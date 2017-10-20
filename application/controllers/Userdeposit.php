<?php
class userdeposit extends CI_Controller 
{
	public function __construct()
 	{
 		parent::__construct();
 		if(!$this->jwtservice->getToken())
		{
			echo json_encode(array('jwt'=>'notoken'));
			exit;
		}
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
 		$query = $this->db->get_where('walletcode', array('wallet_usercode' => $id));
 		echo json_encode($query->result());
 		
 	}
 	public function listWithdraw($id)
 	{
 		$this->db->order_by("withdraw_id","desc");
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
 	public function outWithdraw($id,$price)
 	{
 		$query = $this->db->get_where('member', array('member_code' => $id));
 		foreach($query->result() as $key => $value)
 		{
 			if($value->member_price > $price)
 			{
		 		if($price >= 200)
		 		{	
		 			$this->db->set('member_price', "member_price-{$price}", FALSE);
					$this->db->where('member_code', $id);
					if($this->db->update('member'))
					{
				 		$data = array(
						        'withdraw_usercode' => $id,
						        'withdraw_price' => $price,
						);
						if($this->db->insert('withdraw', $data))
						{
							echo json_encode(array('out'=>'ok'));
						}
						else 
						{
							echo json_encode(array('out'=>'no'));
						}					
					}
					else 
					{
						echo json_encode(array('out'=>'no'));
					}	
		 		}
		 		else 
		 		{
		 			echo json_encode(array('out'=>'no'));
		 		}			
 			}
 			else 
 			{
 				echo json_encode(array('notenough'=>'yes'));
 			}
 		}
 	}
 	public function listbet($id)
 	{
 		$this->db->select('*');
		$this->db->from('userbet');
		$this->db->order_by("userbet_matchid","desc");
		$this->db->join('matchgame', 'matchgame.match_id = userbet.userbet_matchid');
		$this->db->where('userbet_usercode',$id);
		$query = $this->db->get();
		$betData = array();
		$start = 0;
		foreach($query->result() as $key => $value)
		{
			$betData[$start]['betprice'] = $value->userbet_price;
			$percentAndOdd = $this->game->oddAndpercent($value->team1price,$value->team2price);
			if($value->userbet_team == 1)
			{
				$betData[$start]['betteam'] = $value->team_1;
				$betData[$start]['odd'] = $percentAndOdd['oddA'];
			}
			else
			{ 
				$betData[$start]['betteam'] = $value->team_2;
				$betData[$start]['odd'] = $percentAndOdd['oddB'];
			}
			$betData[$start]['time'] = $value->userbet_time;
			$betData[$start]['vsteam'] = $value->team_1.' vs '.$value->team_2;
			$betData[$start]['statusgame'] = $this->game->statusGame($value->day,$value->month,$value->year,$value->time,$value->statusgame);
					
			$betData[$start]['guessMoney'] = $value->userbet_price*$betData[$start]['odd'];
			$betData[$start]['cat'] = $value->cat_name;
			if(!is_null($value->winner))
			{
				if($value->winner == 1)
				{
					$betData[$start]['resultMatch'] = $value->team_1;
				}
				else
				{
					$betData[$start]['resultMatch'] = $value->team_2;
				}
				$betData[$start]['moneystatus'] = 'เรียบร้อย';
			}
			else 
			{
				$betData[$start]['resultMatch'] = ' - ';
				$betData[$start]['moneystatus'] = 'ยัง';
			}
			$start++;
		}
		echo json_encode($betData);
 	}


 }