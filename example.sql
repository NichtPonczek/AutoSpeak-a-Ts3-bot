-- Host: localhost
-- Time: 29 Dec 2019, 11:37
-- Server: 5.7.28-0ubuntu0.16.04.2
-- PHP: 7.0.33-0ubuntu0.16.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Db: `AutoSpeak`
--

-- --------------------------------------------------------

CREATE TABLE `actions` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `name` longtext COLLATE utf8_polish_ci NOT NULL,
  `text` longtext COLLATE utf8_polish_ci NOT NULL,
  `instance_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------


CREATE TABLE `clients` (
  `client_dbid` bigint(255) NOT NULL,
  `client_clid` bigint(11) NOT NULL,
  `client_nick` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `last_nicks` longtext CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `client_uid` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `server_groups` longtext CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `connections` bigint(200) NOT NULL,
  `connected_time` bigint(255) NOT NULL DEFAULT '0',
  `connected_time_record` bigint(255) NOT NULL,
  `idle_time_record` bigint(255) NOT NULL,
  `time_spent` bigint(255) NOT NULL,
  `idle_time_spent` bigint(255) NOT NULL,
  `week_start` int(11) DEFAULT NULL,
  `week_start_time` int(255) UNSIGNED NOT NULL,
  `banner_clock` int(11) NOT NULL DEFAULT '1',
  `banner_additional` int(11) NOT NULL DEFAULT '1',
  `banner_online` int(11) NOT NULL DEFAULT '1',
  `banner_admins` int(11) NOT NULL DEFAULT '1',
  `banner_date` int(11) NOT NULL DEFAULT '1',
  `banner_weather` int(11) NOT NULL DEFAULT '1',
  `banner_bg` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

CREATE TABLE `new_daily_users` (
  `client_dbid` int(255) NOT NULL,
  `client_clid` int(11) NOT NULL,
  `client_nick` text CHARACTER SET latin1 NOT NULL,
  `client_uid` text CHARACTER SET latin1 NOT NULL,
  `day` text CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------


CREATE TABLE `random_group` (
  `client_dbid` int(11) NOT NULL,
  `sgid` int(11) NOT NULL,
  `date` bigint(255) NOT NULL,
  `time` bigint(20) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------


CREATE TABLE `statistics` (
  `dbid` int(10) NOT NULL,
  `groups_day_start` text COLLATE utf8_polish_ci NOT NULL,
  `groups_day_normal` int(11) NOT NULL DEFAULT '0',
  `groups_day_reg` int(11) NOT NULL DEFAULT '0',
  `groups_week_start` text COLLATE utf8_polish_ci NOT NULL,
  `groups_week_normal` int(11) NOT NULL DEFAULT '0',
  `groups_week_reg` int(11) NOT NULL DEFAULT '0',
  `groups_month_start` text COLLATE utf8_polish_ci NOT NULL,
  `groups_month_normal` int(11) NOT NULL DEFAULT '0',
  `groups_month_reg` int(11) NOT NULL DEFAULT '0',
  `groups_total_normal` int(11) NOT NULL DEFAULT '0',
  `groups_total_reg` int(11) NOT NULL DEFAULT '0',
  `time_day_start` text COLLATE utf8_polish_ci NOT NULL,
  `time_day_time` bigint(20) NOT NULL DEFAULT '0',
  `time_day_offline` bigint(20) NOT NULL DEFAULT '0',
  `time_week_start` text COLLATE utf8_polish_ci NOT NULL,
  `time_week_time` bigint(20) NOT NULL DEFAULT '0',
  `time_week_offline` bigint(20) NOT NULL DEFAULT '0',
  `time_month_start` text COLLATE utf8_polish_ci NOT NULL,
  `time_month_time` bigint(20) NOT NULL DEFAULT '0',
  `time_month_offline` bigint(11) NOT NULL DEFAULT '0',
  `time_total_time` bigint(20) NOT NULL DEFAULT '0',
  `time_total_offline` bigint(20) NOT NULL DEFAULT '0',
  `help_day_start` text COLLATE utf8_polish_ci NOT NULL,
  `help_day_time` int(11) NOT NULL DEFAULT '0',
  `help_day_count` int(11) NOT NULL DEFAULT '0',
  `help_week_start` text COLLATE utf8_polish_ci NOT NULL,
  `help_week_time` int(11) NOT NULL DEFAULT '0',
  `help_week_count` int(11) NOT NULL DEFAULT '0',
  `help_month_start` text COLLATE utf8_polish_ci NOT NULL,
  `help_month_time` int(11) NOT NULL DEFAULT '0',
  `help_month_count` int(11) NOT NULL DEFAULT '0',
  `help_total_time` int(11) NOT NULL DEFAULT '0',
  `help_total_count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

CREATE TABLE `vip_channels` (
  `id` int(11) NOT NULL,
  `type_id` text COLLATE utf8_polish_ci NOT NULL,
  `channel_num` int(11) NOT NULL,
  `channel_cid` text COLLATE utf8_polish_ci NOT NULL,
  `spacer_cid` int(11) NOT NULL,
  `online_from` int(11) NOT NULL,
  `get_group` int(11) NOT NULL,
  `owner_dbid` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


INSERT INTO `vip_channels` (`id`, `type_id`, `channel_num`, `channel_cid`, `spacer_cid`, `online_from`, `get_group`, `owner_dbid`, `group_id`, `created`) VALUES
(1, 'Diamond', 1, '6', 7, 9, 10, 2, 10, 1573919864),
(2, 'VIP', 1, '22', 23, 25, 26, 2, 11, 1573920010);

-- --------------------------------------------------------


CREATE TABLE `visitors` (
  `client_dbid` int(255) NOT NULL,
  `day` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

CREATE TABLE `yt_channels` (
  `id` int(11) NOT NULL,
  `channel_num` int(11) NOT NULL,
  `channel_cid` int(11) NOT NULL,
  `spacer_cid` int(11) NOT NULL,
  `main_info` int(11) NOT NULL,
  `videos_count` int(11) NOT NULL,
  `views_count` int(11) NOT NULL,
  `owner_dbid` int(11) NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Index
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_dbid`);

--
-- Indexes for table `new_daily_users`
--
ALTER TABLE `new_daily_users`
  ADD PRIMARY KEY (`client_dbid`);

--
-- Indexes for table `random_group`
--
ALTER TABLE `random_group`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`dbid`);

--
-- Indexes for table `vip_channels`
--
ALTER TABLE `vip_channels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`client_dbid`);

--
-- Indexes for table `yt_channels`
--
ALTER TABLE `yt_channels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1406;
--
-- AUTO_INCREMENT dla tabeli `vip_channels`
--
ALTER TABLE `vip_channels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT dla tabeli `yt_channels`
--
ALTER TABLE `yt_channels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
