-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Bulan Mei 2024 pada 10.55
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ccs`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`id`, `nama_kategori`) VALUES
(15, 'Pembatalan - Pembatalan Transaksi(Current Date, Backdate, Adendum Kredit dan Ecollector)'),
(16, 'Ecollector - Ecollector Kas Mobile'),
(17, 'Backdate - Backdate Transaksi'),
(18, 'Proses - Proses Ulang'),
(20, 'Transaksi - Koreksi Transaksi'),
(21, 'Kredit - Master Rekening Kredit'),
(22, 'Kredit - Data Kredit'),
(23, 'Kredit - Transaksi Kredit'),
(24, 'Kredit - Bunga Kredit'),
(25, 'Kredit - Agunan'),
(26, 'Kredit - Sistem Angsuran'),
(27, 'Kredit - Kolektibilitas'),
(28, 'Kredit - Jadwal Angsuran'),
(29, 'Kredit - Koreksi PYAD Kredit'),
(30, 'Kredit - PPAP Kredit'),
(31, 'Kredit - Koreksi PYD Kredit'),
(32, 'Kredit - Aktivasi Rekening Kredit'),
(33, 'Kredit - Tarik Nominatif'),
(34, 'API - TTF'),
(36, 'C6'),
(37, 'Kredit - Tarik Nominatif Kredit'),
(38, 'Tabungan - Tabungan'),
(39, 'Tabungan - Data Tabungan'),
(40, 'Tabungan - Transaksi Tabungan'),
(41, 'Tabungan - Pembukaan Rekening'),
(42, 'Tabungan - Aktivasi Rekening'),
(43, 'Tabungan - Tarik Nominatif'),
(44, 'Tabungan - Saldo Minus Tabungan'),
(45, 'Tabungan - Koreksi Kode Produk'),
(46, 'Tabungan - Penutupan Tabungan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comment`
--

CREATE TABLE `comment` (
  `id_comment` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `pelaporan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `file` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `comment`
--

INSERT INTO `comment` (`id_comment`, `parent_id`, `pelaporan_id`, `user_id`, `body`, `file`, `created_at`) VALUES
(141, 0, 127, 55, '<p>kurang data</p>', '', '2024-05-25 12:11:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` int(11) NOT NULL,
  `nama_divisi` varchar(50) NOT NULL,
  `nama_pegawai` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nama_divisi`, `nama_pegawai`) VALUES
(1, 'Helpdesk 1', 'Ajeng'),
(2, 'Helpdesk 1', 'Novi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `forward`
--

CREATE TABLE `forward` (
  `id_forward` int(11) NOT NULL,
  `pelaporan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subtask` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `forward`
--

INSERT INTO `forward` (`id_forward`, `pelaporan_id`, `user_id`, `subtask`) VALUES
(143, 127, 55, NULL),
(144, 130, 52, NULL),
(146, 125, 53, NULL),
(147, 125, 55, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `klien`
--

CREATE TABLE `klien` (
  `id` int(11) NOT NULL,
  `no_klien` varchar(20) NOT NULL,
  `nama_klien` varchar(75) NOT NULL,
  `id_user_klien` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `klien`
--

INSERT INTO `klien` (`id`, `no_klien`, `nama_klien`, `id_user_klien`) VALUES
(23, '0001', 'PT BPR BKK Banjarharjo(Perseroda)', 58),
(24, '0002', 'PT BPR BKK Karangmalang(Perseroda)', 59),
(35, '0003', 'PT BPR BKK Kab.Pekalongan(Perseroda)', 61),
(36, '0004', 'PT BPR BKK Purwokerto(Perseroda)', 60),
(38, '0005', 'PT BPR BKK Kebumen(Perseroda)', 66);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelaporan`
--

CREATE TABLE `pelaporan` (
  `id_pelaporan` int(11) NOT NULL,
  `no_tiket` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `tags` varchar(100) DEFAULT NULL,
  `waktu_pelaporan` date NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'proses',
  `status_ccs` varchar(20) DEFAULT 'ADDED',
  `priority` varchar(30) DEFAULT NULL,
  `maxday` int(11) DEFAULT NULL,
  `judul` varchar(100) NOT NULL,
  `perihal` text NOT NULL,
  `impact` varchar(30) DEFAULT NULL,
  `file` varchar(100) DEFAULT NULL,
  `rating` text DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `handle_by` varchar(100) DEFAULT NULL,
  `handle_by2` varchar(100) DEFAULT NULL,
  `handle_by3` varchar(100) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `waktu_approve` date DEFAULT NULL,
  `csrf_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelaporan`
--

INSERT INTO `pelaporan` (`id_pelaporan`, `no_tiket`, `user_id`, `kategori`, `tags`, `waktu_pelaporan`, `status`, `status_ccs`, `priority`, `maxday`, `judul`, `perihal`, `impact`, `file`, `rating`, `nama`, `handle_by`, `handle_by2`, `handle_by3`, `keterangan`, `waktu_approve`, `csrf_token`) VALUES
(125, 'TIC00012024050001', 58, 'Backdate - Backdate Transaksi', 'Backdate,transaksi', '2024-05-22', 'Forward To Helpdesk', 'HANDLE', 'Low', 90, 'Test 1', '<p>Test 1</p>', NULL, 'Screenshot_2024-05-13_084149.png', NULL, 'PT BPR BKK Banjarharjo(Perseroda)', 'Luthfi', NULL, NULL, NULL, NULL, NULL),
(126, 'TIC00012024050002', 58, 'C6', 'C6', '2024-05-25', 'proses', 'ADDED', 'Medium', 60, 'Test 2', '<p>Test 2</p>', NULL, 'Screenshot_2024-04-22_115028.png', NULL, 'PT BPR BKK Banjarharjo(Perseroda)', NULL, NULL, NULL, NULL, NULL, NULL),
(127, 'TIC00042024050001', 60, 'Pembatalan - Pembatalan Transaksi(Current Date, Backdate, Adendum Kredit dan Ecollector)', 'current date,adendum', '2024-05-25', 'Solved', 'FINISH', 'High', 7, 'TEST 3', '<p>Test 3</p>', 'kritikal', 'Screenshot_2024-05-07_112200.png', NULL, 'PT BPR BKK Purwokerto (Perseroda)', 'Luthfi', 'Implementator PT MSO Purwokerto', NULL, NULL, '2024-05-28', NULL),
(128, 'TIC00042024050002', 60, 'Kredit - Agunan', 'agunan', '2024-05-25', 'proses', 'ADDED', 'Low', 90, 'TEST 4', '<p>Test 4</p>', NULL, 'Screenshot_2024-05-16_143604.png', NULL, 'PT BPR BKK Purwokerto (Perseroda)', NULL, NULL, NULL, NULL, NULL, NULL),
(129, 'TIC00022024050001', 59, 'Kredit - Data Kredit', 'kredit,data', '2024-05-25', 'proses', 'ADDED', 'Low', 90, 'TEST 5', '<p>Test 5</p>', NULL, 'Screenshot_2024-05-15_114436.png', NULL, 'PT BPR BKK Karangmalang (Perseroda)', NULL, NULL, NULL, NULL, '2024-05-25', NULL),
(130, 'TIC00012024050003', 58, 'Kredit - PPAP Kredit', 'Kredit,PPAP', '2024-05-25', 'Solved', 'FINISH', 'Medium', 60, 'Test 6', '<p>Test 66</p>', 'kritikal', 'Screenshot_2024-05-13_082002.png', NULL, 'PT BPR BKK Banjarharjo(Perseroda)', 'Eva', 'Implementator PT MSO Purwokerto', NULL, NULL, '2024-05-25', NULL),
(132, 'TIC00012024050004', 58, 'API - TTF', 'API', '2024-05-28', 'proses', 'ADDED', NULL, NULL, 'coba', 'coba', NULL, 'Screenshot_2024-05-18_085129.png', NULL, 'PT BPR BKK Banjarharjo(Perseroda)', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rating`
--

CREATE TABLE `rating` (
  `id_rating` int(11) NOT NULL,
  `pelaporan_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating _name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reply`
--

CREATE TABLE `reply` (
  `id_reply` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `pelaporan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `file` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `reply`
--

INSERT INTO `reply` (`id_reply`, `comment_id`, `pelaporan_id`, `user_id`, `body`, `file`, `created_at`) VALUES
(35, 141, 127, 60, '', 'CCS_Customer_Care_System1.pdf', '2024-05-25 12:12:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `s_forward`
--

CREATE TABLE `s_forward` (
  `id_forward` int(11) NOT NULL,
  `pelaporan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `s_forward`
--

INSERT INTO `s_forward` (`id_forward`, `pelaporan_id`, `user_id`) VALUES
(9, 130, 47),
(10, 127, 47);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t1_forward`
--

CREATE TABLE `t1_forward` (
  `id_forward` int(11) NOT NULL,
  `pelaporan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `judul` text DEFAULT NULL,
  `subtask` text DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t1_forward`
--

INSERT INTO `t1_forward` (`id_forward`, `pelaporan_id`, `user_id`, `judul`, `subtask`, `tanggal`) VALUES
(11, 130, 62, 'Test 66', 'Test 666', '2024-05-29'),
(12, 127, 62, 'TEST 3', 'test 333', '2024-05-31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t2_forward`
--

CREATE TABLE `t2_forward` (
  `id_forward` int(11) NOT NULL,
  `pelaporan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `judul2` text NOT NULL,
  `subtask2` text DEFAULT NULL,
  `tanggal2` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket_temp`
--

CREATE TABLE `tiket_temp` (
  `id_temp` int(11) NOT NULL,
  `no_tiket` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `tags` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `divisi` varchar(30) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `active` varchar(5) NOT NULL DEFAULT 'Y',
  `tgl_register` date NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `divisi`, `nama_user`, `username`, `password`, `role`, `active`, `tgl_register`, `last_login`) VALUES
(47, 'Supervisor 2', 'Supervisor 2', 'spv2', '$2y$10$3fmu3UaUBtwMUn/ibOqgwO0h36GrfFrAwjP/GAHxYZfIPJOJPYdgC', 9, 'Y', '2024-05-21', '2024-05-28 09:52:13'),
(48, 'Helpdesk 1', 'Ajeng', 'ajeng', '$2y$10$yMDEbxjjlh4oNXdZJw1om.SmuYMqFSzqLe3vycjiXnVFnZVXh7Fli', 2, 'Y', '2024-05-21', '2024-05-21 16:18:09'),
(49, 'Helpdesk 1', 'Novi', 'novi', '$2y$10$61Gvfbmfq/xELLugqweR3.ITjxqoazOT478NP8hl9ND44iSRndaWO', 2, 'Y', '2024-05-21', '2024-05-21 16:19:16'),
(50, 'Helpdesk 2', 'Ayu', 'ayu', '$2y$10$CBazdGZC3pDGBYv0WVS6WuqgRQW2SNVhGotgSoR09dL3CpXRLn4Tq', 2, 'Y', '2024-05-21', '2024-05-21 16:19:30'),
(51, 'Helpdesk 2', 'Chintya', 'chintya', '$2y$10$dfuc4GUWd8UHDVpKSDO2z.9G./SV5svEYIThkIB6.ZCFvWnjz6zkC', 2, 'Y', '2024-05-21', '2024-05-21 16:19:50'),
(52, 'Helpdesk 3', 'Eva', 'eva', '$2y$10$R8oQzXHI8pnwusrmXCTX3e9FWIjfvqgXFekk1yqJNhXIAkFDTY.n.', 2, 'Y', '2024-05-21', '2024-05-25 10:22:11'),
(53, 'Helpdesk 3', 'Ina', 'ina', '$2y$10$39stpYd9tIjV.jrW/ffns.bVwZtKOyDqHHdZkSSwTmaNjTAS.1Qsi', 2, 'Y', '2024-05-21', '2024-05-25 11:32:23'),
(54, 'Helpdesk 4', 'Nita', 'nita', '$2y$10$lGRwZfprphMBSECfyzb/SOLIyxsTw2THLpKO5WYjUeq41XBy0Nnz.', 2, 'Y', '2024-05-21', '2024-05-22 08:49:50'),
(55, 'Helpdesk 4', 'Luthfi', 'luthfi', '$2y$10$JEjAMFVKUPfcwhAh5mNlAOzSOKQmSmXL/2iVnTWN6NS4BRzke6wMu', 2, 'Y', '2024-05-21', '2024-05-28 09:52:49'),
(56, 'Helpdesk 4', 'Khabibah', 'Khabibah', '$2y$10$kMOcFV1oh9PL5kGxkARcW.0q6iPYOTTe/M4OjztfR2dRory9yTwRa', 2, 'Y', '2024-05-22', '2024-05-21 16:21:03'),
(57, 'Supervisor', 'Supervisor', 'supervisor', '$2y$10$B2CATYduaY1k14AaFRVyP.m/rV5.yI4mj0.WXWt.Ud8P5oZMF1rQy', 3, 'Y', '2024-05-22', '2024-05-28 15:14:41'),
(58, 'Klien', 'PT BPR BKK Banjarharjo(Perseroda)', 'banjarharjo', '$2y$10$kTGlxi4xSlwGOuMW8xDSc.CparcG1uAK/YAIV4PU0trjX8oZ.YMVq', 1, 'Y', '2024-05-22', '2024-05-28 12:15:08'),
(59, 'Klien', 'PT BPR BKK Karangmalang(Perseroda)', 'karangmalang', '$2y$10$QNYfJEq8VLi6JCCBdywKjumU8rGIQnu9LU5AIcCobSyvXzauc6EWm', 1, 'Y', '2024-05-22', '2024-05-28 12:14:51'),
(60, 'Klien', 'PT BPR BKK Purwokerto(Perseroda)', 'purwokerto', '$2y$10$WniGIEgNUJA9Z/aNxOh3TO9oUtB9BAi9q3U8FYeqHHbTXTaV9Eywe', 1, 'Y', '2024-05-22', '2024-05-25 12:36:30'),
(61, 'Klien', 'PT BPR BKK Kab. Pekalongan(Perseroda)', 'pekalongan', '$2y$10$v7C/rY7SMvCOdS46NFs3jeZWtJbLmwImjBnw9KyHj0IM0fI3Useyu', 1, 'Y', '2024-05-22', '2024-05-25 08:51:19'),
(62, 'Implementator', 'Implementator PT MSO Purwokerto', 'implementator', '$2y$10$vAfqKnPDv/ymAIPib1NF2uhLZbnqWuJ6JN87f6T/Fq0A9n0axAoA2', 4, 'Y', '2024-05-22', '2024-05-28 15:14:15'),
(63, 'Support', 'Support PT MSO Purwokerto', 'support', '$2y$10$HEztd8wkl66Mpu2EIIRdpuFj/EBs57NLxZiZRGjc0Kg4M1kNpwoUu', 5, 'Y', '2024-05-22', '2024-05-28 09:54:07'),
(66, 'Klien', 'PT BPR BKK Kebumen (Perseroda)', 'kebumen', '$2y$10$8U34fAsqjj5IvjEe7CZgpeR.1.otC4xVr1F/cDHpSRCowoEUU4ffm', 1, 'Y', '2024-05-22', '2024-05-25 09:14:04'),
(68, 'Superadmin', 'Superadmin', 'superadmin', '$2y$10$tDJeFvFcChAeZWacIUOTxuSJp9HbObg3pagd3zZiHSj9EkGou79Iy', 6, 'Y', '2024-05-22', '2024-05-28 15:16:04');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id_comment`);

--
-- Indeks untuk tabel `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indeks untuk tabel `forward`
--
ALTER TABLE `forward`
  ADD PRIMARY KEY (`id_forward`);

--
-- Indeks untuk tabel `klien`
--
ALTER TABLE `klien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_klien` (`no_klien`);

--
-- Indeks untuk tabel `pelaporan`
--
ALTER TABLE `pelaporan`
  ADD PRIMARY KEY (`id_pelaporan`);

--
-- Indeks untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id_rating`);

--
-- Indeks untuk tabel `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`id_reply`);

--
-- Indeks untuk tabel `s_forward`
--
ALTER TABLE `s_forward`
  ADD PRIMARY KEY (`id_forward`);

--
-- Indeks untuk tabel `t1_forward`
--
ALTER TABLE `t1_forward`
  ADD PRIMARY KEY (`id_forward`);

--
-- Indeks untuk tabel `t2_forward`
--
ALTER TABLE `t2_forward`
  ADD PRIMARY KEY (`id_forward`);

--
-- Indeks untuk tabel `tiket_temp`
--
ALTER TABLE `tiket_temp`
  ADD PRIMARY KEY (`id_temp`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `comment`
--
ALTER TABLE `comment`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT untuk tabel `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `forward`
--
ALTER TABLE `forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT untuk tabel `klien`
--
ALTER TABLE `klien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `pelaporan`
--
ALTER TABLE `pelaporan`
  MODIFY `id_pelaporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reply`
--
ALTER TABLE `reply`
  MODIFY `id_reply` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `s_forward`
--
ALTER TABLE `s_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `t1_forward`
--
ALTER TABLE `t1_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `t2_forward`
--
ALTER TABLE `t2_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tiket_temp`
--
ALTER TABLE `tiket_temp`
  MODIFY `id_temp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
