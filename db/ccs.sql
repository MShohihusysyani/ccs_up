-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Agu 2024 pada 07.04
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
(36, 'C6 - C6'),
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
(59, 'Deposito - Master Deposito (Posting Bunga Deposito Dan Biaya Transaksi Deposito)'),
(60, 'Deposito - Posting Deposito'),
(61, 'Deposito - Data Deposito'),
(62, 'Deposito - Bilyet Deposito'),
(63, 'Deposito - Trans Dep'),
(64, 'Deposito - Bunga Deposito'),
(65, 'Nasabah - Master Nasabah (Aktifkan CIF, Merger CIF)'),
(66, 'Nasabah - Merger CIF'),
(67, 'Nasabah - Data Nasabah'),
(68, 'Nasabah - Tarik Data Nasabah'),
(69, 'Nasabah - Error SLIK'),
(70, 'Nasabah - Request Core Banking System'),
(71, 'Nasabah - Error MBS'),
(72, 'Nasabah - LAPBUL Koreksi OJK/KAP'),
(73, 'Lapbul - Error LAPBUL'),
(74, 'Exim - Exim'),
(75, 'MBS ADMIN - Mbs Admin (Reset Password, Pengaktifan User, Setting Distribusi Angsuran)'),
(76, 'User - Aktivasi User'),
(77, 'User - Mutasi User'),
(78, 'User - Reset Password'),
(79, 'User - Perubahan Ijin Transaksi User'),
(80, 'User - Data User'),
(81, 'User - Registrasi Komputer'),
(82, 'MBS Report - MBS Report'),
(83, 'Akuntansi - Akuntansi'),
(84, 'COA - COA (Pembukaan Kode Perkiraan, Pengaktifan Kode Perkiraan)'),
(85, 'COA - Pembukaan Kode Perkiraan'),
(86, 'COA - Penambahan Kode Perkiraan'),
(87, 'COA - Perubahan Kode Perkiraan'),
(88, 'COA - Koreksi Coa'),
(89, 'COA - Penonaktifan Kode Perkiraan'),
(90, 'ABA - ABA'),
(91, 'Inventaris - Inventaris'),
(92, 'Kantor - Penambahan Kantor '),
(93, 'MBS Online - MBS Online'),
(94, 'SMS Banking - SMS Banking'),
(95, 'Jaringan - Jaringan'),
(96, 'Website - Website'),
(97, 'MBS Otorisasi - MBS Otorisasi'),
(98, 'TKS - TKS'),
(99, 'Obox - Obox'),
(100, 'Virtual - Virtual Account'),
(101, 'MBS Publikasi - MBS Publikasi'),
(102, 'QRIS - QRIS'),
(103, 'PPOB - PPOB'),
(104, 'Lain-Lain - Lain-Lain'),
(105, 'WA Blast - WA Blast'),
(106, 'Undian - Undian');

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `forward`
--

CREATE TABLE `forward` (
  `id_forward` int(11) NOT NULL,
  `pelaporan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(23, '0001', 'PT BPR BKK Banjarharjo (Perseroda)', 58),
(24, '0002', 'PT BPR BKK Karangmalang (Perseroda)', 59),
(35, '0003', 'PT BPR BKK Purwokerto (Perseroda)', 60),
(40, '0006', 'PT BPR BKK Kab.Pekalongan (Perseroda)', 61),
(41, '0007', 'PT BPR BKK Kebumen (Perseroda)', 66),
(42, '0008', 'PT. BPR Arta Utama', 101),
(43, '0009', 'PT. BPR Mentari Terang', 102),
(44, '0010', 'PT. BPR Sinar Garuda Prima', 103),
(45, '0011', 'PT. BPR Wirosari Ijo', 104),
(46, '0012', 'PT BPR BKK Blora (Perseroda)', 105),
(47, '0013', 'Kospin Sekartama', 106),
(48, '0014', 'PT BPR BKK Jepara (Perseroda)', 107),
(49, '0015', 'PT. BPR Kusuma Sumbing', 108),
(50, '0016', 'PT BPR BKK Grogol (Perseroda)', 109),
(52, '0018', 'PT. BPR Artha Guna Mandiri', 112),
(53, '0021', 'PT. BPR Mitradana Madani', 114),
(54, '0022', 'PT. BPR Mitra Rakyat Riau', 115),
(55, '0024', 'PT. BPR Sejahtera Artha Sembada', 116),
(56, '0029', 'PT BPR BKK Purbalingga (Perseroda)', 117),
(57, '0030', 'PT BPR Bank Sukoharjo (Perseroda)', 118),
(58, '0031', 'PT. BPR DP Taspen', 119),
(59, '0032', 'PT BPR Artha Tanah Mas', 120),
(60, '0033', 'PT. BPR Gunung Kinibalu', 121),
(61, '0034', 'PERUMDA BPR Bank Brebes', 122),
(62, '0035', 'PT. BPR Artha Puspa Mega', 123),
(63, '0036', 'PT BPR Binalanggeng', 124),
(64, '0037', 'PT. BPR Pedungan', 125),
(65, '0039', 'PT BPR Bank Pekalongan (Perseroda)', 126),
(66, '0041', 'PT BPR BKK Kab. Tegal (Perseroda)', 127),
(67, '0042', 'PT BPR Bank Purwa Artha (Perseroda)', 128),
(68, '0043', 'PT. BPR Usaha Rakyat', 129),
(69, '0045', 'PT BPR BKK Kota Tegal (Perseroda)', 130),
(70, '0046', 'PT. BPR DP Taspen Jateng', 131),
(71, '0047', 'PT.BPR Arthama Cerah', 132),
(72, '0048', 'Kospin Surya Artha', 133),
(73, '0049', 'PT. BPR Sumber Arta', 134),
(74, '0051', 'PT BPR Bank Pasar Kota Tegal', 135),
(75, '0052', 'PD BPR Bank Pemalang', 136),
(76, '0059', 'PT BPR Bank Tegal Gotong Royong (Perseroda)', 137),
(77, '0061', 'PT. BPR Enggal Makmur Adi Santoso', 138),
(78, '0062', 'Kospin Jujur Artha Mandiri', 139),
(79, '0063', 'PT. BPR Bina Maju Usaha', 140),
(80, '0064', 'PT.BPR Muhadi Setia Budi', 141),
(81, '0065', 'Kospin Rejo Agung Sukses', 142),
(82, '0066', 'SMK 2 Pekalongan', 143),
(83, '0068', 'PT.BPR Dana Rakyat Sentosa', 144),
(84, '0069', 'PT.BPR Dana Mitra Sentosa', 145),
(85, '0070', 'PT. BPR Surya Kusuma Kranggan', 146),
(86, '0071', 'PT. BPR Milala', 147),
(87, '0072', 'PT. BPR Guna Rakyat', 148),
(88, '0073', 'Koperasi Tri Capital Investama 1', 150),
(89, '0074', 'PT. BPR Duta Pasundan', 151),
(90, '0075', 'PT. BPR Mitratama Arthabuana', 152),
(91, '0077', 'PT BPR BKK Kota Semarang (Perseroda)', 153),
(92, '0078', 'Koperasi Tri Capital Investama 2', 154),
(93, '0079', 'PT BPR BKK Ungaran (Perseroda)', 155),
(94, '0080', 'PT BPR BKK Wonosobo (Perseroda)', 156),
(95, '0081', 'Perumda BPR Artha Perwira', 157),
(96, '0082', 'PT. BPR Delanggu Raya', 158),
(97, '0083', 'Koperasi Jembar Maju Bersama', 159),
(98, '0084', 'PT.  BPR BKK Tulung (Perseroda)', 160),
(99, '0085', 'PERUMDA BPR Marunting Sejahtera', 161),
(100, '0086', 'PT. BPT Kurnia Sewon', 162),
(101, '0087', 'PT. BPR Cipatujah Jabar Perseroda', 163),
(102, '0088', 'KSP Bougenvill', 164),
(103, '0090', 'PT BPR TCI', 165),
(104, '0092', 'PT. BPR BKK Kota Magelang (Perseroda)', 166),
(105, '0093', 'PT. BPR Shinta Daya', 167),
(106, '0094', 'Kospin Wijaya Kusuma', 168),
(107, '0095', 'PT BPR Eleska Artha', 169),
(108, '0096', 'PT. BPR Arta Mas Surakarta', 170),
(109, '0097', 'PT. BPR BKK Batang', 171),
(110, '0098', 'PT. BPR BKK GALUH', 172);

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
  `nama` varchar(100) NOT NULL,
  `handle_by` varchar(100) DEFAULT NULL,
  `handle_by2` varchar(100) DEFAULT NULL,
  `handle_by3` varchar(100) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `waktu_approve` date DEFAULT NULL,
  `catatan_finish` text NOT NULL,
  `file_finish` text DEFAULT NULL,
  `has_rated` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `s_forward`
--

CREATE TABLE `s_forward` (
  `id_forward` int(11) NOT NULL,
  `pelaporan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `tanggal` date DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'PENDING',
  `tanggal_finish` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t2_forward`
--

CREATE TABLE `t2_forward` (
  `id_forward` int(11) NOT NULL,
  `pelaporan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `judul` text NOT NULL,
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
  `perihal` text NOT NULL,
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
  `username` varchar(50) NOT NULL,
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
(47, 'Supervisor 2', 'Aling', 'aling', '$2y$10$3fmu3UaUBtwMUn/ibOqgwO0h36GrfFrAwjP/GAHxYZfIPJOJPYdgC', 9, 'Y', '2024-05-31', '2024-07-27 11:40:07'),
(48, 'Helpdesk', 'Ajeng', 'ajeng', '$2y$10$yMDEbxjjlh4oNXdZJw1om.SmuYMqFSzqLe3vycjiXnVFnZVXh7Fli', 2, 'Y', '2024-05-31', '2024-05-31 15:08:48'),
(50, 'Helpdesk', 'Ayu', 'ayu', '$2y$10$CBazdGZC3pDGBYv0WVS6WuqgRQW2SNVhGotgSoR09dL3CpXRLn4Tq', 2, 'Y', '2024-05-31', '2024-07-31 15:33:25'),
(52, 'Helpdesk', 'Eva', 'eva', '$2y$10$R8oQzXHI8pnwusrmXCTX3e9FWIjfvqgXFekk1yqJNhXIAkFDTY.n.', 2, 'Y', '2024-05-31', '2024-07-23 15:16:42'),
(54, 'Helpdesk', 'Nita', 'nita', '$2y$10$lGRwZfprphMBSECfyzb/SOLIyxsTw2THLpKO5WYjUeq41XBy0Nnz.', 2, 'Y', '2024-05-31', '2024-06-26 16:11:57'),
(55, 'Helpdesk', 'Luthfi', 'luthfi', '$2y$10$JEjAMFVKUPfcwhAh5mNlAOzSOKQmSmXL/2iVnTWN6NS4BRzke6wMu', 2, 'Y', '2024-05-31', '2024-07-24 08:09:48'),
(57, 'Supervisor 1', 'Khabibah', 'Khabibah', '$2y$10$B2CATYduaY1k14AaFRVyP.m/rV5.yI4mj0.WXWt.Ud8P5oZMF1rQy', 3, 'Y', '2024-05-31', '2024-08-02 13:51:36'),
(58, 'Klien', 'PT BPR BKK Banjarharjo (Perseroda)', 'banjarharjo', '$2y$10$kTGlxi4xSlwGOuMW8xDSc.CparcG1uAK/YAIV4PU0trjX8oZ.YMVq', 1, 'Y', '2024-05-31', '2024-08-13 08:59:53'),
(59, 'Klien', 'PT BPR BKK Karangmalang (Perseroda)', 'karangmalang', '$2y$10$QNYfJEq8VLi6JCCBdywKjumU8rGIQnu9LU5AIcCobSyvXzauc6EWm', 1, 'Y', '2024-05-31', '2024-08-13 09:00:10'),
(60, 'Klien', 'PT BPR BKK Purwokerto (Perseroda)', 'purwokerto', '$2y$10$WniGIEgNUJA9Z/aNxOh3TO9oUtB9BAi9q3U8FYeqHHbTXTaV9Eywe', 1, 'Y', '2024-05-31', '2024-08-13 09:00:27'),
(61, 'Klien', 'PT BPR BKK Kab.Pekalongan (Perseroda)', 'pekalongan', '$2y$10$v7C/rY7SMvCOdS46NFs3jeZWtJbLmwImjBnw9KyHj0IM0fI3Useyu', 1, 'Y', '2024-05-31', '2024-08-13 09:00:46'),
(62, 'Implementator', 'Diki', 'diki', '$2y$10$vAfqKnPDv/ymAIPib1NF2uhLZbnqWuJ6JN87f6T/Fq0A9n0axAoA2', 4, 'Y', '2024-05-31', '2024-08-02 08:17:50'),
(66, 'Klien', 'PT BPR BKK Kebumen (Perseroda)', 'kebumen', '$2y$10$8U34fAsqjj5IvjEe7CZgpeR.1.otC4xVr1F/cDHpSRCowoEUU4ffm', 1, 'Y', '2024-05-31', '2024-08-13 09:01:19'),
(68, 'Superadmin', 'Indri', 'indri', '$2y$10$tDJeFvFcChAeZWacIUOTxuSJp9HbObg3pagd3zZiHSj9EkGou79Iy', 6, 'Y', '2024-05-31', '2024-08-13 08:33:11'),
(78, 'Implementator', 'Indra', 'indra', '$2y$10$8etE1d5OKw9.Gbyz58eyjuGIfU.O0MyFH0r6XZ8oY4bQek.ujQChK', 4, 'Y', '2024-06-28', '2024-08-01 16:11:57'),
(79, 'Implementator', 'Arif', 'arif', '$2y$10$Vbg7uz5gPOgYBEcSJUt2Jef5ox//0yFYSCtS60mPzC2irwkmbSPzW', 4, 'Y', '2024-07-01', '2024-07-27 10:50:00'),
(80, 'Helpdesk', 'Zelly', 'zelly', '$2y$10$w3ERUHDBVufTAMNPzcYdou5vlkWRrUykQxsVwJqCQkzOVIOYc2iZm', 2, 'Y', '2024-07-27', '2024-07-27 10:33:02'),
(81, 'Helpdesk', 'Sandy', 'sandy', '$2y$10$rL5AZzoyO6rtAgWClQov7euzNspS5sP3UQydqwWDPLnBIR5cDZZcu', 2, 'Y', '2024-07-27', '2024-07-27 10:39:29'),
(82, 'Helpdesk', 'Bachtiar', 'bachtiar', '$2y$10$YUjsywxMapJMpjKbhRBFmeAFAHMK/RkkFE2z4.ALkcUgy33e3/.Wa', 2, 'Y', '2024-07-27', '2024-07-27 10:39:52'),
(83, 'Helpdesk', 'Ratna', 'ratna', '$2y$10$LVJvul7rFMEbi5eI6VQW2ula76hh2N4EMJWsRfiRMKCnjGt3DLuNe', 2, 'Y', '2024-07-27', '2024-07-27 10:40:08'),
(84, 'Helpdesk', 'Tiwi', 'tiwi', '$2y$10$yQJeyW.RDO6Kn7jVKR8JAeeXsbPrsuD.Z4iECH2JGwd88D0Z0MAaW', 2, 'Y', '2024-07-27', '2024-07-27 10:40:28'),
(85, 'Helpdesk', 'Herda', 'herda', '$2y$10$UWx/hvX6PZW29q2WhLCOGuVRu9uIDJGMTpr16Hgpmv/h1hatjP4Zy', 2, 'Y', '0000-00-00', '2024-07-27 10:40:44'),
(86, 'Helpdesk', 'Isna', 'isna', '$2y$10$RwDEjUmYW.auaIC6Db2YGuPVXXSoM2RqLLii7cZENEhUkAKUsMxNa', 2, 'Y', '2024-07-27', '2024-07-27 10:40:57'),
(87, 'Helpdesk', 'Zida', 'zida', '$2y$10$PN9tJOUeKlb0hqcP.xeN.OHHzlQqttVXA7FYhdrKr8t8qqASR2tbS', 2, 'Y', '2024-07-27', '2024-07-27 10:41:19'),
(88, 'Helpdesk', 'Norma', 'norma', '$2y$10$sm5kMLxhTaw9BYfF1pkn1eel00qOiMPixy7AK.ScIcEVErhjjbKPm', 2, 'Y', '2024-07-27', '2024-07-27 10:41:33'),
(89, 'Helpdesk', 'Dettia', 'dettia', '$2y$10$HApXZCz.1SBLh228GLzzneTVnKOOAKPXkPd8dl8Fz9jA..AWJkMiS', 2, 'Y', '2024-07-27', '2024-07-27 11:01:43'),
(90, 'Implementator', 'Mumu', 'mumu', '$2y$10$a10JPBaZBcEyfmecbyKNt.2zb2PiBV2be8gDLY7/7.NgiRkAyngZu', 4, 'Y', '2024-07-27', '2024-07-27 10:51:48'),
(91, 'Implementator', 'Wasis', 'wasis', '$2y$10$BgNRkRD/zdzTYOSn49CAlu7F1.mH3X65/0slBywf2SiTiUnvNkT2i', 4, 'Y', '2024-07-27', '2024-07-27 10:53:34'),
(92, 'Implementator', 'Dwi', 'dwi', '$2y$10$hP325C8eu.Fxj4AxK2xMCubwTiPM1raY2pwAwwe8Wz2GwLmfNM9/C', 4, 'Y', '2024-07-27', '2024-07-27 10:54:18'),
(93, 'Implementator', 'Rijal', 'rijal', '$2y$10$pXM4mb2Kg3iS7jY4pd3oX.u17tpNZ707DkqVdFnfaFaW0QswKiiz6', 4, 'Y', '2024-07-27', '2024-07-27 10:55:18'),
(94, 'Implementator', 'Kiky', 'kiky', '$2y$10$MaB54/lHgfpG5NB4PGoqreskhl1H4TchyI7GHWoVzb4DRLTbU9G.S', 4, 'Y', '2024-07-27', '2024-07-27 11:02:44'),
(95, 'Implementator', 'Jaman', 'jaman', '$2y$10$mfg4t7FeWCFn.xcZwxbYa.9HAYT.tJr8L6ts633Ld4Bds3IalkX5C', 4, 'Y', '2024-07-27', '2024-07-27 10:57:05'),
(96, 'Supervisor 1', 'Dettia', 'dettiaspv', '$2y$10$EzfEeeAW7c9ecyuyhGKLDOfqn9bK1E7T0g8QeoL.sWwYOJR4Zs8o.', 3, 'Y', '2024-07-27', '2024-07-27 11:03:33'),
(97, 'Supervisor 1', 'Norma', 'normaspv', '$2y$10$K.YfvCf/L/aaWGHfzeKiC.TLhT4KTYbSCp2Y5QJG7ZMWk/1Q1wSM2', 3, 'Y', '2024-07-27', '2024-07-27 11:05:16'),
(98, 'Superadmin', 'Novi', 'novi', '$2y$10$a28QjMimNT3y9rZiXmkHTOqnWsmE2ndNtkLXqPrPRpUlYlmJoIhbW', 6, 'Y', '2024-07-27', '2024-08-13 11:18:56'),
(99, 'Superadmin', 'Muti', 'muti', '$2y$10$TjmDQQw/JYMs.fRUA.6bsefuXIfIGzh.3dtTwG5efkfhrW/LTVF/y', 6, 'Y', '2024-07-27', '2024-07-27 11:07:52'),
(101, 'Klien', 'PT. BPR Arta Utama', 'artautama', '$2y$10$S9XpmzbDl/D2jBCuPhIvi.3qIsGGB4hFtDCKrRqLqAY2TIUdamqFS', 1, 'Y', '2024-08-02', '2024-08-13 09:02:29'),
(102, 'Klien', 'PT. BPR Mentari Terang', 'mentariterang', '$2y$10$AUlBIJ2KbdUgXuIoTE71MOKaVfh/HxHbBZo0DL4uxAIpGJ/BbgtTy', 1, 'Y', '2024-08-02', '2024-08-13 09:02:54'),
(103, 'Klien', 'PT. BPR Sinar Garuda Prima', 'sinargarudaprima', '$2y$10$PHOrGjejFr0jdXzQZlkB0ObsDdO16s/G3soLdAntKzt9ek8AAmdPy', 1, 'Y', '2024-08-02', '2024-08-13 09:03:31'),
(104, 'Klien', 'PT. BPR Wirosari Ijo', 'wirosariijo', '$2y$10$.cuv3nB.lIydSFhPENEVmufgBieQNpzxss9jMX/i1.GnGZtOsJPDy', 1, 'Y', '2024-08-02', '2024-08-13 09:03:52'),
(105, 'Klien', 'PT BPR BKK Blora (Perseroda)', 'blora', '$2y$10$hOpF.ArXNQJPAEX.LjZMT.G5qxi4684vDrv6PyQwFt8NYOx4Eg12m', 1, 'Y', '2024-08-02', '2024-08-13 09:04:15'),
(106, 'Klien', 'Kospin Sekartama', 'sekartama', '$2y$10$jgQlX0GNz0/cqXaeZjATxO/MTNBRhlvdZl82ksogu7rvYN5l1ASuu', 1, 'Y', '2024-08-02', '2024-08-13 09:04:37'),
(107, 'Klien', 'PT BPR BKK Jepara (Perseroda)', 'jepara', '$2y$10$MqnibtwmduWuDg63c9pUt.htUXpCBo/XXSg2M6UyyVruarVuFiUga', 1, 'Y', '2024-08-02', '2024-08-13 09:04:57'),
(108, 'Klien', 'PT. BPR Kusuma Sumbing', 'kusumasumbing', '$2y$10$PsRo6ECqNTPuVWV8qAnIJ.o7glngrf9UIAIorVMat8nYOeJBreKIO', 1, 'Y', '2024-08-02', '2024-08-13 09:05:27'),
(109, 'Klien', 'PT BPR BKK Grogol (Perseroda)', 'grogol', '$2y$10$C1Si1w.4W4dEWP.tMuAgoOjtrwxOMN3RL8bL1i9c6gWmyz1cyPudi', 1, 'Y', '2024-08-02', '2024-08-13 09:05:51'),
(112, 'Klien', 'PT. BPR Artha Guna Mandiri', 'agm', '$2y$10$nd6nh8D2biftGHUX9JOgP.m2ouEjWDecUjSzDPMdPtfcWunAs3TWS', 1, 'Y', '2024-08-13', '2024-08-13 09:06:08'),
(114, 'Klien', 'PT. BPR Mitradana Madani', 'mitradana', '$2y$10$HYJr1xITPxAupaPdgxSqru5.vsaEVfruxn4c0fMwwrV4vjUIosjL6', 1, 'Y', '2024-08-13', '2024-08-13 09:06:43'),
(115, 'Klien', 'PT. BPR Mitra Rakyat Riau', 'mitrarakyatriau', '$2y$10$iWRtQIlNtEH2.SvvyVeXXeeKJZai.wmX5xE6cozMsoYuFQ9adhRQa', 1, 'Y', '2024-08-13', '2024-08-13 09:07:03'),
(116, 'Klien', 'PT. BPR Sejahtera Artha Sembada', 'arthasembada', '$2y$10$sX3cxLXu84zxtZ0ASfxxEe4//JRBtEM3QGpnet0KS2g4hC9T1sLPG', 1, 'Y', '2024-08-13', '2024-08-13 09:07:24'),
(117, 'Klien', 'PT BPR BKK Purbalingga (Perseroda)', 'purbalingga', '$2y$10$pgVpwN.wBhJBKoSemeRmruEUy7xsHOptH.dD2LyyrDabd0JPK7TvG', 1, 'Y', '2024-08-13', '2024-08-13 09:07:46'),
(118, 'Klien', 'PT BPR Bank Sukoharjo (Perseroda)', 'banksukoharjo', '$2y$10$d.2qW13ehNxttLhfjP1f..C3kdgcxqI5mZtYh7Op3DTJBTxiozSq.', 1, 'Y', '2024-08-13', '2024-08-13 09:08:15'),
(119, 'Klien', 'PT. BPR DP Taspen', 'dptaspen', '$2y$10$YvV7u0RgmgGETskM2t8jTuCMuK4YiDXF1/zsKI9gn1BifcRjrfPpW', 1, 'Y', '2024-08-13', '2024-08-13 09:08:45'),
(120, 'Klien', 'PT BPR Artha Tanah Mas', 'arthatanahmas', '$2y$10$d3dPNZt7Eb2Gzsjn.yHtvepHiGflGO83zLfygxl51xcr6W99L0Ucq', 1, 'Y', '2024-08-13', '2024-08-13 09:09:15'),
(121, 'Klien', 'PT. BPR Gunung Kinibalu', 'gunungkinibalu', '$2y$10$mBnk.E5QkuMI1ylj4rY2wu8Txvj8wIiaObqK3tea3Jvim1VXglHGu', 1, 'Y', '2024-08-13', '2024-08-13 09:09:36'),
(122, 'Klien', 'PERUMDA BPR Bank Brebes', 'bankbrebes', '$2y$10$WkSUoKTPQZpHey/9S4.hpuUJITC2QDCOZQS/prAnhjOcDVyN6NHLi', 1, 'Y', '2024-08-13', '2024-08-13 09:09:56'),
(123, 'Klien', 'PT. BPR Artha Puspa Mega', 'arthapuspamega', '$2y$10$c.EPOsSmDyrKpLHEc4jH.uJtSrqxrlXEfiRHyDsFnpTvEhHdDwPAa', 1, 'Y', '2024-08-13', '2024-08-13 09:10:18'),
(124, 'Klien', 'PT BPR Binalanggeng', 'binalanggeng', '$2y$10$WjDZqvEqW3.XjDwrEwLqP.maddppmoc6soVLAF6hWxm2EljO0iPue', 1, 'Y', '2024-08-13', '2024-08-13 09:10:38'),
(125, 'Klien', 'PT. BPR Pedungan', 'pedungan', '$2y$10$1VnDAqxgy46ruRPYonjjXuKu6Xa3N24tFQM8s4DFV/LScvUEec.Ym', 1, 'Y', '2024-08-13', '2024-08-13 09:10:58'),
(126, 'Klien', 'PT BPR Bank Pekalongan (Perseroda)', 'bankpekalongan', '$2y$10$dQtDnO5NMJ5p8zhnUsxxROI7YD78YseV4RwxGqBMP5ZE/8qOsTBKu', 1, 'Y', '2024-08-13', '2024-08-13 09:11:22'),
(127, 'Klien', 'PT BPR BKK Kab. Tegal (Perseroda)', 'kabtegal', '$2y$10$btKvHp52liRMaoW0OrFOIOFwwlrOPi7vYup8h0ssW38m8zXYaM3fW', 1, 'Y', '2024-08-13', '2024-08-13 10:29:59'),
(128, 'Klien', 'PT BPR Bank Purwa Artha (Perseroda)', 'purwaartha', '$2y$10$QhOX5jMkii8p7KIaKPKVYuAqWH/.KPo7goJGMHE3e1jVIpOX.igby', 1, 'Y', '2024-08-13', '2024-08-13 10:31:40'),
(129, 'Klien', 'PT. BPR Usaha Rakyat', 'usaharakyat', '$2y$10$lYnJrJQpIOIOJ91hqsu7PeoW7ZXdVtA66opS0VjrhkAbcFyi8Gpve', 1, 'Y', '2024-08-13', '2024-08-13 10:33:10'),
(130, 'Klien', 'PT BPR BKK Kota Tegal (Perseroda)', 'kotategal', '$2y$10$1nfemXm6wYL9TgWPwryN9ecwCAHI.EeBy4FtjGVt1R1z/Dttx1PRO', 1, 'Y', '2024-08-13', '2024-08-13 10:34:33'),
(131, 'Klien', 'PT. BPR DP Taspen Jateng', 'dptaspenjateng', '$2y$10$/HLrNQNqsWNtylN7bewflOKpXnAwBaTG5uFAvEJGHSddQzt0e6FkG', 1, 'Y', '2024-08-13', '2024-08-13 10:36:18'),
(132, 'Klien', 'PT.BPR Arthama Cerah', 'arthamacerah', '$2y$10$uz0vXkMzEWhWRO8Z0sHRP.HFLWD0VWuXbdpEzJX2/WpNRF6hnJxmq', 1, 'Y', '2024-08-13', '2024-08-13 10:37:53'),
(133, 'Klien', 'Kospin Surya Artha', 'suryaartha', '$2y$10$2nITxuXbT/jP.zwdh0sOXOr0nKWmtZkFSMzfQ8R5BAdXuUK.jerNy', 1, 'Y', '2024-08-13', '2024-08-13 10:39:21'),
(134, 'Klien', 'PT. BPR Sumber Arta', 'sumberarta', '$2y$10$Q1b3ppGcPCRKStQCFRS3iutqZ57QOTm/CLuJ27uPWjvqL3keTjLte', 1, 'Y', '2024-08-13', '2024-08-13 10:40:56'),
(135, 'Klien', 'PT BPR Bank Pasar Kota Tegal', 'pasarkotategal', '$2y$10$vdzYkIzuD7Ai9bBCvE0HOukGGo1oCt3uwTwoUCcETSQEL4cQKjfyO', 1, 'Y', '2024-08-13', '2024-08-13 10:43:03'),
(136, 'Klien', 'PD BPR Bank Pemalang', 'bankpemalang', '$2y$10$IiTkBHiuyBut8mTYZppw7eFc9Db2l1yhK87RogI9EweF1jkRkLtue', 1, 'Y', '2024-08-13', '2024-08-13 10:44:28'),
(137, 'Klien', 'PT BPR Bank Tegal Gotong Royong (Perseroda)', 'banktegal', '$2y$10$skD/gnkYbNbp1HX6KqECSuLqslReHf.gmN0A7wX1lNuEP9akxfkHq', 1, 'Y', '2024-08-13', '2024-08-13 10:49:12'),
(138, 'Klien', 'PT. BPR Enggal Makmur Adi Santoso', 'enggalmakmur', '$2y$10$lzl4I8WRshS3Y1VKO7p8Au.bnNiJykbR1kv2Crp2DaEpg7yUWg5m2', 1, 'Y', '2024-08-13', '2024-08-13 10:50:51'),
(139, 'Klien', 'Kospin Jujur Artha Mandiri', 'arthamandiri', '$2y$10$RsV8kNuDe2gBDyoIwQHu5uYldVY9nDJzb.HifkbltODRsMRfAtcka', 1, 'Y', '2024-08-13', '2024-08-13 10:53:56'),
(140, 'Klien', 'PT. BPR Bina Maju Usaha', 'binamajuusaha', '$2y$10$pG.0Vq3oNZW1mtCjfKKJSO5f0ryFQfzawT4uJRFSj58BXEEKpUTxC', 1, 'Y', '2024-08-13', '2024-08-13 10:55:20'),
(141, 'Klien', 'PT.BPR Muhadi Setia Budi', 'muhadi', '$2y$10$mBt3J8hZ9J8wsyjBsjalRu/4bVeadeXeZ89cSB0UKy1AdeAtOWRsm', 1, 'Y', '2024-08-13', '2024-08-13 10:58:56'),
(142, 'Klien', 'Kospin Rejo Agung Sukses', 'rejoagung', '$2y$10$AxkQ8bWlyqnP4oy4Upqs3O8h3ZAAIWN4a9.7YecWW.fdxTzYFArnW', 1, 'Y', '2024-08-13', '2024-08-13 11:00:28'),
(143, 'Klien', 'SMK 2 Pekalongan', 'smk2pekalongan', '$2y$10$2LQnTTrqTVCPigTEkXwYy.h4dWdWZTF7o6W4y4AQd5A47tk8PisPi', 1, 'Y', '2024-08-13', '2024-08-13 11:01:53'),
(144, 'Klien', 'PT.BPR Dana Rakyat Sentosa', 'drs', '$2y$10$XBtxnfBo5vQHRGzRofZjNe2Tnld09ZJl96Dlc4Rujx19Y68uS44Ee', 1, 'Y', '2024-08-13', '2024-08-13 11:03:09'),
(145, 'Klien', 'PT.BPR Dana Mitra Sentosa', 'dms', '$2y$10$dE8L5398nZajXe28tZNY7eX/M3Re1i6enmB5QqLyMH2D73Vlbo..2', 1, 'Y', '2024-08-13', '2024-08-13 11:04:28'),
(146, 'Klien', 'PT. BPR Surya Kusuma Kranggan', 'suryakusuma', '$2y$10$eN75b9kY9jSNV5GbbmTuGus345yxU8Esw26J8YmAOy2kA2nY3oqq6', 1, 'Y', '2024-08-13', '2024-08-13 11:06:23'),
(147, 'Klien', 'PT. BPR Milala', 'milala', '$2y$10$olLUeWudKckMfuw9LkK9deL0ATAKE7O/JPgWFWtje7zO/xj5zdw4O', 1, 'Y', '2024-08-13', '2024-08-13 11:08:48'),
(148, 'Klien', 'PT. BPR Guna Rakyat', 'gunarakyat', '$2y$10$MxD0wT4KHhxH.mPthZRfxexN4o5lsSe18hO4dmhM8vVum19Uv6L9a', 1, 'Y', '2024-08-13', '2024-08-13 11:10:04'),
(150, 'Klien', 'Koperasi Tri Capital Investama 1', 'tci1', '$2y$10$IMj.GDy/1wQZGqc3j.cryuXH.FwXLm/moN10vXOReJrFcdmQnWyIC', 1, 'Y', '2024-08-13', '2024-08-13 11:13:20'),
(151, 'Klien', 'PT. BPR Duta Pasundan', 'dutapasundan', '$2y$10$HxFtex/psOKpGuOSrPeuQOQ.kVHxtXaGuhhTJn7OdYOOgMsE7B7P2', 1, 'Y', '2024-08-13', '2024-08-13 11:15:26'),
(152, 'Klien', 'PT. BPR Mitratama Arthabuana', 'arthabuana', '$2y$10$uP1od3gPLs98OWgYrOl1Meg1OB0FLuxb3tSRmpSfMui2IqvD4oPK6', 1, 'Y', '2024-08-13', '2024-08-13 11:17:01'),
(153, 'Klien', 'PT BPR BKK Kota Semarang (Perseroda)', 'kotasemarang', '$2y$10$oB3LWrCzzcyLVGcQuDuhCea8sYJePBwZb/imi5qCoqd7FPP7EUXS2', 1, 'Y', '2024-08-13', '2024-08-13 11:18:35'),
(154, 'Klien', 'Koperasi Tri Capital Investama 2', 'tci2', '$2y$10$UlJp1jIFE.qTsvgM2dat/O1bFxyu2jAblIPn4a37HpTHqPAWXOf0e', 1, 'Y', '2024-08-13', '2024-08-13 11:21:26'),
(155, 'Klien', 'PT BPR BKK Ungaran (Perseroda)', 'ungaran', '$2y$10$mkcyQrV5d3sutDpGwjWCKOV22Zlah/0Im0MRnoAiIEdpLu9ZhRXM6', 1, 'Y', '2024-08-13', '2024-08-13 11:23:00'),
(156, 'Klien', 'PT BPR BKK Wonosobo (Perseroda)', 'wonosobo', '$2y$10$2AWICFoRUSXoXHD.5diH0OriW0M.efeyb2xtV2McE9a57c0iM04hu', 1, 'Y', '2024-08-13', '2024-08-13 11:24:28'),
(157, 'Klien', 'Perumda BPR Artha Perwira', 'arthaperwira', '$2y$10$WkK8R2jM5Q1KNRXrLUJZJesm7HfiMx1War/cNKigaLl3AeFnZtYPm', 1, 'Y', '2024-08-13', '2024-08-13 11:26:01'),
(158, 'Klien', 'PT. BPR Delanggu Raya', 'delangguraya', '$2y$10$2A9G6EwyKSCte6.hynO3UuEm0eDNlshdDOZtHipNtWtY.9lzKfAlS', 1, 'Y', '2024-08-13', '2024-08-13 11:28:02'),
(159, 'Klien', 'Koperasi Jembar Maju Bersama', 'jembarmajubersama', '$2y$10$/fs5QKDhUIcAJazPfxPK9.CmNPN3c13mB5cvNgZpQO1DgqTBmNjKi', 1, 'Y', '2024-08-13', '2024-08-13 11:38:05'),
(160, 'Klien', 'PT.  BPR BKK Tulung (Perseroda)', 'tulung', '$2y$10$yti8zJ1YDVv54QnkOE8L1e5Tx2lQNvsN0Xderfo8CCtlqIYdPoDYK', 1, 'Y', '2024-08-13', '2024-08-13 11:39:27'),
(161, 'Klien', 'PERUMDA BPR Marunting Sejahtera', 'marunting', '$2y$10$CmLXMa/hKNq.K0/hiaB7QeN79jJFW3YBGTMs/3eDdsZ2/.7u2PHRu', 1, 'Y', '2024-08-13', '2024-08-13 11:40:48'),
(162, 'Klien', 'PT. BPT Kurnia Sewon', 'sewon', '$2y$10$m6v5V1a2ewEr7Bw31CA0juriwgSCzFEawL6L/xpObbu1TOBt6OIPO', 1, 'Y', '2024-08-13', '2024-08-13 11:42:25'),
(163, 'Klien', 'PT. BPR Cipatujah Jabar Perseroda', 'cipatujah', '$2y$10$kXi73/XiBRfI1qIUnEf.ouk.nFwk.NhyNOJH4TLYtN.UnnQkGMVrC', 1, 'Y', '2024-08-13', '2024-08-13 11:43:47'),
(164, 'Klien', 'KSP Bougenvill', 'bougenvill', '$2y$10$WkgnCx8bTB2oYDhFIiq87ec5b6twTgqQ1/lhJhBBsk8IjhrQaq2lm', 1, 'Y', '2024-08-13', '2024-08-13 11:45:11'),
(165, 'Klien', 'PT BPR TCI', 'tci', '$2y$10$UkLG4vvcz.uYvYRObwZEN.yKSMVdIix7Vd/Kg5JLX9zHJ99yPP3sK', 1, 'Y', '2024-08-13', '2024-08-13 11:46:47'),
(166, 'Klien', 'PT. BPR BKK Kota Magelang (Perseroda)', 'kotamagelang', '$2y$10$tAKDsCWwfblGJg8xkgJgbuS8aNvMYq8gt4slZpk7VVS.MUgmqeqzS', 1, 'Y', '2024-08-13', '2024-08-13 11:48:59'),
(167, 'Klien', 'PT. BPR Shinta Daya', 'shintadaya', '$2y$10$1kHi5s7g0be3QivP7UeXu.dh4RwVuloyLagVmcLYrfZiPAFmRPrd6', 1, 'Y', '2024-08-13', '2024-08-13 11:50:40'),
(168, 'Klien', 'Kospin Wijaya Kusuma', 'wijayakusuma', '$2y$10$Iq3bQhYDltY217sI1fnGUOI9m8NM9TDMzl8SrZntdWR.lIaFI7DfS', 1, 'Y', '2024-08-13', '2024-08-13 11:52:02'),
(169, 'Klien', 'PT BPR Eleska Artha', 'eleska', '$2y$10$.DRU1xSnJlNBl3qo4JUPV.a.lQGmJQVFAX7rgMaqJE93J3mNpMG5y', 1, 'Y', '2024-08-13', '2024-08-13 11:53:37'),
(170, 'Klien', 'PT. BPR Arta Mas Surakarta', 'artamassurakarta', '$2y$10$u4ayEQsyCJaxa.KBGk0RJO97B.QXdpbgHF9QAZesUlObbi9NeoSiS', 1, 'Y', '2024-08-13', '2024-08-13 11:55:14'),
(171, 'Klien', 'PT. BPR BKK Batang', 'batang', '$2y$10$AaMSsDGF2KyN3K1vLSIPROHwPmlQaS/vEzqmo8cKM4j1vZTRCdE8u', 1, 'Y', '2024-08-13', '2024-08-13 11:56:57'),
(172, 'Klien', 'PT. BPR BKK GALUH', 'galuh', '$2y$10$W5o/x1PCp6jFsK2EkXALPOth9GpPbjjeH5K/R58lT6TUGrVxEDd6S', 1, 'Y', '2024-08-13', '2024-08-13 11:58:22');

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
  ADD PRIMARY KEY (`id_pelaporan`),
  ADD KEY `status_ccs` (`status_ccs`);

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
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT untuk tabel `comment`
--
ALTER TABLE `comment`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT untuk tabel `forward`
--
ALTER TABLE `forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT untuk tabel `klien`
--
ALTER TABLE `klien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT untuk tabel `pelaporan`
--
ALTER TABLE `pelaporan`
  MODIFY `id_pelaporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reply`
--
ALTER TABLE `reply`
  MODIFY `id_reply` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `s_forward`
--
ALTER TABLE `s_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `t1_forward`
--
ALTER TABLE `t1_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `t2_forward`
--
ALTER TABLE `t2_forward`
  MODIFY `id_forward` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tiket_temp`
--
ALTER TABLE `tiket_temp`
  MODIFY `id_temp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
