-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2017 at 11:58 AM
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
  `daycreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cat_id` text COLLATE utf8_unicode_ci NOT NULL,
  `cat_name` text COLLATE utf8_unicode_ci NOT NULL,
  `statusgame` int(11) NOT NULL DEFAULT '0' COMMENT 'สถานะการแข่ง 0 เท่ากับยังไม่เริ่ม 1 เท่ากับแข่งไปแล้ว',
  `winner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `matchgame`
--

INSERT INTO `matchgame` (`match_id`, `team_1`, `team_2`, `team1pic`, `team2pic`, `day`, `month`, `year`, `time`, `team1people`, `team2people`, `team1price`, `team2price`, `daycreate`, `cat_id`, `cat_name`, `statusgame`, `winner`) VALUES
(2, 'Natus Vincere', 'Virtus.pro', 'https://www.esportsearnings.com/images/logos/tm163-natus-vincere-3644.png', 'https://www.esportsearnings.com/images/logos/tm185-virtus-pro1781.png', 21, 10, 2017, '1:55', 2, 1, 446, 361, '2017-10-18 20:39:38', '20', 'marvel', 1, NULL),
(3, 'Wings Gaming', 'Natus Vincere', 'https://www.esportsearnings.com/images/logos/tm507-wings-gaming-7431.png', 'https://www.esportsearnings.com/images/logos/tm163-natus-vincere-3644.png', 21, 10, 2017, '21:30', 0, 0, 1, 1, '2017-10-20 00:15:30', '20', 'marvel', 0, NULL),
(4, 'Natus Vincere', 'Newbee', 'https://www.esportsearnings.com/images/logos/tm163-natus-vincere-3644.png', 'https://www.esportsearnings.com/images/logos/tm210-newbee-5563.png', 22, 10, 2017, '10:25', 1, 1, 501, 321, '2017-10-20 00:16:08', '20', 'marvel', 1, NULL);

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
(4, 'chareef@gmail.com', '$2y$10$n8gebsunMnmxtSE/3bMksOBr2saWNiKKcqbuJvEiY.sMpy0rwq/lS', 2010174246, '2017-10-20 00:23:42', '::1', 759),
(5, 'test@gmail.com', '$2y$10$AFEVKQ49lIut31EoZK3W7.Hg5cWw1cy9qFLg0MgwXEmwP..rFX8Vy', 2010175358, '2017-10-20 00:24:53', '::1', 2175),
(6, 'test2@gmail.com', '$2y$10$8zM7Jb89qf2bfj1bO4lUHungQttiDeYqtjofJa73o08Bj0SHjTVdu', 201017066, '2017-10-20 00:25:06', '::1', 2760);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `setting_id` int(10) NOT NULL,
  `setting_phone` text COLLATE utf8_unicode_ci,
  `setting_usercode` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`setting_id`, `setting_phone`, `setting_usercode`) VALUES
(4, NULL, 2010174246),
(5, NULL, 2010175358),
(6, NULL, 201017066);

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
(3, 2, 120, 201017066, 1, '2017-10-20 00:26:12', NULL),
(4, 4, 320, 201017066, 2, '2017-10-20 00:26:12', NULL),
(5, 4, 500, 2010174246, 1, '2017-10-20 00:29:08', NULL),
(6, 2, 360, 2010174246, 2, '2017-10-20 00:29:22', NULL),
(7, 2, 325, 2010175358, 1, '2017-10-20 00:31:42', NULL);

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
(1, 2010174246, 250, '2017-10-22 08:20:03', 0),
(5, 2010175358, 500, '2017-10-22 08:20:03', 0);

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
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `setting_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `storeteam`
--
ALTER TABLE `storeteam`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `userbet`
--
ALTER TABLE `userbet`
  MODIFY `userbet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `walletcode`
--
ALTER TABLE `walletcode`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `withdraw_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
