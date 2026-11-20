-- Database untuk TP Modul 9 (MVC)
-- Cara pakai: buka phpMyAdmin -> Import -> pilih file ini.

CREATE DATABASE IF NOT EXISTS `tp_mvc25` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tp_mvc25`;

DROP TABLE IF EXISTS `courses`;
DROP TABLE IF EXISTS `lecturers`;
DROP TABLE IF EXISTS `departments`;

-- --------------------------------------------------------
-- Tabel baru: departments
-- --------------------------------------------------------
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `building` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Tabel lama: lecturers (dari kode awal)
-- Atribut baru: department_id (relasi ke departments)
-- Jika departemen dihapus, department_id dosen menjadi NULL
-- --------------------------------------------------------
CREATE TABLE `lecturers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `nidn` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `join_date` date NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `fk_lecturers_department` FOREIGN KEY (`department_id`)
    REFERENCES `departments` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Tabel baru: courses
-- Jika dosen dihapus, mata kuliah yang diajarnya ikut terhapus
-- --------------------------------------------------------
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `credits` int(11) NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lecturer_id` (`lecturer_id`),
  CONSTRAINT `fk_courses_lecturer` FOREIGN KEY (`lecturer_id`)
    REFERENCES `lecturers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Data contoh
-- --------------------------------------------------------
INSERT INTO `departments` (`id`, `name`, `building`) VALUES
(1, 'Ilmu Komputer', 'Gedung FPMIPA C'),
(2, 'Matematika', 'Gedung FPMIPA A'),
(3, 'Fisika', 'Gedung FPMIPA B');

INSERT INTO `lecturers` (`id`, `name`, `nidn`, `phone`, `join_date`, `department_id`) VALUES
(1, 'Budi Santoso', '0412058801', '081234567890', '2015-08-17', 1),
(2, 'Siti Rahmawati', '0425069002', '081298765432', '2018-02-01', 1),
(3, 'Andi Wijaya', '0430078503', '082111222333', '2012-09-10', 2),
(4, 'Dewi Lestari', '0415109204', '085777888999', '2020-01-15', 3);

INSERT INTO `courses` (`id`, `code`, `name`, `credits`, `lecturer_id`) VALUES
(1, 'IK101', 'Desain dan Pemrograman Berbasis Objek', 3, 1),
(2, 'IK102', 'Struktur Data', 3, 2),
(3, 'IK201', 'Teori Bahasa dan Otomata', 3, 1),
(4, 'MT101', 'Kalkulus', 3, 3),
(5, 'FS101', 'Fisika Dasar', 2, 4);
