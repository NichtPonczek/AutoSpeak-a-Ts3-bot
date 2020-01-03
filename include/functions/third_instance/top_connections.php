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

class top_connections
{
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
		global $query, $query_sql, $language, $AutoSpeak;
		
		$desc = "[hr][center][size=14][b]".self::$cfg['top_description']."[/b][/size][/center][hr]\n";
		$result = $query_sql->query('SELECT `client_dbid`,`client_clid`,`client_uid`,`client_nick`,`server_groups`,`connections` FROM `clients` ORDER BY `connections` DESC LIMIT '.(5*self::$cfg['records']))->fetchAll(PDO::FETCH_ASSOC);

		$count = 1;
		foreach($result as $user)
		{
			if($count>self::$cfg['records'])
				break;
			if(!$AutoSpeak::has_group($user['server_groups'], self::$cfg['ignored_groups']))
				$desc .= "[list][*] [size=15] ".$count++.". [/size] [size=9][b]  Nick: [URL=client://".$user['client_clid']."/".$user['client_uid']."]".$user['client_nick']."[/url]".$AutoSpeak::show_link($user['client_dbid'])."  → ".$user['connections']." ".$language['function']['top_connections']['connect']."[/size][/list]";
		}

		$desc .= $language['function']['down_desc'];
	
		if($AutoSpeak::check_channel_desc(self::$cfg['channel_id'], $desc))
			$AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_description' => $desc)), self::$name, self::$cfg['channel_id'], true);
	}
}
?>