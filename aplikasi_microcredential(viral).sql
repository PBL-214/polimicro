-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 29 Apr 2026 pada 13.34
-- Versi server: 8.4.3
-- Versi PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `aplikasi_microcredential`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1777469324),
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1777469324;', 1777469324);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `makul`
--

CREATE TABLE `makul` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_makul` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_makul` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `sks` int NOT NULL DEFAULT '3',
  `prodi_id` bigint UNSIGNED NOT NULL,
  `dosen_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `makul`
--

INSERT INTO `makul` (`id`, `kode_makul`, `nama_makul`, `deskripsi`, `sks`, `prodi_id`, `dosen_id`, `created_at`, `updated_at`) VALUES
(1, 'MK001', 'Dasar Machine Learning', 'Pengantar konsep machine learning, supervised/unsupervised learning', 3, 1, 6, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(2, 'MK002', 'Deep Learning', 'Neural networks, CNN, RNN, dan implementasi deep learning', 3, 1, 6, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(3, 'MK003', 'Natural Language Processing', 'Pemrosesan bahasa alami, text mining, dan chatbot AI', 3, 1, 6, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(4, 'MK004', 'Statistik & Probabilitas', 'Dasar statistik untuk analisis data dan pengambilan keputusan', 3, 2, 7, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(5, 'MK005', 'Data Visualization', 'Teknik visualisasi data menggunakan tools modern', 2, 2, 7, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(6, 'MK006', 'Big Data Analytics', 'Pengelolaan dan analisis data berskala besar', 3, 2, 7, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(7, 'MK007', 'Network Security', 'Keamanan jaringan komputer dan protokol keamanan', 3, 3, 8, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(8, 'MK008', 'Ethical Hacking', 'Penetration testing dan ethical hacking', 3, 3, 8, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(9, 'MK-O0lz0', 'Mata Kuliah itaque et quos', 'Consequatur dolor pariatur quaerat tenetur beatae in voluptas.', 2, 10, 18, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(10, 'MK-ibXvd', 'Mata Kuliah non atque repellendus', 'Blanditiis et sunt quia blanditiis tenetur beatae est a doloribus aperiam.', 2, 6, 22, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(11, 'MK-Uf4bd', 'Mata Kuliah qui deleniti error', 'Quo debitis laudantium sit quia earum modi.', 2, 6, 16, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(12, 'MK-V55vH', 'Mata Kuliah maiores nobis dignissimos', 'Qui dolores sunt beatae neque ad consequuntur quae ut.', 3, 9, 32, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(13, 'MK-sSOpK', 'Mata Kuliah assumenda placeat incidunt', 'Commodi aut delectus quisquam animi enim in.', 2, 9, 16, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(14, 'MK-MAils', 'Mata Kuliah corrupti tempora doloribus', 'Deserunt aut omnis est nemo nostrum eos qui omnis.', 4, 6, 18, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(15, 'MK-w9tYf', 'Mata Kuliah minus voluptatibus eum', 'Et sit nulla veniam voluptatem reprehenderit neque modi atque consequatur.', 4, 11, 28, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(16, 'MK-wPQEj', 'Mata Kuliah enim sit aut', 'Sit aut alias facere sint velit omnis.', 2, 12, 18, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(17, 'MK-7QR9w', 'Mata Kuliah officiis aut et', 'Quia cumque maxime qui aut neque cupiditate sunt sed perspiciatis iusto numquam.', 2, 9, 30, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(18, 'MK-3vMeA', 'Mata Kuliah reiciendis omnis sit', 'Aut incidunt eos possimus animi est voluptas.', 3, 11, 24, '2026-04-28 12:49:51', '2026-04-28 12:49:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_materi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_materi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_materi` text COLLATE utf8mb4_unicode_ci,
  `file_materi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `makul_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`id`, `kode_materi`, `nama_materi`, `deskripsi_materi`, `file_materi`, `makul_id`, `created_at`, `updated_at`) VALUES
(1, 'MAT001', 'Pengantar Machine Learning', 'Konsep dasar ML, tipe-tipe learning, dan pipeline ML', 'pengantar-ml.pdf', 1, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(2, 'MAT002', 'Supervised Learning', 'Regresi, klasifikasi, decision tree, SVM', 'supervised-learning.pdf', 1, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(3, 'MAT003', 'Neural Networks Basics', 'Arsitektur neural network, backpropagation', 'neural-networks.pdf', 2, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(4, 'MAT004', 'Convolutional Neural Networks', 'CNN untuk image recognition dan computer vision', 'cnn.pdf', 2, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(5, 'MAT005', 'Pengantar Statistik', 'Statistik deskriptif, distribusi, dan uji hipotesis', 'pengantar-statistik.pdf', 4, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(6, 'MAT006', 'Dashboard Design', 'Prinsip desain dashboard yang efektif', 'dashboard-design.pdf', 5, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(7, 'MAT007', 'Firewall & IDS', 'Konfigurasi firewall dan intrusion detection system', 'firewall-ids.pdf', 7, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(8, 'MAT008', 'Vulnerability Assessment', 'Teknik penilaian kerentanan sistem', 'vuln-assessment.pdf', 8, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(9, 'MAT0009', 'asdas', 'dsad', 'materials/xDDdQrZhRnhFwSokaGw87fxgHSBs0dSKqZ3C0bFF.pdf', 1, '2026-04-28 08:29:57', '2026-04-28 08:29:57'),
(10, 'MAT0010', 'GIT', '321', 'materials/01WyUEZ4hQaeZgMeuFv9RzS8xygZTs6kEloZ5DcN.docx', 1, '2026-04-28 09:14:47', '2026-04-28 09:14:47'),
(11, 'MAT-VeK5V', 'Materi minus ut', 'Odit autem placeat iusto reprehenderit natus ratione explicabo sit mollitia corporis officiis.', NULL, 18, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(12, 'MAT-IbL5N', 'Materi facere voluptatem', 'Dolor repudiandae in sequi deleniti in sit.', NULL, 10, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(13, 'MAT-6bthp', 'Materi similique nostrum', 'Est voluptas voluptatem est maxime et itaque non dolores id.', NULL, 18, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(14, 'MAT-rE51c', 'Materi repudiandae recusandae', 'Ut qui incidunt in fuga expedita alias.', NULL, 12, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(15, 'MAT-GK122', 'Materi ea maiores', 'Impedit deleniti cum magnam dicta iusto nihil porro consequatur.', NULL, 12, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(16, 'MAT-nMqCY', 'Materi in molestiae', 'Ratione exercitationem ea iste assumenda ducimus temporibus unde at ipsam blanditiis id rerum.', NULL, 10, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(17, 'MAT-zPPfF', 'Materi et veniam', 'Porro nulla unde sed fugit aut et quaerat et consequatur autem corrupti.', NULL, 14, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(18, 'MAT-0APpz', 'Materi molestiae corporis', 'Deleniti pariatur quod qui et quae omnis minima veritatis.', NULL, 12, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(19, 'MAT-AWxle', 'Materi repellendus aut', 'Vel officia accusamus sequi et harum voluptatem exercitationem.', NULL, 11, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(20, 'MAT-iPuNT', 'Materi id perspiciatis', 'Est sequi doloremque repellat ut voluptas incidunt dignissimos magni molestias placeat.', NULL, 18, '2026-04-28 12:49:51', '2026-04-28 12:49:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '0001_01_01_000003_create_polimicro_tables', 1),
(5, '2026_04_28_143554_add_file_sertifikat_to_sertifikat_table', 2),
(6, '2026_04_28_154324_add_file_tugas_to_tugas_table', 3),
(7, '2026_04_28_160804_create_notifications_table', 4),
(8, '2026_04_29_000001_rename_bidang_to_homebase_on_users_table', 5),
(9, '2026_04_28_185201_add_points_to_users_table', 6),
(10, '2026_04_28_185211_create_badges_table', 6),
(11, '2026_04_28_185221_create_badge_user_table', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('541afdd0-e16b-4e6b-a425-49db4e8aa27f', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 11, '{\"title\":\"Pendaftaran Diterima! \\ud83c\\udf89\",\"message\":\"Selamat! Anda telah diterima di prodi Cloud Computing\",\"icon\":\"fas fa-check-circle\",\"color\":\"bg-cyan-100\",\"text_color\":\"text-cyan-600\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/mahasiswa\\/dashboard\"}', NULL, '2026-04-28 10:25:31', '2026-04-28 10:25:31'),
('87825f16-039e-4a4e-9b3b-f7a61450ec4c', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 1, '{\"title\":\"Tugas Telah Dinilai\",\"message\":\"Tugas Analisis Statistik Dataset Anda telah dinilai: 93\",\"icon\":\"fas fa-star\",\"color\":\"bg-amber-100\",\"text_color\":\"text-amber-600\",\"url\":\"http:\\/\\/127.0.0.1:8001\\/mahasiswa\\/grades\"}', '2026-04-28 09:21:35', '2026-04-28 09:21:02', '2026-04-28 09:21:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `prodi_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','diterima','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `registered_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `mahasiswa_id`, `prodi_id`, `status`, `registered_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'diterima', '2026-03-29', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(2, 1, 2, 'diterima', '2026-04-03', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(3, 2, 1, 'diterima', '2026-03-31', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(4, 2, 3, 'diterima', '2026-04-08', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(5, 3, 2, 'diterima', '2026-04-06', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(6, 3, 3, 'diterima', '2026-04-13', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(7, 4, 1, 'pending', '2026-04-25', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(8, 5, 4, 'pending', '2026-04-27', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(9, 1, 3, 'diterima', '2026-04-28', '2026-04-28 05:32:47', '2026-04-28 05:35:53'),
(10, 11, 1, 'pending', '2026-04-28', '2026-04-28 05:55:26', '2026-04-28 05:55:26'),
(11, 11, 4, 'diterima', '2026-04-28', '2026-04-28 06:25:47', '2026-04-28 10:25:31'),
(12, 12, 4, 'pending', '2026-04-28', '2026-04-28 10:24:35', '2026-04-28 10:24:35'),
(13, 29, 11, 'diterima', '2026-03-31', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(14, 25, 8, 'diterima', '2026-04-15', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(15, 33, 7, 'diterima', '2026-04-07', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(16, 23, 6, 'diterima', '2026-04-14', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(17, 17, 15, 'diterima', '2026-04-15', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(18, 27, 11, 'diterima', '2026-04-04', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(19, 15, 6, 'diterima', '2026-04-17', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(20, 25, 6, 'diterima', '2026-04-20', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(21, 33, 8, 'diterima', '2026-04-22', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(22, 21, 10, 'diterima', '2026-04-26', '2026-04-28 12:49:51', '2026-04-28 12:49:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengerjaan_tugas`
--

CREATE TABLE `pengerjaan_tugas` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `tugas_id` bigint UNSIGNED NOT NULL,
  `file_dikumpul` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_kumpul` datetime DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengerjaan_tugas`
--

INSERT INTO `pengerjaan_tugas` (`id`, `mahasiswa_id`, `tugas_id`, `file_dikumpul`, `waktu_kumpul`, `nilai`, `feedback`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'ahmad_linear_regression.ipynb', '2026-04-23 12:30:18', 88.00, 'Implementasi bagus, coba tambahkan regularization', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(2, 1, 2, 'ahmad_cnn_classifier.py', '2026-04-25 12:30:18', 92.00, 'Excellent! Akurasi sangat baik', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(3, 1, 4, 'ahmad_statistik.xlsx', '2026-04-26 12:30:18', 93.00, NULL, '2026-04-28 05:30:18', '2026-04-28 09:20:59'),
(4, 2, 1, 'siti_linear_reg.py', '2026-04-24 12:30:18', 85.00, 'Good work', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(5, 2, 6, 'siti_security_audit.pdf', '2026-04-27 12:30:18', NULL, NULL, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(6, 3, 4, 'budi_analisis.pdf', '2026-04-22 12:30:18', 78.00, 'Perlu lebih detail di bagian uji hipotesis', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(7, 3, 5, 'budi_dashboard.html', '2026-04-26 12:30:18', 90.00, 'Dashboard sangat interaktif dan informatif!', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(8, 3, 6, 'budi_netsec_audit.pdf', '2026-04-27 12:30:18', NULL, NULL, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(9, 1, 3, 'submissions/e7kbQNy3D7ESJkaLk32xfsyDK4pOpOH8B6fdLHW3.pdf', '2026-04-28 15:39:38', 100.00, NULL, '2026-04-28 08:39:38', '2026-04-28 09:00:10'),
(10, 25, 10, NULL, '2026-04-26 19:49:51', 72.00, 'Molestiae qui est et ut.', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(11, 31, 15, NULL, '2026-04-26 19:49:51', 88.00, 'Nulla reiciendis aut et nihil.', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(12, 33, 14, NULL, '2026-04-27 19:49:51', 95.00, 'Asperiores quasi excepturi consequatur.', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(13, 27, 8, NULL, '2026-04-27 19:49:51', 80.00, 'Fuga dicta quasi dignissimos.', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(14, 15, 16, NULL, '2026-04-26 19:49:51', 85.00, 'Adipisci exercitationem voluptatem similique totam.', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(15, 17, 14, NULL, '2026-04-25 19:49:51', 88.00, 'Natus aut facilis est iusto eligendi qui.', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(16, 17, 14, NULL, '2026-04-27 19:49:51', 77.00, 'In nihil exercitationem ea molestias.', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(17, 33, 11, NULL, '2026-04-25 19:49:51', 85.00, 'Non aut nisi aut repudiandae adipisci.', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(18, 33, 10, NULL, '2026-04-25 19:49:51', 74.00, 'Corporis deserunt minima nostrum voluptatibus animi omnis.', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(19, 33, 16, NULL, '2026-04-27 19:49:51', 92.00, 'Quia assumenda quasi error vero modi nisi.', '2026-04-28 12:49:51', '2026-04-28 12:49:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `prodi_mikro`
--

CREATE TABLE `prodi_mikro` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_prodi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_prodi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `durasi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 0xF09F939A,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `nid` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `prodi_mikro`
--

INSERT INTO `prodi_mikro` (`id`, `kode_prodi`, `nama_prodi`, `deskripsi`, `durasi`, `icon`, `status`, `nid`, `created_at`, `updated_at`) VALUES
(1, 'PRD001', 'Artificial Intelligence', 'Program studi microcredential yang berfokus pada pengembangan kecerdasan buatan, machine learning, dan deep learning untuk solusi industri.', '6 Bulan', '🤖', 'aktif', NULL, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(2, 'PRD002', 'Data Science & Analytics', 'Program studi untuk menguasai analisis data besar, statistik, dan visualisasi data untuk pengambilan keputusan bisnis.', '6 Bulan', '📊', 'aktif', NULL, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(3, 'PRD003', 'Cybersecurity', 'Program studi untuk menguasai keamanan jaringan, ethical hacking, dan pengelolaan risiko keamanan informasi.', '4 Bulan', '🔒', 'aktif', NULL, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(4, 'PRD004', 'Cloud Computing', 'Program studi microcredential tentang infrastruktur cloud, DevOps, dan pengelolaan layanan cloud modern.', '5 Bulan', '☁️', 'aktif', NULL, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(5, 'PRD005', 'UI/UX Design', 'Program studi tentang desain antarmuka pengguna, pengalaman pengguna, dan desain produk digital.', '4 Bulan', '🎨', 'aktif', NULL, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(6, 'PRD-8Uvmz', 'Program libero aliquid', 'Distinctio est maiores laboriosam nostrum voluptas consequatur.', '6 Bulan', '📚', 'aktif', 14, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(7, 'PRD-SAwWj', 'Program beatae qui', 'Quo quibusdam mollitia perferendis rem recusandae ut quisquam quisquam ipsa omnis modi voluptas.', '6 Bulan', '🎨', 'aktif', 18, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(8, 'PRD-lCJ3A', 'Program a dolorum', 'Tempora commodi sed quam veniam iusto sunt expedita qui molestiae.', '6 Bulan', '💻', 'aktif', 14, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(9, 'PRD-rVHmW', 'Program voluptatibus voluptatem', 'Eos quo mollitia qui consequatur dolores nostrum sapiente quia aut ea voluptatem.', '6 Bulan', '📚', 'aktif', 30, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(10, 'PRD-3ypET', 'Program facilis voluptatem', 'Et voluptates perspiciatis aut distinctio consequatur dolor placeat odit.', '6 Bulan', '💻', 'aktif', 24, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(11, 'PRD-gbEuW', 'Program autem dolorem', 'Ut mollitia veniam sequi qui repudiandae ducimus exercitationem molestiae labore accusamus quisquam.', '6 Bulan', '📊', 'aktif', 30, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(12, 'PRD-elqDN', 'Program cumque accusantium', 'Et natus voluptatum dicta qui corporis nesciunt optio qui non ut et sunt.', '6 Bulan', '🎨', 'aktif', 30, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(13, 'PRD-4NjuT', 'Program minus dolorem', 'Cupiditate quasi voluptatum illum harum consectetur dolore non veritatis rerum et qui corporis.', '6 Bulan', '📚', 'aktif', 20, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(14, 'PRD-BK1GX', 'Program enim rerum', 'Maxime voluptatem eos et repellat sed porro ut voluptates corporis fugiat.', '6 Bulan', '💻', 'aktif', 26, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(15, 'PRD-Rauak', 'Program fuga nostrum', 'Cupiditate laboriosam omnis ea soluta ea ea est minus in magni animi et.', '6 Bulan', '💻', 'aktif', 22, '2026-04-28 12:49:51', '2026-04-28 12:49:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sertifikat`
--

CREATE TABLE `sertifikat` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `prodi_id` bigint UNSIGNED NOT NULL,
  `nomor_sertifikat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_sertifikat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_terbit` date NOT NULL,
  `status` enum('diterbitkan','dicabut') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diterbitkan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sertifikat`
--

INSERT INTO `sertifikat` (`id`, `mahasiswa_id`, `prodi_id`, `nomor_sertifikat`, `file_sertifikat`, `tanggal_terbit`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'CERT-PM-2026-001', NULL, '2026-04-23', 'diterbitkan', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(2, 3, 2, 'CERT-PM-2026-002', NULL, '2026-04-26', 'diterbitkan', '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(3, 1, 2, 'CERT-PM-2026-003', 'certificates/fxYWh6X1e54eWu0NvQ4rxelKB28Xtrke8KLZi0Oe.pdf', '2026-04-28', 'diterbitkan', '2026-04-28 12:46:54', '2026-04-28 12:46:54'),
(4, 29, 9, 'CERT-BQZP3H2D6Z', NULL, '2026-04-19', 'diterbitkan', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(5, 19, 15, 'CERT-14AKGHHFRL', NULL, '2026-04-21', 'diterbitkan', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(6, 29, 13, 'CERT-MRJD5ASMUA', NULL, '2026-04-18', 'diterbitkan', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(7, 25, 12, 'CERT-RPPC3EGQON', NULL, '2026-04-23', 'diterbitkan', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(8, 29, 10, 'CERT-UCZIPVZ4MT', NULL, '2026-04-18', 'diterbitkan', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(9, 27, 6, 'CERT-J1AP79GBAZ', NULL, '2026-04-20', 'diterbitkan', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(10, 31, 7, 'CERT-SFWMYNUVBN', NULL, '2026-04-22', 'diterbitkan', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(11, 15, 8, 'CERT-S6KYIZ0TNJ', NULL, '2026-04-24', 'diterbitkan', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(12, 33, 14, 'CERT-FMHKUZLU37', NULL, '2026-04-22', 'diterbitkan', '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(13, 23, 15, 'CERT-2NYRUXEF0U', NULL, '2026-04-24', 'diterbitkan', '2026-04-28 12:49:51', '2026-04-28 12:49:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5rHDCJpMPqpushJyYmN0DkEIUeJ2VlL7zrHlsPjX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJrbmRzcXZ2eVVXR3pXS25yNTVCSzhDYmo3NFVvOTgxc1MxejdpVWVCIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2ZhcSIsInJvdXRlIjoiZmFxIn19', 1777469589),
('eCDoBKJBA44bR2sVU6KsOOJAXC0DrAczx6UhWJji', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJUS3VGUnM1SnpXdnplc25EWWNXc0tIOElkSTlkUUJoNVpkSUVTOWFNIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluLXBpY1wvdmVyaWZpY2F0aW9uIiwicm91dGUiOiJhZG1pbi1waWMudmVyaWZpY2F0aW9uIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjo5fQ==', 1777411945),
('OokTgSJx0D76hmi41FaDWxvzPfVY08VWxMEaDSKn', 10, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'eyJfdG9rZW4iOiIxaHROaHJNbmY4M3YxbXc5cldBRnVpUzFUSXFzOXB6UmxUbVIzWjNaIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvcG9saW1pY3JvLnRlc3RcL2FkbWluLWFrYWRlbWlrXC9wcm9ncmFtcyIsInJvdXRlIjoiYWRtaW4tYWthZGVtaWsucHJvZ3JhbXMifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEwfQ==', 1777412991);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_tugas` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_tugas` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_tugas` text COLLATE utf8mb4_unicode_ci,
  `file_tugas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_file` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_nilai` int NOT NULL DEFAULT '100',
  `tanggal_awal_deadline` date DEFAULT NULL,
  `tanggal_akhir_deadline` date DEFAULT NULL,
  `materi_id` bigint UNSIGNED DEFAULT NULL,
  `makul_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`id`, `kode_tugas`, `nama_tugas`, `deskripsi_tugas`, `file_tugas`, `format_file`, `max_nilai`, `tanggal_awal_deadline`, `tanggal_akhir_deadline`, `materi_id`, `makul_id`, `created_at`, `updated_at`) VALUES
(1, 'TGS001', 'Implementasi Linear Regression', 'Buat model regresi linier menggunakan dataset yang diberikan', NULL, NULL, 100, NULL, '2026-05-12', NULL, 1, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(2, 'TGS002', 'Klasifikasi Gambar dengan CNN', 'Bangun classifier gambar menggunakan CNN', NULL, NULL, 100, NULL, '2026-05-19', NULL, 2, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(3, 'TGS003', 'Chatbot Sederhana', 'Buat chatbot sederhana menggunakan NLP', NULL, NULL, 100, NULL, '2026-05-26', NULL, 3, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(4, 'TGS004', 'Analisis Statistik Dataset', 'Lakukan analisis statistik pada dataset terlampir', NULL, NULL, 100, NULL, '2026-05-08', NULL, 4, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(5, 'TGS005', 'Dashboard Interaktif', 'Buat dashboard interaktif menggunakan tools visualisasi', NULL, NULL, 100, NULL, '2026-05-15', NULL, 5, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(6, 'TGS006', 'Network Security Audit', 'Lakukan audit keamanan pada jaringan yang diberikan', NULL, NULL, 100, NULL, '2026-05-12', NULL, 7, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(7, 'TGS007', 'Penetration Testing Report', 'Buat laporan penetration testing lengkap', NULL, NULL, 100, NULL, '2026-05-19', NULL, 8, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(8, 'TGS-O0Wjg', 'Tugas dolorem praesentium', 'Autem in soluta quia suscipit voluptatem in laborum sed quibusdam quia.', NULL, 'pdf', 100, '2026-04-28', '2026-05-05', 13, 16, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(9, 'TGS-dWXGT', 'Tugas autem praesentium', 'Quisquam deleniti et eligendi sint tempore quas quisquam.', NULL, 'pdf', 100, '2026-04-28', '2026-05-05', 14, 10, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(10, 'TGS-nqqVB', 'Tugas enim sequi', 'Consectetur et non quasi et omnis excepturi accusamus sed amet fuga.', NULL, 'pdf', 100, '2026-04-28', '2026-05-05', 13, 10, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(11, 'TGS-hRV5N', 'Tugas consequatur aut', 'Laborum aut dicta qui sed aut sunt reiciendis rerum ab sequi.', NULL, 'pdf', 100, '2026-04-28', '2026-05-05', 16, 14, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(12, 'TGS-jMBuE', 'Tugas praesentium quibusdam', 'Ex sunt omnis qui adipisci sed saepe sed commodi.', NULL, 'pdf', 100, '2026-04-28', '2026-05-05', 14, 9, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(13, 'TGS-wAKaN', 'Tugas officiis aliquam', 'Et expedita quibusdam repellat voluptas quam sit porro.', NULL, 'pdf', 100, '2026-04-28', '2026-05-05', 17, 12, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(14, 'TGS-11bpM', 'Tugas ipsum incidunt', 'Incidunt incidunt reiciendis sed natus autem dolores est adipisci.', NULL, 'pdf', 100, '2026-04-28', '2026-05-05', 14, 14, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(15, 'TGS-BbRJm', 'Tugas molestiae inventore', 'Sint sed beatae saepe quasi nam laboriosam neque officia.', NULL, 'pdf', 100, '2026-04-28', '2026-05-05', 19, 17, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(16, 'TGS-cCcEo', 'Tugas nisi autem', 'Omnis praesentium ducimus omnis quas tenetur ea quam.', NULL, 'pdf', 100, '2026-04-28', '2026-05-05', 15, 14, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(17, 'TGS-KePAH', 'Tugas voluptate ullam', 'Et autem mollitia provident suscipit praesentium temporibus accusamus consequatur non autem et.', NULL, 'pdf', 100, '2026-04-28', '2026-05-05', 20, 12, '2026-04-28 12:49:51', '2026-04-28 12:49:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('mahasiswa','dosen','admin_pic','admin_akademik') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mahasiswa',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `nim` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `homebase` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','pending','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `address`, `nim`, `nip`, `homebase`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad Fauzi', 'ahmad@student.polimicro.ac.id', NULL, '$2y$12$OSEOGl.4RSDqyMG/9K.uBuT7D3IRm.RekPH22UpyDCxWXpDpee3PG', 'mahasiswa', '081234567890', NULL, '2024001', NULL, NULL, 'aktif', NULL, '2026-04-28 05:30:13', '2026-04-28 12:11:10'),
(2, 'Siti Nurhaliza', 'siti@student.polimicro.ac.id', NULL, '$2y$12$gMMVg7K0ebs/WcUCVxqaxuWmruldpGK2Hwb.tzmMn5yFizL5CNHTO', 'mahasiswa', '081234567891', NULL, '2024002', NULL, NULL, 'aktif', NULL, '2026-04-28 05:30:14', '2026-04-28 05:30:14'),
(3, 'Budi Santoso', 'budi@student.polimicro.ac.id', NULL, '$2y$12$da6QJMgfTLFIgnBp6fh/bOQX3xAqEOV2YWy6oQzFL4xsSdsNcpPgO', 'mahasiswa', '081234567892', NULL, '2024003', NULL, NULL, 'aktif', NULL, '2026-04-28 05:30:15', '2026-04-28 05:30:15'),
(4, 'Dewi Lestari', 'dewi@student.polimicro.ac.id', NULL, '$2y$12$h8KOiqMPd1iGSpDA1q0AxOfNUid.BzfqCPufMFXhk0DzQaE7DFsFq', 'mahasiswa', NULL, NULL, '2024004', NULL, NULL, 'pending', NULL, '2026-04-28 05:30:15', '2026-04-28 05:30:15'),
(5, 'Rian Pratama', 'rian@student.polimicro.ac.id', NULL, '$2y$12$iuVcSegBhMEpVAkVw7.BMe0Hr6s9F9ICVfnPS2m/UFdNjhxaDylpS', 'mahasiswa', NULL, NULL, '2024005', NULL, NULL, 'pending', NULL, '2026-04-28 05:30:17', '2026-04-28 05:30:17'),
(6, 'Dr. Hendra Wijaya', 'hendra@dosen.polimicro.ac.id', NULL, '$2y$12$z3QO5qHGqgJMbC6IemmBFuL.ZTDiq22f9ves2.N00hZPJPSyRcW8y', 'dosen', '082111222333', NULL, NULL, '198501012020011001', 'Artificial Intelligence', 'aktif', NULL, '2026-04-28 05:30:17', '2026-04-28 05:30:17'),
(7, 'Prof. Ratna Sari', 'ratna@dosen.polimicro.ac.id', NULL, '$2y$12$5Q5TdZc0lCNoENpgMqFkTuZmA8DnauMpY2AWYEFheizS43.rbPTC2', 'dosen', '082111222334', NULL, NULL, '197901012019012001', 'Data Science', 'aktif', NULL, '2026-04-28 05:30:17', '2026-04-28 05:30:17'),
(8, 'Dr. Bambang Eko', 'bambang@dosen.polimicro.ac.id', NULL, '$2y$12$mKW31OIqZAixhWPjWTApTezlfFKl5G48SvHetRz1sWBQ4nnxz.Lou', 'dosen', '082111222335', NULL, NULL, '198201012021011001', 'Cybersecurity', 'aktif', NULL, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(9, 'Admin PIC', 'adminpic@polimicro.ac.id', NULL, '$2y$12$0dWIZ8kf7aIlXcQ0H3GoW.7y/ZvNcbbMGeS214Z8zDQd2Xkx5nTHC', 'admin_pic', NULL, NULL, NULL, NULL, NULL, 'aktif', NULL, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(10, 'Admin Akademik', 'adminakademik@polimicro.ac.id', NULL, '$2y$12$vGooXqnQAWD27W35xjXx/./WFxYmM7HtAFfLwuCOKs2/9r0be57M2', 'admin_akademik', NULL, NULL, NULL, NULL, NULL, 'aktif', NULL, '2026-04-28 05:30:18', '2026-04-28 05:30:18'),
(11, 'tes', 'tes@gmail.com', NULL, '$2y$12$BkQcntb3jweXbmwCtNtHjOxnaCPsa3fVWux7.vD0A4yUBxl.rm.kK', 'mahasiswa', '2313123131', NULL, '2024006', NULL, NULL, 'aktif', NULL, '2026-04-28 05:54:54', '2026-04-28 10:25:31'),
(12, 'Fajar Rizki Aprilian', 'tes1@gmail.com', NULL, '$2y$12$G7FIWiMFgk5Yl7jScpC1iu8HL.jV87v7SZrL0JwLH1CbuuGcR9rCW', 'mahasiswa', 'dsads', NULL, '2024007', NULL, NULL, 'pending', NULL, '2026-04-28 10:24:35', '2026-04-28 10:24:35'),
(13, 'ipan', 'ipan@gmail.com', NULL, '$2y$12$v5ggHCzM/f/c6t/m9ZJQ7Ord0ionGFZ1NnLfDbaeuHgvW8EPcSgZC', 'dosen', '2931837213', NULL, NULL, '21312312', 'Artificial Intelligence', 'aktif', NULL, '2026-04-28 10:45:18', '2026-04-28 10:45:30'),
(14, 'Aisyah Ayu Kusmawati S.Psi', 'cinta82@example.com', NULL, '$2y$12$jvLdVDYwKZ9gqDab1ALBnu3EMyhBC052A.mrkddcIxz56lG2WqOAm', 'mahasiswa', NULL, NULL, NULL, '1981679559', NULL, 'pending', NULL, '2026-04-28 12:49:47', '2026-04-28 12:49:47'),
(15, 'Tania Lintang Palastri S.Kom', 'nababan.lintang@example.com', NULL, '$2y$12$fSAc8DW771oTYlVIWU9L9.riFxwfvcozRc/U5R1oGfRJyYzZuQtYy', 'mahasiswa', NULL, NULL, '3312409715', NULL, NULL, 'pending', NULL, '2026-04-28 12:49:47', '2026-04-28 12:49:47'),
(16, 'Farah Janet Pratiwi S.Pd', 'uyainah.gabriella@example.org', NULL, '$2y$12$1vEw8vs2UEN.CJhjU9ENnOO4J/03NmQLlKAwC9RzpxLQp9hGsfZhi', 'mahasiswa', NULL, NULL, NULL, '1989214485', NULL, 'pending', NULL, '2026-04-28 12:49:47', '2026-04-28 12:49:47'),
(17, 'Ilyas Hidayat', 'sudiati.maria@example.com', NULL, '$2y$12$gEf/AdNzrLA.Wh068ULp/.lSA/5k9qK3uezMBcj3oNnGt9bw96qJe', 'mahasiswa', NULL, NULL, '3312402754', NULL, NULL, 'pending', NULL, '2026-04-28 12:49:47', '2026-04-28 12:49:47'),
(18, 'Maria Widya Kuswandari', 'karimah93@example.org', NULL, '$2y$12$GGSXjfnozn3mVZFKCzrUmeqm6YIp7Kon/FDiFAY5vEDaclwIm.w6O', 'mahasiswa', NULL, NULL, NULL, '1980823636', NULL, 'pending', NULL, '2026-04-28 12:49:48', '2026-04-28 12:49:48'),
(19, 'Lala Nadine Mardhiyah', 'budiyanto.imam@example.org', NULL, '$2y$12$SF7.4Tc3CJDL.WKkiELw1OYal1cA5pCWd4Nc/BWiZSzC7kI7XZl7O', 'mahasiswa', NULL, NULL, '3312404260', NULL, NULL, 'pending', NULL, '2026-04-28 12:49:48', '2026-04-28 12:49:48'),
(20, 'Oskar Jatmiko Hardiansyah S.IP', 'xsihombing@example.com', NULL, '$2y$12$p5sOt.Rdpv.9TUQlc4a1jex6U0rSgYqRfp4nNqGdRaa/7Uhw4csdu', 'mahasiswa', NULL, NULL, NULL, '1987397944', NULL, 'pending', NULL, '2026-04-28 12:49:48', '2026-04-28 12:49:48'),
(21, 'Rina Karen Halimah M.Kom.', 'nuraini.ibrahim@example.org', NULL, '$2y$12$RDG0w2GhmpzwZ2zgCovT7OfkUY8wBjoF2RU.UeuO0tPGpuPz9ctqm', 'mahasiswa', NULL, NULL, '3312401453', NULL, NULL, 'pending', NULL, '2026-04-28 12:49:48', '2026-04-28 12:49:48'),
(22, 'Betania Mardhiyah', 'cpudjiastuti@example.org', NULL, '$2y$12$NUpsF/or5wBBvUXyjtHKyOnP7yjl8.EVcYacikkzaEoeJ6q5ZKNES', 'mahasiswa', NULL, NULL, NULL, '1987197088', NULL, 'pending', NULL, '2026-04-28 12:49:48', '2026-04-28 12:49:48'),
(23, 'Emong Nrima Setiawan', 'yono14@example.com', NULL, '$2y$12$Yq7n5xl/QsBHDOBHf8edjeb4JPU5sk91bkL7LHXgVI5tLdMe2Sx82', 'mahasiswa', NULL, NULL, '3312401274', NULL, NULL, 'pending', NULL, '2026-04-28 12:49:49', '2026-04-28 12:49:49'),
(24, 'Paulin Tantri Pratiwi S.Pt', 'hidayat.sabri@example.com', NULL, '$2y$12$rZJ4BGBtkP.48SCQ2cIzE.YqmQHMdzXMHUz2vieM4E5iXaIib6vXa', 'mahasiswa', NULL, NULL, NULL, '1985786798', NULL, 'pending', NULL, '2026-04-28 12:49:49', '2026-04-28 12:49:49'),
(25, 'Nadia Maryati', 'dacin.yuliarti@example.com', NULL, '$2y$12$1vTCJV7KFPafAEJbo.rp/uZC.iCDCwV1h9KKD/2793hgQmztrVVh6', 'mahasiswa', NULL, NULL, '3312406781', NULL, NULL, 'pending', NULL, '2026-04-28 12:49:49', '2026-04-28 12:49:49'),
(26, 'Dasa Wahyu Marbun', 'paris45@example.org', NULL, '$2y$12$UsNREbB0X4t0s6tVrtuQ6.8Mi2KqwLWGqe/XQM.XDXblFBj/sPcwK', 'mahasiswa', NULL, NULL, NULL, '1982695640', NULL, 'pending', NULL, '2026-04-28 12:49:49', '2026-04-28 12:49:49'),
(27, 'Laksana Januar', 'yuni.sudiati@example.net', NULL, '$2y$12$TyW54fsSxNs1cMsrTF3Mn./5miZdLm377C8xssunQk6455j1bj2cq', 'mahasiswa', NULL, NULL, '3312408913', NULL, NULL, 'pending', NULL, '2026-04-28 12:49:49', '2026-04-28 12:49:49'),
(28, 'Syahrini Susanti', 'sarah25@example.net', NULL, '$2y$12$r5dcS3bB1hz4ISoP60PeS.X11fi4JS3rZzOsrW3f/r7oozRpzicNy', 'mahasiswa', NULL, NULL, NULL, '1985244663', NULL, 'pending', NULL, '2026-04-28 12:49:50', '2026-04-28 12:49:50'),
(29, 'Zaenab Mayasari', 'pertiwi.raihan@example.com', NULL, '$2y$12$86z8kpopKD7wG51RAFDO6eC8ARiOLPEptByHmJEKLqsCvlFMDKKJ2', 'mahasiswa', NULL, NULL, '3312408648', NULL, NULL, 'pending', NULL, '2026-04-28 12:49:50', '2026-04-28 12:49:50'),
(30, 'Keisha Permata', 'hasna25@example.org', NULL, '$2y$12$MiCgvgSBtagfVmv9uNi0NOCM2w5/YubDmA1rgTBHnc1xy3Sasbxja', 'mahasiswa', NULL, NULL, NULL, '1989083004', NULL, 'pending', NULL, '2026-04-28 12:49:50', '2026-04-28 12:49:50'),
(31, 'Azalea Agustina', 'aslijan48@example.net', NULL, '$2y$12$IcqAIGfK4anCOYgcvDBTte9r0dEt5mfDXyKWBc9E3CZTyysFms7Ka', 'mahasiswa', NULL, NULL, '3312408953', NULL, NULL, 'pending', NULL, '2026-04-28 12:49:50', '2026-04-28 12:49:50'),
(32, 'Kawaca Banawa Santoso', 'qputra@example.net', NULL, '$2y$12$T027w4qwukiI7Iz8GuYQYOxpGF4LWfXsczwd83dW0P9d3eTq6F8Ga', 'mahasiswa', NULL, NULL, NULL, '1980673764', NULL, 'pending', NULL, '2026-04-28 12:49:50', '2026-04-28 12:49:50'),
(33, 'Najwa Eka Wulandari', 'maya.samosir@example.com', NULL, '$2y$12$KfAVhCcE25cGs6HILKDMuuxqsdUr0Xbtfz6kwYiwGvCNiefLHXjbO', 'mahasiswa', NULL, NULL, '3312407698', NULL, NULL, 'pending', NULL, '2026-04-28 12:49:51', '2026-04-28 12:49:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `views_materi`
--

CREATE TABLE `views_materi` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `materi_id` bigint UNSIGNED NOT NULL,
  `waktu_akses_materi` datetime DEFAULT NULL,
  `waktu_selesai_materi` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `views_materi`
--

INSERT INTO `views_materi` (`id`, `mahasiswa_id`, `materi_id`, `waktu_akses_materi`, `waktu_selesai_materi`, `created_at`, `updated_at`) VALUES
(1, 21, 16, '2026-04-27 19:49:51', NULL, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(2, 31, 15, '2026-04-27 21:49:51', NULL, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(3, 19, 19, '2026-04-27 22:49:51', NULL, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(4, 15, 11, '2026-04-28 17:49:51', NULL, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(5, 25, 11, '2026-04-28 12:49:51', NULL, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(6, 23, 11, '2026-04-28 12:49:51', NULL, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(7, 25, 16, '2026-04-28 16:49:51', NULL, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(8, 33, 11, '2026-04-28 02:49:51', NULL, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(9, 21, 18, '2026-04-28 09:49:51', NULL, '2026-04-28 12:49:51', '2026-04-28 12:49:51'),
(10, 17, 11, '2026-04-28 05:49:51', NULL, '2026-04-28 12:49:51', '2026-04-28 12:49:51');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `makul`
--
ALTER TABLE `makul`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `makul_kode_makul_unique` (`kode_makul`),
  ADD KEY `makul_prodi_id_foreign` (`prodi_id`),
  ADD KEY `makul_dosen_id_foreign` (`dosen_id`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `materi_kode_materi_unique` (`kode_materi`),
  ADD KEY `materi_makul_id_foreign` (`makul_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftaran_mahasiswa_id_foreign` (`mahasiswa_id`),
  ADD KEY `pendaftaran_prodi_id_foreign` (`prodi_id`);

--
-- Indeks untuk tabel `pengerjaan_tugas`
--
ALTER TABLE `pengerjaan_tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengerjaan_tugas_mahasiswa_id_foreign` (`mahasiswa_id`),
  ADD KEY `pengerjaan_tugas_tugas_id_foreign` (`tugas_id`);

--
-- Indeks untuk tabel `prodi_mikro`
--
ALTER TABLE `prodi_mikro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prodi_mikro_kode_prodi_unique` (`kode_prodi`),
  ADD KEY `prodi_mikro_nid_foreign` (`nid`);

--
-- Indeks untuk tabel `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sertifikat_nomor_sertifikat_unique` (`nomor_sertifikat`),
  ADD KEY `sertifikat_mahasiswa_id_foreign` (`mahasiswa_id`),
  ADD KEY `sertifikat_prodi_id_foreign` (`prodi_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tugas_kode_tugas_unique` (`kode_tugas`),
  ADD KEY `tugas_materi_id_foreign` (`materi_id`),
  ADD KEY `tugas_makul_id_foreign` (`makul_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `views_materi`
--
ALTER TABLE `views_materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `views_materi_mahasiswa_id_foreign` (`mahasiswa_id`),
  ADD KEY `views_materi_materi_id_foreign` (`materi_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `makul`
--
ALTER TABLE `makul`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `pengerjaan_tugas`
--
ALTER TABLE `pengerjaan_tugas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `prodi_mikro`
--
ALTER TABLE `prodi_mikro`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `sertifikat`
--
ALTER TABLE `sertifikat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `views_materi`
--
ALTER TABLE `views_materi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `makul`
--
ALTER TABLE `makul`
  ADD CONSTRAINT `makul_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `makul_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodi_mikro` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_makul_id_foreign` FOREIGN KEY (`makul_id`) REFERENCES `makul` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftaran_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodi_mikro` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengerjaan_tugas`
--
ALTER TABLE `pengerjaan_tugas`
  ADD CONSTRAINT `pengerjaan_tugas_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengerjaan_tugas_tugas_id_foreign` FOREIGN KEY (`tugas_id`) REFERENCES `tugas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `prodi_mikro`
--
ALTER TABLE `prodi_mikro`
  ADD CONSTRAINT `prodi_mikro_nid_foreign` FOREIGN KEY (`nid`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD CONSTRAINT `sertifikat_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sertifikat_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodi_mikro` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_makul_id_foreign` FOREIGN KEY (`makul_id`) REFERENCES `makul` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tugas_materi_id_foreign` FOREIGN KEY (`materi_id`) REFERENCES `materi` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `views_materi`
--
ALTER TABLE `views_materi`
  ADD CONSTRAINT `views_materi_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `views_materi_materi_id_foreign` FOREIGN KEY (`materi_id`) REFERENCES `materi` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
