-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2025 at 05:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appliance_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appliance`
--

CREATE TABLE `appliance` (
  `ApplianceID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ApplianceType` varchar(50) NOT NULL,
  `Brand` varchar(50) NOT NULL,
  `ModelNumber` varchar(50) NOT NULL,
  `SerialNumber` varchar(50) NOT NULL,
  `PurchaseDate` date NOT NULL,
  `WarrantyExpirationDate` date NOT NULL,
  `CostOfAppliance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appliance`
--

INSERT INTO `appliance` (`ApplianceID`, `UserID`, `ApplianceType`, `Brand`, `ModelNumber`, `SerialNumber`, `PurchaseDate`, `WarrantyExpirationDate`, `CostOfAppliance`) VALUES
(2, 2, 'Refrigerator', 'HAHA', 'NS-87998', 'SN-587001', '2025-04-18', '2025-08-31', 398.00),
(4, 4, 'Washing Machine', 'washining', 'MB-897', 'SN-458793', '2025-04-18', '2025-07-05', 654.99),
(5, 5, 'Dishwasher', 'LavaTudo', 'AB-654', 'SN-3014', '2025-04-18', '2025-09-25', 987.00),
(6, 6, 'Refrigerator', 'hka', 'as-8975', 'sn-96547', '2025-04-02', '2026-01-07', 1248.00),
(7, 1, 'Microwave', 'Canarinho', 'AS-1472', 'SN-347891', '2025-01-15', '2026-02-21', 398.97),
(8, 7, 'Microwave', 'Hagooe', 'AB-896363', 'SN-3247888', '2025-04-15', '2025-12-26', 456.00),
(9, 7, 'Dishwasher', 'Hagsas', 'AB-896454', 'SN-32451454', '2025-03-07', '2025-12-31', 987.00),
(10, 3, 'Washing Machine', 'Hagsasas', 'AB-896466', 'SN-3246666', '2025-05-09', '2026-01-23', 874.00),
(11, 8, 'Dishwasher', 'Grande', 'AS-6396', 'SN-789422', '2024-09-12', '2026-12-29', 2540.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Mobile` varchar(15) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Eircode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `FirstName`, `LastName`, `Address`, `Mobile`, `Email`, `Eircode`) VALUES
(1, 'Aline', 'Mc', '10 father patrick', '0862722555', 'aline.mc@gmail.com', 'T23D789'),
(2, 'Aline', 'rarra', '5 the Close, Lady&#039;s well, ArdPatrick', '0862722391', 'aline.andrade.costa12@gmail.com', 'T23D785'),
(3, 'Aline', 'Lasls', '5 the black', '5656488899', 'costa12@gmail.com', 'T23D785'),
(4, 'Joao', 'Vicente', '10 father dominic', '0862798431', 'joao@gmail.com', 'T33 56X8'),
(5, 'Carlos', 'Silva', '55 the close', '0859741234', 'sulvinha@gmail.com', 'T33 789S'),
(6, 'Ana', 'Costa', '5 the Close, Lady&#039;s well, ArdPatrick', '0862722391', 'aline.costa12@gmail.com', 'T23 D2265'),
(7, 'Marcos', 'gragaa', '358 the Close', '08627879555', 'hallo@gmail.com', 'T33 6d54'),
(8, 'John', 'Mc', '10 father dominic', '086272999999', 'john.mc@gmail.com', 'T12 98987'),
(9, 'Ana', 'Boenia', '777 Puio CXii', '08597823145', 'ANA.PUIO@GMAIL.COM', 'T54 89745');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appliance`
--
ALTER TABLE `appliance`
  ADD PRIMARY KEY (`ApplianceID`),
  ADD KEY `FK` (`UserID`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appliance`
--
ALTER TABLE `appliance`
  MODIFY `ApplianceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appliance`
--
ALTER TABLE `appliance`
  ADD CONSTRAINT `UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
