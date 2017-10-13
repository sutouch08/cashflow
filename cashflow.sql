-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: 172.20.11.8
-- Generation Time: Oct 13, 2017 at 05:28 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cashflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('db570c9a852586128063890dfbc6ec67', '172.20.100.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36', 1499674002, 'a:1:{s:9:"user_data";s:0:"";}'),
('e7be2311b536fcedb75ba985f9142728', '172.20.100.88', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.3', 1499674579, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_access`
--

CREATE TABLE IF NOT EXISTS `tbl_access` (
  `id_access` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `view` tinyint(1) NOT NULL DEFAULT '0',
  `add` tinyint(1) NOT NULL DEFAULT '0',
  `edit` tinyint(1) NOT NULL DEFAULT '0',
  `del` tinyint(1) NOT NULL DEFAULT '0',
  `print` tinyint(1) NOT NULL DEFAULT '0',
  `approve` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_access`
--

INSERT INTO `tbl_access` (`id_access`, `id_profile`, `id_menu`, `view`, `add`, `edit`, `del`, `print`, `approve`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 1, 2, 1, 1, 1, 1, 1, 1),
(3, 1, 3, 1, 1, 1, 1, 1, 1),
(4, 1, 4, 1, 1, 1, 1, 1, 1),
(5, 1, 5, 1, 1, 1, 1, 1, 1),
(6, 1, 6, 1, 1, 1, 1, 1, 1),
(7, 1, 7, 1, 1, 1, 1, 1, 1),
(8, 1, 8, 1, 1, 1, 1, 1, 1),
(9, 1, 9, 1, 1, 1, 1, 1, 1),
(10, 1, 10, 1, 1, 1, 1, 1, 1),
(11, 2, 1, 0, 0, 0, 0, 0, 0),
(12, 2, 2, 0, 0, 0, 0, 0, 0),
(13, 2, 3, 0, 0, 0, 0, 0, 0),
(14, 2, 4, 0, 0, 0, 0, 0, 0),
(15, 2, 5, 0, 0, 0, 0, 0, 0),
(16, 2, 6, 0, 0, 0, 0, 0, 0),
(17, 2, 7, 0, 0, 0, 0, 0, 0),
(18, 2, 8, 0, 0, 0, 0, 0, 0),
(19, 2, 9, 0, 0, 0, 0, 0, 0),
(20, 2, 10, 1, 1, 1, 1, 1, 1),
(21, 4, 1, 0, 0, 0, 0, 0, 0),
(22, 4, 2, 0, 0, 0, 0, 0, 0),
(23, 4, 3, 0, 0, 0, 0, 0, 0),
(24, 4, 4, 0, 0, 0, 0, 0, 0),
(25, 4, 5, 0, 0, 0, 0, 0, 0),
(26, 4, 6, 0, 0, 0, 0, 0, 0),
(27, 4, 7, 0, 0, 0, 0, 0, 0),
(28, 4, 8, 0, 0, 0, 0, 0, 0),
(29, 4, 9, 0, 0, 0, 0, 0, 0),
(30, 4, 10, 0, 0, 0, 0, 0, 0),
(31, 4, 11, 0, 0, 0, 0, 0, 0),
(32, 1, 11, 1, 1, 1, 1, 1, 1),
(33, 2, 11, 0, 0, 0, 0, 0, 0),
(34, 1, 12, 1, 1, 1, 1, 1, 1),
(35, 1, 13, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ac_access`
--

CREATE TABLE IF NOT EXISTS `tbl_ac_access` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_bank_ac` int(11) NOT NULL,
  `view` tinyint(1) NOT NULL DEFAULT '0',
  `add` tinyint(1) NOT NULL DEFAULT '0',
  `edit` tinyint(1) NOT NULL DEFAULT '0',
  `delete` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_ac_access`
--

INSERT INTO `tbl_ac_access` (`id`, `id_user`, `id_bank_ac`, `view`, `add`, `edit`, `delete`) VALUES
(1, 4, 1, 1, 1, 1, 1),
(2, 2, 1, 1, 1, 1, 1),
(3, 2, 2, 1, 1, 1, 1),
(4, 2, 3, 1, 1, 1, 1),
(5, 2, 4, 1, 1, 1, 1),
(6, 2, 5, 1, 1, 1, 1),
(7, 2, 6, 1, 1, 1, 1),
(8, 2, 7, 1, 1, 1, 1),
(9, 2, 8, 1, 1, 1, 1),
(10, 2, 9, 1, 1, 1, 1),
(11, 2, 10, 1, 1, 1, 1),
(12, 2, 11, 1, 1, 1, 1),
(13, 4, 2, 1, 1, 1, 1),
(14, 4, 3, 1, 1, 1, 1),
(15, 4, 4, 1, 1, 1, 1),
(16, 4, 5, 1, 1, 1, 1),
(17, 4, 6, 1, 1, 1, 1),
(18, 4, 7, 1, 1, 1, 1),
(19, 4, 8, 1, 1, 1, 1),
(20, 4, 9, 1, 1, 1, 1),
(21, 4, 10, 1, 1, 1, 1),
(22, 4, 11, 1, 1, 1, 1),
(23, 5, 1, 1, 1, 1, 1),
(24, 5, 2, 1, 1, 1, 1),
(25, 5, 3, 1, 1, 1, 1),
(26, 5, 4, 1, 1, 1, 1),
(27, 5, 5, 1, 1, 1, 1),
(28, 5, 6, 1, 1, 1, 1),
(29, 5, 7, 1, 1, 1, 1),
(30, 5, 8, 1, 1, 1, 1),
(31, 5, 9, 1, 1, 1, 1),
(32, 5, 10, 1, 1, 1, 1),
(33, 5, 11, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank`
--

CREATE TABLE IF NOT EXISTS `tbl_bank` (
  `id_bank` int(11) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `date_add` datetime NOT NULL,
  `date_upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_bank`
--

INSERT INTO `tbl_bank` (`id_bank`, `bank_name`, `date_add`, `date_upd`) VALUES
(1, 'ทหารไทย', '2015-09-08 15:54:33', '2015-09-08 08:54:33'),
(2, 'กสิกรไทย', '2015-09-08 16:13:26', '2015-09-08 09:13:26'),
(3, 'ซีไอเอ็มบี ไทย', '2015-09-08 21:14:33', '2015-09-08 14:14:33'),
(4, 'สแตนดาร์ชาร์เตอร์ด', '2015-09-08 21:14:53', '2015-09-08 14:14:53'),
(5, 'กรุงไทย', '2015-09-08 21:15:05', '2015-09-08 14:15:05'),
(6, 'กรุงเทพ', '2015-09-08 21:15:17', '2015-09-08 14:15:17'),
(7, 'กรุงศรีอยุธยา', '2015-09-08 21:15:46', '2015-09-08 14:15:46'),
(8, 'ไทยพาณิชย์', '2015-09-08 21:17:14', '2015-09-08 14:17:14'),
(9, 'ยูโอบี', '2015-09-08 21:17:35', '2015-09-08 14:17:35'),
(10, 'Exim Bank', '2015-09-08 21:34:47', '2015-09-08 14:34:47');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank_ac`
--

CREATE TABLE IF NOT EXISTS `tbl_bank_ac` (
  `id_bank_ac` int(11) NOT NULL,
  `id_bank` int(11) NOT NULL,
  `ac_code` varchar(20) NOT NULL,
  `ac_number` varchar(15) NOT NULL,
  `ac_name` varchar(100) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `ac_type` varchar(50) NOT NULL,
  `id_company` int(11) NOT NULL,
  `od_rate` decimal(6,3) NOT NULL DEFAULT '0.000',
  `od_budget` decimal(20,2) NOT NULL DEFAULT '0.00',
  `loan_budget` decimal(20,2) NOT NULL DEFAULT '0.00',
  `date_add` datetime NOT NULL,
  `date_upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  `int` tinyint(1) NOT NULL DEFAULT '0',
  `int_date` varchar(2) NOT NULL DEFAULT '0',
  `int_cal` tinyint(1) NOT NULL DEFAULT '0',
  `in_book` int(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_bank_ac`
--

INSERT INTO `tbl_bank_ac` (`id_bank_ac`, `id_bank`, `ac_code`, `ac_number`, `ac_name`, `branch`, `ac_type`, `id_company`, `od_rate`, `od_budget`, `loan_budget`, `date_add`, `date_upd`, `active`, `valid`, `int`, `int_date`, `int_cal`, `in_book`) VALUES
(1, 2, '111210', '439-1-01549-5', 'เงินฝากกระแสรายวัน-ธ.กสิกรไทย ', 'อ้อมน้อย', 'กระแสรายวัน', 1, 0.000, 0.00, 0.00, '2017-05-10 14:51:29', '2017-05-10 07:51:29', 1, 1, 0, '0', 0, 0),
(2, 2, '111215', '020-8-75881-0', 'เงินฝากกระแสรายวัน-ธ.กสิกรไทย', 'อ้อมใหญ่', 'กระแสรายวัน', 1, 0.000, 0.00, 0.00, '2017-05-11 17:59:46', '2017-05-11 11:00:17', 1, 1, 0, '0', 0, 0),
(3, 6, '111220', '239-3-02018-1', 'เงินฝากกระแสรายวัน-ธ.กรุงเทพ ', 'อ้อมใหญ่', 'กระแสรายวัน', 1, 0.000, 0.00, 0.00, '2017-05-11 18:01:30', '2017-05-11 11:01:30', 1, 1, 0, '0', 0, 0),
(4, 8, '111225', '191-3-00150-7', 'เงินฝากกระแสรายวัน-ธ.ไทยพาณิชย์', 'โรงพยาบาลเซ็นหลุยส์', 'กระแสรายวัน', 1, 0.000, 0.00, 0.00, '2017-05-11 18:02:56', '2017-05-11 11:02:56', 1, 1, 0, '0', 0, 0),
(5, 10, '111230', '204-1-0-0698-8', 'เงินฝากระแสรายวัน-ธ.Exim Bank', 'พระราม 2', 'กระแสรายวัน', 1, 0.000, 0.00, 0.00, '2017-05-11 18:04:37', '2017-05-11 11:07:57', 1, 1, 0, '0', 0, 0),
(6, 9, '111235', '787-3-63083-7', 'เงินฝากกระแสรายวัน-ธ.UOB', 'หนองแขม', 'กระแสรายวัน', 1, 0.000, 0.00, 0.00, '2017-05-11 18:06:06', '2017-05-11 11:06:06', 1, 1, 0, '0', 0, 0),
(7, 7, '111240', '625-0-00070-4', 'เงินฝากกระแสรายวัน-ธ.กรุงศรี', 'ศูนย์ราชการเฉลิมพระเกียรติ อาคารB', 'กระแสรายวัน', 1, 0.000, 0.00, 0.00, '2017-05-11 18:07:22', '2017-05-11 11:14:57', 1, 1, 0, '0', 0, 0),
(8, 10, '11310', '204-1-00078-2', 'เงินฝากออมทรัพย์-ธ.Exim ฺฺBank', 'พระราม 2', 'ฝากออมทรัพย์', 1, 0.000, 0.00, 0.00, '2017-05-11 18:10:52', '2017-05-11 11:10:52', 1, 1, 0, '0', 0, 0),
(9, 9, '111420', '787-063-738-5', 'เงินฝากประจำ-ธ.UOB ', 'หนองแขม', 'ประจำ', 1, 0.000, 0.00, 0.00, '2017-05-11 18:12:00', '2017-05-11 11:12:00', 1, 1, 0, '0', 0, 0),
(10, 7, '111430', '625-2-00384-5', 'เงินฝากประจำ-ธ.กรุงศรี', 'ศูนย์ราชการเฉลิมพระเกียรติ อาคารB', 'เงินฝากประจำ', 1, 0.000, 0.00, 0.00, '2017-05-11 18:13:41', '2017-05-11 11:13:41', 1, 1, 0, '0', 0, 0),
(11, 2, '111410', '002-1-22869-9', 'เงินฝากประจำ-ธ.กสิกรไทย', 'พระราม 2', 'ฝากประจำ', 1, 0.000, 0.00, 0.00, '2017-05-11 18:16:39', '2017-05-11 11:16:39', 1, 1, 0, '0', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cash_flow`
--

CREATE TABLE IF NOT EXISTS `tbl_cash_flow` (
  `id_cash_flow` int(11) NOT NULL,
  `id_bank` int(11) NOT NULL,
  `id_bank_ac` int(11) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `detail` varchar(200) NOT NULL,
  `cash_in` decimal(20,2) NOT NULL DEFAULT '0.00',
  `cash_out` decimal(20,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(20,2) NOT NULL DEFAULT '0.00',
  `od_balance` decimal(20,2) NOT NULL DEFAULT '0.00',
  `is_in` tinyint(1) NOT NULL COMMENT '1=cash_in 0 = cash_out',
  `id_repay` int(5) NOT NULL DEFAULT '0',
  `move_type` varchar(20) NOT NULL COMMENT 'ประเภทการจ่าย เช่น เช็ค เงินสด โอน',
  `move_reference` varchar(50) NOT NULL COMMENT 'อ้างอิงการจ่าย เช่น เลขที่เช็ค',
  `date_add` datetime NOT NULL,
  `date_upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `due_date` date NOT NULL,
  `remark` text NOT NULL,
  `employee_add` int(11) NOT NULL,
  `employee_upd` int(11) NOT NULL DEFAULT '0',
  `position` int(3) NOT NULL,
  `color` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company`
--

CREATE TABLE IF NOT EXISTS `tbl_company` (
  `id_company` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `date_add` datetime NOT NULL,
  `date_upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_company`
--

INSERT INTO `tbl_company` (`id_company`, `company_name`, `active`, `date_add`, `date_upd`) VALUES
(1, 'บริษัท วอริกซ์ สปอร์ต จำกัด', 1, '2017-04-25 09:34:26', '2017-04-25 02:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE IF NOT EXISTS `tbl_employee` (
  `id_employee` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `is_quit` tinyint(1) NOT NULL DEFAULT '0',
  `date_upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_employee`
--

INSERT INTO `tbl_employee` (`id_employee`, `first_name`, `last_name`, `active`, `is_quit`, `date_upd`) VALUES
(1, 'สุทัศ', 'สังข์สวัสดิ์', 1, 0, '2015-08-21 07:51:35'),
(3, 'ดวงใจ', 'พรหมวิเศษ', 1, 0, '2015-08-21 07:59:17'),
(4, 'นุชนภา', 'ขอบใจ', 1, 0, '2015-08-28 02:15:22'),
(5, 'วิไล', 'คำเหลือ', 1, 0, '2015-09-08 14:19:06'),
(6, 'จันทร์จิรา', 'นารีนุช', 1, 0, '2015-09-17 05:06:16'),
(7, 'กฤษณา', 'บุญสะอาด', 1, 0, '2015-09-17 05:06:36'),
(8, 'อรอุมา', 'ศรีอุ่น', 0, 1, '2017-05-10 07:52:39');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_loan`
--

CREATE TABLE IF NOT EXISTS `tbl_loan` (
  `id_loan` int(11) NOT NULL,
  `id_bank_ac` int(5) NOT NULL,
  `id_bank` int(5) NOT NULL,
  `detail` varchar(100) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `amount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `paid` decimal(20,2) NOT NULL DEFAULT '0.00',
  `rate` decimal(5,3) NOT NULL DEFAULT '0.000',
  `days` int(5) NOT NULL DEFAULT '0',
  `due_date` date NOT NULL,
  `date_add` date NOT NULL,
  `date_upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  `position` int(5) NOT NULL DEFAULT '1',
  `remark` text NOT NULL,
  `employee_add` varchar(50) NOT NULL,
  `employee_upd` varchar(50) NOT NULL DEFAULT '',
  `color` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='บันทึกรายการกู้ยืม';

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

CREATE TABLE IF NOT EXISTS `tbl_menu` (
  `id_menu` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`id_menu`, `name`) VALUES
(1, 'เพิ่ม/แก้ไข ธนาคาร'),
(2, 'เพิ่ม/แก้ไข บัญชีธนาคาร'),
(3, 'เพิ่ม/แก้ไข พนักงาน'),
(4, 'เพิ่ม/แก้ไข ล็อกอิน'),
(5, 'เพิ่ม/แก้ไข ชื่อผู้ขาย'),
(6, 'เพิ่ม/แก้ไข ชื่อลูกค้า'),
(7, 'เพิ่ม/แก้ไข บริษัท'),
(8, 'เพิ่ม/แก้ไข โปรไฟล์'),
(9, 'กำหนดสิทธิ์'),
(10, 'บันทึก กระแสเงินสด'),
(11, 'กำหนดสิทธิ์ สมุดบัญชี'),
(12, 'บันทึกการกู้ตั๋ว'),
(13, 'จ่ายชำระตั๋วกู้');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_move_type`
--

CREATE TABLE IF NOT EXISTS `tbl_move_type` (
  `id` tinyint(2) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='เก็บวิธีการรับและจ่าย';

--
-- Dumping data for table `tbl_move_type`
--

INSERT INTO `tbl_move_type` (`id`, `name`) VALUES
(1, 'เช็ค'),
(2, 'เงินโอน'),
(3, 'เงินสด'),
(4, 'ตัดบัญชี');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profile`
--

CREATE TABLE IF NOT EXISTS `tbl_profile` (
  `id_profile` int(11) NOT NULL,
  `profile_name` varchar(100) NOT NULL,
  `date_upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_profile`
--

INSERT INTO `tbl_profile` (`id_profile`, `profile_name`, `date_upd`) VALUES
(1, 'ผู้ดูแลระบบ', '2015-08-27 17:00:00'),
(2, 'ผู้บันทึกรายการ', '2015-08-27 17:00:00'),
(4, 'ผู้บริหาร', '2015-08-28 07:43:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_repay`
--

CREATE TABLE IF NOT EXISTS `tbl_repay` (
  `id_repay` int(11) NOT NULL,
  `id_bank_ac` int(11) NOT NULL,
  `id_loan` int(11) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `amount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `date_add` date NOT NULL,
  `date_upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remark` text NOT NULL,
  `employee_add` varchar(100) NOT NULL,
  `employee_upd` varchar(100) NOT NULL,
  `color` varchar(20) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

CREATE TABLE IF NOT EXISTS `tbl_setting` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `value` varchar(50) NOT NULL,
  `date_upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_employee` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `name`, `value`, `date_upd`, `id_employee`) VALUES
(1, 'PER_PAGE', '50', '2015-09-08 08:10:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL,
  `id_employee` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `user_name` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `s_key` varchar(32) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `id_employee`, `id_profile`, `user_name`, `password`, `s_key`, `active`, `last_login`) VALUES
(1, 1, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, 1, '2017-07-10 14:39:53'),
(2, 3, 1, 'jib', '070dbb6024b5ef93784428afc71f2146', NULL, 1, '2017-05-11 17:58:20'),
(4, 4, 1, 'nuchnapa', '31c97cbb941d3e92d0e6f9925e9bc4d7', NULL, 1, '2015-10-19 14:02:41'),
(5, 5, 2, 'wilai', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 1, '2015-09-17 17:59:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `tbl_access`
--
ALTER TABLE `tbl_access`
  ADD PRIMARY KEY (`id_access`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_profile` (`id_profile`);

--
-- Indexes for table `tbl_ac_access`
--
ALTER TABLE `tbl_ac_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indexes for table `tbl_bank_ac`
--
ALTER TABLE `tbl_bank_ac`
  ADD PRIMARY KEY (`id_bank_ac`),
  ADD KEY `id_bank` (`id_bank`),
  ADD KEY `id_company` (`id_company`),
  ADD KEY `active` (`active`),
  ADD KEY `valid` (`valid`);

--
-- Indexes for table `tbl_cash_flow`
--
ALTER TABLE `tbl_cash_flow`
  ADD PRIMARY KEY (`id_cash_flow`),
  ADD KEY `id_bank` (`id_bank`),
  ADD KEY `id_bank_acc` (`id_bank_ac`),
  ADD KEY `reference` (`reference`),
  ADD KEY `due_date` (`due_date`),
  ADD KEY `valid` (`position`),
  ADD KEY `is_in` (`is_in`);

--
-- Indexes for table `tbl_company`
--
ALTER TABLE `tbl_company`
  ADD PRIMARY KEY (`id_company`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`id_employee`),
  ADD KEY `active` (`active`),
  ADD KEY `is_quit` (`is_quit`);

--
-- Indexes for table `tbl_loan`
--
ALTER TABLE `tbl_loan`
  ADD PRIMARY KEY (`id_loan`),
  ADD KEY `id_bank_ac` (`id_bank_ac`),
  ADD KEY `due_date` (`due_date`),
  ADD KEY `reference` (`reference`),
  ADD KEY `valid` (`valid`),
  ADD KEY `position` (`position`);

--
-- Indexes for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indexes for table `tbl_move_type`
--
ALTER TABLE `tbl_move_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_profile`
--
ALTER TABLE `tbl_profile`
  ADD PRIMARY KEY (`id_profile`);

--
-- Indexes for table `tbl_repay`
--
ALTER TABLE `tbl_repay`
  ADD PRIMARY KEY (`id_repay`);

--
-- Indexes for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_employee` (`id_employee`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `password` (`password`),
  ADD KEY `active` (`active`),
  ADD KEY `s_key` (`s_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_access`
--
ALTER TABLE `tbl_access`
  MODIFY `id_access` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `tbl_ac_access`
--
ALTER TABLE `tbl_ac_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  MODIFY `id_bank` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_bank_ac`
--
ALTER TABLE `tbl_bank_ac`
  MODIFY `id_bank_ac` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tbl_cash_flow`
--
ALTER TABLE `tbl_cash_flow`
  MODIFY `id_cash_flow` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_company`
--
ALTER TABLE `tbl_company`
  MODIFY `id_company` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `id_employee` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_loan`
--
ALTER TABLE `tbl_loan`
  MODIFY `id_loan` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `tbl_move_type`
--
ALTER TABLE `tbl_move_type`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_profile`
--
ALTER TABLE `tbl_profile`
  MODIFY `id_profile` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_repay`
--
ALTER TABLE `tbl_repay`
  MODIFY `id_repay` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
