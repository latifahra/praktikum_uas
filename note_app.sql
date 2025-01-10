-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2025 at 08:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `note_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `content_TEXT` varchar(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `content` text NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'Lainnya'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `title`, `content_TEXT`, `created_at`, `content`, `category`) VALUES
(4, 'Jumat, 10 Januari 2025', '', '2025-01-08 20:22:32', '1. uas praktek pemrograman web (individu)\r\n2. uas praktek bedah dan anesthesi (kelompok)\r\n', 'Schedule'),
(5, 'Radiologi II', '', '2025-01-08 20:22:43', '1. teori = mengerjakan latihan soal\r\n2. praktek = menyelesaikan project kelompok simulasi wiring diagram sinar-x dan laporannya', 'Tugas'),
(6, 'resep cookies', '', '2025-01-08 20:23:04', 'Bahan-bahan\r\n200 gram margarin.\r\n150 gram gula halus.\r\n3 butir kuning telur.\r\n30 gram cokelat bubuk.\r\n300 gram tepung terigu.\r\n25 gram tepung maizena.\r\n150 gram choco chips.\r\nBahan-bahan ini untuk choco chips cookies dengan berat 600 gram. \r\n\r\nCara Membuat\r\nLangkah 1\r\nAduk rata Terigu, maizena dan coklat bubuk untuk membuat cookie. Kemudian, ayak adonan tersebut.\r\n\r\nLangkah 2\r\nPanaskan oven dengan suhu 160° Celsius.\r\n\r\nLangkah 3\r\nKemudian, kocok margarin dan gula halus sampai lembut, masukkan telur satu persatu sambil terus kamu kocok.\r\n\r\nLangkah 4\r\nMasukkan susu bubuk dan campuran terigu sedikit demi sedikit sampai habis.\r\n\r\nLangkah 5\r\nCetak cookie secara perlahan menggunakan sendok untuk kamu letakkan di loyang yang sudah kamu semir margarin. Selanjutnya, hias cookie dengan choco chips. \r\n\r\nLangkah 6\r\nPanggang selama 15 menit, setelah dingin masukkan toples. Choco chips cookies siap kamu nikmati sebagai camilan. ', 'Ide'),
(7, 'Diagnostik II', '', '2025-01-08 20:23:18', '1. membuat makalah mengenai stress test sistem\r\n2. membuat laporan mengenai dental unit', 'Tugas'),
(8, 'uas teori', '', '2025-01-08 20:23:31', '1. lab klinik = materi ppt\r\n2. diagnostik II = latian soal\r\n3. kalibrasi = PERMENKES no.54 tahun 2015\r\n4. bedah anesthesi = materi ppt', 'Belajar'),
(9, 'quotes', '', '2025-01-08 21:25:37', 'whatever you do, do it for the glory of god!', 'Lainnya'),
(10, 'kutipan', '', '2025-01-09 06:22:07', '\"so remember me, i will remember you\"', 'Penting'),
(14, 'mengisi waktu luang', '', '2025-01-09 15:54:42', '1. membuat kerajinan tangan\r\n2. olahraga\r\n3. berkebun\r\n4. mengambil kursus online\r\n5. memasak\r\n6. membuat scrapbook simple', 'Ide');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'ifah', 'latifar@gmail.com', '35ff9bedc47b72c0eaeb0cef9c63d75f7b35e0efc5d3733e54392831bcd2b898');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
