-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2017 at 08:34 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `owasia_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `asset`
--

CREATE TABLE `asset` (
  `AssetNumber` char(13) NOT NULL,
  `AssetClassID` char(2) NOT NULL,
  `DepartmentID` char(3) NOT NULL,
  `EmployeeID` char(6) NOT NULL,
  `RegionID` char(2) NOT NULL,
  `HistoryID` int(11) NOT NULL,
  `SerialNumber` varchar(50) NOT NULL,
  `AssetDescription` varchar(150) NOT NULL,
  `AssetStatus` varchar(20) NOT NULL,
  `AssetRoom` varchar(20) NOT NULL,
  `AcquisitionDate` date NOT NULL,
  `AssetValue` int(11) NOT NULL,
  `Currency` char(3) NOT NULL,
  `Guarantee` date NOT NULL,
  `Date` date NOT NULL,
  `Price` int(11) NOT NULL,
  `PriceCurr` int(11) NOT NULL,
  `Tr_User_I` varchar(50) NOT NULL,
  `Tr_User_U` varchar(50) NOT NULL,
  `Tr_Date_I` date NOT NULL,
  `Tr_Date_U` date NOT NULL,
  `isActive` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assetclass`
--

CREATE TABLE `assetclass` (
  `AssetClassID` char(2) NOT NULL,
  `AssetClassName` varchar(30) NOT NULL,
  `AssetClassDescription` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assetclass`
--

INSERT INTO `assetclass` (`AssetClassID`, `AssetClassName`, `AssetClassDescription`) VALUES
('CE', 'Computer equipment', 'Can include a broad array of computer equipment, such as  server, HDD, laptop, monitor, routers  It is useful to set the capitalization limit higher than the cost of desktop and laptop computers, so that you do not have to track these items as assets.'),
('FF', 'Furniture and fixtures', 'This is one of the broadest categories of fixed assets, since it can include such diverse assets as warehouse storage racks, office cubicles, and desks.'),
('OE', 'Office equipment', 'This account contains such equipment as copiers, printers, and video equipment. Some companies elect to merge this account into the Furniture and Fixtures account, especially if they have few office equipment items.'),
('SO', 'Software', 'Includes larger types of departmental or company-wide software, such as enterprise resources planning software or accounting software. Many desktop software packages are not sufficiently expensive to exceed the corporate capitalization limit.');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `AttendanceID` char(11) NOT NULL,
  `EmployeeID` char(6) NOT NULL,
  `RegionID` char(2) NOT NULL,
  `PermissionID` char(3) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `Time_In` time NOT NULL,
  `Time_Out` time NOT NULL,
  `TotalTime` time NOT NULL,
  `Tr_User_I` varchar(50) NOT NULL,
  `Tr_User_U` varchar(50) NOT NULL,
  `Tr_Date_I` date NOT NULL,
  `Tr_Date_U` date NOT NULL,
  `isActive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`AttendanceID`, `EmployeeID`, `RegionID`, `PermissionID`, `Name`, `date`, `Time_In`, `Time_Out`, `TotalTime`, `Tr_User_I`, `Tr_User_U`, `Tr_Date_I`, `Tr_Date_U`, `isActive`) VALUES
('20170309001', 'EMP001', 'ID', 'P02', 'endreas', '0000-00-00', '05:19:00', '05:31:13', '00:00:00', '', '', '0000-00-00', '0000-00-00', 0),
('20170309002', 'EMP003', 'SG', 'P01', 'dika', '2017-03-08', '09:00:00', '18:00:00', '09:00:00', '', '', '0000-00-00', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `DepartmentID` char(3) NOT NULL,
  `DepartmentName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`DepartmentID`, `DepartmentName`) VALUES
('D01', 'Management'),
('D02', 'Business Development'),
('D03', 'HR & Operation'),
('D04', 'Delivery'),
('D05', 'Finance & Legal');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `HistoryID` int(11) NOT NULL,
  `ItemFrom` int(11) NOT NULL,
  `ItemTo` int(11) NOT NULL,
  `Date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menuchild`
--

CREATE TABLE `menuchild` (
  `MenuChildID` char(4) NOT NULL,
  `MenuChildName` varchar(20) NOT NULL,
  `MenuPath` varchar(50) NOT NULL,
  `Menu_I` int(11) NOT NULL,
  `Menu_U` int(11) NOT NULL,
  `Menu_D` int(11) NOT NULL,
  `Menu_S` int(11) NOT NULL,
  `MenuParentID` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menuchild`
--

INSERT INTO `menuchild` (`MenuChildID`, `MenuChildName`, `MenuPath`, `Menu_I`, `Menu_U`, `Menu_D`, `Menu_S`, `MenuParentID`) VALUES
('MC01', 'Permit List', '', 0, 0, 0, 0, 'MP02'),
('MC02', 'Add Employee', '', 0, 0, 0, 0, 'MP04'),
('MC03', 'List Employee', '', 0, 0, 0, 0, 'MP04'),
('MC04', 'Profile', '', 0, 0, 0, 0, 'MP04'),
('MC05', 'Role', '', 0, 0, 0, 0, 'MP04');

-- --------------------------------------------------------

--
-- Table structure for table `menuparent`
--

CREATE TABLE `menuparent` (
  `MenuParentID` char(4) NOT NULL,
  `MenuParentName` varchar(20) NOT NULL,
  `Menupath` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menuparent`
--

INSERT INTO `menuparent` (`MenuParentID`, `MenuParentName`, `Menupath`) VALUES
('MP01', 'Home', ''),
('MP02', 'Attendance', ''),
('MP03', 'Asset', ''),
('MP04', 'User Management', '');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `PermissionID` char(3) NOT NULL,
  `PermissionType` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`PermissionID`, `PermissionType`) VALUES
('P01', 'Lieu Leave'),
('P02', 'Half Day Leave'),
('P03', 'Onsite Visit'),
('P04', 'Permit');

-- --------------------------------------------------------

--
-- Table structure for table `permissionattendance`
--

CREATE TABLE `permissionattendance` (
  `TransactionPermissionID` char(11) NOT NULL,
  `PermissionID` char(3) NOT NULL,
  `EmployeeID` char(6) NOT NULL,
  `AttendanceID` char(11) NOT NULL,
  `Notes` varchar(500) NOT NULL,
  `Date` datetime NOT NULL,
  `Tr_User_I` varchar(50) NOT NULL,
  `Tr_User_U` varchar(50) NOT NULL,
  `Tr_Date_I` date NOT NULL,
  `Tr_Date_U` date NOT NULL,
  `isActive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `RegionID` char(2) NOT NULL,
  `Region` varchar(50) NOT NULL,
  `Phone_Office` varchar(20) NOT NULL,
  `Address` varchar(150) NOT NULL,
  `Fax` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`RegionID`, `Region`, `Phone_Office`, `Address`, `Fax`) VALUES
('ID', 'Indonesia', '+6221 29403060', 'Jalan Pakubuwono VI No.1, Kebayoran Baru, Jakarta Selatan 1220', '+6221 29403064'),
('MY', 'Malaysia', '+603 7727 8881 ', ' 7-03A & &-06, Level 7, Menara UAC, Jalan PJU 7/5, Mutiara Damansara, 47800 Petaling Jaya, Selangor, Malaysia', '+603 7728 0884'),
('SG', 'Singapore', '', '', ''),
('VN', 'Vietnam', '(+84) 4 3244 4282', 'Room 3006, 30th Floor, West Tower, Lotte Center, 54 Lieu Giai, Cong Vi Ward, Ba Dinh District, Ha Noi, Viet Nam', '(+84) 4 3244 4281');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `RoleID` char(3) NOT NULL,
  `RoleName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`RoleID`, `RoleName`) VALUES
('R00', 'Admin'),
('R01', 'Group Manager'),
('R02', 'Manager'),
('R03', 'Consultant'),
('R04', 'Back Office'),
('R05', 'Sales');

-- --------------------------------------------------------

--
-- Table structure for table `rolemenu`
--

CREATE TABLE `rolemenu` (
  `RoleMenuID` char(7) NOT NULL,
  `RoleID` char(3) NOT NULL,
  `MenuChildID` char(4) NOT NULL,
  `Role_I` int(11) NOT NULL,
  `Role_U` int(11) NOT NULL,
  `Role_D` int(11) NOT NULL,
  `Role_S` int(11) NOT NULL,
  `Tr_User_I` varchar(50) NOT NULL,
  `Tr_User_U` varchar(50) NOT NULL,
  `Tr_Date_I` date NOT NULL,
  `Tr_Date_U` date NOT NULL,
  `isActive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rolemenu`
--

INSERT INTO `rolemenu` (`RoleMenuID`, `RoleID`, `MenuChildID`, `Role_I`, `Role_U`, `Role_D`, `Role_S`, `Tr_User_I`, `Tr_User_U`, `Tr_Date_I`, `Tr_Date_U`, `isActive`) VALUES
('RM00001', 'R03', 'MC04', 1, 1, 1, 1, '', '', '0000-00-00', '0000-00-00', 0),
('RM00002', 'R01', 'MC01', 1, 0, 0, 0, '', '', '0000-00-00', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `EmployeeID` char(6) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `RoleID` char(3) NOT NULL,
  `DepartmentID` char(3) NOT NULL,
  `RegionID` char(2) NOT NULL,
  `EmployeeName` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Position` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `SkypeID` varchar(50) NOT NULL,
  `MobilePhone` varchar(15) NOT NULL,
  `NationalID` varchar(150) NOT NULL,
  `Passport` varchar(150) NOT NULL,
  `Photo` varchar(150) NOT NULL,
  `CV` varchar(150) NOT NULL,
  `TaxID` varchar(150) NOT NULL,
  `StartWorkingDate` date NOT NULL,
  `TerninationDate` date NOT NULL,
  `Tr_User_I` varchar(50) NOT NULL,
  `Tr_User_U` varchar(50) NOT NULL,
  `Tr_Date_I` date NOT NULL,
  `Tr_Date_U` date NOT NULL,
  `isActive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`EmployeeID`, `Username`, `RoleID`, `DepartmentID`, `RegionID`, `EmployeeName`, `Password`, `Position`, `Email`, `SkypeID`, `MobilePhone`, `NationalID`, `Passport`, `Photo`, `CV`, `TaxID`, `StartWorkingDate`, `TerninationDate`, `Tr_User_I`, `Tr_User_U`, `Tr_Date_I`, `Tr_Date_U`, `isActive`) VALUES
('EMP001', 'Dimas', 'R02', 'D04', 'MY', 'dadadadad', 'dadawedasffaas', 'fddafasfafa', 'agsgadvdgsd', 'sfasgdfshsdgs', '124253346346', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '0000-00-00', 0),
('EMP002', 'Endreasik', 'R03', 'D03', 'VN', 'Endreas Sanusi', 'iwenlovelove', 'kiper', 'endreas@openway.com', 'endreas123', '1243543463436', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '0000-00-00', 0),
('EMP003', 'DIka', 'R03', 'D01', 'SG', 'Andika Rachman', 'dika654', 'Kanan', 'Dika@openway.com', 'dika', '08983932323', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '0000-00-00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asset`
--
ALTER TABLE `asset`
  ADD PRIMARY KEY (`AssetNumber`),
  ADD KEY `AssetClassID` (`AssetClassID`),
  ADD KEY `DepartmentID` (`DepartmentID`),
  ADD KEY `EmployeeID` (`EmployeeID`),
  ADD KEY `RegionID` (`RegionID`),
  ADD KEY `HistoryID` (`HistoryID`),
  ADD KEY `HistoryID_2` (`HistoryID`);

--
-- Indexes for table `assetclass`
--
ALTER TABLE `assetclass`
  ADD PRIMARY KEY (`AssetClassID`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`AttendanceID`),
  ADD KEY `EmployeeID` (`EmployeeID`),
  ADD KEY `RegionID` (`RegionID`),
  ADD KEY `PermissionID` (`PermissionID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DepartmentID`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`HistoryID`);

--
-- Indexes for table `menuchild`
--
ALTER TABLE `menuchild`
  ADD PRIMARY KEY (`MenuChildID`),
  ADD KEY `MenuParentID` (`MenuParentID`);

--
-- Indexes for table `menuparent`
--
ALTER TABLE `menuparent`
  ADD PRIMARY KEY (`MenuParentID`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`PermissionID`);

--
-- Indexes for table `permissionattendance`
--
ALTER TABLE `permissionattendance`
  ADD PRIMARY KEY (`TransactionPermissionID`),
  ADD KEY `PermissionID` (`PermissionID`),
  ADD KEY `EmployeeID` (`EmployeeID`),
  ADD KEY `AttendanceID` (`AttendanceID`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`RegionID`),
  ADD UNIQUE KEY `RegionID` (`RegionID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `rolemenu`
--
ALTER TABLE `rolemenu`
  ADD PRIMARY KEY (`RoleMenuID`),
  ADD KEY `RoleID` (`RoleID`),
  ADD KEY `MenuChildID` (`MenuChildID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `RegionID` (`RegionID`),
  ADD KEY `RoleID` (`RoleID`),
  ADD KEY `DepartmentID` (`DepartmentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `HistoryID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `asset`
--
ALTER TABLE `asset`
  ADD CONSTRAINT `asset_ibfk_1` FOREIGN KEY (`DepartmentID`) REFERENCES `department` (`DepartmentID`),
  ADD CONSTRAINT `asset_ibfk_3` FOREIGN KEY (`AssetClassID`) REFERENCES `assetclass` (`AssetClassID`),
  ADD CONSTRAINT `asset_ibfk_4` FOREIGN KEY (`RegionID`) REFERENCES `region` (`RegionID`),
  ADD CONSTRAINT `asset_ibfk_5` FOREIGN KEY (`HistoryID`) REFERENCES `history` (`HistoryID`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`RegionID`) REFERENCES `region` (`RegionID`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`PermissionID`) REFERENCES `permission` (`PermissionID`);

--
-- Constraints for table `menuchild`
--
ALTER TABLE `menuchild`
  ADD CONSTRAINT `menuchild_ibfk_1` FOREIGN KEY (`MenuParentID`) REFERENCES `menuparent` (`MenuParentID`);

--
-- Constraints for table `permissionattendance`
--
ALTER TABLE `permissionattendance`
  ADD CONSTRAINT `permissionattendance_ibfk_4` FOREIGN KEY (`AttendanceID`) REFERENCES `attendance` (`AttendanceID`),
  ADD CONSTRAINT `permissionattendance_ibfk_5` FOREIGN KEY (`EmployeeID`) REFERENCES `user` (`EmployeeID`),
  ADD CONSTRAINT `permissionattendance_ibfk_6` FOREIGN KEY (`AttendanceID`) REFERENCES `attendance` (`AttendanceID`);

--
-- Constraints for table `rolemenu`
--
ALTER TABLE `rolemenu`
  ADD CONSTRAINT `rolemenu_ibfk_1` FOREIGN KEY (`MenuChildID`) REFERENCES `menuchild` (`MenuChildID`),
  ADD CONSTRAINT `rolemenu_ibfk_2` FOREIGN KEY (`RoleID`) REFERENCES `role` (`RoleID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`RegionID`) REFERENCES `region` (`RegionID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`RoleID`) REFERENCES `role` (`RoleID`),
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`DepartmentID`) REFERENCES `department` (`DepartmentID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
