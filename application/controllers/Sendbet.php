<?php
class sendbet extends CI_Controller 
{
	public function __construct()
 	{
 		parent::__construct();
 	}
	public function index()
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