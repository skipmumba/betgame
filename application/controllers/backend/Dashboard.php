<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends CI_Controller
{

	public function getToday()
	{
		$day = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('walletcode');
		$this->db->like('wallet_date', $day);
		$this->db->order_by('wallet_date', 'ASC');
		$query = $this->db->get();
		$wallprice = 0;
		foreach($query->result() as $key => $value)
		{
			$wallprice+=$value->wallet_price;
		}

		$this->db->select('*');
		$this->db->from('withdraw');
		$this->db->like('withdraw_time', $day);
		$this->db->order_by('withdraw_time', 'ASC');
		$query = $this->db->get();
		$withdrawprice = 0;
		foreach($query->result() as $key => $value)
		{
			$withdrawprice+=$value->withdraw_price;
		}


		$this->db->select('*');
		$this->db->from('withdraw');
		$this->db->like('withdraw_time', $day);
		$this->db->order_by('withdraw_time', 'ASC');
		$query = $this->db->get();
		$withdrawprice = 0;
		foreach($query->result() as $key => $value)
		{
			$withdrawprice+=$value->withdraw_price;
		}

		$this->db->select('*');
		$this->db->from('matchgame');
		$this->db->where('daycreate >=', $day);
		$this->db->where('winner is NOT NULL', NULL, FALSE);
		$this->db->order_by('daycreate', 'ASC');
		$query = $this->db->get();
		$profitprice = 0;
		foreach($query->result() as $key => $value)
		{
			if($value->winner == 1)
			{
				$odd = $this->game->oddAndpercent($value->team1price,$value->team2price)['oddA'];
				$price = $value->team1price*$odd;
			}
			else 
			{
				$odd = $this->game->oddAndpercent($value->team1price,$value->team2price)['oddB'];
				$price = $value->team2price*$odd;			
			}		
			$profitprice+=$price;
		}
		$membercount = 0;
		$this->db->select('*');
		$this->db->from('member');
		$this->db->where('member_date >=', $day);
		$query = $this->db->get();
		$membercount = $query->num_rows();
		echo json_encode(array('incomes'=>$wallprice,
							'outcomes'=>$withdrawprice,
							'profits'=>$profitprice,
							'members'=>$membercount,
		));
	}

	public function charts($types='income',$month=0)
	{
		$getMonth = $this->month();
		$year = date('Y');
		if($month==0)
		{
			$month = date('n');
		}

		// $startDay = $year.'-'.1.'-'.$month;
		$startDay = "{$year}-{$month}-01";
		$endDay = $year.'-'.$month.'-'.$getMonth[$month]['days'];
		// echo $startDay.'<br>';
		// echo $endDay;
		if($types == 'income')
		{
			$this->db->select('*');
			$this->db->from('walletcode');
			$this->db->where('wallet_date >=', $startDay);
			$this->db->where('wallet_date <=', $endDay);
			$this->db->order_by('wallet_date', 'ASC');
			$query = $this->db->get();
			$ketpMoney = array();
			foreach($query->result() as $key => $value)
			{
				if(array_key_exists(date('j',strtotime($value->wallet_date)),$ketpMoney))
				{
					$ketpMoney[date('j',strtotime($value->wallet_date))] += $value->wallet_price;
				}
				else 
				{
					$ketpMoney[date('j',strtotime($value->wallet_date))] = $value->wallet_price;
				}
			}
		}
		else if($types == 'outcome')
		{
			$this->db->select('*');
			$this->db->from('withdraw');
			$this->db->where('withdraw_time >=', $startDay);
			$this->db->where('withdraw_time <=', $endDay);
			$this->db->order_by('withdraw_time', 'ASC');
			$query = $this->db->get();
			$ketpMoney = array();
			foreach($query->result() as $key => $value)
			{
				if(array_key_exists(date('j',strtotime($value->withdraw_time)),$ketpMoney))
				{
					$ketpMoney[date('j',strtotime($value->withdraw_time))] += $value->withdraw_price;
				}
				else 
				{
					$ketpMoney[date('j',strtotime($value->withdraw_time))] = $value->withdraw_price;
				}
			}
		}
		else 
		{
			$this->db->select('*');
			$this->db->from('matchgame');
			$this->db->where('daycreate >=', $startDay);
			$this->db->where('daycreate <=', $endDay);
			$this->db->where('winner is NOT NULL', NULL, FALSE);
			$this->db->order_by('daycreate', 'ASC');
			$query = $this->db->get();
			$ketpMoney = array();
			foreach($query->result() as $key => $value)
			{
				if(array_key_exists(date('j',strtotime($value->daycreate)),$ketpMoney))
				{
					if($value->winner == 1)
					{
						$odd = $this->game->oddAndpercent($value->team1price,$value->team2price)['oddA'];
						$price = $value->team1price*$odd;
					}
					else 
					{
						$odd = $this->game->oddAndpercent($value->team1price,$value->team2price)['oddB'];
						$price = $value->team2price*$odd;
					}
					$ketpMoney[date('j',strtotime($value->daycreate))] += $price;
				}
				else 
				{
					if($value->winner == 1)
					{
						$odd = $this->game->oddAndpercent($value->team1price,$value->team2price)['oddA'];
						$price = $value->team1price*$odd;
					}
					else 
					{
						$odd = $this->game->oddAndpercent($value->team1price,$value->team2price)['oddB'];
						$price = $value->team2price*$odd;
					}
					$ketpMoney[date('j',strtotime($value->daycreate))] = $price;
				}
			}
		}


		$dayArray = array();
		$priceArray =array();
		$sumall = 0;
		for($i = 1;$i<=$getMonth[$month]['days'];$i++)
		{
			if(array_key_exists($i,$ketpMoney))
			{
				array_push($priceArray,$ketpMoney[$i]);
				$sumall += $ketpMoney[$i];
			}
			else 
			{
				array_push($priceArray,0);
			}
		}
		echo json_encode(array('days'=>$getMonth[$month]['days'],'data'=>$priceArray,'sum'=>$sumall));
	}

	public function profitMonth()
	{
		
	}

	public function month()
	{
		$months = array(
		  '1' => array(
		    'name'   => 'January',
		    'short'  => 'Jan',
		    'number' => 1,
		    'days'  => 31
		  ),
		  '2' => array(
		    'name'   => 'February',
		    'short'  => 'Feb',
		    'number' => 2,
		    'days'   => 28
		  ),
		  '3' => array(
		    'name'   => 'March',
		    'short'  => 'Mar',
		    'number' => 3,
		    'days'   => 31
		  ),
		  '4' => array(
		    'name'   => 'April',
		    'short'  => 'Apr',
		    'number' => 4,
		    'days'   => 30
		  ),
		  '5' => array(
		    'name'   => 'May',
		    'short'  => 'May',
		    'number' => 5,
		    'days'   => 31
		  ),
		  '6' => array(
		    'name'   => 'June',
		    'short'  => 'Jun',
		    'number' => 6,
		    'days'   => 30
		  ),
		  '7' => array(
		    'name'   => 'July',
		    'short'  => 'Jul',
		    'number' => 7,
		    'days'   => 31
		  ),
		  '8' => array(
		    'name'   => 'August',
		    'short'  => 'Aug',
		    'number' => 8,
		    'days'   => 31
		  ),
		  '9' => array(
		    'name'   => 'September',
		    'short'  => 'Sep',
		    'number' => 9,
		    'days'   => 30
		  ),
		  '10' => array(
		    'name'   => 'October',
		    'short'  => 'Oct',
		    'number' => 10,
		    'days'   => 31
		  ),
		  '11' => array(
		    'name'   => 'November',
		    'short'  => 'Nov',
		    'number' => 11,
		    'days'   => 30
		  ),
		  '12' => array(
		    'name'   => 'December',
		    'short'  => 'Dec',
		    'number' => 12,
		    'days'   => 31
		  ),
		);
		return $months;
	}
}