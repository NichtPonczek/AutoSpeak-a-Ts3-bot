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

class generate_cache
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg, $language;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}

	static public function before_clients()
	{
		global $query, $server_info, $clients;	

		$cache = array();
		$cache['server_info'] = $server_info;
		
		foreach($clients as $client)
			$cache['clients'][$client['client_database_id']] = array('client_database_id' => $client['client_database_id'], 'clid' => $client['clid'], 'cid' => $client['cid'], 'client_nickname' => $client['client_nickname'], 'client_unique_identifier' => $client['client_unique_identifier'], 'connection_client_ip' => $client['connection_client_ip']);
		
		foreach($query->getElement('data', $query->channelList("-flags -limits")) as $channel)
			$cache['channels'][$channel['cid']] = $channel;
		
		foreach($query->getElement('data', $query->channelGroupList()) as $groups)
		{
			$groups['icon'] = null;
			$cache['groups'][$groups['cgid']] = $groups;
		}	
			
		file_put_contents(self::$cfg['target_file'],json_encode($cache));
	}
}
?>