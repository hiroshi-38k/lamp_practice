-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2020 年 7 月 13 日 05:30
-- サーバのバージョン： 10.5.4-MariaDB
-- PHP のバージョン: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `sample`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `details`
--

CREATE TABLE `details` (
  `detail_id` int(11) NOT NULL,
  `history_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `details`
--

INSERT INTO `details` (`detail_id`, `history_id`, `item_id`, `price`, `amount`) VALUES
(1, 5, 32, 100, 1),
(2, 5, 33, 50000, 1),
(7, 8, 32, 100, 2),
(8, 8, 33, 50000, 1),
(9, 9, 32, 100, 1),
(10, 9, 33, 50000, 1),
(11, 10, 32, 100, 1),
(12, 10, 33, 50000, 2),
(13, 11, 32, 100, 1),
(14, 12, 32, 100, 3),
(15, 13, 32, 100, 1),
(16, 14, 34, 1000000, 1),
(17, 15, 34, 1000000, 1),
(18, 15, 32, 100, 1),
(19, 16, 36, 2000000, 1),
(20, 16, 33, 50000, 1),
(21, 17, 36, 2000000, 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `histories`
--

CREATE TABLE `histories` (
  `history_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `histories`
--

INSERT INTO `histories` (`history_id`, `user_id`, `created`) VALUES
(5, 4, '2020-07-08 02:37:16'),
(8, 4, '2020-07-08 03:19:19'),
(9, 4, '2020-07-08 03:20:19'),
(10, 8, '2020-07-08 09:49:11'),
(11, 8, '2020-07-08 13:29:13'),
(12, 8, '2020-07-08 13:29:23'),
(13, 4, '2020-07-09 01:11:27'),
(14, 4, '2020-07-09 06:10:43'),
(15, 4, '2020-07-13 04:46:32'),
(16, 4, '2020-07-13 04:58:33'),
(17, 8, '2020-07-13 04:58:55');

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `items`
--

INSERT INTO `items` (`item_id`, `name`, `stock`, `price`, `image`, `status`, `created`, `updated`) VALUES
(32, 'dog', 39, 100, 'ny1owjn3yqs0cow8w4ws.jpg', 1, '2019-08-09 09:12:30', '2020-07-13 13:46:32'),
(33, 'ハリネズミ', 59, 50000, '16scmunsexdwcosw88g0.jpg', 1, '2019-08-09 09:13:33', '2020-07-13 13:58:33'),
(34, 'ライオン', 98, 1000000, '3mty1yrcba0w84gwc084.jpg', 1, '2020-07-09 10:20:40', '2020-07-13 13:46:32'),
(35, 'チーター', 50, 200000, '60qkj5w1mxcs80oogcoo.jpg', 1, '2020-07-09 10:28:54', '2020-07-09 14:24:58'),
(36, 'キジ', 38, 2000000, '5d6idsd1yf8koo8swwok.jpg', 1, '2020-07-13 13:57:46', '2020-07-13 13:58:55');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 2,
  `created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`user_id`, `name`, `password`, `type`, `created`, `updated`) VALUES
(1, 'sampleuser', '$2y$10$SFrn0kIrsgwRglj52fygye9HkDNZO3RbTNre0dZid/fcd5nDTP2r6', 2, '2020-07-07 12:01:39', '2019-08-07 01:17:12'),
(4, 'admin', '$2y$10$ywRppndJh7C1rClH8vAyzuvX4agd.3B3mO5cfOxNOFuv1tDo2ogT.', 1, '2020-07-07 10:48:24', '2019-08-07 10:45:11'),
(8, 'testtest', '$2y$10$hQMRexDuP27Ckq6AGuK4eOBdbIojylIS0XoZPTZn.GhM/7/74zVqG', 2, '2020-07-07 10:49:46', '2020-07-02 11:13:24'),
(9, 'testtest2', '$2y$10$At/aKqWU5S7O2KdjQ3FdRufxI1UxwuMRYwF2Yh.zGEj89eIqquTAW', 2, '2020-07-07 10:50:12', '2020-07-06 18:49:00'),
(10, 'testtest3', '$2y$10$YgJy./hE8R1DRwZadIZxgeDs1UkX285rRz5G31Dl2PF8D6pnZgYf2', 2, '2020-07-07 10:50:42', '2020-07-06 21:49:05'),
(11, 'test4test4', '$2y$10$JLm0c0ZyIYoruufS.Z3mteAM2.JborQj3A147BDQU7iDqri/hQYFe', 2, '2020-07-07 10:51:47', '2020-07-07 10:51:47'),
(12, 'test5test5', '$2y$10$f4ASMstV0EgJH9Eb9oAht.95JFpFfIX2/37ciwdjPVjtTw84iSOia', 2, '2020-07-07 10:52:55', '2020-07-07 10:52:55');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- テーブルのインデックス `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`detail_id`);

--
-- テーブルのインデックス `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`history_id`);

--
-- テーブルのインデックス `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- テーブルのAUTO_INCREMENT `details`
--
ALTER TABLE `details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- テーブルのAUTO_INCREMENT `histories`
--
ALTER TABLE `histories`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- テーブルのAUTO_INCREMENT `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- テーブルのAUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
