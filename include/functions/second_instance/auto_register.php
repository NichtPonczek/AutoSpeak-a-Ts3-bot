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

class auto_register
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
		global $query, $language, $query_sql, $AutoSpeak;
		
		if(in_array(self::$name, $AutoSpeak::$disabled_functions) || !$AutoSpeak::check_group(self::$cfg['register_group'], self::$name, $name, true))
				return;
		
		if(in_array(self::$cfg['register_group'], explode(',', $client['client_servergroups'])) || $AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']))
			return;
		
		if(isset($query_sql))
		{
			$result = $query_sql->query("SELECT * FROM clients WHERE client_dbid='".$client['client_database_id']."'");

			if($result->rowCount() == 0)
				$time_spent = -1;
			else
			{
				$result = $result->fetch(PDO::FETCH_ASSOC);
				$time_spent = $result['time_spent']/60/1000;
			}

			if($time_spent >= self::$cfg['min_time_on_server'])
			{
				$query->serverGroupAddClient(self::$cfg['register_group'], $client['client_database_id']);
				$query->clientPoke($client['clid'],  $language['function']['auto_register']['received_rang']);
				
				$AutoSpeak::set_action(self::$name, array('client' => $client));
			}
		}

	}
}
?>