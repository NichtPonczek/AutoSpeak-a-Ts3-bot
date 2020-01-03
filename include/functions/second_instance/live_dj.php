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

class live_dj
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

		foreach(self::$cfg['info'] as $channel_id => $channel_name)
		{
			$found = false;

			foreach($query->getElement('data', $query->channelClientList($channel_id, '-voice')) as $client)
				if($client['client_flag_talking'] != 0)
				{
					$found = true;
					break;
				}

			if($found)
				$AutoSpeak::check_error($query->channelEdit($channel_id, array('channel_name' => str_replace('[DJ]', $client['client_nickname'], $channel_name))), self::$name, $channel_id);
			else
				$AutoSpeak::check_error($query->channelEdit($channel_id, array('channel_name' => str_replace('[DJ]', $language['function']['live_dj'], $channel_name))), self::$name, $channel_id);
		}
	}
}
?>