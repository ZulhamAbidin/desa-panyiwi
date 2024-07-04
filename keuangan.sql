

CREATE TABLE `document` (
  `id` int NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `slip_gaji_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


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



Tanggal Mulai:

04/07/2024
Tanggal Akhir:

04/07/2026
Annisa Septiani Kamal: Rp 69.000.000
AstriAyuningsih: Rp 72.000.000
Muflih AlGhifari Salam: Rp 72.000.000
Zulham Abidin: Rp 0
Andri Apriadi: Rp 21.000.000
Zulham Abidin, S.Pd., Gr.: Rp 0

Total Gaji Keseluruhan: Rp 234.000.000

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


CREATE TABLE `histori_gaji` (
  `id` int NOT NULL,
  `pegawai_id` int NOT NULL,
  `gaji_pegawai_id` int NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `nama_kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `laporan_kategori` (
  `laporan_id` int DEFAULT NULL,
  `kategori_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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


CREATE TABLE `laporan_penggajian` (
  `id` int NOT NULL,
  `periode` enum('bulanan','triwulanan','tahunan') NOT NULL,
  `tanggal_dibuat` date NOT NULL,
  `total_gaji` decimal(15,0) NOT NULL,
  `total_tunjangan` decimal(15,0) DEFAULT NULL,
  `total_potongan` decimal(15,0) DEFAULT NULL,
  `total_bonus` decimal(15,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


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


CREATE TABLE `user` (
  `id_admin` int NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
