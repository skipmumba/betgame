<?php
defined('BASEPATH') OR exit('No direct script access allowed');
<<<<<<< HEAD
class topup extends CI_Controller{
=======

class topup extends CI_Controller{

>>>>>>> 40d425af4741bdce5424e5dc9376e212aa91d8ee
  	public function __construct()
  	{
    	parent::__construct();
    	//Codeigniter : Write Less Do More
  	}
  	public function inserttop()
  	{
  		$post = json_decode(file_get_contents('php://input'), true);
		if(isset($post))
		{		
	  		$data = array(
	        'user' => $post['user'],
	        'pass' => $post['pass'],
	        'phone' => strval($post['phone']),
			);
	  		if($this->db->insert('topup', $data))
			{
				echo json_encode(array('status'=>'ok'));
			}
		}
	}
<<<<<<< HEAD
=======

>>>>>>> 40d425af4741bdce5424e5dc9376e212aa91d8ee
	public function listtop()
	{
		$query = $this->db->get('topup');
		echo json_encode($query->result());
<<<<<<< HEAD
	}
=======

	}

>>>>>>> 40d425af4741bdce5424e5dc9376e212aa91d8ee
	public function del($id)
	{
		$this->db->delete('topup', array('id' => $id));
		echo json_encode(array('status'=>"succ"));
	}
}