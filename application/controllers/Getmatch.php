<?php
class getmatch extends CI_Controller 
{
	public function getlistMatch($d=0,$m=0,$y=0,$catInput=0)
	{
		if($d==0 and $m==0 and $y==0)
		{
			$dateNow = $this->getDate();
		}
		else 
		{
			$dateNow['day']= $d ;
			$dateNow['month']= $m;
			$dateNow['year']= $y;
		}
		
		$this->db->from('catgame');
		$this->db->order_by("order", "asc");
		if($catInput != 0)
		{

			$this->db->where('cat_id',$catInput);
		}
		$query = $this->db->get(); 
		$matchArray = array();
		$indexArray = 0;
		$notNullCat = false;
		foreach($query->result() as $row)
		{
			$notNullCat = false;
			$catName = $row->cat_name;
			$catId = $row->cat_id;
			$catOrder = $row->order;		
			$catImage = $row->cat_image;		
			$arrayDate = array($dateNow['day'],$dateNow['day']+1,$dateNow['day']+2,$dateNow['day']+3,$dateNow['day']+4,$dateNow['day']+5);
			$this->db->from('matchgame');
			$this->db->where_in('day',$arrayDate);
			$this->db->where('month',$dateNow['month']);
			$this->db->where('year',$dateNow['year']);
			$this->db->where('cat_id',$catId);
			$queryMatch = $this->db->get();
			$matchIn = 0;
			foreach($queryMatch->result() as $matchData)
			{
				if($query->num_rows() >= 0)
				{
					$notNullCat = true;
					$matchArray[$indexArray]['catName'] = $catName;
					$matchArray[$indexArray]['catImage'] = $catImage;
					$matchArray[$indexArray]['catID'] = $catId;
					$matchArray[$indexArray]['catOrder'] = $catOrder;		

					$matchArray[$indexArray]['matchDetail'][$matchIn]['matchID'] = $matchData->match_id;
					$matchArray[$indexArray]['matchDetail'][$matchIn]['team1'] = $matchData->team_1;
					$matchArray[$indexArray]['matchDetail'][$matchIn]['team2'] = $matchData->team_2;
					$matchArray[$indexArray]['matchDetail'][$matchIn]['pic1'] = $matchData->team1pic;
					$matchArray[$indexArray]['matchDetail'][$matchIn]['pic2'] = $matchData->team2pic;
					$matchArray[$indexArray]['matchDetail'][$matchIn]['day'] = $matchData->day;
					$matchArray[$indexArray]['matchDetail'][$matchIn]['month'] = $matchData->month;
					$matchArray[$indexArray]['matchDetail'][$matchIn]['year'] = $matchData->year;
					$matchArray[$indexArray]['matchDetail'][$matchIn]['price1'] = $matchData->team1price;
					$matchArray[$indexArray]['matchDetail'][$matchIn]['price2'] = $matchData->team2price;
					$matchArray[$indexArray]['matchDetail'][$matchIn]['winner'] = $matchData->winner;
					$matchArray[$indexArray]['matchDetail'][$matchIn]['time'] = $matchData->time;
					$matchArray[$indexArray]['matchDetail'][$matchIn]['statusgame'] = $this->game->statusGame($matchData->statusgame,$matchData->day,
							$matchData->month,$matchData->year,$matchData->time);
					

					
					$plusSum = $matchData->team1price+$matchData->team2price;
					
					$percentAndOdd = $this->game->oddAndpercent($matchData->team1price,$matchData->team2price);//find percents and odds

					$matchArray[$indexArray]['matchDetail'][$matchIn]['percentA'] = $percentAndOdd['percentA'];
					$matchArray[$indexArray]['matchDetail'][$matchIn]['percentB'] = $percentAndOdd['percentB'];
					$matchArray[$indexArray]['matchDetail'][$matchIn]['oddA'] =  $percentAndOdd['oddA'];
					$matchArray[$indexArray]['matchDetail'][$matchIn]['oddB'] =  $percentAndOdd['oddB'];

				}
				$matchIn++;
			}	
			if($notNullCat)
			{
				$indexArray++;
			}
		}
		// echo '<pre>';
		echo json_encode($matchArray);
		// print_r($matchArray);
	}



	public function getDate()
	{
		$json = file_get_contents('https://script.google.com/macros/s/AKfycbyd5AcbAnWi2Yn0xhFRbyzS4qMq1VucMVgVvhul5XqS9HkAyJY/exec?tz=Asia/Bangkok');
		$obj = json_decode($json);
		$date = array('day'=>$obj->day,'month'=>$obj->month,'year'=>$obj->year,'hour'=>$obj->hours,'minute'=>$obj->minutes);
		return $date;
	}

	public function daySelected()
	{	
		// if  next year this function will be bugs
		// i had to create new function specific for 12-1 month
		$montharray = $this->month();
		$dateNow = $this->getDate();
		$day = $dateNow['day'];
		$month = $dateNow['month'];
		$year = $dateNow['year'];
		$dayOfmonth = $montharray[$month]['days'];
		$startMoreday = 1;
		$tabArray = array();
		$arrayStart = 0;
		for($i=1;$i<=5;$i++)
		{
			switch($i)
			{
				case 1:
					if($day == 2)
					{
						$dayCal = $montharray[$month-1]['days'];
						$monthCal = $montharray[$month-1]['number'];
						
					}
					else if($day == 1)
					{
						$dayCal = $montharray[$month-1]['days'];
						$monthCal = $montharray[$month-1]['number'];
						$dayCal -= 1;
					}
					else 
					{
						$monthCal = $month;
						$dayCal = $day - 2;
					}		
					$tabArray[$arrayStart]['day'] = $dayCal;
					$tabArray[$arrayStart]['month'] =$monthCal;
					$tabArray[$arrayStart]['year'] = $year;
					$arrayStart++;
					break;
				case 2:
					if(($day - 1) > 0)
					{
						$dayCal = $day - 1;
						$monthCal = $month;
					}
					else 
					{

						$monthCal = $montharray[$month-1]['number'];
						if($dayCal != $montharray[$month-1]['days'])
							$dayCal+=1;	
					}
					$tabArray[$arrayStart]['day'] = $dayCal;
					$tabArray[$arrayStart]['month'] = $monthCal;
					$tabArray[$arrayStart]['year'] = $year;
					$arrayStart++;
					break;
				case 3:
					$tabArray[$arrayStart]['day'] = $day;
					$tabArray[$arrayStart]['month'] = $month;
					$tabArray[$arrayStart]['year'] = $year;
					$arrayStart++;
					break;
				case 4:
					
					if(($day + 1) <= $dayOfmonth)
					{
						$dayCal = $day + 1;
						$monthCal = $month;
					}
					else 
					{
						$dayCal = $startMoreday;
						$monthCal = $month+1;
						$startMoreday++;
					}
					$tabArray[$arrayStart]['day'] = $dayCal;
					$tabArray[$arrayStart]['month'] = $monthCal;
					$tabArray[$arrayStart]['year'] = $year;
					$arrayStart++;
					break;
				case 5:				
					if(($day + 2) <= $dayOfmonth)
					{
						$monthCal = $month;
						$dayCal = $day + 2;
					}
					else 
					{
						$monthCal = $month+1;
						$dayCal = $startMoreday;
					}
					$tabArray[$arrayStart]['day'] = $dayCal;
					$tabArray[$arrayStart]['month'] = $monthCal;
					$tabArray[$arrayStart]['year'] = $year;
					$arrayStart++;
					break;
			}
			
		}
		echo json_encode($tabArray);
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



