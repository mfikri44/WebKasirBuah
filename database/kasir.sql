-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 08 Apr 2023 pada 13.24
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail_penjualan` int(11) NOT NULL,
  `no_invoice` char(9) NOT NULL,
  `kode_produk` char(9) NOT NULL,
  `harga` mediumint(9) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_detail_penjualan`, `no_invoice`, `kode_produk`, `harga`, `qty`) VALUES
(480, 'A000005', 'P0027', 350000, 2),
(481, 'A000006', 'P0002', 440000, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hutang`
--

CREATE TABLE `hutang` (
  `id_penjualan` int(11) NOT NULL,
  `no_invoice` char(10) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_kasir` int(11) NOT NULL,
  `kode_pelanggan` char(9) NOT NULL,
  `total_bayar` mediumint(9) NOT NULL,
  `uang_muka` mediumint(9) NOT NULL,
  `kekurangan` mediumint(9) NOT NULL,
  `diskon` mediumint(9) NOT NULL,
  `total_bayar_diskon` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hutang_pelanggan`
--

CREATE TABLE `hutang_pelanggan` (
  `id_hutang_pelanggan` int(11) NOT NULL,
  `no_invoice` char(10) NOT NULL,
  `cicilan_bulan` mediumint(9) NOT NULL,
  `pembayaran_hutang` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hutang_supplier`
--

CREATE TABLE `hutang_supplier` (
  `id_hutang_supplier` int(11) NOT NULL,
  `kode_supplier` char(9) NOT NULL,
  `tanggal_nota` date NOT NULL,
  `tanggal_input` datetime NOT NULL DEFAULT current_timestamp(),
  `jenis_transaksi` varchar(10) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `hutang_supplier`
--

INSERT INTO `hutang_supplier` (`id_hutang_supplier`, `kode_supplier`, `tanggal_nota`, `tanggal_input`, `jenis_transaksi`, `nominal`) VALUES
(1, 'SP0001', '2023-04-03', '2023-04-03 15:33:00', 'Kredit', 400000),
(2, 'SP0002', '2023-04-03', '2023-04-03 18:40:00', 'Kredit', 200000),
(3, 'SP0003', '2023-04-10', '2023-04-03 18:40:00', 'Debit', 200000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `id_kt_produk` int(11) NOT NULL,
  `nama_kt_produk` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori_produk`
--

INSERT INTO `kategori_produk` (`id_kt_produk`, `nama_kt_produk`) VALUES
(1, 'Apel'),
(2, 'Anggur'),
(3, 'Pear'),
(4, 'Jeruk'),
(5, 'Kurma'),
(6, 'Kelengkeng');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_aktivitas` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `aktivitas` varchar(300) NOT NULL,
  `id_pengguna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_aktivitas`, `waktu`, `aktivitas`, `id_pengguna`) VALUES
(842, '2023-04-03 15:33:00', 'Edit hutang supplier kode supplier #SP0001 ', 1),
(843, '2023-04-03 16:02:00', 'Input penjualan No Invoice #A000006 ', 2),
(844, '2023-04-03 18:40:00', 'Input hutang supplier kode supplier #SP0002 ', 1),
(845, '2023-04-03 18:40:00', 'Input hutang supplier kode supplier #SP0003 ', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `kode_pelanggan` char(9) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `no_telp` char(14) NOT NULL,
  `alamat_pelanggan` varchar(50) NOT NULL,
  `jenis_kelamin` int(11) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `kode_pelanggan`, `nama_pelanggan`, `no_telp`, `alamat_pelanggan`, `jenis_kelamin`, `tanggal_lahir`, `status`) VALUES
(24, 'PN0001', 'M. Basri', '-', 'Jl. Majapahit', 1, '2023-03-30', 1),
(25, 'PN0002', 'Kembar Jaya', '-', '', 2, '0000-00-00', 1),
(26, 'PN0003', 'M. Deny', '-', 'Gang Baru', 2, '0000-00-00', 1),
(27, 'PN0004', 'Alam', '-', '-', 1, '2023-04-04', 1),
(28, 'PN0005', 'Bu Busro', '-', '', 2, '0000-00-00', 1),
(29, 'PN0007', 'M. Nurul', '-', '', 2, '0000-00-00', 1),
(30, 'PN0008', 'M. Muh', '-', '', 1, '0000-00-00', 1),
(31, 'PN0009', 'Citra Buah', '-', '', 2, '0000-00-00', 1),
(32, 'PN0010', 'MS', '-', '', 2, '0000-00-00', 1),
(33, 'PN0011', 'M. Nur Fais', '-', '', 2, '0000-00-00', 1),
(34, 'PN0012', 'Sigit', '-', '', 1, '0000-00-00', 1),
(35, 'PN0013', 'Meisy Gubug', '-', '', 2, '0000-00-00', 1),
(36, 'PN0014', 'Meisy Kr. Awen', '-', '', 2, '0000-00-00', 1),
(37, 'PN0015', 'Meisy Azizah', '-', '', 2, '0000-00-00', 1),
(38, 'PN0016', 'Bu Jono', '-', '', 2, '0000-00-00', 1),
(39, 'PN0017', 'M. Ali', '-', '', 1, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran_hutang`
--

CREATE TABLE `pembayaran_hutang` (
  `id_pembayaran_hutang` int(11) NOT NULL,
  `no_invoice` varchar(50) NOT NULL,
  `nominal` mediumint(9) NOT NULL,
  `cicilan_ke` mediumint(9) NOT NULL,
  `tanggal_pembayaran` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `kode_pengguna` char(9) NOT NULL,
  `nama_pengguna` varchar(50) NOT NULL,
  `email` varchar(35) NOT NULL,
  `no_telp` char(14) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `level` varchar(10) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `kode_pengguna`, `nama_pengguna`, `email`, `no_telp`, `foto`, `username`, `password`, `level`, `status`) VALUES
(1, 'U001', 'Admin', 'admin@gmail.com', '0', 'user.png', 'admin_grosir', '827ccb0eea8a706c4c34a16891f84e7b', 'Admin', 1),
(2, 'U002', 'Kasir', 'kasir@gmail.com', '0', 'user.png', 'kasir_grosir', '827ccb0eea8a706c4c34a16891f84e7b', 'Kasir', 1),
(3, 'U003', 'Dimas Ari', 'arimurti95.sd@gmail.com', '082322230343', 'marshel.png', 'manajer_penjualan', '827ccb0eea8a706c4c34a16891f84e7b', 'Manajer', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `no_invoice` char(10) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_kasir` int(11) NOT NULL,
  `kode_pelanggan` char(9) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `ongkos_kirim` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `total_transaksi` int(11) NOT NULL,
  `tipe_pembayaran` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `no_invoice`, `tanggal`, `id_kasir`, `kode_pelanggan`, `total_bayar`, `ongkos_kirim`, `diskon`, `total_transaksi`, `tipe_pembayaran`) VALUES
(252, 'A000001', '2023-04-03 08:21:35', 2, '3', 380000, 0, 0, 380000, ''),
(253, 'A000002', '2023-04-03 08:21:38', 2, '3', 390000, 0, 5000, 385000, ''),
(255, 'A000004', '2023-04-03 08:21:42', 2, 'PN0001', 1250000, 0, 0, 1250000, ''),
(275, 'A000005', '2023-04-03 10:02:19', 2, 'PN0002', 700000, 80000, 20000, 760000, ''),
(276, 'A000006', '2023-04-03 09:02:00', 2, '3', 880000, 100000, 30000, 950000, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `kode_produk` char(9) NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `satuan` varchar(5) NOT NULL,
  `kategori_produk` int(11) NOT NULL,
  `stok_produk` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `keterangan_produk` text NOT NULL,
  `tanggal_produk` date NOT NULL,
  `gambar_produk` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `kode_produk`, `nama_produk`, `satuan`, `kategori_produk`, `stok_produk`, `supplier`, `harga_beli`, `harga_jual`, `keterangan_produk`, `tanggal_produk`, `gambar_produk`) VALUES
(1, 'P0001', 'Kurma Barari', 'Dus', 5, 1, 2, 450000, 470000, '', '2023-03-17', 'gambar_default.png'),
(2, 'P0002', 'Kurma 1/4', 'Dus', 5, 6, 1, 420000, 440000, '', '2023-03-17', 'gambar_default.png'),
(3, 'P0003', 'Kurma 1/2', 'Dus', 5, 12, 2, 570000, 590000, '', '2023-03-17', 'gambar_default.png'),
(4, 'P0004', 'Kurma Curah', 'Dus', 5, 12, 2, 240000, 260000, '', '2023-03-17', 'gambar_default.png'),
(5, 'P0005', 'Kelengkeng M', 'keran', 6, 9, 1, 350000, 390000, '', '2023-03-17', 'gambar_default.png'),
(6, 'P0006', 'Lemon', 'Dus', 4, 1, 2, 450000, 470000, '', '2023-03-17', 'gambar_default.png'),
(7, 'P0007', 'Jeruk Santang Daun', 'Dus', 4, 14, 2, 135000, 150000, '', '2023-03-17', 'gambar_default.png'),
(8, 'P0008', 'Jeruk Wogam Krj', 'keran', 4, 0, 2, 220000, 250000, '', '2023-03-17', 'gambar_default.png'),
(9, 'P0009', 'Jeruk Wogam Dus', 'Dus', 4, 21, 2, 220000, 250000, '', '2023-03-17', 'gambar_default.png'),
(10, 'P0010', 'Jeruk Santang Birma', 'keran', 4, 10, 2, 170000, 185000, '', '2023-03-17', 'gambar_default.png'),
(11, 'P0011', 'Pear Yali 80', 'Dus', 3, 10, 1, 315000, 330000, '', '2023-03-17', 'gambar_default.png'),
(12, 'P0012', 'Pear Xiangli', 'Dus', 3, 4, 1, 250000, 280000, '', '2023-03-17', 'gambar_default.png'),
(13, 'P0013', 'Pear Sweet', 'Dus', 3, 11, 1, 275000, 300000, '', '2023-03-17', 'gambar_default.png'),
(14, 'P0014', 'Pear Century', 'Dus', 3, 19, 1, 350000, 380000, '', '2023-03-17', 'gambar_default.png'),
(15, 'P0015', 'Apel Premium', 'Dus', 1, 1, 1, 500000, 530000, '', '2023-03-17', 'gambar_default.png'),
(16, 'P0016', 'Apel USA', 'Dus', 1, 4, 2, 680000, 710000, '', '2023-03-17', 'gambar_default.png'),
(17, 'P0017', 'Apel Fuji 100 BB', 'Dus', 1, 1, 2, 360000, 390000, '', '2023-03-17', 'gambar_default.png'),
(18, 'P0018', 'Apel Fuji 88', 'Dus', 1, 1, 2, 360000, 390000, '', '2023-03-17', 'gambar_default.png'),
(19, 'P0019', 'Apel Fuji 100 T', 'Dus', 1, 10, 1, 400000, 420000, '', '2023-03-17', 'gambar_default.png'),
(20, 'P0020', 'Apel Fuji 88 T', 'Dus', 1, 10, 1, 400000, 420000, '', '2023-03-17', 'gambar_default.png'),
(21, 'P0021', 'Anggur Peru XL', 'keran', 2, 9, 2, 400000, 425000, '', '2023-03-17', 'gambar_default.png'),
(22, 'P0022', 'Anggur Peru J', 'keran', 2, 0, 1, 450000, 470000, '', '2023-03-17', 'gambar_default.png'),
(23, 'P0023', 'Anggur Hijau', 'keran', 2, 2, 2, 700000, 750000, '', '2023-03-17', 'gambar_default.png'),
(24, 'P0024', 'Anggur Autumn', 'keran', 2, 0, 1, 800000, 850000, '', '2023-03-17', 'gambar_default.png'),
(25, 'P0025', 'Anggur China', 'keran', 2, 0, 2, 250000, 275000, '', '2023-03-17', 'gambar_default.png'),
(26, 'P0026', 'Anggur Australi', 'keran', 2, 14, 1, 460000, 500000, '', '2023-03-17', 'gambar_default.png'),
(27, 'P0027', 'Apel Fuji 100 Fresh', 'Dus', 1, 3, 1, 320000, 350000, '', '2023-03-19', 'gambar_default.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_aplikasi`
--

CREATE TABLE `profil_aplikasi` (
  `id` int(11) NOT NULL,
  `nama_aplikasi` varchar(30) NOT NULL,
  `nama_toko` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telp` char(14) NOT NULL,
  `website` varchar(50) NOT NULL,
  `logo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `profil_aplikasi`
--

INSERT INTO `profil_aplikasi` (`id`, `nama_aplikasi`, `nama_toko`, `alamat`, `no_telp`, `website`, `logo`) VALUES
(0, 'Grosir Buah', 'Grosir Buah Segar Bu Dody', 'Jalan Soekarno Hatta No. 9A. Pedurungan Semarang', '085728884914', '-', 'shop.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `kode_supplier` char(9) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `no_telp` char(14) NOT NULL,
  `alamat_supplier` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `kode_supplier`, `nama_supplier`, `no_telp`, `alamat_supplier`, `status`) VALUES
(1, 'SP0001', 'LMU', '-', '', 1),
(2, 'SP0002', 'Bandar Buah', '-', '', 1),
(3, 'SP0003', 'PKJ', '-', '', 1),
(4, 'SP0004', 'Indofresh', '-', '', 1),
(5, 'SP0005', 'Putra Berlian', '-', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail_penjualan`);

--
-- Indeks untuk tabel `hutang`
--
ALTER TABLE `hutang`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD UNIQUE KEY `no_invoice` (`no_invoice`);

--
-- Indeks untuk tabel `hutang_pelanggan`
--
ALTER TABLE `hutang_pelanggan`
  ADD PRIMARY KEY (`id_hutang_pelanggan`),
  ADD UNIQUE KEY `no_invoice` (`no_invoice`);

--
-- Indeks untuk tabel `hutang_supplier`
--
ALTER TABLE `hutang_supplier`
  ADD PRIMARY KEY (`id_hutang_supplier`);

--
-- Indeks untuk tabel `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`id_kt_produk`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_aktivitas`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `kode_pelanggan` (`kode_pelanggan`);

--
-- Indeks untuk tabel `pembayaran_hutang`
--
ALTER TABLE `pembayaran_hutang`
  ADD PRIMARY KEY (`id_pembayaran_hutang`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD UNIQUE KEY `no_invoice` (`no_invoice`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD UNIQUE KEY `kode_produk` (`kode_produk`);

--
-- Indeks untuk tabel `profil_aplikasi`
--
ALTER TABLE `profil_aplikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`),
  ADD UNIQUE KEY `kode_supplier` (`kode_supplier`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=482;

--
-- AUTO_INCREMENT untuk tabel `hutang`
--
ALTER TABLE `hutang`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `hutang_pelanggan`
--
ALTER TABLE `hutang_pelanggan`
  MODIFY `id_hutang_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `hutang_supplier`
--
ALTER TABLE `hutang_supplier`
  MODIFY `id_hutang_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id_kt_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_aktivitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=846;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `pembayaran_hutang`
--
ALTER TABLE `pembayaran_hutang`
  MODIFY `id_pembayaran_hutang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
