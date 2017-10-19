-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2017 at 04:09 AM
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
  `order` int(11) DEFAULT NULL,
  `cat_image` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `catgame`
--

INSERT INTO `catgame` (`cat_id`, `cat_name`, `order`, `cat_image`) VALUES
(19, 'CS:GO', NULL, 'https://logodownload.org/wp-content/uploads/2014/09/cs-go-logo-3.png'),
(20, 'marvel', NULL, 'https://img00.deviantart.net/85b0/i/2014/257/c/0/marvel_logo_by_jmk_prime-d7z0vj3.png');

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
  `team1people` int(11) DEFAULT '0' COMMENT 'จำนวนคน',
  `team2people` int(11) DEFAULT '0' COMMENT 'จำนวนคน',
  `team1price` float DEFAULT '1' COMMENT 'จำนวนเงิน //default1',
  `team2price` float DEFAULT '1' COMMENT 'จำนวนเงิน //default 1',
  `winner` text COLLATE utf8_unicode_ci COMMENT 'ผู้ชนะ',
  `daycreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cat_id` text COLLATE utf8_unicode_ci NOT NULL,
  `cat_name` text COLLATE utf8_unicode_ci NOT NULL,
  `statusgame` int(11) NOT NULL DEFAULT '0' COMMENT 'สถานะการแข่ง 0 เท่ากับยังไม่เริ่ม 1 เท่ากับแข่งไปแล้ว'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `matchgame`
--

INSERT INTO `matchgame` (`match_id`, `team_1`, `team_2`, `team1pic`, `team2pic`, `day`, `month`, `year`, `time`, `team1people`, `team2people`, `team1price`, `team2price`, `winner`, `daycreate`, `cat_id`, `cat_name`, `statusgame`) VALUES
(1, 'Evil Geniuses', 'Wings Gaming', 'https://www.esportsearnings.com/images/logos/tm101-evil-geniuses-6650.png', 'https://www.esportsearnings.com/images/logos/tm507-wings-gaming-7431.png', 19, 10, 2017, '13:15', 1, 2, 321, 301, NULL, '2017-10-18 20:39:17', '19', 'CS:GO', 0),
(2, 'Natus Vincere', 'Virtus.pro', 'https://www.esportsearnings.com/images/logos/tm163-natus-vincere-3644.png', 'https://www.esportsearnings.com/images/logos/tm185-virtus-pro1781.png', 21, 10, 2017, '18:55', 1, 1, 201, 351, NULL, '2017-10-18 20:39:38', '19', 'CS:GO', 0);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `member_email` text COLLATE utf8_unicode_ci NOT NULL,
  `member_pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `member_code` int(20) NOT NULL,
  `member_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `member_ip` text COLLATE utf8_unicode_ci,
  `member_price` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `member_email`, `member_pass`, `member_code`, `member_date`, `member_ip`, `member_price`) VALUES
(1, 'chareef@gmail.com', '$2y$10$fdP8Z9fr8hx1hTNo6a/jWeBOfiDTgkL4Myul.5v/CJcJ.U1o3U1nC', 1510171538, '2017-10-14 22:46:15', '::1', 4230),
(2, 'test@gmail.com', '$2y$10$aK2yK.dKuph6HSEDNnKJ3.Jc9h3wuQbH/dj3IqTQSq.pssLUOYM4K', 2147483647, '2017-10-18 00:59:03', '::1', 2600);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `setting_id` int(10) NOT NULL,
  `setting_phone` int(10) NOT NULL,
  `setting_usercode` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `userbet`
--

CREATE TABLE `userbet` (
  `userbet_id` int(11) NOT NULL,
  `userbet_matchid` int(10) NOT NULL,
  `userbet_price` int(10) NOT NULL,
  `userbet_usercode` int(20) NOT NULL,
  `userbet_team` int(1) NOT NULL,
  `userbet_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userbet_error` text COLLATE utf8_unicode_ci COMMENT 'จะใส่ข้อผิดพลาดเมื่อลบไม่ได้หรือคืนตังไม่ได้'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `userbet`
--

INSERT INTO `userbet` (`userbet_id`, `userbet_matchid`, `userbet_price`, `userbet_usercode`, `userbet_team`, `userbet_time`, `userbet_error`) VALUES
(1, 1, 100, 1510171538, 2, '2017-10-18 20:43:22', NULL),
(2, 1, 320, 1510171538, 1, '2017-10-18 20:43:37', NULL),
(3, 2, 350, 1510171538, 2, '2017-10-18 20:44:00', NULL),
(4, 2, 200, 2147483647, 1, '2017-10-18 20:44:22', NULL),
(5, 1, 200, 2147483647, 2, '2017-10-18 20:44:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `walletcode`
--

CREATE TABLE `walletcode` (
  `wallet_id` int(11) NOT NULL,
  `wallet_phone` text COLLATE utf8_unicode_ci NOT NULL,
  `wallet_usercode` text COLLATE utf8_unicode_ci NOT NULL,
  `wallet_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `wallet_code` text COLLATE utf8_unicode_ci NOT NULL,
  `wallet_price` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `walletcode`
--

INSERT INTO `walletcode` (`wallet_id`, `wallet_phone`, `wallet_usercode`, `wallet_date`, `wallet_code`, `wallet_price`) VALUES
(4, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '200'),
(5, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '380'),
(6, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '780'),
(7, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '250'),
(8, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '200'),
(9, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '2500'),
(10, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '200'),
(11, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '200'),
(12, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '200'),
(13, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '200'),
(14, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '200'),
(15, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '200'),
(16, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '200'),
(17, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '200'),
(18, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '200'),
(19, '06212123', '1510171538', '2017-10-18 23:34:39', '603523132', '200');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `withdraw_id` int(10) NOT NULL,
  `withdraw_usercode` int(20) NOT NULL,
  `withdraw_price` int(20) NOT NULL,
  `withdraw_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `withdraw_status` int(11) NOT NULL DEFAULT '0' COMMENT '0 = ยัง 1 = โอนแล้ว'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `withdraw`
--

INSERT INTO `withdraw` (`withdraw_id`, `withdraw_usercode`, `withdraw_price`, `withdraw_time`, `withdraw_status`) VALUES
(1, 1510171538, 900, '2017-10-19 00:38:54', 1),
(2, 1510171538, 200, '2017-10-19 00:38:54', 0),
(3, 1510171538, 300, '2017-10-19 00:38:54', 0),
(4, 1510171538, 250, '2017-10-19 00:38:54', 0),
(5, 1510171538, 200, '2017-10-19 00:38:54', 0),
(6, 1510171538, 180, '2017-10-19 00:38:54', 0),
(7, 1510171538, 200, '2017-10-19 00:38:54', 0),
(8, 1510171538, 2000, '2017-10-19 00:38:54', 0);

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
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `storeteam`
--
ALTER TABLE `storeteam`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `userbet`
--
ALTER TABLE `userbet`
  ADD PRIMARY KEY (`userbet_id`);

--
-- Indexes for table `walletcode`
--
ALTER TABLE `walletcode`
  ADD PRIMARY KEY (`wallet_id`);

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`withdraw_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catgame`
--
ALTER TABLE `catgame`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `matchgame`
--
ALTER TABLE `matchgame`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `setting_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `storeteam`
--
ALTER TABLE `storeteam`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `userbet`
--
ALTER TABLE `userbet`
  MODIFY `userbet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `walletcode`
--
ALTER TABLE `walletcode`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `withdraw_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
