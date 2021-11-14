<?php
defined('BASEPATH') OR exit ('no direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Tipe extends REST_Controller {
    function __construct($config = 'rest'){
        parent::__construct($config);

    }

    //menampilkan data
    public function index_get() {

        $id = $this->get('id');
        $tipe=[];
        if ($id == ''){
            $data = $this->db->get('tipe')->result();
            foreach($data as $row=>$key):
                    $tipe[]=["id"=>$key->id,
                              "tipe"=>$key->tipe,
                             "_links"=>[(object)["href"=>"mobil/{$key->id}",
                                                    "rel"=>"mobil",
                                                    "type"=>"GET"]],
                
                                       
                                         ];

            endforeach;   
        }else{
            $this->db->where('id', $id);
            $data = $this->db->get('tipe')->result();
        }
        $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                  "code"=>200,
                  "message"=>"Response successfully",
                  "data"=>$tipe];
        header('access-control-allow-mehtods: GET');
        header('access-control-allow-origin: *');
            $this->response($result, 200);
        
    }

}