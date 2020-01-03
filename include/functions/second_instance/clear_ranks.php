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

class clear_ranks
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}

		
	static public function main($client)
	{
		global $query, $AutoSpeak;

		if($AutoSpeak::has_group($client['client_servergroups'], self::$cfg['info'][$client['cid']]))
			foreach(explode(',', $client['client_servergroups']) as $group)
			{
				if(in_array($group, self::$cfg['info'][$client['cid']]))
					$query->serverGroupDeleteClient($group, $client['client_database_id']);
			}

		$query->clientKick($client['clid'], "channel");
	}
}
?>