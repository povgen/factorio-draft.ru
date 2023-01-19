-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 14 2020 г., 17:31
-- Версия сервера: 5.6.37
-- Версия PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `factorio-draft`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE `articles` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(11) UNSIGNED DEFAULT NULL,
  `author_id` int(11) UNSIGNED DEFAULT NULL,
  `imgurl` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `title`, `description`, `code`, `category_id`, `author_id`, `imgurl`) VALUES
(1, '213', '123', '213', NULL, 7, 'default.png'),
(2, 'test', 'sdf', 'sdf', NULL, 12, 'default.png');

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE `comment` (
  `id` int(11) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci,
  `art_id` int(11) UNSIGNED DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `comment`
--

INSERT INTO `comment` (`id`, `text`, `art_id`, `user_id`) VALUES
(1, 'коммент\r\n', 1, 7),
(15, ',kmjhgnbfvc', 1, 8),
(16, ' Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste quaerat laboriosam sint natus laborum sunt, voluptates consequuntur blanditiis omnis. Quam, ut, natus? Earum eveniet ex laudantium quas atque commodi asperiores distinctio quae, incidunt non laboriosam doloribus sequi. Cupiditate itaque nihil accusantium pariatur, in eveniet, veniam ullam voluptate a recusandae quisquam molestiae magni consequatur commodi nisi, voluptatum esse vitae laboriosam libero expedita ea vel eius quis assumenda quia. At veniam ad ipsa dolorum eum, ex vel harum quibusdam illum aspernatur neque praesentium, totam blanditiis officia officiis ducimus facere quod quam laboriosam eaque labore alias. Error amet, recusandae nam officia asperiores eos.', 1, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `rate`
--

CREATE TABLE `rate` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_user` int(11) UNSIGNED DEFAULT NULL,
  `id_article` tinyint(1) UNSIGNED DEFAULT NULL,
  `star` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `rate`
--

INSERT INTO `rate` (`id`, `id_user`, `id_article`, `star`) VALUES
(1, 8, 1, 4),
(2, 10, 1, 1),
(3, 11, 1, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`) VALUES
(5, 'Юрий', 'agatto', '$2y$10$PLiuWESYDazF8l/R2jcG/OHlCe8dywgxfxKnemeshBb1bV7oeEbXW'),
(6, 'Геннадий', 'povgen', '$2y$10$OZo8Ck56cMWh0PGnM78dZ.oy3GwQGURBYtCBut8vPxL3e2GxuGlVa'),
(7, 'гена', 'gena', '$2y$10$JU.QhwffG1gOWtfORG951enA7rEekgul14lVNLiwiyNKUdPvCYugG'),
(8, 'Гена', '123', '$2y$10$sIFc/IeI0lwMpbBMXBh/6uMQyGmrEMgcJgrQu5lzP4YYkrvTjjRCi'),
(9, 'тест', 'test', '$2y$10$dXmdXeWX8OuzgV1RdazTL.N6zyRG.Blaucc0aEwdBcsJabrXY4xSy'),
(10, 'Гена', 'povgena', '$2y$10$YpYetDY5gfdgpc8o4UnFA.W8H0fcPwrR0mn3B9QsycS.9PaNQnL2S'),
(11, 'Гена', 'vghjo', '$2y$10$BRS.qDHFcvqp09gCQydbCOff3Kf6TzqVIDIvtUnRq/CQbTUIKdLDy'),
(12, 'Гена', 'qwe', '$2y$10$tIL9QUgDFv.D.jMt1/Wj2e.EUEMUX2EVnRDHH4YV4HbniHjgJtKCe');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_articles_category` (`category_id`),
  ADD KEY `index_foreignkey_articles_author` (`author_id`);

--
-- Индексы таблицы `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_comment_art` (`art_id`),
  ADD KEY `index_foreignkey_comment_user` (`user_id`);

--
-- Индексы таблицы `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `rate`
--
ALTER TABLE `rate`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
