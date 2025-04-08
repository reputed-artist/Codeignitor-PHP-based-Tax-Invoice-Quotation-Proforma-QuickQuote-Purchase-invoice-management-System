-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2025 at 01:45 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `aid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `acc_type` int(11) NOT NULL,
  `opening_bal` double NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`aid`, `cid`, `acc_type`, `opening_bal`, `created`) VALUES
(1, 1, 1, 201723, '2022-08-11'),
(6, 7, 1, 0, '2024-04-12'),
(12, 5, 2, 10, '2024-04-12'),
(17, 706, 2, 0, '2024-04-22'),
(21, 640, 2, 0, '2024-04-26'),
(29, 940, 2, 0, '2024-09-08'),
(30, 30, 0, 0, '2024-11-07'),
(31, 31, 0, 0, '2024-11-07'),
(32, 32, 0, 0, '2024-11-07'),
(41, 714, 1, 0, '2024-11-07'),
(42, 9, 0, 0, '2024-11-07'),
(43, 814, 0, 200000, '2024-11-08'),
(44, 633, 2, 0, '2024-11-20'),
(45, 969, 1, 0, '2024-11-20'),
(46, 989, 1, 230000, '2025-01-08');

-- --------------------------------------------------------

--
-- Table structure for table `acc_type`
--

CREATE TABLE `acc_type` (
  `id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `acc_type`
--

INSERT INTO `acc_type` (`id`, `type`) VALUES
(0, 'Customer'),
(1, 'Supplier'),
(2, 'Dual (Cust/Sup)');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `qualification` varchar(200) NOT NULL,
  `location` varchar(200) NOT NULL,
  `skills` varchar(300) NOT NULL,
  `c_name` varchar(300) NOT NULL,
  `c_add` varchar(300) NOT NULL,
  `profession` varchar(300) NOT NULL,
  `mob` varchar(50) NOT NULL,
  `gst` varchar(20) NOT NULL,
  `pan` varchar(10) NOT NULL,
  `picture` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `picturelogo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `name`, `email`, `qualification`, `location`, `skills`, `c_name`, `c_add`, `profession`, `mob`, `gst`, `pan`, `picture`, `picturelogo`) VALUES
(1, 'admin@gmail.com', 'admin@123', 'Tejas Chavda', 'codetech32@xxxxxx.xxx', 'M-Tech at LJ University', 'Ahmedabad, Gujarat', '[\"test ,from\"]', 'CodeTech Engineers', 'A 4/1 Suryanagar Soc., Jawahar Chowk, xxx, Ahmedabad- 380008', 'Web Developer', '+91-973769xxxx / +91-7600158xxx', '24AVVPC8158XXXX', 'AVVPC815XX', '1738680148_07cbe5986e43c596a9d7.jpeg', '1738682224_ae94bb2586482adfce76.png');

-- --------------------------------------------------------

--
-- Table structure for table `bankdetails`
--

CREATE TABLE `bankdetails` (
  `bid` int(50) NOT NULL,
  `bname` varchar(300) NOT NULL,
  `ac` varchar(300) NOT NULL,
  `ifsc` varchar(300) NOT NULL,
  `branch` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bankdetails`
--

INSERT INTO `bankdetails` (`bid`, `bname`, `ac`, `ifsc`, `branch`) VALUES
(1, 'ICICI BANK', '6424555555211', 'ICICI00012232', 'Mahura Road');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `cid` int(10) NOT NULL,
  `c_name` varchar(80) NOT NULL,
  `c_add` varchar(200) NOT NULL,
  `mob` varchar(50) NOT NULL,
  `country` varchar(100) NOT NULL,
  `gst` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `c_type` varchar(4) NOT NULL,
  `u_type` tinyint(1) NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`cid`, `c_name`, `c_add`, `mob`, `country`, `gst`, `email`, `c_type`, `u_type`, `created`) VALUES
(1, 'JAYA ENTERPRISES1', 'MANINAGAR guj', '+918735003590', 'India', '1478523691', 'TC4220@GMAIL.COM', 'Loc', 2, '2025-01-08'),
(4, 'Gamer Enterprise', 'Mumbai', '+918735003591', 'India', '7485961023', 'gamer@gmail.co', 'IGST', 0, '2025-01-08'),
(6, 'Diamond Enterprises', 'Karnataka', '+917600158240', 'India', '7485602310', 'SAVER@GMAIL.COM', 'IGST', 2, '2025-01-08'),
(7, 'Random India', 'Vizag', '+918735003590', 'India', '7412589630', 'Retro@gmail.com', 'Loc', 0, '2025-01-08'),
(15, 'Cyan', 'mumbai', '+917600158240', 'India', '24AVVPC8158M1ZV', 'demo@gmail.com', 'Loc', 0, '2025-01-14'),
(16, 'Code maninagar', 'Gujarat', '+917600158245', 'India', '24AVVPC8158M1ZN', 'CODETECH32@GMAIL.COM', 'Loc', 0, '2025-01-14'),
(20, 'simon', 'uh euwie i', '+917600158240', 'India', '7894561230', '', 'Loc', 2, '2025-01-15'),
(21, 'simon2', 'adress', '+9178945611230', 'India', '7485963210', '', 'Loc', 1, '2025-01-15'),
(22, 'demo', 'maninagar', '+917845120369', 'India', '7485961023', '', 'IGST', 2, '2025-01-15'),
(23, 'amplify', 'ihhr ro', '+917894561230', 'India', '7485963210', '', 'Loc', 2, '2025-01-15'),
(24, '2 nd name', 'kjd or', '+917600158240', 'India', '7894561230', '', 'Loc', 2, '2025-01-15'),
(25, '3 rd ', 'mumbai', '+917016419537', 'India ', '7894561230', '', 'Loc', 1, '2025-01-15'),
(26, '3rd co', 'kmleew', '+917600158240', 'India', '7485961230', '', 'Loc', 0, '2025-01-15'),
(27, 'sed', 'maumb', '+918735003590', 'India', '7485963210', '', 'Loc', 0, '2025-01-15'),
(28, 'demo', 'jwejo', '+917600158240', 'India', '748596230', '', 'Loc', 2, '2025-01-15'),
(29, 'dem', 'jheje', '+917894561230', 'India', '7485961023', '', 'Loc', 0, '2025-01-15'),
(30, 'jay', 'uiori ', '+917541896320', 'India', '7485961230', 'code@gmail.com', 'Loc', 0, '2025-01-15'),
(31, 'sivay', 'ihw hu ', '+917485963210', 'India', '7485963210', '', 'Loc', 2, '2025-01-15'),
(32, 'dro', 'ijoewi wo', '+917894561230', 'India', '7485961230', 'code@gmail.com', 'Loc', 2, '2025-01-15'),
(33, 'sibvkj', ' jdioee o', '+917894561230', 'India', '7485961230', '', 'Loc', 0, '2025-01-15'),
(34, 'jay', 'jhkeje', '+918735003590', 'India', '7485961230', '', 'Loc', 2, '2025-01-15'),
(35, 'retuy', 'i iduwie e', '+918735003590', 'India', '7485961230', '', 'Loc', 2, '2025-01-15'),
(36, 'we ho', 'w peeop', '+918735003590', 'India', '7485963210', '', 'IGST', 2, '2025-01-15'),
(37, 'demo', 'hdewiehw', '+918735003590', 'India', '7894561230', '', 'IGST', 0, '2025-01-15'),
(38, '2 name', 'kjh iweh ', '+918735003590', 'India', '7485961230', '', 'IGST', 0, '2025-01-15'),
(39, 'slope', 'o keew', '+917894561230', 'India', '7485961023', '', 'IGST', 0, '2025-01-15'),
(40, 'rteiuw', 'he woow ', '+917894561230', 'India', '7418529630', '', 'Loc', 0, '2025-01-15'),
(41, 'deij o', 'ij oeiwo', '+917894561230', 'India', '7410258963', '', 'Loc', 0, '2025-01-15'),
(42, 'zecomo', 'ieje w', '+917600158240', 'India ', '7485961230', '', 'IGST', 1, '2025-01-15'),
(43, 'simini', 'ijweow', '+917894561230', 'India', '7410258963', '', 'IGST', 0, '2025-01-15'),
(44, 'ee ooir', 'o epeop', '+917894561230', 'India', '7412589630', '', 'IGST', 0, '2025-01-15'),
(45, 'ieoi', 'oie ie', '+917894561230', 'India', '7894561230', '', 'Loc', 0, '2025-01-15'),
(46, 'rrrijerp', 'oeweoepwp', '+917894561230', 'India', '7894561230', 'f@yahoo.in', 'IGST', 0, '2025-01-15'),
(47, 'ideoew', 'o ewepw', '+917894561230', 'India', '7485961230', 'cv@yahoo.in', 'IGST', 0, '2025-01-15'),
(48, 'sdfdoj', 'ije oew ', '+917894561230', 'India', '7894561230', 'cdeeke@gmail.co', 'IGST', 0, '2025-01-15'),
(49, 'ewe', 'ewewe', '+917894561230', 'India', '7412589630', 'rv@gmail.com', 'IGST', 0, '2025-01-15'),
(50, '456', 'kjire ro', '+917600158240', 'India', '7412589630', 'cde@gmail.com', 'IGST', 0, '2025-01-15'),
(51, 'reomew', 'kwekoe', '+917895612301', 'India', '7412589630', 'cv@gmail.com', 'IGST', 0, '2025-01-15'),
(52, 'froze', 'j deei oew', '+917894561230', 'India (भारत)', '7410258963', '', 'IGST', 1, '2025-01-15'),
(54, 'ueiue i', 'uhe ueh wi', '+917894561230', '', '7485961230', '', 'Loc', 1, '2025-01-15');

-- --------------------------------------------------------

--
-- Table structure for table `clienttype`
--

CREATE TABLE `clienttype` (
  `id` int(30) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clienttype`
--

INSERT INTO `clienttype` (`id`, `type`) VALUES
(1, 'IGST'),
(2, 'Loc');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_addresses`
--

CREATE TABLE `delivery_addresses` (
  `delid` int(11) NOT NULL,
  `invid` varchar(50) NOT NULL,
  `name` varchar(80) NOT NULL,
  `address` varchar(200) NOT NULL,
  `mob` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fd`
--

CREATE TABLE `fd` (
  `id` int(10) NOT NULL,
  `fdissueddate` date DEFAULT NULL,
  `fdholder` varchar(50) NOT NULL,
  `fdofbank` varchar(100) NOT NULL,
  `principleamt` int(20) NOT NULL,
  `nodays` varchar(20) NOT NULL,
  `intrate` varchar(10) NOT NULL,
  `intamt` int(10) NOT NULL,
  `finalamt` int(20) NOT NULL,
  `maturitydate` date NOT NULL,
  `fdentrydate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fd`
--

INSERT INTO `fd` (`id`, `fdissueddate`, `fdholder`, `fdofbank`, `principleamt`, `nodays`, `intrate`, `intamt`, `finalamt`, `maturitydate`, `fdentrydate`) VALUES
(1, '2024-03-02', 'Tejas', 'Saraswat Bank', 51418, '0.5', '5.75', 1458, 52876, '2024-08-29', '2024-03-21 20:38:50');

-- --------------------------------------------------------

--
-- Table structure for table `fest`
--

CREATE TABLE `fest` (
  `id` int(10) NOT NULL,
  `date` varchar(50) NOT NULL,
  `fest_name` varchar(250) NOT NULL,
  `gifs` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fest`
--

INSERT INTO `fest` (`id`, `date`, `fest_name`, `gifs`) VALUES
(1, '18-Feb', 'Maha Shivaratri', 'best mahashivratri.gif'),
(2, '09-Jul', 'Holi', 'happy-holi.gif\r\n\n\n\n\n');

-- --------------------------------------------------------

--
-- Table structure for table `invtest`
--

CREATE TABLE `invtest` (
  `orderno` int(100) NOT NULL,
  `orderid` varchar(300) NOT NULL,
  `item_name` varchar(300) NOT NULL,
  `item_desc` varchar(300) DEFAULT NULL,
  `hsn` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `total` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invtest`
--

INSERT INTO `invtest` (`orderno`, `orderid`, `item_name`, `item_desc`, `hsn`, `quantity`, `price`, `total`) VALUES
(1, '677eb6940aac8', 'CT- 01 HandHeld Manual Coder', NULL, 8443, 1, 3000, 3000),
(2, '677eb6b93db03', 'CT- 02 Handy Marker for Currogated Cartons', NULL, 8443, 1, 4000, 4000),
(3, '677f49a69a9cb', 'CT- 01 HandHeld Manual Coder', NULL, 8443, 1, 3000, 3000),
(4, '67874b54c5345', 'CT- 01 HandHeld Manual Coder', NULL, 8443, 1, 3000, 3000),
(5, '67874ba2f24b5', 'CT- 01 HandHeld Manual Coder', NULL, 8443, 1, 3000, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `invtest2`
--

CREATE TABLE `invtest2` (
  `invid` varchar(100) NOT NULL,
  `cid` int(10) NOT NULL,
  `orderid` varchar(300) NOT NULL,
  `totalitems` int(10) NOT NULL,
  `subtotal` int(100) NOT NULL,
  `taxrate` int(10) NOT NULL,
  `taxamount` int(100) NOT NULL,
  `totalamount` int(100) NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invtest2`
--

INSERT INTO `invtest2` (`invid`, `cid`, `orderid`, `totalitems`, `subtotal`, `taxrate`, `taxamount`, `totalamount`, `created`) VALUES
(' INV/24-25/0001', 1, '677eb6940aac8', 1, 3000, 18, 540, 3540, '2025-01-08'),
(' INV/24-25/0002', 6, '677eb6b93db03', 1, 4000, 18, 720, 4720, '2025-01-08'),
(' INV/24-25/0003', 14, '677f49a69a9cb', 1, 3000, 18, 540, 3540, '2025-01-08'),
(' INV/24-25/0004', 7, '67874b54c5345', 1, 3000, 18, 540, 3540, '2025-01-14'),
(' INV/24-25/0005', 15, '67874ba2f24b5', 1, 3000, 18, 540, 3540, '2025-01-14');

-- --------------------------------------------------------

--
-- Table structure for table `paidhistory`
--

CREATE TABLE `paidhistory` (
  `pay_id` varchar(50) NOT NULL,
  `cid` varchar(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `dateofpayment` date NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paidhistory`
--

INSERT INTO `paidhistory` (`pay_id`, `cid`, `amount`, `bank`, `dateofpayment`, `purpose`, `created`) VALUES
('T/24-25/0001', '1', 5000, 'ICICI BANK', '2025-11-10', 'kopppppppppppppppppp', '2025-01-08 21:53:21');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `hsn` int(10) NOT NULL,
  `description` varchar(30) NOT NULL,
  `p_type` varchar(50) NOT NULL,
  `img_loc` varchar(300) DEFAULT NULL,
  `techs` varchar(800) DEFAULT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `name`, `hsn`, `description`, `p_type`, `img_loc`, `techs`, `created`) VALUES
(1, 'CT- 01 HandHeld Manual Coder', 8443, 'Font Kit 2.5 mm', 'Machine', 'hand stamp.jpg', 'Printing Area : 35 x 60 mm (LxB);Prints using Grooves Rubber based stereo (3  MM); Ink- Fast dry & Water Resistant; Weight 0.5 kgs; Comes with 500ml ink, 500ml Cleaner, Groove fonts & Inkpad (2pcs)', '2020-07-02'),
(2, 'CT- 02 Handy Marker for Currogated Cartons', 8443, 'Font kit 10 mm', 'Machine', 'handy box.jpg', 'Printing Area : 3x12 inch (LxB);Prints using Grooves Rubber based stereo (12  MM); Ink Roller – Rechargeable high capacity porous ink;Impression -  1,000 per charge of 20ml / 40ml. /10 ml(depending upon no. of lines printed);Weight - 3kgs;Comes with 1 liter porus ink.', '2022-02-26'),
(3, 'CT-03 Handy Marker for HDPE Bags', 8443, 'Font kit 12mm', 'Machine', 'handy bag.jpg', 'Printing Area : 3x12 inch (LxB);Prints using Grooves Rubber based stereo (12  MM);Ink Roller – Rechargeable high capacity non porous ink;Impression -  1,000 per charge of 20ml / 40ml. /10 ml. (depending upon no. of lines printed);Weight - 3kgs;Comes with 1 liter HDPE ink, 1 Liter ink-aid & Tools.', '2022-02-26'),
(4, 'CT-05 Table Top Coder ', 8443, 'Complete set', 'Machine', 'table top.jpg', 'Printing Area – 35 x 35 mm (LxB);Operating Method – Foot Switch & Continuous Both.;Power – 230 V AC 50 Hz;Print material: rubber stereo 3 mm sheet.;Comes with -  PLC motor, Liquid Fast dry Ink(500 ml),ink Roll, Form Pad, Tools, Circuit Board controller, Cleaner(500 ml).; Printing Speed (Max) - 60 Nos/Min.;Comes with Complete protective box', '2020-12-16'),
(5, 'CT-07 Standard Multipurpose Coder', 8443, 'Wooden Packing', 'Machine', '2in1.jpg', 'Overall Dimensions: 1070 x 680 x 450;Speed: 150 cartons/min.  250 labels/min.;Pouch/Carton Size: 80mm x 40mm to 305mm x 200mm;Power : 0.5HP  3 phase;Weight: Approx. 100 Kgs;Prints using Rubber Stereo.;Materials along with m/c: 500ml paste Ink, tape roll,Tools.', '2020-12-21'),
(6, 'CT-07 Ice Cream Multipurpose Coder', 8443, 'Includes Wooden Packing', 'Machine', '2in1.jpg', 'Overall Dimensions: 1070 x 680 x 450;Speed: 150 cartons/min.  250 labels/min.;Pouch/Carton Size: 80mm x 40mm to 305mm x 200mm;Power : 0.5HP  3 phase;Weight: Approx. 100 Kgs;Prints using Rubber Stereo.;Materials along with m/c: 500ml paste Ink, tape roll,Tools.', '2020-12-21'),
(7, '2in1 coder', 8443, 'includes wooden packing', 'Machine', '2in1.jpg', 'Overall Dimensions: 1070 x 680 x 450;Speed: 150 cartons/min.  250 labels/min.;Pouch/Carton Size: 80mm x 40mm to 305mm x 200mm;Power : 0.5HP  3 phase;Weight: Approx. 100 Kgs;Prints using Rubber Stereo.;Materials along with m/c: 500ml paste Ink, tape roll,Tools.', '2020-05-05'),
(8, 'Standard Carton Coder', 8443, 'With Counting Sensor and Delta', 'Machine', 'standard carton.jpg', 'Overall Dimensions: 1010 x 690 x 590;Speed:   250 cartons/min.;Carton Size: 80mm x 25mm to 305mm x 200mm;Power : 0.5HP  3 phase;Weight: Approx. 102 Kgs;Prints using Rubber Stereo.;Materials along m/c:  500ml paste Ink, tape roll,Liquid block, Tools & Liquid ink.', '2020-05-14'),
(14, 'Inkpad', 8443, 'white font pad', 'Consumables', '', '', '2020-06-04'),
(15, 'Inkpad Holder', 8443, 'Black plastic form pad holder ', 'Consumables', '', '', '2024-10-12'),
(17, 'High Speed Carton Stracker', 8443, 'Standard', 'Machine', '', '', '2020-06-07'),
(18, 'SpgInk', 8443, 'Antifreeze', 'Consumables', '', '', '2020-06-08'),
(19, 'C - Feeding Rubber', 8443, 'Carton Feeding Rubber ', 'Consumables', '', '', '2020-06-08'),
(20, 'L - Feeding Rubber', 8443, 'Label Feeding Rubber', 'Consumables', '', '', '2020-06-08'),
(21, 'Paste Ink', 8443, 'Paste Ink', 'Consumables', '', '', '2020-06-08'),
(25, 'Black Rubber strip Plain', 8443, 'Rubber strip', 'Consumables', '', '', '2020-06-10'),
(26, 'Anti-Freeze Fast Dry Ink', 8443, 'antifreeze', 'Consumables', '', '', '2020-06-19'),
(27, 'Font Kit 3 mm', 8443, 'Normal by sunita', 'Consumables', '', '', '2020-06-26'),
(28, 'Font Kit 4 mm', 8443, 'font kit orange ', 'Consumables', '', '', '2020-06-26'),
(29, 'Groove Sheet', 8443, 'Black ', 'Consumables', '1736181106_299dea25c8011296392b.jpg', '', '2025-01-06'),
(31, 'Courier', 8443, 'trackon, mahaveer', 'Freight', 'courier.png', '', '2020-07-05'),
(32, 'Wooden Packing', 4416, 'wooden', 'Freight', '', '', '2025-02-04'),
(33, 'Freight Charges', 8443, 'freight', 'Freight', 'logistic.png', '', '2020-09-07'),
(34, 'Mini High Speed Inkjet Stacker ', 8443, 'ade', 'Machine', '', '', '2023-07-25'),
(36, 'Font Kit 2mm', 8443, 'sd', 'Consumables', '', '', '2020-06-11'),
(37, 'Ink Roll', 8443, 'hjk', 'Consumables', '', '', '2020-07-21'),
(38, 'Porous Ink Roll', 8443, '645654', 'Consumables', '', '', '2020-07-20'),
(39, 'Spring', 8443, '5654', 'Consumables', '', '', '2020-07-20'),
(40, 'TUFT Pink Belt For High Speed Stracker', 8443, 'dfgdrh', 'Consumables', '', '', '2020-07-22'),
(41, 'Grooved Logo Sheet', 8443, 'ytrhrth', 'Consumables', '', '', '2020-07-28'),
(42, 'Ink-Aid', 8443, 'INK AID', 'Consumables', '', '', '2020-08-24'),
(43, 'Standard Label Coder', 8443, 'Label Coder', 'Machine', 'standard label.jpg', 'Overall Dimensions: 880 x 530 x 460;Speed:  250 labels/min.;Label Size: 20mm x 40mm to 150mm x 200mm;Power: 0.5HP  3 phase;Weight: Approx. 80 Kgs;Prints using Rubber Stereo.;Materials along with machine: Paste ink, 2 sided tape,Tools & Feeding Rubber ', '2020-09-03'),
(44, 'High Speed Pouch Inkjet Stracker ', 8443, 'adsjdsahsdkjh', 'Machine', '', '', '2020-09-07'),
(45, 'Font Kit 12 mm', 8443, 'kjdfhkjshkl', 'Consumables', '', '', '2020-09-14'),
(46, 'Logo Sheet', 8443, 'jsdhkjsah', 'Consumables', '', '', '2020-09-14'),
(47, 'CT - 14 High Speed Inkjet Stracker', 8443, 'sjhsak', 'Machine', '', '', '2020-10-05'),
(48, 'Font Kit 25mm', 8443, 'therhgrth', 'Consumables', '', '', '2020-10-20'),
(49, 'Code Equipment', 8443, 'ddfus', 'Consumables', '', '', '2020-10-23'),
(50, 'Font kit 10 mm', 8443, 'jdsnkjd', 'Consumables', '', '', '2020-10-24'),
(51, 'Font kit 6mm', 8443, 'defewf', 'Consumables', '', '', '2020-10-29'),
(52, 'Font kit 14 mm', 8443, 'kljlkj', 'Consumables', '', '', '2020-12-14'),
(53, 'Handy Marker for Jute Bags', 8443, '8232', 'Machine', '', '', '2020-12-14'),
(54, 'Ice Cream 2in1 Coder', 8443, 'hgsdajhg', 'Machine', '', '', '2021-01-11'),
(55, 'Packing and forwarding', 8443, 'ewe', 'Freight', '', '', '2021-02-06'),
(56, 'Stereo Sheet 2mm', 8443, 'thtrfh', 'Consumables', '', '', '2021-03-06'),
(57, 'Stereo Sheet 3mm', 8443, 'fdgdtrh', 'Consumables', '', '', '2021-03-06'),
(58, '2in Gear 7.5 inch dia', 8443, 'l[ihwieoiqh', 'Consumables', '', '', '2021-03-12'),
(59, 'Feeding Rubber', 8443, 'hdjkshk', 'Consumables', '', '', '2021-03-15'),
(61, 'HDPE Bag Ink', 8443, 'fdkljhf', 'Consumables', '', '', '2020-05-28'),
(62, 'Plain Pad', 8443, 'dsjsk', 'Consumables', '', '', '2021-04-06'),
(63, '2 Sided Tape ', 8443, 'dsidsji', 'Consumables', '', '', '2021-04-06'),
(64, 'Box Ink', 8443, 'jytj', 'Consumables', '', '', '2021-04-07'),
(65, 'Font kit 8 mm', 8443, '21445', 'Consumables', '', '', '2021-04-10'),
(66, 'Delta VFD Drive + Multispan Counter', 8443, 'dslihwejkh', 'Consumables', '', '', '2021-04-13'),
(67, 'Hand Printer', 84229090, 'jkbiuljk', 'Machine', '', '', '2021-05-28'),
(68, 'High Speed Multipurpose Inkjet Stracker', 8443, 'dsljgfdjgb', 'Machine', '', '', '2021-06-04'),
(69, 'Pusher Assembly', 8443, 'edwejklujtgewuyy', 'Consumables', '', '', '2021-06-04'),
(70, 'NP Ink Roll', 8443, 'uktu', 'Consumables', '', '', '2021-06-09'),
(71, 'Handy Coder for Plywood', 8443, 'dsf.,khsdk', 'Machine', '', '', '2021-06-10'),
(72, 'Handy Marker for HDPE Bags', 8443, 'trete', 'Machine', '', '', '2021-06-14'),
(73, 'Font kit 20 mm', 8443, 'efe', 'Consumables', '', '', '2021-06-15'),
(74, 'Font kit 25 mm', 8443, 'ettewe', 'Consumables', '', '', '2021-06-25'),
(75, 'H.P Cartridge', 8443, '4564534', 'Consumables', 'hp cartridge.jpg', '47 ml Ink Cartridge;No chip Cartridge;HP Original Seal Pack Cartridge;Print Head 12.7mm;Solvent Ink;Fast Dry & Permanent ', '2021-06-26'),
(76, 'Handheld Inkjet Printer JD-007', 8443, 'kuhdfwkjjhk', 'Machine', '', '', '2021-09-30'),
(77, 'Wiper', 8443, 'adsskihdwoih', 'Consumables', '', '', '2021-07-12'),
(78, 'Thermal Inkjet Printer  -  T180', 8443, 'dfgdfsd', 'Machine', 'm 302.jpg', 'Max.Print Height : 12.7 mm;Max. Speed : 80-200 per...', '2021-07-30'),
(79, 'High Speed Medical Cassete Feeder ', 8443, 'chsdkjdh', 'Machine', '', '', '2021-08-23'),
(80, 'Black Plain PVC Belt', 8443, '44444', 'Consumables', '', '', '2021-08-31'),
(81, 'Electromechanical Coder', 8443, 'dfuugsidugg', 'Machine', '', '', '2021-09-22'),
(82, 'Metal Sensor for inkjet', 8443, 'jjdsggjuhjsdg', 'Consumables', '', '', '2021-09-24'),
(83, 'Gearbox Varam wheel with shaft', 8443, 'jsdajhkjsaha', 'Consumables', '', '', '2021-09-28'),
(84, 'Shaft Roller for Feeding Conevyor', 8443, 'kdsjgsdjg', 'Consumables', '', '', '2021-09-30'),
(85, 'High Speed Label Inkjet Feeder', 8443, 'jsdgjug', 'Machine', '', '', '2021-10-09'),
(86, 'Blue cartridge', 8443, 'gdsajhg', 'Consumables', '', '', '2021-10-13'),
(87, 'Handheld Inkjet Printer JJ-007', 8443, 'jsdguy', 'Machine', '', '', '2021-10-16'),
(88, 'H.P Solvent Cartridge', 8443, 'hgk', 'Consumables', 'hp cartridge.jpg', '47 ml Ink Cartridge;No chip Cartridge;HP Original Seal Pack Cartridge;Print Head 12.7mm;Solvent Ink;Fast Dry & Permanent ', '2021-10-21'),
(89, 'HP Water Based Cartridge', 8443, 'hgfh', 'Consumables', '', '', '2021-10-21'),
(91, 'Battery', 8443, 'gnny', 'Consumables', '', '', '2021-10-23'),
(92, 'Handy Coder for Metallic Surface', 8443, 'kjhsdiks', 'Machine', '', '', '2021-10-25'),
(93, 'Handy coder', 8443, 'kjjhdfkjh', 'Machine', '', '', '2021-11-10'),
(94, 'Handheld Inkjet printer - KGP 001', 8443, 'dhwjshvjhv', 'Machine', '', '', '2021-11-22'),
(95, 'Semi-Automatic Sticker Labeling', 8422, 'jhdsafuyf', 'Machine', '', '', '2021-11-26'),
(96, 'Extra Modification', 8422, 'isdjikk', 'Consumables', '', '', '2021-11-26'),
(97, 'Handheld Inkjet Printer - KG 001', 8443, 'jhjfdsiug', 'Machine', '', '', '2021-11-26'),
(98, 'Double bond cartridge', 8443, 'dfksuhukj', 'Consumables', 'double bond.jpg', 'Japanese Cartridge;High cohesion on Glossy Surface...', '2021-12-01'),
(99, 'Motor Belt', 8443, 'kugsdfiu', 'Consumables', '', '', '2021-12-25'),
(100, 'Simple Conveyor', 8443, '767665', 'Machine', 'simple conveyor.jpeg', 'Machine Length - 1500 mm; Machine Width -  350 mm;...', '2021-12-27'),
(101, 'Feeding Belt', 8443, 'dshkj', 'Consumables', '', '', '2021-12-31'),
(102, 'White roller with Oring', 8443, 'hdsjkgh', 'Consumables', '', '', '2021-12-31'),
(103, 'Center Roller ', 8443, 'jdfsikj', 'Consumables', '', '', '2021-12-31'),
(104, 'Encoder Wheel + Bracket', 8443, 'dsihjikjh', 'Consumables', '', '', '2021-12-31'),
(105, 'T-180 Inkjet Printer', 8443, 'dsihjikjh', 'Machine', '', '', '2022-01-03'),
(106, 'White Cartridge', 8443, 'jkbjhv', 'Consumables', '', '', '2022-01-06'),
(107, 'Handy Stand Assembly', 8443, 'bdfjeh', 'Consumables', '', '', '2022-01-10'),
(109, 'codpad printer', 8443, 'kdushkfjd', 'Machine', '', '', '2022-01-14'),
(111, 'Empty Bottle', 8443, 'kusdfgiuds', 'Consumables', '', '', '2022-01-17'),
(112, 'Encoder ', 8443, 'yryuy', 'Consumables', '', '', '2022-01-20'),
(114, 'Long Rubber -CL', 8443, 'geskj', 'Consumables', '', '', '2022-02-01'),
(115, 'Motor with Gearbox ', 8443, 'ytyt', 'Consumables', '', '', '2022-02-05'),
(116, 'Gearbox ', 8443, 'isoi', 'Consumables', '', '', '2022-02-05'),
(117, 'Duplex Gear', 8443, 'kd', 'Consumables', '', '', '2019-12-19'),
(118, 'Bronze Bush', 8443, 'jgsd', 'Consumables', '', '', '2019-12-19'),
(119, 'Reling Rubber', 8443, 'jsjhgj', 'Consumables', '', '', '2019-12-19'),
(120, 'Bosh Gear', 8443, 'kkshiu', 'Consumables', '', '', '2019-12-19'),
(121, 'Nut Bolt', 8443, 'jgsj', 'Consumables', '', '', '2020-02-24'),
(122, 'object Sensor for Inkjet', 8443, '4555', 'Consumables', '', '', '2022-03-21'),
(123, 'Solvent Ink Cartridge', 8443, 'jyj', 'Consumables', '', '', '2022-03-21'),
(124, 'Thermal  Inkjet Printer - M302 ', 8443, 'fdghrdh', 'Machine', '', '', '2022-04-11'),
(125, 'Repairing', 8443, 'yfyujyuj', 'Consumables', '', '', '2022-04-30'),
(126, 'Delta VFD Drive', 8443, 'sjdlkj', 'Consumables', '', '', '2022-05-25'),
(127, 'Green Cartridge', 8443, 'jbnj', 'Consumables', '', '', '2022-06-04'),
(128, 'Green Carton Special Belt', 8443, 'jhsdkjhsdkj', 'Consumables', '', '', '2022-09-11'),
(129, 'CT-03 Touch Screen Coder', 8443, 'rgdfg', 'Machine', '', '', '2022-11-07'),
(130, 'Touch Screen Coder', 8443, 'ihuhiu', 'Machine', '', '', '2022-11-12'),
(131, 'Mini Printer', 8443, 'esfew', 'Machine', 'mini printer.jpg', 'Max.Print Height : 12.7 mm;Max. Speed : 30-40 per/min.;LCD  Display;Comes along pen drive , HP original Seal Pack Black ink Cartridge , charger;NO Courier Charges', '2022-11-15'),
(132, 'Porous Spgink', 8443, 'hsg', 'Consumables', '', '', '2022-12-02'),
(133, 'Water Based Black Porous Ink', 8443, 'sdjgjh', 'Consumables', '', '', '2022-12-02'),
(134, 'Screw', 8443, 'lidf', 'Consumables', '', '', '2022-12-27'),
(135, 'Auto-Collector Conveyor', 8443, 'sdfdsdd', 'Machine', '', '', '2023-01-31'),
(136, 'CT - 13 Thermal Inkjet Printer ', 8443, 'kreuuijk', 'Machine', '', '', '2023-03-02'),
(137, 'Manual Induction', 8443, 'fdsfd', 'Machine', '', '', '2023-03-18'),
(138, 'Stand Bracket with sensor', 8443, 'iuoio', 'Consumables', '', '', '2023-03-27'),
(139, 'Bandsealer', 8443, 'hfhg', 'Machine', '', '', '2023-04-21'),
(140, 'weigh filler', 8443, 'uyuy', 'Machine', '', '', '2023-04-21'),
(141, 'Printer Cartridge', 8443, 'jhhk', 'Consumables', '', '', '2023-05-15'),
(142, 'Charger', 8443, 'hsdkh', 'Consumables', '', '', '2023-06-30'),
(143, 'Stereo', 8443, 'ghhfdd', 'Consumables', '', '', '2023-07-11'),
(145, 'stamp handle', 8443, 'dsfrdsfe', 'Consumables', '', '', '2023-09-29'),
(146, 'Yellow Cartridge', 8443, 'jhkj', 'Consumables', '', '', '2023-10-11'),
(147, 'Display', 8443, 'Display', 'Machine', '', '', '2023-10-16'),
(148, 'Pressure Roller for stracker', 8443, 'dfedfer', 'Consumables', '', '', '2023-11-30'),
(149, 'Print Driver Board', 8443, 'sdfhfsdkjhfi', 'Consumables', '', '', '2023-12-07'),
(150, 'Cable Strip', 8443, ',dsjhfdkjsh', 'Consumables', '', '', '2023-12-06'),
(151, 'Orings ', 8443, 'jkhsdkjhdskj', 'Consumables', '', '', '2023-12-07'),
(152, 'touch pen', 8443, 'klsdfjflkdsj', 'Consumables', '', '', '2023-12-07'),
(154, 'cartridge inserting plastic block', 8443, 'jksdhdjskh', 'Consumables', '', '', '2024-01-11'),
(155, 'Locking Stip Latch', 8443, 'dkjhkjh', 'Consumables', '', '', '2024-04-10'),
(156, 'Stand Assembly', 8443, 'wsjkeykj', 'Consumables', '', '', '2024-04-17'),
(157, 'Q Shape Plastic', 8443, '56u', 'Consumables', '', '', '2024-05-18'),
(158, 'CMos Battery Cell', 8443, 'jhgejeg', 'Consumables', '', '', '2024-05-23'),
(159, 'Touch Screen', 8443, 'dtgertr', 'Consumables', '', '', '2024-06-14'),
(160, ' Assembly for Auto-collector', 8443, 'fdkfjgkuew', 'Consumables', '', '', '2024-09-20'),
(161, 'Porter Delivery', 8443, 'sutgduig ', 'Freight', '', '', '2024-09-21'),
(165, 'flow ', 8443, 'jwe w', 'Consumables', '1736942221_14cd51e0eb5d58f3b95a.jpg', 'Printing Area : 35 x 60 mm (LxB);Prints using Grooves Rubber based stereo (3  MM); Ink- Fast dry & Water Resistant; Weight 0.5 kgs; Comes with 500ml ink, 500ml Cleaner, Groove fonts & Inkpad (2pcs)', '2025-01-15');

-- --------------------------------------------------------

--
-- Table structure for table `protest`
--

CREATE TABLE `protest` (
  `orderno` int(100) NOT NULL,
  `orderid` varchar(300) NOT NULL,
  `item_name` varchar(300) NOT NULL,
  `item_desc` varchar(300) DEFAULT NULL,
  `hsn` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `total` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `protest`
--

INSERT INTO `protest` (`orderno`, `orderid`, `item_name`, `item_desc`, `hsn`, `quantity`, `price`, `total`) VALUES
(2, '677eb8aff273c', 'CT- 01 HandHeld Manual Coder', NULL, 8443, 1, 2500, 2500),
(3, '677f497c81839', 'CT- 02 Handy Marker for Currogated Cartons', NULL, 8443, 1, 4000, 4000),
(4, '677f7a4bbdd86', 'CT-05 Table Top Coder ', NULL, 8443, 1, 30000, 30000),
(5, '677f7a5d289b4', 'Font Kit 3 mm', NULL, 8443, 1, 500, 500),
(6, '677f7a7272192', 'Inkpad Holder', NULL, 8443, 1, 50, 50),
(7, '677f7a97dba57', '2in1 coder', NULL, 8443, 1, 50000, 50000),
(9, '677f7aaae39a5', 'CT-05 Table Top Coder ', NULL, 8443, 1, 35000, 35000),
(10, '678747a3b1ea1', 'CT- 01 HandHeld Manual Coder', NULL, 8443, 1, 3000, 3000),
(12, '67874af9f182a', 'CT- 02 Handy Marker for Currogated Cartons', NULL, 8443, 1, 4000, 4000);

-- --------------------------------------------------------

--
-- Table structure for table `protest2`
--

CREATE TABLE `protest2` (
  `invid` varchar(100) NOT NULL,
  `cid` int(10) NOT NULL,
  `orderid` varchar(300) NOT NULL,
  `totalitems` int(10) NOT NULL,
  `subtotal` int(100) NOT NULL,
  `taxrate` int(10) NOT NULL,
  `taxamount` int(100) NOT NULL,
  `totalamount` int(100) NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `protest2`
--

INSERT INTO `protest2` (`invid`, `cid`, `orderid`, `totalitems`, `subtotal`, `taxrate`, `taxamount`, `totalamount`, `created`) VALUES
(' PI/24-25/0001', 1, '677eb8aff273c', 1, 2500, 18, 450, 2950, '2025-01-08'),
(' PI/24-25/0002', 4, '677f497c81839', 1, 4000, 18, 720, 4720, '2025-01-08'),
(' PI/24-25/0003', 7, '677f7a4bbdd86', 1, 30000, 18, 5400, 35400, '2025-01-09'),
(' PI/24-25/0004', 7, '677f7a5d289b4', 1, 500, 18, 90, 590, '2025-01-09'),
(' PI/24-25/0005', 6, '677f7a7272192', 1, 50, 18, 9, 59, '2025-01-09'),
(' PI/24-25/0006', 4, '677f7a97dba57', 1, 50000, 18, 9000, 59000, '2025-01-09'),
(' PI/24-25/0007', 7, '677f7aaae39a5', 1, 35000, 18, 6300, 41300, '2025-01-09'),
(' PI/24-25/0008', 6, '678747a3b1ea1', 1, 3000, 18, 540, 3540, '2025-01-14'),
(' PI/24-25/0009', 1, '67874af9f182a', 1, 4000, 18, 720, 4720, '2025-01-14');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseinv`
--

CREATE TABLE `purchaseinv` (
  `orderno` int(100) NOT NULL,
  `orderid` varchar(300) NOT NULL,
  `item_name` varchar(300) NOT NULL,
  `item_desc` varchar(300) DEFAULT NULL,
  `hsn` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `total` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchaseinv`
--

INSERT INTO `purchaseinv` (`orderno`, `orderid`, `item_name`, `item_desc`, `hsn`, `quantity`, `price`, `total`) VALUES
(3, '677eb80c7a165', 'CT- 01 HandHeld Manual Coder', NULL, 8443, 1, 3000, 3000),
(4, '677eb7ba2e3c8', 'Wooden Packing', NULL, 4416, 1, 3000, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `purchaseinv2`
--

CREATE TABLE `purchaseinv2` (
  `nid` int(100) NOT NULL,
  `invid` varchar(100) NOT NULL,
  `cid` int(10) NOT NULL,
  `invdate` date NOT NULL,
  `orderid` varchar(300) NOT NULL,
  `totalitems` int(10) NOT NULL,
  `subtotal` int(100) NOT NULL,
  `taxrate` int(10) NOT NULL,
  `taxamount` int(100) NOT NULL,
  `totalamount` int(100) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchaseinv2`
--

INSERT INTO `purchaseinv2` (`nid`, `invid`, `cid`, `invdate`, `orderid`, `totalitems`, `subtotal`, `taxrate`, `taxamount`, `totalamount`, `created`) VALUES
(1, '11', 1, '2025-01-08', '677eb7ba2e3c8', 1, 3000, 18, 540, 3540, '2025-01-15 06:42:25'),
(2, '1', 14, '2025-01-05', '677eb80c7a165', 1, 3000, 18, 540, 3540, '2025-01-08 11:38:20');

-- --------------------------------------------------------

--
-- Table structure for table `quickquote`
--

CREATE TABLE `quickquote` (
  `sr_no` int(11) NOT NULL,
  `q_id` varchar(50) NOT NULL,
  `p_id` int(50) NOT NULL,
  `mob` varchar(50) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `price` varchar(50) NOT NULL,
  `subtotal` int(50) NOT NULL,
  `gst` int(50) NOT NULL,
  `total` int(50) NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quickquote`
--

INSERT INTO `quickquote` (`sr_no`, `q_id`, `p_id`, `mob`, `quantity`, `price`, `subtotal`, `gst`, `total`, `created`) VALUES
(1, 'QUICKT/24-25/0001', 2, '7412589630', '1', '650', 650, 117, 767, '2025-01-07'),
(2, 'QUICKT/24-25/0002', 4, '748561023', '1', '5000', 5000, 900, 5900, '2025-01-07'),
(3, 'QUICKT/24-25/0003', 4, '7485961023', '1', '50', 50, 9, 59, '2025-01-07'),
(4, 'QUICKT/24-25/0004', 1, '9632587410', '1', '55', 55, 10, 65, '2025-01-07'),
(5, 'QUICKT/24-25/0005', 75, '7412589630', '1', '40', 40, 7, 47, '2025-01-07'),
(6, 'QUICKT/24-25/0006', 43, '8735003590', '1', '50000', 50000, 9000, 59000, '2025-01-07'),
(7, 'QUICKT/24-25/0007', 4, '8760152410', '1', '500', 500, 90, 590, '2025-01-07'),
(8, 'QUICKT/24-25/0008', 1, '8735003590', '1', '450', 450, 81, 531, '2025-01-08'),
(9, 'QUICKT/24-25/0009', 1, '7016419537', '1', '500', 500, 90, 590, '2025-01-08'),
(10, 'QUICKT/24-25/0010', 1, '8735003590', '1', '500', 500, 90, 590, '2025-01-08'),
(11, 'QUICKT/24-25/0011', 4, '8735003590', '1', '30000', 30000, 5400, 35400, '2025-01-08'),
(12, 'QUICKT/24-25/0012', 1, '7600158240', '1', '50', 50, 9, 59, '2025-01-08'),
(13, 'QUICKT/24-25/0013', 4, '8735003590', '1', '500', 500, 90, 590, '2025-01-08');

-- --------------------------------------------------------

--
-- Table structure for table `quote`
--

CREATE TABLE `quote` (
  `orderno` int(100) NOT NULL,
  `orderid` varchar(300) NOT NULL,
  `item_name` varchar(300) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `total` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quote`
--

INSERT INTO `quote` (`orderno`, `orderid`, `item_name`, `quantity`, `price`, `total`) VALUES
(2, '677eb8506b620', 'CT- 01 HandHeld Manual Coder', 1, 3000, 3000),
(5, '677f583470f5f', 'CT- 01 HandHeld Manual Coder', 1, 3000, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `quote2`
--

CREATE TABLE `quote2` (
  `invid` varchar(100) NOT NULL,
  `cid` int(10) NOT NULL,
  `orderid` varchar(300) NOT NULL,
  `totalitems` int(10) NOT NULL,
  `subtotal` int(100) NOT NULL,
  `taxrate` int(10) NOT NULL,
  `taxamount` int(100) NOT NULL,
  `totalamount` int(100) NOT NULL,
  `created` date NOT NULL,
  `note` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quote2`
--

INSERT INTO `quote2` (`invid`, `cid`, `orderid`, `totalitems`, `subtotal`, `taxrate`, `taxamount`, `totalamount`, `created`, `note`) VALUES
('QT/24-25/0001', 6, '677eb8506b620', 1, 3000, 18, 540, 3540, '2025-01-08', ''),
('QT/24-25/0002', 4, '677f583470f5f', 1, 3000, 18, 540, 3540, '2025-01-08', '');

-- --------------------------------------------------------

--
-- Table structure for table `techsps`
--

CREATE TABLE `techsps` (
  `tid` int(5) NOT NULL,
  `p_id` int(5) NOT NULL,
  `img_loc` varchar(300) DEFAULT NULL,
  `techs` varchar(800) DEFAULT NULL,
  `subcat` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `techsps`
--

INSERT INTO `techsps` (`tid`, `p_id`, `img_loc`, `techs`, `subcat`) VALUES
(1, 1, 'hand stamp.jpg', 'Printing Area : 35 x 60 mm (LxB);Prints using Grooves Rubber based stereo (3  MM); Ink- Fast dry & Water Resistant; Weight 0.5 kgs; Comes with 500ml ink, 500ml Cleaner, Groove fonts & Inkpad (2pcs)', 'Manual Batch Coding Machine'),
(2, 2, 'handy box.jpg', 'Printing Area : 3x12 inch (LxB);Prints using Grooves Rubber based stereo (12  MM); Ink Roller – Rechargeable high capacity porous ink;Impression -  1,000 per charge of 20ml / 40ml. /10 ml(depending upon no. of lines printed);Weight - 3kgs;Comes with 1 liter porus ink.', 'Manual Batch Coding Machine'),
(3, 3, 'handy bag.jpg', 'Printing Area : 3x12 inch (LxB);Prints using Grooves Rubber based stereo (12  MM);Ink Roller – Rechargeable high capacity non porous ink;Impression -  1,000 per charge of 20ml / 40ml. /10 ml. (depending upon no. of lines printed);Weight - 3kgs;Comes with 1 liter HDPE ink, 1 Liter ink-aid & Tools.', 'Manual Batch Coding Machine'),
(4, 4, 'table top.jpg', 'Printing Area – 35 x 35 mm (LxB);Operating Method – Foot Switch & Continuous Both.;Power – 230 V AC 50 Hz;Print material: rubber stereo 3 mm sheet.;Comes with -  PLC motor, Liquid Fast dry Ink(500 ml),ink Roll, Form Pad, Tools, Circuit Board controller, Cleaner(500 ml).; Printing Speed (Max) - 60 Nos/Min.;Comes with Complete protective box', 'Semi Automatic Batch Coding Machine'),
(5, 87, 'handheld inkjet.jpg', 'Max.Print Height : 12.7 mm;Max. Speed : 30-40 per/min.;LCD Display with print head;Comes along pen drive, ink cartridge, charger, SS Frame & Battery;1 year warranty;NO Courier Charges', 'Handy Inkjet Printer'),
(6, 5, '2in1.jpg', 'Overall Dimensions: 1070 x 680 x 450;Speed: 150 cartons/min.  250 labels/min.;Pouch/Carton Size: 80mm x 40mm to 305mm x 200mm;Power : 0.5HP  3 phase;Weight: Approx. 100 Kgs;Prints using Rubber Stereo.;Materials along with m/c: 500ml paste Ink, tape roll,Tools.', 'Automatic Batch Coding Machine'),
(7, 76, 'Handheld inkjet printer.jpg', 'Max.Print Height : 12. 7 mm;Max. Speed : 30-40 per/min.;LCD Display with print head;Comes along pen drive, ink cartridge, charger, SS Frame & Battery;1 year warranty;NO Courier Charges', 'Handy Inkjet Printer'),
(8, 7, '2in1.jpg', 'Overall Dimensions: 1070 x 680 x 450;Speed: 150 cartons/min.  250 labels/min.;Pouch/Carton Size: 80mm x 40mm to 305mm x 200mm;Power : 0.5HP  3 phase;Weight: Approx. 100 Kgs;Prints using Rubber Stereo.;Materials along with m/c: 500ml paste Ink, tape roll,Tools.', 'Automatic Batch Coding Machines'),
(9, 6, '2in1.jpg', 'Overall Dimensions: 1070 x 680 x 450;Speed: 150 cartons/min.  250 labels/min.;Pouch/Carton Size: 80mm x 40mm to 305mm x 200mm;Power : 0.5HP  3 phase;Weight: Approx. 100 Kgs;Prints using Rubber Stereo.;Materials along with m/c: 500ml paste Ink, tape roll,Tools.', 'Automatic Batch Coding Machines'),
(10, 81, 'table top.jpg', 'Printing Area – 35 x 35 mm (LxB);Operating Method – Foot Switch & Continuous Both.;Power – 230 V AC 50 Hz;Print material: rubber stereo 3 mm sheet.;Comes with -  PLC motor, Liquid Fast dry Ink(500 ml),ink Roll, Form Pad, Tools, Circuit Board controller, Cleaner(500 ml).; Printing Speed (Max) - 60 Nos/Min.;Comes with Complete protective box', 'Semi Automatic Batch Coding Machine'),
(11, 8, 'standard carton.jpg', 'Overall Dimensions: 1010 x 690 x 590;Speed:   250 cartons/min.;Carton Size: 80mm x 25mm to 305mm x 200mm;Power : 0.5HP  3 phase;Weight: Approx. 102 Kgs;Prints using Rubber Stereo.;Materials along m/c:  500ml paste Ink, tape roll,Liquid block, Tools & Liquid ink.', 'Automatic Batch coding Machine'),
(12, 43, 'standard label.jpg', 'Overall Dimensions: 880 x 530 x 460;Speed:  250 labels/min.;Label Size: 20mm x 40mm to 150mm x 200mm;Power: 0.5HP  3 phase;Weight: Approx. 80 Kgs;Prints using Rubber Stereo.;Materials along with machine: Paste ink, 2 sided tape,Tools & Feeding Rubber ', 'Automatic Batch coding Machine'),
(13, 131, 'mini printer.jpg', 'Max.Print Height : 12.7 mm;Max. Speed : 30-40 per/min.;LCD  Display;Comes along pen drive , HP original Seal Pack Black ink Cartridge , charger;NO Courier Charges', 'Handy Inkjet Printer'),
(14, 75, 'hp cartridge.jpg', '47 ml Ink Cartridge;No chip Cartridge;HP Original Seal Pack Cartridge;Print Head 12.7mm;Solvent Ink;Fast Dry & Permanent \n', 'Handy Inkjet Printer'),
(15, 88, 'hp cartridge.jpg', '47 ml Ink Cartridge;No chip Cartridge;HP Original Seal Pack Cartridge;Print Head 12.7mm;Solvent Ink;Fast Dry & Permanent \n', 'Handy Inkjet Printer'),
(16, 98, 'double bond.jpg', 'Japanese Cartridge;High cohesion on Glossy Surface;Permanent impression Guaranteed;Print material: Glossy surface, Glass bottles etc', 'Handy Inkjet Printer'),
(17, 100, 'simple conveyor.jpeg', 'Machine Length - 1500 mm; Machine Width -  350 mm;Conveyor Belt Width – 300 mm;Fully SS Make;0.25 HP Motor with Speed Controller;Completely Foldable type   \r\n', 'conveyor'),
(18, 113, 'simple conveyor.jpeg', 'Machine Length - 1500 mm; Machine Width -  350 mm;Conveyor Belt Width – 300 mm;Fully SS Make;0.25 HP Motor with Speed Controller;Completely Foldable type   \r\n', 'conveyor'),
(19, 78, 'm 302.jpg', 'Max.Print Height : 12.7 mm;Max. Speed : 80-200 per/min. (depends upon the size of samples);LCD  Display with print head;Comes along pen drive,Solvent Ink (Black) cartridge & charger.;Comes with Additional Stand assembly for attachment in conveyor & Metal sensor; Unlock Machine;1 year warranty', 'Online Printers'),
(20, 124, 'm 302.jpg', 'Max.Print Height : 12.7 mm;Max. Speed : 80-200 per/min. (depends upon the size of samples);LCD  Display with print head;Comes along pen drive,Solvent Ink (Black) cartridge & charger.;Comes with Additional Stand assembly for attachment in conveyor & Metal sensor; Unlock Machine;1 year warranty\r\n', 'Online Printers'),
(21, 105, 'm 302.jpg', 'Max.Print Height : 12.7 mm;Max. Speed : 80-200 per/min. (depends upon the size of samples);LCD  Display with print head;Comes along pen drive,Solvent Ink (Black) cartridge & charger.;Comes with Additional Stand assembly for attachment in conveyor & Metal sensor; Unlock Machine;1 year warranty\r\n', 'Online Printers'),
(22, 109, 'm 302.jpg', 'Max.Print Height : 12.7 mm;Max. Speed : 80-200 per/min. (depends upon the size of samples);LCD  Display with print head;Comes along pen drive,Solvent Ink (Black) cartridge & charger.;Comes with Additional Stand assembly for attachment in conveyor & Metal sensor; Unlock Machine;1 year warranty\r\n', 'Online Printers'),
(23, 136, 'CT 13.jpeg', 'Max.Print Height : 50 mm [Each head 25 mm];Max. Speed : 120-300 per/min. (depends upon the size of samples);LCD  Display with print head;Comes along pen drive, Solvent Ink (Black) cartridge & Power charger.;Comes with Additional Stand assembly for attachment in conveyor & Metal sensor;1 year warranty\r\n', 'Online Printers');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `acc_type`
--
ALTER TABLE `acc_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bankdetails`
--
ALTER TABLE `bankdetails`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `clienttype`
--
ALTER TABLE `clienttype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  ADD PRIMARY KEY (`delid`);

--
-- Indexes for table `fd`
--
ALTER TABLE `fd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fest`
--
ALTER TABLE `fest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invtest`
--
ALTER TABLE `invtest`
  ADD PRIMARY KEY (`orderno`);

--
-- Indexes for table `invtest2`
--
ALTER TABLE `invtest2`
  ADD PRIMARY KEY (`invid`);

--
-- Indexes for table `paidhistory`
--
ALTER TABLE `paidhistory`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `protest`
--
ALTER TABLE `protest`
  ADD PRIMARY KEY (`orderno`);

--
-- Indexes for table `protest2`
--
ALTER TABLE `protest2`
  ADD PRIMARY KEY (`invid`);

--
-- Indexes for table `purchaseinv`
--
ALTER TABLE `purchaseinv`
  ADD PRIMARY KEY (`orderno`);

--
-- Indexes for table `purchaseinv2`
--
ALTER TABLE `purchaseinv2`
  ADD PRIMARY KEY (`nid`);

--
-- Indexes for table `quickquote`
--
ALTER TABLE `quickquote`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `quote`
--
ALTER TABLE `quote`
  ADD PRIMARY KEY (`orderno`);

--
-- Indexes for table `quote2`
--
ALTER TABLE `quote2`
  ADD PRIMARY KEY (`invid`);

--
-- Indexes for table `techsps`
--
ALTER TABLE `techsps`
  ADD PRIMARY KEY (`tid`),
  ADD KEY `fk` (`p_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `acc_type`
--
ALTER TABLE `acc_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bankdetails`
--
ALTER TABLE `bankdetails`
  MODIFY `bid` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `cid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  MODIFY `delid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fd`
--
ALTER TABLE `fd`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fest`
--
ALTER TABLE `fest`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invtest`
--
ALTER TABLE `invtest`
  MODIFY `orderno` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT for table `protest`
--
ALTER TABLE `protest`
  MODIFY `orderno` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `purchaseinv`
--
ALTER TABLE `purchaseinv`
  MODIFY `orderno` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchaseinv2`
--
ALTER TABLE `purchaseinv2`
  MODIFY `nid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quickquote`
--
ALTER TABLE `quickquote`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `quote`
--
ALTER TABLE `quote`
  MODIFY `orderno` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `techsps`
--
ALTER TABLE `techsps`
  MODIFY `tid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
