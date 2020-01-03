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

class clients
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

		foreach($query->getElement('data', $query->clientList("-groups -uid -ip")) as $client)
			if($client['clid'] != $whoAmI['client_id'] && $client['client_database_id'] != 1)
			{	
				$count++;
				$query->sendMessage(1,$info['clid'],$count.". -> Nick: ".$client['client_nickname']." || Database Id: ".$client['client_database_id']." || Uid: ".$client['client_unique_identifier']." || Id: ".$client['clid']." || Ip: ".$client['connection_client_ip']." || On channnel: ".$client['cid']);	
			}

		$query->sendMessage(1,$info['clid'],$language['command']['result'].$count);
	}
}
?>