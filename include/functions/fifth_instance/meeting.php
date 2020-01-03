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

class meeting
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
		global $query, $whoAmI, $language, $AutoSpeak;
		$count = 0;

		foreach($query->getElement('data', $query->clientList("-groups")) as $client)
			if($client['clid'] != $whoAmI['client_id'] && $client['client_database_id'] != 1 && $AutoSpeak::has_group($client['client_servergroups'], self::$cfg['admins_server_groups']))
			{
				$query->clientMove($client['clid'],self::$cfg['meeting_channel_id']);	
				$count++;
			}

		$query->sendMessage(1,$info['clid'],$language['command']['success_moved'].$count);
	}
}
?>