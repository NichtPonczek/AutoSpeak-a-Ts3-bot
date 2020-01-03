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

class private_channels_info
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
		global $query, $language, $logs_manager, $AutoSpeak;

		$empty = 0;
		$taken = 0;
		$found = false;

		foreach($channels = $query->getElement('data', $query->channelList("-topic")) as $channel)
		{
			if($channel['cid'] == self::$cfg['channels_zone'])
				$found = true;
			elseif($channel['pid'] == self::$cfg['channels_zone'])
			{
				if($channel['channel_topic'] == self::$cfg['empty_channel_topic'])
					$empty++;
				else
					$taken++;
			}	
		}
		
		if(!$found)
		{
			$logs_manager::set_error("#Ch1:".self::$cfg['channels_zone'], self::$name, true);
			return;
		}
		
		$total = $taken+$empty;

		if(self::$cfg['total']['enabled'])
			$AutoSpeak::check_error($query->channelEdit(self::$cfg['total']['channel_id'], array('channel_name' => str_replace('[NUM]', $total, self::$cfg['total']['channel_name']))), self::$name, self::$cfg['total']['channel_id']);
		if(self::$cfg['taken']['enabled'])
			$AutoSpeak::check_error($query->channelEdit(self::$cfg['taken']['channel_id'], array('channel_name' => str_replace('[NUM]', $taken, self::$cfg['taken']['channel_name']))), self::$name, self::$cfg['taken']['channel_id']);
		if(self::$cfg['empty']['enabled'])
			$AutoSpeak::check_error($query->channelEdit(self::$cfg['empty']['channel_id'], array('channel_name' => str_replace('[NUM]', $empty, self::$cfg['empty']['channel_name']))), self::$name, self::$cfg['empty']['channel_id']);
	}
}
?>