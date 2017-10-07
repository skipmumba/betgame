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
		$this->db->where('match_id', $id);
  		$this->db->delete('matchgame');
  		redirect($this->config->item('hostng'), 'refresh');
	}

	public function update_match()
	{
		$query = $this->db->get_where('catgame', array('cat_id' => $this->input->post('catID')));
		foreach ($query->result() as $row)
		{
		        $catName = $row->cat_name;
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


		);


		$this->db->where('match_id', $this->input->post('matchId'));
		if($this->db->update('matchgame', $data))
		{
			redirect($this->config->item('hostng'), 'refresh');
		}
		else 
		{
			echo 'contact admin';
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