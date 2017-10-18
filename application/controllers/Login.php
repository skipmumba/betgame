<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller{
	public function __construct()
	{
	   	parent::__construct();
	    //Codeigniter : Write Less Do More
	}
	public function memberLogin()
	{
		$data = json_decode(file_get_contents('php://input'),true);
		$email = $data['email'];
		$pass = $data['pass'];
		$this->db->from('member');
		$this->db->where('member_email',$email);
		$query = $this->db->get();
		$count = $query->num_rows();
		if($count > 0)
		{
			foreach ($query->result() as $row)
			{
				if(password_verify($pass, $row->member_pass))
				{
					$this->db->where('member_code', $row->member_code);
					if($this->db->update('member',array('member_ip'=>$this->ipuser->real_ip())))
					{	
						echo json_encode(array('statusLogin'=>true,'memberCode'=>$row->member_code,'email'=>$row->member_email,
						'price'=>$row->member_price,'token'=>$this->jwtservice->setToken($row->member_code)));
					}
					else 
					{
						echo json_encode(array('statusLogin'=>false));
					}
				}
				else 
				{
					echo json_encode(array('statusLogin'=>false));
				}			    
			}
		}
		else 
		{
			echo json_encode(array('statusLogin'=>false));
		}
	}
}