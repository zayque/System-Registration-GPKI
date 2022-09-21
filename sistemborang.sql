-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2021 at 01:50 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistemborang`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

CREATE TABLE `adminlogin` (
  `user_id` int(100) NOT NULL,
  `user_first` varchar(500) NOT NULL,
  `user_last` varchar(500) NOT NULL,
  `user_email` varchar(500) NOT NULL,
  `user_uid` varchar(500) NOT NULL,
  `user_pwd` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adminlogin`
--

INSERT INTO `adminlogin` (`user_id`, `user_first`, `user_last`, `user_email`, `user_uid`, `user_pwd`) VALUES
(1, 'Akmal', 'Hafiz', 'zayque@yahoo.com', 'zayque', '$2y$10$nL7ejhLkp.dS5WE/WYFn0OckEVpsafUQtGUXPPh.UWsOt9Hyz2Bki'),
(2, 'muhd', 'syarif', 'syariff@gmail.com', 'syariff', '$2y$10$fclej.rMJ4CTPB38nJo7sOt8JaMWSNQiDyDJjZolNJvgF/MVSevoW');

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id_email` int(100) NOT NULL,
  `subject_email` varchar(400) NOT NULL,
  `body_email` varchar(400) NOT NULL,
  `altbody_email` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id_email`, `subject_email`, `body_email`, `altbody_email`) VALUES
(1, 'PENGESAHAN PENDAFTARAN KEHADIRAN LATIHAN PENGGUNA GPKI ', 'Untuk makluman, pengesahan kehadiran tuan/puan telah diterima dan Berjaya untuk mengikuti:\r\nLatihan Pengguna GPKI Zon Selatan 2021\r\nTarikh : 18 April 2021 (Khamis)\r\nMaklumat terperinci, sila rujuk lampiran agenda emel.', 'PENGESAHAN PENDAFTARAN KEHADIRAN LATIHAN PENGGUNA GPKI ');

-- --------------------------------------------------------

--
-- Table structure for table `email2`
--

CREATE TABLE `email2` (
  `id_email2` int(100) NOT NULL,
  `subject_email2` varchar(200) NOT NULL,
  `body_email2` varchar(400) NOT NULL,
  `altbody_email2` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email2`
--

INSERT INTO `email2` (`id_email2`, `subject_email2`, `body_email2`, `altbody_email2`) VALUES
(1, 'PENGESAHAN PENDAFTARAN KEHADIRAN SEMINAR PENGURUSAN GPKI ', 'Untuk makluman, pengesahan kehadiran tuan/puan telah diterima dan Berjaya untuk mengikuti: Seminar Pengurusan GPKI Zon Selatan 2021 Tarikh : 17 April 2021 (Rabu) Maklumat terperinci, sila rujuk lampiran agenda emel.', 'PENGESAHAN PENDAFTARAN KEHADIRAN SEMINAR PENGURUSAN GPKI ');

-- --------------------------------------------------------

--
-- Table structure for table `limitlatihan`
--

CREATE TABLE `limitlatihan` (
  `id_limit` int(100) NOT NULL,
  `jumlah_limit` int(255) NOT NULL,
  `mesej_limit` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `limitlatihan`
--

INSERT INTO `limitlatihan` (`id_limit`, `jumlah_limit`, `mesej_limit`) VALUES
(1, 200, 'Assalamualaikum w.b.t dan Salam Sejahtera,    Tuan/Puan,Untuk makluman, penyertaan ke Latihan Pengguna Prasarana Kunci Awam Kerajaan (Government Public Key Infrastructure (GPKI)) Versi 2.0. Zon Selatan telah DITUTUP kerana kuota telah mencukupi.  Tempat adalah terhad kepada 50 peserta yang terawal membuat pengesahan kehadiran.  Sekian, terima kasih.');

-- --------------------------------------------------------

--
-- Table structure for table `limitseminar`
--

CREATE TABLE `limitseminar` (
  `id_limit2` int(100) NOT NULL,
  `jumlah_limit2` int(200) NOT NULL,
  `mesej_limit2` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `limitseminar`
--

INSERT INTO `limitseminar` (`id_limit2`, `jumlah_limit2`, `mesej_limit2`) VALUES
(1, 300, 'Assalamualaikum w.b.t dan Salam Sejahtera,Tuan/Puan, Untuk makluman, penyertaan ke Seminar Pengurusan GPKI.  Zon Selatan telah DITUTUP kerana kuota telah mencukupi.  Tempat adalah terhad kepada 150 peserta yang terawal membuat pengesahan kehadiran. Sekian, terima kasih. ');

-- --------------------------------------------------------

--
-- Table structure for table `maklumat`
--

CREATE TABLE `maklumat` (
  `maklumat_id` int(100) NOT NULL,
  `maklumat_detail` varchar(300) NOT NULL,
  `maklumat_zon` varchar(100) NOT NULL,
  `maklumat_negeri` varchar(100) NOT NULL,
  `maklumat_tarikh` varchar(300) NOT NULL,
  `maklumat_hari` varchar(100) NOT NULL,
  `maklumat_masa` varchar(400) NOT NULL,
  `maklumat_tempat` varchar(300) NOT NULL,
  `maklumat_tempat2` varchar(100) NOT NULL,
  `maklumat_tempat3` varchar(100) NOT NULL,
  `maklumat_tempat4` varchar(100) NOT NULL,
  `maklumat_tempat5` varchar(100) NOT NULL,
  `maklumat_tempat6` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `maklumat`
--

INSERT INTO `maklumat` (`maklumat_id`, `maklumat_detail`, `maklumat_zon`, `maklumat_negeri`, `maklumat_tarikh`, `maklumat_hari`, `maklumat_masa`, `maklumat_tempat`, `maklumat_tempat2`, `maklumat_tempat3`, `maklumat_tempat4`, `maklumat_tempat5`, `maklumat_tempat6`) VALUES
(3, 'Latihan Pengguna GPKI Zon Selatan 2021', 'Tengah', 'Selangor', '18 April 2021', '	Jumaat ', '	09:30 pagi - 04:00 petang ', 'Taman Baiduri                                                                                                                                                                                                                                                                                               ', '', 'Sepang, Selangor', '43800', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `maklumat2`
--

CREATE TABLE `maklumat2` (
  `maklumat_id2` int(100) NOT NULL,
  `maklumat_detail2` varchar(200) NOT NULL,
  `maklumat_zon2` varchar(100) NOT NULL,
  `maklumat_negeri2` varchar(100) NOT NULL,
  `maklumat_tarikh2` varchar(200) NOT NULL,
  `maklumat_hari2` varchar(100) NOT NULL,
  `maklumat_masa2` varchar(400) NOT NULL,
  `maklumat_tempat2` varchar(200) NOT NULL,
  `maklumat_tempat22` varchar(100) NOT NULL,
  `maklumat_tempat23` varchar(100) NOT NULL,
  `maklumat_tempat24` varchar(100) NOT NULL,
  `maklumat_tempat25` varchar(100) NOT NULL,
  `maklumat_tempat26` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `maklumat2`
--

INSERT INTO `maklumat2` (`maklumat_id2`, `maklumat_detail2`, `maklumat_zon2`, `maklumat_negeri2`, `maklumat_tarikh2`, `maklumat_hari2`, `maklumat_masa2`, `maklumat_tempat2`, `maklumat_tempat22`, `maklumat_tempat23`, `maklumat_tempat24`, `maklumat_tempat25`, `maklumat_tempat26`) VALUES
(3, 'Seminar Pengurusan Perubahan GPKI ', 'Selatan', 'Johor', '17 April 2021', 'Rabu', '08:30 pagi - 05:00 petang', '', 'Hotel Hilton                                                                                        ', '79100', 'Nusajaya, Johor', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `negeri`
--

CREATE TABLE `negeri` (
  `zon_id` int(2) NOT NULL DEFAULT 0,
  `negeri` varchar(25) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `negeri`
--

INSERT INTO `negeri` (`zon_id`, `negeri`) VALUES
(1, 'Kuala Lumpur'),
(1, 'Selangor'),
(1, 'Putrajaya'),
(2, 'Kelantan'),
(2, 'Terengganu'),
(2, 'Pahang'),
(3, 'Perlis'),
(3, 'Kedah'),
(3, 'Pulau Pinang'),
(3, 'Perak'),
(4, 'Johor'),
(4, 'Negeri Sembilan'),
(4, 'Melaka'),
(5, 'Sabah'),
(6, 'Sarawak');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `email_user` varchar(500) NOT NULL,
  `nama_user` varchar(500) NOT NULL,
  `noic_user` varchar(12) NOT NULL,
  `notel_user` varchar(11) NOT NULL,
  `nopej_user` varchar(12) NOT NULL,
  `agensi_user` varchar(500) NOT NULL,
  `kementerian_user` varchar(500) NOT NULL,
  `gred_user` varchar(500) NOT NULL,
  `peranan_user` varchar(500) NOT NULL,
  `sistem_user` varchar(500) NOT NULL,
  `zon_user` varchar(500) NOT NULL,
  `negeri_user` varchar(500) NOT NULL,
  `jenis` varchar(100) NOT NULL,
  `masa` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `qrImg` varchar(250) NOT NULL,
  `qrlink` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `email_user`, `nama_user`, `noic_user`, `notel_user`, `nopej_user`, `agensi_user`, `kementerian_user`, `gred_user`, `peranan_user`, `sistem_user`, `zon_user`, `negeri_user`, `jenis`, `masa`, `qrImg`, `qrlink`) VALUES
(0, 'zayque@yahoo.com', 'Hashim', '990916023433', '0176768793', '0176768793', 'SMK Selangor', 'KEMENTERIAN PEMBANGUNAN WANITA, KELUARGA, MASYARAKAT', '0176768793', 'SUB ADMIN(SA)', 'MyCukai,MyeTaPP,uCustom,eROSA,', 'Selatan', 'Negeri Sembilan', 'Seminar', '2021-06-19 11:36:45', 'seminar1593470392.png', 'localhost/qrcodeseminar1593470392.png'),
(0, 'zayque@yahoo.com', 'Akmal', '990916025388', '0176768793', '0176768793', 'MYR', 'PENTADBIRAN KERAJAAN NEGERI SARAWAK', 'D', 'AUTHORIZED PERSONNEL(AP)', 'iGFMAS,eVetting,MyGST,', 'Tengah', 'Kelantan', 'Latihan', '2021-06-19 11:35:43', 'latihan945274100.png', 'localhost/qrcodelatihan945274100.png');

-- --------------------------------------------------------

--
-- Table structure for table `zon`
--

CREATE TABLE `zon` (
  `zon_id` int(2) NOT NULL,
  `zon` varchar(25) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zon`
--

INSERT INTO `zon` (`zon_id`, `zon`) VALUES
(1, 'Tengah'),
(2, 'Timur'),
(3, 'Utara'),
(4, 'Selatan'),
(5, 'Sabah'),
(6, 'Sarawak');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminlogin`
--
ALTER TABLE `adminlogin`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id_email`);

--
-- Indexes for table `email2`
--
ALTER TABLE `email2`
  ADD PRIMARY KEY (`id_email2`);

--
-- Indexes for table `limitlatihan`
--
ALTER TABLE `limitlatihan`
  ADD PRIMARY KEY (`id_limit`);

--
-- Indexes for table `limitseminar`
--
ALTER TABLE `limitseminar`
  ADD PRIMARY KEY (`id_limit2`);

--
-- Indexes for table `maklumat`
--
ALTER TABLE `maklumat`
  ADD PRIMARY KEY (`maklumat_id`);

--
-- Indexes for table `maklumat2`
--
ALTER TABLE `maklumat2`
  ADD PRIMARY KEY (`maklumat_id2`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`noic_user`);

--
-- Indexes for table `zon`
--
ALTER TABLE `zon`
  ADD PRIMARY KEY (`zon_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminlogin`
--
ALTER TABLE `adminlogin`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id_email` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email2`
--
ALTER TABLE `email2`
  MODIFY `id_email2` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `limitlatihan`
--
ALTER TABLE `limitlatihan`
  MODIFY `id_limit` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `limitseminar`
--
ALTER TABLE `limitseminar`
  MODIFY `id_limit2` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `maklumat`
--
ALTER TABLE `maklumat`
  MODIFY `maklumat_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `maklumat2`
--
ALTER TABLE `maklumat2`
  MODIFY `maklumat_id2` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `zon`
--
ALTER TABLE `zon`
  MODIFY `zon_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
