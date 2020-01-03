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

class get_server_group
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}

	static public function main($client)
	{
		global $query, $query, $cfg, $query_sql, $logs_manager, $language;

		$main_channels = array();
		
		if(isset($query_sql))
		{
			$result = $query_sql->query("SELECT `get_group`, `group_id`, `channel_cid` FROM `vip_channels`");
			if($result->rowCount() > 0)
			{	
				$result = $result->fetchAll(PDO::FETCH_ASSOC);

				foreach($result as $once)
				{
					self::$cfg['info'][$once['get_group']] = $once['group_id'];
					$main_channels[$once['group_id']] = explode(',', $once['channel_cid'])[0];
				}
			}
		}

		$groups = explode(',', $client['client_servergroups']);

		foreach(self::$cfg['info'] as $ch_id => $server_group)
		{
			if($client['cid'] == $ch_id)
			{
				if(!in_array($server_group, $groups))
				{
					if(!$query->getElement('success', $query->serverGroupAddClient($server_group, $client['client_database_id'])))
						$logs_manager::set_error("#Gr1:".$server_group, self::$name);

					if(isset($main_channels[$server_group]))
						$query->clientMove($client['clid'], $main_channels[$server_group]);
					elseif(self::$cfg['client_kick'])
						$query->clientKick($client['clid'], "channel");
					
					if(self::$cfg['poke_client'])
						$query->clientPoke($client['clid'], $language['function']['get_server_group']['add']);
				}
				elseif(self::$cfg['delete_rang'] && in_array($server_group, $groups))
				{
					$query->serverGroupDeleteClient($server_group, $client['client_database_id']);
					
					if(self::$cfg['client_kick'])
						$query->clientKick($client['clid'], "channel");
					
					if(self::$cfg['poke_client'])
						$query->clientPoke($client['clid'], $language['function']['get_server_group']['del']);
				}
			}
		}
	}
}
?>