-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2017 at 06:43 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `andoeng`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alat`
--

CREATE TABLE IF NOT EXISTS `tbl_alat` (
`id_alat` int(5) NOT NULL,
  `nama_alat` varchar(30) NOT NULL,
  `biaya_sewa` int(10) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `stock` int(5) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_alat`
--

INSERT INTO `tbl_alat` (`id_alat`, `nama_alat`, `biaya_sewa`, `satuan`, `stock`, `foto`) VALUES
(16, 'TAS', 25000, 'Unit', 15, 'images (1).jpg'),
(17, 'SENTER', 15000, 'Unit', 20, 'Vioslite-LED-Night-Light-Flashlight-COB-Work-Lights-font-b-Maintenance-b-font-Lights-Outdoor-font.jpg'),
(18, 'TONGKAT', 30000, 'Unit', 4, 'trekking-pole-300x300.jpg'),
(19, 'TENDA', 45000, 'Unit', 30, '2-160106152521114 - Copy.jpg'),
(20, 'KOMPOR', 20000, 'Unit', 20, '434452_ffa4c50c-f7f6-11e4-858d-9ffa49bc7260.jpg'),
(21, 'HAMMOCK', 35000, 'Unit', 4, 'FB_IMG_1506859081653.jpg'),
(22, 'SLEEPING BAG', 30000, 'Unit', 20, 'sleeping bag.jpg'),
(23, 'MANTEL', 20000, 'Unit', 15, 'Outdoor-Camping-Hiking-Alat-font-b-Travel-b-font-Portabel-Terintegrasi-Panjang-Hujan-Hujan-Mantel-Perlindungan.jpg'),
(24, 'KOMPAS', 20000, 'Unit', 4, '1106779_1f12ac2f-2e52-4d8c-92c8-f1bc7a46247d.jpg'),
(25, 'MATRAS', 15000, 'Unit', 4, 'Matras_camping.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kembali`
--

CREATE TABLE IF NOT EXISTS `tbl_kembali` (
`id_kembali` int(10) NOT NULL,
  `id_keranjang` int(10) NOT NULL,
  `jml_sewa` int(5) NOT NULL,
  `jml_kembali` int(5) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_kembali`
--

INSERT INTO `tbl_kembali` (`id_kembali`, `id_keranjang`, `jml_sewa`, `jml_kembali`, `date`) VALUES
(19, 200, 1, 1, '2017-10-06 09:46:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_keranjang`
--

CREATE TABLE IF NOT EXISTS `tbl_keranjang` (
`id_keranjang` int(10) NOT NULL,
  `id_pinjam` int(10) NOT NULL,
  `id_alat` int(10) NOT NULL,
  `biaya_sewa` int(10) NOT NULL,
  `jml_sewa` int(5) NOT NULL,
  `id_user` int(10) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=203 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_keranjang`
--

INSERT INTO `tbl_keranjang` (`id_keranjang`, `id_pinjam`, `id_alat`, `biaya_sewa`, `jml_sewa`, `id_user`, `status`) VALUES
(200, 80, 17, 15000, 1, 19, 'Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pinjam`
--

CREATE TABLE IF NOT EXISTS `tbl_pinjam` (
`id_pinjam` int(10) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `jml_hari` int(5) NOT NULL,
  `metode` varchar(15) NOT NULL,
  `total_biaya` int(10) NOT NULL,
  `jml_bayar` int(10) NOT NULL,
  `status` varchar(30) NOT NULL,
  `id_user` int(10) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pinjam`
--

INSERT INTO `tbl_pinjam` (`id_pinjam`, `tgl_mulai`, `tgl_akhir`, `jml_hari`, `metode`, `total_biaya`, `jml_bayar`, `status`, `id_user`, `date`) VALUES
(80, '2017-10-07', '2017-10-09', 2, 'Bayar Langsung', 30000, 30000, 'Lunas', 19, '2017-10-06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
`id_user` int(5) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `hp` varchar(16) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `level` varchar(10) NOT NULL,
  `date_join` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `nama_lengkap`, `hp`, `alamat`, `email`, `username`, `password`, `level`, `date_join`) VALUES
(3, '', '', '', '', 'admin', '1212', 'admin', '2017-08-04 01:13:36'),
(19, 'mery', '087847584834', 'sibolga', 'merryandaniy@gmail.com', 'mery', '1234', 'user', '2017-10-06 09:32:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_alat`
--
ALTER TABLE `tbl_alat`
 ADD PRIMARY KEY (`id_alat`);

--
-- Indexes for table `tbl_kembali`
--
ALTER TABLE `tbl_kembali`
 ADD PRIMARY KEY (`id_kembali`);

--
-- Indexes for table `tbl_keranjang`
--
ALTER TABLE `tbl_keranjang`
 ADD PRIMARY KEY (`id_keranjang`);

--
-- Indexes for table `tbl_pinjam`
--
ALTER TABLE `tbl_pinjam`
 ADD PRIMARY KEY (`id_pinjam`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
 ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_alat`
--
ALTER TABLE `tbl_alat`
MODIFY `id_alat` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `tbl_kembali`
--
ALTER TABLE `tbl_kembali`
MODIFY `id_kembali` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tbl_keranjang`
--
ALTER TABLE `tbl_keranjang`
MODIFY `id_keranjang` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=203;
--
-- AUTO_INCREMENT for table `tbl_pinjam`
--
ALTER TABLE `tbl_pinjam`
MODIFY `id_pinjam` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
