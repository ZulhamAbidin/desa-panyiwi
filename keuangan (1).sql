CREATE TABLE `gaji_otomatis` (
  `id` int NOT NULL,
  `pegawai_id` int DEFAULT NULL,
  `gaji_pokok` decimal(15,0) DEFAULT NULL,
  `tunjangan` decimal(15,0) DEFAULT NULL,
  `bonus` decimal(15,0) DEFAULT NULL,
  `potongan` decimal(15,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `gaji_otomatis` (`id`, `pegawai_id`, `gaji_pokok`, `tunjangan`, `bonus`, `potongan`) VALUES
(67, 36, '1000000', '1000000', '1000000', '2000000'),
(68, 37, '1000000', '1000000', '1000000', '2000000'),
(69, 38, '1000000', '1000000', '1000000', '2000000'),
(70, 39, '1000000', '1000000', '1000000', '2000000'),
(71, 40, '1000000', '1000000', '1000000', '2000000');


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


INSERT INTO `gaji_pegawai` (`id`, `pegawai_id`, `periode`, `gaji_pokok`, `tunjangan`, `potongan`, `bonus`, `total_gaji`, `tanggal_pembayaran`, `metode_pembayaran`) VALUES
(178, 36, '2024-07-04', '1000000', '1000000', '2000000', '1000000', '1000000', '2024-07-04', 'Transfer Bank'),
(179, 37, '2024-07-04', '1000000', '1000000', '2000000', '1000000', '1000000', '2024-07-04', 'Transfer Bank'),
(180, 38, '2024-07-04', '1000000', '1000000', '2000000', '1000000', '1000000', '2024-07-04', 'Transfer Bank'),
(181, 39, '2024-07-04', '1000000', '1000000', '2000000', '1000000', '1000000', '2024-07-04', 'Transfer Bank'),
(183, 40, '2024-07-04', '1000000', '1000000', '2000000', '1000000', '1000000', '2024-07-04', 'Transfer Bank');



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


INSERT INTO `pegawai` (`id`, `nama`, `jabatan`, `nomor_identifikasi`, `email`, `nomor_telepon`, `alamat`, `periode_pembayaran`, `foto_pegawai`) VALUES
(36, 'Annisa Septiani Kamal', 'Staf', '1629042028', 'zlhm378@gmail.com', '0895801138822', 'BTN NUKI DWI KARYA PERMAI A5/23, RT 002, RW 003', 'tahunan', '6683df77369e6.png'),
(37, 'AstriAyuningsih', 'Sekretaris Umum', '1729042028', 'astriayuningsih@gmail.com', '1729042028', 'BTN NUKI DWI KARYA PERMAI A5/23, RT 002, RW 003', 'bulanan', '6683e04d8ab04.jpg'),
(38, 'Muflih AlGhifari Salam', 'Staf', '1929042005', 'MuflihAlGhifariSalam@gmail.com', '1929042005', 'Jeneponto', 'bulanan', '6683df8464c75.jpg'),
(39, 'Zulham Abidin', 'Staf', '1929042001', 'loremipsumdolorsimet@gmail.com', '089580113882', 'BTN NUKI DWI KARYA PERMAI A5/23, RT 002, RW 003', 'bulanan', '6683d65b75f18.jpg'),
(40, 'Andri Apriadi', 'Staf', '1929042011', 'AndriApriadi@gmail.com', '1929042011', 'BTN NUKI DWI KARYA PERMAI A5/23, RT 002, RW 003', 'triwulanan', '6683df91f0811.jpg');
