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

class block_recording
{
	private static $name;
	private static $cfg;
	
	static public function construct($plugin_name)
	{
		global $cfg;
		self::$cfg = $cfg[$plugin_name];
		self::$name = $plugin_name;
	}

	static public function every_client($client)
	{
		if($client['client_is_recording'] != 1)
			return;
		
		global $query, $AutoSpeak;

		if(!$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']))
		{
			switch(self::$cfg['type'])
			{
				case 'ban':
					$query->banAddByUid($client['client_unique_identifier'], self::$cfg['time'], self::$cfg['message']);
					break;
				default: 
					$query->clientKick($client['clid'], "server", self::$cfg['message']);
					break;		
			}
			
			$AutoSpeak::set_action(self::$name, array('client' => $client));
		}
		
	}
}
?>