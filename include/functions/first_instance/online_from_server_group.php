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

class online_from_server_group
{
	private static $name;
	private static $cfg;
	public static $disabled_groups = array();
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}

	static private function replace($text, $online, $max)
	{
		$edited_text = array
		(
			'[ONLINE]' => $online,
			'[MAX]' => $max,		
		);
		return str_replace(array_keys($edited_text), array_values($edited_text), $text);
	}

	static public function before_clients()
	{
		global $query, $clients, $language, $query_sql, $AutoSpeak;
		
		if(isset($query_sql))
		{
			$result = $query_sql->query("SELECT `online_from`, `group_id`, `type_id` FROM `vip_channels`");
			if($result->rowCount() > 0)
			{	
				global $cfg;
				$result = $result->fetchAll(PDO::FETCH_ASSOC);

				foreach($result as $once)
					if($once['online_from'] != 0)
					{	
						$channel_name = (isset($cfg['get_vip_channel_spacer']['info'][$once['type_id']]['online_from_server_group_name']) ? $cfg['get_vip_channel_spacer']['info'][$once['type_id']]['online_from_server_group_name'] : 'Online z [SERVER_GROUP]: [ONLINE]/[MAX]');
						
						self::$cfg['info'][$once['online_from']] = array('server_groups' => array($once['group_id']), 'only_online' => false, 'show_description' => true, 'channel_name' => $channel_name,'top_description' => '| Lista osób z rangi: [SERVER_GROUP] |');
					}
			}
		}
		
		foreach(self::$cfg['info'] as $channel_id => $inf)
		{
			$show_more = false;
			$count = 0;
			$count_all = 0;
			$users = array();
			$clients_from = array();
			$group_names = array();

			if(count($inf['server_groups']) == 1 && in_array($inf['server_groups'][0], self::$disabled_groups)) continue;
			
			foreach($inf['server_groups'] as $server_group)
			{
				if(in_array($server_group, self::$disabled_groups) || !$AutoSpeak::check_group($server_group, self::$name, $group_name))
					continue;

				$group_names[] = $group_name;
				
				foreach($query->getElement('data', $query->serverGroupClientList($server_group, true)) as $client)
					$clients_from[] = $client;
			}
			
			if(count($clients_from) <= 25 && self::$cfg['show_time'])
				$show_more = true;
				
			foreach($clients_from as $client_from_group)
			{
				$flag = false;
				if(isset($client_from_group['cldbid']) && $client_from_group['cldbid'] != 1)
				{
					foreach($clients as $client)
					{
						if($client['client_database_id'] != 1 && $client['client_database_id'] == $client_from_group['cldbid'])
						{
							$flag = true;
							$count++;
							if($show_more)
								array_push($users, array('name' => $client['client_nickname'], 'dbid' => $client['client_database_id'], 'uid' => $client['client_unique_identifier'], 'clid' => $client['clid'], 'status' => 'online', 'from' => $AutoSpeak::convert_time(time() - $client['client_lastconnected'])));
							else
								array_push($users, array('name' => $client['client_nickname'], 'dbid' => $client['client_database_id'], 'uid' => $client['client_unique_identifier'], 'clid' => $client['clid'], 'status' => 'online'));
							break;
						}
					}
			
					if(!$flag && !$inf['only_online'])
					{
						if($show_more)
						{
							$client_info = $query->getElement('data', $query->clientDbInfo($client_from_group['cldbid']));
							array_push($users, array('name' => $client_from_group['client_nickname'], 'status' => 'offline', 'dbid' => $client_from_group['cldbid'], 'from' => $AutoSpeak::convert_time(time() - $client_info['client_lastconnected'])));
						}
						else
							array_push($users, array('name' => $client_from_group['client_nickname'], 'dbid' => $client_from_group['cldbid'], 'status' => 'offline'));
					}

					$count_all++;	
				}
			}
			
			$groups = "";
			foreach($group_names as $index => $group_name) $groups .= ($index != count($group_names)-1 ? $group_name." & " : $group_name);
			
			$desc = str_replace("[SERVER_GROUP]", $groups, "[hr][center][size=14][b]".$inf['top_description']."[/b][/size][hr][/center]\n");
			$count_all = ($count_all == 0 ? 0 : count($clients_from));

			if(count($users) != 0 && $inf['show_description'])
				foreach($users as $index => $user)
				{
					if($user['status'] == 'online')
					{
						if($show_more)
							$desc .= "[size=13][color=green]• [/color][/size][size=9][URL=client://".$user['clid']."/".$user['uid']."]".$user['name']."[/url]".$AutoSpeak::show_link($user['dbid'])."[/size][size=8][B][color=green] ONLINE[/color][/B]: ".$user['from'].".[/size]\n";

						else
							$desc .= "[size=13][color=green]• [/color][/size][size=9][URL=client://".$user['clid']."/".$user['uid']."]".$user['name']."[/url]".$AutoSpeak::show_link($user['dbid'])."[/size]\n";
					}
					else
					{
						if($show_more)
							$desc .= "[size=13][color=red]• [/color][/size][size=9][b][color=grey]".$user['name']."[/color][/b]".$AutoSpeak::show_link($user['dbid'])."[/size][size=8][B][color=red] OFFLINE[/color][/B]: ".$user['from'].".[/size]\n";
						else
							$desc .= "[size=13][color=red]• [/color][/size][size=9][b][color=grey]".$user['name']."[/color][/b]".$AutoSpeak::show_link($user['dbid'])."[/size]\n";
					}
					
					if($index > self::$cfg['max_users'])
						break;
				}
			else
				$desc .= "[size=13]• ".$language['function']['online_from_server_group']."[/size]\n";

			$desc .= $language['function']['down_desc'];
					
			$name = str_replace("[SERVER_GROUP]", $group_names[0], self::replace($inf['channel_name'], $count, $count_all));
			$channel = $query->getElement('data', $query->channelInfo($channel_id));
			
			if($inf['show_description'] && $AutoSpeak::check_channel_desc($channel_id, $desc))
			{
				if($name != $channel['channel_name'])
					$AutoSpeak::check_error($query->channelEdit($channel_id, array('channel_name' => $name, 'channel_description' => $desc)), self::$name, $channel_id);
				elseif($show_more)
					$AutoSpeak::check_error($query->channelEdit($channel_id, array('channel_description' => $desc)), self::$name, $channel_id);
			}
			else if(!$inf['show_description'] && $name != $channel['channel_name'])
				$AutoSpeak::check_error($query->channelEdit($channel_id, array('channel_name' => $name)), self::$name, $channel_id);
		}
	}
}
?>
