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

class admin_list
{
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
		global $query, $clients, $language, $AutoSpeak, $query_sql;
		
		self::$lang = $language['function']['connect_message'];
		$lan = $language['function']['admin_list'];
		
		foreach(self::$cfg['info'] as $channel_id => $info)
		{
			$desc = "[hr][center][size=14][b]".$info['top_description']."[/b][/size][/center][hr]\n";
			$count_all = 0;
			$loop_rotation = 0;
			$all_admins = count($info['admins_server_groups']);
			
			foreach($info['admins_server_groups'] as $admin_group)
			{
				$loop_rotation++;
				$count = 0;
				$count_online = 0;
				$admins = array();

				if(!$AutoSpeak::check_group($admin_group, self::$name, $rang_name))
					continue;
					
				$clients_from_group = $query->getElement('data', $query->serverGroupClientList($admin_group));

				if($clients_from_group != NULL)
				{
					foreach($clients_from_group as $client_from_group)
					{
						if(isset($client_from_group['cldbid']) && $client_from_group['cldbid'] != 1)
						{
							$client_online = false;
							foreach($clients as $client)
							{
								if($client['client_database_id'] != 1 && $client['client_database_id'] == $client_from_group['cldbid'] && !$AutoSpeak::has_group($client['client_servergroups'], $info['ignored_groups']))
								{
									$client_online = true;
									$count_online++;
									$channel = $query->getElement('data', $query->channelInfo($client['cid']));
									
									
									if($client['client_away'] == 1 || $client['client_output_muted'] || $client['client_idle_time'] >= 1000 * self::$cfg['min_idle_time'])
										array_push($admins, array
										(
											'name' => $client['client_nickname'], 
											'type' => "away", 'channel' => $channel['channel_name'], 
											'channel_id' => $client['cid'], 
											'uid' => $client['client_unique_identifier'],
											'clid' => $client['clid'],
											'dbid' => $client['client_database_id'],
											'away_for' => $AutoSpeak::convert_time($client['client_idle_time']/1000),
										));
									else
										array_push($admins, array
										(
											'name' => $client['client_nickname'], 
											'type' => "online", 'channel' => $channel['channel_name'], 
											'channel_id' => $client['cid'], 
											'uid' => $client['client_unique_identifier'],
											'clid' => $client['clid'],
											'dbid' => $client['client_database_id'],
											'online_for' => $AutoSpeak::convert_time(time() - $client['client_lastconnected']),
										));
								}
							}
							if(!$client_online)
							{
								if(isset($query_sql))
								{
									$result = $query_sql->query("SELECT `connected_time` FROM `clients` WHERE `client_dbid`=".$client_from_group['cldbid']);
									$result = $result->fetch(PDO::FETCH_ASSOC);
									$connected_time = $result['connected_time'];
								}
								else
									$connected_time = 0;
								
								$client_info = $query->getElement('data', $query->clientDbInfo($client_from_group['cldbid']));
								array_push($admins, array('name' => $client_info['client_nickname'], 'dbid' => $client_from_group['cldbid'], 'type' => "offline", 'offline_for' => $AutoSpeak::convert_time(time() - $client_info['client_lastconnected'] - $connected_time/1000)));
							}
							$count++;
						}
					}
				}
				
				if($info['icons_enabled'])
					$desc .= "\n[size=13][b][img]".$info['icons'][$admin_group]."[/img][/b][/size]\n".(self::$cfg['admins_count'] ? "[size=9]Adminów w grupie: [b]".$count."[/b][/size]\n" : "");
				else
					$desc .= "[size=13][b][".$rang_name."][/b][/size]\n".(self::$cfg['admins_count'] ? "[size=9]Adminów w grupie: [b]".$count."[/b][/size]\n" : "");

				
				if(count($admins) == 0)
					$desc .= "\n   ●  [size=9] ".$lan['no_admins']."[/size]\n";

				foreach($admins as $admin)
				{
					if($admin['name'] != " ")
					{
						$desc .= "\n";

						if($admin['type'] == 'online')
							$desc .= "   ●  ".($admin['name'] == "Ponczek" ? "" : "")." [size=9]Nick: [URL=client://".$admin['clid']."/".$admin['uid']."]".$admin['name']."[/url]".$AutoSpeak::show_link($admin['dbid'])."[/size]\n   ●   [size=9]Status: [/size][color=green][b]Online[/b][/color] ".$lan['for']."[b]".$admin['online_for']."[/b]\n   ●   [size=9]".$lan['on_channel']."[/size][b][url=channelId://".$admin['channel_id']."]".$admin['channel']."[/url][/b]\n";
						elseif($admin['type'] == 'away')
							$desc .= "   ●  ".($admin['name'] == "Ponczek" ? "" : "")." [size=9]Nick: [URL=client://".$admin['clid']."/".$admin['uid']."]".$admin['name']."[/url]".$AutoSpeak::show_link($admin['dbid'])."[/size]\n   ●   [size=9]Status: [/size][color=#dd8300][b]Away[/b][/color] ".$lan['for']."[b]".$admin['away_for']."[/b]\n   ●   [size=9]".$lan['on_channel']."[/size][b][url=channelId://".$admin['channel_id']."]".$admin['channel']."[/url][/b]\n";
						else
							$desc .= "   ●   [size=9]Nick: ".$admin['name'].$AutoSpeak::show_link($admin['dbid'])."[/size]\n   ●   [size=9]Status: [/size][color=red][b]Offline[/b][/color] ".$lan['for']."[b]".$admin['offline_for']."[/b]\n";
					}
						
				}
				if($loop_rotation != $all_admins)
					$desc .= "[hr]";

				unset($admins);
			}
			$desc .= $language['function']['down_desc'];
			
			if($AutoSpeak::check_channel_desc($channel_id, $desc))
				$AutoSpeak::check_error($query->channelEdit($channel_id, array('channel_description' => $desc)), self::$name, $channel_id);
		}
	}
}
?>
