-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 16 2022 г., 20:21
-- Версия сервера: 8.0.27
-- Версия PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kino`
--
CREATE DATABASE IF NOT EXISTS `kino` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `kino`;

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `test` ()  begin
	declare d float;
    declare c float;
    select sum(rate), count(*) from expert_rate where id_meet=1  into d,c;
    select d/c;
 end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `director`
--

CREATE TABLE `director` (
  `id_d` int NOT NULL,
  `name_d` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `director`
--

INSERT INTO `director` (`id_d`, `name_d`) VALUES
(1, 'Френсис Форд Коппола'),
(2, 'Уильям Уайлер'),
(4, ' Флориан Хенкель фон Доннерсмарк'),
(5, 'Йоргос Лантимос'),
(6, 'Вуди Аллен');

-- --------------------------------------------------------

--
-- Структура таблицы `expert`
--

CREATE TABLE `expert` (
  `id_e` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default.jpg',
  `login` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `expert`
--

INSERT INTO `expert` (`id_e`, `name`, `avatar`, `login`, `password`) VALUES
(1, 'Ваня', 'ivan.jpg', 'pontiypilat', '0'),
(2, 'Дима', 'dima.jpg', 'nupellot', '0'),
(3, 'Альвар', 'alvar.png', 'alvarr', '0'),
(4, 'Даня', 'dan.jpg', 'DanilKochura', 'Danil2002'),
(5, 'Стас', 'stas.jpg', 'lazarestas', '0'),
(6, 'Дмитрий Сергеевич', 'sergeevich.jpg', 'lnkavai', '0'),
(7, 'Арсен', 'arsen.jpg', 'arsenkhad', 'IMDIBIL'),
(29, 'Danil', 'root.jpg', 'root', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Структура таблицы `expert_rate`
--

CREATE TABLE `expert_rate` (
  `id_rate` int NOT NULL,
  `id_meet` int DEFAULT NULL,
  `id_exp` int DEFAULT NULL,
  `rate` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `expert_rate`
--

INSERT INTO `expert_rate` (`id_rate`, `id_meet`, `id_exp`, `rate`) VALUES
(1, 1, 1, 8),
(2, 1, 3, 8),
(3, 1, 2, 7),
(4, 1, 4, 7),
(5, 2, 1, 7),
(6, 2, 3, 7),
(7, 2, 2, 7),
(8, 2, 4, 7),
(9, 3, 3, 9),
(10, 3, 4, 9),
(11, 3, 2, 8),
(12, 3, 1, 9),
(13, 4, 3, 9),
(14, 4, 4, 7),
(15, 4, 2, 7),
(16, 4, 1, 8),
(17, 4, 5, 8),
(18, 5, 5, 7),
(19, 5, 3, 6),
(20, 5, 4, 7),
(21, 5, 2, 5),
(22, 5, 1, 8),
(27, 6, 3, 8),
(28, 6, 4, 10),
(29, 6, 2, 6),
(30, 6, 1, 8),
(31, 6, 6, 7),
(32, 7, 2, 8),
(33, 7, 7, 7),
(34, 7, 1, 7),
(35, 7, 6, 8),
(36, 7, 4, 6),
(37, 7, 5, 6),
(38, 7, 3, 6);

--
-- Триггеры `expert_rate`
--
DELIMITER $$
CREATE TRIGGER `delt` BEFORE DELETE ON `expert_rate` FOR EACH ROW BEGIN
DECLARE s FLOAT;
DECLARE co FLOAT;
DECLARE res FLOAT;
DECLARE id INT;

SELECT SUM(rate), COUNT(*), id_m FROM expert_rate JOIN meeting USING(id_meet) WHERE meeting.id_meet=old.id_meet into s,co, id;
UPDATE movie 
SET our_rate=ROUND(s/co, 1)
WHERE id_m=id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `rate_math` AFTER INSERT ON `expert_rate` FOR EACH ROW BEGIN
DECLARE s FLOAT;
DECLARE co FLOAT;
DECLARE res FLOAT;
DECLARE id INT;

SELECT SUM(rate), COUNT(*), id_m FROM expert_rate JOIN meeting USING(id_meet) WHERE meeting.id_meet=new.id_meet into s,co, id;
UPDATE movie 
SET our_rate=ROUND(s/co, 1)
WHERE id_m=id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `genre`
--

CREATE TABLE `genre` (
  `id_g` int NOT NULL,
  `name_g` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `genre`
--

INSERT INTO `genre` (`id_g`, `name_g`) VALUES
(1, 'драма'),
(2, 'мелодрама'),
(3, 'комедия'),
(4, 'военный'),
(5, 'боевик'),
(6, 'детектив'),
(7, 'триллер'),
(8, 'фантастика'),
(9, 'фэнтези');

-- --------------------------------------------------------

--
-- Структура таблицы `gen_to_mov`
--

CREATE TABLE `gen_to_mov` (
  `id_s` int NOT NULL,
  `id_g` int DEFAULT NULL,
  `id_m` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `gen_to_mov`
--

INSERT INTO `gen_to_mov` (`id_s`, `id_g`, `id_m`) VALUES
(1, 4, 1),
(2, 1, 1),
(3, 2, 2),
(4, 1, 2),
(5, 3, 2),
(7, 2, 3),
(8, 3, 3),
(9, 6, 4),
(10, 1, 4),
(11, 8, 5),
(12, 1, 5),
(13, 7, 5),
(14, 9, 6),
(15, 2, 6),
(16, 3, 6),
(17, 5, 7),
(18, 7, 7),
(19, 6, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `meeting`
--

CREATE TABLE `meeting` (
  `id_meet` int NOT NULL,
  `number` int NOT NULL,
  `id_m` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `meeting`
--

INSERT INTO `meeting` (`id_meet`, `number`, `id_m`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `movie`
--

CREATE TABLE `movie` (
  `id_m` int NOT NULL,
  `name_m` varchar(45) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `rating_kp` float NOT NULL,
  `year_of_cr` int DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `director` int DEFAULT NULL,
  `our_rate` float DEFAULT NULL,
  `original` varchar(45) DEFAULT NULL,
  `poster` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `movie`
--

INSERT INTO `movie` (`id_m`, `name_m`, `rating`, `rating_kp`, `year_of_cr`, `duration`, `director`, `our_rate`, `original`, `poster`) VALUES
(1, 'Апокалипсис сегодня', 8.5, 8.1, 1979, 194, 1, 7.4, 'Apocalypse now', 'image/apocalypse.jpg'),
(2, 'Завтрак у Тиффани', 7.6, 8, 1961, 115, 2, 6.8, 'Breakfast at Tiffany`s', 'image\\tiffany.jpg'),
(3, 'Римские каникулы', 8, 8.3, 1953, 118, 2, 8.6, 'Roman Holiday', 'image/roman.jpg'),
(4, 'Жизнь других', 8.4, 8.1, 2006, 137, 4, 7.3, 'Das Leben der Anderen', 'image/other.jpg'),
(5, 'Лобстер', 7.1, 7, 2015, 119, 5, 6.8, 'The Lobster', 'image/lobster.jpg'),
(6, 'Полночь в Париже', 7.7, 7.7, 2011, 94, 6, 7.8, 'Midnight in Paris', 'image/midnight.jpg'),
(7, 'Убийца', 7.2, 7.6, 2015, 121, 6, 7, 'Sicario', 'image\\sicario.jpg\r\n');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `director`
--
ALTER TABLE `director`
  ADD PRIMARY KEY (`id_d`);

--
-- Индексы таблицы `expert`
--
ALTER TABLE `expert`
  ADD PRIMARY KEY (`id_e`);

--
-- Индексы таблицы `expert_rate`
--
ALTER TABLE `expert_rate`
  ADD PRIMARY KEY (`id_rate`),
  ADD KEY `id_exp_idx` (`id_exp`),
  ADD KEY `id_meet_idx` (`id_meet`);

--
-- Индексы таблицы `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id_g`);

--
-- Индексы таблицы `gen_to_mov`
--
ALTER TABLE `gen_to_mov`
  ADD PRIMARY KEY (`id_s`),
  ADD KEY `id_genre_idx` (`id_g`),
  ADD KEY `id_movie_idx` (`id_m`);

--
-- Индексы таблицы `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`id_meet`),
  ADD UNIQUE KEY `number_UNIQUE` (`number`),
  ADD KEY `id_movie_idx` (`id_m`);

--
-- Индексы таблицы `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id_m`),
  ADD KEY `id_dir_idx` (`director`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `expert`
--
ALTER TABLE `expert`
  MODIFY `id_e` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `expert_rate`
--
ALTER TABLE `expert_rate`
  MODIFY `id_rate` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT для таблицы `gen_to_mov`
--
ALTER TABLE `gen_to_mov`
  MODIFY `id_s` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `meeting`
--
ALTER TABLE `meeting`
  MODIFY `id_meet` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `expert_rate`
--
ALTER TABLE `expert_rate`
  ADD CONSTRAINT `id_exp` FOREIGN KEY (`id_exp`) REFERENCES `expert` (`id_e`),
  ADD CONSTRAINT `id_meet` FOREIGN KEY (`id_meet`) REFERENCES `meeting` (`id_meet`);

--
-- Ограничения внешнего ключа таблицы `gen_to_mov`
--
ALTER TABLE `gen_to_mov`
  ADD CONSTRAINT `id_genre` FOREIGN KEY (`id_g`) REFERENCES `genre` (`id_g`),
  ADD CONSTRAINT `id_movie` FOREIGN KEY (`id_m`) REFERENCES `movie` (`id_m`);

--
-- Ограничения внешнего ключа таблицы `meeting`
--
ALTER TABLE `meeting`
  ADD CONSTRAINT `id_m` FOREIGN KEY (`id_m`) REFERENCES `movie` (`id_m`);

--
-- Ограничения внешнего ключа таблицы `movie`
--
ALTER TABLE `movie`
  ADD CONSTRAINT `id_dir` FOREIGN KEY (`director`) REFERENCES `director` (`id_d`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
