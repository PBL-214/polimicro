-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260411.e2d74342d3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 27, 2026 at 02:12 PM
-- Server version: 8.4.3
-- PHP Version: 8.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasi_microcredential`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calon_pelajar`
--

CREATE TABLE `calon_pelajar` (
  `nik` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(10) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text,
  `provinsi` varchar(100) DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nomor_hp` varchar(20) DEFAULT NULL,
  `informasi_ortu` text,
  `lampiran` varchar(255) DEFAULT NULL,
  `admin_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `nid` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text,
  `jenis_kelamin` varchar(10) DEFAULT NULL,
  `prodi_asal` varchar(100) DEFAULT NULL,
  `admin_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `makul`
--

CREATE TABLE `makul` (
  `kode_makul` varchar(20) NOT NULL,
  `nama_makul` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `kode_prodi` varchar(20) DEFAULT NULL,
  `nid` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `kode_materi` varchar(20) NOT NULL,
  `nama_materi` varchar(100) DEFAULT NULL,
  `deskripsi_materi` text,
  `file_materi` varchar(255) DEFAULT NULL,
  `kode_makul` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelajar`
--

CREATE TABLE `pelajar` (
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(10) DEFAULT NULL,
  `alamat` text,
  `status` varchar(50) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `kode_prodi` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengerjaan_tugas`
--

CREATE TABLE `pengerjaan_tugas` (
  `id` int NOT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `kode_tugas` varchar(20) DEFAULT NULL,
  `file_dikumpul` varchar(255) DEFAULT NULL,
  `waktu_kumpul` datetime DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prodi_mikro`
--

CREATE TABLE `prodi_mikro` (
  `kode_prodi` varchar(20) NOT NULL,
  `nama_prodi` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `nid` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `kode_tugas` varchar(20) NOT NULL,
  `nama_tugas` varchar(100) DEFAULT NULL,
  `deskripsi_tugas` text,
  `format_file` varchar(50) DEFAULT NULL,
  `tanggal_awal_deadline` date DEFAULT NULL,
  `tanggal_akhir_deadline` date DEFAULT NULL,
  `kode_materi` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `views_materi`
--

CREATE TABLE `views_materi` (
  `id` int NOT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `kode_materi` varchar(20) DEFAULT NULL,
  `waktu_akses_materi` datetime DEFAULT NULL,
  `waktu_selesai_materi` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `calon_pelajar`
--
ALTER TABLE `calon_pelajar`
  ADD PRIMARY KEY (`nik`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`nid`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `makul`
--
ALTER TABLE `makul`
  ADD PRIMARY KEY (`kode_makul`),
  ADD KEY `kode_prodi` (`kode_prodi`),
  ADD KEY `nid` (`nid`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`kode_materi`),
  ADD KEY `kode_makul` (`kode_makul`);

--
-- Indexes for table `pelajar`
--
ALTER TABLE `pelajar`
  ADD PRIMARY KEY (`nim`),
  ADD KEY `nik` (`nik`),
  ADD KEY `kode_prodi` (`kode_prodi`);

--
-- Indexes for table `pengerjaan_tugas`
--
ALTER TABLE `pengerjaan_tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim` (`nim`),
  ADD KEY `kode_tugas` (`kode_tugas`);

--
-- Indexes for table `prodi_mikro`
--
ALTER TABLE `prodi_mikro`
  ADD PRIMARY KEY (`kode_prodi`),
  ADD KEY `nid` (`nid`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`kode_tugas`),
  ADD KEY `kode_materi` (`kode_materi`);

--
-- Indexes for table `views_materi`
--
ALTER TABLE `views_materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim` (`nim`),
  ADD KEY `kode_materi` (`kode_materi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengerjaan_tugas`
--
ALTER TABLE `pengerjaan_tugas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `views_materi`
--
ALTER TABLE `views_materi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calon_pelajar`
--
ALTER TABLE `calon_pelajar`
  ADD CONSTRAINT `calon_pelajar_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `makul`
--
ALTER TABLE `makul`
  ADD CONSTRAINT `makul_ibfk_1` FOREIGN KEY (`kode_prodi`) REFERENCES `prodi_mikro` (`kode_prodi`),
  ADD CONSTRAINT `makul_ibfk_2` FOREIGN KEY (`nid`) REFERENCES `dosen` (`nid`);

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`kode_makul`) REFERENCES `makul` (`kode_makul`);

--
-- Constraints for table `pelajar`
--
ALTER TABLE `pelajar`
  ADD CONSTRAINT `pelajar_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `calon_pelajar` (`nik`),
  ADD CONSTRAINT `pelajar_ibfk_2` FOREIGN KEY (`kode_prodi`) REFERENCES `prodi_mikro` (`kode_prodi`);

--
-- Constraints for table `pengerjaan_tugas`
--
ALTER TABLE `pengerjaan_tugas`
  ADD CONSTRAINT `pengerjaan_tugas_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `pelajar` (`nim`),
  ADD CONSTRAINT `pengerjaan_tugas_ibfk_2` FOREIGN KEY (`kode_tugas`) REFERENCES `tugas` (`kode_tugas`);

--
-- Constraints for table `prodi_mikro`
--
ALTER TABLE `prodi_mikro`
  ADD CONSTRAINT `prodi_mikro_ibfk_1` FOREIGN KEY (`nid`) REFERENCES `dosen` (`nid`);

--
-- Constraints for table `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_ibfk_1` FOREIGN KEY (`kode_materi`) REFERENCES `materi` (`kode_materi`);

--
-- Constraints for table `views_materi`
--
ALTER TABLE `views_materi`
  ADD CONSTRAINT `views_materi_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `pelajar` (`nim`),
  ADD CONSTRAINT `views_materi_ibfk_2` FOREIGN KEY (`kode_materi`) REFERENCES `materi` (`kode_materi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
