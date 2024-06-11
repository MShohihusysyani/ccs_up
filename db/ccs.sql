-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Jun 2024 pada 11.32
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
(143, 0, 140, 55, 'coba preg', '', '2024-05-31 16:03:08'),
(145, 0, 140, 60, 'preg', '', '2024-05-31 16:05:04'),
(146, 0, 140, 57, 'coba preg', '', '2024-05-31 16:06:28');

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
(152, 140, 55, NULL),
(153, 141, 55, NULL),
(154, 142, 55, NULL),
(155, 143, 52, NULL),
(156, 147, 50, NULL);

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
(35, '0003', 'PT BPR BKK Purwokerto(Perseroda)', 60),
(40, '0006', 'PT BPR BKK Kab.Pekalongan(Perseroda)', 61),
(41, '0007', 'PT BPR BKK Kebumen(Perseroda)', 66);

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
  `waktu_approve` date DEFAULT NULL,
  `catatan_finish` text NOT NULL,
  `file_finish` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelaporan`
--

INSERT INTO `pelaporan` (`id_pelaporan`, `no_tiket`, `user_id`, `kategori`, `tags`, `waktu_pelaporan`, `status`, `status_ccs`, `priority`, `maxday`, `judul`, `perihal`, `impact`, `file`, `rating`, `nama`, `handle_by`, `handle_by2`, `handle_by3`, `waktu_approve`, `catatan_finish`, `file_finish`) VALUES
(140, 'TIC00032024050001', 60, 'Proses - Proses Ulang', 'proses ulang', '2024-05-31', 'Forward To Helpdesk', 'HANDLE', 'High', 7, 'Coba Preg', 'coba preg', 'kritikal', 'Rekap_Pelaporan.xlsx', NULL, 'PT BPR BKK Purwokerto(Perseroda)', 'Luthfi', NULL, NULL, NULL, '', NULL),
(141, 'TIC00032024060002', 60, 'API - TTF', 'apii', '2024-06-04', 'Solved', 'FINISH', 'Medium', 60, 'tesss', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Obcaecati provident, quasi quae recusandae magni, tempore illo voluptatem nam voluptatibus ducimus quod minima ullam. Obcaecati, modi. Ducimus perspiciatis quaerat iure, atque magni porro natus ill', 'material', 'Screenshot_2024-06-03_102755.png', NULL, 'PT BPR BKK Purwokerto(Perseroda)', 'Luthfi', NULL, NULL, '2024-06-04', '', NULL),
(142, 'TIC00032024060003', 60, 'API - TTF', 'api', '2024-06-05', 'Solved', 'FINISH', 'Low', 90, 'coba finish', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorum ut necessitatibus quibusdam nostrum labore aliquam voluptate doloremque ipsa suscipit voluptatum? In animi impedit iure fugiat doloribus iste ipsum consequatur cum! Accusantium nihil eius q', 'material', 'Screenshot_2024-04-22_115028.png', NULL, 'PT BPR BKK Purwokerto(Perseroda)', 'Luthfi', NULL, NULL, '2024-06-05', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quidem ea quam amet soluta atque eum, ab illo. Quas enim maxime est nisi modi, labore rem porro, accusantium, deleniti beatae inventore exercitationem? Provident perferendis beatae ratione eum est ipsam, cumque, recusandae, commodi soluta repellat aliquam architecto sit. Quibusdam quis consequuntur totam dolorum cumque. Asperiores, nisi in?', ''),
(143, 'TIC00012024060001', 58, 'API - TTF', 'API', '2024-06-05', 'Solved', 'FINISH', 'High', 7, 'Lorem ipsum', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quidem ea quam amet soluta atque eum, ab illo. Quas enim maxime est nisi modi, labore rem porro, accusantium, deleniti beatae inventore exercitationem? Provident perferendis beatae ratione eum est ', 'kritikal', 'Screenshot_2024-05-28_100649.png', NULL, 'PT BPR BKK Banjarharjo(Perseroda)', 'Eva', 'Implementator PT MSO Purwokerto', NULL, '2024-06-07', '', NULL),
(144, 'TIC00022024060001', 59, 'Kredit - Agunan', 'agunan', '2024-06-06', 'proses', 'ADDED', NULL, NULL, 'lorem', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Obcaecati provident, quasi quae recusandae magni, tempore illo voluptatem nam voluptatibus ducimus quod minima ullam. Obcaecati, modi. Ducimus perspiciatis quaerat iure, atque magni porro natus ill', NULL, 'Screenshot_2024-04-22_115120.png', NULL, 'PT BPR BKK Karangmalang(Perseroda)', NULL, NULL, NULL, NULL, '', NULL),
(145, 'TIC00062024060001', 61, 'Kredit - Agunan', 'agunan', '2024-06-06', 'proses', 'ADDED', NULL, NULL, 'lorem ipsum', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Obcaecati provident, quasi quae recusandae magni, tempore illo voluptatem nam voluptatibus ducimus quod minima ullam. Obcaecati, modi. Ducimus perspiciatis quaerat iure, atque magni porro natus ill', NULL, 'Screenshot_2024-05-13_084149.png', NULL, 'PT BPR BKK Kab. Pekalongan(Perseroda)', NULL, NULL, NULL, NULL, '', NULL),
(146, 'TIC00072024060001', 66, 'Kredit - Agunan', 'agunan', '2024-06-06', 'proses', 'ADDED', NULL, NULL, 'lorem ipsum 50', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Obcaecati provident, quasi quae recusandae magni, tempore illo voluptatem nam voluptatibus ducimus quod minima ullam. Obcaecati, modi. Ducimus perspiciatis quaerat iure, atque magni porro natus ill', NULL, 'Screenshot_2024-04-22_1150281.png', NULL, 'PT BPR BKK Kebumen(Perseroda)', NULL, NULL, NULL, NULL, '', NULL),
(147, 'TIC00072024060002', 66, 'Kredit - Agunan', 'agunan', '2024-06-06', 'Forward To Helpdesk', 'HANDLE', 'Medium', 60, 'tes pdf', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorum ut necessitatibus quibusdam nostrum labore aliquam voluptate doloremque ipsa suscipit voluptatum? In animi impedit iure fugiat doloribus iste ipsum consequatur cum! Accusantium nihil eius q', NULL, 'Screenshot_2024-06-06_141736.png', NULL, 'PT BPR BKK Kebumen(Perseroda)', 'Ayu', NULL, NULL, NULL, '', NULL),
(148, 'TIC00012024060002', 58, 'Backdate - Backdate Transaksi', 'backdate', '2024-06-07', 'proses', 'ADDED', NULL, NULL, 'test serverside', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Obcaecati provident, quasi quae recusandae magni, tempore illo voluptatem nam voluptatibus ducimus quod minima ullam. Obcaecati, modi. Ducimus perspiciatis quaerat iure, atque magni porro natus ill', NULL, 'CCS_Customer_Care_System.xlsx', NULL, 'PT BPR BKK Banjarharjo(Perseroda)', NULL, NULL, NULL, NULL, '', NULL),
(149, 'TIC00022024060002', 59, 'Backdate - Backdate Transaksi', 'backdate', '2024-06-07', 'proses', 'ADDED', NULL, NULL, 'serverside', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Obcaecati provident, quasi quae recusandae magni, tempore illo voluptatem nam voluptatibus ducimus quod minima ullam. Obcaecati, modi. Ducimus perspiciatis quaerat iure, atque magni porro natus ill', NULL, 'CCS_Customer_Care_System1.pdf', NULL, 'PT BPR BKK Karangmalang(Perseroda)', NULL, NULL, NULL, NULL, '', NULL),
(150, 'TIC00072024060003', 66, 'Backdate - Backdate Transaksi', 'backdate', '2024-06-07', 'proses', 'ADDED', NULL, NULL, 'serverside test', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Obcaecati provident, quasi quae recusandae magni, tempore illo voluptatem nam voluptatibus ducimus quod minima ullam. Obcaecati, modi. Ducimus perspiciatis quaerat iure, atque magni porro natus ill', NULL, 'export-pdf-demo.pdf', NULL, 'PT BPR BKK Kebumen(Perseroda)', NULL, NULL, NULL, NULL, '', NULL);

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
(39, 145, 140, 60, 'preggg', '', '2024-05-31 16:05:20'),
(40, 146, 140, 57, 'preg', '', '2024-05-31 16:06:46');

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
(12, 143, 47);

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
(14, 143, 62, 'Lorem Ipsum', 'Lorem ipsum 55', '2024-06-11');

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

--
-- Dumping data untuk tabel `tiket_temp`
--

INSERT INTO `tiket_temp` (`id_temp`, `no_tiket`, `user_id`, `judul`, `perihal`, `file`, `nama`, `kategori`, `tags`) VALUES
(219, 'TIC00032024060004', 60, 'link', 'https://datatables.net/examples/server_side/simple.html', '', 'PT BPR BKK Purwokerto(Perseroda)', '', '');

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
(47, 'Supervisor 2', 'Supervisor 2', 'spv2', '$2y$10$3fmu3UaUBtwMUn/ibOqgwO0h36GrfFrAwjP/GAHxYZfIPJOJPYdgC', 9, 'Y', '2024-05-31', '2024-06-07 15:03:35'),
(48, 'Helpdesk 1', 'Ajeng', 'ajeng', '$2y$10$yMDEbxjjlh4oNXdZJw1om.SmuYMqFSzqLe3vycjiXnVFnZVXh7Fli', 2, 'Y', '2024-05-31', '2024-05-31 15:08:48'),
(49, 'Helpdesk 1', 'Novi', 'novi', '$2y$10$61Gvfbmfq/xELLugqweR3.ITjxqoazOT478NP8hl9ND44iSRndaWO', 2, 'Y', '2024-05-31', '2024-05-31 15:08:57'),
(50, 'Helpdesk 2', 'Ayu', 'ayu', '$2y$10$CBazdGZC3pDGBYv0WVS6WuqgRQW2SNVhGotgSoR09dL3CpXRLn4Tq', 2, 'Y', '2024-05-31', '2024-06-10 16:50:28'),
(51, 'Helpdesk 2', 'Chintya', 'chintya', '$2y$10$dfuc4GUWd8UHDVpKSDO2z.9G./SV5svEYIThkIB6.ZCFvWnjz6zkC', 2, 'Y', '2024-05-31', '2024-05-31 15:09:26'),
(52, 'Helpdesk 3', 'Eva', 'eva', '$2y$10$R8oQzXHI8pnwusrmXCTX3e9FWIjfvqgXFekk1yqJNhXIAkFDTY.n.', 2, 'Y', '2024-05-31', '2024-06-07 15:02:57'),
(53, 'Helpdesk 3', 'Ina', 'ina', '$2y$10$39stpYd9tIjV.jrW/ffns.bVwZtKOyDqHHdZkSSwTmaNjTAS.1Qsi', 2, 'Y', '2024-05-31', '2024-05-31 15:09:55'),
(54, 'Helpdesk 4', 'Nita', 'nita', '$2y$10$lGRwZfprphMBSECfyzb/SOLIyxsTw2THLpKO5WYjUeq41XBy0Nnz.', 2, 'Y', '2024-05-31', '2024-05-31 15:10:43'),
(55, 'Helpdesk 4', 'Luthfi', 'luthfi', '$2y$10$JEjAMFVKUPfcwhAh5mNlAOzSOKQmSmXL/2iVnTWN6NS4BRzke6wMu', 2, 'Y', '2024-05-31', '2024-06-11 12:26:06'),
(56, 'Helpdesk 4', 'Khabibah', 'Khabibah', '$2y$10$kMOcFV1oh9PL5kGxkARcW.0q6iPYOTTe/M4OjztfR2dRory9yTwRa', 2, 'Y', '2024-05-31', '2024-05-31 15:10:18'),
(57, 'Supervisor', 'Supervisor', 'supervisor', '$2y$10$B2CATYduaY1k14AaFRVyP.m/rV5.yI4mj0.WXWt.Ud8P5oZMF1rQy', 3, 'Y', '2024-05-31', '2024-06-11 15:31:49'),
(58, 'Klien', 'PT BPR BKK Banjarharjo(Perseroda)', 'banjarharjo', '$2y$10$kTGlxi4xSlwGOuMW8xDSc.CparcG1uAK/YAIV4PU0trjX8oZ.YMVq', 1, 'Y', '2024-05-31', '2024-06-11 12:32:25'),
(59, 'Klien', 'PT BPR BKK Karangmalang(Perseroda)', 'karangmalang', '$2y$10$QNYfJEq8VLi6JCCBdywKjumU8rGIQnu9LU5AIcCobSyvXzauc6EWm', 1, 'Y', '2024-05-31', '2024-06-07 15:50:46'),
(60, 'Klien', 'PT BPR BKK Purwokerto(Perseroda)', 'purwokerto', '$2y$10$WniGIEgNUJA9Z/aNxOh3TO9oUtB9BAi9q3U8FYeqHHbTXTaV9Eywe', 1, 'Y', '2024-05-31', '2024-06-11 15:33:35'),
(61, 'Klien', 'PT BPR BKK Kab. Pekalongan(Perseroda)', 'pekalongan', '$2y$10$v7C/rY7SMvCOdS46NFs3jeZWtJbLmwImjBnw9KyHj0IM0fI3Useyu', 1, 'Y', '2024-05-31', '2024-06-06 09:52:09'),
(62, 'Implementator', 'Implementator PT MSO Purwokerto', 'implementator', '$2y$10$vAfqKnPDv/ymAIPib1NF2uhLZbnqWuJ6JN87f6T/Fq0A9n0axAoA2', 4, 'Y', '2024-05-31', '2024-06-07 15:04:58'),
(63, 'Support', 'Support PT MSO Purwokerto', 'support', '$2y$10$HEztd8wkl66Mpu2EIIRdpuFj/EBs57NLxZiZRGjc0Kg4M1kNpwoUu', 5, 'Y', '2024-05-31', '2024-05-31 15:05:31'),
(66, 'Klien', 'PT BPR BKK Kebumen(Perseroda)', 'kebumen', '$2y$10$8U34fAsqjj5IvjEe7CZgpeR.1.otC4xVr1F/cDHpSRCowoEUU4ffm', 1, 'Y', '2024-05-31', '2024-06-07 15:55:52'),
(68, 'Superadmin', 'Superadmin', 'superadmin', '$2y$10$tDJeFvFcChAeZWacIUOTxuSJp9HbObg3pagd3zZiHSj9EkGou79Iy', 6, 'Y', '2024-05-31', '2024-06-11 15:48:17');

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
  ADD PRIMARY KEY (`id_temp`),
  ADD UNIQUE KEY `no_tiket` (`no_tiket`);

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
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT untuk tabel `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `forward`
--
ALTER TABLE `forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT untuk tabel `klien`
--
ALTER TABLE `klien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `pelaporan`
--
ALTER TABLE `pelaporan`
  MODIFY `id_pelaporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reply`
--
ALTER TABLE `reply`
  MODIFY `id_reply` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `s_forward`
--
ALTER TABLE `s_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `t1_forward`
--
ALTER TABLE `t1_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `t2_forward`
--
ALTER TABLE `t2_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tiket_temp`
--
ALTER TABLE `tiket_temp`
  MODIFY `id_temp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
