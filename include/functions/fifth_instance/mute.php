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

class mute
{
	private static $name;
	private static $cfg;
	
	static public function construct($command_name)
	{
		global $cfg;
		self::$cfg = $cfg[$command_name];
		self::$name = $command_name;
	}	

	static public function check_cache()
	{
		global $query, $cache_mute;

		foreach($cache_mute as $dbid => $info)
		{
			$info = explode('<->', $info);
			$sec = $info[0];
			$last_time = $info[1];

			if($sec + $last_time <= time())
			{
				$query->serverGroupDeleteClient(self::$cfg['give_group'], $dbid);
				unset($cache_mute[$dbid]);
			}
		}
	}

	static public function main($info)
	{
		global $query, $language, $cache_mute;
		
		foreach($query->getElement('data', $query->clientList()) as $client)
		{
			if($client['client_database_id'] == $info['parameters'][0][1])
			{
				$query->serverGroupAddClient(self::$cfg['give_group'], $info['parameters'][0][1]);
				$cache_mute[$info['parameters'][0][1]] = $info['parameters'][0][2]."<->".time();

				$query->sendMessage(1,$info['clid'],str_replace('[NICK]', $client['client_nickname'], $language['command']['mute']['success'].$info['parameters'][0][2]));
			}
		}

	}
}
?>