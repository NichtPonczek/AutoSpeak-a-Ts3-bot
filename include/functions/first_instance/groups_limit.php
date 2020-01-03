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

class groups_limit
{
	private static $name;
	private static $cfg;
	
	static public function construct($plugin_name)
	{
		global $cfg;
		self::$cfg = $cfg[$plugin_name];
		self::$name = $plugin_name;
	}
	
	static private function check_more_groups($groups, $checking_groups, $limit, $dbid)
	{
		global $query;
		
		$count = 0;
		
		if(!isset($checking_groups) || empty($checking_groups))
			return;

		foreach($checking_groups as $checking_group)
		{
			if(in_array($checking_group, $groups))
			{
				$count++;
				
				if($count > $limit)
					$query->serverGroupDeleteClient($checking_group, $dbid);
			}
		}
	}

	static public function every_client($client)
	{
		global $query, $language, $AutoSpeak;

		foreach(self::$cfg['info'] as $info)
		{
			$groups = explode(',', $client['client_servergroups']);
			
			if(!$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']))
				self::check_more_groups($groups, $info['checking_groups'], $info['limit'], $client['client_database_id']);
		}
	}
}
?>