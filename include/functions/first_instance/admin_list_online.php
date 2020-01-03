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

class admin_list_online
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
		$count_all = 0;
		
		foreach(self::$cfg['admins_server_groups'] as $admin_group)
		{
			$count = 0;
			$admins = array();

			if(!$AutoSpeak::check_group($admin_group, self::$name, $rang_name))
				continue;
			
			foreach($query->getElement('data', $query->serverGroupClientList($admin_group)) as $client_from_group)
			{
				if(isset($client_from_group['cldbid']) && $client_from_group['cldbid'] != 1)
				{
					foreach($clients as $client)
					{
						if(isset($client['client_database_id']) && $client['client_database_id'] != 1 && $client['client_database_id'] == $client_from_group['cldbid'] && !$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']))
						{
							$count++;
							$channel = $query->getElement('data', $query->channelInfo($client['cid']));
							array_push($admins, array
							(
								'name' => $client['client_nickname'],
								'type' => "online", 
								'channel' => $channel['channel_name'], 
								'channel_id' => $client['cid'], 
								'uid' => $client['client_unique_identifier'],
								'clid' => $client['clid'],
								'dbid' => $client['client_database_id'],
								'time_online' => $AutoSpeak::convert_time(time() - $client['client_lastconnected']),
							));
						}
					}
				}
			}
			if($count == 0)
				continue;			

			$desc .= "[size=13][b][".$rang_name."][/b][/size]\n[size=9][b]Online: ".$count."[/b][/size]";
			
			if($admins == NULL)
				$desc .= "\n\n";

			foreach($admins as $admin)
				$desc .= "[size=9][list][*] [b][URL=client://".$admin['clid']."/".$admin['uid']."]".$admin['name']."[/url]".$AutoSpeak::show_link($admin['dbid'])." [*] ".$language['function']['admin_list_online']['online']."[color=green]".$admin['time_online']."[/color] [*] ".$language['function']['admin_list_online']['on_channel']." [b][url=channelId://".$admin['channel_id']."]".$admin['channel']."[/url][/list][/size]";

			unset($admins);
			$count_all += $count;
		}
		
		if($count_all == 0)
			$desc .= "\n   ●  [size=9] ".$language['function']['admin_list_online']['no_admins']."[/size]\n";
		
		$desc .= $language['function']['down_desc'];
		
		if($AutoSpeak::check_channel_desc(self::$cfg['channel_id'], $desc))		
			if($AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_description' => $desc)), self::$name, self::$cfg['channel_id']))
				$query->channelEdit(self::$cfg['channel_id'], array('channel_name' => str_replace('[ONLINE]', $count_all, self::$cfg['channel_name'])));	
		
	}
}
?>