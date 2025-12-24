-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2025 at 05:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fentasyart_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` varchar(100) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `payment_proof` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `booking_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `item_name`, `item_price`, `status`, `payment_proof`, `full_name`, `email`, `phone`, `booking_date`, `notes`, `submitted_at`) VALUES
(1, 'Art Studio', 'IDR 250.000/day', 'verified', 'PAY_1766547122_6.jpg', 'Angelica Immanuela Nazarina', 'ela@gmail.com', '082264486606', '2025-12-25', '', '2025-12-24 03:05:06');

-- --------------------------------------------------------

--
-- Table structure for table `collaborations`
--

CREATE TABLE `collaborations` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date_text` varchar(100) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collaborations`
--

INSERT INTO `collaborations` (`id`, `title`, `date_text`, `image_url`) VALUES
(1, 'Digital Marketing Workshop for Artists', 'July 15, 2024', 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=2832&auto=format&fit=crop'),
(2, '“Colors of the Archipelago” Art Exhibition', 'November 20, 2024', 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2671&auto=format&fit=crop'),
(3, 'Creativepreneur Talk: From Hobby to Business', 'August 5, 2025', 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=2670&auto=format&fit=crop');

-- --------------------------------------------------------

--
-- Table structure for table `exhibitions`
--

CREATE TABLE `exhibitions` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `duration_text` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exhibitions`
--

INSERT INTO `exhibitions` (`id`, `title`, `artist`, `duration_text`, `description`, `image_url`) VALUES
(1, 'Spectrum of the Soul', 'By Various Artists', 'November 1 - December 31, 2025', 'An exhibition that explores the emotional and spiritual journey through abstract expressionism.', 'https://i.pinimg.com/736x/a2/8d/0a/a28d0aec53235e6cf880512decad7285.jpg'),
(2, 'Urban Silence', 'By Photographer Alex Chen', 'December 15, 2025 - January 15, 2026', 'A stunning collection of black and white photography capturing quiet moments in bustling cities.', 'https://i.pinimg.com/1200x/76/e9/7b/76e97b8b3768238ef8bea32bca633987.jpg'),
(3, 'Forms of Nature', 'By Sculptor Maria Garcia', 'Starts February 1, 2026', 'An exploration of natural forms and textures through innovative sculpture techniques.', 'https://i.pinimg.com/1200x/5a/24/47/5a24478e2aa6ad7b664a74dcdfe662de.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `submitted_at`) VALUES
(1, 'Nazarina', 'nazarina@gmail.com', 'project', 'hahahahahaha', '2025-11-12 11:37:36');

-- --------------------------------------------------------

--
-- Table structure for table `spaces`
--

CREATE TABLE `spaces` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spaces`
--

INSERT INTO `spaces` (`id`, `name`, `description`, `image_url`, `price_per_day`, `stock`) VALUES
(1, 'Art Studio', 'A space with perfect natural lighting for painting and creating artwork.', 'https://i.pinimg.com/736x/5f/32/87/5f32872e6b627cf020b04ea31609c5c5.jpg', 250000.00, 1),
(2, 'Photography Studio', 'Equipped with backdrops, professional lighting, and other supporting equipment.', 'https://i.pinimg.com/736x/66/4e/d6/664ed653147e0c047349a80017810ae9.jpg', 350000.00, 2),
(3, 'Workshop Room', 'Spacious room for hosting workshops, classes, or creative meetings.', 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', 500000.00, 3);

-- --------------------------------------------------------

--
-- Table structure for table `space_features`
--

CREATE TABLE `space_features` (
  `id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `feature` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `space_features`
--

INSERT INTO `space_features` (`id`, `space_id`, `feature`) VALUES
(1, 1, 'Optimal natural lighting'),
(2, 1, 'Good ventilation system'),
(3, 1, 'Material storage area'),
(4, 1, 'Art-specific sink'),
(5, 2, 'Professional lighting setup'),
(6, 2, 'Various colored backdrops'),
(7, 2, 'Makeup area'),
(8, 2, 'Equipment rental available'),
(9, 3, 'Capacity up to 20 people'),
(10, 3, 'Projector and screen'),
(11, 3, 'Sound system'),
(12, 3, 'Flexible work tables');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `role`, `image_url`) VALUES
(1, 'Angelica', 'Founder & CEO', 'https://i.pinimg.com/736x/1d/30/07/1d3007a726b68c10d1f0e005ac7a20bd.jpg'),
(2, 'Nadhif', 'Community Manager', 'https://i.pinimg.com/1200x/b9/b6/e9/b9b6e9c60ac6e5af6e37a540204eb367.jpg'),
(3, 'Firta', 'Program Director', 'https://i.pinimg.com/736x/02/0c/5f/020c5f728b8d5e5e1b095219130b8008.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Angelica', 'ela@gmail.com', 'ela123', 'user', '2025-11-29 14:06:48'),
(2, 'admin', 'admin@gmail.com', 'admin123', 'admin', '2025-11-29 14:07:25');

-- --------------------------------------------------------

--
-- Table structure for table `workshops`
--

CREATE TABLE `workshops` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `instructor` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `date_text` date DEFAULT NULL,
  `duration_text` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 20
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workshops`
--

INSERT INTO `workshops` (`id`, `category`, `title`, `instructor`, `image_url`, `date_text`, `duration_text`, `price`, `stock`) VALUES
(1, 'Oil Painting', 'Realism Techniques in Oil Painting', 'With Artist Budi Santoso', 'https://i.pinimg.com/736x/16/6d/de/166dde240d056b9e0c75edef6b3fe434.jpg', '2026-02-01', '3 Sessions (9 hours)', 750000.00, 20),
(2, 'Digital Art', 'Creating Digital Illustrations with Procreate', 'With Designer Maya Putri', 'https://i.pinimg.com/736x/6a/34/b2/6a34b23e6bc5ba860930e48234935649.jpg', '2026-02-28', '2 Sessions (6 hours)', 600000.00, 20),
(3, 'Ceramics', 'Basics of Hand-Built Ceramics', 'With Ceramic Artist Sari Dewi', 'https://columbiaassociation.org/wp-content/uploads/coEmptyBowlsBClr-e1731980420940.jpg', '2026-04-15', '4 Sessions (12 hours)', 850000.00, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collaborations`
--
ALTER TABLE `collaborations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exhibitions`
--
ALTER TABLE `exhibitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spaces`
--
ALTER TABLE `spaces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `space_features`
--
ALTER TABLE `space_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `space_id` (`space_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `workshops`
--
ALTER TABLE `workshops`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `collaborations`
--
ALTER TABLE `collaborations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exhibitions`
--
ALTER TABLE `exhibitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `spaces`
--
ALTER TABLE `spaces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `space_features`
--
ALTER TABLE `space_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `space_features`
--
ALTER TABLE `space_features`
  ADD CONSTRAINT `space_features_ibfk_1` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
