-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Apr 2024 pada 11.03
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
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `forward`
--

INSERT INTO `forward` (`id_forward`, `pelaporan_id`, `user_id`) VALUES
(45, 78, 25),
(46, 78, 39);

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
(18, 12, 'PT BPR BKK Blora (Perseroda)'),
(21, 13, 'PT BPR BKK PWT');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelaporan`
--

CREATE TABLE `pelaporan` (
  `id_pelaporan` int(11) NOT NULL,
  `no_tiket` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `waktu_pelaporan` date NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'proses',
  `status_ccs` varchar(20) DEFAULT 'ADDED',
  `priority` varchar(30) DEFAULT NULL,
  `maxday` int(11) DEFAULT NULL,
  `perihal` text NOT NULL,
  `impact` varchar(30) DEFAULT NULL,
  `file` varchar(100) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `handle_by` varchar(100) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `waktu_approve` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelaporan`
--

INSERT INTO `pelaporan` (`id_pelaporan`, `no_tiket`, `user_id`, `kategori`, `waktu_pelaporan`, `status`, `status_ccs`, `priority`, `maxday`, `perihal`, `impact`, `file`, `nama`, `handle_by`, `keterangan`, `waktu_approve`) VALUES
(69, 'TIC2024040001', 33, 'Pembatalan - Pembatalan Transaksi(Current Date, Backdate, Adendum Kredit dan Ecollector)', '2024-04-18', 'Solved by HD4', 'FINISH', 'Medium', 60, '<p>Permintaan Backdate</p>', NULL, '1702018237376.png', 'PT BPR BKK Kab. Pekalongan(Perseroda)', 'Nita', '', '2024-04-19'),
(71, 'TIC2024040003', 20, 'Kredit - PPAP Kredit ', '2024-04-18', 'proses', 'ADDED', 'Medium', 60, '<p>Perbaikan PPAP Kredit</p>', NULL, 'CCS_Customer_Care_System.pdf', 'PT BPR BKK Banjarharjo(Perseroda)', NULL, NULL, NULL),
(72, 'TIC2024040004', 20, 'Backdate - Backdate Transaksi', '2024-04-18', 'proses', 'ADDED', 'High', 7, '<p>tes</p>', NULL, 'CCS_Customer_Care_System_(1).xlsx', 'PT BPR BKK Banjarharjo(Perseroda)', NULL, NULL, NULL),
(73, 'TIC2024040005', 20, 'Proses - Proses Ulang', '2024-04-18', 'proses', 'ADDED', 'Low', 90, '<p>tes2</p>', 'kritikal', 'CCS_Customer_Care_System_(2).xlsx', 'PT BPR BKK Banjarharjo(Perseroda)', NULL, NULL, NULL),
(74, 'TIC2024040006', 33, 'Kredit - PPAP Kredit ', '2024-04-18', 'proses', 'ADDED', 'High', 7, '<p>tes3</p>', NULL, 'Pertemuan_13.pdf', 'PT BPR BKK Kab. Pekalongan(Perseroda)', NULL, NULL, NULL),
(77, 'TIC2024040007', 33, 'Kredit - PPAP Kredit ', '2024-04-22', 'Forward To Helpdesk', 'HANDLE', 'High', 7, '<p>tes 4</p>', 'kritikal', '1702018237376.png', 'PT BPR BKK Kab. Pekalongan(Perseroda)', 'Chintya', NULL, NULL),
(78, 'TIC2024040008', 20, 'Kredit - PPAP Kredit ', '2024-04-23', 'Forward To Supervisor 2', 'HANDLE 2', 'Medium', 60, '<p>tes5</p>', 'kritikal', 'CCS_Customer_Care_System_(3).xlsx', 'PT BPR BKK Banjarharjo(Perseroda)', 'Eva', NULL, NULL);

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
  `kategori` varchar(100) DEFAULT NULL
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
  `password` varchar(50) NOT NULL,
  `role` int(11) NOT NULL,
  `active` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `divisi`, `nama_user`, `username`, `password`, `role`, `active`) VALUES
(3, 'Supervisor', 'Supervisor PT MSO Purwokerto', 'supervisor', '5f4dcc3b5aa765d61d8327deb882cf99', 3, 'Y'),
(4, 'Helpdesk 1', 'Ajeng', 'ajeng', '5f4dcc3b5aa765d61d8327deb882cf99', 2, 'Y'),
(8, 'Support', 'Support PT MSO', 'support', '5f4dcc3b5aa765d61d8327deb882cf99', 5, 'Y'),
(9, 'DBS', 'DBS PT MSO', 'dbs', '482c811da5d5b4bc6d497ffa98491e38', 6, 'Y'),
(10, 'CRD', 'CRD PT MSO', 'crd', '5f4dcc3b5aa765d61d8327deb882cf99', 7, 'Y'),
(11, 'Development', 'Development PT MSO', 'development', '5f4dcc3b5aa765d61d8327deb882cf99', 8, 'Y'),
(20, 'Klien', 'PT BPR BKK Banjarharjo(Perseroda)', 'banjarharjo', '5f4dcc3b5aa765d61d8327deb882cf99', 1, 'Y'),
(23, 'Helpdesk 2', 'Ayu', 'ayu', '5f4dcc3b5aa765d61d8327deb882cf99', 2, 'Y'),
(24, 'Implementator', 'Implementator PT MSO', 'implementator', '5f4dcc3b5aa765d61d8327deb882cf99', 4, 'Y'),
(25, 'Helpdesk 3', 'Eva', 'eva', '5f4dcc3b5aa765d61d8327deb882cf99', 2, 'Y'),
(26, 'Helpdesk 4', 'Khabibah', 'Khabibah', '5f4dcc3b5aa765d61d8327deb882cf99', 2, 'Y'),
(27, 'Helpdesk 1', 'Novi', 'novi', '5f4dcc3b5aa765d61d8327deb882cf99', 2, 'Y'),
(28, 'Klien', 'PT BPR BKK Karangmalang(Perseroda)', 'karangmalang', '5f4dcc3b5aa765d61d8327deb882cf99', 1, 'Y'),
(29, 'Helpdesk 2', 'Chintya', 'chintya', '5f4dcc3b5aa765d61d8327deb882cf99', 2, 'Y'),
(30, 'Helpdesk 3', 'Ina', 'ina', '5f4dcc3b5aa765d61d8327deb882cf99', 2, 'Y'),
(31, 'Helpdesk 4', 'Luthfi', 'luthfi', '5f4dcc3b5aa765d61d8327deb882cf99', 2, 'Y'),
(32, 'Helpdesk 4', 'Nita', 'nita', '5f4dcc3b5aa765d61d8327deb882cf99', 2, 'Y'),
(33, 'Klien', 'PT BPR BKK Kab. Pekalongan(Perseroda)', 'pekalongan', '5f4dcc3b5aa765d61d8327deb882cf99', 1, 'Y'),
(39, 'Supervisor 2', 'Supervisor PT MSO Purwokerto', 'spv2', '5f4dcc3b5aa765d61d8327deb882cf99', 9, 'Y'),
(42, 'Support', 'Rijal Amri', 'rijal', '5f4dcc3b5aa765d61d8327deb882cf99', 5, 'Y');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT untuk tabel `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `forward`
--
ALTER TABLE `forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `klien`
--
ALTER TABLE `klien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `pelaporan`
--
ALTER TABLE `pelaporan`
  MODIFY `id_pelaporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT untuk tabel `tiket_temp`
--
ALTER TABLE `tiket_temp`
  MODIFY `id_temp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
