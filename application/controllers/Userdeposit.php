<?php
class userdeposit extends CI_Controller 
{
	public function __construct()
 	{
 		parent::__construct();
 	// 	if($this->jwtservice->getToken())
		// {
		// 	exit;
		// }
 	}
 	public function listDeposit($id,$start)
 	{
 		$perpage = 10;
 		if($start<=1)
		{
			$start = 0;
		}
		else 
		{
			$start = ($start * $perpage) - $perpage + 1 ;
		}
 		// $query = $this->db->get_where('walletcode', array('wallet_usercode' => $id), $perpage, $start);
 		$query = $this->db->get_where('walletcode', array('wallet_usercode' => $id));
 		echo json_encode($query->result());
 		
 	}
 	public function listWithdraw($id)
 	{
 		$query = $this->db->get_where('withdraw', array('withdraw_usercode' => $id));
 		echo json_encode($query->result());
 	}
 }