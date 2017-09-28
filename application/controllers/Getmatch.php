<?php
class getmatch extends CI_Controller 
{
	public function getlistMatch($d=0,$m=0,$y=0)
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

					if($matchData->statusgame == 0)
					{
						$matchArray[$indexArray]['matchDetail'][$matchIn]['statusgame'] = $this->statusGame($matchData->day,
							$matchData->month,$matchData->year,$matchData->time);
					}
					else 
					{
						$matchArray[$indexArray]['matchDetail'][$matchIn]['statusgame'] = 'แข่งจบแล้ว';
					}

					$calpercent = $this->findPercent($matchData->team1price,$matchData->team2price);
					$plusSum = $matchData->team1price+$matchData->team2price;
					if($matchData->team1price == 1 && $matchData->team2price == 1)
					{
						
						$percentA = 0;
						$percentB = 0;	
					}
					else 
					{
						$percentA = $calpercent[0];
						$percentB = $calpercent[1];					
					}
					$matchArray[$indexArray]['matchDetail'][$matchIn]['percentA'] = $percentA;
					$matchArray[$indexArray]['matchDetail'][$matchIn]['percentB'] = $percentB;
					$calOdds=$this->findOdds($percentA,$percentB);
					$oddA = $matchData->team2price != 1?$calOdds[0]:1; // if no bet return odd 1
					$oddB = $matchData->team1price != 1?$calOdds[1]:1; // if no bet return odd 1
					$matchArray[$indexArray]['matchDetail'][$matchIn]['oddA'] = $oddA;
					$matchArray[$indexArray]['matchDetail'][$matchIn]['oddB'] = $oddB;

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

	function statusGame($d,$m,$y,$time='00:00',$status=0)
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
				$timeNow['minute'] = '0'.timeNow['minute'];
			}
			$hourMin =  explode(':', $time);
			$hourMinNow = $timeNow['hour'].$timeNow['minute'];
			$hourInput = $hourMin[0].$hourMin[1];			
				if($hourMinNow >= $hourInput)
				{

					return 'กำลังแข่ง';
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
					return 'กำลังแข่ง';
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
					return 'กำลังแข่ง';
				}
				else 
				{
					return 'ยังไม่แข่ง';
				}
			}
		}
	}

	public function findPercent($team1,$team2)
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

	public function findOdds($percentA,$percentB)
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
				$oddA = 92;
			}
		

		}
		else 
		{
			$oddA = 92;
		}
		if($percentB != 0)
		{
			$oddB =  $this->floorp(($percentA/$percentB)+1,2);
			if($oddB > 91)
			{
				$oddB = 92;
			}
	
		}
		else 
		{
			$oddB = 92;
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



// -- phpMyAdmin SQL Dump
// -- version 4.6.5.2
// -- https://www.phpmyadmin.net/
// --
// -- Host: 127.0.0.1
// -- Generation Time: Sep 28, 2017 at 10:54 AM
// -- Server version: 10.1.21-MariaDB
// -- PHP Version: 5.6.30

// SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
// SET time_zone = "+00:00";


// /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
// /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
// /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
// /*!40101 SET NAMES utf8mb4 */;

// --
// -- Database: `esport`
// --

// -- --------------------------------------------------------

// --
// -- Table structure for table `catgame`
// --

// CREATE TABLE `catgame` (
//   `cat_id` int(11) NOT NULL,
//   `cat_name` text COLLATE utf8_unicode_ci NOT NULL,
//   `order` int(11) DEFAULT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

// --
// -- Dumping data for table `catgame`
// --

// INSERT INTO `catgame` (`cat_id`, `cat_name`, `order`) VALUES
// (12, 'DOTA', 2),
// (14, 'CS:GO', 1),
// (16, 'OVER WATCH', 3),
// (17, 'ROV', 4);

// -- --------------------------------------------------------

// --
// -- Table structure for table `matchgame`
// --

// CREATE TABLE `matchgame` (
//   `match_id` int(11) NOT NULL,
//   `team_1` text COLLATE utf8_unicode_ci NOT NULL,
//   `team_2` text COLLATE utf8_unicode_ci NOT NULL,
//   `team1pic` text COLLATE utf8_unicode_ci NOT NULL,
//   `team2pic` text COLLATE utf8_unicode_ci NOT NULL,
//   `day` int(11) NOT NULL,
//   `month` int(11) NOT NULL,
//   `year` int(11) NOT NULL,
//   `time` text COLLATE utf8_unicode_ci NOT NULL,
//   `team1people` int(11) DEFAULT '0' COMMENT 'จำนวนคน',
//   `team2people` int(11) DEFAULT '0' COMMENT 'จำนวนคน',
//   `team1price` float DEFAULT '1' COMMENT 'จำนวนเงิน //default1',
//   `team2price` float DEFAULT '1' COMMENT 'จำนวนเงิน //default 1',
//   `winner` text COLLATE utf8_unicode_ci COMMENT 'ผู้ชนะ',
//   `daycreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//   `cat_id` text COLLATE utf8_unicode_ci NOT NULL,
//   `cat_name` text COLLATE utf8_unicode_ci NOT NULL,
//   `statusgame` int(11) NOT NULL DEFAULT '0' COMMENT 'สถานะการแข่ง 0 เท่ากับยังไม่เริ่ม 1 เท่ากับแข่งไปแล้ว'
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

// --
// -- Dumping data for table `matchgame`
// --

// INSERT INTO `matchgame` (`match_id`, `team_1`, `team_2`, `team1pic`, `team2pic`, `day`, `month`, `year`, `time`, `team1people`, `team2people`, `team1price`, `team2price`, `winner`, `daycreate`, `cat_id`, `cat_name`, `statusgame`) VALUES
// (5, 'Fnatic', 'Evil Geniuses', 'https://www.esportsearnings.com/images/logos/tm118-fnatic-2413.png', 'https://www.esportsearnings.com/images/logos/tm101-evil-geniuses-6650.png', 23, 9, 2017, '11:50', 0, 0, 1500, 250, NULL, '2017-09-22 20:45:09', '12', 'DOTA', 0),
// (6, 'Invictus Gaming', 'Evil Geniuses', 'https://www.esportsearnings.com/images/logos/tm124-invictus-gaming-5841.png', 'https://www.esportsearnings.com/images/logos/tm101-evil-geniuses-6650.png', 26, 9, 2017, '22:00', 0, 0, 2852, 1530, NULL, '2017-09-22 20:45:51', '16', 'OVER WATCH', 0),
// (7, 'Wings Gaming', 'Virtus.pro', 'https://www.esportsearnings.com/images/logos/tm507-wings-gaming-7431.png', 'https://www.esportsearnings.com/images/logos/tm185-virtus-pro1781.png', 27, 9, 2017, '08:55', 0, 0, 2500, 8500, NULL, '2017-09-22 20:46:18', '16', 'OVER WATCH', 0),
// (8, 'Invictus Gaming', 'Wings Gaming', 'https://www.esportsearnings.com/images/logos/tm124-invictus-gaming-5841.png', 'https://www.esportsearnings.com/images/logos/tm507-wings-gaming-7431.png', 23, 9, 2017, '13:55', 0, 0, 3250, 2785, NULL, '2017-09-22 21:49:29', '12', 'DOTA', 0),
// (9, 'SK Telecom T1', 'Invictus Gaming', 'https://www.esportsearnings.com/images/logos/tm145-sk-telecom-t1-1662.png', 'https://www.esportsearnings.com/images/logos/tm124-invictus-gaming-5841.png', 26, 9, 2017, '18:00', 0, 0, 800, 1400, NULL, '2017-09-26 09:49:27', '17', 'ROV', 0),
// (10, 'Natus Vincere', 'Newbee', 'https://www.esportsearnings.com/images/logos/tm163-natus-vincere-3644.png', 'https://www.esportsearnings.com/images/logos/tm210-newbee-5563.png', 27, 9, 2017, '18:33', 0, 0, 250, 1800, NULL, '2017-09-26 09:52:21', '14', 'CS:GO', 0),
// (11, 'Fnatic', 'Evil Geniuses', 'https://www.esportsearnings.com/images/logos/tm118-fnatic-2413.png', 'https://www.esportsearnings.com/images/logos/tm101-evil-geniuses-6650.png', 28, 9, 2017, '18:55', 0, 0, 1, 1, NULL, '2017-09-26 09:53:03', '12', 'DOTA', 0),
// (12, 'Wings Gaming', 'Virtus.pro', 'https://www.esportsearnings.com/images/logos/tm507-wings-gaming-7431.png', 'https://www.esportsearnings.com/images/logos/tm185-virtus-pro1781.png', 29, 9, 2017, '01:35', 0, 0, 2500, 8500, NULL, '2017-09-22 20:46:18', '16', 'OVER WATCH', 0),
// (13, 'Fnatic', 'Evil Geniuses', 'https://www.esportsearnings.com/images/logos/tm118-fnatic-2413.png', 'https://www.esportsearnings.com/images/logos/tm101-evil-geniuses-6650.png', 28, 9, 2017, '01:55', 0, 0, 1, 1, NULL, '2017-09-26 09:53:03', '12', 'DOTA', 0);

// -- --------------------------------------------------------

// --
// -- Table structure for table `member`
// --

// CREATE TABLE `member` (
//   `member_id` int(11) NOT NULL,
//   `member_email` text COLLATE utf8_unicode_ci NOT NULL,
//   `member_pass` text COLLATE utf8_unicode_ci NOT NULL,
//   `member_code` text COLLATE utf8_unicode_ci NOT NULL,
//   `member_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//   `member_auth` text COLLATE utf8_unicode_ci,
//   `member_price` int(11) NOT NULL DEFAULT '0'
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

// --
// -- Dumping data for table `member`
// --

// INSERT INTO `member` (`member_id`, `member_email`, `member_pass`, `member_code`, `member_date`, `member_auth`, `member_price`) VALUES
// (54, 'chareef@gmail.com', 'reefaut53', '2009173950', '2017-09-20 20:17:39', NULL, 0),
// (55, 'mygamepc.com@gmail.com', 'reefaut53', '2109171247', '2017-09-21 18:24:12', NULL, 0),
// (56, 'hello@hello.com', 'reefaut53', '2209171960', '2017-09-21 22:45:19', NULL, 0);

// -- --------------------------------------------------------

// --
// -- Table structure for table `storeteam`
// --

// CREATE TABLE `storeteam` (
//   `team_id` int(11) NOT NULL,
//   `team_name` text COLLATE utf8_unicode_ci NOT NULL,
//   `team_imageurl` text COLLATE utf8_unicode_ci NOT NULL,
//   `team_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

// --
// -- Dumping data for table `storeteam`
// --

// INSERT INTO `storeteam` (`team_id`, `team_name`, `team_imageurl`, `team_date`) VALUES
// (2, 'Evil Geniuses', 'https://www.esportsearnings.com/images/logos/tm101-evil-geniuses-6650.png', '2017-08-24 21:34:42'),
// (3, 'Newbee', 'https://www.esportsearnings.com/images/logos/tm210-newbee-5563.png', '2017-08-24 21:35:04'),
// (5, 'Wings Gaming', 'https://www.esportsearnings.com/images/logos/tm507-wings-gaming-7431.png', '2017-08-24 21:35:37'),
// (6, 'Fnatic', 'https://www.esportsearnings.com/images/logos/tm118-fnatic-2413.png', '2017-08-24 21:35:58'),
// (7, 'SK Telecom T1', 'https://www.esportsearnings.com/images/logos/tm145-sk-telecom-t1-1662.png', '2017-08-24 21:36:14'),
// (8, 'Virtus.pro', 'https://www.esportsearnings.com/images/logos/tm185-virtus-pro1781.png', '2017-08-24 21:36:42'),
// (9, 'Invictus Gaming', 'https://www.esportsearnings.com/images/logos/tm124-invictus-gaming-5841.png', '2017-08-24 21:36:58'),
// (10, 'Natus Vincere', 'https://www.esportsearnings.com/images/logos/tm163-natus-vincere-3644.png', '2017-08-24 21:37:17');

// --
// -- Indexes for dumped tables
// --

// --
// -- Indexes for table `catgame`
// --
// ALTER TABLE `catgame`
//   ADD PRIMARY KEY (`cat_id`);

// --
// -- Indexes for table `matchgame`
// --
// ALTER TABLE `matchgame`
//   ADD PRIMARY KEY (`match_id`);

// --
// -- Indexes for table `member`
// --
// ALTER TABLE `member`
//   ADD PRIMARY KEY (`member_id`);

// --
// -- Indexes for table `storeteam`
// --
// ALTER TABLE `storeteam`
//   ADD PRIMARY KEY (`team_id`);

// --
// -- AUTO_INCREMENT for dumped tables
// --

// --
// -- AUTO_INCREMENT for table `catgame`
// --
// ALTER TABLE `catgame`
//   MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
// --
// -- AUTO_INCREMENT for table `matchgame`
// --
// ALTER TABLE `matchgame`
//   MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
// --
// -- AUTO_INCREMENT for table `member`
// --
// ALTER TABLE `member`
//   MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
// --
// -- AUTO_INCREMENT for table `storeteam`
// --
// ALTER TABLE `storeteam`
//   MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
