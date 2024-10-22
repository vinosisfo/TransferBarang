-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Des 2018 pada 14.20
-- Versi server: 10.1.31-MariaDB
-- Versi PHP: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `septian`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang`
--

CREATE TABLE `tb_barang` (
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `jenis_barang` varchar(50) NOT NULL,
  `kategori_barang` varchar(50) NOT NULL,
  `stok_barang` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_barang`
--

INSERT INTO `tb_barang` (`kode_barang`, `nama_barang`, `jenis_barang`, `kategori_barang`, `stok_barang`) VALUES
('KDB000002', 'barang 2', 'jenis barang 2', 'kategori barang 2', '98.00'),
('KDB000003', 'barang 2 b', 'a', 'b', '132.00'),
('KDB000004', 'tes barang 3', 'tes barang 3', 'tes barang 3', '45.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_penerimaan`
--

CREATE TABLE `tb_detail_penerimaan` (
  `id_dtpenerimaan` int(11) NOT NULL,
  `id_dtpengiriman` int(11) NOT NULL,
  `kode_penerimaan` varchar(10) NOT NULL,
  `jumlah_terima` decimal(18,2) NOT NULL,
  `jumlah_NG` decimal(18,2) NOT NULL,
  `jumlah_sisa` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_detail_penerimaan`
--

INSERT INTO `tb_detail_penerimaan` (`id_dtpenerimaan`, `id_dtpengiriman`, `kode_penerimaan`, `jumlah_terima`, `jumlah_NG`, `jumlah_sisa`) VALUES
(1, 1, 'KPN000001', '7.00', '3.00', '0.00'),
(2, 2, 'KPN000001', '13.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_pengiriman`
--

CREATE TABLE `tb_detail_pengiriman` (
  `id_dtpengiriman` int(11) NOT NULL,
  `kode_pengiriman` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `jumlah_barang_kirim` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_detail_pengiriman`
--

INSERT INTO `tb_detail_pengiriman` (`id_dtpengiriman`, `kode_pengiriman`, `kode_barang`, `jumlah_barang_kirim`) VALUES
(3, 'KPG000002', 'KDB000002', '10.00'),
(4, 'KPG000002', 'KDB000003', '12.00'),
(5, 'KPG000002', 'KDB000004', '13.00'),
(6, 'KPG000003', 'KDB000002', '12.00'),
(7, 'KPG000003', 'KDB000003', '13.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_retur`
--

CREATE TABLE `tb_detail_retur` (
  `id_dtretur` int(11) NOT NULL,
  `kode_retur` varchar(10) NOT NULL,
  `id_dtpengiriman` int(11) NOT NULL,
  `jumlah_retur` decimal(18,2) NOT NULL,
  `keterangan_retur` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_detail_retur`
--

INSERT INTO `tb_detail_retur` (`id_dtretur`, `kode_retur`, `id_dtpengiriman`, `jumlah_retur`, `keterangan_retur`) VALUES
(1, 'KRT000001', 1, '2.00', 'tes retur');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_penerimaan`
--

CREATE TABLE `tb_penerimaan` (
  `kode_penerimaan` varchar(10) NOT NULL,
  `kode_pengiriman` varchar(10) NOT NULL,
  `tanggal_terima` date NOT NULL,
  `diterima_oleh` varchar(10) NOT NULL,
  `status_terima` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_penerimaan`
--

INSERT INTO `tb_penerimaan` (`kode_penerimaan`, `kode_pengiriman`, `tanggal_terima`, `diterima_oleh`, `status_terima`) VALUES
('KPN000001', 'KPG000001', '2018-12-28', 'KUS000001', 'SELESAI');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengiriman`
--

CREATE TABLE `tb_pengiriman` (
  `kode_pengiriman` varchar(10) NOT NULL,
  `kode_subcont` varchar(10) NOT NULL,
  `tanggal_kirim` date NOT NULL,
  `perkiraan_tanggal_tiba` date NOT NULL,
  `created_by` varchar(10) NOT NULL,
  `status_pengiriman` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_pengiriman`
--

INSERT INTO `tb_pengiriman` (`kode_pengiriman`, `kode_subcont`, `tanggal_kirim`, `perkiraan_tanggal_tiba`, `created_by`, `status_pengiriman`) VALUES
('KPG000002', 'KSB000003', '2018-12-27', '2018-12-31', 'KUS000001', 'SELESAI'),
('KPG000003', 'KSB000002', '2018-12-29', '2018-12-31', 'KUS000001', 'BARU');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_retur`
--

CREATE TABLE `tb_retur` (
  `kode_retur` varchar(10) NOT NULL,
  `tanggal_retur` date NOT NULL,
  `diterima_oleh` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_retur`
--

INSERT INTO `tb_retur` (`kode_retur`, `tanggal_retur`, `diterima_oleh`) VALUES
('KRT000001', '2018-12-28', 'KUS000001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_subcont`
--

CREATE TABLE `tb_subcont` (
  `kode_subcont` varchar(10) NOT NULL,
  `nama_subcont` varchar(50) NOT NULL,
  `alamat_subcont` varchar(200) NOT NULL,
  `no_tlp` varchar(13) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_subcont`
--

INSERT INTO `tb_subcont` (`kode_subcont`, `nama_subcont`, `alamat_subcont`, `no_tlp`, `email`) VALUES
('KSB000002', 'Pt. 2 edit', 'alamat pt 2 edit', '12345678', 'a@mail.com'),
('KSB000003', 'pt. 3', 'tes ', '8998989898989', 'a');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `kode_supplier` varchar(10) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `no_tlp` varchar(13) NOT NULL,
  `email` varchar(50) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `keterangan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `kode_user` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(35) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`kode_user`, `username`, `password`, `level`) VALUES
('KUS000001', 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'ADMIN PPIC'),
('KUS000002', 'kabag', 'b66dc44cd9882859d84670604ae276e6', 'ADMIN GUDANG'),
('KUS000003', 'gudang', '01cfcd4f6b8770febfb40cb906715822', 'GUDANG'),
('KUS000004', 'pimpinan', 'cdaeb1282d614772beb1e74c192bebda', 'PIMPINAN');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indeks untuk tabel `tb_detail_penerimaan`
--
ALTER TABLE `tb_detail_penerimaan`
  ADD PRIMARY KEY (`id_dtpenerimaan`);

--
-- Indeks untuk tabel `tb_detail_pengiriman`
--
ALTER TABLE `tb_detail_pengiriman`
  ADD PRIMARY KEY (`id_dtpengiriman`);

--
-- Indeks untuk tabel `tb_detail_retur`
--
ALTER TABLE `tb_detail_retur`
  ADD PRIMARY KEY (`id_dtretur`);

--
-- Indeks untuk tabel `tb_penerimaan`
--
ALTER TABLE `tb_penerimaan`
  ADD PRIMARY KEY (`kode_penerimaan`);

--
-- Indeks untuk tabel `tb_pengiriman`
--
ALTER TABLE `tb_pengiriman`
  ADD PRIMARY KEY (`kode_pengiriman`);

--
-- Indeks untuk tabel `tb_retur`
--
ALTER TABLE `tb_retur`
  ADD PRIMARY KEY (`kode_retur`);

--
-- Indeks untuk tabel `tb_subcont`
--
ALTER TABLE `tb_subcont`
  ADD PRIMARY KEY (`kode_subcont`);

--
-- Indeks untuk tabel `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`kode_supplier`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`kode_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_detail_penerimaan`
--
ALTER TABLE `tb_detail_penerimaan`
  MODIFY `id_dtpenerimaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_detail_pengiriman`
--
ALTER TABLE `tb_detail_pengiriman`
  MODIFY `id_dtpengiriman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_detail_retur`
--
ALTER TABLE `tb_detail_retur`
  MODIFY `id_dtretur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
