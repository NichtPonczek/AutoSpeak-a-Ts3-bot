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

class server_query_online
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
		global $query, $clients, $language, $AutoSpeak;
		
		$desc = "[hr][center][size=14][b][I]".self::$cfg['top_description']."[/I][/b][/size][/center][hr]\n";
		$count = 0;
		$queries = array();
		
		foreach($clients as $client)
		{
			if($client['client_type'] == 1)
			{
				$count++;
				$channel = $query->getElement('data', $query->channelInfo($client['cid']));
				array_push($queries, array
				(
					'name' => $client['client_nickname'],
					'channel' => $channel['channel_name'], 
					'channel_id' => $client['cid'], 
					'uid' => $client['client_unique_identifier'],
					'clid' => $client['clid'],
				));
			}
		}	
			
		$desc .= "[size=9][b]Online: ".$count."[/b][/size]";
			
		if($queries == NULL)
			$desc .= "\n\n";

		foreach($queries as $qe)
				$desc .= "[list][*] [size=15][/size] [size=9] [b][URL=client://".$qe['clid']."/".$qe['uid']."]".$qe['name']."[/url] ".$language['function']['admin_list']['on_channel']." [b][url=channelId://".$qe['channel_id']."]".$qe['channel']."[/url][/size][/list]";

		unset($queries);
		
		$desc .= $language['function']['down_desc'];
		
		if($AutoSpeak::check_channel_desc(self::$cfg['channel_id'], $desc))
			if($AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_description' => $desc)), self::$name, self::$cfg['channel_id'], true))
				$query->channelEdit(self::$cfg['channel_id'], array('channel_name' => str_replace('[ONLINE]', $count, self::$cfg['channel_name'])));
	}
}
?>