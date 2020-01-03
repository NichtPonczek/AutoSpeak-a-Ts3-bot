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

class clock_date
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}

	static private function the_same_name($name, $channel_id)
	{
		global $query;

		$channel = $query->getElement('data', $query->channelInfo($channel_id));
		
		if($name != $channel['channel_name'])
			return false;
		else 
			return true;
	}
	
	static public function before_clients()
	{
		global $query, $AutoSpeak;

		if(self::$cfg['content']['clock']['enabled'])
		{
			$function = self::$cfg['content']['clock'];
			$name = str_replace("[CLOCK]", date($function['format']), $function['channel_name']);

			if(!self::the_same_name($name, $function['channel_id']))
				$AutoSpeak::check_error($query->channelEdit($function['channel_id'], array('channel_name' => $name)), self::$name, $function['channel_id']);
		}	

		if(self::$cfg['content']['date']['enabled'])
		{
			$function = self::$cfg['content']['date'];
			$name = str_replace("[DATE]", date($function['format']), $function['channel_name']);

			if(!self::the_same_name($name, $function['channel_id']))
				$AutoSpeak::check_error($query->channelEdit($function['channel_id'], array('channel_name' => $name)), self::$name, $function['channel_id']);
		}

		if(self::$cfg['content']['date_and_clock']['enabled'])
		{
			$function = self::$cfg['content']['date_and_clock'];
			$name = str_replace("[DATE&CLOCK]", date($function['format']), $function['channel_name']);

			if(!self::the_same_name($name, $function['channel_id']))
				$AutoSpeak::check_error($query->channelEdit($function['channel_id'], array('channel_name' => $name)), self::$name, $function['channel_id']);
		}
	}
}
?>