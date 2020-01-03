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

class online_users
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
		global $query, $clients, $AutoSpeak;	
		
		$count = 0;
		
		foreach($clients as $client)
			if($client['client_type'] != 1 && !$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']))
				$count++;
		
		$channel = $query->getElement('data', $query->channelInfo(self::$cfg['channel_id']));
		$name = str_replace('[ONLINE]', $count, self::$cfg['channel_name']);
		if($name != $channel['channel_name'])
			$AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_name' => $name)), self::$name, self::$cfg['channel_id'], true);
	}
}
?>