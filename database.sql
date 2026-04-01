-- ============================================
-- P3M UNIM — Database Schema Reference
-- Database: p3munimphp
-- ============================================

-- NOTE: Buat database 'p3munimphp' secara manual jika belum ada
-- CREATE DATABASE IF NOT EXISTS `p3munimphp`
--     DEFAULT CHARACTER SET utf8mb4
--     DEFAULT COLLATE utf8mb4_general_ci;

USE `sdnk1832_p3munimphp`;

SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------
-- DROP TABLES (Child tables first to avoid FK constraints)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `dokumenProfs`;
DROP TABLE IF EXISTS `catDokumenProfs`;
DROP TABLE IF EXISTS `dokumenPengabs`;
DROP TABLE IF EXISTS `catDokumenPengabs`;
DROP TABLE IF EXISTS `dokumenPens`;
DROP TABLE IF EXISTS `catDokumenPens`;
DROP TABLE IF EXISTS `Forms`;
DROP TABLE IF EXISTS `files`;
DROP TABLE IF EXISTS `Youtubes`;
DROP TABLE IF EXISTS `profiles`;
DROP TABLE IF EXISTS `Articles`;
DROP TABLE IF EXISTS `Admins`;

-- ============ ADMINS ============
CREATE TABLE `Admins` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `createdAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin (password: 19p3munim99)
INSERT INTO `Admins` (`username`, `password`, `createdAt`, `updatedAt`)
SELECT * FROM (SELECT 'adminp3munim', '$2y$10$4XOrOSZLFhTMU/a1wWFsau/X2/JL/4aT5yaejjuHqeX9xbWHE7OLa', NOW() as created, NOW() as updated) AS tmp
WHERE NOT EXISTS (
    SELECT username FROM `Admins` WHERE username = 'adminp3munim'
) LIMIT 1;

-- ============ ARTICLES ============
CREATE TABLE `Articles` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) DEFAULT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `content` TEXT NOT NULL,
    `thumbnail` VARCHAR(255) NOT NULL,
    `published_date` DATETIME NOT NULL,
    `author` VARCHAR(255) NOT NULL,
    `category` ENUM(
        'informasi_kkn',
        'informasi_pengabdian_masyarakat',
        'informasi_pengabdian_masyarakat_mandiri',
        'informasi_penelitian',
        'umum'
    ) DEFAULT NULL,
    `createdAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============ PROFILES ============
CREATE TABLE `profiles` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `image` VARCHAR(255) DEFAULT NULL,
    `alt` VARCHAR(255) DEFAULT NULL,
    `type` ENUM('pimpinan_lembaga','struktur_organisasi') NOT NULL,
    `createdAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============ YOUTUBES ============
CREATE TABLE `Youtubes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) DEFAULT NULL,
    `link` VARCHAR(255) NOT NULL,
    `createdAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============ FILES ============
CREATE TABLE `files` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `file_url` VARCHAR(255) NOT NULL,
    `file_name` VARCHAR(255) NOT NULL,
    `file_description` VARCHAR(255) DEFAULT NULL,
    `file_type` ENUM(
        'panduan_penelitian',
        'sk_rektor_penelitian',
        'dokumen_penelitian',
        'dokumen_pengabdian_masyarakat_mandiri',
        'panduan_pengabdian_masyarakat',
        'sk_rektor_pengabdian_masyarakat',
        'dokumen_penting_pengabdian_masyarakat',
        'panduan_kkn_tematik',
        'sk_rektor_pelaksanaan_kkn_tematik',
        'panduan_pengelolaan_jurnal_ilmiah',
        'panduan_kkn_pmm',
        'panduan_kkn_pkn_bem',
        'sk_rektor_pelaksanaan_kkn_pmm',
        'panduan_layanan_hki'
    ) NOT NULL,
    `createdAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============ FORMS ============
CREATE TABLE `Forms` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `link` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `createdAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============ CATEGORY DOKUMEN PENELITIAN ============
CREATE TABLE `catDokumenPens` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) DEFAULT NULL,
    `createdAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============ DOKUMEN PENELITIAN ============
CREATE TABLE `dokumenPens` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `file_url` VARCHAR(255) NOT NULL,
    `file_name` VARCHAR(255) NOT NULL,
    `catdokumenpenId` INT NOT NULL,
    `createdAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `dokumenpens_ibfk_1` FOREIGN KEY (`catdokumenpenId`) REFERENCES `catDokumenPens`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============ CATEGORY DOKUMEN PENGABDIAN ============
CREATE TABLE `catDokumenPengabs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) DEFAULT NULL,
    `createdAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============ DOKUMEN PENGABDIAN ============
CREATE TABLE `dokumenPengabs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `file_url` VARCHAR(255) NOT NULL,
    `file_name` VARCHAR(255) NOT NULL,
    `catdokumenpengabId` INT NOT NULL,
    `createdAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `dokumenpengabs_ibfk_1` FOREIGN KEY (`catdokumenpengabId`) REFERENCES `catDokumenPengabs`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============ CATEGORY DOKUMEN PROFIL ============
CREATE TABLE `catDokumenProfs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `createdAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============ DOKUMEN PROFIL ============
CREATE TABLE `dokumenProfs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `file_url` VARCHAR(255) NOT NULL,
    `file_name` VARCHAR(255) NOT NULL,
    `catdokumenprofId` INT NOT NULL,
    `createdAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `dokumenprofs_ibfk_1` FOREIGN KEY (`catdokumenprofId`) REFERENCES `catDokumenProfs`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
