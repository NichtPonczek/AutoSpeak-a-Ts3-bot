<?php
	/********************************
 _______  __   __  _______  _______  _______  _______  _______  _______  ___   _ 
|   _   ||  | |  ||       ||       ||       ||       ||       ||   _   ||   | | |
|  |_|  ||  | |  ||_     _||   _   ||  _____||    _  ||    ___||  |_|  ||   |_| |
|       ||  |_|  |  |   |  |  | |  || |_____ |   |_| ||   |___ |       ||      _|
|       ||       |  |   |  |  |_|  ||_____  ||    ___||    ___||       ||     |_ 
|   _   ||       |  |   |  |       | _____| ||   |    |   |___ |   _   ||    _  |
|__| |__||_______|  |___|  |_______||_______||___|    |_______||__| |__||___| |_|
	********************************/

class admin
{
	private static $name;
	private static $cfg;
	
	static public function construct($command_name)
	{
		global $cfg;
		self::$cfg = $cfg[$command_name];
		self::$name = $command_name;
	}	

	static private function tip_of_words($num, $for1, $for234, $for_others)
	{
		$text = " ".$num." ";
		if($num == 1)
			return $text.$for1;
		elseif(in_array($num%10, array(2,3,4)))
			return $text.$for234;
		else return $text.$for_others; 
	}

	static private function convert_to_time($seconds)
	{
		global $language;

		$lang = $language['function']['connect_message'];

		$text = "";
		$uptime['d']=floor($seconds / 86400);
		$uptime['h']=floor(($seconds - ($uptime['d'] * 86400)) / 3600);
		$uptime['m']=floor(($seconds - (($uptime['d'] * 86400)+($uptime['h']*3600))) / 60);
		$uptime['s']=floor(($seconds - (($uptime['d'] * 86400)+($uptime['h']*3600)+($uptime['m'] * 60))));

		
		if($uptime['d'] != 0)
			$text .= self::tip_of_words($uptime['d'], $lang['one_day'], $lang['2_days'], $lang['other_days']);
		if($uptime['h'] != 0)
			$text .= self::tip_of_words($uptime['h'], $lang['one_hour'], $lang['2_hours'], $lang['other_hours']);
		if($uptime['m'] != 0)
			$text .= self::tip_of_words($uptime['m'], $lang['one_minute'], $lang['2_minutes'], $lang['other_minutes']);
		if($text == '') 
			$text .= $uptime['s'].' '.$lang['seconds'].' ';


		return $text;	}

	static private function replace($message, $db_info, $stats)
	{		
		$edited_message = array
		(
			'[nick]' => $db_info['client_nick'],
			'[dbid]' => $db_info['client_dbid'],
			'[uid]' => $db_info['client_uid'],
			'[con]' => $db_info['connections'],
			'[time_spent]' => self::convert_to_time($db_info['time_spent']/1000),
			'[today]' => $stats['groups_day_normal'],
			'[weekly]' => $stats['groups_week_normal'],
			'[monthly]' => $stats['groups_month_normal'], 
			'[total]' => $stats['groups_total_normal'], 
			'[reg_today]' => $stats['groups_day_reg'], 
			'[reg_weekly]' => $stats['groups_week_reg'], 
			'[reg_monthly]' => $stats['groups_month_reg'], 
			'[reg_total]' => $stats['groups_total_reg'],
			'[today_time]' => self::convert_to_time($stats['time_day_time']),
			'[weekly_time]' => self::convert_to_time($stats['time_week_time']), 
			'[monthly_time]' => self::convert_to_time($stats['time_month_time']), 
			'[total_time]' => self::convert_to_time($stats['time_total_time']), 
			'[off_today]' => self::convert_to_time($stats['time_day_offline']), 
			'[off_weekly]' => self::convert_to_time($stats['time_week_offline']), 
			'[off_monthly]' => self::convert_to_time($stats['time_month_offline']), 
			'[off_total]' => self::convert_to_time($stats['time_total_offline']),
		);
		return str_replace(array_keys($edited_message), array_values($edited_message), $message);
	}


	static public function main($info)
	{
		global $query, $query_sql, $language, $AutoSpeak;
	
		$lang = $language['command']['admin'];
		$msg = '';

		$result = $query_sql->query("SELECT * FROM `clients` WHERE `client_dbid`='".$info['parameters'][0][1]."'");
		
		if($result->rowCount() > 0)
		{
			$result = $result->fetch(PDO::FETCH_ASSOC);

			if($AutoSpeak::has_group($result['server_groups'], self::$cfg['admins_groups']))
			{
				$stats = $query_sql->query("SELECT * FROM `statistics` WHERE `dbid`='".$info['parameters'][0][1]."'");
				$stats = $stats->fetch(PDO::FETCH_ASSOC);

				$msg .= self::replace($lang['info'], $result, $stats);
				$query->sendMessage(1, $info['clid'], $msg);
				$msg = self::replace($lang['info_2'], $result, $stats);
				$query->sendMessage(1, $info['clid'], $msg);

				return;
			}
			else
				$msg .= $lang['no_admin'];
		}
		else
			$msg .= $lang['no_in_db'];


		$query->sendMessage(1, $info['clid'], $msg);

	}
}
?>
