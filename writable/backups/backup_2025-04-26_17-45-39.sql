SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET NAMES utf8 */;

-- Database Backup: `db`



CREATE TABLE `acc_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO `acc_type` VALUES 
('0','Customer'),
('1','Supplier'),
('2','Dual (Cust/Sup)');



CREATE TABLE `account` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `acc_type` int(11) NOT NULL,
  `opening_bal` double NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



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
  `picturelogo` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin` VALUES 
('1','admin@gmail.com','admin@123','Tejas Rajput','codetech32@xxxxxx.com','B-Tech at LJ University','Jamnagar, Gujarat','[\"test ,from\"]','CodeTech Engineers 1','A 4/1 Suryanagar Soc., Jawahar Chowk, xxx, Ahmedabad- 380009','Web Developer','+91-973769xxxx / +91-7600158xxx','24AVVPC8158XXX1','AVVPC815X1','1745669592_d8044a2d210a4ee636c4.jpeg','1745669680_8606dd248e7357350774.png');



CREATE TABLE `bankdetails` (
  `bid` int(50) NOT NULL AUTO_INCREMENT,
  `bname` varchar(300) NOT NULL,
  `ac` varchar(300) NOT NULL,
  `ifsc` varchar(300) NOT NULL,
  `branch` varchar(300) NOT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO `bankdetails` VALUES 
('1','ICICI BANK','6424555555xxx','ICICI000xxx','Mahura Road');



CREATE TABLE `client` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(80) NOT NULL,
  `c_add` varchar(200) NOT NULL,
  `mob` varchar(50) NOT NULL,
  `country` varchar(100) NOT NULL,
  `gst` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `c_type` varchar(4) NOT NULL,
  `u_type` tinyint(1) NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

INSERT INTO `client` VALUES 
('1','Food inox1','3/4 jalgaon - 758571','+918735003591','India','1234567891','fdinox@gmail.com','IGST','0','2025-04-24'),
('2','Food berry','1-2, GIDC, vatva - 380008','+918735003590','India','7894561230','foodberry@gmail.com','Loc','0','2025-04-24'),
('4','Chemoplastic','sumeru, rajasthan','+918735003590','India','24AVVPC8158M1ZV','','IGST','0','2025-04-24'),
('5','FROZEN PERRY','midc, Mumbai','+918735003590','India','9874563210','','Loc','0','2025-04-24'),
('6','Destro gen1','mumbai - 380008','+918735003591','India ','8523697410','','IGST','1','2025-04-24'),
('7','Romio','UP','+918735003590','India','9632587410','','Loc','2','2025-04-24');



CREATE TABLE `clienttype` (
  `id` int(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `clienttype` VALUES 
('1','IGST'),
('2','Loc');



CREATE TABLE `delivery_addresses` (
  `delid` int(11) NOT NULL AUTO_INCREMENT,
  `invid` varchar(50) NOT NULL,
  `name` varchar(80) NOT NULL,
  `address` varchar(200) NOT NULL,
  `mob` varchar(50) NOT NULL,
  PRIMARY KEY (`delid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `fd` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fdissueddate` date DEFAULT NULL,
  `fdholder` varchar(50) NOT NULL,
  `fdofbank` varchar(100) NOT NULL,
  `principleamt` int(20) NOT NULL,
  `nodays` varchar(20) NOT NULL,
  `intrate` varchar(10) NOT NULL,
  `intamt` int(10) NOT NULL,
  `finalamt` int(20) NOT NULL,
  `maturitydate` date NOT NULL,
  `fdentrydate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

INSERT INTO `fd` VALUES 
('1','2024-03-02','Tejas','Saraswat Bank','51418','0.5','5.75','1458','52876','2024-08-29','2024-03-21 20:38:50');



CREATE TABLE `fest` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` varchar(50) NOT NULL,
  `fest_name` varchar(250) NOT NULL,
  `gifs` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO `fest` VALUES 
('1','18-Feb','Maha Shivaratri','best mahashivratri.gif'),
('2','09-Jul','Holi','happy-holi.gif\r\n\n\n\n\n');



CREATE TABLE `invtest` (
  `orderno` int(100) NOT NULL AUTO_INCREMENT,
  `orderid` varchar(300) NOT NULL,
  `item_name` varchar(300) NOT NULL,
  `item_desc` varchar(300) DEFAULT NULL,
  `hsn` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `total` int(100) NOT NULL,
  PRIMARY KEY (`orderno`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

INSERT INTO `invtest` VALUES 
('1','680cc8f1ced98','CT- 01 HandHeld Manual Coder',NULL,'8443','1','300','300'),
('2','680cc91b3c3c1','CT- 02 Handy Marker for Currogated Cartons',NULL,'8443','1','450','450'),
('3','680cc91b3c3c1','Courier',NULL,'8443','1','52','52');



CREATE TABLE `invtest2` (
  `invid` varchar(100) NOT NULL,
  `cid` int(10) NOT NULL,
  `orderid` varchar(300) NOT NULL,
  `totalitems` int(10) NOT NULL,
  `subtotal` int(100) NOT NULL,
  `taxrate` int(10) NOT NULL,
  `taxamount` int(100) NOT NULL,
  `totalamount` int(100) NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`invid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `invtest2` VALUES 
('INV/25-26/0001','5','680cc8f1ced98','1','300','18','54','354','2025-04-26'),
('INV/25-26/0002','7','680cc91b3c3c1','2','502','18','91','593','2025-04-26');



CREATE TABLE `paidhistory` (
  `pay_id` varchar(50) NOT NULL,
  `cid` varchar(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `dateofpayment` date NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`pay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `products` (
  `p_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `hsn` int(10) NOT NULL,
  `description` varchar(30) NOT NULL,
  `p_type` varchar(50) NOT NULL,
  `cattype` varchar(20) NOT NULL,
  `img_loc` varchar(300) DEFAULT NULL,
  `techs` varchar(800) DEFAULT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=184 DEFAULT CHARSET=utf8mb4;

INSERT INTO `products` VALUES 
('1','CT- 01 HandHeld Manual Coder','8443','Font Kit 2.5 mm','Machine','Manual','hand stamp.jpg','Printing Area : 35 x 60 mm (LxB);Prints using Grooves Rubber based stereo (3  MM); Ink- Fast dry & Water Resistant; Weight 0.5 kgs; Comes with 500ml ink, 500ml Cleaner, Groove fonts & Inkpad (2pcs)','2020-07-02'),
('2','CT- 02 Handy Marker for Currogated Cartons','8443','Font kit 10 mm','Machine','Manual','handy box.jpg','Printing Area : 3x12 inch (LxB);Prints using Grooves Rubber based stereo (12  MM); Ink Roller – Rechargeable high capacity porous ink;Impression -  1,000 per charge of 20ml / 40ml. /10 ml(depending upon no. of lines printed);Weight - 3kgs;Comes with 1 liter porus ink.','2022-02-26'),
('3','CT-03 Handy Marker for HDPE Bags','8443','Font kit 12mm','Machine','Manual','handy bag.jpg','Printing Area : 3x12 inch (LxB);Prints using Grooves Rubber based stereo (12  MM);Ink Roller – Rechargeable high capacity non porous ink;Impression -  1,000 per charge of 20ml / 40ml. /10 ml. (depending upon no. of lines printed);Weight - 3kgs;Comes with 1 liter HDPE ink, 1 Liter ink-aid & Tools.','2022-02-26'),
('4','CT-05 Table Top Coder ','8443','Complete set','Machine','Semi-Auomatic','table top.jpg','Printing Area – 35 x 35 mm (LxB);Operating Method – Foot Switch & Continuous Both.;Power – 230 V AC 50 Hz;Print material: rubber stereo 3 mm sheet.;Comes with -  PLC motor, Liquid Fast dry Ink(500 ml),ink Roll, Form Pad, Tools, Circuit Board controller, Cleaner(500 ml).; Printing Speed (Max) - 60 Nos/Min.;Comes with Complete protective box','2020-12-16'),
('5','CT-07 Standard Multipurpose Coder','8443','Wooden Packing','Machine','Automatic','','','2020-12-21'),
('6','CT-07 Ice Cream Multipurpose Coder','8443','Includes Wooden Packing','Machine','Automatic','','','2020-12-21'),
('7','2in1 coder','8443','includes wooden packing','Machine','Automatic','','','2020-05-05'),
('8','Standard Carton Coder','8443','With Counting Sensor and Delta','Machine','Automatic','','','2020-05-14'),
('14','Inkpad','8443','white font pad','Consumables','Manual','','','2020-06-04'),
('15','Inkpad Holder','8443','Black plastic form pad holder','Consumables','Manual','','','2020-06-04'),
('17','High Speed Carton Stracker','8443','Standard','Machine','Automatic','1739626927_b55f2499a5e3236a1130.jpg',NULL,'2025-02-15'),
('18','SpgInk','8443','Antifreeze','Consumables','Manual','','','2020-06-08'),
('19','C - Feeding Rubber','8443','Carton Feeding Rubber ','Consumables','Automatic','','','2020-06-08'),
('20','L - Feeding Rubber','8443','Label Feeding Rubber','Consumables','','','','2020-06-08'),
('21','Paste Ink','8443','Paste Ink','Consumables','','','','2020-06-08'),
('25','Black Rubber strip Plain','8443','Rubber strip','Consumables','','','','2020-06-10'),
('26','Anti-Freeze Fast Dry Ink','8443','antifreeze','Consumables','','','','2020-06-19'),
('27','Font Kit 3 mm','8443','Normal by sunita','Consumables','','','','2020-06-26'),
('28','Font Kit 4 mm','8443','font kit orange ','Consumables','','','','2020-06-26'),
('29','Groove Sheet','8443','Black ','Consumables','','','','2020-06-26'),
('31','Courier','8443','trackon, mahaveer','Freight','','courier.png','','2020-07-05'),
('32','Wooden Packing','4416','wooden','Freight','','','','2025-02-04'),
('33','Freight Charges','8443','freight','Freight','','logistic.png','','2020-09-07'),
('34','Mini High Speed Inkjet Stacker ','8443','ade','Machine','','','','2023-07-25'),
('36','Font Kit 2mm','8443','sd','Consumables','','','','2020-06-11'),
('37','Ink Roll','8443','hjk','Consumables','','','','2020-07-21'),
('38','Porous Ink Roll','8443','645654','Consumables','','','','2020-07-20'),
('39','Spring','8443','5654','Consumables','','','','2020-07-20'),
('40','TUFT Pink Belt For High Speed Stracker','8443','dfgdrh','Consumables','','','','2020-07-22'),
('41','Grooved Logo Sheet','8443','ytrhrth','Consumables','','','','2020-07-28'),
('42','Ink-Aid','8443','INK AID','Consumables','','','','2020-08-24'),
('43','Standard Label Coder','8443','Label Coder','Machine','','standard label.jpg','Overall Dimensions: 880 x 530 x 460;Speed:  250 labels/min.;Label Size: 20mm x 40mm to 150mm x 200mm;Power: 0.5HP  3 phase;Weight: Approx. 80 Kgs;Prints using Rubber Stereo.;Materials along with machine: Paste ink, 2 sided tape,Tools & Feeding Rubber ','2020-09-03'),
('44','High Speed Pouch Inkjet Stracker ','8443','adsjdsahsdkjh','Machine','','','','2020-09-07'),
('45','Font Kit 12 mm','8443','kjdfhkjshkl','Consumables','','','','2020-09-14'),
('46','Logo Sheet','8443','jsdhkjsah','Consumables','','','','2020-09-14'),
('47','CT - 14 High Speed Inkjet Stracker','8443','sjhsak','Machine','','','','2020-10-05'),
('48','Font Kit 25mm','8443','therhgrth','Consumables','','','','2020-10-20'),
('49','Code Equipment','8443','ddfus','Consumables','','','','2020-10-23'),
('50','Font kit 10 mm','8443','jdsnkjd','Consumables','','','','2020-10-24'),
('51','Font kit 6mm','8443','defewf','Consumables','','','','2020-10-29'),
('52','Font kit 14 mm','8443','kljlkj','Consumables','','','','2020-12-14'),
('53','Handy Marker for Jute Bags','8443','8232','Machine','','','','2020-12-14'),
('54','Ice Cream 2in1 Coder','8443','hgsdajhg','Machine','','','','2021-01-11'),
('55','Packing and forwarding','8443','ewe','Freight','','','','2021-02-06'),
('56','Stereo Sheet 2mm','8443','thtrfh','Consumables','','','','2021-03-06'),
('57','Stereo Sheet 3mm','8443','fdgdtrh','Consumables','','','','2021-03-06'),
('58','2in Gear 7.5 inch dia','8443','l[ihwieoiqh','Consumables','','','','2021-03-12'),
('59','Feeding Rubber','8443','hdjkshk','Consumables','','','','2021-03-15'),
('61','HDPE Bag Ink','8443','fdkljhf','Consumables','','','','2020-05-28'),
('62','Plain Pad','8443','dsjsk','Consumables','','','','2021-04-06'),
('63','2 Sided Tape ','8443','dsidsji','Consumables','','','','2021-04-06'),
('64','Box Ink','8443','jytj','Consumables','','','','2021-04-07'),
('65','Font kit 8 mm','8443','21445','Consumables','','','','2021-04-10'),
('66','Delta VFD Drive + Multispan Counter','8443','dslihwejkh','Consumables','','','','2021-04-13'),
('67','Hand Printer','84229090','jkbiuljk','Machine','','','','2021-05-28'),
('68','High Speed Multipurpose Inkjet Stracker','8443','dsljgfdjgb','Machine','','','','2021-06-04'),
('69','Pusher Assembly','8443','edwejklujtgewuyy','Consumables','','','','2021-06-04'),
('70','NP Ink Roll','8443','uktu','Consumables','','','','2021-06-09'),
('71','Handy Coder for Plywood','8443','dsf.,khsdk','Machine','','','','2021-06-10'),
('72','Handy Marker for HDPE Bags','8443','trete','Machine','','','','2021-06-14'),
('73','Font kit 20 mm','8443','efe','Consumables','','','','2021-06-15'),
('74','Font kit 25 mm','8443','ettewe','Consumables','','','','2021-06-25'),
('75','H.P Cartridge','8443','4564534','Consumables','','hp cartridge.jpg','47 ml Ink Cartridge;No chip Cartridge;HP Original Seal Pack Cartridge;Print Head 12.7mm;Solvent Ink;Fast Dry & Permanent ','2021-06-26'),
('76','Handheld Inkjet Printer JD-007','8443','kuhdfwkjjhk','Machine','','1739627709_502f505adde0b574abea.png',NULL,'2025-02-15'),
('77','Wiper','8443','adsskihdwoih','Consumables','','','','2021-07-12'),
('78','Thermal Inkjet Printer  -  T180','8443','dfgdfsd','Machine','','m 302.jpg','Max.Print Height : 12.7 mm;Max. Speed : 80-200 per...','2021-07-30'),
('79','High Speed Medical Cassete Feeder ','8443','chsdkjdh','Machine','','','','2021-08-23'),
('80','Black Plain PVC Belt','8443','44444','Consumables','','','','2021-08-31'),
('81','Electromechanical Coder','8443','dfuugsidugg','Machine','','','','2021-09-22'),
('82','Metal Sensor for inkjet','8443','jjdsggjuhjsdg','Consumables','','','','2021-09-24'),
('83','Gearbox Varam wheel with shaft','8443','jsdajhkjsaha','Consumables','','','','2021-09-28'),
('84','Shaft Roller for Feeding Conevyor','8443','kdsjgsdjg','Consumables','','','','2021-09-30'),
('85','High Speed Label Inkjet Feeder','8443','jsdgjug','Machine','','','','2021-10-09'),
('86','Blue cartridge','8443','gdsajhg','Consumables','','','','2021-10-13'),
('87','Handheld Inkjet Printer JJ-007','8443','jsdguy','Machine','','','','2021-10-16'),
('88','H.P Solvent Cartridge','8443','hgk','Consumables','','hp cartridge.jpg','47 ml Ink Cartridge;No chip Cartridge;HP Original Seal Pack Cartridge;Print Head 12.7mm;Solvent Ink;Fast Dry & Permanent ','2021-10-21'),
('89','HP Water Based Cartridge','8443','hgfh','Consumables','','','','2021-10-21'),
('91','Battery','8443','gnny','Consumables','','','','2021-10-23'),
('92','Handy Coder for Metallic Surface','8443','kjhsdiks','Machine','','','','2021-10-25'),
('93','Handy coder','8443','kjjhdfkjh','Machine','','','','2021-11-10'),
('94','Handheld Inkjet printer - KGP 001','8443','dhwjshvjhv','Machine','','1745486601_7896f2a62c8359465b20.jpg',NULL,'2025-04-24'),
('95','Semi-Automatic Sticker Labeling','8422','jhdsafuyf','Machine','','','','2021-11-26'),
('96','Extra Modification','8422','isdjikk','Consumables','','','','2021-11-26'),
('97','Handheld Inkjet Printer - KG 001','8443','jhjfdsiug','Machine','','','','2021-11-26'),
('98','Double bond cartridge','8443','dfksuhukj','Consumables','','double bond.jpg','Japanese Cartridge;High cohesion on Glossy Surface...','2021-12-01'),
('99','Motor Belt','8443','kugsdfiu','Consumables','','','','2021-12-25'),
('100','Simple Conveyor','8443','767665','Machine','','simple conveyor.jpeg','Machine Length - 1500 mm; Machine Width -  350 mm;...','2021-12-27'),
('101','Feeding Belt','8443','dshkj','Consumables','','','','2021-12-31'),
('102','White roller with Oring','8443','hdsjkgh','Consumables','','','','2021-12-31'),
('103','Center Roller ','8443','jdfsikj','Consumables','','','','2021-12-31'),
('104','Encoder Wheel + Bracket','8443','dsihjikjh','Consumables','','','','2021-12-31'),
('105','T-180 Inkjet Printer','8443','dsihjikjh','Machine','','','','2022-01-03'),
('106','White Cartridge','8443','jkbjhv','Consumables','','','','2022-01-06'),
('107','Handy Stand Assembly','8443','bdfjeh','Consumables','','','','2022-01-10'),
('109','codpad printer','8443','kdushkfjd','Machine','','','','2022-01-14'),
('111','Empty Bottle','8443','kusdfgiuds','Consumables','','','','2022-01-17'),
('112','Encoder ','8443','yryuy','Consumables','','','','2022-01-20'),
('114','Long Rubber -CL','8443','geskj','Consumables','','','','2022-02-01'),
('115','Motor with Gearbox ','8443','ytyt','Consumables','','','','2022-02-05'),
('116','Gearbox ','8443','isoi','Consumables','','','','2022-02-05'),
('117','Duplex Gear','8443','kd','Consumables','','','','2019-12-19'),
('118','Bronze Bush','8443','jgsd','Consumables','','','','2019-12-19'),
('119','Reling Rubber','8443','jsjhgj','Consumables','','','','2019-12-19'),
('120','Bosh Gear','8443','kkshiu','Consumables','','','','2019-12-19'),
('121','Nut Bolt','8443','jgsj','Consumables','','','','2020-02-24'),
('122','object Sensor for Inkjet','8443','4555','Consumables','','','','2022-03-21'),
('123','Solvent Ink Cartridge','8443','jyj','Consumables','','','','2022-03-21'),
('124','Thermal  Inkjet Printer - M302 ','8443','fdghrdh','Machine','','','','2022-04-11'),
('125','Repairing','8443','yfyujyuj','Consumables','','','','2022-04-30'),
('126','Delta VFD Drive','8443','sjdlkj','Consumables','','','','2022-05-25'),
('127','Green Cartridge','8443','jbnj','Consumables','','','','2022-06-04'),
('128','Green Carton Special Belt','8443','jhsdkjhsdkj','Consumables','','','','2022-09-11'),
('129','CT-03 Touch Screen Coder','8443','rgdfg','Machine','','','','2022-11-07'),
('130','Touch Screen Coder','8443','ihuhiu','Machine','','','','2022-11-12'),
('131','Mini Printer','8443','esfew','Machine','','mini printer.jpg','Max.Print Height : 12.7 mm;Max. Speed : 30-40 per/min.;LCD  Display;Comes along pen drive , HP original Seal Pack Black ink Cartridge , charger;NO Courier Charges','2022-11-15'),
('132','Porous Spgink','8443','hsg','Consumables','','','','2022-12-02'),
('133','Water Based Black Porous Ink','8443','sdjgjh','Consumables','','','','2022-12-02'),
('134','Screw','8443','lidf','Consumables','','','','2022-12-27'),
('135','Auto-Collector Conveyor','8443','sdfdsdd','Machine','','','','2023-01-31'),
('136','CT - 13 Thermal Inkjet Printer ','8443','kreuuijk','Machine','','','','2023-03-02'),
('137','Manual Induction','8443','fdsfd','Machine','','','','2023-03-18'),
('138','Stand Bracket with sensor','8443','iuoio','Consumables','','','','2023-03-27'),
('139','Bandsealer','8443','hfhg','Machine','','','','2023-04-21'),
('140','weigh filler','8443','uyuy','Machine','','','','2023-04-21'),
('141','Printer Cartridge','8443','jhhk','Consumables','','','','2023-05-15'),
('142','Charger','8443','hsdkh','Consumables','','','','2023-06-30'),
('143','Stereo','8443','ghhfdd','Consumables','','','','2023-07-11'),
('145','stamp handle','8443','dsfrdsfe','Consumables','','','','2023-09-29'),
('146','Yellow Cartridge','8443','jhkj','Consumables','','','','2023-10-11'),
('147','Display','8443','Display','Machine','','','','2023-10-16'),
('148','Pressure Roller for stracker','8443','dfedfer','Consumables','','','','2023-11-30'),
('149','Print Driver Board','8443','sdfhfsdkjhfi','Consumables','','','','2023-12-07'),
('150','Cable Strip','8443',',dsjhfdkjsh','Consumables','','','','2023-12-06'),
('151','Orings ','8443','jkhsdkjhdskj','Consumables','','','','2023-12-07'),
('152','touch pen','8443','klsdfjflkdsj','Consumables','','','','2023-12-07'),
('154','cartridge inserting plastic block','8443','jksdhdjskh','Consumables','','','','2024-01-11'),
('155','Locking Stip Latch','8443','dkjhkjh','Consumables','','','','2024-04-10'),
('156','Stand Assembly','8443','wsjkeykj','Consumables','','','','2024-04-17'),
('157','Q Shape Plastic','8443','56u','Consumables','','','','2024-05-18'),
('158','CMos Battery Cell','8443','jhgejeg','Consumables','','','','2024-05-23'),
('159','Touch Screen','8443','dtgertr','Consumables','','','','2024-06-14'),
('160',' Assembly for Auto-collector','8443','fdkfjgkuew','Consumables','','','','2024-09-20'),
('161','Porter Delivery','8443','sutgduig ','Freight','','','','2024-09-21'),
('162','Pressure Strip','8443','jkdsdji','Consumables','','','','2024-10-05'),
('163','Metallic  Block Roller','8443','shsu sai','Consumables','','','','2024-11-12'),
('164','Silver Display Online printer','8443','jywegjuew','Machine','','','','2024-11-26'),
('165','i - MARK SENSOR','8443','HGDSUG','Consumables','','','','2024-12-09'),
('166','MS Roller','8443','Stracker ','Machine','','','','2024-12-13'),
('167','eoir','8443','iouwe wei','Consumables','',NULL,NULL,'2025-04-12'),
('168','udi ','8443','ui ue','Consumables','','1744457956_8c8dadcbedbb32db8bc2.png',NULL,'2025-04-12'),
('169','iorpp','8852','oipo','Machine','','1744457956_8c8dadcbedbb32db8bc2.png',NULL,'2025-04-12'),
('170','ioofs','7412','oowe powpj p','Machine','','1744457956_8c8dadcbedbb32db8bc2.png',NULL,'2025-04-12'),
('171','iosujdo','8443','okoiw','Consumables','Manual',NULL,NULL,'2025-04-13'),
('172','ghg','7787','jkjkj','Freight','','',NULL,'2025-04-13');



CREATE TABLE `protest` (
  `orderno` int(100) NOT NULL AUTO_INCREMENT,
  `orderid` varchar(300) NOT NULL,
  `item_name` varchar(300) NOT NULL,
  `item_desc` varchar(300) DEFAULT NULL,
  `hsn` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `total` int(100) NOT NULL,
  PRIMARY KEY (`orderno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `protest2` (
  `invid` varchar(100) NOT NULL,
  `cid` int(10) NOT NULL,
  `orderid` varchar(300) NOT NULL,
  `totalitems` int(10) NOT NULL,
  `subtotal` int(100) NOT NULL,
  `taxrate` int(10) NOT NULL,
  `taxamount` int(100) NOT NULL,
  `totalamount` int(100) NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`invid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `purchaseinv` (
  `orderno` int(100) NOT NULL AUTO_INCREMENT,
  `orderid` varchar(300) NOT NULL,
  `item_name` varchar(300) NOT NULL,
  `item_desc` varchar(300) DEFAULT NULL,
  `hsn` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `total` int(100) NOT NULL,
  PRIMARY KEY (`orderno`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO `purchaseinv` VALUES 
('1','680a049c4d6fd','CT- 01 HandHeld Manual Coder',NULL,'8443','1','450','450'),
('2','680a049c4d6fd','Courier',NULL,'8443','1','50','50'),
('3','680a04fb09bd4','CT- 01 HandHeld Manual Coder',NULL,'8443','1','450','450'),
('4','680a04fb09bd4','Courier',NULL,'8443','1','50','50');



CREATE TABLE `purchaseinv2` (
  `nid` int(100) NOT NULL AUTO_INCREMENT,
  `invid` varchar(100) NOT NULL,
  `cid` int(10) NOT NULL,
  `invdate` date NOT NULL,
  `orderid` varchar(300) NOT NULL,
  `totalitems` int(10) NOT NULL,
  `subtotal` int(100) NOT NULL,
  `taxrate` int(10) NOT NULL,
  `taxamount` int(100) NOT NULL,
  `totalamount` int(100) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`nid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO `purchaseinv2` VALUES 
('1','11','7','2025-04-10','680a049c4d6fd','2','500','18','90','590','2025-04-24 15:00:04'),
('2','12','6','2025-04-17','680a04fb09bd4','2','500','18','90','590','2025-04-24 15:01:39');



CREATE TABLE `quickquote` (
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `q_id` varchar(50) NOT NULL,
  `p_id` int(50) NOT NULL,
  `mob` varchar(50) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `price` varchar(50) NOT NULL,
  `subtotal` int(50) NOT NULL,
  `gst` int(50) NOT NULL,
  `total` int(50) NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`sr_no`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

INSERT INTO `quickquote` VALUES 
('1','QUICKT/24-25/0001','2','7412589630','1','650','650','117','767','2025-01-07'),
('2','QUICKT/24-25/0002','4','748561023','1','5000','5000','900','5900','2025-01-07'),
('3','QUICKT/24-25/0003','4','7485961023','1','50','50','9','59','2025-01-07'),
('4','QUICKT/24-25/0004','1','9632587410','1','55','55','10','65','2025-01-07'),
('5','QUICKT/24-25/0005','75','7412589630','1','40','40','7','47','2025-01-07'),
('6','QUICKT/24-25/0006','43','8735003590','1','50000','50000','9000','59000','2025-01-07'),
('7','QUICKT/24-25/0007','4','8760152410','1','500','500','90','590','2025-01-07'),
('8','QUICKT/24-25/0008','1','8735003590','1','450','450','81','531','2025-01-08'),
('9','QUICKT/24-25/0009','1','7016419537','1','500','500','90','590','2025-01-08'),
('10','QUICKT/24-25/0010','1','8735003590','1','500','500','90','590','2025-01-08'),
('11','QUICKT/24-25/0011','4','8735003590','1','30000','30000','5400','35400','2025-01-08'),
('12','QUICKT/24-25/0012','1','7600158240','1','50','50','9','59','2025-01-08'),
('13','QUICKT/24-25/0013','4','8735003590','1','500','500','90','590','2025-01-08'),
('14','QUICKT/25-26/0014','1','8735003590','1','300','300','54','354','2025-04-13'),
('15','QUICKT/25-26/0015','1','8735003590','1','500','500','90','590','2025-04-26'),
('16','QUICKT/25-26/0016','1','8735003590','1','500','500','90','590','2025-04-26');



CREATE TABLE `quote` (
  `orderno` int(100) NOT NULL AUTO_INCREMENT,
  `orderid` varchar(300) NOT NULL,
  `item_name` varchar(300) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `total` int(100) NOT NULL,
  PRIMARY KEY (`orderno`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

INSERT INTO `quote` VALUES 
('9','677eb8506b620','CT- 02 Handy Marker for Currogated Cartons','1','4000','4000'),
('10','67eeb551833fa','CT- 01 HandHeld Manual Coder','1','50','50'),
('11','67eeb551833fa','CT-03 Handy Marker for HDPE Bags','1','50','50'),
('12','680a419c31aaf','CT- 01 HandHeld Manual Coder','1','3000','3000'),
('13','67fb565d213f4','iosujdo','1','300','300'),
('16','680caa415ec09','CT- 02 Handy Marker for Currogated Cartons','2','400','800');



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
  `note` varchar(300) NOT NULL,
  PRIMARY KEY (`invid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `quote2` VALUES 
('QT/24-25/0001','56','677eb8506b620','1','4000','18','720','4720','2025-01-08',''),
('QT/25-26/0001','5','680a419c31aaf','1','3000','18','540','3540','2025-04-24',''),
('QT/25-26/0002','15','67eeb551833fa','2','100','18','18','118','2025-04-03',''),
('QT/25-26/0003','3','67fb565d213f4','1','300','18','54','354','2025-04-13',''),
('QT/25-26/0004','5','680caa415ec09','1','800','18','144','944','2025-04-26','');



CREATE TABLE `techsps` (
  `tid` int(5) NOT NULL AUTO_INCREMENT,
  `p_id` int(5) NOT NULL,
  `img_loc` varchar(300) DEFAULT NULL,
  `techs` varchar(800) DEFAULT NULL,
  `subcat` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `fk` (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

INSERT INTO `techsps` VALUES 
('1','1','hand stamp.jpg','Printing Area : 35 x 60 mm (LxB);Prints using Grooves Rubber based stereo (3  MM); Ink- Fast dry & Water Resistant; Weight 0.5 kgs; Comes with 500ml ink, 500ml Cleaner, Groove fonts & Inkpad (2pcs)','Manual Batch Coding Machine'),
('2','2','handy box.jpg','Printing Area : 3x12 inch (LxB);Prints using Grooves Rubber based stereo (12  MM); Ink Roller – Rechargeable high capacity porous ink;Impression -  1,000 per charge of 20ml / 40ml. /10 ml(depending upon no. of lines printed);Weight - 3kgs;Comes with 1 liter porus ink.','Manual Batch Coding Machine'),
('3','3','handy bag.jpg','Printing Area : 3x12 inch (LxB);Prints using Grooves Rubber based stereo (12  MM);Ink Roller – Rechargeable high capacity non porous ink;Impression -  1,000 per charge of 20ml / 40ml. /10 ml. (depending upon no. of lines printed);Weight - 3kgs;Comes with 1 liter HDPE ink, 1 Liter ink-aid & Tools.','Manual Batch Coding Machine'),
('4','4','table top.jpg','Printing Area – 35 x 35 mm (LxB);Operating Method – Foot Switch & Continuous Both.;Power – 230 V AC 50 Hz;Print material: rubber stereo 3 mm sheet.;Comes with -  PLC motor, Liquid Fast dry Ink(500 ml),ink Roll, Form Pad, Tools, Circuit Board controller, Cleaner(500 ml).; Printing Speed (Max) - 60 Nos/Min.;Comes with Complete protective box','Semi Automatic Batch Coding Machine'),
('5','87','handheld inkjet.jpg','Max.Print Height : 12.7 mm;Max. Speed : 30-40 per/min.;LCD Display with print head;Comes along pen drive, ink cartridge, charger, SS Frame & Battery;1 year warranty;NO Courier Charges','Handy Inkjet Printer'),
('6','5','2in1.jpg','Overall Dimensions: 1070 x 680 x 450;Speed: 150 cartons/min.  250 labels/min.;Pouch/Carton Size: 80mm x 40mm to 305mm x 200mm;Power : 0.5HP  3 phase;Weight: Approx. 100 Kgs;Prints using Rubber Stereo.;Materials along with m/c: 500ml paste Ink, tape roll,Tools.','Automatic Batch Coding Machine'),
('7','76','Handheld inkjet printer.jpg','Max.Print Height : 12. 7 mm;Max. Speed : 30-40 per/min.;LCD Display with print head;Comes along pen drive, ink cartridge, charger, SS Frame & Battery;1 year warranty;NO Courier Charges','Handy Inkjet Printer'),
('8','7','2in1.jpg','Overall Dimensions: 1070 x 680 x 450;Speed: 150 cartons/min.  250 labels/min.;Pouch/Carton Size: 80mm x 40mm to 305mm x 200mm;Power : 0.5HP  3 phase;Weight: Approx. 100 Kgs;Prints using Rubber Stereo.;Materials along with m/c: 500ml paste Ink, tape roll,Tools.','Automatic Batch Coding Machines'),
('9','6','2in1.jpg','Overall Dimensions: 1070 x 680 x 450;Speed: 150 cartons/min.  250 labels/min.;Pouch/Carton Size: 80mm x 40mm to 305mm x 200mm;Power : 0.5HP  3 phase;Weight: Approx. 100 Kgs;Prints using Rubber Stereo.;Materials along with m/c: 500ml paste Ink, tape roll,Tools.','Automatic Batch Coding Machines'),
('10','81','table top.jpg','Printing Area – 35 x 35 mm (LxB);Operating Method – Foot Switch & Continuous Both.;Power – 230 V AC 50 Hz;Print material: rubber stereo 3 mm sheet.;Comes with -  PLC motor, Liquid Fast dry Ink(500 ml),ink Roll, Form Pad, Tools, Circuit Board controller, Cleaner(500 ml).; Printing Speed (Max) - 60 Nos/Min.;Comes with Complete protective box','Semi Automatic Batch Coding Machine'),
('11','8','standard carton.jpg','Overall Dimensions: 1010 x 690 x 590;Speed:   250 cartons/min.;Carton Size: 80mm x 25mm to 305mm x 200mm;Power : 0.5HP  3 phase;Weight: Approx. 102 Kgs;Prints using Rubber Stereo.;Materials along m/c:  500ml paste Ink, tape roll,Liquid block, Tools & Liquid ink.','Automatic Batch coding Machine'),
('12','43','standard label.jpg','Overall Dimensions: 880 x 530 x 460;Speed:  250 labels/min.;Label Size: 20mm x 40mm to 150mm x 200mm;Power: 0.5HP  3 phase;Weight: Approx. 80 Kgs;Prints using Rubber Stereo.;Materials along with machine: Paste ink, 2 sided tape,Tools & Feeding Rubber ','Automatic Batch coding Machine'),
('13','131','mini printer.jpg','Max.Print Height : 12.7 mm;Max. Speed : 30-40 per/min.;LCD  Display;Comes along pen drive , HP original Seal Pack Black ink Cartridge , charger;NO Courier Charges','Handy Inkjet Printer'),
('14','75','hp cartridge.jpg','47 ml Ink Cartridge;No chip Cartridge;HP Original Seal Pack Cartridge;Print Head 12.7mm;Solvent Ink;Fast Dry & Permanent \n','Handy Inkjet Printer'),
('15','88','hp cartridge.jpg','47 ml Ink Cartridge;No chip Cartridge;HP Original Seal Pack Cartridge;Print Head 12.7mm;Solvent Ink;Fast Dry & Permanent \n','Handy Inkjet Printer'),
('16','98','double bond.jpg','Japanese Cartridge;High cohesion on Glossy Surface;Permanent impression Guaranteed;Print material: Glossy surface, Glass bottles etc','Handy Inkjet Printer'),
('17','100','simple conveyor.jpeg','Machine Length - 1500 mm; Machine Width -  350 mm;Conveyor Belt Width – 300 mm;Fully SS Make;0.25 HP Motor with Speed Controller;Completely Foldable type   \r\n','conveyor'),
('18','113','simple conveyor.jpeg','Machine Length - 1500 mm; Machine Width -  350 mm;Conveyor Belt Width – 300 mm;Fully SS Make;0.25 HP Motor with Speed Controller;Completely Foldable type   \r\n','conveyor'),
('19','78','m 302.jpg','Max.Print Height : 12.7 mm;Max. Speed : 80-200 per/min. (depends upon the size of samples);LCD  Display with print head;Comes along pen drive,Solvent Ink (Black) cartridge & charger.;Comes with Additional Stand assembly for attachment in conveyor & Metal sensor; Unlock Machine;1 year warranty','Online Printers'),
('20','124','m 302.jpg','Max.Print Height : 12.7 mm;Max. Speed : 80-200 per/min. (depends upon the size of samples);LCD  Display with print head;Comes along pen drive,Solvent Ink (Black) cartridge & charger.;Comes with Additional Stand assembly for attachment in conveyor & Metal sensor; Unlock Machine;1 year warranty\r\n','Online Printers'),
('21','105','m 302.jpg','Max.Print Height : 12.7 mm;Max. Speed : 80-200 per/min. (depends upon the size of samples);LCD  Display with print head;Comes along pen drive,Solvent Ink (Black) cartridge & charger.;Comes with Additional Stand assembly for attachment in conveyor & Metal sensor; Unlock Machine;1 year warranty\r\n','Online Printers'),
('22','109','m 302.jpg','Max.Print Height : 12.7 mm;Max. Speed : 80-200 per/min. (depends upon the size of samples);LCD  Display with print head;Comes along pen drive,Solvent Ink (Black) cartridge & charger.;Comes with Additional Stand assembly for attachment in conveyor & Metal sensor; Unlock Machine;1 year warranty\r\n','Online Printers'),
('23','136','CT 13.jpeg','Max.Print Height : 50 mm [Each head 25 mm];Max. Speed : 120-300 per/min. (depends upon the size of samples);LCD  Display with print head;Comes along pen drive, Solvent Ink (Black) cartridge & Power charger.;Comes with Additional Stand assembly for attachment in conveyor & Metal sensor;1 year warranty\r\n','Online Printers');

