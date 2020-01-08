-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2019-11-06 16:49:28
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
-- 資料表結構 `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `City_ch` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `City_img` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `city`
--

INSERT INTO `city` (`id`, `City_ch`, `City_img`) VALUES
(1, '南投縣', 'NantouCounty.jpg'),
(2, '金門縣', 'KinmenCounty.jpg'),
(3, '臺東縣', 'TaitungCounty.jpg'),
(4, '宜蘭縣', 'YilanCounty.jpg'),
(5, '花蓮縣', 'HualienCounty.jpg'),
(6, '雲林縣', 'YunlinCounty.jpg'),
(7, '高雄市', 'KaohsiungCity.jpg'),
(8, '屏東縣', 'PingtungCounty.jpg'),
(9, '臺北市', 'TaipeiCity.jpg'),
(10, '臺南市', 'TainanCity.jpg'),
(11, '澎湖縣', 'PenghuCounty.jpg'),
(12, '彰化縣', 'ChanghuaCounty.jpg'),
(13, '臺中市', 'TaichungCity.jpg'),
(14, '嘉義縣', 'ChiayiCounty.jpg'),
(15, '連江縣', 'LienchiangCounty.jpg'),
(16, '桃園市', 'TaoyuanCity.jpg'),
(17, '新北市', 'NewTaipeiCity.jpg'),
(18, '新竹縣', 'HsinchuCounty.jpg'),
(19, '新竹市', 'HsinchuCity.jpg'),
(20, '苗栗縣', 'MiaoliCounty.jpg'),
(21, '基隆市', 'KeelungCity.jpg'),
(22, '嘉義市', 'ChiayiCity.jpg');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
