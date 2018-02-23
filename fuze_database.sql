-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2018 at 06:19 AM
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
-- AUTO_INCREMENT for table `calibration_table`
--
ALTER TABLE `calibration_table`
  MODIFY `_id` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qa_table`
--
ALTER TABLE `qa_table`
  MODIFY `_id` mediumint(9) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
