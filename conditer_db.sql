-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 21 2025 г., 19:42
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `conditer_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `order_date`) VALUES
(1, 1, 1, '2025-03-21 17:41:56'),
(2, 1, 7, '2025-03-21 17:47:53'),
(3, 1, 2, '2025-03-21 17:47:57'),
(4, 1, 3, '2025-03-21 17:52:40'),
(5, 1, 6, '2025-03-21 18:00:24');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `description`, `category`) VALUES
(1, 'Форма для выпечки', 500.00, './img/1.jpg', 'Форма для выпечки диаметром 25 см', 'Инструменты'),
(2, 'Шоколад', 150.00, ' ./img/2.jpeg', 'Шоколад высокого качества', 'Ингредиенты'),
(3, 'Шприц для крема', 350.00, './img/3.jpg', NULL, 'Инструменты'),
(4, 'Матовое стекло для декора', 500.00, './img/4.jpeg', NULL, 'Инструменты'),
(5, 'Кондитерский мешок', 150.00, './img/5.jpg', NULL, 'Инструменты'),
(6, 'Термометр для шоколада', 1200.00, './img/6.jpeg', NULL, 'Оборудование'),
(7, 'Шаблон для выпечки', 220.00, './img/7.jpeg', NULL, 'Инструменты'),
(8, 'Кондитерская кисть', 100.00, './img/8.jpeg', NULL, 'Инструменты'),
(9, 'Миксер для теста', 3500.00, './img/9.jpg', NULL, 'Оборудование'),
(10, 'Форма для шоколадок', 800.00, './img/10.jpeg', NULL, 'Формы для выпечки'),
(11, 'Лопатка для крема', 250.00, './img/11.jpeg', NULL, 'Инструменты'),
(12, 'Кулинарный термометр', 900.00, './img/12.jpeg', NULL, 'Оборудование'),
(13, 'Цветные посыпки', 150.00, './img/13.jpeg', NULL, 'Декор'),
(14, 'Пластиковые формы для печенья', 300.00, './img/14.jpeg', NULL, 'Формы для выпечки'),
(15, 'Набор кондитерских насадок', 450.00, './img/15.jpg\r\n', NULL, 'Инструменты'),
(16, 'Форма для торта', 600.00, './img/16.jpg', NULL, 'Формы для выпечки');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `first_name`, `last_name`, `created_at`, `updated_at`) VALUES
(1, 'Магомедсаид', 'nexusAllClose1@gmail.com', '$2y$10$JY9H3qVP.6NnMvWkGSPLQuFgK4EdM2sniNeBTSDwqF8OTmJSB5uXa', NULL, NULL, '2025-03-20 23:56:04', '2025-03-20 23:56:04'),
(3, 'medjjjidov', 'wer@gmail.com', '$2y$10$Sz6y.RTwvG4Jt1jL6/eYAuvLKD5k0U0VZ42u/LoxjE4hYW/U6Jz2.', NULL, NULL, '2025-03-21 00:27:55', '2025-03-21 00:27:55'),
(4, 'medjjjidof', 'alex882211@ya.ru', '$2y$10$Zc7uxfCfTRXApXIZBUsSEeIwEz0808PAqup2eFU4N8XU8TGnhtqAa', NULL, NULL, '2025-03-21 00:29:50', '2025-03-21 00:29:50'),
(5, 'nneexxuuss', '123@gmail.com', '$2y$10$z2InvLoZiOIz8gz8HQDacuKrZB7uoCcx5x2TD6oeZMvXd/G234/Ju', NULL, NULL, '2025-03-21 00:35:23', '2025-03-21 00:35:23'),
(6, 'dede', 'cdwcfw@gmail.com', '$2y$10$ELzFTa0.GFnmoBl/YOZYs.NUDjXjMcDEUZxdFalGYH7372EuuerpW', NULL, NULL, '2025-03-21 00:52:39', '2025-03-21 00:52:39'),
(7, 'dqwdq', 'vfuf@gmail.com', '$2y$10$eaVgr6pwdl2Zt3jyIfl1HOm/bRafAGf918X2yL6VxS2huIlxSKfEW', NULL, NULL, '2025-03-21 00:53:06', '2025-03-21 00:53:06'),
(8, 'Фатима', 'fatima@gmail.com', '$2y$10$.P4/EnCFOXW0soV4DYtCwOc1wC2mjbDfE9VkTk7y2UQxJ0/De4wBW', NULL, NULL, '2025-03-21 13:01:00', '2025-03-21 13:01:00'),
(9, 'мага', 'razakov@gmail.com', '$2y$10$6Rzp1/294aWU0..FPuhP7O/eyiOgk9yiVB.p/E2jroowU7N4HULxe', NULL, NULL, '2025-03-21 17:56:50', '2025-03-21 17:56:50');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
