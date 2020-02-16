-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2019 at 06:07 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `name`, `deleted`) VALUES
(1, 'Kg 1', 0),
(2, 'kg 2', 0),
(3, 'Primary 1', 0),
(4, 'Primary 2', 0),
(5, 'Primary 3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `disposition`
--

CREATE TABLE `disposition` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `disposition`
--

INSERT INTO `disposition` (`id`, `title`) VALUES
(1, 'Attentiveness'),
(2, 'Cooperation with others'),
(3, 'Emotional Stability');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `beneficiary` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `beneficiary`, `purpose`, `amount`, `date`) VALUES
(1, 'Mr Gbenga', 'Repair of school chairs', '5000.00', '2018-10-17'),
(2, 'Mr Adamolekun', 'Supply of biro', '3000.00', '2018-10-17'),
(3, 'Mr Ajala', 'Repair of school bus tyre', '2000.00', '2018-10-17'),
(4, 'Baba Driver', 'Fuel', '2000.00', '2018-11-22');

-- --------------------------------------------------------

--
-- Table structure for table `pay`
--

CREATE TABLE `pay` (
  `id` int(11) NOT NULL,
  `classid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pay`
--

INSERT INTO `pay` (`id`, `classid`, `name`, `amount`, `deleted`) VALUES
(1, 1, 'Development Fees', '7500.00', 1),
(2, 1, 'Uniform', '2500.00', 0),
(3, 1, 'School Fees', '20000.00', 0),
(4, 3, 'School Fees', '25000.00', 0),
(5, 3, 'Development Fees', '8000.00', 0),
(6, 3, 'Uniform', '2500.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `regnumber` varchar(255) NOT NULL,
  `classid` int(11) NOT NULL,
  `payid` int(11) NOT NULL,
  `sessionid` int(11) NOT NULL,
  `termid` int(11) NOT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `paymentid` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `deleted` int(11) NOT NULL,
  `corrected` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `studentid`, `regnumber`, `classid`, `payid`, `sessionid`, `termid`, `amount`, `paymentid`, `date`, `deleted`, `corrected`) VALUES
(45, 10, 'CA/2018/01', 3, 5, 3, 1, '5000.00', 'vkoalklhvuiubvdn1akonmh0c2', '2018-10-17', 0, 0),
(46, 10, 'CA/2018/01', 3, 4, 3, 1, '15000.00', 'vkoalklhvuiubvdn1akonmh0c2', '2018-10-17', 0, 0),
(47, 10, 'CA/2018/01', 3, 6, 3, 1, '1000.00', 'vkoalklhvuiubvdn1akonmh0c2', '2018-10-17', 0, 0),
(48, 11, 'CA/2018/02', 3, 5, 3, 1, '3000.00', 's49jshrvqecvaphquq4sjn80f4', '2018-10-17', 0, 0),
(49, 11, 'CA/2018/02', 3, 4, 3, 1, '15000.00', 's49jshrvqecvaphquq4sjn80f4', '2018-10-17', 0, 1),
(50, 11, 'CA/2018/02', 3, 6, 3, 1, '2000.00', 's49jshrvqecvaphquq4sjn80f4', '2018-10-17', 0, 0),
(51, 10, 'CA/2018/01', 3, 4, 3, 1, '5000.00', 'aep8e6u9i94k9td9et74b3m8m4', '2018-10-17', 1, 0),
(52, 10, 'CA/2018/01', 3, 4, 3, 1, '5000.00', 'ntaqlou1p3dgc83n051224ait2', '2018-11-22', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `description`) VALUES
('Admin Officer', 'Add, Remove, and Update User Information'),
('Class Teacher', 'Add, Remove and Update Student Information'),
('Secretary', 'Add, Remove, and Update Payments');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `name`) VALUES
(1, '2018/2019'),
(2, '2019/2020'),
(3, '2020/2021'),
(4, '2021/2022');

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE `skill` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skill`
--

INSERT INTO `skill` (`id`, `title`) VALUES
(1, 'Drawing and Painting'),
(2, 'Handling Tools'),
(3, 'Games');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `othername` varchar(255) DEFAULT NULL,
  `regnumber` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `parentphone` varchar(255) DEFAULT NULL,
  `classid` int(11) NOT NULL,
  `sessionid` int(11) NOT NULL,
  `termid` int(11) NOT NULL,
  `dob` date NOT NULL,
  `date` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL,
  `corrected` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `surname`, `firstname`, `othername`, `regnumber`, `gender`, `parentphone`, `classid`, `sessionid`, `termid`, `dob`, `date`, `image`, `deleted`, `corrected`) VALUES
(2, 'Hammed', 'Hamidat', 'Anike', 'CA/2018/01', 'Female', '08034567890', 1, 1, 1, '2018-06-26', '2018-09-13', 'upload/5d77c069e9220.png', 0, 0),
(3, 'Hammed', 'Taofeek', 'Olajide', 'CA/2018/02', 'Male', '08035297428', 1, 1, 1, '1996-06-26', '2018-09-13', 'upload/5cbf2342982a3.png', 0, 0),
(4, 'Hammed', 'Hamidat', 'Anike', 'CA/2018/01', 'Female', '08034567890', 1, 1, 2, '2018-06-26', '2018-09-13', '', 0, 0),
(5, 'Hammed', 'Taofeek', 'Olajide', 'CA/2018/02', 'Male', '08035297428', 1, 1, 2, '1996-06-26', '2018-09-16', '', 0, 0),
(6, 'Hammed', 'Hamidat', 'Anike', 'CA/2018/01', 'Female', '08034567890', 1, 1, 3, '2018-06-26', '2018-09-13', 'upload/5d77c85a94b95.png', 0, 0),
(7, 'Hammed', 'Taofeek', 'Olajide', 'CA/2018/02', 'Male', '08035297428', 1, 1, 3, '1996-06-26', '2018-09-14', 'upload/5d78066ac0116.png', 0, 0),
(8, 'Hammed', 'Hamidat', 'Anike', 'CA/2018/01', 'Female', '08034567890', 2, 2, 1, '2018-06-26', '2018-09-14', '', 0, 0),
(9, 'Hammed', 'Taofeek', 'Olajide', 'CA/2018/02', 'Male', '08035297428', 2, 2, 1, '1996-06-26', '2018-09-14', '', 0, 0),
(10, 'Hammed', 'Hamidat', 'Anike', 'CA/2018/01', 'Female', '08034567890', 3, 3, 1, '2018-06-26', '2018-10-08', '', 0, 0),
(11, 'Hammed', 'Taofeek', 'Olajide', 'CA/2018/02', 'Male', '08035297428', 3, 3, 1, '1996-06-26', '2018-10-10', '', 0, 0),
(12, 'Hammed', 'Hamidat', 'Anike', 'CA/2018/01', 'Female', '08034567890', 4, 3, 1, '2018-06-26', '2018-10-17', '', 0, 0),
(13, 'HAMMED', 'Akeem', 'Amoo', 'CA/2018/003', 'Male', '8035297428', 1, 1, 1, '1989-05-20', '2019-04-20', 'upload/5cbdfbcf3bcac.png', 0, 0),
(17, 'HAMMED', 'Akeem', 'Amoo', 'CA/2018/003', 'Male', '8035297428', 1, 1, 2, '1989-05-20', '2019-09-10', 'upload/5cbdfbcf3bcac.png', 0, 0),
(18, 'HAMMED', 'Akeem', 'Amoo', 'CA/2018/003', 'Male', '8035297428', 1, 1, 3, '1989-05-20', '2019-09-10', 'upload/5cbdfbcf3bcac.png', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `studentdisposition`
--

CREATE TABLE `studentdisposition` (
  `id` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `dispositionid` int(11) NOT NULL,
  `grade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentdisposition`
--

INSERT INTO `studentdisposition` (`id`, `studentid`, `dispositionid`, `grade`) VALUES
(4, 3, 1, 3),
(5, 3, 2, 1),
(6, 3, 3, 2),
(7, 13, 1, 1),
(8, 13, 2, 1),
(9, 13, 3, 1),
(22, 7, 1, 2),
(23, 7, 2, 2),
(24, 7, 3, 3),
(25, 4, 1, 1),
(26, 4, 2, 2),
(27, 4, 3, 3),
(28, 5, 1, 1),
(29, 5, 2, 2),
(30, 5, 3, 3),
(31, 17, 1, 1),
(32, 17, 2, 2),
(33, 17, 3, 3),
(34, 6, 1, 2),
(35, 6, 2, 1),
(36, 6, 3, 2),
(43, 2, 1, 1),
(44, 2, 2, 2),
(45, 2, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `studentskill`
--

CREATE TABLE `studentskill` (
  `id` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `skillid` int(11) NOT NULL,
  `grade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentskill`
--

INSERT INTO `studentskill` (`id`, `studentid`, `skillid`, `grade`) VALUES
(4, 3, 1, 3),
(5, 3, 2, 1),
(6, 3, 3, 2),
(7, 13, 1, 1),
(8, 13, 2, 1),
(9, 13, 3, 1),
(22, 7, 1, 2),
(23, 7, 2, 2),
(24, 7, 3, 3),
(25, 4, 1, 1),
(26, 4, 2, 2),
(27, 4, 3, 3),
(28, 5, 1, 1),
(29, 5, 2, 2),
(30, 5, 3, 3),
(31, 17, 1, 1),
(32, 17, 2, 2),
(33, 17, 3, 3),
(34, 6, 1, 2),
(35, 6, 2, 1),
(36, 6, 3, 2),
(43, 2, 1, 1),
(44, 2, 2, 2),
(45, 2, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `studentsubject`
--

CREATE TABLE `studentsubject` (
  `studentid` int(11) NOT NULL,
  `regnumber` varchar(255) NOT NULL,
  `subjectid` int(11) NOT NULL,
  `sessionid` int(11) NOT NULL,
  `termid` int(11) NOT NULL,
  `classid` int(11) NOT NULL,
  `test1` int(11) NOT NULL,
  `test2` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `studentsubject`
--

INSERT INTO `studentsubject` (`studentid`, `regnumber`, `subjectid`, `sessionid`, `termid`, `classid`, `test1`, `test2`, `score`, `date`) VALUES
(2, 'CA/2018/01', 1, 1, 1, 1, 12, 8, 50, '2019-11-06'),
(2, 'CA/2018/01', 2, 1, 1, 1, 12, 8, 50, '2019-11-06'),
(2, 'CA/2018/01', 3, 1, 1, 1, 12, 8, 50, '2019-11-06'),
(2, 'CA/2018/01', 4, 1, 1, 1, 12, 8, 50, '2019-11-06'),
(2, 'CA/2018/01', 6, 1, 1, 1, 12, 8, 50, '2019-11-06'),
(2, 'CA/2018/01', 7, 1, 1, 1, 12, 8, 50, '2019-11-06'),
(3, 'CA/2018/02', 1, 1, 1, 1, 12, 8, 50, '2019-09-07'),
(3, 'CA/2018/02', 2, 1, 1, 1, 12, 8, 50, '2019-09-07'),
(3, 'CA/2018/02', 3, 1, 1, 1, 12, 8, 50, '2019-09-07'),
(3, 'CA/2018/02', 4, 1, 1, 1, 12, 8, 50, '2019-09-07'),
(3, 'CA/2018/02', 6, 1, 1, 1, 12, 8, 50, '2019-09-07'),
(3, 'CA/2018/02', 7, 1, 1, 1, 12, 8, 50, '2019-09-07'),
(4, 'CA/2018/01', 1, 1, 2, 1, 10, 12, 55, '2018-10-10'),
(4, 'CA/2018/01', 2, 1, 2, 1, 12, 10, 70, '2018-10-10'),
(4, 'CA/2018/01', 3, 1, 2, 1, 5, 10, 50, '2018-10-10'),
(4, 'CA/2018/01', 4, 1, 2, 1, 8, 12, 45, '2018-10-10'),
(4, 'CA/2018/01', 6, 1, 2, 1, 10, 15, 60, '2018-10-10'),
(5, 'CA/2018/02', 1, 1, 2, 1, 8, 10, 40, '2018-10-10'),
(5, 'CA/2018/02', 2, 1, 2, 1, 7, 8, 48, '2018-10-10'),
(5, 'CA/2018/02', 3, 1, 2, 1, 12, 8, 30, '2018-10-10'),
(5, 'CA/2018/02', 4, 1, 2, 1, 10, 8, 42, '2018-10-10'),
(5, 'CA/2018/02', 6, 1, 2, 1, 5, 10, 35, '2018-10-10'),
(6, 'CA/2018/01', 1, 1, 3, 1, 12, 5, 40, '2019-09-10'),
(6, 'CA/2018/01', 2, 1, 3, 1, 12, 8, 45, '2019-09-10'),
(6, 'CA/2018/01', 3, 1, 3, 1, 10, 5, 35, '2019-09-10'),
(6, 'CA/2018/01', 4, 1, 3, 1, 10, 5, 42, '2019-09-10'),
(6, 'CA/2018/01', 6, 1, 3, 1, 8, 12, 30, '2019-09-10'),
(6, 'CA/2018/01', 7, 1, 3, 1, 12, 8, 50, '2019-09-10'),
(7, 'CA/2018/02', 1, 1, 3, 1, 8, 12, 25, '2019-09-10'),
(7, 'CA/2018/02', 2, 1, 3, 1, 5, 8, 50, '2019-09-10'),
(7, 'CA/2018/02', 3, 1, 3, 1, 12, 10, 30, '2019-09-10'),
(7, 'CA/2018/02', 4, 1, 3, 1, 7, 8, 52, '2019-09-10'),
(7, 'CA/2018/02', 6, 1, 3, 1, 10, 10, 35, '2019-09-10'),
(7, 'CA/2018/02', 7, 1, 3, 1, 0, 0, 0, '2019-09-10'),
(8, 'CA/2018/01', 1, 2, 1, 2, 12, 5, 30, '2018-10-08'),
(8, 'CA/2018/01', 2, 2, 1, 2, 10, 8, 32, '2018-10-08'),
(8, 'CA/2018/01', 3, 2, 1, 2, 8, 12, 40, '2018-10-08'),
(8, 'CA/2018/01', 4, 2, 1, 2, 15, 10, 50, '2018-10-08'),
(8, 'CA/2018/01', 6, 2, 1, 2, 0, 0, 0, '2018-10-08'),
(9, 'CA/2018/02', 1, 2, 1, 2, 0, 0, 0, '2018-10-08'),
(9, 'CA/2018/02', 2, 2, 1, 2, 0, 0, 0, '2018-10-08'),
(9, 'CA/2018/02', 3, 2, 1, 2, 0, 0, 0, '2018-10-08'),
(9, 'CA/2018/02', 4, 2, 1, 2, 0, 0, 0, '2018-10-08'),
(9, 'CA/2018/02', 6, 2, 1, 2, 0, 0, 0, '2018-10-08'),
(10, 'CA/2018/01', 1, 3, 1, 3, 0, 0, 0, '2018-11-07'),
(10, 'CA/2018/01', 2, 3, 1, 3, 0, 0, 0, '2018-11-07'),
(10, 'CA/2018/01', 3, 3, 1, 3, 12, 8, 45, '2018-11-07'),
(10, 'CA/2018/01', 4, 3, 1, 3, 0, 0, 0, '2018-11-07'),
(10, 'CA/2018/01', 6, 3, 1, 3, 0, 0, 0, '2018-11-07'),
(10, 'CA/2018/01', 7, 3, 1, 3, 0, 0, 0, '2018-11-07'),
(11, 'CA/2018/02', 1, 3, 1, 3, 0, 0, 0, '0000-00-00'),
(11, 'CA/2018/02', 2, 3, 1, 3, 0, 0, 0, '0000-00-00'),
(11, 'CA/2018/02', 3, 3, 1, 3, 0, 0, 0, '0000-00-00'),
(11, 'CA/2018/02', 4, 3, 1, 3, 0, 0, 0, '0000-00-00'),
(11, 'CA/2018/02', 6, 3, 1, 3, 0, 0, 0, '0000-00-00'),
(12, 'CA/2018/01', 1, 3, 1, 4, 0, 0, 0, '0000-00-00'),
(12, 'CA/2018/01', 2, 3, 1, 4, 0, 0, 0, '0000-00-00'),
(12, 'CA/2018/01', 3, 3, 1, 4, 0, 0, 0, '0000-00-00'),
(12, 'CA/2018/01', 4, 3, 1, 4, 0, 0, 0, '0000-00-00'),
(12, 'CA/2018/01', 6, 3, 1, 4, 0, 0, 0, '0000-00-00'),
(13, 'CA/2018/003', 1, 1, 1, 1, 12, 8, 50, '2019-09-08'),
(13, 'CA/2018/003', 2, 1, 1, 1, 10, 12, 40, '2019-09-08'),
(13, 'CA/2018/003', 3, 1, 1, 1, 12, 8, 45, '2019-09-08'),
(13, 'CA/2018/003', 4, 1, 1, 1, 10, 8, 45, '2019-09-08'),
(13, 'CA/2018/003', 6, 1, 1, 1, 15, 5, 50, '2019-09-08'),
(13, 'CA/2018/003', 7, 1, 1, 1, 14, 10, 45, '2019-09-08'),
(14, 'CA/2018/003', 1, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(14, 'CA/2018/01', 1, 4, 1, 5, 0, 0, 0, '0000-00-00'),
(14, 'CA/2018/003', 2, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(14, 'CA/2018/01', 2, 4, 1, 5, 0, 0, 0, '0000-00-00'),
(14, 'CA/2018/003', 3, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(14, 'CA/2018/01', 3, 4, 1, 5, 0, 0, 0, '0000-00-00'),
(14, 'CA/2018/003', 4, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(14, 'CA/2018/01', 4, 4, 1, 5, 0, 0, 0, '0000-00-00'),
(14, 'CA/2018/003', 6, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(14, 'CA/2018/01', 6, 4, 1, 5, 0, 0, 0, '0000-00-00'),
(14, 'CA/2018/003', 7, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(14, 'CA/2018/01', 7, 4, 1, 5, 0, 0, 0, '0000-00-00'),
(15, 'CA/2018/003', 1, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(15, 'CA/2018/003', 2, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(15, 'CA/2018/003', 3, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(15, 'CA/2018/003', 4, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(15, 'CA/2018/003', 6, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(15, 'CA/2018/003', 7, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(16, 'CA/2018/003', 1, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(16, 'CA/2018/003', 2, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(16, 'CA/2018/003', 3, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(16, 'CA/2018/003', 4, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(16, 'CA/2018/003', 6, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(16, 'CA/2018/003', 7, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(17, 'CA/2018/003', 1, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(17, 'CA/2018/003', 2, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(17, 'CA/2018/003', 3, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(17, 'CA/2018/003', 4, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(17, 'CA/2018/003', 6, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(17, 'CA/2018/003', 7, 1, 2, 1, 0, 0, 0, '0000-00-00'),
(18, 'CA/2018/003', 1, 1, 3, 1, 0, 0, 0, '0000-00-00'),
(18, 'CA/2018/003', 2, 1, 3, 1, 0, 0, 0, '0000-00-00'),
(18, 'CA/2018/003', 3, 1, 3, 1, 0, 0, 0, '0000-00-00'),
(18, 'CA/2018/003', 4, 1, 3, 1, 0, 0, 0, '0000-00-00'),
(18, 'CA/2018/003', 6, 1, 3, 1, 0, 0, 0, '0000-00-00'),
(18, 'CA/2018/003', 7, 1, 3, 1, 0, 0, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `name`, `deleted`) VALUES
(1, 'English Language', 0),
(2, 'Mathematics', 0),
(3, 'Basic Science', 0),
(4, 'Yoruba', 0),
(6, 'French', 0),
(7, 'Computer Science', 0),
(8, 'Social Studies', 0);

-- --------------------------------------------------------

--
-- Table structure for table `term`
--

CREATE TABLE `term` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `term`
--

INSERT INTO `term` (`id`, `name`) VALUES
(1, 'First Term'),
(2, 'Second Term'),
(3, 'Third Term');

-- --------------------------------------------------------

--
-- Table structure for table `userrole`
--

CREATE TABLE `userrole` (
  `userid` int(11) NOT NULL,
  `roleid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userrole`
--

INSERT INTO `userrole` (`userid`, `roleid`) VALUES
(1, 'Admin Officer'),
(1, 'Class Teacher'),
(1, 'Secretary'),
(2, 'Class Teacher'),
(2, 'Secretary'),
(3, 'Secretary'),
(4, 'Class Teacher'),
(5, 'Class Teacher');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `photo` varchar(255) NOT NULL,
  `password` char(32) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `classid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `address`, `gender`, `date`, `email`, `photo`, `password`, `deleted`, `classid`) VALUES
(1, 'Hammed Taofeek', '08035297428', 'No 5 Oriire Akure', 'Male', '2012-04-01', 'htolajide@yahoo.com', 'upload/5cc0385a28c80.png', '6f3ce7bc7aeccf1e1fcfc93763d91416', 0, 1),
(2, 'Kareem Akeem', '08035297428', 'No 5 Oriire Lagos', 'Male', '2012-04-01', 'kareemakeem@yahoo.com', 'upload/5d580f440c12a.png', 'f47fda17ce8b377bc256383354087413', 0, 1),
(3, 'Omotosho Ademola', '08034567890', 'Oke Aro Lagos', 'Male', '2018-09-06', 'omotee@yahoo.com', 'upload/5cc043105859c.png', 'a7753b29c4ca4ee18932cb159824fe53', 0, 0),
(4, 'Musibau Nimot', '08034567890', 'Oriire House Lagos', 'Female', '2018-09-06', 'musibaunimota@yahoo.com', 'upload/5cc0434e3beb0.png', 'dbd3d63cb1b23b518a7ee0ec72fda888', 1, 2),
(5, 'Biodun adeoye', '08034567890', 'Iseyin lagos', 'Male', '2018-09-06', 'biodunadeoye@yahoo.com', 'upload/5cc6c224aa666.png', '2b1498bd2db3da64d2497ba07ad72e86', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disposition`
--
ALTER TABLE `disposition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pay`
--
ALTER TABLE `pay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentdisposition`
--
ALTER TABLE `studentdisposition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentskill`
--
ALTER TABLE `studentskill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentsubject`
--
ALTER TABLE `studentsubject`
  ADD PRIMARY KEY (`studentid`,`subjectid`,`sessionid`,`termid`,`classid`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `term`
--
ALTER TABLE `term`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userrole`
--
ALTER TABLE `userrole`
  ADD PRIMARY KEY (`userid`,`roleid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `disposition`
--
ALTER TABLE `disposition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `pay`
--
ALTER TABLE `pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `skill`
--
ALTER TABLE `skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `studentdisposition`
--
ALTER TABLE `studentdisposition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `studentskill`
--
ALTER TABLE `studentskill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `term`
--
ALTER TABLE `term`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
