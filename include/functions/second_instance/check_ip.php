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

class check_ip
{
	private static $lang;
	private static $lang;
	private static $name;
	private static $cfg;

	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}

	static public function before_clients()
	{
		global $query, $AutoSpeak, $language, $clients;

		$client_ips = array();

		foreach($clients as $client)
		{
			if($client['client_type'] != 1 && !$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']))
			{
				if(isset($client_ips[$client['connection_client_ip']])) 
				{
					$client_ips[$client['connection_client_ip']]['number']++;
					if($client_ips[$client['connection_client_ip']]['client']['client_lastconnected'] < $client['client_lastconnected']) 
						$client_ips[$client['connection_client_ip']]['client'] = array('clid' => $client['clid'], 'client_lastconnected' => $client['client_lastconnected']);
				}
				else
					$client_ips[$client['connection_client_ip']] = array('number' => 1, 'client' => array('clid' => $client['clid'], 'client_lastconnected' => $client['client_lastconnected']));
			}
		}

		foreach($client_ips as $ip => $client_ip)
			if($ip != '127.0.0.1' && $client_ip['number'] > self::$cfg['max_users'])
				$query->clientKick($client_ip['client']['clid'],'server',str_replace('[NUMBER]',self::$cfg['max_users'],$language['function']['check_ip']));
	}
}
?> 
