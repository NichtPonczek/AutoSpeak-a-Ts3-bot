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

class achievements
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}	
	
	static public function every_client($client)
	{
		global $query, $query_sql, $language, $AutoSpeak;
		
		if(!$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']))
		{
			$client_info = $query_sql->query("SELECT connections, time_spent FROM clients WHERE client_dbid=".$client['client_database_id'])->fetch(PDO::FETCH_ASSOC);
			
			if(!$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['header_group']))
				$query->serverGroupAddClient(self::$cfg['header_group'], $client['client_database_id']);
			if(!$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['footer_group']))
				$query->serverGroupAddClient(self::$cfg['footer_group'], $client['client_database_id']);
				
			if(self::$cfg['info']['connections']['enabled'])
			{
				if(!$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['info']['connections']['header_group']))
					$query->serverGroupAddClient(self::$cfg['info']['connections']['header_group'], $client['client_database_id']);
				
				$to_add = null;
				
				foreach(self::$cfg['info']['connections']['groups'] as $group => $required)
				{
					if($client_info['connections'] >= $required) $to_add = $group;
					else break;
				}
				
				foreach(self::$cfg['info']['connections']['groups'] as $group => $required)
					if($to_add != $group && $AutoSpeak::has_group($client['client_servergroups'], $group))
							$query->serverGroupDeleteClient($group, $client['client_database_id']);	
				
				if($to_add != null && !$AutoSpeak::has_group($client['client_servergroups'], $to_add))
					$query->serverGroupAddClient($to_add, $client['client_database_id']);	
			}
			
			if(self::$cfg['info']['time_spent']['enabled'])
			{
				if(!$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['info']['time_spent']['header_group']))
					$query->serverGroupAddClient(self::$cfg['info']['time_spent']['header_group'], $client['client_database_id']);
				
				$to_add = null;
				
				foreach(self::$cfg['info']['time_spent']['groups'] as $group => $required)
				{
					if($client_info['time_spent']/1000 >= $required) $to_add = $group;
					else break;
				}
				
				foreach(self::$cfg['info']['time_spent']['groups'] as $group => $required)
					if($to_add != $group && $AutoSpeak::has_group($client['client_servergroups'], $group))
							$query->serverGroupDeleteClient($group, $client['client_database_id']);	
				
				if($to_add != null && !$AutoSpeak::has_group($client['client_servergroups'], $to_add))
					$query->serverGroupAddClient($to_add, $client['client_database_id']);	
			}
		}
	}
}
?>