<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getwallet extends CI_Controller
{
	public function __construct()
	{
		// $this->load->library('session');
		 parent::__construct();
	}
	public function specificSearch($type,$texts)
	{
		if($type == 'email')
		{
			$this->db->select('*');
			$this->db->from('member');
			$this->db->like('member_email', $texts);
			$this->db->join('walletcode', 'member.member_code = walletcode.wallet_usercode');
			$this->db->order_by('walletcode.wallet_id', 'DESC');
			$query = $this->db->get();
			echo json_encode($query->result());
		}
		elseif ($type =='fulldate') 
		{
			$this->db->select('*');
			$this->db->from('member');
			$this->db->join('walletcode', 'member.member_code = walletcode.wallet_usercode');
			$this->db->like('walletcode.wallet_date', $texts);
			$this->db->order_by('walletcode.wallet_id', 'DESC');
			$query = $this->db->get();
			echo json_encode($query->result());
		}
		else
		{
			$this->db->select('*');
			$this->db->from('member');
			$this->db->join('walletcode', 'member.member_code = walletcode.wallet_usercode');
			$this->db->like('walletcode.wallet_phone', $texts);
			$this->db->order_by('walletcode.wallet_id', 'DESC');
			$query = $this->db->get();
			echo json_encode($query->result());
		}
	}
	public function listwallet()
	{
		$this->db->select('*');
		$this->db->from('walletcode');
		$this->db->order_by('wallet_id', 'DESC');
		$this->db->join('member', 'member.member_code = walletcode.wallet_usercode');
		$query = $this->db->get();
		echo json_encode($query->result());
	}
}