-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Bulan Mei 2024 pada 11.23
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
(46, 'Tabungan - Penutupan Tabungan'),
(57, 'tes');

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
(142, 0, 138, 52, '<p>cobaa</p>', '', '2024-05-29 15:38:06');

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
(149, 135, 52, NULL),
(150, 138, 52, NULL);

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
  `waktu_approve` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelaporan`
--

INSERT INTO `pelaporan` (`id_pelaporan`, `no_tiket`, `user_id`, `kategori`, `tags`, `waktu_pelaporan`, `status`, `status_ccs`, `priority`, `maxday`, `judul`, `perihal`, `impact`, `file`, `rating`, `nama`, `handle_by`, `handle_by2`, `handle_by3`, `keterangan`, `waktu_approve`) VALUES
(135, 'TIC00012024050001', 58, 'API - TTF', 'API', '2024-05-29', 'Solved', 'FINISH', 'High', 7, 'Test', 'Test', 'kritikal', 'Rekap_Pelaporan.xlsx', NULL, 'PT BPR BKK Banjarharjo(Perseroda)', 'Eva', NULL, NULL, NULL, '2024-05-30'),
(138, 'TIC00042024050001', 60, 'C6', 'C6', '2024-05-29', 'Solved', 'FINISH', 'Medium', 60, 'Coba', 'cobaa', 'material', 'CCS_Customer_Care_System.csv', NULL, 'PT BPR BKK Purwokerto(Perseroda)', 'Eva', 'Implementator PT MSO Purwokerto', NULL, NULL, '2024-05-30'),
(139, 'TIC00042024050002', 60, 'Kredit - PPAP Kredit', 'kredit,ppap', '2024-05-29', 'proses', 'ADDED', NULL, NULL, 'coba coba', 'coba coba', NULL, 'Screenshot_2024-05-13_084149.png', NULL, 'PT BPR BKK Purwokerto(Perseroda)', NULL, NULL, NULL, NULL, NULL);

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
(36, 142, 138, 60, '<p>cobaaa</p>', '', '2024-05-29 15:38:30'),
(37, 142, 138, 57, '<p>cobaa</p>', 'Screenshot_2024-05-28_100649.png', '2024-05-29 15:39:08'),
(38, 142, 138, 62, '<p>cobaa</p>', '', '2024-05-29 15:40:16');

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
(11, 138, 47);

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
(13, 138, 62, 'Coba', 'cobaaa', '2024-05-31');

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
(47, 'Supervisor 2', 'Supervisor 2', 'spv2', '$2y$10$3fmu3UaUBtwMUn/ibOqgwO0h36GrfFrAwjP/GAHxYZfIPJOJPYdgC', 9, 'Y', '2024-05-21', '2024-05-30 08:02:33'),
(48, 'Helpdesk 1', 'Ajeng', 'ajeng', '$2y$10$yMDEbxjjlh4oNXdZJw1om.SmuYMqFSzqLe3vycjiXnVFnZVXh7Fli', 2, 'Y', '2024-05-21', '2024-05-21 16:18:09'),
(49, 'Helpdesk 1', 'Novi', 'novi', '$2y$10$61Gvfbmfq/xELLugqweR3.ITjxqoazOT478NP8hl9ND44iSRndaWO', 2, 'Y', '2024-05-21', '2024-05-21 16:19:16'),
(50, 'Helpdesk 2', 'Ayu', 'ayu', '$2y$10$CBazdGZC3pDGBYv0WVS6WuqgRQW2SNVhGotgSoR09dL3CpXRLn4Tq', 2, 'Y', '2024-05-21', '2024-05-21 16:19:30'),
(51, 'Helpdesk 2', 'Chintya', 'chintya', '$2y$10$dfuc4GUWd8UHDVpKSDO2z.9G./SV5svEYIThkIB6.ZCFvWnjz6zkC', 2, 'Y', '2024-05-21', '2024-05-21 16:19:50'),
(52, 'Helpdesk 3', 'Eva', 'eva', '$2y$10$R8oQzXHI8pnwusrmXCTX3e9FWIjfvqgXFekk1yqJNhXIAkFDTY.n.', 2, 'Y', '2024-05-21', '2024-05-30 08:06:40'),
(53, 'Helpdesk 3', 'Ina', 'ina', '$2y$10$39stpYd9tIjV.jrW/ffns.bVwZtKOyDqHHdZkSSwTmaNjTAS.1Qsi', 2, 'Y', '2024-05-21', '2024-05-25 11:32:23'),
(54, 'Helpdesk 4', 'Nita', 'nita', '$2y$10$lGRwZfprphMBSECfyzb/SOLIyxsTw2THLpKO5WYjUeq41XBy0Nnz.', 2, 'Y', '2024-05-21', '2024-05-22 08:49:50'),
(55, 'Helpdesk 4', 'Luthfi', 'luthfi', '$2y$10$JEjAMFVKUPfcwhAh5mNlAOzSOKQmSmXL/2iVnTWN6NS4BRzke6wMu', 2, 'Y', '2024-05-21', '2024-05-29 11:46:10'),
(56, 'Helpdesk 4', 'Khabibah', 'Khabibah', '$2y$10$kMOcFV1oh9PL5kGxkARcW.0q6iPYOTTe/M4OjztfR2dRory9yTwRa', 2, 'Y', '2024-05-22', '2024-05-21 16:21:03'),
(57, 'Supervisor', 'Supervisor', 'supervisor', '$2y$10$B2CATYduaY1k14AaFRVyP.m/rV5.yI4mj0.WXWt.Ud8P5oZMF1rQy', 3, 'Y', '2024-05-22', '2024-05-30 07:55:08'),
(58, 'Klien', 'PT BPR BKK Banjarharjo(Perseroda)', 'banjarharjo', '$2y$10$kTGlxi4xSlwGOuMW8xDSc.CparcG1uAK/YAIV4PU0trjX8oZ.YMVq', 1, 'Y', '2024-05-22', '2024-05-30 08:03:36'),
(59, 'Klien', 'PT BPR BKK Karangmalang(Perseroda)', 'karangmalang', '$2y$10$QNYfJEq8VLi6JCCBdywKjumU8rGIQnu9LU5AIcCobSyvXzauc6EWm', 1, 'Y', '2024-05-22', '2024-05-28 16:14:31'),
(60, 'Klien', 'PT BPR BKK Purwokerto(Perseroda)', 'purwokerto', '$2y$10$WniGIEgNUJA9Z/aNxOh3TO9oUtB9BAi9q3U8FYeqHHbTXTaV9Eywe', 1, 'Y', '2024-05-22', '2024-05-29 15:13:49'),
(61, 'Klien', 'PT BPR BKK Kab. Pekalongan(Perseroda)', 'pekalongan', '$2y$10$v7C/rY7SMvCOdS46NFs3jeZWtJbLmwImjBnw9KyHj0IM0fI3Useyu', 1, 'Y', '2024-05-22', '2024-05-25 08:51:19'),
(62, 'Implementator', 'Implementator PT MSO Purwokerto', 'implementator', '$2y$10$vAfqKnPDv/ymAIPib1NF2uhLZbnqWuJ6JN87f6T/Fq0A9n0axAoA2', 4, 'Y', '2024-05-22', '2024-05-30 11:31:06'),
(63, 'Support', 'Support PT MSO Purwokerto', 'support', '$2y$10$HEztd8wkl66Mpu2EIIRdpuFj/EBs57NLxZiZRGjc0Kg4M1kNpwoUu', 5, 'Y', '2024-05-22', '2024-05-28 09:54:07'),
(66, 'Klien', 'PT BPR BKK Kebumen (Perseroda)', 'kebumen', '$2y$10$8U34fAsqjj5IvjEe7CZgpeR.1.otC4xVr1F/cDHpSRCowoEUU4ffm', 1, 'Y', '2024-05-22', '2024-05-25 09:14:04'),
(68, 'Superadmin', 'Superadmin', 'superadmin', '$2y$10$tDJeFvFcChAeZWacIUOTxuSJp9HbObg3pagd3zZiHSj9EkGou79Iy', 6, 'Y', '2024-05-22', '2024-05-30 16:04:27');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT untuk tabel `comment`
--
ALTER TABLE `comment`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT untuk tabel `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `forward`
--
ALTER TABLE `forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT untuk tabel `klien`
--
ALTER TABLE `klien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `pelaporan`
--
ALTER TABLE `pelaporan`
  MODIFY `id_pelaporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reply`
--
ALTER TABLE `reply`
  MODIFY `id_reply` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `s_forward`
--
ALTER TABLE `s_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `t1_forward`
--
ALTER TABLE `t1_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `t2_forward`
--
ALTER TABLE `t2_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tiket_temp`
--
ALTER TABLE `tiket_temp`
  MODIFY `id_temp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
