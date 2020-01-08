-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2019-11-06 16:50:47
-- 伺服器版本： 10.4.8-MariaDB
-- PHP 版本： 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `jhongcorn`
--

-- --------------------------------------------------------

--
-- 資料表結構 `room_order`
--

CREATE TABLE `room_order` (
  `Order_Id` int(11) NOT NULL,
  `hotel_Id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_Id` int(11) NOT NULL,
  `OAuth_Id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Checkin_date` date NOT NULL,
  `Checkout_date` date NOT NULL,
  `adult` int(11) NOT NULL,
  `child` int(11) NOT NULL,
  `nights` int(11) NOT NULL,
  `room` int(30) NOT NULL,
  `times` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `room_order`
--

INSERT INTO `room_order` (`Order_Id`, `hotel_Id`, `customer_Id`, `OAuth_Id`, `Checkin_date`, `Checkout_date`, `adult`, `child`, `nights`, `room`, `times`) VALUES
(4, 'C4_315080000H_000807', 13, '108720019983307745004', '2019-11-20', '2019-11-21', 2, 6, 1, 1, '2019-11-02 15:10:00'),
(17, 'C4_315080000H_000154', 13, '108720019983307745004', '2019-11-14', '2019-11-15', 2, 0, 1, 1, '2019-11-06 16:31:59'),
(18, 'C4_315080000H_000154', 13, '108720019983307745004', '2019-11-21', '2019-11-22', 2, 0, 1, 1, '2019-11-06 16:32:17');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `room_order`
--
ALTER TABLE `room_order`
  ADD PRIMARY KEY (`Order_Id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `room_order`
--
ALTER TABLE `room_order`
  MODIFY `Order_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
