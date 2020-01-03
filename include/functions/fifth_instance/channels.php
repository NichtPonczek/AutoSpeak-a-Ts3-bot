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

class channels
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

		foreach($query->getElement('data', $query->channelList()) as $channel)
		{
			$count++;
			$query->sendMessage(1,$info['clid'],$count.". -> Id: ".$channel['cid']." || Name: ".$channel['channel_name']." || Clients: ".$channel['total_clients']);	
		}

		$query->sendMessage(1,$info['clid'],$language['command']['result'].$count);
	}
}
?>