<?php
class sendbet extends CI_Controller 
{
	public function __construct()
 	{
 		parent::__construct();
 	}
	public function index()
	{
		$headers = apache_request_headers();
		if($this->jwtservice->getToken())
		{
			$data = json_decode(file_get_contents('php://input'),true);
			$sumMoney = 0;
			$info = array();
			$gotmoneyInfo = array();
			if(!is_numeric($data['codeuser']))
			{
				echo json_encode(array('betsuc'=>'pls dont'));
				exit;
			}
			foreach($data['money'] as $key => $value)
			{
				if(is_numeric($value))// money
				{
					$sumMoney+=$value;
				}
				else 
				{
					echo json_encode(array('betsuc'=>'pls dont'));
					exit;
				}
			}

			if(!$this->balanceMoney($sumMoney,$data['codeuser']))
			{
				echo json_encode(array('betsuc'=>'notenough'));
				exit;
			}

			foreach($data['matchinfo'] as $key => $value)
			{
				$info[$value['id']]['matchid'] = $value['matchId'];
				$querytime = $this->db->get_where('matchgame', array('match_id' => $value['matchId']));
				foreach($querytime->result() as $checks)
				{
					$checkTimeMatch = $this->game->statusGame($checks->day,$checks->month,$checks->year,$checks->time);
					if($checkTimeMatch != 'ยังไม่แข่ง')
					{
						echo json_encode(array('betsuc'=>'timeout'));
						exit;
					}
				}
				$info[$value['id']]['team'] = $value['teamnum'];
				$info[$value['id']]['codeuser'] = $data['codeuser'];
			}
			$checkError = array();
			$haveError = false;

			foreach($data['money'] as $key => $value)
			{
				$putdata = array(
					'userbet_matchid' => $info[$key]['matchid'],
					'userbet_price' => $value,
					'userbet_usercode' => $info[$key]['codeuser'],
					'userbet_team' => $info[$key]['team']
				);		
				if($this->db->insert('userbet', $putdata))
				{
					$checkError[] = true;
					$teaminloopPrice = "team{$info[$key]['team']}price";
					$teaminloopPeople = "team{$info[$key]['team']}people";
					$this->db->set($teaminloopPrice, "{$teaminloopPrice}+{$value}", FALSE);
					$this->db->set($teaminloopPeople, "{$teaminloopPeople}+1", FALSE);
					$this->db->where('match_id', $info[$key]['matchid']);
					if($this->db->update('matchgame'))
					{
						$checkError[] = true;
					}
					else 
					{
						$checkError[] = false;
					}
				}
				else 
				{
					$checkError[] = false;
				}	
			}

			foreach($checkError as $value)
			{
				if($value == false)
				{
					$haveError = true;
				}
			}
			if(!$haveError)
			{
				if($sumMoney != 0)
				{
					$this->db->set('member_price', "member_price-{$sumMoney}", FALSE);
					$this->db->where('member_code', $data['codeuser']);
					if($this->db->update('member'))
					{
						echo json_encode(array('betsuc'=>'ok','betmoney'=>$sumMoney));
					}
					else 
					{
						echo json_encode(array('betsuc'=>'no'));
					}
				}
			else 
			{		
				echo json_encode(array('betsuc'=>'no'));
			}
			}
			else
			{
				echo json_encode(array('betsuc'=>'no'));
			}			
		}
		else 
		{
			echo json_encode(array('betsuc'=>'expire'));
		}

			
	}
	public function balanceMoney($money,$code)
	{
		$this->db->from('member');
		$this->db->where('member_code',$code);
		$query = $this->db->get();
		foreach ($query->result() as $row)
		{
			if($row->member_price >= $money)
			{
				return true;
			}
			else 
			{
				return false;
			}
		}
	}
}