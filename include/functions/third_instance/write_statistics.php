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

class write_statistics
{
	private static $name;
	private static $cfg;
	private static $admins;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$admins = $cfg[$event_name]['admins_groups'];
		self::$name = $event_name;
	}
	
	static private function client_url($client)
	{
   		if($client)
        		return "[url=client://0/".$client['client_unique_identifier']."]".$client['client_nickname']."[/url]";
    		else	
        		return false;
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

		return $text;
	}

	static public function before_clients()
	{
		global $query, $clients, $language, $query_sql, $AutoSpeak;

		$lang = $language['function']['write_statistics'];
		$i = 0;
		$groups_list = $query->getElement('data', $query->serverGroupList());

		$groups_desc = "[hr][center]".self::$cfg['groups']['top_description']."[/center][hr]";
		$time_spent_desc = "[hr][center]".self::$cfg['timespent']['top_description']."[/center][hr]";
		$help_center_desc = "[hr][center]".self::$cfg['help_center']['top_description']."[/center][hr]";

		$result = $query_sql->query("SELECT * FROM statistics")->fetchAll(PDO::FETCH_ASSOC);
		$total = 0;
		
		foreach(self::$admins as $admin_group)
		{
			foreach($result as $client)
			{
				$clientinfo = $query->getElement('data', $query->clientDbInfo($client['dbid']));

				$client_from_db = $query_sql->query("SELECT * FROM clients WHERE client_dbid=".$client['dbid']."")->fetch(PDO::FETCH_ASSOC);
			
				if(!in_array($admin_group, explode(',', $client_from_db['server_groups'])))
					continue;
				else
					$total++;	
			}
		}

		foreach(self::$admins as $admin_group)
		{
			foreach($groups_list as $group_info)
				if($group_info['sgid'] == $admin_group)
					$name = $group_info['name'];


			foreach($result as $client)
			{
				$clientinfo = $query->getElement('data', $query->clientDbInfo($client['dbid']));

				$client_from_db = $query_sql->query("SELECT * FROM clients WHERE client_dbid=".$client['dbid']."")->fetch(PDO::FETCH_ASSOC);
			
				if(!in_array($admin_group, explode(',', $client_from_db['server_groups'])))
					continue;

				if($clientinfo)
				{
					$i++;

					$groups_desc .= str_replace(['[num]', '[client]', '[rang_name]', '[today]', '[weekly]', '[monthly]', '[total]', '[reg_today]', '[reg_weekly]', '[reg_monthly]', '[reg_total]'], [$i, self::client_url($clientinfo), $name, $client['groups_day_normal'], $client['groups_week_normal'], $client['groups_month_normal'], $client['groups_total_normal'], $client['groups_day_reg'], $client['groups_week_reg'], $client['groups_month_reg'], $client['groups_total_reg']], $lang['groups']);
					$time_spent_desc .= str_replace(['[num]', '[client]', '[rang_name]', '[today]', '[weekly]', '[monthly]', '[total]', '[off_today]', '[off_weekly]', '[off_monthly]', '[off_total]'], [$i, self::client_url($clientinfo), $name, self::convert_to_time($client['time_day_time']), self::convert_to_time($client['time_week_time']), self::convert_to_time($client['time_month_time']), self::convert_to_time($client['time_total_time']), self::convert_to_time($client['time_day_offline']), self::convert_to_time($client['time_week_offline']), self::convert_to_time($client['time_month_offline']), self::convert_to_time($client['time_total_offline'])], $lang['time_spent']);	
					$help_center_desc .= str_replace(['[num]', '[client]', '[rang_name]', '[today_count]', '[weekly_count]', '[monthly_count]', '[total_count]', '[today_time]', '[weekly_time]', '[monthly_time]', '[total_time]'], [$i, self::client_url($clientinfo), $name, $client['help_day_count'], $client['help_week_count'], $client['help_month_count'], $client['help_total_count'], self::convert_to_time($client['help_day_time']), self::convert_to_time($client['help_week_time']), self::convert_to_time($client['help_month_time']), self::convert_to_time($client['help_total_time'])], $lang['help_center']);	
		
					if($i != $total)
					{
						$groups_desc .= "[hr]";
						$time_spent_desc .= "[hr]";
						$help_center_desc .= "[hr]";
					}
				}
				
			}
		}

		$groups_desc .= $language['function']['down_desc'];
		$time_spent_desc .= $language['function']['down_desc'];
		
		$AutoSpeak::check_error($query->channelEdit(self::$cfg['groups']['channelid'], array('channel_description' => $groups_desc)), self::$name, self::$cfg['groups']['channelid'], true);
		$AutoSpeak::check_error($query->channelEdit(self::$cfg['timespent']['channelid'], array('channel_description' => $time_spent_desc)), self::$name, self::$cfg['timespent']['channelid'], true);		
		$AutoSpeak::check_error($query->channelEdit(self::$cfg['help_center']['channelid'], array('channel_description' => $help_center_desc)), self::$name, self::$cfg['help_center']['channelid'], true);		
	}
}
?>