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

class away_group
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}
	
	static private function is_group($name)
	{
		global $server_groups;
		
		foreach($server_groups as $group)
			if($group['name'] == $name)
				return $group['sgid'];
			
		return 0;
	}
	
	static public function before_clients()
	{
		global $clients, $query;
		
		$clients_online = array();
		$cache = json_decode(file_get_contents("include/cache/away_group.txt"), 1);
		
		if(empty($cache))
			return;
		
		foreach($clients as $client)
			$clients_online[] = $client['client_database_id'];
			
		foreach($cache as $dbid => $rang)
			if(!in_array($dbid, $clients_online))
			{
				unset($cache[$dbid]);
				$query->serverGroupDeleteClient($rang, $dbid);
				
				if(!in_array($rang, $cache))
					$query->serverGroupDelete($rang);
			}
		
		file_put_contents("include/cache/away_group.txt", json_encode($cache));
	}
	
	static public function every_client($client)
	{
		global $query, $AutoSpeak, $server_groups;
		
		$cache = json_decode(file_get_contents("include/cache/away_group.txt"), 1);
		
		if($client['client_idle_time'] >= 1000 * self::$cfg['min_idle_time'] && !$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']))
		{
			$idle_time = "AFK: ".$AutoSpeak::convert_time($client['client_idle_time']/1000);
			
			$is_group = self::is_group($idle_time);
			
			if(isset($cache[$client['client_database_id']]) && $cache[$client['client_database_id']] == $is_group)
				return;
			
			if($is_group != 0)
			{
				$query->serverGroupAddClient($is_group, $client['client_database_id']);
				
				if(!empty($cache) && in_array($client['client_database_id'], array_keys($cache)))
				{
					$group = $cache[$client['client_database_id']];
					$query->serverGroupDeleteClient($group, $client['client_database_id']);
					
					$cache[$client['client_database_id']] = $is_group;
					
					if(!in_array($group, $cache))
						$query->serverGroupDelete($group, $client['client_database_id']);
				}
				else
					$cache[$client['client_database_id']] = $is_group;
			}
			else
			{
				if(!empty($cache) && in_array($client['client_database_id'], array_keys($cache)))
				{
					$clients_in_group = $query->getElement('data', $query->serverGroupClientList($cache[$client['client_database_id']]));
					
					if(gettype($clients_in_group) == 'array' && count($clients_in_group) == 1)
						$query->serverGroupRename($cache[$client['client_database_id']], $idle_time);
					else
					{
						$query->serverGroupDeleteClient($cache[$client['client_database_id']], $client['client_database_id']);
						$group_id = $query->serverGroupCopy(self::$cfg['server_group_copy'], 0, $idle_time, 2);
						$query->serverGroupAddClient($group_id['data']['sgid'], $client['client_database_id']);
						$cache[$client['client_database_id']] = $group_id['data']['sgid'];
					}
				}
				else
				{
					$group_id = $query->serverGroupCopy(self::$cfg['server_group_copy'], 0, $idle_time, 2);
					$query->serverGroupAddClient($group_id['data']['sgid'], $client['client_database_id']);
					$cache[$client['client_database_id']] = $group_id['data']['sgid'];
				}
			}
		}
		elseif(!empty($cache) && in_array($client['client_database_id'], array_keys($cache)))
		{
			$group = $cache[$client['client_database_id']];
			$query->serverGroupDeleteClient($group, $client['client_database_id']);
			unset($cache[$client['client_database_id']]);
			
			if(!in_array($group, $cache))
				$query->serverGroupDelete($group);
		}
		
		file_put_contents("include/cache/away_group.txt", json_encode($cache));
	}
}
?>