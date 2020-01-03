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

class fill_empty_channels
{
	private static $lang;
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
		global $query, $language, $AutoSpeak;

		foreach($query->getElement('data', $query->channelList()) as $channel)
		{
			if(strpos($channel['channel_name'], self::$cfg['needed_phrase']) !== false)
			{
				$channel_info = $query->getElement('data', $query->channelInfo($channel['cid']));
				
				if($channel_info['channel_description'] == null)
					$query->channelEdit($channel['cid'], array('channel_description' => self::$cfg['description']));
			}
		}	
	}
}
?>