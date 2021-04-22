<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class lagu extends REST_Controller {
	
	function __construct($config = 'rest') {
		parent::__Construct($config);
	}
	
	//Menampilkan data
	public function index_get() {
		
		$id = $this->get('id');
		if ($id == '') {
			$data = $this->db->get('lagu')->result();
		} else {
			$this->db->where('id_lagu', $id);
			$data = $this->db->get('lagu')->result();
		}
		$result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
				   "code"=>200,
				   "message"=>"Response successfully",
				   "data"=>$data];
		$this->response($result, 200);
	    }


   //Menambah data 
   public function index_post() {
    $data = array(
        'id_lagu'  => $this->post('id_lagu'),
        'judul_lagu' => $this->post('judul_lagu'),
        'id_pencipta' => $this->post('id_pencipta'));
    $insert = $this->db->insert('lagu', $data);
    if ($insert) {
        //$this->response($data, 200);
        $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
            "Code"=>201,
            "message"=>"Data has successfully added",
            "data"=>$data];
        $this->response($result, 201);
    } else {
        $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
            "code"=>502,
            "message"=>"Failed adding data",
            "data"=>null];
        $this->response($result, 502);  
        }
    }

    //Memperbarui data yang telah ada
     public function index_put() { 
        $id = $this->put('id');        
        $data = array (                       
            'judul_lagu' => $this->put('judul_lagu'),
            'id_pencipta' => $this->put('id_pencipta'));
       // echo "<pre>"; print_r($data); die();
        $this->db->where('id_lagu', $id);
        $update = $this->db->update('lagu', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
     }
    //Menghapus data lagu
    public function index_delete() {
        $id = $this->delete('id'); // ini yang ditulis pada key di postman ya...., bukan customerID
        $this->db->where('id_lagu', $id);
        $delete = $this->db->delete('lagu');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
  
}
?>