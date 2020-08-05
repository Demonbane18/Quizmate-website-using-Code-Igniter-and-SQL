-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2019 at 08:41 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `getAnswer` (`Qid` INT) RETURNS TEXT CHARSET utf8 NO SQL
BEGIN
	DECLARE result text;
	SELECT IFNULL(IFNULL(answer_choice,answer_numeric),answer_boolean) as answer
    into @result
from question_list
    where question_id = Qid;

	IF FOUND_ROWS() > 0 THEN
		RETURN @result;
    ELSE
    	RETURN "false";
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getEnrollCount` (`courseid` INT) RETURNS INT(10) NO SQL
BEGIN

declare result int(10);
select count(course_id) as a into @result from Student_Enroll
where course_id = courseid;

return @result;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getNameFromUid` (`Uid` INT) RETURNS VARCHAR(100) CHARSET utf8 NO SQL
BEGIN
	DECLARE fullname varchar(100);
	SELECT IFNULL(IFNULL( concat(admins.name,' ',admins.lname), concat(teachers.name,' ',teachers.lname) ), concat(students.name,' ',students.lname)) as fullname
    into @fullname
from users
left join admins on (users.id = admins.id)
left join teachers on (users.id = teachers.id)
left join students on (users.id = students.id)
    where users.id = Uid;

	IF FOUND_ROWS() > 0 THEN
		RETURN @fullname;
    ELSE
    	RETURN "false";
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getScoreByPaperId` (`paperid` INT, `stuid` INT) RETURNS FLOAT NO SQL
BEGIN
declare rscore float;
SELECT Score INTO @rscore FROM Scoreboard WHERE paper_id = paperid and stu_id = stuid;

IF FOUND_ROWS() > 0 THEN
		RETURN @rscore;
    ELSE
    	RETURN null;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getStudentGroupByCourseId` (`courseid` INT, `stuid` INT) RETURNS VARCHAR(40) CHARSET utf8 NO SQL
BEGIN
declare groupname varchar(40);
SELECT name INTO @groupname FROM `Student_Enroll` se 
left join Course_Students_group csg on se.group_id = csg.group_id 
where se.course_id = courseid and se.stu_id = stuid;

return @groupname;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getSubjectIdFromCourseId` (`CourseId` INT) RETURNS INT(5) NO SQL
BEGIN
Declare ret1 INT(5);
	SELECT subject_id into @ret1
from Courses
    where course_id = CourseId;

	IF FOUND_ROWS() > 0 THEN
		RETURN @ret1;
    ELSE
    	RETURN -1;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `isHasQuestion` (`sub_id` INT) RETURNS VARCHAR(20) CHARSET utf8 NO SQL
BEGIN
	DECLARE chapter INT;
	SELECT chapter_id into @chapter from Chapter where subject_id = sub_id LIMIT 1;
	-- SET chapter = FOUND_ROWS();
	IF FOUND_ROWS() > 0 THEN
		RETURN "true";
    ELSE
    	RETURN "false";
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(10) NOT NULL,
  `id` int(8) NOT NULL,
  `name` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `pic` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `id`, `name`, `lname`, `email`, `pic`) VALUES
(1, 1, 'John Paul', 'Fusin', 'fusinjohnpaul@yahoo.com', NULL),
(2, 5, 'John Paul', 'Fusin', 'fusinjohnpaul1@yahoo.com', NULL),
(3, 6, 'John Paul', 'Fusin', 'fusinjohnpaul3@yahoo.com', NULL),
(4, 7, 'John Paul', 'Fusin1', 'fusinjohnpaul@yahoo.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `answer_papers`
--

CREATE TABLE `answer_papers` (
  `question_id` int(10) NOT NULL,
  `sco_id` int(6) NOT NULL,
  `answer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answer_papers`
--

INSERT INTO `answer_papers` (`question_id`, `sco_id`, `answer`) VALUES
(1, 10, '2010'),
(2, 10, '3'),
(3, 10, '1'),
(4, 1, '2'),
(4, 7, '4'),
(4, 8, '2'),
(5, 1, 't'),
(5, 7, 't'),
(5, 8, 't'),
(6, 1, 'f'),
(6, 7, 'f'),
(6, 8, 'f'),
(7, 1, '2'),
(7, 7, '2'),
(7, 8, '1'),
(8, 1, '4'),
(8, 7, '2'),
(8, 8, '4'),
(9, 10, 'f'),
(10, 10, '1'),
(11, 10, '555'),
(12, 10, 't'),
(13, 1, ''),
(13, 7, '4'),
(13, 8, '222222222222222222222222222'),
(14, 10, '2'),
(15, 10, '8888'),
(16, 10, 't'),
(17, 10, 'f'),
(18, 10, '44'),
(19, 10, 'f'),
(20, 10, 't'),
(21, 10, '3'),
(23, 2, '3'),
(23, 6, '3'),
(23, 11, '3'),
(23, 13, '2'),
(23, 14, '1'),
(23, 15, '3'),
(23, 17, '3'),
(23, 18, '2'),
(24, 2, '2'),
(24, 6, '3'),
(24, 11, '1'),
(24, 13, '2'),
(24, 14, '2'),
(24, 15, '2'),
(24, 17, '2'),
(24, 18, '3'),
(25, 2, '3'),
(25, 6, '3'),
(25, 11, '3'),
(25, 13, '1'),
(25, 14, '4'),
(25, 15, '3'),
(25, 17, '3'),
(25, 18, '2'),
(26, 2, '3'),
(26, 6, '1'),
(26, 11, '1'),
(26, 13, '1'),
(26, 14, '4'),
(26, 15, '4'),
(26, 17, '2'),
(26, 18, '4'),
(27, 2, '3'),
(27, 6, '2'),
(27, 11, '1'),
(27, 13, '2'),
(27, 15, '3'),
(27, 17, '2'),
(27, 18, '4'),
(28, 2, '1'),
(28, 6, '1'),
(28, 11, '1'),
(28, 13, '1'),
(28, 15, '4'),
(28, 17, '3'),
(28, 18, '2'),
(29, 2, '4'),
(29, 6, '4'),
(29, 11, '4'),
(29, 13, '4'),
(29, 14, '2'),
(29, 15, '4'),
(29, 17, '4'),
(29, 18, '4'),
(30, 2, '2'),
(30, 6, '2'),
(30, 11, '4'),
(30, 13, '1'),
(30, 14, '2'),
(30, 15, '2'),
(30, 17, '2'),
(30, 18, '2'),
(31, 2, '3'),
(31, 6, '2'),
(31, 11, '2'),
(31, 13, '2'),
(31, 14, '3'),
(31, 15, '2'),
(31, 17, '4'),
(31, 18, '2'),
(32, 2, '4'),
(32, 6, '1'),
(32, 11, '1'),
(32, 13, '3'),
(32, 14, '1'),
(32, 15, '3'),
(32, 17, '3'),
(32, 18, '2'),
(33, 3, '3'),
(33, 5, '1'),
(34, 3, '4'),
(34, 5, '1'),
(35, 3, '3'),
(35, 5, '3'),
(36, 3, '4'),
(36, 5, '4'),
(37, 3, '1'),
(37, 5, '2'),
(38, 3, '1'),
(38, 5, '1'),
(39, 3, '2'),
(39, 5, '3'),
(40, 3, '1'),
(40, 5, '3'),
(41, 3, '1'),
(41, 5, '1'),
(42, 3, '4'),
(42, 5, '4'),
(43, 4, 't'),
(43, 9, 't'),
(43, 12, 't'),
(43, 19, 'f'),
(44, 4, 't'),
(44, 9, 't'),
(44, 12, 't'),
(44, 19, 'f'),
(45, 4, 'f'),
(45, 9, 't'),
(45, 12, 'f'),
(45, 19, 't'),
(46, 4, 'f'),
(46, 9, 'f'),
(46, 12, 't'),
(46, 19, 'f'),
(47, 4, 'f'),
(47, 9, 't'),
(47, 12, 'f'),
(47, 19, 'f'),
(48, 4, 't'),
(48, 9, 'f'),
(48, 12, 't'),
(48, 19, 't'),
(49, 4, 't'),
(49, 9, 'f'),
(49, 12, 't'),
(49, 19, 't'),
(50, 4, 't'),
(50, 9, 't'),
(50, 12, 't'),
(50, 19, 't'),
(53, 4, '1'),
(53, 9, '1'),
(53, 12, '1'),
(53, 19, '4'),
(54, 4, '4'),
(54, 9, '4'),
(54, 12, '4'),
(54, 19, '4'),
(55, 4, '4'),
(55, 9, '4'),
(55, 12, '4'),
(55, 19, '3'),
(56, 4, '3'),
(56, 9, '2'),
(56, 12, '3'),
(56, 19, '3'),
(57, 4, '2'),
(57, 9, '2'),
(57, 12, '2'),
(57, 19, '4'),
(80, 16, '3'),
(81, 16, '2'),
(82, 16, '2'),
(83, 16, '4'),
(84, 16, '2'),
(85, 16, '3'),
(86, 16, '2'),
(87, 16, '2'),
(88, 16, '2'),
(89, 16, '3'),
(90, 16, '1'),
(91, 16, '2'),
(92, 16, '3'),
(93, 16, '3'),
(94, 16, '2'),
(95, 16, '3'),
(96, 16, '1'),
(97, 16, '2'),
(98, 16, '3'),
(99, 16, '2'),
(100, 21, '3'),
(100, 22, '2'),
(101, 21, '1'),
(101, 22, '1'),
(101, 24, '1'),
(102, 21, 't'),
(102, 22, 't'),
(103, 21, 't'),
(103, 22, 't'),
(104, 24, '1');

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

CREATE TABLE `chapter` (
  `chapter_id` int(7) NOT NULL,
  `name` varchar(60) NOT NULL,
  `description` text DEFAULT NULL,
  `subject_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `chapter`
--

INSERT INTO `chapter` (`chapter_id`, `name`, `description`, `subject_id`) VALUES
(4, 'บทที่ 1', NULL, 1),
(5, 'บทที่ 2', NULL, 1),
(7, 'บทที่ 1 แนะนำ OOP', NULL, 2),
(8, 'บทที่ 2 Class', NULL, 2),
(9, 'บทที่ 3', NULL, 1),
(10, 'Chapter 1', NULL, 4),
(11, 'เรื่อง ระบบย่อยอาหาร', NULL, 6),
(12, 'การจัดเรียงอิเล็กตรอนในระดับพลังงานต่างๆ', NULL, 7),
(13, 'การตลาดระดับโลก ถูกผิด', NULL, 8),
(14, 'การตลาดระดับโลก ปรนัย', NULL, 8),
(15, 'reading comprehension', NULL, 9),
(16, 'การเจริญเติบโตของร่างกาย', NULL, 6),
(17, 'กีฬาเทควันโด', NULL, 10),
(18, 'บทที่  1', NULL, 3),
(19, 'บทที่ 2', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(50) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) DEFAULT NULL,
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('5c268f76f54c9ff517a88e6546fdf321', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 1571462951, ''),
('dc0f435f892b0863d871fc9b38c7c181', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 1571462656, ''),
('eb5e88a08e8a4189ef3249478819e889', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 1571467184, 'a:11:{s:9:\"user_data\";s:0:\"\";s:2:\"id\";s:1:\"5\";s:3:\"uid\";s:1:\"2\";s:8:\"username\";s:5:\"test2\";s:8:\"fullname\";s:15:\"John Paul Fusin\";s:5:\"fname\";s:9:\"John Paul\";s:5:\"lname\";s:5:\"Fusin\";s:4:\"role\";s:5:\"admin\";s:6:\"logged\";b:1;s:16:\"flash:old:noAnim\";b:1;s:18:\"flash:old:msg_info\";s:7:\"Updated\";}');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(4) NOT NULL,
  `year` varchar(4) NOT NULL DEFAULT '',
  `pwd` varchar(20) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `status` varchar(20) NOT NULL,
  `subject_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `year`, `pwd`, `visible`, `status`, `subject_id`) VALUES
(1, '2014', NULL, 1, 'active', 1),
(2, '2014', '12345', 1, 'active', 2),
(3, '2014', NULL, 0, 'inactive', 4),
(4, '2014', NULL, 1, 'active', 6),
(5, '2014', NULL, 1, 'active', 7),
(6, '2014', NULL, 1, 'active', 8),
(7, '2014', NULL, 1, 'active', 9),
(8, '2014', NULL, 1, 'active', 10),
(9, '2014', NULL, 1, 'active', 2),
(10, '2014', NULL, 1, 'active', 3);

-- --------------------------------------------------------

--
-- Stand-in structure for view `coursesbystudents`
-- (See below for the actual view)
--
CREATE TABLE `coursesbystudents` (
`stu_id` varchar(10)
,`course_id` int(4)
,`subject_id` int(5)
,`group_id` int(6)
,`year` varchar(4)
,`visible` tinyint(1)
,`status` varchar(20)
,`code` varchar(10)
,`name` varchar(60)
,`shortname` varchar(15)
,`description` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `courseslist_view`
-- (See below for the actual view)
--
CREATE TABLE `courseslist_view` (
`course_id` int(4)
,`subject_id` int(5)
,`code` varchar(10)
,`year` varchar(4)
,`name` varchar(60)
,`shortname` varchar(15)
,`description` text
,`visible` tinyint(1)
,`status` varchar(20)
);

-- --------------------------------------------------------

--
-- Table structure for table `course_students_group`
--

CREATE TABLE `course_students_group` (
  `group_id` int(6) NOT NULL,
  `name` varchar(40) NOT NULL,
  `description` text DEFAULT NULL,
  `course_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course_students_group`
--

INSERT INTO `course_students_group` (`group_id`, `name`, `description`, `course_id`) VALUES
(1, 'Sec 1', NULL, 1),
(11, 'group1', '', 2),
(13, 'Sci.p 1', '', 5),
(14, 'GM', '', 6),
(20, 'TOEIC 1', 'ENGLISH', 7);

-- --------------------------------------------------------

--
-- Table structure for table `exam_papers`
--

CREATE TABLE `exam_papers` (
  `paper_id` int(7) NOT NULL,
  `title` varchar(70) NOT NULL,
  `description` text DEFAULT NULL,
  `rules` text DEFAULT NULL,
  `semester` varchar(10) NOT NULL,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `course_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exam_papers`
--

INSERT INTO `exam_papers` (`paper_id`, `title`, `description`, `rules`, `semester`, `starttime`, `endtime`, `visible`, `status`, `course_id`) VALUES
(12, 'TOEIC TEST', 'Reading Comprehension', '60 minutes for testing', '1', '2019-10-18 09:00:00', '2019-10-20 22:00:00', 1, 'active', 7),
(18, 'test', 'test', 'dada', '', '2019-10-19 13:25:00', '2019-10-19 13:25:00', 1, 'active', 7);

-- --------------------------------------------------------

--
-- Table structure for table `exam_papers_detail`
--

CREATE TABLE `exam_papers_detail` (
  `question_id` int(10) NOT NULL,
  `part_id` int(7) NOT NULL,
  `paper_id` int(7) NOT NULL,
  `no` tinyint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exam_papers_detail`
--

INSERT INTO `exam_papers_detail` (`question_id`, `part_id`, `paper_id`, `no`) VALUES
(1, 1, 1, 1),
(1, 9, 8, 1),
(2, 1, 1, 2),
(2, 8, 8, 2),
(3, 1, 1, 7),
(3, 8, 8, 7),
(4, 5, 6, 1),
(4, 7, 7, 1),
(5, 5, 6, 2),
(5, 7, 7, 2),
(6, 6, 6, 1),
(6, 7, 7, 1),
(7, 6, 6, 2),
(7, 7, 7, 2),
(8, 7, 7, 1),
(9, 1, 1, 6),
(11, 1, 1, 5),
(11, 9, 8, 5),
(12, 1, 1, 3),
(13, 5, 6, 3),
(13, 7, 7, 3),
(14, 8, 8, 1),
(15, 1, 1, 8),
(15, 9, 8, 8),
(18, 1, 1, 9),
(20, 1, 1, 4),
(21, 9, 8, 1),
(23, 13, 9, 1),
(23, 19, 13, 1),
(24, 13, 9, 2),
(24, 19, 13, 2),
(25, 13, 9, 4),
(25, 19, 13, 4),
(26, 13, 9, 3),
(26, 19, 13, 3),
(27, 13, 9, 5),
(27, 19, 13, 5),
(28, 13, 9, 6),
(28, 19, 13, 6),
(29, 13, 9, 7),
(29, 19, 13, 7),
(30, 13, 9, 8),
(30, 19, 13, 8),
(31, 13, 9, 9),
(31, 19, 13, 9),
(32, 13, 9, 10),
(32, 19, 13, 10),
(33, 15, 10, 1),
(34, 15, 10, 2),
(35, 15, 10, 3),
(36, 15, 10, 4),
(37, 15, 10, 5),
(38, 15, 10, 6),
(39, 15, 10, 7),
(40, 15, 10, 8),
(41, 15, 10, 9),
(42, 15, 10, 10),
(43, 16, 11, 1),
(44, 16, 11, 2),
(45, 16, 11, 3),
(46, 16, 11, 4),
(47, 16, 11, 5),
(48, 16, 11, 6),
(49, 16, 11, 7),
(50, 16, 11, 8),
(53, 17, 11, 1),
(54, 17, 11, 2),
(55, 17, 11, 3),
(56, 17, 11, 4),
(57, 17, 11, 5),
(58, 18, 12, 1),
(59, 18, 12, 2),
(60, 18, 12, 3),
(61, 18, 12, 4),
(62, 18, 12, 5),
(63, 18, 12, 6),
(64, 18, 12, 7),
(65, 18, 12, 8),
(66, 18, 12, 9),
(67, 18, 12, 10),
(68, 18, 12, 11),
(69, 18, 12, 12),
(80, 20, 15, 1),
(81, 20, 15, 2),
(82, 20, 15, 3),
(83, 20, 15, 4),
(84, 20, 15, 5),
(85, 20, 15, 6),
(86, 20, 15, 7),
(87, 20, 15, 8),
(88, 20, 15, 9),
(89, 20, 15, 10),
(90, 20, 15, 11),
(91, 20, 15, 12),
(92, 20, 15, 13),
(93, 20, 15, 14),
(94, 20, 15, 15),
(95, 20, 15, 16),
(96, 20, 15, 17),
(97, 20, 15, 18),
(98, 20, 15, 19),
(99, 20, 15, 20),
(101, 29, 17, 0),
(102, 27, 16, 1),
(103, 27, 16, 2);

-- --------------------------------------------------------

--
-- Table structure for table `exam_papers_parts`
--

CREATE TABLE `exam_papers_parts` (
  `part_id` int(7) NOT NULL,
  `no` tinyint(3) NOT NULL,
  `type` varchar(10) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` text DEFAULT NULL,
  `israndom` tinyint(1) NOT NULL,
  `paper_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exam_papers_parts`
--

INSERT INTO `exam_papers_parts` (`part_id`, `no`, `type`, `title`, `description`, `israndom`, `paper_id`) VALUES
(18, 1, '', 'reading comprehension', '', 0, 12);

-- --------------------------------------------------------

--
-- Table structure for table `log_usage`
--

CREATE TABLE `log_usage` (
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `uid` int(6) NOT NULL,
  `action` text NOT NULL,
  `ipaddress` varchar(128) NOT NULL,
  `iphostname` varchar(128) NOT NULL,
  `iplocal` varchar(128) NOT NULL,
  `useragent` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(10) NOT NULL,
  `question` text NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `created_time` datetime NOT NULL DEFAULT current_timestamp(),
  `chapter_id` int(7) NOT NULL,
  `created_by_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question`, `type`, `status`, `created_time`, `chapter_id`, `created_by_id`) VALUES
(58, '<p>Small computer software company is looking for an office manager .College degree not required, but applicant must have at least two year experience at a similar job. Call Ms. Chang (director) at 348-555-0987. <span style=\"line-height:1.6em;\">What kind of job is advertised ?</span></p>', 'choice', 'inuse', '2014-12-06 23:41:04', 15, 64),
(59, '<p>Small computer software company is looking for an office manager .College degree not required, but applicant must have at least two year experience at a similar job. Call Ms. Chang (director) at 348-555-0987. What is a requirement for this job ?</p>', 'choice', 'inuse', '2014-12-06 23:44:11', 15, 64),
(60, '<p style=\"text-align:center;\"><strong>OFFICE SUPPLY SALE</strong></p>\n\n<p style=\"text-align:center;\"><strong>This week only</strong></p>\n\n<ul><li>Computer paper (white only) 25 %</li>\n	<li>Envelopes (all colors, including pink, purple, and gold) 50 %</li>\n	<li>Notebooks-buy five, get one free</li>\n	<li>Pens (blue,back.and red ink) 12 for 1 USD</li>\n</ul><p style=\"text-align:center;\"><strong>Sale ends Saturday</strong></p>\n\n<p><strong>What kind of computer paper is on sale?</strong></p>', 'choice', 'inuse', '2014-12-06 23:53:54', 15, 64),
(61, '<p style=\"text-align:center;\"><strong>OFFICE SUPPLY SALE</strong></p>\n\n<p style=\"text-align:center;\"><strong>This week only</strong></p>\n\n<ul><li>Computer paper (white only) 25 %</li>\n	<li>Envelopes (all colors, including pink, purple, and gold) 50 %</li>\n	<li>Notebooks-buy five, get one free</li>\n	<li>Pens (blue,back.and red ink) 12 for 1 USD</li>\n</ul><p style=\"text-align:center;\"><strong>Sale ends Saturday</strong></p>\n\n<p><strong>How can you get a free notebook ?</strong></p>', 'choice', 'inuse', '2014-12-06 23:56:50', 15, 64),
(62, '<p style=\"text-align:center;\"><strong>OFFICE SUPPLY SALE</strong></p>\n\n<p style=\"text-align:center;\"><strong>This week only</strong></p>\n\n<ul><li>Computer paper (white only) 25 %</li>\n	<li>Envelopes (all colors, including pink, purple, and gold) 50 %</li>\n	<li>Notebooks-buy five, get one free</li>\n	<li>Pens (blue,back.and red ink) 12 for 1 USD</li>\n</ul><p style=\"text-align:center;\"><strong>Sale ends Saturday</strong></p>\n\n<p><strong>When is the sale ?</strong></p>', 'choice', 'inuse', '2014-12-06 23:58:42', 15, 64),
(63, '<p style=\"text-align:center;\">CITY ZOO</p>\n\n<p><img alt=\"\" src=\"http://192.168.1.9/oxproject/vendor/js/plugins/ckeditor/plugins/uploads/capture-20141207-000838.png\" style=\"height:209px;width:485px;\" /></p>\n\n<p>How many people visited the zoo in February?</p>', 'choice', 'inuse', '2014-12-07 00:16:54', 15, 64),
(64, '<p style=\"text-align:center;\">CITY ZOO</p>\n\n<p><img alt=\"\" src=\"http://192.168.1.9/oxproject/vendor/js/plugins/ckeditor/plugins/uploads/capture-20141207-000838.png\" style=\"height:209px;width:485px;\" /></p>\n\n<p>When did 4,980 people visit the zoo?</p>', 'choice', 'inuse', '2014-12-07 00:18:40', 15, 64),
(65, '<p style=\"text-align:center;\">CITY ZOO</p>\n\n<p><img alt=\"\" src=\"http://192.168.1.9/oxproject/vendor/js/plugins/ckeditor/plugins/uploads/capture-20141207-000838.png\" style=\"height:209px;width:485px;\" /></p>\n\n<p>Which was the most popular month to visit the zoo?</p>', 'choice', 'inuse', '2014-12-07 00:20:09', 15, 64),
(66, '<p><img alt=\"\" src=\"vendor/js/plugins/ckeditor/plugins/uploads/capture-20141207-003144.jpg\" style=\"height:300px;width:454px;\" /></p><p>Where will Brianna Herbert be next week?</p>', 'choice', 'inuse', '2014-12-07 00:37:21', 15, 64),
(67, '<p><img alt=\"\" src=\"vendor/js/plugins/ckeditor/plugins/uploads/capture-20141207-003144.jpg\" style=\"height:300px;width:454px;\" /></p><p>Who is Sherry Noyes?</p>', 'choice', 'inuse', '2014-12-07 00:41:22', 15, 64),
(68, '<p><img alt=\"\" src=\"vendor/js/plugins/ckeditor/plugins/uploads/capture-20141207-003144.jpg\" style=\"height:300px;width:454px;\" /></p><p>The word \"<u>contact</u>\" in  the line 8 is closest in meaning to...</p>', 'choice', 'inuse', '2014-12-07 00:43:50', 15, 64),
(69, '<p><img alt=\"\" src=\"vendor/js/plugins/ckeditor/plugins/uploads/capture-20141207-003144.jpg\" style=\"height:300px;width:454px;\" /></p><p>Who should read the memo?</p>', 'choice', 'inuse', '2014-12-07 00:46:32', 15, 64),
(102, '<p>2+3 = 5</p>', 'boolean', 'inuse', '2014-12-17 09:55:33', 19, 3),
(103, '<p>3+3 = 10</p>', 'boolean', 'inuse', '2014-12-17 09:55:52', 19, 3),
(104, '<p>22+1 = ?</p>', 'choice', 'inuse', '2014-12-22 16:09:53', 18, 3);

-- --------------------------------------------------------

--
-- Table structure for table `question_boolean`
--

CREATE TABLE `question_boolean` (
  `id` int(10) NOT NULL,
  `answer` varchar(20) NOT NULL,
  `question_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `question_boolean`
--

INSERT INTO `question_boolean` (`id`, `answer`, `question_id`) VALUES
(1, 't', 5),
(2, 'f', 6),
(3, 't', 9),
(4, 't', 12),
(5, 'f', 16),
(6, 't', 17),
(7, 't', 19),
(8, 't', 20),
(9, 't', 43),
(10, 't', 44),
(11, 'f', 45),
(12, 'f', 46),
(13, 'f', 47),
(14, 't', 48),
(15, 't', 49),
(16, 't', 50),
(17, 't', 51),
(18, 't', 52),
(19, 't', 102),
(20, 'f', 103);

-- --------------------------------------------------------

--
-- Table structure for table `question_choice`
--

CREATE TABLE `question_choice` (
  `id` int(10) NOT NULL,
  `choice1` text NOT NULL,
  `choice2` text NOT NULL,
  `choice3` text DEFAULT NULL,
  `choice4` text DEFAULT NULL,
  `choice5` text DEFAULT NULL,
  `choice6` text DEFAULT NULL,
  `answer` varchar(20) NOT NULL,
  `question_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `question_choice`
--

INSERT INTO `question_choice` (`id`, `choice1`, `choice2`, `choice3`, `choice4`, `choice5`, `choice6`, `answer`, `question_id`) VALUES
(1, 'aaaa', 'bbbb', 'cccc', 'dddd', '', '', '1', 2),
(2, 'HTML', 'C#.NET', 'PHP', 'MySQL', '', '', '3', 3),
(3, 'Public', 'Function', 'Attribute', 'ถูกทุกข้อ', '', '', '2', 4),
(4, 'Private', 'Public', 'Protected', 'Void', '', '', '2', 7),
(5, '5656', '7404', '', '', '', '', '2', 10),
(6, 'a', 'b', 'c', 'd', '', '', '1', 14),
(7, 'rtte', 'ere', 'fgsdf', 'dfg', '', '', '3', 22),
(19, '2n^2', '2n^3', '2n^5', '2n^7', '', '', '2', 34),
(20, '2', '8', '18', '32', '', '', '3', 35),
(21, '2  2  4', '2  4  5', '1  2  8', '2  8  1', '', '', '4', 36),
(22, '2  8  10', '2  8  8  2', '2  8  2  8', '2  8  9  1', '', '', '2', 37),
(23, 's p d f', 's p d y', 's d p f', 's d p y', '', '', '1', 38),
(24, '1s^0 2s^2', '1s^0 2s^1 2s^2', '1s^2 2s^1', '1s^1 2s^3', '', '', '3', 39),
(25, '1s^2 2s^2 2s^4', '1s^1 2s^2 3s^5', '1s^1 2s^2 2p^5', '1s^2 2s^2 2p^4', '', '', '4', 40),
(27, '2', '16', '18', '32', '', '', '4', 42),
(32, 'Mexico', 'Italy', 'Turkey', 'Indonesia', 'Nigeria', '', '2', 57),
(33, 'Director of a computer company', 'Office manager', 'Computer programmer', 'College professor', '', '', '2', 58),
(34, 'A college degree', 'Less than two years experience', 'Telephone skills', 'Two or more years experience', '', '', '4', 59),
(35, 'White', 'All colors', 'Pink, purple,and gold', 'Red,blue, and black', '', '', '1', 60),
(36, 'Pay one dollar', 'Spend 25 USD on computer paper', 'Buy colored envelopes', 'Buy five notebooks', '', '', '4', 61),
(37, 'All weekend', 'On Sunday only', 'All week', 'On Saturday only', '', '', '3', 62),
(38, '4,000', '4,500', '4,675', '5,000', '', '', '2', 63),
(39, 'March', 'April', 'May', 'June', '', '', '2', 64),
(40, 'March', 'April', 'May', 'June', '', '', '3', 65),
(41, 'In the office', 'At a conference', 'On vacation', 'At the XYZ Company', '', '', '2', 66),
(42, 'An  accountant', 'The writer of the memo', 'The owner of the XYZ Company', 'Brianna Herbert\'s assistant', '', '', '4', 67),
(43, 'work with', 'call', 'touch', 'look at', '', '', '2', 68),
(44, 'All staff at the XYZ company', 'Brianna Herbert', 'People who work in the accounting department', 'Conference planners', '', '', '3', 69),
(55, '1971', '1972', '1973', '1974', '', '', '3', 80),
(63, 'Front Kick', 'Side Kick', 'Round House Kick', 'Chop Kick', '', '', '4', 88),
(64, 'Front Kick', 'Side Kick', 'Round House Kick', 'Chop Kick', '', '', '2', 89),
(65, 'Front Kick', 'Side Kick', 'Round House Kick', 'Chop Kick', '', '', '1', 90),
(72, 'Takkwon + Kongsoodo', 'Takkyon + Kongsondo', 'Takkwon + Kongsondo', 'Takkyon + Kongsoodo', '', '', '4', 97),
(75, '10', '0', '7', '50', '', '', '1', 101),
(76, '23', '24', '25', '26', '27', '28', '1', 104);

-- --------------------------------------------------------

--
-- Stand-in structure for view `question_detail_list`
-- (See below for the actual view)
--
CREATE TABLE `question_detail_list` (
`paper_id` int(7)
,`part_id` int(7)
,`no` tinyint(3)
,`question_id` int(10)
,`question` text
,`type` varchar(10)
,`status` varchar(10)
,`chapter_id` int(7)
,`created_by` varchar(100)
,`created_time` datetime
,`choice1` text
,`choice2` text
,`choice3` text
,`choice4` text
,`choice5` text
,`choice6` text
,`answer_choice` varchar(20)
,`answer_numeric` varchar(20)
,`answer_boolean` varchar(20)
,`chapter_name` varchar(60)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `question_list`
-- (See below for the actual view)
--
CREATE TABLE `question_list` (
`question_id` int(10)
,`question` text
,`type` varchar(10)
,`status` varchar(10)
,`chapter_id` int(7)
,`created_by` varchar(100)
,`created_time` datetime
,`choice1` text
,`choice2` text
,`choice3` text
,`choice4` text
,`choice5` text
,`choice6` text
,`answer_choice` varchar(20)
,`answer_numeric` varchar(20)
,`answer_boolean` varchar(20)
,`chapter_name` varchar(60)
);

-- --------------------------------------------------------

--
-- Table structure for table `question_numerical`
--

CREATE TABLE `question_numerical` (
  `id` int(10) NOT NULL,
  `answer` varchar(20) NOT NULL,
  `question_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `question_numerical`
--

INSERT INTO `question_numerical` (`id`, `answer`, `question_id`) VALUES
(1, '2010', 1),
(2, '4', 8),
(3, '2', 11),
(4, '4234234', 13),
(5, '29311', 15),
(6, '22222', 18),
(7, '3', 21),
(8, '3', 100),
(9, '3', 105);

-- --------------------------------------------------------

--
-- Stand-in structure for view `report_courses`
-- (See below for the actual view)
--
CREATE TABLE `report_courses` (
`course_id` int(4)
,`subject_id` int(5)
,`code` varchar(10)
,`year` varchar(4)
,`name` varchar(60)
,`shortname` varchar(15)
,`description` text
,`visible` tinyint(1)
,`status` varchar(20)
,`examcount` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `report_course_calc`
-- (See below for the actual view)
--
CREATE TABLE `report_course_calc` (
`course_id` int(4)
,`subject_id` int(5)
,`code` varchar(10)
,`year` varchar(4)
,`subjectname` varchar(60)
,`shortname` varchar(15)
,`papername` varchar(70)
,`starttime` datetime
,`endtime` datetime
,`visible` tinyint(1)
,`status` varchar(20)
,`paper_id` int(7)
,`enrollcount` int(10)
,`testedcount` bigint(21)
,`average` double
,`minimum` float
,`maximum` float
);

-- --------------------------------------------------------

--
-- Table structure for table `scoreboard`
--

CREATE TABLE `scoreboard` (
  `sco_id` int(6) NOT NULL,
  `stu_id` int(10) NOT NULL,
  `course_id` int(4) NOT NULL,
  `paper_id` int(7) NOT NULL,
  `Score` float DEFAULT NULL,
  `Max` float DEFAULT NULL,
  `Min` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `scoreboard`
--

INSERT INTO `scoreboard` (`sco_id`, `stu_id`, `course_id`, `paper_id`, `Score`, `Max`, `Min`) VALUES
(1, 54310104, 2, 6, 5, NULL, NULL),
(2, 54310104, 4, 9, 8, NULL, NULL),
(3, 54310104, 5, 10, 5, NULL, NULL),
(4, 54311095, 6, 11, 13, NULL, NULL),
(5, 54311095, 5, 10, 7, NULL, NULL),
(6, 54311095, 4, 9, 7, NULL, NULL),
(7, 54311095, 2, 6, 3, NULL, NULL),
(8, 54311095, 2, 7, 4, NULL, NULL),
(9, 57700188, 6, 11, 8, NULL, NULL),
(10, 57700188, 1, 1, 4, NULL, NULL),
(11, 57700188, 4, 9, 6, NULL, NULL),
(12, 57700189, 6, 11, 12, NULL, NULL),
(13, 57700189, 4, 9, 4, NULL, NULL),
(14, 57700190, 4, 9, 4, NULL, NULL),
(15, 54310104, 4, 13, 6, NULL, NULL),
(16, 54311095, 8, 15, 9, NULL, NULL),
(17, 57700192, 4, 13, 5, NULL, NULL),
(18, 57700196, 4, 13, 2, NULL, NULL),
(19, 57700193, 6, 11, 7, NULL, NULL),
(20, 54310104, 6, 11, 0, NULL, NULL),
(21, 54310104, 10, 16, 3, NULL, NULL),
(22, 54311095, 10, 16, 2, NULL, NULL),
(24, 54310104, 10, 17, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `stu_id` varchar(10) NOT NULL,
  `id` int(8) NOT NULL,
  `title` varchar(20) NOT NULL,
  `name` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `birth` date DEFAULT NULL,
  `gender` enum('male','female') NOT NULL,
  `idcard` varchar(13) DEFAULT NULL,
  `year` int(4) NOT NULL,
  `fac_id` varchar(50) NOT NULL,
  `branch_id` varchar(50) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `pic` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`stu_id`, `id`, `title`, `name`, `lname`, `birth`, `gender`, `idcard`, `year`, `fac_id`, `branch_id`, `email`, `pic`) VALUES
('1710015', 2, 'Mr.', 'Caloy', 'Montes', '1992-09-14', 'male', NULL, 2015, 'Computer Engineering', 'TIP-Manila', 'cmontes@gmail.com', NULL),
('jasper1', 77, '', 'Jasper', 'Ballesteros', '1998-01-24', 'male', NULL, 2019, 'Computer Engineering', 'TIP-Manila', 'jballesteros@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_enroll`
--

CREATE TABLE `student_enroll` (
  `stu_id` varchar(10) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `group_id` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student_enroll`
--

INSERT INTO `student_enroll` (`stu_id`, `course_id`, `group_id`) VALUES
('1710015', '7', 20),
('54310104', '1', 1),
('54310104', '10', 19),
('54310104', '2', 11),
('54310104', '4', 12),
('54310104', '5', 13),
('54310104', '6', 14),
('54311095', '10', 18),
('54311095', '2', 11),
('54311095', '4', 12),
('54311095', '5', 13),
('54311095', '6', 14),
('54311095', '8', 17),
('57700188', '1', 1),
('57700188', '4', 12),
('57700188', '6', 14),
('57700189', '4', 12),
('57700189', '6', 14),
('57700190', '4', 12),
('57700191', '4', 12),
('57700192', '4', 12),
('57700192', '5', 13),
('57700192', '8', 17),
('57700193', '4', 12),
('57700193', '6', 14),
('57700194', '1', 9),
('57700194', '4', 12),
('57700194', '6', 14),
('57700195', '4', 12),
('57700196', '4', 12),
('57700196', '5', 13),
('57700196', '8', 17),
('57700197', '1', 9),
('57700197', '10', 18),
('57700197', '4', 12),
('57700198', '4', 12),
('57700198', '5', 13),
('57700199', '4', 12),
('57700200', '4', 12),
('57700200', '5', 13),
('58700101', '4', 12),
('58700101', '5', 13),
('58700105', '4', 12),
('58700105', '5', 13),
('58700112', '4', 12),
('58700115', '10', 18),
('58700115', '4', 12),
('58700115', '5', 13),
('58700115', '6', 14),
('58700120', '4', 12),
('58700121', '4', 12),
('58700121', '6', 14),
('58700127', '1', 9),
('58700127', '10', 18),
('58700127', '4', 12),
('58700133', '4', 12),
('58700133', '6', 14),
('58700135', '1', 1),
('58700135', '4', 12),
('58700135', '6', 14),
('58700140', '1', 1),
('58700140', '4', 12),
('58700140', '6', 14),
('58700141', '4', 12),
('58700141', '5', 13),
('58700156', '4', 12),
('58700157', '1', 9),
('58700157', '4', 12),
('58700157', '6', 14);

-- --------------------------------------------------------

--
-- Table structure for table `student_group_paper`
--

CREATE TABLE `student_group_paper` (
  `group_id` int(6) NOT NULL,
  `paper_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student_group_paper`
--

INSERT INTO `student_group_paper` (`group_id`, `paper_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(5) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(60) NOT NULL,
  `shortname` varchar(15) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `code`, `name`, `shortname`, `description`, `status`) VALUES
(9, '271232', 'English for Standardized Tests', 'TOEIC', 'Language patterns, test structures, grammar and vocabularies, reading excerpts, conversation styles and dialogues, and statements, commonly used in standardized tests\r\n', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `tea_id` int(10) NOT NULL,
  `id` int(8) NOT NULL,
  `name` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `fac_id` varchar(50) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `pic` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`tea_id`, `id`, `name`, `lname`, `fac_id`, `email`, `pic`) VALUES
(1, 4, 'Gelo', 'Atienza', 'Computer Engineering', 'gelly@gmail.com', NULL),
(2, 3, 'William', 'Smith', 'Industrial Engineering', 'willsmith@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_course_detail`
--

CREATE TABLE `teacher_course_detail` (
  `tea_id` int(10) NOT NULL,
  `course_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teacher_course_detail`
--

INSERT INTO `teacher_course_detail` (`tea_id`, `course_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(1, 8),
(2, 2),
(2, 10),
(3, 1),
(3, 10),
(4, 10),
(5, 4),
(5, 5),
(5, 6);

-- --------------------------------------------------------

--
-- Stand-in structure for view `upcomingtest`
-- (See below for the actual view)
--
CREATE TABLE `upcomingtest` (
`stu_id` varchar(10)
,`group_id` int(6)
,`paper_id` int(7)
,`course_id` varchar(10)
,`papertitle` varchar(70)
,`paperdesc` text
,`rules` text
,`starttime` datetime
,`endtime` datetime
,`subject_id` int(5)
,`code` varchar(10)
,`subjectname` varchar(60)
,`shortname` varchar(15)
,`subjectdesc` varchar(60)
,`status` varchar(20)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(8) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `status`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'active'),
(2, '54310104', '81dc9bdb52d04dc20036dbd8313ed055', 'student', 'active'),
(3, 'uraiwan', '81dc9bdb52d04dc20036dbd8313ed055', 'teacher', 'active'),
(4, 'sombut', '81dc9bdb52d04dc20036dbd8313ed055', 'teacher', 'active'),
(5, 'test2', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'active'),
(6, 'admin2', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'active'),
(7, 'admin3', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'inactive'),
(8, 'teacher', '81dc9bdb52d04dc20036dbd8313ed055', 'teacher', 'active'),
(9, 'orawan', '81dc9bdb52d04dc20036dbd8313ed055', 'teacher', 'active'),
(36, '57700188', '65350653c9baf66a82bd3eff3719e59c', 'student', 'active'),
(37, '57700189', '0d4a6549dcb0ee35ecb006d7f88a8b2d', 'student', 'active'),
(38, '57700190', '950e657b21be908c22477b92a55b362d', 'student', 'active'),
(39, '57700191', '281c939e1a1effb80020d274e3081c5c', 'student', 'active'),
(40, '57700192', 'ca2ce83788f3b73b90438e3de06897a2', 'student', 'active'),
(41, '57700193', '7a727f46360a98be4658156ace52d893', 'student', 'active'),
(42, '57700194', '3d9386dd7bc38e0420fd406f260e62aa', 'student', 'active'),
(43, '57700195', 'e26414761bb8fc0b74b0c1c423bcfd87', 'student', 'active'),
(44, '57700196', '6bf3de8a868cddc20513157179248624', 'student', 'active'),
(45, '57700197', 'add7099ea46b393dbcea34a0d59b3826', 'student', 'active'),
(46, '57700198', 'e597b2bc6e556a570aa57dc8c9504341', 'student', 'active'),
(47, '57700199', 'b2e894fca115093e29131568c984a574', 'student', 'active'),
(48, '57700200', '9a16c63a88acdda4057bd1516ace2d4f', 'student', 'active'),
(50, '58700101', '67d2ce973dfe2aec3279d8e957cce9f9', 'student', 'active'),
(51, '58700105', '9e5433b81ee5c5912cfe934b84b74e73', 'student', 'active'),
(52, '58700112', '341f4eb75f1a53e1f6ddcc470f933e70', 'student', 'active'),
(53, '58700115', 'd1bdc133b4784098c686b0c5ca1ea00d', 'student', 'active'),
(54, '58700120', '1cc25c938d648d6e4fda4775c17413e0', 'student', 'active'),
(55, '58700121', '9c51a68150d03bb11b475fc0973cd373', 'student', 'active'),
(56, '58700127', '3a302f28028a573242054324089dc0ce', 'student', 'active'),
(57, '58700133', '6592a2ca0cb86cdf8dcb15d9b5c7b0c3', 'student', 'active'),
(58, '58700135', '3157f62f08435873f5e609a8b516e9e8', 'student', 'active'),
(59, '58700140', '6e83bbdf1dad2c7afbc730a9a3f19609', 'student', 'active'),
(60, '58700141', 'c0064bb3ef67639fb47b1d3632242c02', 'student', 'active'),
(61, '58700156', '3b66eb863d7180d06c9bdca6e41e2981', 'student', 'active'),
(62, '58700157', '97648f4805e0f8fdcd68eeb44cd08056', 'student', 'active'),
(63, '54311095', '81dc9bdb52d04dc20036dbd8313ed055', 'student', 'active'),
(64, 'sittinee', 'b59c67bf196a4758191e42f76670ceba', 'teacher', 'active'),
(65, '58310101', '4cabad4498b33bad3b575846d0131566', 'student', 'active'),
(66, '58310102', '4820dbedb5675bf4c8a4c4db174cbb45', 'student', 'active'),
(67, '58310103', 'fd2823f14a2b3b22f797bf507b5d31b4', 'student', 'active'),
(68, '58310104', 'b2cb1a1900797081c87ec93391c464ec', 'student', 'active'),
(69, '58310105', '9c1f713f91b49bc0df686d67e59a5e94', 'student', 'active'),
(70, '58310106', '1ed33111671ee18f3b55717c457ee7d2', 'student', 'active'),
(71, '58310107', 'd709109cc9aab2194fd286929fc7bc08', 'student', 'active'),
(72, '58310108', '3e76a67fab7fd40d2bb42792953f31de', 'student', 'active'),
(73, '58310109', '16ceb1c121a385b6d95817d7e6b240ce', 'student', 'active'),
(74, '58310110', '41c9a257b3d9ce0b4f62eaad2046fad7', 'student', 'active'),
(75, 'jasper', '81dc9bdb52d04dc20036dbd8313ed055', 'student', 'active'),
(77, 'jasper1', '81dc9bdb52d04dc20036dbd8313ed055', 'student', 'active');

-- --------------------------------------------------------

--
-- Structure for view `coursesbystudents`
--
DROP TABLE IF EXISTS `coursesbystudents`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `coursesbystudents`  AS  select `se`.`stu_id` AS `stu_id`,`c`.`course_id` AS `course_id`,`s`.`subject_id` AS `subject_id`,`se`.`group_id` AS `group_id`,`c`.`year` AS `year`,`c`.`visible` AS `visible`,`c`.`status` AS `status`,`s`.`code` AS `code`,`s`.`name` AS `name`,`s`.`shortname` AS `shortname`,`s`.`description` AS `description` from ((`student_enroll` `se` left join `courses` `c` on(`se`.`course_id` = `c`.`course_id`)) left join `subjects` `s` on(`s`.`subject_id` = `c`.`subject_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `courseslist_view`
--
DROP TABLE IF EXISTS `courseslist_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `courseslist_view`  AS  select `c`.`course_id` AS `course_id`,`s`.`subject_id` AS `subject_id`,`s`.`code` AS `code`,`c`.`year` AS `year`,`s`.`name` AS `name`,`s`.`shortname` AS `shortname`,`s`.`description` AS `description`,`c`.`visible` AS `visible`,`c`.`status` AS `status` from (`courses` `c` left join `subjects` `s` on(`c`.`subject_id` = `s`.`subject_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `question_detail_list`
--
DROP TABLE IF EXISTS `question_detail_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `question_detail_list`  AS  select `epd`.`paper_id` AS `paper_id`,`epd`.`part_id` AS `part_id`,`epd`.`no` AS `no`,`q`.`question_id` AS `question_id`,`q`.`question` AS `question`,`q`.`type` AS `type`,`q`.`status` AS `status`,`q`.`chapter_id` AS `chapter_id`,`q`.`created_by` AS `created_by`,`q`.`created_time` AS `created_time`,`q`.`choice1` AS `choice1`,`q`.`choice2` AS `choice2`,`q`.`choice3` AS `choice3`,`q`.`choice4` AS `choice4`,`q`.`choice5` AS `choice5`,`q`.`choice6` AS `choice6`,`q`.`answer_choice` AS `answer_choice`,`q`.`answer_numeric` AS `answer_numeric`,`q`.`answer_boolean` AS `answer_boolean`,`q`.`chapter_name` AS `chapter_name` from (`exam_papers_detail` `epd` left join `question_list` `q` on(`epd`.`question_id` = `q`.`question_id`)) order by `epd`.`paper_id`,`epd`.`part_id`,`epd`.`no` ;

-- --------------------------------------------------------

--
-- Structure for view `question_list`
--
DROP TABLE IF EXISTS `question_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `question_list`  AS  select `q`.`question_id` AS `question_id`,`q`.`question` AS `question`,`q`.`type` AS `type`,`q`.`status` AS `status`,`q`.`chapter_id` AS `chapter_id`,`getNameFromUid`(`q`.`created_by_id`) AS `created_by`,`q`.`created_time` AS `created_time`,`qc`.`choice1` AS `choice1`,`qc`.`choice2` AS `choice2`,`qc`.`choice3` AS `choice3`,`qc`.`choice4` AS `choice4`,`qc`.`choice5` AS `choice5`,`qc`.`choice6` AS `choice6`,`qc`.`answer` AS `answer_choice`,`qn`.`answer` AS `answer_numeric`,`qb`.`answer` AS `answer_boolean`,`ch`.`name` AS `chapter_name` from ((((`questions` `q` left join `question_choice` `qc` on(`q`.`question_id` = `qc`.`question_id`)) left join `question_numerical` `qn` on(`q`.`question_id` = `qn`.`question_id`)) left join `question_boolean` `qb` on(`q`.`question_id` = `qb`.`question_id`)) left join `chapter` `ch` on(`q`.`chapter_id` = `ch`.`chapter_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `report_courses`
--
DROP TABLE IF EXISTS `report_courses`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `report_courses`  AS  select `cv`.`course_id` AS `course_id`,`cv`.`subject_id` AS `subject_id`,`cv`.`code` AS `code`,`cv`.`year` AS `year`,`cv`.`name` AS `name`,`cv`.`shortname` AS `shortname`,`cv`.`description` AS `description`,`cv`.`visible` AS `visible`,`cv`.`status` AS `status`,count(`ep`.`course_id`) AS `examcount` from (`courseslist_view` `cv` left join `exam_papers` `ep` on(`cv`.`course_id` = `ep`.`course_id`)) group by `cv`.`course_id` ;

-- --------------------------------------------------------

--
-- Structure for view `report_course_calc`
--
DROP TABLE IF EXISTS `report_course_calc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `report_course_calc`  AS  select `c`.`course_id` AS `course_id`,`c`.`subject_id` AS `subject_id`,`c`.`code` AS `code`,`c`.`year` AS `year`,`c`.`name` AS `subjectname`,`c`.`shortname` AS `shortname`,`ep`.`title` AS `papername`,`ep`.`starttime` AS `starttime`,`ep`.`endtime` AS `endtime`,`c`.`visible` AS `visible`,`c`.`status` AS `status`,`s`.`paper_id` AS `paper_id`,`getEnrollCount`(`c`.`course_id`) AS `enrollcount`,count(`s`.`stu_id`) AS `testedcount`,avg(`s`.`Score`) AS `average`,min(`s`.`Score`) AS `minimum`,max(`s`.`Score`) AS `maximum` from ((`courseslist_view` `c` left join `scoreboard` `s` on(`c`.`course_id` = `s`.`course_id`)) left join `exam_papers` `ep` on(`s`.`paper_id` = `ep`.`paper_id`)) group by `s`.`course_id` order by `c`.`code` ;

-- --------------------------------------------------------

--
-- Structure for view `upcomingtest`
--
DROP TABLE IF EXISTS `upcomingtest`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `upcomingtest`  AS  select `se`.`stu_id` AS `stu_id`,`se`.`group_id` AS `group_id`,`ep`.`paper_id` AS `paper_id`,`se`.`course_id` AS `course_id`,`ep`.`title` AS `papertitle`,`ep`.`description` AS `paperdesc`,`ep`.`rules` AS `rules`,`ep`.`starttime` AS `starttime`,`ep`.`endtime` AS `endtime`,`s`.`subject_id` AS `subject_id`,`s`.`code` AS `code`,`s`.`name` AS `subjectname`,`s`.`shortname` AS `shortname`,`s`.`name` AS `subjectdesc`,`ep`.`status` AS `status` from ((`student_enroll` `se` left join `exam_papers` `ep` on(`se`.`course_id` = `ep`.`course_id`)) left join `subjects` `s` on(`s`.`subject_id` = `getSubjectIdFromCourseId`(`se`.`course_id`))) where `ep`.`endtime` >= current_timestamp() ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `answer_papers`
--
ALTER TABLE `answer_papers`
  ADD PRIMARY KEY (`question_id`,`sco_id`);

--
-- Indexes for table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`chapter_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_students_group`
--
ALTER TABLE `course_students_group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `exam_papers`
--
ALTER TABLE `exam_papers`
  ADD PRIMARY KEY (`paper_id`);

--
-- Indexes for table `exam_papers_detail`
--
ALTER TABLE `exam_papers_detail`
  ADD PRIMARY KEY (`question_id`,`part_id`,`paper_id`);

--
-- Indexes for table `exam_papers_parts`
--
ALTER TABLE `exam_papers_parts`
  ADD PRIMARY KEY (`part_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `question_boolean`
--
ALTER TABLE `question_boolean`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_choice`
--
ALTER TABLE `question_choice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_numerical`
--
ALTER TABLE `question_numerical`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scoreboard`
--
ALTER TABLE `scoreboard`
  ADD PRIMARY KEY (`sco_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`stu_id`);

--
-- Indexes for table `student_enroll`
--
ALTER TABLE `student_enroll`
  ADD PRIMARY KEY (`stu_id`,`course_id`);

--
-- Indexes for table `student_group_paper`
--
ALTER TABLE `student_group_paper`
  ADD PRIMARY KEY (`group_id`,`paper_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`tea_id`);

--
-- Indexes for table `teacher_course_detail`
--
ALTER TABLE `teacher_course_detail`
  ADD PRIMARY KEY (`tea_id`,`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chapter`
--
ALTER TABLE `chapter`
  MODIFY `chapter_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `course_students_group`
--
ALTER TABLE `course_students_group`
  MODIFY `group_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `exam_papers`
--
ALTER TABLE `exam_papers`
  MODIFY `paper_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `exam_papers_parts`
--
ALTER TABLE `exam_papers_parts`
  MODIFY `part_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `question_boolean`
--
ALTER TABLE `question_boolean`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `question_choice`
--
ALTER TABLE `question_choice`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `question_numerical`
--
ALTER TABLE `question_numerical`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `scoreboard`
--
ALTER TABLE `scoreboard`
  MODIFY `sco_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `tea_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
