SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_phone` varchar(50) DEFAULT NULL,
  `package_id` int(11) NOT NULL,
  `travel_date` date NOT NULL,
  `num_people` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `status` enum('pending_payment','confirmed','cancelled') DEFAULT 'pending_payment',
  `booking_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `bookings` (`id`, `user_id`, `user_name`, `user_email`, `user_phone`, `package_id`, `travel_date`, `num_people`, `total_price`, `transaction_id`, `status`, `booking_date`) VALUES
(1, 1, NULL, NULL, NULL, 2, '2026-02-20', 1, 10000.00, NULL, 'confirmed', '2026-02-18 05:51:34'),
(2, 1, NULL, NULL, NULL, 1, '2026-02-20', 1, 15000.00, NULL, 'confirmed', '2026-02-18 06:13:25'),
(3, 0, NULL, NULL, NULL, 1, '2026-03-19', 1, 15000.00, NULL, 'cancelled', '2026-03-10 09:07:38'),
(4, 1, NULL, NULL, NULL, 1, '2026-03-27', 1, 15000.00, NULL, 'cancelled', '2026-03-10 09:44:00'),
(5, 1, NULL, NULL, NULL, 1, '2026-03-27', 1, 15000.00, NULL, 'cancelled', '2026-03-10 09:44:05'),
(6, 1, NULL, NULL, NULL, 1, '2026-04-03', 1, 15000.00, NULL, 'cancelled', '2026-03-10 09:53:30'),
(7, 1, NULL, NULL, NULL, 1, '2026-04-08', 1, 15000.00, NULL, 'cancelled', '2026-03-10 09:53:35'),
(8, 1, NULL, NULL, NULL, 1, '2026-04-08', 1, 15000.00, NULL, 'cancelled', '2026-03-10 09:53:36'),
(9, 1, NULL, NULL, NULL, 1, '2026-04-08', 1, 15000.00, NULL, 'confirmed', '2026-03-10 09:55:18'),
(10, 1, NULL, NULL, NULL, 1, '2026-04-08', 1, 15000.00, NULL, 'confirmed', '2026-03-10 10:00:25');

CREATE TABLE `destinations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `destinations` (`id`, `name`, `description`, `image`) VALUES
(1, 'Kashmir', 'Paradise on Earth with mountains and lakes.', 'kashmir.avif'),
(2, 'Darjeeling', 'Beautiful hill station with tea gardens.', 'darjeeling.avif'),
(3, 'Delhi', 'Capital city of India with historical monuments.', 'delhi.avif');

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `feedback` (`id`, `user_id`, `message`, `rating`) VALUES
(5, 1, 'hahaa less go', NULL),
(6, 1, 'sdhasdjfsdj', 1);

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `destination_id` int(11) DEFAULT NULL,
  `days` varchar(50) DEFAULT NULL,
  `transport` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `packages` (`id`, `destination_id`, `days`, `transport`, `price`) VALUES
(1, 1, '5 Days', 'Flight + Cab', 15000),
(2, 2, '4 Days', 'Train + Cab', 10000),
(3, 3, '3 Days', 'Train', 8000);

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Prantik', 'pihukesariya@gmail.com', '$2y$10$kkiASuWe.MRRU7XxJ2SDP.KAOwxhMw7QMjH8Xbfe2hKZLoUYvlnx2');

ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destination_id` (`destination_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `packages`
  ADD CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`);
COMMIT;