<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class register extends CI_Controller{
	public function __construct()
	{
	   	parent::__construct();
	    //Codeigniter : Write Less Do More
	}

	public function sameUser($username)
	{
		$this->db->from('member');
		$this->db->where('member_email',$username);
		$query = $this->db->get();
		$count = $query->num_rows();
		if($count > 0)
		{
			echo json_encode(array('state'=>'1')); // 1 have
		}
		else 
		{
			echo json_encode(array('state'=>'0')); // 0 no
		}
	}

	public function sameUserSserver($username)
	{
		$this->db->from('member');
		$this->db->where('member_email',$username);
		$query = $this->db->get();
		$count = $query->num_rows();
		if($count > 0)
		{
			return $count;
		}
		else 
		{
			return $count;
		}
	}

	public function regisTer()
	{
		$data = json_decode(file_get_contents('php://input'),true);
		$email = $data['email'];
		$pass = $data['pass'];
		$checkUSer = $this->sameUserSserver($email);
		$patternEmail ="/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/";
		$patternPass ="/^[a-zA-Z0-9_-]{8,30}$/";
		if($checkUSer < 1)
		{
			if (preg_match($patternEmail, $email) === 1) 
			{
				$lenEmail = strlen($email);
				if($lenEmail > 7 )
				{
					$lenPass = strlen($pass);
					if (preg_match($patternPass, $pass) === 1) 
					{					
						if($this->insertMember($email,$pass))
						{
							echo json_encode(array('regisStatus'=>1)); // register ok
						}
						else 
						{
							echo json_encode(array('regisStatus'=>0));
						}
					}
					else 
					{
						echo 'noooooooooooooo';
					}

				}
				else 
				{
					echo 'what are you trying to do Bitch !!';
				}
			}
			else 
			{
				echo 'fuck off you cunts !!!';
			}
		}
		else 
		{
			echo 'fuck off bitch !!!';
		}
	}

	public function insertMember($email,$pass)
	{
		$time = date('dmys');
		$ran = rand(date('s'),rand(1,99));
		$ranNow = $time.''.$ran;
		$data = array(
	        'member_email' => $email,
	        'member_pass' => $pass,
	        'member_code' => $ranNow,
		);

		$this->db->insert('member', $data);
		if($this->db->affected_rows() > 0)
		{
		    return true;
		}
		else 
		{
			return false;
		}
	}

}

//sql file

-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2017 at 11:35 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esport`
--

-- --------------------------------------------------------

--
-- Table structure for table `catgame`
--

CREATE TABLE `catgame` (
  `cat_id` int(11) NOT NULL,
  `cat_name` text COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `catgame`
--

INSERT INTO `catgame` (`cat_id`, `cat_name`, `order`) VALUES
(12, 'DOTA', 2),
(14, 'CS:GO', 1),
(16, 'OVER WATCH', 3),
(17, 'ROV', 4);

-- --------------------------------------------------------

--
-- Table structure for table `matchgame`
--

CREATE TABLE `matchgame` (
  `match_id` int(11) NOT NULL,
  `team_1` text COLLATE utf8_unicode_ci NOT NULL,
  `team_2` text COLLATE utf8_unicode_ci NOT NULL,
  `team1pic` text COLLATE utf8_unicode_ci NOT NULL,
  `team2pic` text COLLATE utf8_unicode_ci NOT NULL,
  `day` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `time` text COLLATE utf8_unicode_ci NOT NULL,
  `team1percent` int(11) DEFAULT '0' COMMENT 'เปอเซ็น',
  `team2percent` int(11) DEFAULT '0' COMMENT 'เปอเซ็น',
  `team1people` int(11) DEFAULT '0' COMMENT 'จำนวนคน',
  `team2people` int(11) DEFAULT '0' COMMENT 'จำนวนคน',
  `team1price` int(11) DEFAULT '0' COMMENT 'จำนวนเงิน',
  `team2price` int(11) DEFAULT '0' COMMENT 'จำนวนเงิน',
  `winner` text COLLATE utf8_unicode_ci COMMENT 'ผู้ชนะ',
  `daycreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cat_id` text COLLATE utf8_unicode_ci NOT NULL,
  `cat_name` text COLLATE utf8_unicode_ci NOT NULL,
  `statusgame` int(11) NOT NULL DEFAULT '0' COMMENT 'สถานะการแข่ง 0 เท่ากับยังไม่เริ่ม 1 เท่ากับแข่งไปแล้ว'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `matchgame`
--

INSERT INTO `matchgame` (`match_id`, `team_1`, `team_2`, `team1pic`, `team2pic`, `day`, `month`, `year`, `time`, `team1percent`, `team2percent`, `team1people`, `team2people`, `team1price`, `team2price`, `winner`, `daycreate`, `cat_id`, `cat_name`, `statusgame`) VALUES
(15, 'Newbee', 'Evil Geniuses', 'https://www.esportsearnings.com/images/logos/tm210-newbee-5563.png', 'https://www.esportsearnings.com/images/logos/tm101-evil-geniuses-6650.png', 6, 9, 2017, '12:00', 0, 0, 0, 0, 0, 0, NULL, '2017-09-06 07:50:44', '17', 'ROV', 0),
(16, 'Wings Gaming', 'Fnatic', 'https://www.esportsearnings.com/images/logos/tm507-wings-gaming-7431.png', 'https://www.esportsearnings.com/images/logos/tm118-fnatic-2413.png', 7, 9, 2017, '13:25', 0, 0, 0, 0, 0, 0, NULL, '2017-09-06 07:51:29', '17', 'ROV', 0),
(17, 'Natus Vincere', 'SK Telecom T1', 'https://www.esportsearnings.com/images/logos/tm163-natus-vincere-3644.png', 'https://www.esportsearnings.com/images/logos/tm145-sk-telecom-t1-1662.png', 8, 9, 2017, '16:55', 0, 0, 0, 0, 0, 0, NULL, '2017-09-06 07:52:16', '16', 'OVER WATCH', 0),
(18, 'Fnatic', 'Evil Geniuses', 'https://www.esportsearnings.com/images/logos/tm118-fnatic-2413.png', 'https://www.esportsearnings.com/images/logos/tm101-evil-geniuses-6650.png', 11, 9, 2017, '18:35', 0, 0, 0, 0, 0, 0, NULL, '2017-09-06 07:53:09', '16', 'OVER WATCH', 0),
(19, 'Wings Gaming', 'Evil Geniuses', 'https://www.esportsearnings.com/images/logos/tm507-wings-gaming-7431.png', 'https://www.esportsearnings.com/images/logos/tm101-evil-geniuses-6650.png', 6, 9, 2017, '16:45', 0, 0, 0, 0, 0, 0, NULL, '2017-09-06 07:54:34', '12', 'DOTA', 0),
(20, 'Wings Gaming', 'Evil Geniuses', 'https://www.esportsearnings.com/images/logos/tm507-wings-gaming-7431.png', 'https://www.esportsearnings.com/images/logos/tm101-evil-geniuses-6650.png', 11, 9, 2017, '13:45', 0, 0, 0, 0, 0, 0, NULL, '2017-09-11 16:06:38', '17', 'ROV', 0),
(21, 'Virtus.pro', 'Natus Vincere', 'https://www.esportsearnings.com/images/logos/tm185-virtus-pro1781.png', 'https://www.esportsearnings.com/images/logos/tm163-natus-vincere-3644.png', 13, 9, 2017, '10:50', 0, 0, 0, 0, 0, 0, NULL, '2017-09-11 16:07:15', '17', 'ROV', 0),
(22, 'Evil Geniuses', 'Fnatic', 'https://www.esportsearnings.com/images/logos/tm101-evil-geniuses-6650.png', 'https://www.esportsearnings.com/images/logos/tm118-fnatic-2413.png', 15, 9, 2017, '21:30', 0, 0, 0, 0, 0, 0, NULL, '2017-09-11 16:07:49', '14', 'CS:GO', 0),
(23, 'Wings Gaming', 'SK Telecom T1', 'https://www.esportsearnings.com/images/logos/tm507-wings-gaming-7431.png', 'https://www.esportsearnings.com/images/logos/tm145-sk-telecom-t1-1662.png', 13, 9, 2017, '13:00', 0, 0, 0, 0, 0, 0, NULL, '2017-09-11 16:38:05', '16', 'OVER WATCH', 0),
(24, 'SK Telecom T1', 'Evil Geniuses', 'https://www.esportsearnings.com/images/logos/tm145-sk-telecom-t1-1662.png', 'https://www.esportsearnings.com/images/logos/tm101-evil-geniuses-6650.png', 11, 9, 2017, '22:45', 0, 0, 0, 0, 0, 0, NULL, '2017-09-11 16:38:37', '12', 'DOTA', 0);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `member_email` text COLLATE utf8_unicode_ci NOT NULL,
  `member_pass` text COLLATE utf8_unicode_ci NOT NULL,
  `member_code` text COLLATE utf8_unicode_ci NOT NULL,
  `member_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `member_email`, `member_pass`, `member_code`, `member_date`) VALUES
(1, 'test@gmail.com', 'reefaut53', 'awdwad', '2017-09-11 06:00:26'),
(2, 'abc@gmail.com', 'reefaut53', 'fwadwad', '2017-09-11 06:11:35'),
(3, 'chbareef@gmail.com', '123456713212', '1609174814', '2017-09-16 08:50:48'),
(4, 'chbareefs@gmail.com', '123456713212', '160917014', '2017-09-16 08:51:01'),
(5, 'chbareefs@gmail.coma', '123456713212', '1609172437', '2017-09-16 08:52:24'),
(6, 'chbareefs@gmail.coms', '123456713212', '1609170663', '2017-09-16 08:55:06'),
(7, 'chbareefs@gmail.comsss', '123456713212', '1609172646', '2017-09-16 08:55:26'),
(8, 'chbareef@gmail.cos', '123456713212', '1609175947', '2017-09-16 08:55:59'),
(9, 'test@test.com', 'reefaut53', '1609172012', '2017-09-16 08:56:20'),
(10, 'chareef56@gmail.com', 'reefaut53', '1609174040', '2017-09-16 08:57:40'),
(11, 'abcd@gmail.com', 'reefaut53', '1609172469', '2017-09-16 08:59:24'),
(12, 'abcd@gmail.coma', 'reefaut53', '160917033', '2017-09-16 09:00:03'),
(13, 'aaaaa@gmail.com', 'reefaut53', '1609173258', '2017-09-16 09:00:32'),
(14, 'asdasd@asdsad.com', 'sadsadawdad', '1609170817', '2017-09-16 09:01:08'),
(15, 'asdasd@asdsad.coma', 'sadsadawdada', '1609173333', '2017-09-16 09:02:33'),
(16, 'asdsdsadw@sadsfdw.com', '15213awdwad', '1609171440', '2017-09-16 09:03:14'),
(17, 'asdsdsadw@sadsfdw.coma', '15213awdwad', '1609173333', '2017-09-16 09:03:33'),
(18, 'chareef@gmail.com', 'reefait53', '1609174851', '2017-09-16 09:06:48'),
(19, 'chareef@gmail.coms', 'asdsadsadaasdawa', '1609171818', '2017-09-16 09:07:18'),
(20, 'chareef53@gmail.com', 'refait53', '1609174645', '2017-09-16 09:08:46'),
(21, 'chareef@gmail.comss', 'sssssssss', '1609175361', '2017-09-16 09:11:53');

-- --------------------------------------------------------

--
-- Table structure for table `storeteam`
--

CREATE TABLE `storeteam` (
  `team_id` int(11) NOT NULL,
  `team_name` text COLLATE utf8_unicode_ci NOT NULL,
  `team_imageurl` text COLLATE utf8_unicode_ci NOT NULL,
  `team_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `storeteam`
--

INSERT INTO `storeteam` (`team_id`, `team_name`, `team_imageurl`, `team_date`) VALUES
(2, 'Evil Geniuses', 'https://www.esportsearnings.com/images/logos/tm101-evil-geniuses-6650.png', '2017-08-24 21:34:42'),
(3, 'Newbee', 'https://www.esportsearnings.com/images/logos/tm210-newbee-5563.png', '2017-08-24 21:35:04'),
(5, 'Wings Gaming', 'https://www.esportsearnings.com/images/logos/tm507-wings-gaming-7431.png', '2017-08-24 21:35:37'),
(6, 'Fnatic', 'https://www.esportsearnings.com/images/logos/tm118-fnatic-2413.png', '2017-08-24 21:35:58'),
(7, 'SK Telecom T1', 'https://www.esportsearnings.com/images/logos/tm145-sk-telecom-t1-1662.png', '2017-08-24 21:36:14'),
(8, 'Virtus.pro', 'https://www.esportsearnings.com/images/logos/tm185-virtus-pro1781.png', '2017-08-24 21:36:42'),
(9, 'Invictus Gaming', 'https://www.esportsearnings.com/images/logos/tm124-invictus-gaming-5841.png', '2017-08-24 21:36:58'),
(10, 'Natus Vincere', 'https://www.esportsearnings.com/images/logos/tm163-natus-vincere-3644.png', '2017-08-24 21:37:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catgame`
--
ALTER TABLE `catgame`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `matchgame`
--
ALTER TABLE `matchgame`
  ADD PRIMARY KEY (`match_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `storeteam`
--
ALTER TABLE `storeteam`
  ADD PRIMARY KEY (`team_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catgame`
--
ALTER TABLE `catgame`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `matchgame`
--
ALTER TABLE `matchgame`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `storeteam`
--
ALTER TABLE `storeteam`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
