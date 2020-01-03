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

class move_groups
{
	private static $name;
	private static $cfg;
	public static $from_vip_channels = array();
	
	static public function construct($plugin_name)
	{
		global $cfg;
		self::$cfg = $cfg[$plugin_name];
		self::$name = $plugin_name;
	}
	
	static public function main($client)
	{
		global $query, $AutoSpeak;
		
		foreach(array_merge(self::$cfg['info'], self::$from_vip_channels) as $info)
			if($client['cid'] == $info['is_on_channel'] && $AutoSpeak::has_group($client['client_servergroups'], $info['groups']) && (!isset($info['ignored_groups']) || !$AutoSpeak::has_group($client['client_servergroups'], $info['ignored_groups'])))
			{
				$query->clientMove($client['clid'], $info['move_to_channel']);
				return;
			}
	}
}
?>