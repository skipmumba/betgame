<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class withdraw extends CI_Controller
{
	public function __construct()
	{
		// $this->load->library('session');
		 parent::__construct();
	}
	public function findEamil($type='',$search='')
	{
		if($type == 'email')
		{

			$this->db->select('*');
			$this->db->from('member');
			$this->db->like('member_email', $search);
			$this->db->join('withdraw', 'member.member_code = withdraw.withdraw_usercode');
			$this->db->order_by('withdraw_id', 'DESC');
			$query = $this->db->get();
			echo json_encode($query->result());
		}
		else if($type == 'fulldate')
		{
			$this->db->select('*');
			$this->db->from('withdraw');
			$this->db->like('withdraw_time', $search);
			$this->db->order_by('withdraw_id', 'DESC');
			$this->db->join('member', 'member.member_code = withdraw.withdraw_usercode');
			$query = $this->db->get();
			echo json_encode($query->result());
		}
		else 
		{
			echo json_encode(array('null'=>0));
		}
	}
	public function userWithdraw($id='')
	{
		$this->db->select('*');
		$this->db->from('withdraw');
		$this->db->order_by('withdraw_id', 'DESC');
		$this->db->join('member', 'member.member_code = withdraw.withdraw_usercode');
		if($id != '')
		{

			$this->db->where('withdraw_usercode', $id);
			$query = $this->db->get();
		}
		else 
		{
			$query = $this->db->get();
		}
		echo json_encode($query->result());
	}
	public function allowstatus($id,$status)
	{
		$this->db->set('withdraw_status', $status, FALSE);
		$this->db->where('withdraw_id', $id);
		if($this->db->update('withdraw'))
		{
			echo json_encode(array($id=>$status));
		}
	}
}