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

class client_platform
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}


	static private function has_rang($groups, $ignored)
	{
		foreach($ignored as $ign)
			if(in_array($ign, $groups))
				return true;
		return false;
	}

	static public function every_client($client)
	{
		global $query, $clients;
		$check = array();

	
		if($client['client_database_id'] != 1)
		{
			$client_info = $query->getElement('data', $query->clientInfo($client['clid']));
			$groups = explode(",", $client['client_servergroups']);
			
			if(self::$cfg['linux_enabled'] && $client_info['client_platform'] == "Linux" && !self::has_rang(self::$cfg['ignored_groups'], $groups))
			{
				$check['linux'] = true;
				$check['windows'] = false;
				$check['android'] = false;
			}
			elseif(self::$cfg['android_enabled'] && $client_info['client_platform'] == "Android" && !self::has_rang(self::$cfg['ignored_groups'], $groups))
			{
				$check['android'] = true;
				$check['windows'] = false;
				$check['linux'] = false;
			}
			elseif(self::$cfg['windows_enabled'] && $client_info['client_platform'] == "Windows" && !self::has_rang(self::$cfg['ignored_groups'], $groups))
			{
				$check['windows'] = true;
				$check['linux'] = false;
				$check['android'] = false;
			}
			else
			{
				$check['windows'] = false;
				$check['linux'] = false;
				$check['android'] = false;
			}
				
			if(array_key_exists('linux', $check) && $check['linux'])
			{
				if(!in_array(self::$cfg['linux_group'], $groups))
					$query->serverGroupAddClient(self::$cfg['linux_group'], $client['client_database_id']);

				if(!$check['windows'] && in_array(self::$cfg['windows_group'], $groups))
					$query->serverGroupDeleteClient(self::$cfg['windows_group'], $client['client_database_id']);

				if(!$check['android'] && in_array(self::$cfg['android_group'], $groups))
					$query->serverGroupDeleteClient(self::$cfg['android_group'], $client['client_database_id']);
			}
			elseif(array_key_exists('android', $check) && $check['android'])
			{
				if(!in_array(self::$cfg['android_group'], $groups))
					$query->serverGroupAddClient(self::$cfg['android_group'], $client['client_database_id']);

				if(!$check['windows'] && in_array(self::$cfg['windows_group'], $groups))
					$query->serverGroupDeleteClient(self::$cfg['windows_group'], $client['client_database_id']);

				if(!$check['linux'] && in_array(self::$cfg['linux_group'], $groups))
					$query->serverGroupDeleteClient(self::$cfg['linux_group'], $client['client_database_id']);
			}
			elseif(array_key_exists('windows', $check) && $check['windows'])
			{
				if(!in_array(self::$cfg['windows_group'], $groups))
					$query->serverGroupAddClient(self::$cfg['windows_group'], $client['client_database_id']);
				
				if(!$check['android'] && in_array(self::$cfg['android_group'], $groups))
					$query->serverGroupDeleteClient(self::$cfg['android_group'], $client['client_database_id']);

				if(!$check['linux'] && in_array(self::$cfg['linux_group'], $groups))
					$query->serverGroupDeleteClient(self::$cfg['linux_group'], $client['client_database_id']);
			}
			else
			{
				if(!$check['windows'] && in_array(self::$cfg['windows_group'], $groups))
					$query->serverGroupDeleteClient(self::$cfg['windows_group'], $client['client_database_id']);

				if(!$check['linux'] && in_array(self::$cfg['linux_group'], $groups))
					$query->serverGroupDeleteClient(self::$cfg['linux_group'], $client['client_database_id']);
	
				if(!$check['android'] && in_array(self::$cfg['android_group'], $groups))
					$query->serverGroupDeleteClient(self::$cfg['android_group'], $client['client_database_id']);
			}			
		}
	}
}
?>