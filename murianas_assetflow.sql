-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 26 Okt 2026 pada 07.17
-- Versi server: 10.11.19-MariaDB
-- Versi PHP: 8.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `murianas_assetflow`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `entity_type` varchar(50) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `asset_code` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `category_id` int(11) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'default_asset.png',
  `description` text DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_price` decimal(15,2) DEFAULT 0.00,
  `vendor` varchar(150) DEFAULT NULL,
  `management_type` enum('borrowable','assignable','fixed') DEFAULT 'borrowable',
  `condition_status` enum('good','fair','damaged','lost') DEFAULT 'good',
  `operational_status` enum('available','in_use','assigned','maintenance','archived') DEFAULT 'available',
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `is_archived` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `assets`
--

INSERT INTO `assets` (`id`, `asset_code`, `name`, `category_id`, `location_id`, `department_id`, `brand`, `model`, `serial_number`, `photo`, `description`, `purchase_date`, `purchase_price`, `vendor`, `management_type`, `condition_status`, `operational_status`, `price`, `is_archived`, `created_at`, `updated_at`) VALUES
(3, 'lap-02', 'lenovo thinkpad', 2, 1, 1, 'lenovo', 'thinkpad', '6356980', 'ASET-1791942357.png', NULL, '2026-10-16', 8.00, NULL, 'assignable', 'good', 'assigned', 0.00, 0, '2026-10-14 08:45:57', '2026-10-19 11:12:20'),
(4, 'lap-03', 'macbook m2 pro 2020', 2, 1, 1, 'apple', 'm2 pro', '826187361', 'ASET-1792335397.PNG', NULL, NULL, 0.00, NULL, 'borrowable', 'good', 'available', 0.00, 0, '2026-10-15 09:35:55', '2026-10-21 07:48:44'),
(5, 'lap-04', 'macbook m2 ', 2, 1, 1, 'apple', 'm2 ', '715813527', 'ASET-1792031953.png', NULL, '2024-02-15', 12000000.00, NULL, 'borrowable', 'good', 'in_use', 0.00, 0, '2026-10-15 09:39:13', '2026-10-15 09:41:32'),
(7, 'lap-01', 'macbook m1 pro 2020', 2, 1, NULL, 'apple', 'm1 pro', '76843112300', 'ASET-1792335382.png', NULL, NULL, 0.00, NULL, 'borrowable', 'good', 'available', 0.00, 0, '2026-10-19 09:10:13', '2026-10-21 04:05:48'),
(8, 'kP-05', 'iPAD', 2, 1, NULL, 'apple', 'ipad mini', '21351236151', 'ASET-1792383003.PNG', NULL, '2026-10-13', 8000000.00, NULL, 'borrowable', 'good', 'archived', 0.00, 1, '2026-10-19 11:10:03', '2026-10-19 11:10:15'),
(9, 'kP-10', 'hebat', 3, NULL, NULL, '', '', '', 'default_asset.png', NULL, NULL, 8000000.00, NULL, 'borrowable', 'good', 'available', 0.00, 0, '2026-10-20 11:21:49', '2026-10-20 11:21:49'),
(11, 'kP-19', 'afeaaw', 3, NULL, NULL, '', '', NULL, 'default_asset.png', NULL, NULL, 20000000.00, NULL, 'borrowable', 'good', 'available', 0.00, 0, '2026-10-20 11:24:32', '2026-10-20 11:24:32'),
(12, 'kp-20', 'Mini rush', 3, NULL, 1, '', '', NULL, 'ASET-1792553054.jpg', NULL, NULL, 0.00, NULL, 'borrowable', 'good', 'available', 0.00, 0, '2026-10-21 03:23:39', '2026-10-21 03:24:14'),
(13, 'IT-Lap 0001', 'TAB Infinix Pro', 2, 1, 1, 'INFINIX', '', NULL, 'ASET-1792556278.webp', NULL, '2015-11-20', 5000000.00, NULL, 'borrowable', 'good', 'available', 0.00, 0, '2026-10-21 04:17:58', '2026-10-21 04:17:58'),
(14, 'IT-Lap 0002', 'TAB Infinix Pro', 2, 1, 1, 'INFINIX', '', NULL, 'ASET-1792556278.webp', NULL, '2015-11-20', 5000000.00, NULL, 'borrowable', 'good', 'available', 0.00, 0, '2026-10-21 04:17:58', '2026-10-21 04:17:58'),
(15, 'IT-Lap 0003', 'TAB Infinix Pro', 2, 1, 1, 'INFINIX', '', NULL, 'ASET-1792556278.webp', NULL, '2015-11-20', 5000000.00, NULL, 'borrowable', 'good', 'available', 0.00, 0, '2026-10-21 04:17:58', '2026-10-21 04:17:58'),
(16, 'IT-Lap 0004', 'TAB Infinix Pro', 2, 1, 1, 'INFINIX', '', NULL, 'ASET-1792556278.webp', NULL, '2015-11-20', 5000000.00, NULL, 'borrowable', 'good', 'available', 0.00, 0, '2026-10-21 04:17:58', '2026-10-21 04:17:58'),
(17, 'IT-Lap 0005', 'TAB Infinix Pro', 2, 1, 1, 'INFINIX', '', NULL, 'ASET-1792556278.webp', NULL, '2015-11-20', 5000000.00, NULL, 'borrowable', 'good', 'available', 0.00, 0, '2026-10-21 04:17:58', '2026-10-21 04:17:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `asset_assignments`
--

CREATE TABLE `asset_assignments` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assigned_by` int(11) DEFAULT NULL,
  `assigned_at` datetime NOT NULL,
  `assigned_condition` enum('good','fair','damaged') NOT NULL,
  `assignment_note` text DEFAULT NULL,
  `returned_at` datetime DEFAULT NULL,
  `return_condition` enum('good','fair','damaged','lost') DEFAULT NULL,
  `status` enum('active','returned') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assigned_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('assigned','returned') NOT NULL DEFAULT 'assigned',
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `assignments`
--

INSERT INTO `assignments` (`id`, `asset_id`, `user_id`, `assigned_date`, `return_date`, `status`, `notes`) VALUES
(1, 3, 3, '2026-10-19', NULL, 'assigned', 'charger ddan tas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `borrowings`
--

CREATE TABLE `borrowings` (
  `id` int(11) NOT NULL,
  `borrowing_code` varchar(50) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `requested_start_at` datetime NOT NULL,
  `requested_end_at` datetime NOT NULL,
  `reason` text DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `actual_handover_at` datetime DEFAULT NULL,
  `handover_condition` enum('good','fair','damaged') DEFAULT NULL,
  `actual_return_at` datetime DEFAULT NULL,
  `return_condition` enum('good','fair','damaged','lost') DEFAULT NULL,
  `purpose` text NOT NULL,
  `admin_note` text DEFAULT NULL,
  `status` enum('pending','approved','ready_for_handover','in_use','returned','rejected','canceled') NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `borrowings`
--

INSERT INTO `borrowings` (`id`, `borrowing_code`, `asset_id`, `user_id`, `requested_start_at`, `requested_end_at`, `reason`, `approved_by`, `approved_at`, `actual_handover_at`, `handover_condition`, `actual_return_at`, `return_condition`, `purpose`, `admin_note`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BRW-20261015-2E47', 5, 3, '2026-10-16 09:40:00', '2026-10-18 09:40:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pinjemin kontol', NULL, 'in_use', '2026-10-15 09:40:57', '2026-10-15 09:42:50'),
(2, 'TRX-20261018-AC36', 4, 3, '2026-10-18 00:00:00', '2026-10-18 00:00:00', 'map', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 'canceled', '2026-10-18 22:28:23', '2026-10-19 11:15:52'),
(3, 'BRW-20261021-3056', 7, 3, '2026-10-21 10:49:00', '2026-10-25 10:49:00', 'bagus', NULL, NULL, '2026-10-21 04:05:38', NULL, '2026-10-21 04:05:48', NULL, 'bagus', NULL, 'returned', '2026-10-21 04:05:13', '2026-10-21 04:05:48'),
(4, 'BRW-20261021-6E90', 4, 3, '2026-10-21 14:48:00', '2026-10-28 14:48:00', 'pliss i need this', NULL, NULL, '2026-10-21 07:48:35', NULL, '2026-10-21 07:48:44', NULL, 'pliss i need this', NULL, 'returned', '2026-10-21 07:48:21', '2026-10-21 07:48:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'elektronik', 'barang dengan kategori elektronik\r\n', 1, '2026-10-12 15:55:57', '2026-10-12 15:55:57'),
(3, 'apaja', 'awoi', 1, '2026-10-19 11:10:55', '2026-10-19 11:10:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'IT Department', 'Departemen Teknologi Informasi', '2026-10-09 14:36:39', '2026-10-09 14:36:39'),
(2, 'backend dev', 'apaa', '2026-10-19 11:11:35', '2026-10-19 11:11:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `locations`
--

INSERT INTO `locations` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'rak elektronik lt 1', '', 1, '2026-10-13 09:02:03', '2026-10-13 09:02:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `maintenance_records`
--

CREATE TABLE `maintenance_records` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `problem_description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `cost` decimal(15,2) DEFAULT 0.00,
  `status` enum('ongoing','completed') NOT NULL DEFAULT 'ongoing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `maintenance_records`
--

INSERT INTO `maintenance_records` (`id`, `asset_id`, `problem_description`, `start_date`, `end_date`, `cost`, `status`) VALUES
(1, 1, 'asdasdasd', '2026-10-15', NULL, 0.00, 'ongoing'),
(2, 7, 'lcd', '2026-10-19', '2026-10-20', 2000000.00, 'completed'),
(3, 4, 'rusak', '2026-10-20', '2026-10-20', 2000000.00, 'completed');

-- --------------------------------------------------------

--
-- Struktur dari tabel `maintenance_schedules`
--

CREATE TABLE `maintenance_schedules` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `maintenance_type` varchar(100) NOT NULL,
  `scheduled_at` date NOT NULL,
  `recurrence_interval` varchar(50) DEFAULT NULL,
  `vendor_or_technician` varchar(150) DEFAULT NULL,
  `estimated_cost` decimal(15,2) DEFAULT 0.00,
  `status` enum('scheduled','completed','cancelled','missed') DEFAULT 'scheduled',
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `related_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`) VALUES
(1, '02kelinci02@gmail.com', 'ba1080d27d3b136812042ab04355fb9c7ba4747cf521730eb20076676eb425b6', '2026-10-21 04:31:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `employee_code` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','employee') DEFAULT 'employee',
  `department_id` int(11) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT 'default.png',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `employee_code`, `name`, `email`, `password_hash`, `role`, `department_id`, `position`, `phone`, `profile_photo`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'EMP-0001', 'Super Admin', 'admin@gmail.com', '$2y$10$0f6hgntDHcELy9NlCc7aR.SYVy8A09v7rOY7tRD82VBDAbmmWGWFK', 'admin', 1, 'System Administrator', NULL, 'default.png', 1, '2026-10-09 14:36:40', '2026-10-21 03:21:13'),
(3, 'emp=002', 'Users', 'users@gmail.com', '$2y$10$FpaSDGojdofex7u0E3UTi.yL/Z2G/WrrM1IsFYwipQRMrnH6bjY9u', 'employee', 1, 'backend dev', '08954239870', 'default.png', 1, '2026-10-13 16:01:38', '2026-10-21 07:50:46'),
(4, 'emp 3', 'ali', 'murianaalfiqo@gmail.com', '$2y$10$J6W8hne6825yawfY046reeHudVivlZOdQk2OQVw73sPxdl/JcrSai', 'employee', 1, 'beckend devekoper', '0888931231', 'default.png', 0, '2026-10-19 11:14:01', '2026-10-21 04:30:47'),
(5, 'R-2', 'ALIFQO 02', '02kelinci02@gmail.com', '$2y$10$jH4geo5RhS7soKvLpGTS9OjUso7VlKoi0gGwkgzMIEPPZ/xlhUIaa', 'employee', 1, 'beckend devekoper', '0888931231', 'default.png', 1, '2026-10-21 04:31:19', '2026-10-21 04:31:19');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asset_code` (`asset_code`),
  ADD UNIQUE KEY `serial_number` (`serial_number`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indeks untuk tabel `asset_assignments`
--
ALTER TABLE `asset_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assigned_by` (`assigned_by`);

--
-- Indeks untuk tabel `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `borrowing_code` (`borrowing_code`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `maintenance_records`
--
ALTER TABLE `maintenance_records`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `maintenance_schedules`
--
ALTER TABLE `maintenance_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_code` (`employee_code`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `department_id` (`department_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `asset_assignments`
--
ALTER TABLE `asset_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `maintenance_records`
--
ALTER TABLE `maintenance_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `maintenance_schedules`
--
ALTER TABLE `maintenance_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `assets_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assets_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `asset_assignments`
--
ALTER TABLE `asset_assignments`
  ADD CONSTRAINT `asset_assignments_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`),
  ADD CONSTRAINT `asset_assignments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asset_assignments_ibfk_3` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`),
  ADD CONSTRAINT `borrowings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrowings_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `maintenance_schedules`
--
ALTER TABLE `maintenance_schedules`
  ADD CONSTRAINT `maintenance_schedules_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
