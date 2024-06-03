-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2024 at 08:35 AM
-- Server version: 8.2.0
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diagnostic_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `gender` varchar(45) NOT NULL,
  `image` varchar(500) NOT NULL,
  `password` varchar(45) NOT NULL DEFAULT '@admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `firstName`, `lastName`, `email`, `phone`, `dateOfBirth`, `gender`, `image`, `password`) VALUES
(1, 'Md. Hasibul', 'Hasan', 'hasib@admin.com', '01643183705', '2003-04-17', 'Male', 'hasib.jpg', '@hasib009'),
(2, 'Md. Hasan', 'Imam', 'hasan@admin.com', '01732500958', '1973-11-19', 'Male', 'hasan.jpg', '@admin'),
(4, 'Rakibul Hasan', 'Nahid', 'nahid@test.com', '01732500958', '2006-07-11', 'male', 'testPhoto.jpg', '@admin123');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointmentID` int NOT NULL,
  `patientID` int NOT NULL,
  `appointmentType` varchar(250) NOT NULL,
  `doctorID` int DEFAULT NULL,
  `testID` int DEFAULT NULL,
  `appointmentDay` varchar(250) NOT NULL,
  `appointmentTime` varchar(250) NOT NULL,
  `patientType` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointmentID`, `patientID`, `appointmentType`, `doctorID`, `testID`, `appointmentDay`, `appointmentTime`, `patientType`, `status`) VALUES
(1, 1, 'Doctor', 1, NULL, 'Thursday', '19:30', 'New', 'Confirmed'),
(3, 1, 'Test', NULL, 1, 'Friday', '20:00', 'New', 'Confirmed'),
(4, 8, 'Doctor', 3, NULL, 'Monday', '16:30', 'New', 'Confirmed'),
(5, 8, 'Test', NULL, 6, 'Tuesday', '15:00', 'New', 'Confirmed'),
(8, 1, 'Doctor', 4, NULL, 'Thursday', '18:30', 'Old', 'Confirmed'),
(9, 1, 'Test', NULL, 9, 'Monday', '18:00', 'New', 'Confirmed'),
(10, 1, 'Test', NULL, 3, 'Monday', '17:00', 'New', 'Confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctorID` int NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `gender` varchar(45) NOT NULL,
  `image` varchar(500) NOT NULL,
  `specialization` varchar(45) NOT NULL,
  `newFee` varchar(45) NOT NULL,
  `oldFee` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL DEFAULT '@doctor123'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctorID`, `firstName`, `lastName`, `email`, `phone`, `dateOfBirth`, `gender`, `image`, `specialization`, `newFee`, `oldFee`, `password`) VALUES
(1, 'Mr. Doctor', '01', 'doctor@doctor.com', '01643183705', '2003-04-17', 'male', 'demo-doctor.jpg', 'Cardiology', '1500', '800', '@doctor123'),
(2, 'Demo', '02', 'demo@demo.com', '01643183705', '2003-07-06', 'female', 'demo-doctor.jpg', 'Cardiology', '1500', '500', '@doctor123'),
(3, 'Dr. Hasibul', 'Hasan', 'hasib@doctor.com', '01643183705', '2003-04-17', 'male', 'hasib.jpg', 'All Rounder', '1800', '1400', '@doctor123'),
(4, 'SHAMSUL', 'HAQUE', 'sam@doctor.com', '01642558156', '1997-02-27', 'male', 'demo.jpg', 'Eye', '1200', '500', '@doctor123'),
(5, 'Hasan', 'Ali', 'hasanali@doctor.com', '01342867015', '1998-04-03', 'male', 'demo2.jpg', 'ENT', '1000', '500', '@doctor123'),
(6, 'Saiful', 'Alam', 'saiful@doctor.com', '01345267802', '1995-03-01', 'male', 'demo4.jpg', 'Neuro', '1200', '800', '@doctor123'),
(7, 'Dr. Munni', 'Brgum', 'munni@doctor.com', '013461875023', '1994-02-08', 'male', 'demo6.jpg', 'Cancer', '1000', '800', '@doctor123');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patientID` int NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `gender` varchar(45) NOT NULL,
  `image` varchar(500) NOT NULL,
  `password` varchar(45) NOT NULL DEFAULT '@patient123'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patientID`, `firstName`, `lastName`, `email`, `phone`, `dateOfBirth`, `gender`, `image`, `password`) VALUES
(1, 'Samiur', 'Alex', 'test@samiur.com', '01643333333', '2003-06-17', 'male', 'Samiur_Rabbi_Alex.jpg', '@patient123'),
(4, 'Demo', 'Patient', 'demo@patient.com', '01643183705', '2012-06-08', 'male', 'demo-doctor.jpg', '@patient123'),
(5, 'Patient', '03', 'patient@demo.com', '01643183705', '2009-06-20', 'female', 'tom.jpg', '@patient123'),
(7, 'Afrin', 'Khatun', 'afrin@gmail.com', '01643257985', '2003-06-10', 'female', 'anime_girl_pfp_2_by_kenkanekiart_dfbouue-pre.jpg', 'afrin123'),
(8, 'Shuborna', 'Begom', 'shuborna@gmail.com', '01645287932', '2001-10-20', 'female', 'images.jpg', 'shuborna');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int NOT NULL,
  `appointmentID` int NOT NULL,
  `paymentType` varchar(45) NOT NULL DEFAULT 'Cash',
  `amount` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentID`, `appointmentID`, `paymentType`, `amount`) VALUES
(1, 1, 'Cash', '1500'),
(3, 3, 'Cash', '1500'),
(4, 4, 'Cash', '1800'),
(5, 5, 'Cash', '600'),
(6, 6, 'Cash', '500'),
(7, 7, 'Cash', '1000'),
(8, 8, 'Cash', '500'),
(9, 9, 'Cash', '2500'),
(10, 10, 'Cash', '2000');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `prescriptionID` int NOT NULL,
  `appointmentID` int NOT NULL,
  `testID` int DEFAULT NULL,
  `medicineList` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`prescriptionID`, `appointmentID`, `testID`, `medicineList`) VALUES
(1, 1, 1, '[\"Napa 500mg 2x\",\"Afrin Nasal Drop 3x\"]'),
(2, 4, 6, '[\"Napa Extra 2x\",\"Beshi Koira Ghuma \"]'),
(5, 8, 3, '[\"Napa 2x Daily\",\"Osudh er Nam Jani Na :)\"]');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `reportID` int NOT NULL,
  `appointmentID` int NOT NULL,
  `description` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`reportID`, `appointmentID`, `description`) VALUES
(1, 3, '[\"Blood Group: O+(ve)\",\"Red Blood Count: 3.76 \"]'),
(2, 5, '[\"Pa Vainga Gese Mone Hoy. :)\",\"Mathay Brain ta Nai Dekhi :(\"]'),
(3, 10, '[\"Tui Ghuma Valo Koira.\",\"report Hobe kisu ekta\"]');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `scheduleID` int NOT NULL,
  `doctorID` int NOT NULL,
  `availableDay` varchar(255) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleID`, `doctorID`, `availableDay`, `startTime`, `endTime`) VALUES
(1, 1, 'Monday, Wednesday, Thursday', '10:30:00', '20:30:00'),
(2, 2, 'Sunday, Monday', '12:30:00', '20:30:00'),
(3, 3, 'Monday, Tuesday', '16:30:00', '22:30:00'),
(4, 4, 'Wednesday, Thursday', '10:30:00', '19:50:00'),
(5, 5, 'Monday, Tuesday, Wednesday', '16:30:00', '22:00:00'),
(6, 6, 'Sunday, Monday, Tuesday, Wednesday, Thursday', '10:30:00', '22:00:00'),
(7, 7, 'Sunday, Monday, Tuesday, Wednesday, Thursday', '11:00:00', '20:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `gender` varchar(45) NOT NULL,
  `staffType` varchar(45) NOT NULL,
  `image` varchar(500) NOT NULL,
  `password` varchar(45) NOT NULL DEFAULT '@staff123'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `firstName`, `lastName`, `email`, `phone`, `dateOfBirth`, `gender`, `staffType`, `image`, `password`) VALUES
(1, 'Kowshik', 'Ali', 'kowshik@staff.com', '01643183705', '2004-02-11', 'male', 'receptionist', 'testPhoto.jpg', '@staff123');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `testID` int NOT NULL,
  `testName` varchar(250) NOT NULL,
  `amount` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`testID`, `testName`, `amount`) VALUES
(1, 'Basic Blood Panel', '1500'),
(3, 'Genetic Testing', '2000'),
(5, ' Hormone Level Testing', '1800'),
(6, 'X-rays', '600'),
(7, 'Ultrasound', '1800'),
(8, 'CT Scan', '1300'),
(9, 'MRI', '2500');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointmentID`),
  ADD KEY `fkDoctor_idx` (`doctorID`),
  ADD KEY `fkPatient_idx` (`patientID`),
  ADD KEY `fkTest_idx` (`testID`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctorID`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patientID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`prescriptionID`),
  ADD KEY `fkTestID_idx` (`testID`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`reportID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`scheduleID`),
  ADD KEY `FK_DoctorID_idx` (`doctorID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`testID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointmentID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doctorID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patientID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `prescriptionID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `reportID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `scheduleID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `testID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `fkDoctor` FOREIGN KEY (`doctorID`) REFERENCES `doctor` (`doctorID`),
  ADD CONSTRAINT `fkPatient` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`),
  ADD CONSTRAINT `fkTest` FOREIGN KEY (`testID`) REFERENCES `test` (`testID`);

--
-- Constraints for table `prescription`
--
ALTER TABLE `prescription`
  ADD CONSTRAINT `fkTestID` FOREIGN KEY (`testID`) REFERENCES `test` (`testID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `FK_DoctorID` FOREIGN KEY (`doctorID`) REFERENCES `doctor` (`doctorID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
