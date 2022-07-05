-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2022 at 10:14 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blooddonation`
--

-- --------------------------------------------------------

--
-- Table structure for table `aphresis_donation`
--

CREATE TABLE `aphresis_donation` (
  `DonationListID` int(12) NOT NULL,
  `PlateletVolume` int(255) NOT NULL,
  `PlasmaVolume` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `aphresis_donation`
--

INSERT INTO `aphresis_donation` (`DonationListID`, `PlateletVolume`, `PlasmaVolume`) VALUES
(1003, 100, 200),
(1005, 100, 200),
(1009, 150, 300),
(1010, 100, 200),
(1011, 100, 200),
(1012, 100, 200),
(1015, 100, 200),
(1017, 150, 300),
(1018, 100, 200);

-- --------------------------------------------------------

--
-- Table structure for table `blood`
--

CREATE TABLE `blood` (
  `BloodID` int(12) NOT NULL,
  `BloodType` enum('A+','A-','B+','B-','O+','O-','AB+','AB-') COLLATE utf8_unicode_ci NOT NULL,
  `DonationDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `blood`
--

INSERT INTO `blood` (`BloodID`, `BloodType`, `DonationDate`) VALUES
(1, 'O-', '2021-09-24'),
(2, 'O+', '2021-10-02'),
(3, 'O-', '2021-10-16'),
(4, 'A+', '2021-11-05'),
(5, 'O-', '2021-11-09'),
(6, 'AB+', '2022-01-07'),
(7, 'O-', '2022-01-07'),
(8, 'O-', '2022-01-22'),
(9, 'AB+', '2022-01-30'),
(10, 'B+', '2022-02-04'),
(11, 'A+', '2022-02-04'),
(12, 'B-', '2022-02-19'),
(13, 'B+', '2022-02-19'),
(14, 'A+', '2022-02-26'),
(15, 'O+', '2022-03-15');

-- --------------------------------------------------------

--
-- Table structure for table `blood_bank`
--

CREATE TABLE `blood_bank` (
  `DonationListID` int(12) NOT NULL,
  `BankID` int(12) NOT NULL,
  `BankName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `BankAddress` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `BankTelNumber` int(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `blood_bank`
--

INSERT INTO `blood_bank` (`DonationListID`, `BankID`, `BankName`, `BankAddress`, `BankTelNumber`) VALUES
(1002, 200524, 'Pusat Darah Negara', 'Jalan Tun Razak, 50400 Kuala Lumpur', 326955557),
(1005, 200478, 'Unit Transfusi Perubatan, Hospital Sultanah Aminah', '80100 Johor Bharu, Johor.', 73565034),
(1008, 200302, 'Unit Transfusi Perubatan, Hospital Umum Sarawak', 'Jalan Tun Ahmad Zaidi Adruse, 93586 Kuching, Sarawak', 82276666),
(1010, 200203, 'Unit Transfusi Perubatan Hospital Sultanah Bahiyah', '05100,Alor Star,Kedah', 37406265),
(1011, 200584, 'Unit Transfusi Perubatan Hospital Tengku Ampuan Afzan', '25100 Kuantan,Pahang', 95572085),
(1012, 200302, 'Unit Transfusi Perubatan, Hospital Umum Sarawak', 'Jalan Tun Ahmad Zaidi Adruse, 93586 Kuching, Sarawak', 82276666),
(1015, 200584, 'Unit Transfusi Perubatan Hospital Tengku Ampuan Afzan', '25100 Kuantan,Pahang', 95572085),
(1018, 200524, 'Pusat Darah Negara', 'Jalan Tun Razak, 50400 Kuala Lumpur', 326955557);

-- --------------------------------------------------------

--
-- Table structure for table `donation_list`
--

CREATE TABLE `donation_list` (
  `DonationListID` int(12) NOT NULL,
  `HemoglobinLevel` float(3,1) NOT NULL,
  `BloodDonationType` enum('W','A') NOT NULL,
  `FluidVolume` int(255) NOT NULL,
  `DonationLocation` enum('B','L','M') NOT NULL,
  `DonorID` int(12) DEFAULT NULL,
  `DonationDate` date NOT NULL,
  `EmpID` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donation_list`
--

INSERT INTO `donation_list` (`DonationListID`, `HemoglobinLevel`, `BloodDonationType`, `FluidVolume`, `DonationLocation`, `DonorID`, `DonationDate`, `EmpID`) VALUES
(1001, 14.3, 'W', 460, 'M', 1238714891, '2021-09-24', 622943),
(1002, 14.9, 'W', 450, 'L', 1293810983, '2021-10-02', 622943),
(1003, 15.6, 'A', 300, 'L', 1823958746, '2021-10-16', 622943),
(1004, 13.8, 'W', 450, 'M', 1878237489, '2021-11-05', 622943),
(1005, 14.1, 'A', 300, 'B', 1238714891, '2021-11-09', 622943),
(1006, 15.7, 'W', 450, 'L', 1295435641, '2022-01-07', 622943),
(1007, 14.5, 'W', 450, 'M', 1238714891, '2022-01-07', 649852),
(1008, 14.3, 'W', 450, 'B', 1823958746, '2022-01-22', 649852),
(1009, 13.4, 'A', 450, 'M', 1295435641, '2022-01-30', 649852),
(1010, 13.0, 'A', 300, 'B', 1359876541, '2022-02-04', 649852),
(1011, 14.7, 'A', 300, 'B', 1486325640, '2022-02-04', 649852),
(1012, 13.6, 'A', 300, 'B', 1659998525, '2022-02-05', 649852),
(1013, 13.6, 'W', 450, 'L', 1456823331, '2022-02-19', 673563),
(1014, 15.2, 'W', 450, 'L', 1468555573, '2022-02-19', 673563),
(1015, 14.0, 'A', 300, 'B', 1878237489, '2022-02-22', 673563),
(1016, 14.2, 'W', 450, 'M', 1448085377, '2022-02-26', 673563),
(1017, 16.0, 'A', 450, 'M', 1685469998, '2022-03-15', 673563),
(1018, 13.6, 'A', 300, 'B', 1486325640, '2022-06-23', 748621),
(1019, 14.7, 'W', 450, 'L', 1878237490, '2022-06-30', 622943);

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `DonorID` int(12) NOT NULL,
  `DonorName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `DonorIC/Passport_No` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `DonorWeight` float NOT NULL,
  `DonorAge` int(100) NOT NULL,
  `DonorSex` enum('M','F') COLLATE utf8_unicode_ci NOT NULL,
  `DonorPhoneNo` int(13) NOT NULL,
  `DonorAddress` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `DonorEmail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `DonorNationality` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `LastDonation` date NOT NULL,
  `DonationFrequency` int(12) NOT NULL,
  `BloodType` enum('A+','A-','B+','B-','O+','O-','AB+','AB-') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`DonorID`, `DonorName`, `DonorIC/Passport_No`, `DonorWeight`, `DonorAge`, `DonorSex`, `DonorPhoneNo`, `DonorAddress`, `DonorEmail`, `DonorNationality`, `LastDonation`, `DonationFrequency`, `BloodType`) VALUES
(1238714891, 'Liew Kai Jun', '980613147133', 70, 24, 'M', 127789608, '14, Sri Bayu, 43200 Cheras, Selangor', 'lkj@gmail.com', 'Malaysian', '2022-01-07', 3, 'A-'),
(1293810983, 'Jeremi Kek Teng Fong', '000303146133', 55, 22, 'M', 126435798, '805, Jalan Kemacahaya, 43200 Cheras, Selangor', 'jeremi@gmail.com', 'Malaysian', '2021-10-02', 1, 'O+'),
(1295435641, 'Zanariah Noor', '910307568686', 65, 31, 'F', 105974685, '33, Taman Setia, 43200 Cheras, Selangor', 'norzana12@gmail.com', 'Malaysian', '2022-01-30', 2, 'AB+'),
(1359876541, 'Tan Soon Huat', '740604254771', 73, 48, 'M', 161486354, 'No.26,Lorong 7,Taman Gurun Jaya,Gurun, Kedah', 'hhuat357@yahoo.com', 'Malaysian', '2022-02-04', 1, 'B+'),
(1448085377, 'Haika bin Muhammad Zikri', '71016453333', 85, 43, 'M', 103566854, 'No3, Jalan taman purnama, 20400 Kuala Terengganu, Terengganu', 'ka1999ak@outlook.com', 'Malaysian', '2022-02-26', 1, 'A+'),
(1456823331, 'Jane Camilia', '000426064828', 52, 22, 'F', 105698421, 'No5. Taman Bistari, 27600 Raub, Pahang', 'janneyca@gmail.com', 'Malaysian', '2022-02-19', 1, 'B-'),
(1468555573, 'Hamirul bin Jali', '861211081357', 76, 36, 'M', 16485365, 'No. 65, Jalan Pengkalan Utama 1, Taman Pengkalan Utama, 31650 Ipoh,Perak', 'hamirulllll23@outlook.com', 'Malaysian', '2022-02-19', 1, 'B-'),
(1486325640, 'Airell bin Sariff', '930304355133', 85, 37, 'M', 125864447, 'B-2-6, Pangsapuri Taman Bentong Makmur, 28700 Bentong, Pahang', 'airell3541@gmail.com', 'Malaysian', '2022-06-23', 2, 'B+'),
(1659998525, 'Nurul Fatin binti Abu Bakar', '870505085222', 61, 35, 'F', 164851133, '22, Jalan Raja Di Hilir, 30350 Ipoh, Perak', 'fatintinti@yahoo.com', 'Malaysian', '2022-02-05', 1, 'B+'),
(1685469998, 'Chan Xi Ping', '930306353919', 64, 29, 'M', 168544475, 'No. 3, Jalan Padang Victoria, 10400 George Town, Pulau Pinang', 'xipinggggxi@yahoo.com', 'Malaysian', '2022-03-15', 1, 'O+'),
(1823958746, 'Muhammad Danial Irfan', '980215501313', 70, 24, 'M', 1178944560, '43, Lorong Berlian 1E, 94300, Kota Samarahan, Sarawak', 'danial@gmail.com', 'Malaysian', '2022-01-22', 2, 'O-'),
(1878237489, 'Muhammad Luqman Hakim', '990118137333', 67, 23, 'M', 178567489, '58 ,Lorong Samarindah 21A5, 94300, Kota Samarahan, Sarawak', 'luqman@gmail.com', 'Malaysian', '2022-02-22', 1, 'A+'),
(1878237490, 'Muhammad Ali', '011120132017', 70, 21, 'M', 111123456, 'No 1 Lorong ABC', 'alimuhammad@gmail.com', 'Malaysian', '2022-06-30', 1, 'A+'),
(1878237491, 'Dummy Name', '880516566248', 63, 41, 'F', 123456789, '1, Jalan Song, Sarawak', 'DummyEmail12@gmail.com', 'Malaysian', '0000-00-00', 0, 'A+');

-- --------------------------------------------------------

--
-- Table structure for table `local_health_centre`
--

CREATE TABLE `local_health_centre` (
  `DonationListID` int(12) NOT NULL,
  `CentreID` int(12) NOT NULL,
  `CentreName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `CentreAddress` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `CentreTelNumber` int(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `local_health_centre`
--

INSERT INTO `local_health_centre` (`DonationListID`, `CentreID`, `CentreName`, `CentreAddress`, `CentreTelNumber`) VALUES
(1002, 100991, 'KPJ Penang Specialist Hospital', '570, Jln Perda Utama, Bandar Baru Perda, 14000 Bukit Mertajam, Pulau Pinang', 45486688),
(1003, 100991, 'KPJ Penang Specialist Hospital', '570, Jln Perda Utama, Bandar Baru Perda, 14000 Bukit Mertajam, Pulau Pinang', 45486688),
(1006, 100681, 'Pantai Hospital Cheras', '1, Jalan 1/96a, Taman Cheras Makmur, 56100 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur', 91452888),
(1013, 100681, 'Pantai Hospital Cheras', '1, Jalan 1/96a, Taman Cheras Makmur, 56100 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur', 91452888),
(1014, 100413, 'Pantai Hospital Ipoh', '126, Jalan Tambun, Taman Ipoh, 31400 Ipoh, Perak', 55405555),
(1019, 100991, 'KPJ Penang Specialist Hospital', '570, Jln Perda Utama, Bandar Baru Perda, 14000 Bukit Mertajam, Pulau Pinang', 45486688);

-- --------------------------------------------------------

--
-- Table structure for table `medical_officer`
--

CREATE TABLE `medical_officer` (
  `EmpID` int(12) NOT NULL,
  `EmpName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `EmpAge` int(3) NOT NULL,
  `EmpEmail` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EmpAddress` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `EmpPhoneNo` int(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `medical_officer`
--

INSERT INTO `medical_officer` (`EmpID`, `EmpName`, `EmpAge`, `EmpEmail`, `EmpAddress`, `EmpPhoneNo`) VALUES
(622943, 'Areesa binti Sham ', 35, 'Sasaree@yahoo.com', 'No. 46, Jalan Ah Peng. 28700 Bentong, Pahang', 105211355),
(649852, 'Sarah Lo', 51, 'Sarahlo2507@gmail.com', '3, Jln Raja Gopal, Pulau Tikus, 10350 George Town, Pulau Pinang', 126845512),
(673563, 'Vasantha A/P Lakshman', 29, 'vasantha@gmail.com', '31, Jalan Berlian 2K, 94300 Kota Samarahan, Sarawak', 163467896),
(748621, 'Lam Li ', 29, 'Laammm@hotmail.com', 'No. 6, Taman Talapia, 05350 Alor Setar, Kedah', 1126587469),
(753787, 'Noor Azizah Binti Hassan', 43, 'zizah567noor@gmail.com', '67, Jln Taming Lapan, Taman Tanming Jaya. Seri Kembangan 43300, Selangor', 124680256),
(765282, 'Chen Xiao Ling', 30, 'xl@gmail.com', 'Blok B-302, Jalan Jaya, 43200 Cheras, Selangor', 177321456),
(785266, 'Nam Hui Xin', 42, 'hxnam@hotmail.com', 'No. 3, Jalan Greentown, 30450 Ipoh, Perak', 124551126),
(842555, 'Mo Kam Loong ', 41, 'kloongggg@gmail.com', 'No.99, Jalan Banggol, 20100 Kuala Terengganu, Terengganu', 125668887),
(864567, 'Mohammad Haiqal', 27, 'haiqal@gmail.com', '14, Lorong Merdang Gayam, 93450 Kuching, Sarawak', 126879548),
(873626, 'Muhammad Ali', 27, 'ali@gmail.com', '13, Jalan Sinar, 43200 Cheras, Selangor', 127562336),
(964528, 'Siti Nur Sofia', 26, 'siti@gmail.com', 'Lorong Midway Crescent 5B, 94300 Kota Samarahan, Sarawak', 1165427890);

-- --------------------------------------------------------

--
-- Table structure for table `mobile_blood_donation_program`
--

CREATE TABLE `mobile_blood_donation_program` (
  `DonationListID` int(12) NOT NULL,
  `ProgramID` int(12) NOT NULL,
  `ProgramName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ProgramAddress` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ProgramDate` date NOT NULL,
  `ProgramTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mobile_blood_donation_program`
--

INSERT INTO `mobile_blood_donation_program` (`DonationListID`, `ProgramID`, `ProgramName`, `ProgramAddress`, `ProgramDate`, `ProgramTime`) VALUES
(1001, 900209, 'Jom Derma Darah', 'Kuantan Parade Lobi, Jalan Haji Abdul Rahman, 25000 Kuantan, Pahang', '2021-09-24', '11:30:00'),
(1004, 900214, 'Kempen Derma Darah Anjuran Pusat Kesihatan UNIMAS', 'Dewan Kristal, BHEPA, UNIMAS 94300, Kota Samarahan', '2021-11-05', '09:00:00'),
(1007, 900578, 'Darah Tak Pernah Cuti', 'Aeon Mall, No.1, Jalan Akuatik 13/64, Seksyen 13, 40100, Shah Alam, Selangor', '2022-01-07', '14:30:00'),
(1009, 900578, 'Darah Tak Pernah Cuti', 'Aeon Mall, No.1, Jalan Akuatik 13/64, Seksyen 13, 40100, Shah Alam, Selangor', '2022-01-07', '14:30:00'),
(1016, 900568, 'Derma Darah Terengganu Kita', '10599, Jalan Kampung Batin, Kampung Batin, 21300 Kuala Terengganu, Terengganu', '2022-02-26', '09:00:00'),
(1017, 900770, 'Kempen Derma Darah Bergerak', '1154 Penang Science Park, Lorong Perindustrian Bukit Minyak 22, 14100 Simpang Ampat, Penang', '2022-03-15', '08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `whole_blood_donation`
--

CREATE TABLE `whole_blood_donation` (
  `DonationListID` int(12) NOT NULL,
  `PackedRedCellsVolume` int(255) NOT NULL,
  `PlateletVolume` int(255) NOT NULL,
  `PlasmaVolume` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `whole_blood_donation`
--

INSERT INTO `whole_blood_donation` (`DonationListID`, `PackedRedCellsVolume`, `PlateletVolume`, `PlasmaVolume`) VALUES
(1, 300, 100, 50),
(1001, 300, 100, 60),
(1002, 300, 100, 50),
(1004, 300, 100, 50),
(1006, 300, 100, 50),
(1007, 300, 100, 50),
(1008, 300, 100, 50),
(1013, 300, 100, 50),
(1014, 300, 100, 50),
(1015, 300, 100, 50),
(1016, 300, 100, 50),
(1019, 300, 100, 50);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aphresis_donation`
--
ALTER TABLE `aphresis_donation`
  ADD PRIMARY KEY (`DonationListID`),
  ADD KEY `FK_DonationListID` (`DonationListID`) USING BTREE;

--
-- Indexes for table `blood`
--
ALTER TABLE `blood`
  ADD PRIMARY KEY (`BloodID`);

--
-- Indexes for table `blood_bank`
--
ALTER TABLE `blood_bank`
  ADD PRIMARY KEY (`DonationListID`),
  ADD KEY `FK_DonationListID` (`DonationListID`);

--
-- Indexes for table `donation_list`
--
ALTER TABLE `donation_list`
  ADD PRIMARY KEY (`DonationListID`),
  ADD KEY `FK_DonorID` (`DonorID`),
  ADD KEY `DonationList_ibfk_2` (`EmpID`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`DonorID`);

--
-- Indexes for table `local_health_centre`
--
ALTER TABLE `local_health_centre`
  ADD PRIMARY KEY (`DonationListID`),
  ADD KEY `FK_DonationListID` (`DonationListID`);

--
-- Indexes for table `medical_officer`
--
ALTER TABLE `medical_officer`
  ADD PRIMARY KEY (`EmpID`);

--
-- Indexes for table `mobile_blood_donation_program`
--
ALTER TABLE `mobile_blood_donation_program`
  ADD PRIMARY KEY (`DonationListID`),
  ADD KEY `FK_DonationListID` (`DonationListID`);

--
-- Indexes for table `whole_blood_donation`
--
ALTER TABLE `whole_blood_donation`
  ADD PRIMARY KEY (`DonationListID`),
  ADD KEY `FK_DonationListID` (`DonationListID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blood`
--
ALTER TABLE `blood`
  MODIFY `BloodID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `donation_list`
--
ALTER TABLE `donation_list`
  MODIFY `DonationListID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1028;

--
-- AUTO_INCREMENT for table `donor`
--
ALTER TABLE `donor`
  MODIFY `DonorID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1878237497;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aphresis_donation`
--
ALTER TABLE `aphresis_donation`
  ADD CONSTRAINT `FK_DonationList` FOREIGN KEY (`DonationListID`) REFERENCES `donation_list` (`DonationListID`);

--
-- Constraints for table `blood_bank`
--
ALTER TABLE `blood_bank`
  ADD CONSTRAINT `Blood Bank_ibfk_1` FOREIGN KEY (`DonationListID`) REFERENCES `donation_list` (`DonationListID`);

--
-- Constraints for table `donation_list`
--
ALTER TABLE `donation_list`
  ADD CONSTRAINT `DonationList_ibfk_1` FOREIGN KEY (`DonorID`) REFERENCES `donor` (`DonorID`),
  ADD CONSTRAINT `DonationList_ibfk_2` FOREIGN KEY (`EmpID`) REFERENCES `medical_officer` (`EmpID`);

--
-- Constraints for table `local_health_centre`
--
ALTER TABLE `local_health_centre`
  ADD CONSTRAINT `Local Health Centre_ibfk_1` FOREIGN KEY (`DonationListID`) REFERENCES `donation_list` (`DonationListID`);

--
-- Constraints for table `mobile_blood_donation_program`
--
ALTER TABLE `mobile_blood_donation_program`
  ADD CONSTRAINT `Mobile Blood Donation Program_ibfk_1` FOREIGN KEY (`DonationListID`) REFERENCES `donation_list` (`DonationListID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
