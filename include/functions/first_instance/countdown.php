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
class countdown
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}
	
	static public function before_clients()
	{
		global $query, $AutoSpeak;

		foreach(self::$cfg['info'] as $info)
		{
			$date = explode(' ', $info['date']);
			$hours = explode(':', $date[1]);
			$date = explode('-', $date[0]);
			
			$time = ($info['count_type'] == 'from_date' ? $AutoSpeak::convert_time(time() - mktime($hours[0],$hours[1],0,$date[1],$date[0],$date[2]), self::$cfg['time_settings']) : $AutoSpeak::convert_time(mktime($hours[0],$hours[1],0,$date[1],$date[0],$date[2]) - time(), self::$cfg['time_settings']));
			
			if($time < 0)
				$time = "---";
			
			$AutoSpeak::check_error($query->channelEdit($info['channel_id'], array('channel_name' => str_replace('[COUNT]', $time, $info['channel_name']))), self::$name, $info['channel_id']);;
		}
	}
}
?>