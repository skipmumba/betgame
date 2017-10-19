<?php
class userdeposit extends CI_Controller 
{
	public function __construct()
 	{
 		parent::__construct();
 	// 	if(!$this->jwtservice->getToken())
		// {
		// 	echo json_encode(array('jwt'=>'notoken'));
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

 	public function setting($id,$phone)
 	{
 		$query = $this->db->get_where('setting', array('setting_usercode' => $id));
 		foreach($query->result() as $key => $value)
 		{
 			if(is_null($value->setting_phone))
 			{
 				$this->db->where('setting_usercode', $id);
				if($this->db->update('setting',array('setting_phone'=>$phone)))
				{
 					echo json_encode(array('status'=>'ok'));
				}
				else 
				{
					echo json_encode(array('status'=>'cant'));				
				}
 			}
 			else 
 			{
 				echo json_encode(array('status'=>'cant'));
 			}
 		}
 	}

 	public function listbet($id)
 	{
 		$this->db->select('*');
		$this->db->from('userbet');
		$this->db->join('matchgame', 'matchgame.match_id = userbet.userbet_matchid');
		$this->db->where('userbet_usercode','1910174791');
		$query = $this->db->get();
		echo '<pre>';
		print_r($query->result());
 	}


 }