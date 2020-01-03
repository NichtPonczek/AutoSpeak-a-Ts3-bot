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

class pokegroup
{
	private static $name;
	private static $cfg;
	
	static public function construct($command_name)
	{
		global $cfg;
		self::$cfg = $cfg[$command_name];
		self::$name = $command_name;
	}	

	static public function main($info)
	{
		global $query, $whoAmI, $language;
		$count = 0;

		foreach($query->getElement('data', $query->clientList("-groups")) as $client)
			if($client['clid'] != $whoAmI['client_id'] && $client['client_database_id'] != 1 && in_array($info['parameters'][0][1], explode(',', $client['client_servergroups'])))
			{
				$query->clientPoke($client['clid'],$info['parameters'][0][2]);	
				$count++;
			}

		$query->sendMessage(1,$info['clid'],$language['command']['success'].$count);
	}
}
?>