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

class groups_assigner
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
		global $query, $language, $query_sql, $logs_manager, $AutoSpeak;
		
		$has_register_rang = false;
		$db = false;
		$time_spent = 0;

		if(isset($query_sql))
		{
			$result = $query_sql->query("SELECT * FROM clients WHERE client_dbid='".$client['client_database_id']."'");

			$db = true;

			if($result->rowCount() == 0)
				$time_spent = 0;
			else
			{
				$result = $result->fetch(PDO::FETCH_ASSOC);
				$time_spent = $result['time_spent']/60/1000;
			}
		}
		else
			$db = false;

		foreach(self::$cfg['register_groups'] as $group)
		{
			if(in_array($group, explode(',', $client['client_servergroups'])))
			{
				$has_register_rang = true;
				$query->clientKick($client['clid'], "channel");
				$query->clientPoke($client['clid'],  $language['function']['groups_assigner']['has_rang']);
				break;
			}
		}

		if(!$has_register_rang)
		{
			if((self::$cfg['min_time_on_server'] == 0) || ($db && $time_spent >= self::$cfg['min_time_on_server']))
			{
				$config = self::$cfg['info'];
				while($sgid = current($config))
				{
					if(key($config) == $client['cid'])
					{
						if(!$query->getElement('success', $query->serverGroupAddClient($sgid, $client['client_database_id'])))	
							$logs_manager::set_error("#Gr1:".$sgid, self::$name);
						
						$query->clientKick($client['clid'], "channel");
						$query->clientPoke($client['clid'],  $language['function']['groups_assigner']['received_rang']);
						
						$AutoSpeak::set_action(self::$name, array('client' => $client));
					}
					next($config);
				}
			}
			else
			{
				$query->clientKick($client['clid'], "channel");
				$query->clientPoke($client['clid'], $language['function']['groups_assigner']['error']." ".self::$cfg['min_time_on_server']." ".$language['function']['groups_assigner']['min']);
			}
		}
	}
}
?>