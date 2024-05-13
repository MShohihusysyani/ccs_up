-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Bulan Mei 2024 pada 11.08
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
  `pelaporan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `comment`
--

INSERT INTO `comment` (`id_comment`, `pelaporan_id`, `user_id`, `body`) VALUES
(34, 101, 62, '&lt;p&gt;tes4&lt;/p&gt;'),
(44, 101, 49, '&lt;p&gt;tes4&lt;/p&gt;'),
(45, 101, 61, '&lt;p&gt;tes4&lt;/p&gt;'),
(46, 101, 57, '&lt;p&gt;tes4&lt;/p&gt;'),
(48, 101, 47, '&lt;p&gt;Tes4&lt;/p&gt;'),
(49, 101, 63, '&lt;p&gt;Tes4&lt;/p&gt;');

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
(117, 100, 56, NULL),
(118, 99, 55, NULL),
(119, 101, 49, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `klien`
--

CREATE TABLE `klien` (
  `id` int(11) NOT NULL,
  `no_urut` int(11) NOT NULL,
  `nama_klien` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `klien`
--

INSERT INTO `klien` (`id`, `no_urut`, `nama_klien`) VALUES
(9, 1, 'PT BPR BKK Banjarharjo(Perseroda)'),
(10, 2, 'PT BPR BKK Karangmalang(Perseroda)'),
(11, 3, 'PT BPR BKK Purwokerto(Perseroda)'),
(12, 6, 'PT BPR BKK Kab. Pekalongan(Perseroda)'),
(13, 7, 'PT BPR BKK Kebumen(Perseroda)'),
(14, 8, 'PT BPR BKK Arta Utama'),
(15, 9, 'PT BPR Mentari Terang'),
(16, 10, 'PT BPR Sinar Garuda Prima'),
(17, 11, 'PT BPR Wirosari Ijo'),
(18, 12, 'PT BPR BKK Blora (Perseroda)');

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

INSERT INTO `pelaporan` (`id_pelaporan`, `no_tiket`, `user_id`, `kategori`, `tags`, `waktu_pelaporan`, `status`, `status_ccs`, `priority`, `maxday`, `perihal`, `impact`, `file`, `rating`, `nama`, `handle_by`, `handle_by2`, `handle_by3`, `keterangan`, `waktu_approve`) VALUES
(98, 'TIC2024050001', 59, 'Backdate - Backdate Transaksi', 'Tes,transaksi,backdate', '2024-05-07', 'Solved', 'FINISH', 'Low', 90, '<p>Tes</p>', 'material', 'CCS_Customer_Care_System.xlsx', NULL, 'PT BPR BKK Karangmalang (Perseroda)', 'Nita', NULL, NULL, NULL, '2024-05-07'),
(99, 'TIC2024050002', 58, 'Kredit - Agunan', 'kredit,agunan', '2024-05-07', 'Solved', 'FINISH', 'Medium', 60, '<p>Tes2</p>', 'material', 'code.png', NULL, 'PT BPR BKK Banjarharjo(Perseroda)', 'Luthfi', 'Implementator PT MSO Purwokerto', NULL, NULL, '2024-05-08'),
(100, 'TIC2024050003', 60, 'Pembatalan - Pembatalan Transaksi(Current Date, Backdate, Adendum Kredit dan Ecollector)', 'backdate,kredit,pembatalan,ecollector', '2024-05-07', 'Solved', 'FINISH', 'High', 7, '<p>Tes3</p>', 'kritikal', 'CCS_Customer_Care_System.pdf', NULL, 'PT BPR BKK Purwokerto (Perseroda)', 'Khabibah', NULL, NULL, NULL, '2024-05-08'),
(101, 'TIC2024050004', 61, 'Backdate - Backdate Transaksi', 'Backdate,Tes4,Transaksi', '2024-05-08', 'Forward To Teknisi', 'HANDLE 2', 'High', 7, '<p>Tes4</p>', 'kritikal', 'controller.png', NULL, 'PT BPR BKK Kab. Pekalongan (Perseroda)', 'Novi', 'Implementator PT MSO Purwokerto', 'Support PT MSO Purwokerto', NULL, NULL);

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
(3, 99, 47),
(4, 101, 47);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t1_forward`
--

CREATE TABLE `t1_forward` (
  `id_forward` int(11) NOT NULL,
  `pelaporan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `judul` text NOT NULL,
  `subtask` text DEFAULT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t1_forward`
--

INSERT INTO `t1_forward` (`id_forward`, `pelaporan_id`, `user_id`, `judul`, `subtask`, `tanggal`) VALUES
(3, 99, 62, '', '', '0000-00-00'),
(7, 101, 62, 'TES 4', 'TES 44', '2024-05-16');

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

--
-- Dumping data untuk tabel `t2_forward`
--

INSERT INTO `t2_forward` (`id_forward`, `pelaporan_id`, `user_id`, `judul2`, `subtask2`, `tanggal2`) VALUES
(5, 101, 63, 'TES4', 'TES44', '2024-05-16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket_temp`
--

CREATE TABLE `tiket_temp` (
  `id_temp` int(11) NOT NULL,
  `no_tiket` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
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
  `active` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `divisi`, `nama_user`, `username`, `password`, `role`, `active`) VALUES
(47, 'Supervisor 2', 'Supervisor 2', 'spv2', '$2y$10$3fmu3UaUBtwMUn/ibOqgwO0h36GrfFrAwjP/GAHxYZfIPJOJPYdgC', 9, 'Y'),
(48, 'Helpdesk 1', 'Ajeng', 'ajeng', '$2y$10$yMDEbxjjlh4oNXdZJw1om.SmuYMqFSzqLe3vycjiXnVFnZVXh7Fli', 2, 'Y'),
(49, 'Helpdesk 1', 'Novi', 'novi', '$2y$10$61Gvfbmfq/xELLugqweR3.ITjxqoazOT478NP8hl9ND44iSRndaWO', 2, 'Y'),
(50, 'Helpdesk 2', 'Ayu', 'ayu', '$2y$10$CBazdGZC3pDGBYv0WVS6WuqgRQW2SNVhGotgSoR09dL3CpXRLn4Tq', 2, 'Y'),
(51, 'Helpdesk 2', 'Chintya', 'chintya', '$2y$10$dfuc4GUWd8UHDVpKSDO2z.9G./SV5svEYIThkIB6.ZCFvWnjz6zkC', 2, 'Y'),
(52, 'Helpdesk 3', 'Eva', 'eva', '$2y$10$R8oQzXHI8pnwusrmXCTX3e9FWIjfvqgXFekk1yqJNhXIAkFDTY.n.', 2, 'Y'),
(53, 'Helpdesk 3', 'Ina', 'ina', '$2y$10$FZNnbtkfhSp9udiGEEOuOOjFMG3XX38k2U1XXjdvwtgGu52oViYae', 2, 'Y'),
(54, 'Helpdesk 4', 'Nita', 'nita', '$2y$10$lGRwZfprphMBSECfyzb/SOLIyxsTw2THLpKO5WYjUeq41XBy0Nnz.', 2, 'Y'),
(55, 'Helpdesk 4', 'Luthfi', 'luthfi', '$2y$10$JEjAMFVKUPfcwhAh5mNlAOzSOKQmSmXL/2iVnTWN6NS4BRzke6wMu', 2, 'Y'),
(56, 'Helpdesk 4', 'Khabibah', 'Khabibah', '$2y$10$kMOcFV1oh9PL5kGxkARcW.0q6iPYOTTe/M4OjztfR2dRory9yTwRa', 2, 'Y'),
(57, 'Supervisor', 'Supervisor ', 'supervisor', '$2y$10$3DEhLQ855QS0gvAMQlSbC.uI1Fz..6KGobTwMfim6goDVQFoKiGuO', 3, 'Y'),
(58, 'Klien', 'PT BPR BKK Banjarharjo(Perseroda)', 'banjarharjo', '$2y$10$pv3isBjHWz6jhsA872peJOxxtwQ8Zw.0v.EMyK/qzsYz25IByX6AS', 1, 'Y'),
(59, 'Klien', 'PT BPR BKK Karangmalang (Perseroda)', 'karangmalang', '$2y$10$QNYfJEq8VLi6JCCBdywKjumU8rGIQnu9LU5AIcCobSyvXzauc6EWm', 1, 'Y'),
(60, 'Klien', 'PT BPR BKK Purwokerto (Perseroda)', 'purwokerto', '$2y$10$WniGIEgNUJA9Z/aNxOh3TO9oUtB9BAi9q3U8FYeqHHbTXTaV9Eywe', 1, 'Y'),
(61, 'Klien', 'PT BPR BKK Kab. Pekalongan (Perseroda)', 'pekalongan', '$2y$10$v7C/rY7SMvCOdS46NFs3jeZWtJbLmwImjBnw9KyHj0IM0fI3Useyu', 1, 'Y'),
(62, 'Implementator', 'Implementator PT MSO Purwokerto', 'implementator', '$2y$10$4i/3FulPCa5Q1At8XM5Kxu.egGG4nkIu8w/Tlsr61gTv3clxwVZdC', 4, 'Y'),
(63, 'Support', 'Support PT MSO Purwokerto', 'support', '$2y$10$MtL38t9ucCnh1JbfkThYX.E4IPqvInrAnDmfH/yOYeGOac6X5lYKS', 5, 'Y');

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `comment`
--
ALTER TABLE `comment`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `forward`
--
ALTER TABLE `forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT untuk tabel `klien`
--
ALTER TABLE `klien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `pelaporan`
--
ALTER TABLE `pelaporan`
  MODIFY `id_pelaporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `s_forward`
--
ALTER TABLE `s_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `t1_forward`
--
ALTER TABLE `t1_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `t2_forward`
--
ALTER TABLE `t2_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tiket_temp`
--
ALTER TABLE `tiket_temp`
  MODIFY `id_temp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
