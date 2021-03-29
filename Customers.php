<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Customers extends REST_Controller {
	
	function __construct($config = 'rest') {
		parent::__Construct($config);
	}
	
	//Menampilkan data
	public function index_get() {
		
		$id = $this->get('id');
		if ($id == '') {
			$data = $this->db->get('customers')->result();
		} else {
			$this->db->where('CustomerID', $id);
			$data = $this->db->get('Customers')->result();
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
        'CustomerID'  => $this->post('CustomerID'),
        'CompanyName' => $this->post('CompanyName'),
        'ContactTitle' => $this->post('ContactTitle'),
        'Address'  => $this->post('Address'),
        'City'  => $this->post('City'),
        'Region'  => $this->post('Region'),
        'PostalCode'  => $this->post('PostalCode'),
        'Country'  => $this->post('Country'),
        'Phone'  => $this->post('Phone'),
        'Fax'  => $this->post('Fax'));
    $insert = $this->db->insert('customers', $data);
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
            'CustomerID'  => $this->post('CustomerID'),
            'CompanyName' => $this->post('CompanyName'),
            'ContactTitle' => $this->post('ContactTitle'),
            'Address'  => $this->post('Address'),
            'City'  => $this->post('City'),
            'Region'  => $this->post('Region'),
            'PostalCode'  => $this->post('PostalCode'),
            'Country'  => $this->post('Country'),
            'Phone'  => $this->post('Phone'),
            'Fax'  => $this->post('Fax'));
        $this->db->where('CustomerID', $id);
        $update = $this->db->db->update('customers', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
     }

    //Menghapus data customers
    public function index_delete() {
        $id = $this->delete('id');
        $this->db->where('CustomerID', $id);
        $delete = $this->db->delete('customers');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
  
}
?>