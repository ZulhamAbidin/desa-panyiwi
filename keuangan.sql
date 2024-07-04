-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 04, 2024 at 01:45 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keuangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `id` int NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `slip_gaji_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `export_laporan_penggajian`
--

CREATE TABLE `export_laporan_penggajian` (
  `id` int NOT NULL,
  `pegawai_id` int DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `export_laporan_penggajian`
--

INSERT INTO `export_laporan_penggajian` (`id`, `pegawai_id`, `file_path`, `created_at`) VALUES
(599, 38, 'export-data-penggajian-muflih-alghifari-salam-04-07-2024-13-26.pdf', '2024-07-04 13:26:08');

-- --------------------------------------------------------

--
-- Table structure for table `gaji_otomatis`
--

CREATE TABLE `gaji_otomatis` (
  `id` int NOT NULL,
  `pegawai_id` int DEFAULT NULL,
  `gaji_pokok` decimal(15,0) DEFAULT NULL,
  `tunjangan` decimal(15,0) DEFAULT NULL,
  `bonus` decimal(15,0) DEFAULT NULL,
  `potongan` decimal(15,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gaji_otomatis`
--

INSERT INTO `gaji_otomatis` (`id`, `pegawai_id`, `gaji_pokok`, `tunjangan`, `bonus`, `potongan`) VALUES
(67, 36, '1000000', '1000000', '1000000', '0'),
(68, 37, '1000000', '1000000', '1000000', '0'),
(69, 38, '1000000', '1000000', '1000000', '0'),
(70, 39, '1000000', '1000000', '1000000', '0'),
(71, 40, '1000000', '1000000', '1000000', '0');

-- --------------------------------------------------------

--
-- Table structure for table `gaji_pegawai`
--

CREATE TABLE `gaji_pegawai` (
  `id` int NOT NULL,
  `pegawai_id` int NOT NULL,
  `periode` date NOT NULL,
  `gaji_pokok` decimal(15,0) NOT NULL,
  `tunjangan` decimal(15,0) DEFAULT NULL,
  `potongan` decimal(15,0) DEFAULT NULL,
  `bonus` decimal(15,0) DEFAULT NULL,
  `total_gaji` decimal(15,0) NOT NULL,
  `tanggal_pembayaran` date DEFAULT NULL,
  `metode_pembayaran` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gaji_pegawai`
--

INSERT INTO `gaji_pegawai` (`id`, `pegawai_id`, `periode`, `gaji_pokok`, `tunjangan`, `potongan`, `bonus`, `total_gaji`, `tanggal_pembayaran`, `metode_pembayaran`) VALUES
(178, 36, '2024-07-04', '1000000', '1000000', '2000000', '1000000', '1000000', '2024-07-04', 'Transfer Bank'),
(179, 37, '2024-07-04', '1000000', '1000000', '2000000', '1000000', '1000000', '2024-07-04', 'Transfer Bank'),
(180, 38, '2024-07-04', '1000000', '1000000', '2000000', '1000000', '1000000', '2024-07-04', 'Transfer Bank'),
(181, 39, '2024-07-04', '1000000', '1000000', '2000000', '1000000', '1000000', '2024-07-04', 'Transfer Bank'),
(183, 40, '2024-07-04', '1000000', '1000000', '2000000', '1000000', '1000000', '2024-07-04', 'Transfer Bank'),
(196, 36, '2024-08-04', '1000000', '1000000', '0', '1000000', '3000000', '2024-07-04', 'Gopay'),
(197, 36, '2024-09-04', '1000000', '1000000', '0', '1000000', '3000000', '2024-08-04', 'Gopay'),
(198, 37, '2024-08-04', '1000000', '1000000', '0', '1000000', '3000000', '2024-07-04', 'Gopay'),
(199, 36, '2024-10-04', '1000000', '1000000', '0', '1000000', '3000000', '2024-09-04', 'Gopay');

-- --------------------------------------------------------

--
-- Table structure for table `histori_gaji`
--

CREATE TABLE `histori_gaji` (
  `id` int NOT NULL,
  `pegawai_id` int NOT NULL,
  `gaji_pegawai_id` int NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `histori_gaji`
--

INSERT INTO `histori_gaji` (`id`, `pegawai_id`, `gaji_pegawai_id`, `tanggal`, `keterangan`) VALUES
(63, 36, 178, '2024-07-03', 'Gaji untuk periode 2024-07-04'),
(64, 37, 179, '2024-07-03', 'Gaji untuk periode 2024-07-04'),
(65, 38, 180, '2024-07-03', 'Gaji untuk periode 2024-07-04'),
(66, 39, 181, '2024-07-03', 'Gaji untuk periode 2024-07-04'),
(68, 40, 183, '2024-07-03', 'Gaji untuk periode 2024-07-04');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `nama_kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Pendapatan'),
(2, 'Belanja'),
(3, 'Pembiayaan'),
(4, 'Penggajian');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_kategori`
--

CREATE TABLE `laporan_kategori` (
  `laporan_id` int DEFAULT NULL,
  `kategori_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laporan_kategori`
--

INSERT INTO `laporan_kategori` (`laporan_id`, `kategori_id`) VALUES
(1, 1),
(1001, 1),
(1004, 2),
(1005, 2),
(1006, 2),
(1007, 3),
(1008, 3),
(1009, 3),
(1010, 4),
(1013, 1),
(1014, 1),
(1015, 1),
(1101, 1),
(1102, 1),
(1103, 1),
(1104, 2),
(1105, 2),
(1106, 2),
(1107, 3),
(1108, 3),
(1109, 3),
(1110, 4),
(1111, 4),
(1112, 4),
(1113, 1),
(1114, 1),
(1115, 1),
(1201, 1),
(1202, 1),
(1203, 1),
(1204, 2),
(1206, 2),
(1207, 3),
(1210, 4),
(1211, 4),
(1212, 4),
(1214, 1),
(1215, 1),
(1216, 1),
(1217, 1),
(1218, 2),
(1220, 1),
(1221, 1),
(1222, 3);

-- --------------------------------------------------------

--
-- Table structure for table `laporan_keuangan`
--

CREATE TABLE `laporan_keuangan` (
  `id` int NOT NULL,
  `uraian` varchar(255) DEFAULT NULL,
  `ref` varchar(50) DEFAULT NULL,
  `anggaran` decimal(15,0) DEFAULT NULL,
  `realisasi` decimal(15,0) DEFAULT NULL,
  `selisih` decimal(15,0) DEFAULT NULL,
  `periode` date DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi_gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laporan_keuangan`
--

INSERT INTO `laporan_keuangan` (`id`, `uraian`, `ref`, `anggaran`, `realisasi`, `selisih`, `periode`, `gambar`, `deskripsi_gambar`) VALUES
(1, 'Pendapatan Januariaaaaaaa', 'asdasdas', '100000000', '110000000', '10000000', '2021-01-01', 'gambar_667d56733942e.png', ' sadasda '),
(1001, 'Pendapatan Awal Tahun 2022', 'REF1001', '11000000', '10000000', '1000000', '2022-01-01', 'gambar_667ae155499ec.jpg', NULL),
(1004, 'Belanja Pengadaan Kantor 2022', 'REF1004', '8500000', '8000000', '500000', '2022-01-01', 'gambar_667ae155499ec.jpg', NULL),
(1005, 'Belanja Peralatan Baru 2022', 'REF1005', '9500000', '9000000', '500000', '2022-02-01', 'gambar_667ae155499ec.jpg', NULL),
(1006, 'Belanja Maintenance 2022', 'REF1006', '10000000', '9500000', '500000', '2022-03-01', 'gambar_667ae155499ec.jpg', NULL),
(1007, 'Pembiayaan Pembaruan Sistem 2022', 'REF1007', '5500000', '5300000', '200000', '2022-01-01', 'gambar_667ae155499ec.jpg', NULL),
(1008, 'Pembiayaan Investasi 2022', 'REF1008', '6000000', '5500000', '500000', '2022-02-01', 'gambar_667ae155499ec.jpg', NULL),
(1009, 'Pembiayaan Proyek Strategis 2022', '', '6500000', '6000000', '500000', '2022-03-01', 'gambar_667c5d1315bc2.jpg', NULL),
(1010, 'Penggajian Karyawan 2022', 'REF1010', '7500000', '7300000', '200000', '2022-01-01', 'gambar_667ae155499ec.jpg', NULL),
(1013, 'Pendapatan Tahun Baru 2022', 'REF1013', '13500000', '12500000', '1000000', '2022-04-01', 'gambar_667ae155499ec.jpg', NULL),
(1014, 'Pendapatan Bonus Karyawan 2022', 'REF1014', '12500000', '11500000', '1000000', '2022-05-01', 'gambar_667ae155499ec.jpg', NULL),
(1015, 'Pendapatan Akhir Tahun 2022', 'REF1015', '14000000', '13000000', '1000000', '2022-06-01', 'gambar_667ae155499ec.jpg', NULL),
(1101, 'Pendapatan Awal Tahun 2023', 'REF1101', '12000000', '11000000', '1000000', '2023-01-01', 'gambar_667ae155499ec.jpg', NULL),
(1102, 'Pendapatan Tahun Baru 2023', 'REF1102', '14000000', '13000000', '1000000', '2023-02-01', 'gambar_667ae155499ec.jpg', NULL),
(1103, 'Pendapatan Bonus Karyawan 2023', 'REF1103', '13000000', '12000000', '1000000', '2023-03-01', 'gambar_667ae155499ec.jpg', NULL),
(1104, 'Belanja Pengadaan Kantor 2023', 'REF1104', '9000000', '8500000', '500000', '2023-01-01', 'gambar_667ae155499ec.jpg', NULL),
(1105, 'Belanja Peralatan Baru 2023', 'REF1105', '10000000', '9500000', '500000', '2023-02-01', 'gambar_667ae155499ec.jpg', NULL),
(1106, 'Belanja Maintenance 2023', 'REF1106', '10500000', '10000000', '500000', '2023-03-01', 'gambar_667ae155499ec.jpg', NULL),
(1107, 'Pembiayaan Pembaruan Sistem 2023', 'REF1107', '6000000', '5800000', '200000', '2023-01-01', 'gambar_667ae155499ec.jpg', NULL),
(1108, 'Pembiayaan Investasi 2023', 'REF1108', '6500000', '6000000', '500000', '2023-02-01', 'gambar_667ae155499ec.jpg', NULL),
(1109, 'Pembiayaan Proyek Strategis 2023', 'REF1109', '7000000', '6500000', '500000', '2023-03-01', 'gambar_667ae155499ec.jpg', NULL),
(1110, 'Penggajian Karyawan 2023', 'REF1110', '8000000', '7800000', '200000', '2023-01-01', 'gambar_667ae155499ec.jpg', NULL),
(1111, 'Penggajian Karyawan 2023', 'REF1111', '8200000', '8000000', '200000', '2023-02-01', 'gambar_667ae155499ec.jpg', NULL),
(1112, 'Penggajian Karyawan 2023', 'REF1112', '8500000', '8300000', '200000', '2023-03-01', 'gambar_667ae155499ec.jpg', NULL),
(1113, 'Pendapatan Tahun Baru 2023', 'REF1113', '14500000', '13500000', '1000000', '2023-04-01', 'gambar_667ae155499ec.jpg', NULL),
(1114, 'Pendapatan Bonus Karyawan 2023', 'REF1114', '13500000', '12500000', '1000000', '2023-05-01', 'gambar_667ae155499ec.jpg', NULL),
(1115, 'Pendapatan Akhir Tahun 2023', 'REF1115', '15000000', '14000000', '1000000', '2023-06-01', 'gambar_667ae155499ec.jpg', NULL),
(1201, 'Pendapatan Awal Tahun 2024', 'REF1201', '13000000', '12000000', '1000000', '2024-01-01', 'gambar_667ae155499ec.jpg', NULL),
(1202, 'Pendapatan Tahun Baru 2024', 'REF1202', '15000000', '14000000', '1000000', '2024-02-01', 'gambar_667ae155499ec.jpg', NULL),
(1203, 'Pendapatan Bonus Karyawan 2024', 'REF1203', '14000000', '13000000', '1000000', '2024-03-01', 'gambar_667ae155499ec.jpg', NULL),
(1204, 'Belanja Pengadaan Kantor 2024', 'REF1204', '9500000', '9000000', '500000', '2024-01-01', 'gambar_667ae155499ec.jpg', NULL),
(1206, 'Belanja Maintenance 2024', 'REF1206', '11000000', '10500000', '500000', '2024-03-01', 'gambar_667ae155499ec.jpg', NULL),
(1207, 'Pembiayaan Pembaruan Sistem 2024', 'REF1207', '6500000', '6300000', '200000', '2024-01-01', 'gambar_667ae155499ec.jpg', NULL),
(1210, 'Penggajian Karyawan 2024', 'REF1210', '8500000', '8300000', '200000', '2024-01-01', 'gambar_667ae155499ec.jpg', NULL),
(1211, 'Penggajian Karyawan 2024', 'REF1211', '8700000', '8500000', '200000', '2024-02-01', 'gambar_667ae155499ec.jpg', NULL),
(1212, 'Penggajian Karyawan 2024', 'REF1212', '9000000', '8800000', '200000', '2024-03-01', 'gambar_667ae155499ec.jpg', NULL),
(1214, 'Pendapatan Bonus Karyawan 2024', 'REF1214', '14500000', '13500000', '1000000', '2024-05-01', 'gambar_667ae155499ec.jpg', NULL),
(1215, 'Pendapatan Akhir Tahun 2024', 'REF1215', '16000000', '15000000', '1000000', '2024-06-01', 'gambar_667ae155499ec.jpg', NULL),
(1216, 'a', 'tef', '100000', '1000000', '900000', '2000-06-27', 'gambar_667c5f792ad53.jpg', NULL),
(1217, 'cek cek ', '', '1000000', '2000000', '1000000', '1999-12-12', 'gambar_667c5f067c23a.jpg', NULL),
(1218, 'Pembelian Takjil', 'Takjil', '100000', '100000', '0', '2024-06-27', 'gambar_667c600760861.png', NULL),
(1220, 'lorem', 'xxx', '100000', '10000', '90000', '2024-06-27', 'gambar_667d547b01d90.jpg', NULL),
(1221, 'xxxx', 'xxx', '212121', '121212', '90909', '2024-06-27', 'gambar_667d564d5de53.jpg', '   dfsfds  '),
(1222, 'aaa', 'aaaa', '1111111', '111111', '1000000', '2024-06-30', 'gambar_6681694744e7d.jpg', ' sdffsddfs');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_penggajian`
--

CREATE TABLE `laporan_penggajian` (
  `id` int NOT NULL,
  `periode` enum('bulanan','triwulanan','tahunan') NOT NULL,
  `tanggal_dibuat` date NOT NULL,
  `total_gaji` decimal(15,0) NOT NULL,
  `total_tunjangan` decimal(15,0) DEFAULT NULL,
  `total_potongan` decimal(15,0) DEFAULT NULL,
  `total_bonus` decimal(15,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `nomor_identifikasi` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `alamat` text,
  `periode_pembayaran` enum('bulanan','triwulanan','tahunan') DEFAULT NULL,
  `foto_pegawai` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nama`, `jabatan`, `nomor_identifikasi`, `email`, `nomor_telepon`, `alamat`, `periode_pembayaran`, `foto_pegawai`) VALUES
(36, 'Annisa Septiani Kamal', 'Staf', '1629042028', 'zlhm378@gmail.com', '0895801138822', 'BTN NUKI DWI KARYA PERMAI A5/23, RT 002, RW 003', 'bulanan', '6683df77369e6.png'),
(37, 'AstriAyuningsih', 'Sekretaris Umum', '1729042028', 'astriayuningsih@gmail.com', '1729042028', 'BTN NUKI DWI KARYA PERMAI A5/23, RT 002, RW 003', 'bulanan', '6683e04d8ab04.jpg'),
(38, 'Muflih AlGhifari Salam', 'Staf', '1929042005', 'MuflihAlGhifariSalam@gmail.com', '1929042005', 'Jeneponto', 'bulanan', '6683df8464c75.jpg'),
(39, 'Zulham Abidin', 'Staf', '1929042001', 'loremipsumdolorsimet@gmail.com', '089580113882', 'BTN NUKI DWI KARYA PERMAI A5/23, RT 002, RW 003', 'tahunan', '6683d65b75f18.jpg'),
(40, 'Andri Apriadi', 'Staf', '1929042011', 'AndriApriadi@gmail.com', '1929042011', 'BTN NUKI DWI KARYA PERMAI A5/23, RT 002, RW 003', 'triwulanan', '6683df91f0811.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `slip_gaji`
--

CREATE TABLE `slip_gaji` (
  `id` int NOT NULL,
  `pegawai_id` int NOT NULL,
  `gaji_pegawai_id` int NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `tanggal_dibuat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_admin` int NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_admin`, `nama`, `username`, `password`) VALUES
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_document_slip_gaji` (`slip_gaji_id`);

--
-- Indexes for table `export_laporan_penggajian`
--
ALTER TABLE `export_laporan_penggajian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawai_id` (`pegawai_id`);

--
-- Indexes for table `gaji_otomatis`
--
ALTER TABLE `gaji_otomatis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawai_id` (`pegawai_id`);

--
-- Indexes for table `gaji_pegawai`
--
ALTER TABLE `gaji_pegawai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawai_id` (`pegawai_id`);

--
-- Indexes for table `histori_gaji`
--
ALTER TABLE `histori_gaji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawai_id` (`pegawai_id`),
  ADD KEY `gaji_pegawai_id` (`gaji_pegawai_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_kategori`
--
ALTER TABLE `laporan_kategori`
  ADD KEY `laporan_id` (`laporan_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_penggajian`
--
ALTER TABLE `laporan_penggajian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_identifikasi` (`nomor_identifikasi`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `slip_gaji`
--
ALTER TABLE `slip_gaji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawai_id` (`pegawai_id`),
  ADD KEY `gaji_pegawai_id` (`gaji_pegawai_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `export_laporan_penggajian`
--
ALTER TABLE `export_laporan_penggajian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=601;

--
-- AUTO_INCREMENT for table `gaji_otomatis`
--
ALTER TABLE `gaji_otomatis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `gaji_pegawai`
--
ALTER TABLE `gaji_pegawai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `histori_gaji`
--
ALTER TABLE `histori_gaji`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1223;

--
-- AUTO_INCREMENT for table `laporan_penggajian`
--
ALTER TABLE `laporan_penggajian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `slip_gaji`
--
ALTER TABLE `slip_gaji`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `fk_document_slip_gaji` FOREIGN KEY (`slip_gaji_id`) REFERENCES `slip_gaji` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `export_laporan_penggajian`
--
ALTER TABLE `export_laporan_penggajian`
  ADD CONSTRAINT `export_laporan_penggajian_ibfk_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`);

--
-- Constraints for table `gaji_otomatis`
--
ALTER TABLE `gaji_otomatis`
  ADD CONSTRAINT `gaji_otomatis_ibfk_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`);

--
-- Constraints for table `gaji_pegawai`
--
ALTER TABLE `gaji_pegawai`
  ADD CONSTRAINT `gaji_pegawai_ibfk_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`);

--
-- Constraints for table `histori_gaji`
--
ALTER TABLE `histori_gaji`
  ADD CONSTRAINT `histori_gaji_ibfk_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`),
  ADD CONSTRAINT `histori_gaji_ibfk_2` FOREIGN KEY (`gaji_pegawai_id`) REFERENCES `gaji_pegawai` (`id`);

--
-- Constraints for table `laporan_kategori`
--
ALTER TABLE `laporan_kategori`
  ADD CONSTRAINT `laporan_kategori_ibfk_1` FOREIGN KEY (`laporan_id`) REFERENCES `laporan_keuangan` (`id`),
  ADD CONSTRAINT `laporan_kategori_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

--
-- Constraints for table `slip_gaji`
--
ALTER TABLE `slip_gaji`
  ADD CONSTRAINT `slip_gaji_ibfk_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`),
  ADD CONSTRAINT `slip_gaji_ibfk_2` FOREIGN KEY (`gaji_pegawai_id`) REFERENCES `gaji_pegawai` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
