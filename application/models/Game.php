<?php
class game extends CI_Model {
 	public function __construct()
 	{
 		parent::__construct();
 	}




 	function statusGame($d,$m,$y,$time='00:00',$gamestatus=0)
	{
		if($gamestatus == 0)
		{
			$checkMatch = false;
			$timeNow = $this->getDate();
			if($y == $timeNow['year'])
			{
				if($m == $timeNow['month'])
				{
					if($d == $timeNow['day'])
					{
						$checkMatch = true;
					}
				}
			}		
			if($checkMatch)
			{	
				if($timeNow['minute'] < 10)
				{
					$timeNow['minute'] = '0'.$timeNow['minute'];
				}
				$hourMin =  explode(':', $time);
				$hourMinNow = $timeNow['hour'].$timeNow['minute'];
				$hourInput = $hourMin[0].$hourMin[1];			
					if($hourMinNow >= $hourInput)
					{

						return 'แข่งแล้ว';
					}
					else 
					{
						return 'ยังไม่แข่ง';
					}
			}
			else 
			{
				if($timeNow['month'] == $m)
				{
					if($timeNow['day'] > $d)
					{
						return 'แข่งแล้ว';
					}
					else 
					{
						return 'ยังไม่แข่ง';
					}
				}
				else 
				{
					if($timeNow['month'] > $m)
					{
						return 'แข่งแล้ว';
					}
					else 
					{
						return 'ยังไม่แข่ง';
					}
				}
			}
		}
		else 
		{
			return 'แข่งจบแล้ว';
		}
			
	}

	public function oddAndpercent($price1,$price2,$admin = 0)
	{
		$calpercent = $this->findPercent($price1,$price2,$admin);
		if($price1 == 1 && $price2 == 1)
		{
						
			$percentA = 0;
			$percentB = 0;	
		}
		else 
		{
			$percentA = $calpercent[0];
			$percentB = $calpercent[1];					
		}
		$calOdds=$this->findOdds($percentA,$percentB,$admin);
		$oddA = $price2 != 1?$calOdds[0]:2; // if no bet return odd 1
		$oddB = $price1 != 1?$calOdds[1]:2; // if no bet return odd 1
		
		return array('percentA'=>$percentA,
					'percentB'=>$percentB,
					'oddA'=>$oddA,
					'oddB'=>$oddB,

		);

	}

	public function findPercent($team1,$team2,$admin)
	{
		//assume
		// Team A = 5,284/11,333 = 0.466*100 = 46.6% round(47%)	
		// Team B = 6,049/11,333 = 0.533*100 = 53.3% round(53%)
		// Team A 47% Team B 53%	

		$sum = $team1+$team2;
		$percentA = round(($team1/$sum)*100);
		$percentB = round(($team2/$sum)*100);
		return array($percentA,$percentB);
	}

	public function findOdds($percentA,$percentB,$admin)
	{
		// assume
		// percent A 47
		// percent B 53
		// Team A = 53/47 1.12 floor(1.10) +1 = 2.10 = x2.10
		// Team B = 47/53 0.88 floor(0.80) +1 = 1.80 = x1.80
		if($percentA != 0)
		{
			$oddA =  $this->floorp(($percentB/$percentA)+1,2);
			if($oddA > 91)
			{
				$oddA = 20;
			}
		

		}
		else 
		{
			$oddA = 20;
		}
		if($percentB != 0)
		{
			$oddB =  $this->floorp(($percentA/$percentB)+1,2);
			if($oddB > 91)
			{
				$oddB = 20;
			}
	
		}
		else 
		{
			$oddB = 20;
		}
		if($admin == 0)
		{
			$oddA -= 0.5;
			$oddB -= 0.5;
		}
		return array($oddA,$oddB);	
	}

	function floorp($val, $precision)
	{
	    $mult = pow(10, $precision);
	    return floor($val * $mult) / $mult;
	}



	public function getDate()
	{
		$json = file_get_contents('https://script.google.com/macros/s/AKfycbyd5AcbAnWi2Yn0xhFRbyzS4qMq1VucMVgVvhul5XqS9HkAyJY/exec?tz=Asia/Bangkok');
		$obj = json_decode($json);
		$date = array('day'=>$obj->day,'month'=>$obj->month,'year'=>$obj->year,'hour'=>$obj->hours,'minute'=>$obj->minutes);
		return $date;
	}

	

}