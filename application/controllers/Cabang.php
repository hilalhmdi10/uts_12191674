<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Cabang extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->driver('cache', array('adapter' => 'apc','backup' => 'file'));
    }

    //menampilkan data
    public function index_get() {

        $id = $this->get('id');
        $cabang=[];
        if ($id == '') {
            $data = $this->db->get('cabang')->result();
            foreach ($data as $row=>$key):
                $cabang[]=["id"=>$key->id,
                            "tahun"=>$key->tahun,
                            "wilayah"=>$key->wilayah,
                            "jumlah"=>$key->jumlah,
                            "_links"=>[(object)["href"=>"mobil/{$data[0]->id}",
                                            "rel"=>"mobil",
                                            "type"=>"GET"]]
                            ];
            endforeach;
                $result = [ "took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                            "code"=>200,
					        "message"=>"Response successfully",
					        "data"=>$cabang
                    ];
                $this->response($result, 200);
            } else {
			$this->db->where('id', $id);
			$data = $this->db->get('cabang')->result();
			$cabang=[ "id" => $data[0]->id,
                         "tahun"=>$data[0]->tahun,
						 "wilayah"=>$data[0]->wilayah,
						 "jumlah"=>$data[0]->jumlah,
							        "_links"=>[(object)["href"=>"mobil/{$data[0]->id}",
										"rel"=>"mobil",
										"type"=>"GET"]]
					];   
            $etag = hash('sha256', $data[0]->LastUpdate);
            $this->cache->save($etag, $cabang, 300);
            $this->output->set_header('ETag:' .$etag);
            $this->output->set_header('Cache-Control: must-revalidate');
            if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == $etag){
                $this->output->set_header('HTTP/1.1 304 Not Modified');
            }else{
                $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                        "code"=>200,
                        "message"=>"Response successfully",
                        "data"=>$cabang];
                $this->response($result, 200);
            } 
        }
    }
}