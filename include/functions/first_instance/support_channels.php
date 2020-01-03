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

class support_channels
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}

	static private function check_date($time_open, $time_close)
	{
		$time_open = explode(":", $time_open);
		$time_close = explode(":", $time_close);
		$clock_open = mktime($time_open[0], $time_open[1], 0, date('m'), date('d'), date('Y'));
		$clock_close = mktime($time_close[0], $time_close[1], 0, date('m'), date('d'), date('Y'));

		if(time()>=$clock_open && time()<$clock_close)
			return true;
		else
			return false;
	}

	static private function open_channel($info)
	{
		global $query, $AutoSpeak;

		$channel = array();
		$del[NEEDED_JOIN_POWER] = 0;

		if($info['change_maxfamily_clients'])
		{
			$channel['channel_flag_maxfamilyclients_unlimited'] = 1;
			$channel['channel_flag_maxfamilyclients_inherited'] = 0;
			$channel['channel_maxfamilyclients'] = '-1';
		}

		$channel['channel_name'] = $info['channel_name_open'];
		$channel['channel_flag_maxclients_unlimited'] = 1;
		$channel['channel_maxclients'] = '-1';
		
		if($AutoSpeak::check_error($query->channelEdit($info['channelId'], $channel), self::$name, $info['channelId']))
			$query->channelAddPerm($info['channelId'], $del);
	}

	static private function close_channel($info)
	{
		global $query, $AutoSpeak;

		$channel = array();
		$add[NEEDED_JOIN_POWER] = $info['needed_join_power'];

		if($info['change_maxfamily_clients'])
		{
			$channel['channel_flag_maxfamilyclients_unlimited'] = 0;
			$channel['channel_flag_maxfamilyclients_inherited'] = 0;
			$channel['channel_maxfamilyclients'] = '0';
		}
		else
		{
			$channel['channel_flag_maxfamilyclients_unlimited'] = 1;
			$channel['channel_flag_maxfamilyclients_inherited'] = 0;
			$channel['channel_maxfamilyclients'] = '-1';
		}
			
		$channel['channel_name'] = $info['channel_name_close'];
		$channel['channel_flag_maxclients_unlimited'] = 0;
		$channel['channel_maxclients'] = '0';
		
		if($AutoSpeak::check_error($query->channelEdit($info['channelId'], $channel), self::$name, $info['channelId']))
			$query->channelAddPerm($info['channelId'], $add);
	}

	static public function before_clients()
	{
		global $query, $language, $clients, $AutoSpeak;

		foreach(self::$cfg['content']['time_open'] as $info)
		{
			$current_channel = $query->getElement('data', $query->channelInfo($info['channelId']));
		
			if($info['channel_name_open'] != $current_channel['channel_name'] && self::check_date($info['time_open'], $info['time_close']))
				self::open_channel($info);
			elseif($info['channel_name_close'] != $current_channel['channel_name'] && !self::check_date($info['time_open'], $info['time_close']))
				self::close_channel($info);
		}

		foreach(self::$cfg['content']['open_when_admin'] as $info)
		{
			$current_channel = $query->getElement('data', $query->channelInfo($info['channelId']));
			$to_open = false;		
			
			foreach($clients as $client)
				if((gettype($info['admin']) == 'array' && $AutoSpeak::has_group($client['client_servergroups'], $info['admin'])) || (gettype($info['admin']) != 'array' && $client['client_database_id'] == $info['admin']))
				{
					$to_open = true;
					break;
				}

			if($info['channel_name_open'] != $current_channel['channel_name'] && $to_open)
				self::open_channel($info);
			elseif($info['channel_name_close'] != $current_channel['channel_name'] && !$to_open)
				self::close_channel($info);
		}

	}
}
?>