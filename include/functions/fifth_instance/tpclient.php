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
class tpclient
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
		global $query, $language, $clients;
		$finded = false;

		if(strlen($info['parameters'][0][1]) < 3)
		{
			$query->sendMessage(1,$info['clid'],$language['command']['tpclient']['to_small']);
			return;
		}
	
		foreach($clients as $client)
			if(strpos(strtolower($client['client_nickname']), strtolower($info['parameters'][0][1])) !== False)
			{
				$finded = true;
				break;
			}

		if($finded)
			$query->clientMove($info['clid'], $client['cid']);
		else
			$query->sendMessage(1,$info['clid'],$language['command']['tpclient']['not_finded']);

	}
}
?>