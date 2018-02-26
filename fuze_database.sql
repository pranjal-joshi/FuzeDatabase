-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2018 at 05:24 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fuze_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `after_pu`
--

CREATE TABLE `after_pu` (
  `_id` int(11) NOT NULL,
  `pcb_no` text,
  `i` float NOT NULL,
  `vee` float NOT NULL,
  `vbat_pst` float NOT NULL,
  `pst_amp` float NOT NULL,
  `pst_wid` float NOT NULL,
  `mod_freq` float NOT NULL,
  `mod_dc` float NOT NULL,
  `mod_ac` float NOT NULL,
  `cap_charge` float NOT NULL,
  `vrf_amp` float NOT NULL,
  `vbat_vrf` float NOT NULL,
  `vbat_sil` float NOT NULL,
  `det_wid` float NOT NULL,
  `det_amp` float NOT NULL,
  `cycles` int(11) NOT NULL,
  `bpf_dc` float NOT NULL,
  `bpf_ac` float NOT NULL,
  `sil` float NOT NULL,
  `lvp` float NOT NULL,
  `pd_delay` float NOT NULL,
  `pd_det` float NOT NULL,
  `safe` varchar(4) NOT NULL,
  `result` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `calibration_table`
--

CREATE TABLE `calibration_table` (
  `_id` mediumint(9) NOT NULL,
  `pcb_no` text,
  `rf_no` text,
  `before_freq` text,
  `before_bpf` text NOT NULL,
  `changed` int(11) NOT NULL,
  `res_val` int(11) DEFAULT NULL,
  `after_freq` text,
  `after_bpf` text,
  `timestamp` text,
  `op_name` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calibration_table`
--

INSERT INTO `calibration_table` (`_id`, `pcb_no`, `rf_no`, `before_freq`, `before_bpf`, `changed`, `res_val`, `after_freq`, `after_bpf`, `timestamp`, `op_name`) VALUES
(2, '123', '4567', '1100', '0.7', 1, 67, '795', '1.0', '23 February, 2018', 'PRANJAL'),
(4, '3P1216001196', '1234', '700', '1', 1, 55, '708', '1.1', '23 February, 2018', 'XYZ'),
(5, '3P1216001121', '1121', '814', '1.40', 1, 120, '799.35', '1.29', '23 February, 2018', 'PRANJAL'),
(6, '3P1216001005', '1005', '809.12', '1.03', 0, 0, '', '', '23 February, 2018', 'PRANJAL'),
(7, '3P1216001196', '1234', '1', '1.2', 1, 120, '2', '3', '26 February, 2018', 'P');

-- --------------------------------------------------------

--
-- Table structure for table `password`
--

CREATE TABLE `password` (
  `passwd` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `password`
--

INSERT INTO `password` (`passwd`) VALUES
('6f5f3e9a20961b12fc7bdfef9ce81260');

-- --------------------------------------------------------

--
-- Table structure for table `qa_table`
--

CREATE TABLE `qa_table` (
  `_id` mediumint(9) NOT NULL,
  `pcb_no` text,
  `result` tinyint(4) DEFAULT NULL,
  `reason` tinyint(4) DEFAULT NULL,
  `record_date` text,
  `op_name` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `after_pu`
--
ALTER TABLE `after_pu`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `calibration_table`
--
ALTER TABLE `calibration_table`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `qa_table`
--
ALTER TABLE `qa_table`
  ADD PRIMARY KEY (`_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `after_pu`
--
ALTER TABLE `after_pu`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calibration_table`
--
ALTER TABLE `calibration_table`
  MODIFY `_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `qa_table`
--
ALTER TABLE `qa_table`
  MODIFY `_id` mediumint(9) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
