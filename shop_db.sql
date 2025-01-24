-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Jan 2025 pada 08.34
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(3, 8, 'user3', 'user3@gmail.com', '098123771122', 'This Book Look So Nice');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(3, 4, 'Alfarisi', '081234578906', 'alfarisi@gmail.com', 'credit card', 'flat no. 221, Kedongodong, Jakarta,  - ', ', Holy Ghost (1) , Free Fall (1) , Principles Of Economic (1) ', 326000, '20-Jan-2025', 'completed'),
(4, 8, 'user3', '081342124422', 'user3@gmail.com', 'credit card', 'flat no. 2211, Tamrin, Bogor', ', Principles Of Economic (6) ', 360000, '20-Jan-2025', 'completed'),
(5, 8, 'rafah', '83116116351', 'user3@gmail.com', 'cash on delivery', 'flat no. 433, Prabowo, Surabaya', ', Boring Girls (24) , Principles Of Economic (12) ', 1800000, '20-Jan-2025', 'completed'),
(6, 8, 'braks bruks', '123994212', 'braksbruks@gmail.com', 'credit card', 'flat no. 123, Atang Senjaya, Denpasar', ', Be Well Bee (20) ', 1000000, '21-Jan-2025', 'completed'),
(7, 8, 'user3', '83115116351', 'kingmansalman@gmail.com', 'cash on delivery', 'flat no. 222, Atang Senjaya, Malang', ', Holy Ghost (11) ', 2310000, '21-Jan-2025', 'completed'),
(8, 1, 'Salman', '83115116351', 'kingmansalman@gmail.com', 'cash on delivery', 'flat no. 3, Samarin, Bandung', ', Holy Ghost (31) ', 6510000, '21-Jan-2025', 'completed'),
(9, 1, 'user2', '83115116351', 'kingmansalman@gmail.com', 'cash on delivery', 'flat no. 22, Kedongodong, Denpasar', ', Holy Ghost (30) ', 6300000, '21-Jan-2025', 'completed');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `stock` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `penulis`, `stock`, `price`, `image`) VALUES
(9, 'Holy Ghost', 'David J.S.', 31, 55000, 'holy_ghosts.jpg'),
(10, 'Free Fall', 'Peter Cawdron', 25, 56000, 'freefall.jpg'),
(11, 'Be Well Bee', '0', 24, 50000, 'be_well_bee.jpg'),
(12, 'Bash And Lucy', 'Lisa Cohn', 19, 55000, 'bash_and_lucy-2.jpg'),
(13, 'Principles Of Economic', 'Andrew Barkley', 60, 60000, 'economic.jpg'),
(14, 'Boring Girls', 'Sara Taylor', 20, 45000, 'boring_girls_a_novel.jpg'),
(17, 'Nighshade', 'Andrea Cremer', 40, 25000, 'nightshade.jpg'),
(18, 'Darknet', 'Matthew Mather', 16, 52000, 'darknet.jpg'),
(19, 'History Of Architecture', 'Ricahrd Phillips', 29, 45000, 'history_of_modern_architecture.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(1, 'Salman Alfarisi', 'kingmansalman@gmail.com', '03346657feea0490a4d4f677faa0583d', 'user'),
(2, 'admin1', 'admin1@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(4, 'alfarisi', 'alfarisi@gmail.com', '24063c9a2fa52080ed409825bd9e8a63', 'user'),
(7, 'admin2', 'admin2@gmail.com', 'c84258e9c39059a89ab77d846ddab909', 'admin'),
(8, 'user3', 'user3@gmail.com', '92877af70a45fd6a2ed7fe81e1236b78', 'user'),
(9, 'user4', 'user4@gmail.com', '3f02ebe3d7929b091e3d8ccfde2f3bc6', 'user'),
(10, 'user5', 'user5@gmail.com', 'ee11cbb19052e40b07aac0ca060c23ee', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
