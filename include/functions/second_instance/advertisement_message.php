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

class advertisement_message
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
		global $query, $server_info, $clients;
			
		if(self::$cfg['type'] == 'pw' || self::$cfg['type'] == 'poke')
		{
			$rand = rand(0, count(self::$cfg['advertisements'])-1);

			if(count(self::$cfg['advertisements']) == 1)
				$rand = 0;

			foreach($clients as $client)
			{
				if(self::$cfg['type'] == 'pw')
					$query->sendMessage(1, $client['clid'], self::$cfg['advertisements'][$rand]);
				else
					$query->clientPoke($client['clid'], self::$cfg['advertisements'][$rand]);
			}
		}
		else
			$query->sendMessage(3, $server_info['virtualserver_id'], self::$cfg['advertisements'][rand(0, count(self::$cfg['advertisements'])-1)]);
	}
}
?>