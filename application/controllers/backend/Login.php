<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller{

  	public function __construct()
  	{
    	parent::__construct();
    //Codeigniter : Write Less Do More
  	}

  	public function checklogin()
  	{
  		$data = json_decode(file_get_contents('php://input'),true);
		$email = $data['user'];
		$pass = $data['pass'];
		$this->db->select('*');
		$this->db->from('admin');
		$query = $this->db->get();
		foreach($query->result() as $row)
		{
			if($row->pass == $pass && $row->admin == $email)
			{
				$arr = array('admin'=>'allowed',
							'jwt' => $this->jwtservice->setToken('admin'),
							'status'=>'ok'
				);
				echo json_encode($arr);
			}
			else 
			{
				echo json_encode(array('status'=>'no'));
			}
		}
  	}


}