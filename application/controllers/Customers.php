<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Customers extends REST_Controller{
    function __construct($config = 'rest'){
        parent::__construct($config);
}
//Menampilkan data

    public function index_get() {
 
        $id = $this->get('id');
        if ($id == ''){
            $data = $this->db->get('customers')->result();
        }else{
            $this->db->where('CustomerID', $id);
            $data = $this->db->get('customers')->result();
        }
        $result =["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                  "code"=>200,
                  "message"=>"Response successfully",
                  "data"=>$data
                ];
        header('access-control-allow-mehtods: GET');
        header('access-control-allow-origin: *');
        $this->response($result,200);
    
    }
}


