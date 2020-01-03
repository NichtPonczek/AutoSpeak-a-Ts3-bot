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

class afk_group
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
		global $query, $clients, $AutoSpeak;
	
		if(in_array(self::$name, $AutoSpeak::$disabled_functions) || !$AutoSpeak::check_group(self::$cfg['afk_group'], self::$name, $name, true))
			return;
		
		$server_groups = explode(",", $client['client_servergroups']);

		if(!$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']) && ((self::$cfg['set_group_if_away'] && $client['client_away'] == 1) || (self::$cfg['set_group_if_muted'] && $client['client_output_muted']) || $client['client_idle_time'] >= 1000 * self::$cfg['idle_time']) && !in_array($client['cid'], self::$cfg['ignored_channels']))
		{	
			if(!in_array(self::$cfg['afk_group'], $server_groups))
				$query->serverGroupAddClient(self::$cfg['afk_group'], $client['client_database_id']);
		}
		elseif(in_array(self::$cfg['afk_group'], $server_groups))	
			$query->serverGroupDeleteClient(self::$cfg['afk_group'], $client['client_database_id']);
	}
}
?>