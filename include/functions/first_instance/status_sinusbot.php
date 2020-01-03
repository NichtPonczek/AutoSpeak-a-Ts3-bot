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

class status_sinusbot
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
		global $query, $clients, $language, $AutoSpeak;
		
		self::$lang = $language['function']['connect_message'];
		$lan = $language['function'][self::$name];
		
		$desc = "[hr][center][size=14][b][I]".self::$cfg['top_description']."[/I][/b][/size][/center][hr]";
		$groups_list = $query->getElement('data', $query->serverGroupList());
		$count_all = 0;

		$how_many_groups = count(self::$cfg['bots_server_groups']);
		$loop_rotation = 0;
		
		foreach(self::$cfg['bots_server_groups'] as $bot_group)
		{
			$count = 0;
			$count_online = 0;
			$bots = array();

			if(!$AutoSpeak::check_group($bot_group, self::$name, $rang_name))
				continue;

			$clients_from_group = $query->getElement('data', $query->serverGroupClientList($bot_group));

			if($clients_from_group != NULL)
			{
				foreach($clients_from_group as $client_from_group)
				{
					if(isset($client_from_group['cldbid']) && $client_from_group['cldbid'] != 1)
					{
						$client_online = false;
						foreach($clients as $client)
						{
							if($client['client_database_id'] != 1 && $client['client_database_id'] == $client_from_group['cldbid'])
							{
								$client_online = true;
								$count_online++;
								$channel = $query->getElement('data', $query->channelInfo($client['cid']));

								if($client['client_idle_time'] > 1000)
									array_push($bots, array
									(
										'name' => $client['client_nickname'], 
										'type' => "away", 'channel' => $channel['channel_name'], 
										'channel_id' => $client['cid'], 
										'uid' => $client['client_unique_identifier'],
										'clid' => $client['clid'],
										'away_for' => $AutoSpeak::convert_time($client['client_idle_time']/1000)
									));
								else
									array_push($bots, array
									(
										'name' => $client['client_nickname'], 
										'type' => "online", 'channel' => $channel['channel_name'], 
										'channel_id' => $client['cid'], 
										'uid' => $client['client_unique_identifier'],
										'clid' => $client['clid'],
										'online_for' => $AutoSpeak::convert_time(time() - $client['client_lastconnected'])
									));

							}
						}
						if(!$client_online)
						{
							$client_info = $query->getElement('data', $query->clientDbInfo($client_from_group['cldbid']));
							array_push($bots, array('name' => $client_info['client_nickname'], 'type' => "offline", 'offline_for' => $AutoSpeak::convert_time(time() - $client_info['client_lastconnected'])));
						}
						$count++;
					}
				}
			}
			$desc .= "[size=13][b][".$rang_name."][/b][/size][size=9]\n".$lan['in_group']." ".$count."[/size]";

			foreach($bots as $bot)
			{
				if($bot['name'] != " ")
				{
					if($bot['type'] == 'online')
						$desc .= "[left]  ●  [size=9][b][URL=client://".$bot['clid']."/".$bot['uid']."]".$bot['name']."[/url][/b] ".$lan['is']." [b][color=green][/b] ".$lan['for']." [b]".$bot['online_for']."[/b] ".$lan['on_channel']." [b][url=channelID://".$bot['channel_id']."]".$bot['channel']."[/url].[/b][/size][/left]";
					elseif($bot['type'] == "away")
						$desc .= "[left]  ●  [size=9][b][URL=client://".$bot['clid']."/".$bot['uid']."]".$bot['name']."[/url][/b] ".$lan['is']." [b][color=red][/b] przebywa na [b][url=channelID://".$bot['channel_id']."]".$bot['channel']."[/url].[/b][/size][/left]";
					else
						$desc .= "[left]  ●  [size=9][b]".$bot['name']."[/b] ".$lan['is']." [b][color=red][/b] ".$lan['for']." [b]".$bot['offline_for']."[/b].[/size][/left]";
				}
					
			}
			unset($bots);

			$loop_rotation++;

			if($loop_rotation != $how_many_groups)
				$desc .= "[hr]";
		}
		$desc .= $language['function']['down_desc'];
		$AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_description' => $desc)), self::$name, self::$cfg['channel_id'], true);
	}
}
?>