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

class warning_ban
{
	private static $name;
	private static $cfg;
	
	static public function construct($plugin_name)
	{
		global $cfg;
		self::$cfg = $cfg[$plugin_name];
		self::$name = $plugin_name;
	}


	static public function main($client)
	{
		global $query, $logs_manager, $language;

		$ile = count(self::$cfg['warning_id']);
		$dbid = array();
		$uid = array();
		$ban = array();

		for($j=0; $j<$ile; $j++)
			$ban[$j] = false;
		
		$flag = true;
		$c = 1;

		$groups = explode(',', $client['client_servergroups']);
		foreach($groups as $gr)
		{
			for($k=1; $k<$ile; $k++)
			{
				if($gr == self::$cfg['warning_id'][$k])
					$ban[$k] = true;
			}
		}

		for($k=1; $k<$ile; $k++)
		{	
			if(!$ban[$k])
			{
				$flag = false;
				break;
			}
		}

		if($flag)
		{
			$logs_manager::write_info(" [".self::$name."] ".$language['function']['warning_ban']['user_banned'].$client['client_nickname']);
			$query->banAddByUid($client['client_unique_identifier'], self::$cfg['ban_time'], self::$cfg['ban_message']);
			for($k=0; $k<$ile; $k++)
				$query->serverGroupDeleteClient(self::$cfg['warning_id'][$k],$client['client_database_id']);		
		}
	}
}
?>