-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 21 Mar 2025 pada 10.19
-- Versi server: 8.4.3
-- Versi PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Mengatur karakter set untuk kompatibilitas
SET NAMES utf8;

-- --------------------------------------------------------

-- Struktur dari tabel `cache`
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Struktur dari tabel `cache_locks`
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Struktur dari tabel `dokumentasi`
CREATE TABLE `dokumentasi` (
  `id_dokumentasi` bigint NOT NULL,
  `id_pengiriman` bigint NOT NULL,
  `path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Struktur dari tabel `failed_jobs`
CREATE TABLE `failed_jobs` (
  `id` bigint NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Struktur dari tabel `jobs`
CREATE TABLE `jobs` (
  `id` bigint NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint NOT NULL,
  `reserved_at` int DEFAULT NULL,
  `available_at` int NOT NULL,
  `created_at` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Struktur dari tabel `job_batches`
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Struktur dari tabel `kurir`
CREATE TABLE `kurir` (
  `id_kurir` bigint NOT NULL,
  `id_user` bigint DEFAULT NULL,
  `nama_kurir` varchar(100) DEFAULT NULL,
  `no_hp` varchar(100) DEFAULT NULL,
  `jenis_kurir` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert data ke tabel `kurir`
INSERT INTO `kurir` (`id_kurir`, `id_user`, `nama_kurir`, `no_hp`, `jenis_kurir`) VALUES
(11, 12, 'kurir-1', '0834783924', 'Darat'),
(12, 13, 'kurir-2', '0834783924', 'Laut');

-- --------------------------------------------------------

-- Struktur dari tabel `migrations`
CREATE TABLE `migrations` (
  `id` int NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert data ke tabel `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

-- Struktur dari tabel `password_reset_tokens`
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Struktur dari tabel `pengiriman`
CREATE TABLE `pengiriman` (
  `id_pengiriman` bigint NOT NULL,
  `id_kurir` bigint NOT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `tujuan` varchar(100) DEFAULT NULL,
  `armada` varchar(100) DEFAULT NULL,
  `muatan` int DEFAULT NULL,
  `nomor_kendaraan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Struktur dari tabel `sessions`
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert data ke tabel `sessions`
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0D5TJueo4piiXjvVK9EWzYmq0RqrzUpsALAmsE8Y', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibXRtdkdDYWliT3oxczNPWHBLZEk2NXhDN1FGc21sUXhPWWtQQldRcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly94eXoudGVzdC9wdWJsaWMvcmVrYXAtZGF0YS1wZW5naXJpbWFuIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTI7fQ==', 1741547463);

-- --------------------------------------------------------

-- Struktur dari tabel `users`
CREATE TABLE `users` (
  `id` bigint NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `roles` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert data ke tabel `users` (lanjutan)
INSERT INTO `users` (`id`, `name`, `username`, `roles`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(12, 'kurir-1', 'kurir1', 'kurir', NULL, NULL, '$2y$12$fXQOXLiVWUf1jp8trJ8eyVg1fp0HZH8m5mNY3zWjHlm9EO1X7oFFS', NULL, '2025-02-12 09:40:03', '2025-02-12 09:40:03'),
(13, 'kurir-2', 'kurir2', 'kurir', NULL, NULL, '$2y$12$QwFZQEn7xEPmxX9o1SY71dMFRBfL0oD8KvzA1R9sktc88j9YINMjm', NULL, '2025-02-12 09:45:03', '2025-02-12 09:45:03');

-- Commit transaksi
COMMIT;