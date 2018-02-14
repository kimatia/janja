-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 01, 2017 at 07:34 AM
-- Server version: 5.7.15
-- PHP Version: 7.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `palm`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_billoflading`
--

CREATE TABLE `tbl_billoflading` (
  `id` int(10) NOT NULL,
  `stackNumber` varchar(100) NOT NULL,
  `billofLadingNumber` varchar(100) NOT NULL,
  `shippername` varchar(100) NOT NULL,
  `shipperadress` varchar(100) NOT NULL,
  `shipperlocation` varchar(100) NOT NULL,
  `consigneename` varchar(100) NOT NULL,
  `consigneeadress` varchar(100) NOT NULL,
  `consigneelocation` varchar(100) NOT NULL,
  `precariageBy` varchar(100) NOT NULL,
  `placeofReciept` varchar(100) NOT NULL,
  `vessel` varchar(100) NOT NULL,
  `voyno` varchar(100) NOT NULL,
  `loadingport` varchar(100) NOT NULL,
  `dischargeport` varchar(100) NOT NULL,
  `finalDestination` varchar(100) NOT NULL,
  `freightName` varchar(100) NOT NULL,
  `revenueTons` varchar(100) NOT NULL,
  `rate` varchar(100) NOT NULL,
  `per` varchar(100) NOT NULL,
  `prepaid` varchar(100) NOT NULL,
  `collect` varchar(100) NOT NULL,
  `markNumber` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `grossweight` varchar(100) NOT NULL,
  `measurement` varchar(100) NOT NULL,
  `packagesNo` varchar(100) NOT NULL,
  `freightPayable` varchar(100) NOT NULL,
  `numberOriginal` varchar(100) NOT NULL,
  `placeOfIssue` varchar(100) NOT NULL,
  `dateOfIssue` varchar(100) NOT NULL,
  `billofLading_file` varchar(100) NOT NULL,
  `userId` int(10) NOT NULL,
  `postTime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_certificateofconformity`
--

CREATE TABLE `tbl_certificateofconformity` (
  `id` int(10) NOT NULL,
  `stackNumber` varchar(100) NOT NULL,
  `idfNumber` varchar(100) NOT NULL,
  `certificateofconformity_file` varchar(100) NOT NULL,
  `userId` int(10) NOT NULL,
  `postTime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ecert`
--

CREATE TABLE `tbl_ecert` (
  `id` int(10) NOT NULL,
  `stackNumber` varchar(100) NOT NULL,
  `ecertNo` varchar(100) NOT NULL,
  `ecert_file` varchar(100) NOT NULL,
  `userId` int(10) NOT NULL,
  `postTime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_idf`
--

CREATE TABLE `tbl_idf` (
  `id` int(10) NOT NULL,
  `stackNumber` varchar(100) NOT NULL,
  `idfNo` varchar(100) NOT NULL,
  `idf_file` varchar(100) NOT NULL,
  `userId` int(10) NOT NULL,
  `postTime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `id` int(10) NOT NULL,
  `stackNumber` varchar(100) NOT NULL,
  `invoiceNo` varchar(100) NOT NULL,
  `invoice_file` varchar(100) NOT NULL,
  `userId` int(10) NOT NULL,
  `postTime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kbs`
--

CREATE TABLE `tbl_kbs` (
  `id` int(10) NOT NULL,
  `stackNumber` varchar(100) NOT NULL,
  `kbsNo` varchar(100) NOT NULL,
  `kbs_file` varchar(100) NOT NULL,
  `userId` int(10) NOT NULL,
  `postTime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_kbs`
--

INSERT INTO `tbl_kbs` (`id`, `stackNumber`, `kbsNo`, `kbs_file`, `userId`, `postTime`) VALUES
(3, 'pal/123/JULY/2014', 'editedkbsbyadmin', 'certificateofconformity.png', 1, '2017-08-01 17:28:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lbook`
--

CREATE TABLE `tbl_lbook` (
  `id` int(10) NOT NULL,
  `stackNumber` varchar(100) NOT NULL,
  `lbookNo` varchar(100) NOT NULL,
  `lbook_file` varchar(100) NOT NULL,
  `userId` int(10) NOT NULL,
  `postTime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logs`
--

CREATE TABLE `tbl_logs` (
  `id` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `stackNumber` varchar(100) NOT NULL,
  `file` varchar(100) NOT NULL,
  `postTime` varchar(100) NOT NULL,
  `updateData` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_logs`
--

INSERT INTO `tbl_logs` (`id`, `userId`, `stackNumber`, `file`, `postTime`, `updateData`) VALUES
(39, 1, 'pal/123/JULY/2014', 'kbs', '2017-08-01 17:27:25', NULL),
(40, 1, 'pal/123/JULY/2014', 'kbs', '2017-08-01 17:28:01', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quadruplicate`
--

CREATE TABLE `tbl_quadruplicate` (
  `id` int(10) NOT NULL,
  `stackNumber` varchar(100) NOT NULL,
  `quadruplicateNo` varchar(100) NOT NULL,
  `quadruplicate_file` varchar(100) NOT NULL,
  `userId` int(10) NOT NULL,
  `postTime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stacks`
--

CREATE TABLE `tbl_stacks` (
  `id` int(10) NOT NULL,
  `stackNumber` varchar(100) NOT NULL,
  `bol` varchar(100) NOT NULL DEFAULT 'No',
  `idf` varchar(100) NOT NULL DEFAULT 'No',
  `kbs` varchar(100) NOT NULL DEFAULT 'No',
  `ecert` varchar(100) NOT NULL DEFAULT 'No',
  `invoice` varchar(100) NOT NULL DEFAULT 'No',
  `treciept` varchar(100) NOT NULL DEFAULT 'No',
  `quadruplicate` varchar(100) NOT NULL DEFAULT 'No',
  `lbook` varchar(100) NOT NULL DEFAULT 'No',
  `postDate` varchar(100) NOT NULL,
  `finalDate` varchar(100) NOT NULL DEFAULT 'pending',
  `status` varchar(100) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_stacks`
--

INSERT INTO `tbl_stacks` (`id`, `stackNumber`, `bol`, `idf`, `kbs`, `ecert`, `invoice`, `treciept`, `quadruplicate`, `lbook`, `postDate`, `finalDate`, `status`) VALUES
(17, 'pal/123/JULY/2014', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', '2017-08-01 17:17:27', '2017-08-01 17:28:23', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_treciept`
--

CREATE TABLE `tbl_treciept` (
  `id` int(10) NOT NULL,
  `stackNumber` varchar(100) NOT NULL,
  `trecieptNo` varchar(100) NOT NULL,
  `treciept_file` varchar(100) NOT NULL,
  `userId` int(10) NOT NULL,
  `postTime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userID` int(10) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPass` varchar(100) NOT NULL,
  `userPhone` varchar(20) NOT NULL,
  `nationalId` varchar(1000) DEFAULT NULL,
  `loginType` varchar(100) DEFAULT 'user',
  `status` varchar(1000) DEFAULT 'No',
  `online` varchar(100) NOT NULL DEFAULT 'Yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_billoflading`
--
ALTER TABLE `tbl_billoflading`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stackNumber_2` (`stackNumber`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`),
  ADD KEY `billofLadingNumber` (`billofLadingNumber`),
  ADD KEY `stackNumber` (`stackNumber`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `tbl_certificateofconformity`
--
ALTER TABLE `tbl_certificateofconformity`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `stackNumber` (`stackNumber`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `tbl_ecert`
--
ALTER TABLE `tbl_ecert`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `stackNumber` (`stackNumber`);

--
-- Indexes for table `tbl_idf`
--
ALTER TABLE `tbl_idf`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `stackNumber` (`stackNumber`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `stackNumber` (`stackNumber`);

--
-- Indexes for table `tbl_kbs`
--
ALTER TABLE `tbl_kbs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `stackNumber` (`stackNumber`);

--
-- Indexes for table `tbl_lbook`
--
ALTER TABLE `tbl_lbook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `stackNumber` (`stackNumber`);

--
-- Indexes for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_quadruplicate`
--
ALTER TABLE `tbl_quadruplicate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `stackNumber` (`stackNumber`);

--
-- Indexes for table `tbl_stacks`
--
ALTER TABLE `tbl_stacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `stackNumber` (`stackNumber`);

--
-- Indexes for table `tbl_treciept`
--
ALTER TABLE `tbl_treciept`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `stackNumber` (`stackNumber`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userEmail` (`userEmail`),
  ADD UNIQUE KEY `nationalId` (`nationalId`),
  ADD KEY `userName` (`userName`),
  ADD KEY `userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_billoflading`
--
ALTER TABLE `tbl_billoflading`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `tbl_certificateofconformity`
--
ALTER TABLE `tbl_certificateofconformity`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_ecert`
--
ALTER TABLE `tbl_ecert`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_idf`
--
ALTER TABLE `tbl_idf`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_kbs`
--
ALTER TABLE `tbl_kbs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_lbook`
--
ALTER TABLE `tbl_lbook`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `tbl_quadruplicate`
--
ALTER TABLE `tbl_quadruplicate`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_stacks`
--
ALTER TABLE `tbl_stacks`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tbl_treciept`
--
ALTER TABLE `tbl_treciept`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_billoflading`
--
ALTER TABLE `tbl_billoflading`
  ADD CONSTRAINT `fkstackNumberbol` FOREIGN KEY (`stackNumber`) REFERENCES `tbl_stacks` (`stackNumber`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkuserIDtblusers` FOREIGN KEY (`userId`) REFERENCES `tbl_users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_certificateofconformity`
--
ALTER TABLE `tbl_certificateofconformity`
  ADD CONSTRAINT `fkstackNumberCOC` FOREIGN KEY (`stackNumber`) REFERENCES `tbl_stacks` (`stackNumber`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkuserIDcoc` FOREIGN KEY (`userId`) REFERENCES `tbl_users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_ecert`
--
ALTER TABLE `tbl_ecert`
  ADD CONSTRAINT `fkstackNumberecert` FOREIGN KEY (`stackNumber`) REFERENCES `tbl_stacks` (`stackNumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_idf`
--
ALTER TABLE `tbl_idf`
  ADD CONSTRAINT `fkstackNumberIDF` FOREIGN KEY (`stackNumber`) REFERENCES `tbl_stacks` (`stackNumber`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkuserIDidf` FOREIGN KEY (`userId`) REFERENCES `tbl_users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD CONSTRAINT `fkstackNumberinvoice` FOREIGN KEY (`stackNumber`) REFERENCES `tbl_stacks` (`stackNumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_kbs`
--
ALTER TABLE `tbl_kbs`
  ADD CONSTRAINT `fkstackNumberkbs` FOREIGN KEY (`stackNumber`) REFERENCES `tbl_stacks` (`stackNumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_lbook`
--
ALTER TABLE `tbl_lbook`
  ADD CONSTRAINT `fkstackNumberlbook` FOREIGN KEY (`stackNumber`) REFERENCES `tbl_stacks` (`stackNumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_quadruplicate`
--
ALTER TABLE `tbl_quadruplicate`
  ADD CONSTRAINT `fkstackNumberquadruplicate` FOREIGN KEY (`stackNumber`) REFERENCES `tbl_stacks` (`stackNumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_treciept`
--
ALTER TABLE `tbl_treciept`
  ADD CONSTRAINT `fkstackNumbertreciept` FOREIGN KEY (`stackNumber`) REFERENCES `tbl_stacks` (`stackNumber`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
