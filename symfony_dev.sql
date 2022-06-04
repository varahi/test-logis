-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jun 04, 2022 at 06:20 PM
-- Server version: 10.3.25-MariaDB-1:10.3.25+maria~focal
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `symfony_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `title`, `description`) VALUES
(1, 'Транспортная Компания №1', NULL),
(2, 'Транспортная  Компания №2', NULL),
(3, 'Транспортная  Компания №3', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `id` int(11) NOT NULL,
  `base_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departure_id` int(11) DEFAULT NULL,
  `destination_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `company_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`id`, `base_url`, `weight`, `departure_id`, `destination_id`, `title`, `from_date`, `to_date`, `company_id`) VALUES
(1, 'Направление 1', NULL, 4, 5, 'Направление 1', '2022-07-01 00:00:00', '2022-07-03 00:00:00', 1),
(2, 'Направление 2', '250', 1, 3, 'Направление 2', '2022-06-03 21:05:00', '2022-06-03 21:05:00', 1),
(3, 'Направление 3', NULL, 1, 3, 'Направление 3', '2022-07-01 00:00:00', '2022-07-03 00:00:00', 1),
(4, 'Доставка от компании №2', NULL, 5, 1, 'Доставка от компании №2', '2023-01-01 00:00:00', '2023-01-01 00:00:00', 2),
(5, 'Доставка 2 от компании №2', NULL, 2, 1, 'Доставка 2 от компании №2', '2022-01-01 00:00:00', '2022-01-01 00:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220524165500', '2022-06-03 15:23:51', 33),
('DoctrineMigrations\\Version20220524170504', '2022-06-03 15:23:51', 73),
('DoctrineMigrations\\Version20220524180424', '2022-06-03 15:23:51', 33),
('DoctrineMigrations\\Version20220524181801', '2022-06-03 15:23:51', 22),
('DoctrineMigrations\\Version20220524182001', '2022-06-03 15:23:51', 45),
('DoctrineMigrations\\Version20220524183045', '2022-06-03 15:23:51', 35),
('DoctrineMigrations\\Version20220603115820', '2022-06-03 14:58:29', 174),
('DoctrineMigrations\\Version20220603122123', '2022-06-03 15:21:28', 113),
('DoctrineMigrations\\Version20220603122436', '2022-06-03 15:24:39', 197),
('DoctrineMigrations\\Version20220603175300', '2022-06-03 20:53:07', 108),
('DoctrineMigrations\\Version20220603175633', '2022-06-03 20:56:37', 74),
('DoctrineMigrations\\Version20220603180804', '2022-06-03 21:08:07', 20),
('DoctrineMigrations\\Version20220603180917', '2022-06-03 21:09:20', 21),
('DoctrineMigrations\\Version20220604101744', '2022-06-04 13:17:51', 32);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `title`, `description`) VALUES
(1, 'Санкт-Петербург', 'Описание Санкт-Петербург'),
(2, 'Москва', 'Это Москва'),
(3, 'Мурманск', 'Холодный Мурманск'),
(4, 'Новгород', NULL),
(5, 'Псокв', NULL),
(6, 'Магадан', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `company_id`, `delivery_id`, `title`, `created`) VALUES
(1, 1, 1, 'Order 1', '2022-06-03 18:10:10'),
(2, 1, 2, 'Test order', '2022-06-04 17:18:16'),
(3, 1, 3, 'Test order 3', '2022-06-04 17:26:46'),
(4, 2, 5, 'Заказ № 4', '2022-06-04 18:18:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3781EC107704ED06` (`departure_id`),
  ADD KEY `IDX_3781EC10816C6140` (`destination_id`),
  ADD KEY `IDX_3781EC10979B1AD6` (`company_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F5299398979B1AD6` (`company_id`),
  ADD KEY `IDX_F529939812136921` (`delivery_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `FK_3781EC107704ED06` FOREIGN KEY (`departure_id`) REFERENCES `location` (`id`),
  ADD CONSTRAINT `FK_3781EC10816C6140` FOREIGN KEY (`destination_id`) REFERENCES `location` (`id`),
  ADD CONSTRAINT `FK_3781EC10979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F529939812136921` FOREIGN KEY (`delivery_id`) REFERENCES `delivery` (`id`),
  ADD CONSTRAINT `FK_F5299398979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
