<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class pencipta extends REST_Controller {
	
	function __construct($config = 'rest') {
		parent::__Construct($config);
	}
	
	//Menampilkan data
	public function index_get() {
		
		$id = $this->get('id');
		if ($id == '') {
			$data = $this->db->get('pencipta')->result();
		} else {
			$this->db->where('id_pencipta', $id);
			$data = $this->db->get('pencipta')->result();
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
        'id_pencipta'  => $this->post('id_pencipta'),
        'nama_pencipta' => $this->post('nama_pencipta'),
        'negara' => $this->post('negara'));
    $insert = $this->db->insert('pencipta', $data);
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
            'nama_pencipta' => $this->put('nama_pencipta'),
            'negara' => $this->put('negara'));
       // echo "<pre>"; print_r($data); die();
        $this->db->where('id_pencipta', $id);
        $update = $this->db->update('pencipta', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
     }

    //Menghapus data pencipta
    public function index_delete() {
        $id = $this->delete('id'); // ini yang ditulis pada key di postman ya...., bukan customerID
        $this->db->where('id_pencipta', $id);
        $delete = $this->db->delete('pencipta');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
  
}
?>