<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class managematch extends CI_Controller{
	public function __construct()
	{
	    parent::__construct();
	    //Codeigniter : Write Less Do More
	}

	public function del_match($id)
	{
		$arraybet = 0;
		$userbet = array();
		$betid = array();
		$people = 0;
		$refund = 0;
		$query = $this->db->get_where('userbet', array('userbet_matchid' => $id));
		foreach ($query->result() as $row)
		{
			   $betid[] = $row->userbet_id;
		        $userbet[$arraybet]['price'] = $row->userbet_price;
		        $userbet[$arraybet]['team'] = $row->userbet_team;
		        $userbet[$arraybet]['matchid'] = $row->userbet_matchid;
		        $userbet[$arraybet]['usercode'] = $row->userbet_usercode;
		        $userbet[$arraybet]['betid'] = $row->userbet_id;
		        $arraybet ++;
		}

		foreach($userbet as $key => $value)
		{
			$people+=1;
			$refund+=$value['price'];
			$this->db->set('member_price', "member_price+{$value['price']}", FALSE);
			$this->db->where('member_code', $value['usercode']);
			if(!$this->db->update('member')) //if cannot refund money
			{
				$goterror = array(
				        'userbet_error' => 'got error',
				);
				$this->db->update('userbet', $goterror, array('userbet_id' => $value['betid'])); //isert got error in bet id
			}
			else 
			{
				$this->db->delete('userbet', array('userbet_id' => $value['betid']));
			}
		}

		$this->db->delete('matchgame', array('match_id' => $id));
  		redirect($this->config->item('hostng'), 'refresh');
	}
	public function update_match()
	{
		$query = $this->db->get_where('catgame', array('cat_id' => $this->input->post('catID')));
		foreach ($query->result() as $row)
		{
		        $catName = $row->cat_name;
		}
		if($this->input->post('winner') != 0)
		{
			$winner = $this->input->post('winner');
			$statusgame = 1;
		}
		else 
		{
			$winner = null;
			$statusgame = 0;
		}
		$data = array(
	        'team_1' => $this->input->post('team1'),
	        'team_2' => $this->input->post('team2'),
	        'team1pic' => $this->input->post('picTeam1'),
	        'cat_id' => $this->input->post('catID'),
	        'cat_name' => $catName,
	        'day' => $this->input->post('day'),
	        'month' => $this->input->post('month'),
	        'year' => $this->input->post('year'),
	        'time' => $this->input->post('time'),
	        'winner' => $winner,
	        'statusgame' => $statusgame,
		);


		$this->db->where('match_id', $this->input->post('matchId'));
		if($this->db->update('matchgame', $data))
		{
			if(!is_null($winner))
			{
				$this->updateMoneyWin($this->input->post('matchId'),$winner);
			}
			redirect($this->config->item('hostng'), 'refresh');
		}
		else 
		{
			echo 'contact admin';
		}
	}

	public function updateMoneyWin($matchid,$winner)
	{
		$this->db->select('*');
		$this->db->from('userbet');
		$this->db->join('matchgame', 'matchgame.match_id = userbet.userbet_matchid');
		$this->db->where('userbet_matchid',$matchid);
		$query = $this->db->get();
		foreach($query->result() as $key => $value)
		{
			if($value->userbet_team == $winner)
			{
				$usercode = $value->userbet_usercode;
				if($value->userbet_team == 1)
				{
					$newPrice  = $value->userbet_price * $this->game->oddAndpercent($value->team1price,$value->team2price)['oddA'];
				}
				else 
				{
					$newPrice = $value->userbet_price * $this->game->oddAndpercent($value->team1price,$value->team2price)['oddB'];
				}
				$this->db->set('member_price', "member_price+{$newPrice}", FALSE);
				$this->db->where('member_code', $usercode);
				if($this->db->update('member'))
				{
					$this->db->set('winner', $value->userbet_team, FALSE);
					$this->db->where('match_id', $value->userbet_matchid);
					if($this->db->update('matchgame'))
					{
						// redirect($this->config->item('hostng'), 'refresh');
					}
				}
			}
		}

	}

	public function handleMatch($id)
	{
		$matchDetail = array();
		$query = $this->db->get_where('matchgame', array('match_id' => $id));
		foreach ($query->result() as $row)
		{
		       $matchDetail['matchID'] = $row->match_id;
		       $matchDetail['catID'] = $row->cat_id;
		       $matchDetail['catName'] = $row->cat_name;
		       $matchDetail['name1'] = $row->team_1;
		       $matchDetail['name2'] = $row->team_2;
		       $matchDetail['pic1'] = $row->team1pic;
		       $matchDetail['pic2'] = $row->team2pic;
		       $matchDetail['day'] = $row->day;
		       $matchDetail['month'] = $row->month;
		       $matchDetail['year'] = $row->year;
		       $matchDetail['time'] = $row->time;
		       $matchDetail['people1'] = $row->team1people;
		       $matchDetail['people2'] = $row->team2people;
		       $matchDetail['sumpeople'] = $row->team1people+$row->team2people;
		       $matchDetail['price1'] = $row->team1price;
		       $matchDetail['price2'] = $row->team2price;
		       $matchDetail['winner'] = $row->winner;
		       $matchDetail['statusgame'] = $this->game->statusGame($row->day,$row->month,$row->year,$row->time,$row->statusgame);
		       if($row->team1price == 1 && $row->team2price ==1)
		       {
		       	$matchDetail['sumprice'] = 0;
		       }
		       else 
		       {
		       	$matchDetail['sumprice'] = $row->team1price+$row->team2price;
		       }
		       $matchDetail['winner'] = $row->winner;
		       $matchDetail['cat'] = $row->cat_id;
		       $matchDetail['catName'] = $row->cat_name;
		       $matchDetail['status'] = $row->statusgame;
		}
		echo json_encode($matchDetail);
	}

}