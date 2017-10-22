<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class withdraw extends CI_Controller
{
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
		$this->db->where('withdraw_id', $status);
		if($this->db->update('withdraw'))
		{
			//ถึงนี่
		}
	}
}