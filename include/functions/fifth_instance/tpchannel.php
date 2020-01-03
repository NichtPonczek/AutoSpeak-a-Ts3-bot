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

class tpchannel
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
		global $query, $language;
		$finded = false;

		if(strlen($info['parameters'][0][1]) < 5)
		{
			$query->sendMessage(1,$info['clid'],$language['command']['tpchannel']['to_small']);
			return;
		}
	
		foreach($query->getElement('data', $query->channelList()) as $channel)
			if(strpos(strtolower($channel['channel_name']), strtolower($info['parameters'][0][1])) !== False)
			{
				$finded = true;
				break;
			}

		if($finded)
			$query->clientMove($info['clid'], $channel['cid']);
		else
			$query->sendMessage(1,$info['clid'],$language['command']['tpchannel']['not_finded']);

	}
}
?>