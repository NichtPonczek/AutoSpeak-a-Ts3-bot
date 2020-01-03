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

class change_server_name
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}

	static private function replace_name($name, $date_format)
	{
		global $query, $server_info, $clients, $AutoSpeak;

		$per = explode('.', ($server_info['virtualserver_clientsonline'] - $server_info['virtualserver_queryclientsonline'])/$server_info['virtualserver_maxclients']*100);
		
		$count = 0;
		
		foreach($clients as $client)
			if($client['client_type'] != 1 && !$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']))
				$count++;

		$edited_name = array
		(
			'[ONLINE]' => $count,
			'[MAX_CLIENTS]' => $server_info['virtualserver_maxclients'],
			'[DATE]' => date($date_format),
			'[%]' => $per[0],
		);

		return str_replace(array_keys($edited_name), array_values($edited_name), $name);
	}

	static public function before_clients()
	{
		global $query, $server_info;			

		$name = self::replace_name(self::$cfg['server_name'], self::$cfg['format']);

		if($name != $server_info['virtualserver_name'])
			$query->serverEdit(array('virtualserver_name' => $name));		
	}
}
?>