-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 26, 2024 at 08:48 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.16

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
(2, 1),
(3, 1),
(1001, 1),
(1004, 2),
(1005, 2),
(1006, 2),
(1007, 3),
(1008, 3),
(1009, 3),
(1010, 4),
(1011, 4),
(1012, 4),
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
(1218, 2);

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
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laporan_keuangan`
--

INSERT INTO `laporan_keuangan` (`id`, `uraian`, `ref`, `anggaran`, `realisasi`, `selisih`, `periode`, `gambar`) VALUES
(1, 'Pendapatan Januari', 'asdasdas', '100000000', '110000000', '10000000', '2021-01-01', ''),
(2, 'Pendapatan Februari', 'REF002', '12000000', '11000000', '1000000', '2023-02-01', 'gambar_667ae155499ec.jpg'),
(3, 'Pendapatan Maret', 'REF003', '11000000', '10000000', '1000000', '2023-03-01', 'gambar_667ae155499ec.jpg'),
(1001, 'Pendapatan Awal Tahun 2022', 'REF1001', '11000000', '10000000', '1000000', '2022-01-01', 'gambar_667ae155499ec.jpg'),
(1004, 'Belanja Pengadaan Kantor 2022', 'REF1004', '8500000', '8000000', '500000', '2022-01-01', 'gambar_667ae155499ec.jpg'),
(1005, 'Belanja Peralatan Baru 2022', 'REF1005', '9500000', '9000000', '500000', '2022-02-01', 'gambar_667ae155499ec.jpg'),
(1006, 'Belanja Maintenance 2022', 'REF1006', '10000000', '9500000', '500000', '2022-03-01', 'gambar_667ae155499ec.jpg'),
(1007, 'Pembiayaan Pembaruan Sistem 2022', 'REF1007', '5500000', '5300000', '200000', '2022-01-01', 'gambar_667ae155499ec.jpg'),
(1008, 'Pembiayaan Investasi 2022', 'REF1008', '6000000', '5500000', '500000', '2022-02-01', 'gambar_667ae155499ec.jpg'),
(1009, 'Pembiayaan Proyek Strategis 2022', '', '6500000', '6000000', '500000', '2022-03-01', 'gambar_667c5d1315bc2.jpg'),
(1010, 'Penggajian Karyawan 2022', 'REF1010', '7500000', '7300000', '200000', '2022-01-01', 'gambar_667ae155499ec.jpg'),
(1011, 'Penggajian Karyawan 2022', 'REF1011', '7700000', '7500000', '200000', '2022-02-01', 'gambar_667ae155499ec.jpg'),
(1012, 'Penggajian Karyawan 2022', 'REF1012', '8000000', '7800000', '200000', '2022-03-01', 'gambar_667ae155499ec.jpg'),
(1013, 'Pendapatan Tahun Baru 2022', 'REF1013', '13500000', '12500000', '1000000', '2022-04-01', 'gambar_667ae155499ec.jpg'),
(1014, 'Pendapatan Bonus Karyawan 2022', 'REF1014', '12500000', '11500000', '1000000', '2022-05-01', 'gambar_667ae155499ec.jpg'),
(1015, 'Pendapatan Akhir Tahun 2022', 'REF1015', '14000000', '13000000', '1000000', '2022-06-01', 'gambar_667ae155499ec.jpg'),
(1101, 'Pendapatan Awal Tahun 2023', 'REF1101', '12000000', '11000000', '1000000', '2023-01-01', 'gambar_667ae155499ec.jpg'),
(1102, 'Pendapatan Tahun Baru 2023', 'REF1102', '14000000', '13000000', '1000000', '2023-02-01', 'gambar_667ae155499ec.jpg'),
(1103, 'Pendapatan Bonus Karyawan 2023', 'REF1103', '13000000', '12000000', '1000000', '2023-03-01', 'gambar_667ae155499ec.jpg'),
(1104, 'Belanja Pengadaan Kantor 2023', 'REF1104', '9000000', '8500000', '500000', '2023-01-01', 'gambar_667ae155499ec.jpg'),
(1105, 'Belanja Peralatan Baru 2023', 'REF1105', '10000000', '9500000', '500000', '2023-02-01', 'gambar_667ae155499ec.jpg'),
(1106, 'Belanja Maintenance 2023', 'REF1106', '10500000', '10000000', '500000', '2023-03-01', 'gambar_667ae155499ec.jpg'),
(1107, 'Pembiayaan Pembaruan Sistem 2023', 'REF1107', '6000000', '5800000', '200000', '2023-01-01', 'gambar_667ae155499ec.jpg'),
(1108, 'Pembiayaan Investasi 2023', 'REF1108', '6500000', '6000000', '500000', '2023-02-01', 'gambar_667ae155499ec.jpg'),
(1109, 'Pembiayaan Proyek Strategis 2023', 'REF1109', '7000000', '6500000', '500000', '2023-03-01', 'gambar_667ae155499ec.jpg'),
(1110, 'Penggajian Karyawan 2023', 'REF1110', '8000000', '7800000', '200000', '2023-01-01', 'gambar_667ae155499ec.jpg'),
(1111, 'Penggajian Karyawan 2023', 'REF1111', '8200000', '8000000', '200000', '2023-02-01', 'gambar_667ae155499ec.jpg'),
(1112, 'Penggajian Karyawan 2023', 'REF1112', '8500000', '8300000', '200000', '2023-03-01', 'gambar_667ae155499ec.jpg'),
(1113, 'Pendapatan Tahun Baru 2023', 'REF1113', '14500000', '13500000', '1000000', '2023-04-01', 'gambar_667ae155499ec.jpg'),
(1114, 'Pendapatan Bonus Karyawan 2023', 'REF1114', '13500000', '12500000', '1000000', '2023-05-01', 'gambar_667ae155499ec.jpg'),
(1115, 'Pendapatan Akhir Tahun 2023', 'REF1115', '15000000', '14000000', '1000000', '2023-06-01', 'gambar_667ae155499ec.jpg'),
(1201, 'Pendapatan Awal Tahun 2024', 'REF1201', '13000000', '12000000', '1000000', '2024-01-01', 'gambar_667ae155499ec.jpg'),
(1202, 'Pendapatan Tahun Baru 2024', 'REF1202', '15000000', '14000000', '1000000', '2024-02-01', 'gambar_667ae155499ec.jpg'),
(1203, 'Pendapatan Bonus Karyawan 2024', 'REF1203', '14000000', '13000000', '1000000', '2024-03-01', 'gambar_667ae155499ec.jpg'),
(1204, 'Belanja Pengadaan Kantor 2024', 'REF1204', '9500000', '9000000', '500000', '2024-01-01', 'gambar_667ae155499ec.jpg'),
(1206, 'Belanja Maintenance 2024', 'REF1206', '11000000', '10500000', '500000', '2024-03-01', 'gambar_667ae155499ec.jpg'),
(1207, 'Pembiayaan Pembaruan Sistem 2024', 'REF1207', '6500000', '6300000', '200000', '2024-01-01', 'gambar_667ae155499ec.jpg'),
(1210, 'Penggajian Karyawan 2024', 'REF1210', '8500000', '8300000', '200000', '2024-01-01', 'gambar_667ae155499ec.jpg'),
(1211, 'Penggajian Karyawan 2024', 'REF1211', '8700000', '8500000', '200000', '2024-02-01', 'gambar_667ae155499ec.jpg'),
(1212, 'Penggajian Karyawan 2024', 'REF1212', '9000000', '8800000', '200000', '2024-03-01', 'gambar_667ae155499ec.jpg'),
(1214, 'Pendapatan Bonus Karyawan 2024', 'REF1214', '14500000', '13500000', '1000000', '2024-05-01', 'gambar_667ae155499ec.jpg'),
(1215, 'Pendapatan Akhir Tahun 2024', 'REF1215', '16000000', '15000000', '1000000', '2024-06-01', 'gambar_667ae155499ec.jpg'),
(1216, 'a', 'tef', '100000', '1000000', '900000', '2000-06-27', 'gambar_667c5f792ad53.jpg'),
(1217, 'cek cek ', '', '1000000', '2000000', '1000000', '1999-12-12', 'gambar_667c5f067c23a.jpg'),
(1218, 'Pembelian Takjil', 'Takjil', '100000', '100000', '0', '2024-06-27', 'gambar_667c600760861.png');

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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1220;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laporan_kategori`
--
ALTER TABLE `laporan_kategori`
  ADD CONSTRAINT `laporan_kategori_ibfk_1` FOREIGN KEY (`laporan_id`) REFERENCES `laporan_keuangan` (`id`),
  ADD CONSTRAINT `laporan_kategori_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
