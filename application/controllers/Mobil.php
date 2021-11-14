<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Mobil extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
    }

    //Menampilkan data Mobil
    public function index_get() {
        $id = $this->get('id');
        if ($id == '') {
            $data = $this->db->get('mobil')->result();
        } else {
            $this->db->where('id', $id);
            $data = $this->db->get('mobil')->result();
        }
        $result =["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                  "code"=>200,
                  "message"=>"Response successfully",
                  "data"=>$data];
        $this->response($result, 200);
    }

   // menambah data (post)
    public function index_post() {
        $data = array(
                
                'nama_mobil'   => $this->post('nama_mobil'),
                'harga'  => $this->post('harga'),
                'id_tipe'  => $this->post('id_tipe'),
                'stok'   => $this->post('stok'));
               
        $insert = $this->db->insert('mobil', $data);
        if ($insert) {
            $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                "code"=>201,
                "message"=>"Data has successfully added",
                "data"=>$data];
            $this->response($result, 201);
        }else {
            $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                "code"=>502,
                "message"=>"Failed adding data",
                "data"=>null];
        $this->response($result, 502);
        }
    }
    public function index_put() {
        $id = $this->put('id');
        $data = array(
                'id'    => $this->put('id'),
                'nama_mobil'   => $this->put('nama_mobil'),
                'harga'  => $this->put('harga'),
                'id_tipe'  => $this->put('id_tipe'),
                'stok'   => $this->put('stok'));
        $this->db->where('id', $id);
        $update = $this->db->update('mobil', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    
//Menghapus Data
    public function index_delete() {
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('mobil');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>