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

class channels_edits
{
	private static $name;
	private static $cfg;
	private static $time_diff = null;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}
	
	static private function check_cache(&$cache_edits)
	{
		foreach($cache_edits as $key => $time)
			if(time() - $time >= 180)
				unset($cache_edits[$key]);
	}
	
	static private function set_time_diff()
	{
		global $query;
		
		$s_logs = $query->getElement('data', $query->logView(1, 1));
		$log = explode('|', $s_logs[0]['l']);
		$date = explode(' ', $log[0]);
		$time = explode(':', $date[1]);
		$date = explode('-', $date[0]);
		$unix_time = mktime($time[0], $time[1], explode('.', $time[2])[0], $date[1], $date[2], $date[0]);
		self::$time_diff = time() - $unix_time;
	}
	
	static public function before_clients()
	{
		global $query, $clients, $language, $AutoSpeak;	
		
		if(self::$time_diff == null) self::set_time_diff();
		
		$cache_edits = json_decode(file_get_contents("include/cache/channel_edits.txt"), 1);
		if($cache_edits == null) $cache_edits = array();
		self::check_cache($cache_edits);
		
		$s_logs = $query->getElement('data', $query->logView(45, 1));
		$cache_edits_tmp = array();
		$lang = $language['function']['channels_edits'];
		
		foreach(self::$cfg['zones'] as $channel_id => $checking_channels)
		{
			$channel_info = $query->getElement('data', $query->channelInfo($channel_id));
			$channels_info = array();
			$desc = count(explode("[hr]", $channel_info['channel_description'])) == 4 ? explode("[hr]", $channel_info['channel_description'])[2] : "";
			$header = "[hr][center][b][size=15]".$lang['header']."[/size][/b]\n | ";
			$to_add = "";
			
			foreach($checking_channels as $checking_channel)
			{
				$channel_info = $query->getElement('data', $query->channelInfo($checking_channel));
				$channels_info[$checking_channel] = $channel_info['channel_name'];
				$header .= $channel_info['channel_name']." | ";
			}
			
			$header .= "[/center][hr]";
			
			foreach($s_logs as $logs)
			{
				foreach($logs as $log)
				{
					if(isset($log) && strstr($log, "channel") !== false && strstr($log, "edited") !== false)
					{
						$once_log = explode('|', $log);
						preg_match_all("/(\([a-z]+\:(\d+)\))/", trim($once_log[4]), $total_logs);
						$total_logs = array_pop($total_logs);
						
						if(count($total_logs) != 2 || !isset($total_logs[0]) || !isset($total_logs[1]))
							continue;
						
						if(in_array($total_logs[0], $checking_channels))
						{
							$client_db_info = $query->getElement('data', $query->clientDbInfo($total_logs[1]));
							$client_find = $query->getElement('data', $query->clientFind($client_db_info['client_nickname']));
							
							if(!isset($client_find[0]['clid'])) continue;
							
							$client_info = $query->getElement('data', $query->clientInfo($client_find[0]['clid']));

							if(!$AutoSpeak::has_group($client_info['client_servergroups'], self::$cfg['ignored_groups']))
							{
								$date = explode(' ', $once_log[0]);
								$time = explode(':', $date[1]);
								$date = explode('-', $date[0]);
								
								$unix_time = mktime($time[0], $time[1], explode('.', $time[2])[0], $date[1], $date[2], $date[0]);
								
								if(!array_key_exists($total_logs[0].$total_logs[1].$unix_time, $cache_edits))
								{
									$cache_edits_tmp[$total_logs[0].$total_logs[1].$unix_time] = time();
									
									$to_add .= $lang['channel']." [b][url=channelId://".$total_logs[0]."]".$channels_info[$total_logs[0]]."[/url][/b] ".$lang['was_edited']." [u][URL=client://1/".$client_info['client_unique_identifier']."]".$client_info['client_nickname']."[/URL][/u] ([b]".date('d-m-Y G:i:s', $unix_time + self::$time_diff)."[/b])\n";	
								}
							}
						}
					}
				}
			}
			
			if($to_add != "")
			{
				if($AutoSpeak::check_error($query->channelEdit($channel_id, array('channel_description' => $header.$to_add.$desc.$language['function']['down_desc'])), self::$name, $channel_id) != true)
					$query->channelEdit($channel_id, array('channel_description' => $header.$to_add.$language['function']['down_desc']));	
			}	
		}
		
		$cache = $cache_edits;
		foreach($cache_edits_tmp as $key => $info)
			$cache[$key] = $info;
		
		file_put_contents("include/cache/channel_edits.txt", json_encode($cache));
	}
}
?>