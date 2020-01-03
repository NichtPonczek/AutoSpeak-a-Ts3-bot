<?php

	$tables = array('clients' => 0, 'new_daily_users' => 0, 'random_group' => 0, 'statistics' => 0, 'visitors' => 0, 'vip_channels' => 0, 'yt_channels' => 0, 'actions' => 0);

	function create_table($table_name)
	{
		switch($table_name)	
		{
			case 'clients':
				$res  = "CREATE TABLE IF NOT EXISTS `clients` (
  `client_dbid` int(255) NOT NULL,
  `client_clid` int(11) NOT NULL,
  `client_nick` text COLLATE utf8mb4_general_ci NOT NULL,
  `last_nicks` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `client_uid` text CHARACTER SET latin1 NOT NULL,
  `server_groups` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `connections` int(11) NOT NULL,
  `connected_time` int(11) NOT NULL,
  `connected_time_record` bigint(255) NOT NULL,
  `idle_time_record` bigint(255) NOT NULL,
  `time_spent` bigint(255) NOT NULL,
  `idle_time_spent` bigint(255) NOT NULL,
  `week_start` int(11) NOT NULL,
  `week_start_time` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; || ALTER TABLE `clients`
 ADD PRIMARY KEY (`client_dbid`);";
				break;

			case 'new_daily_users':
				$res  = "CREATE TABLE IF NOT EXISTS `new_daily_users` (
  `client_dbid` int(255) NOT NULL,
  `client_clid` int(11) NOT NULL,
  `client_nick` text COLLATE utf8mb4_general_ci NOT NULL,
  `client_uid` text CHARACTER SET latin1 NOT NULL,
  `day` text CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; || ALTER TABLE `new_daily_users`
 ADD PRIMARY KEY (`client_dbid`);";
				break;

			case 'random_group':
				$res  = "CREATE TABLE IF NOT EXISTS `random_group` (
  `client_dbid` int(11) NOT NULL,
  `sgid` int(11) NOT NULL,
  `date` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int(11) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; || ALTER TABLE `random_group`
 ADD PRIMARY KEY (`date`);";
				break;

			case 'statistics':
				$res  = "CREATE TABLE IF NOT EXISTS `statistics` (
  `dbid` int(10) NOT NULL,
  `groups_day_start` text COLLATE utf8mb4_general_ci NOT NULL,
  `groups_day_normal` int(11) NOT NULL DEFAULT '0',
  `groups_day_reg` int(11) NOT NULL DEFAULT '0',
  `groups_week_start` text COLLATE utf8mb4_general_ci NOT NULL,
  `groups_week_normal` int(11) NOT NULL DEFAULT '0',
  `groups_week_reg` int(11) NOT NULL DEFAULT '0',
  `groups_month_start` text COLLATE utf8mb4_general_ci NOT NULL,
  `groups_month_normal` int(11) NOT NULL DEFAULT '0',
  `groups_month_reg` int(11) NOT NULL DEFAULT '0',
  `groups_total_normal` int(11) NOT NULL DEFAULT '0',
  `groups_total_reg` int(11) NOT NULL DEFAULT '0',
  `time_day_start` text COLLATE utf8mb4_general_ci NOT NULL,
  `time_day_time` bigint(20) NOT NULL DEFAULT '0',
  `time_day_offline` bigint(20) NOT NULL DEFAULT '0',
  `time_week_start` text COLLATE utf8mb4_general_ci NOT NULL,
  `time_week_time` bigint(20) NOT NULL DEFAULT '0',
  `time_week_offline` bigint(20) NOT NULL DEFAULT '0',
  `time_month_start` text COLLATE utf8mb4_general_ci NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; || ALTER TABLE `statistics`
 ADD PRIMARY KEY (`dbid`);
";
				break;

			case 'visitors':
				$res  = "CREATE TABLE IF NOT EXISTS `visitors` (
  `client_dbid` int(255) NOT NULL,
  `day` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; || ALTER TABLE `visitors`
 ADD PRIMARY KEY (`client_dbid`);";
				break;
			case 'vip_channels':
				$res  = "CREATE TABLE IF NOT EXISTS `vip_channels` (
`id` int(11) NOT NULL,
  `type_id` text COLLATE utf8mb4_general_ci NOT NULL,
  `channel_num` int(11) NOT NULL,
  `channel_cid` text COLLATE utf8mb4_general_ci NOT NULL,
  `spacer_cid` int(11) NOT NULL,
  `online_from` int(11) NOT NULL,
  `get_group` int(11) NOT NULL,
  `owner_dbid` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; || ALTER TABLE `vip_channels`
 ADD PRIMARY KEY (`id`); || ALTER TABLE `vip_channels`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
				break;
			case 'yt_channels':
				$res  = "CREATE TABLE IF NOT EXISTS `yt_channels` (
`id` int(11) NOT NULL,
  `channel_num` int(11) NOT NULL,
  `channel_cid` int(11) NOT NULL,
  `spacer_cid` int(11) NOT NULL,
  `main_info` int(11) NOT NULL,
  `videos_count` int(11) NOT NULL,
  `views_count` int(11) NOT NULL,
  `owner_dbid` int(11) NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; || ALTER TABLE `yt_channels`
 ADD PRIMARY KEY (`id`); || ALTER TABLE `yt_channels`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
				break;

			case 'actions':
				$res  = "CREATE TABLE IF NOT EXISTS `actions` (
`id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `name` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `instance_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=334 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; || ALTER TABLE `actions`
 ADD PRIMARY KEY (`id`); || ALTER TABLE `actions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
				break;
				
			default:
				$res = "ERROR";
				break;
		}

		return $res;
	}


	$new_columns = array
	(
		'clients' => array
		(
			'idle_time_spent' => 'bigint(255) NOT NULL',
			'week_start' => 'int(11) NOT NULL',
			'week_start_time' => 'int(255) NOT NULL',
			'last_nicks' => 'longtext COLLATE utf8mb4_general_ci NOT NULL',
			'connected_time' => 'int(11) NOT NULL',
		),
		'vip_channels' => array
		(
			'type_id' => 'text COLLATE utf8mb4_general_ci NOT NULL',
		),
		'statistics' => array
		(
		  'help_day_start' => "text COLLATE utf8_polish_ci NOT NULL",
		  'help_day_time' => "int(11) NOT NULL DEFAULT '0'",
		  'help_day_count' => "int(11) NOT NULL DEFAULT '0'",
		  'help_week_start' => "text COLLATE utf8_polish_ci NOT NULL",
		  'help_week_time' => "int(11) NOT NULL DEFAULT '0'",
		  'help_week_count' => "int(11) NOT NULL DEFAULT '0'",
		  'help_month_start' => "text COLLATE utf8_polish_ci NOT NULL",
		  'help_month_time' => "int(11) NOT NULL DEFAULT '0'",
		  'help_month_count' => "int(11) NOT NULL DEFAULT '0'",
		  'help_total_time' => "int(11) NOT NULL DEFAULT '0'",
		  'help_total_count' => "int(11) NOT NULL DEFAULT '0'",
		),
	);
	
	$edits = array
	(
		'vip_channels' => array
		(
			'channel_cid' => array('from' => 'int(11)', 'to' => 'text COLLATE utf8mb4_general_ci NOT NULL'),
		),
	);

?>
