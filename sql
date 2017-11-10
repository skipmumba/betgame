-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2017 at 03:48 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin` text COLLATE utf8_unicode_ci NOT NULL,
  `pass` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin`, `pass`) VALUES
(1, 'admin', '1234');

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
(1, 'CS:GO', NULL, 'http://i.imgur.com/LitsEzw.jpg'),
(2, 'ROV', NULL, 'http://thevoteth.com/wp-content/uploads/2017/05/logo.png');

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
(4, 'OpTic Gaming', 'Team Liquid', 'https://www.esportsearnings.com/images/logos/tm231-optic-gaming-5983.png', 'https://www.esportsearnings.com/images/logos/tm102-team-liquid-9375.png', 5, 11, 2017, '18:01', 0, 0, 1, 1, '2017-10-24 23:12:36', '2', 'ROV', 0, NULL),
(5, 'Team Liquid', 'OpTic Gaming', 'https://www.esportsearnings.com/images/logos/tm102-team-liquid-9375.png', 'https://www.esportsearnings.com/images/logos/tm231-optic-gaming-5983.png', 7, 11, 2017, '12:00', 0, 1, 1, 201, '2017-10-24 23:12:58', '1', 'CS:GO', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `member_email` text COLLATE utf8_unicode_ci NOT NULL,
  `member_pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `member_code` text COLLATE utf8_unicode_ci NOT NULL,
  `member_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `member_ip` text COLLATE utf8_unicode_ci,
  `member_price` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `member_email`, `member_pass`, `member_code`, `member_date`, `member_ip`, `member_price`) VALUES
(1, 'chareef@gmail.com', '$2y$10$mxya9KGTpka7TY23Cy3k8.w9DWw0bAW2h3vtdrLKW0GHKNDbaSIka', '366914', '2017-10-26 21:39:37', '::1', 0),
(2, 'hello@gmail.com', '$2y$10$Madpp501l8eIxTgGS0CChuzjoiXVEDDp0cia/s2/XWsYa/0oP9TYG', '449959', '2017-11-06 11:13:44', '::1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `news_subject` text COLLATE utf8_unicode_ci NOT NULL,
  `news_textarea` text COLLATE utf8_unicode_ci NOT NULL,
  `news_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_subject`, `news_textarea`, `news_date`) VALUES
(34, 'What is Lorem Ipsum? What is Lorem Ipsum? What is Lorem Ipsum? What is Lorem IWhat is Lorem Ipsum?What is Lorem Ipsum?What is Lorem Ipsum?What is Lorem Ipsum?What is Lorem Ipsum?What is Lorem Ipsum?psum?', '<p style="text-align: center;"><strong>Lorem Ipsum</strong></p><ol><li>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining <span style="color: rgb(235, 107, 86);">essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></li></ol>', '2017-11-08 09:34:26'),
(35, 'Why do we use it?', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', '2017-11-08 09:34:54'),
(36, 'Where can I get some?', '<p>There are many variations of passages <span style="color: rgb(147, 101, 184);">of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage </span></p><p><img src="https://i.froala.com/download/084e60acdc04c40e2d8321a18d48240c81bd96e9.jpg?1510133747" style="width: 300px;" class="fr-fic fr-dib"></p><p>of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', '2017-11-08 09:35:58');

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
(1, NULL, 366914),
(2, NULL, 449959);

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
(1, 'Team Liquid', 'https://www.esportsearnings.com/images/logos/tm102-team-liquid-9375.png', '2017-10-24 23:11:33'),
(2, 'OpTic Gaming', 'https://www.esportsearnings.com/images/logos/tm231-optic-gaming-5983.png', '2017-10-24 23:12:18');

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
(1, 5, 200, 366914, 2, '2017-11-06 11:33:57', NULL);

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
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `catgame`
--
ALTER TABLE `catgame`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `matchgame`
--
ALTER TABLE `matchgame`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `setting_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `storeteam`
--
ALTER TABLE `storeteam`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `userbet`
--
ALTER TABLE `userbet`
  MODIFY `userbet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `walletcode`
--
ALTER TABLE `walletcode`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `withdraw_id` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
