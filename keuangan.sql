-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 05, 2024 at 01:02 PM
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

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`id`, `file_path`, `created_at`, `slip_gaji_id`) VALUES
(26, 'slip_gaji_Amiruddin_Jamaluddin_S.H._20240705112321.pdf', '2024-07-05 11:23:21', 144);

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
(73, 48, '2800000', '1000000', '200000', '10000'),
(74, 50, '2800000', '1000000', '200000', '10000'),
(75, 51, '2800000', '1000000', '200000', '10000'),
(76, 52, '2900000', '1000000', '200000', '10000'),
(77, 53, '2900000', '1000000', '200000', '10000'),
(78, 55, '2900000', '1000000', '200000', '10000'),
(79, 49, '4000000', '1000000', '1000000', '100000'),
(80, 54, '4000000', '1000000', '1000000', '100000'),
(81, 56, '4000000', '1000000', '1000000', '100000'),
(82, 47, '5000000', '3000000', '1000000', '0');

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
(217, 47, '2024-07-05', '5000000', '3000000', '0', '1000000', '9000000', '2024-07-05', 'Transfer Bank'),
(218, 48, '2024-07-05', '2800000', '1000000', '10000', '200000', '3990000', '2024-07-05', 'Transfer Bank'),
(219, 49, '2024-07-05', '4000000', '1000000', '100000', '1000000', '5900000', '2024-07-05', 'Transfer Bank'),
(220, 50, '2024-07-05', '2800000', '1000000', '10000', '200000', '3990000', '2024-07-05', 'Transfer Bank'),
(221, 51, '2024-07-05', '2800000', '1000000', '10000', '200000', '3990000', '2024-07-05', 'Transfer Bank'),
(222, 52, '2024-07-05', '2900000', '1000000', '10000', '200000', '4090000', '2024-07-05', 'Transfer Bank'),
(223, 53, '2024-07-05', '2900000', '1000000', '10000', '200000', '4090000', '2024-07-05', 'Transfer Bank'),
(224, 54, '2024-07-05', '4000000', '1000000', '100000', '1000000', '5900000', '2024-07-05', 'Transfer Bank'),
(225, 55, '2024-07-05', '2900000', '1000000', '10000', '200000', '4090000', '2024-07-05', 'Transfer Bank'),
(226, 56, '2024-07-05', '4000000', '1000000', '100000', '1000000', '5900000', '2024-07-05', 'Transfer Bank'),
(227, 47, '2024-08-05', '5000000', '3000000', '0', '1000000', '9000000', '2024-07-05', 'Gopay'),
(228, 48, '2024-08-05', '2800000', '1000000', '10000', '200000', '3990000', '2024-07-05', 'Gopay'),
(229, 50, '2024-08-05', '2800000', '1000000', '10000', '200000', '3990000', '2024-07-05', 'Gopay'),
(230, 51, '2024-08-05', '2800000', '1000000', '10000', '200000', '3990000', '2024-07-05', 'Gopay'),
(231, 52, '2024-08-05', '2900000', '1000000', '10000', '200000', '4090000', '2024-07-05', 'Gopay'),
(232, 53, '2024-08-05', '2900000', '1000000', '10000', '200000', '4090000', '2024-07-05', 'Gopay'),
(233, 55, '2024-08-05', '2900000', '1000000', '10000', '200000', '4090000', '2024-07-05', 'Gopay'),
(234, 49, '2024-08-05', '4000000', '1000000', '100000', '1000000', '5900000', '2024-07-05', 'Gopay'),
(235, 54, '2024-08-05', '4000000', '1000000', '100000', '1000000', '5900000', '2024-07-05', 'Gopay'),
(236, 56, '2024-08-05', '4000000', '1000000', '100000', '1000000', '5900000', '2024-07-05', 'Gopay'),
(237, 47, '2024-09-05', '5000000', '3000000', '0', '1000000', '9000000', '2024-08-05', 'Gopay'),
(238, 48, '2024-09-05', '2800000', '1000000', '10000', '200000', '3990000', '2024-08-05', 'Gopay');

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
(74, 47, 217, '2024-07-05', 'Gaji untuk periode 2024-07-05'),
(75, 48, 218, '2024-07-05', 'Gaji untuk periode 2024-07-05'),
(76, 49, 219, '2024-07-05', 'Gaji untuk periode 2024-07-05'),
(77, 50, 220, '2024-07-05', 'Gaji untuk periode 2024-07-05'),
(78, 51, 221, '2024-07-05', 'Gaji untuk periode 2024-07-05'),
(79, 52, 222, '2024-07-05', 'Gaji untuk periode 2024-07-05'),
(80, 53, 223, '2024-07-05', 'Gaji untuk periode 2024-07-05'),
(81, 54, 224, '2024-07-05', 'Gaji untuk periode 2024-07-05'),
(82, 55, 225, '2024-07-05', 'Gaji untuk periode 2024-07-05'),
(83, 56, 226, '2024-07-05', 'Gaji untuk periode 2024-07-05');

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
(1113, 1),
(1114, 1),
(1115, 1),
(1201, 1),
(1202, 1),
(1203, 1),
(1204, 2),
(1206, 2),
(1207, 3),
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
(1113, 'Pendapatan Tahun Baru 2023', 'REF1113', '14500000', '13500000', '1000000', '2023-04-01', 'gambar_667ae155499ec.jpg', NULL),
(1114, 'Pendapatan Bonus Karyawan 2023', 'REF1114', '13500000', '12500000', '1000000', '2023-05-01', 'gambar_667ae155499ec.jpg', NULL),
(1115, 'Pendapatan Akhir Tahun 2023', 'REF1115', '15000000', '14000000', '1000000', '2023-06-01', 'gambar_667ae155499ec.jpg', NULL),
(1201, 'Pendapatan Awal Tahun 2024', 'REF1201', '13000000', '12000000', '1000000', '2024-01-01', 'gambar_667ae155499ec.jpg', NULL),
(1202, 'Pendapatan Tahun Baru 2024', 'REF1202', '15000000', '14000000', '1000000', '2024-02-01', 'gambar_667ae155499ec.jpg', NULL),
(1203, 'Pendapatan Bonus Karyawan 2024', 'REF1203', '14000000', '13000000', '1000000', '2024-03-01', 'gambar_667ae155499ec.jpg', NULL),
(1204, 'Belanja Pengadaan Kantor 2024', 'REF1204', '9500000', '9000000', '500000', '2024-01-01', 'gambar_667ae155499ec.jpg', NULL),
(1206, 'Belanja Maintenance 2024', 'REF1206', '11000000', '10500000', '500000', '2024-03-01', 'gambar_667ae155499ec.jpg', NULL),
(1207, 'Pembiayaan Pembaruan Sistem 2024', 'REF1207', '6500000', '6300000', '200000', '2024-01-01', 'gambar_667ae155499ec.jpg', NULL),
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
  `foto_pegawai` varchar(255) DEFAULT NULL,
  `pendidikan_terakhir` enum('TK','SD','SMP','SMA','Diploma 3','Diploma 4','Strata 1','Strata 2','Strata 3') DEFAULT NULL,
  `status_pernikahan` enum('Belum Menikah','Menikah','Cerai') DEFAULT NULL,
  `agama` enum('Islam','Kristen','Katolik','Hindu','Buddha','Khonghucu') DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nama`, `jabatan`, `nomor_identifikasi`, `email`, `nomor_telepon`, `alamat`, `periode_pembayaran`, `foto_pegawai`, `pendidikan_terakhir`, `status_pernikahan`, `agama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`) VALUES
(47, 'Amiruddin Jamaluddin S.H.', 'Lurah', '1209876543', 'loremipsumdolorsimet@gmail.com', '081126477590', 'Jl. Pahlawan No. 10, Kelurahan Watampone, Kecamatan Tanete Riattang, Kabupaten Bone', 'bulanan', '6687d47cbde97.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'Jafar Mansur S.T.', 'Sekretaris Kelurahan', '2309876541', 'jafar.mansur@gmail.com', '089432774881', 'Jl. Mawar No. 5, Kelurahan Cina, Kecamatan Tanete Riattang Barat, Kabupaten Bone', 'bulanan', '6687d4b683437.png', NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'Salim Akbar S.Pd.', 'Kasi Pemerintaha', '3409876542', 'salim.akbar@gmail.com', '083456789012', 'Jl. Flamboyan No. 3, Kelurahan Lamuru, Kecamatan Tanete Riattang Timur, Kabupaten Bone', 'bulanan', '6687d4eced232.png', NULL, NULL, NULL, NULL, NULL, NULL),
(50, 'Baso Abdul Rahman M.T.', 'Kasi Keuangan', '4509876543', 'baso.abdulrahman@gmail.com', '084567890123', 'Jl. Teratai No. 8, Kelurahan Tondok Bacang, Kecamatan Tanete Riattang Barat, Kabupaten Bone', 'bulanan', '6687d5194df6e.png', NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'Andi Haji S.Kom.', 'Kasi Umum', '5609876544', 'andi.haji@gmail.com', '089415701234', 'Jl. Kenari No. 15, Kelurahan Mallusetasi, Kecamatan Tanete Riattang Timur, Kabupaten Bone', 'bulanan', '6687d54dbd651.png', NULL, NULL, NULL, NULL, NULL, NULL),
(52, 'Ratna Andi S.Sos.', 'Staf Administrasi', '6709876545', 'ratna.andi@gmail.com', '086789012345', ' Jl. Kamboja No. 12, Kelurahan Lappariaja, Kecamatan Tanete Riattang Timur, Kabupaten Bone', 'bulanan', '6687d577ad87c.png', NULL, NULL, NULL, NULL, NULL, NULL),
(53, 'Nani Fatimah S.E.', 'Staf Administrasi', '7809876546', 'nani.fatimah@gmail.com', '087890123456', 'Jl. Mawar No. 7, Kelurahan Tanete Kecil, Kecamatan Tanete Riattang Barat, Kabupaten Bone', 'bulanan', '6687d59b84c10.png', NULL, NULL, NULL, NULL, NULL, NULL),
(54, ' Henny Kartini S.Psi.', 'Staf Keuangan', '8900876547', 'henny.kartini@gmail.com', '088901234567', 'Jl. Melati No. 20, Kelurahan Monro-Monro, Kecamatan Tanete Riattang, Kabupaten Bone', 'bulanan', '6687d5c066366.png', NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'Maya Indah S.T.', 'Staf Tatausaha', '9019876548', 'maya.indah@gmail.com', '089022464836', 'Jl. Bunga No. 3, Kelurahan Labuang, Kecamatan Tanete Riattang Timur, Kabupaten Bone', 'bulanan', '6687d5f771b4c.png', NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'Rina Siti S.T.', 'Staf Keuangan', '9019876542', 'rina.siti@gmail.com', '089327423199', 'Jl. Anggrek No. 9, Kelurahan Panaikang, Kecamatan Tanete Riattang, Kabupaten Bone', 'bulanan', '6687d63a38ec9.png', NULL, NULL, NULL, NULL, NULL, NULL);

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

--
-- Dumping data for table `slip_gaji`
--

INSERT INTO `slip_gaji` (`id`, `pegawai_id`, `gaji_pegawai_id`, `file_path`, `tanggal_dibuat`) VALUES
(124, 47, 217, '6687d6b3c0633.png', '2024-07-05'),
(125, 48, 218, '6687d6bdae9de.png', '2024-07-05'),
(126, 49, 219, '6687d6c963a8f.png', '2024-07-05'),
(127, 50, 220, '6687d6d7765ff.png', '2024-07-05'),
(128, 51, 221, '6687d6e1dd986.png', '2024-07-05'),
(129, 52, 222, '6687d6ec211a9.jpg', '2024-07-05'),
(130, 53, 223, '6687d6fa0367f.png', '2024-07-05'),
(131, 54, 224, '6687d70605dea.png', '2024-07-05'),
(132, 55, 225, '6687d70e73145.png', '2024-07-05'),
(133, 56, 226, '6687d7165d228.png', '2024-07-05'),
(134, 47, 227, '6687d72b33d07.png', '2024-07-05'),
(135, 48, 228, '6687d7381a77b.png', '2024-07-05'),
(136, 50, 229, '6687d73df1c07.png', '2024-07-05'),
(137, 51, 230, '6687d743d147f.png', '2024-07-05'),
(138, 52, 231, '6687d74d47228.png', '2024-07-05'),
(139, 53, 232, '6687d756bac51.png', '2024-07-05'),
(140, 55, 233, '6687d75cae99a.png', '2024-07-05'),
(141, 49, 234, '6687d7617d262.png', '2024-07-05'),
(142, 54, 235, '6687d766c7b29.png', '2024-07-05'),
(143, 56, 236, '6687d76cda5b9.png', '2024-07-05'),
(144, 47, 237, '6687d7717df16.png', '2024-07-05'),
(145, 48, 238, '6687d89b03ae6.png', '2024-07-05');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `export_laporan_penggajian`
--
ALTER TABLE `export_laporan_penggajian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=601;

--
-- AUTO_INCREMENT for table `gaji_otomatis`
--
ALTER TABLE `gaji_otomatis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `gaji_pegawai`
--
ALTER TABLE `gaji_pegawai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `histori_gaji`
--
ALTER TABLE `histori_gaji`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `slip_gaji`
--
ALTER TABLE `slip_gaji`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

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
