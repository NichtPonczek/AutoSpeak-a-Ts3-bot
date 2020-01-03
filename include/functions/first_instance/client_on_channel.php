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

class client_on_channel
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}

	static private function replace($text, $status, $group_name, $nick)
	{
		$edited_text = array
		(
			'[RANG]' => $group_name,
			'[NICK]' => $nick,
			'[STATUS]' => $status,			
		);
		return str_replace(array_keys($edited_text), array_values($edited_text), $text);
	}

	static public function before_clients()
	{
		global $query, $clients, $AutoSpeak, $language;
		
		$groups_list = $query->getElement('data', $query->serverGroupList());
		
		foreach(self::$cfg['server_groups_id'] as $server_group)
		{
			$clients_from_group = array();
			$good_cli = array();
			$stat = array();

			if(!$AutoSpeak::check_group($server_group, self::$name, $group_name))
				continue;

			$clients_from_group_1 = $query->getElement('data', $query->serverGroupClientList($server_group));

			if($clients_from_group_1 != NULL)
				foreach($clients_from_group_1 as $client_from_group)
					if(isset($client_from_group['cldbid']) && $client_from_group['cldbid'] != 1)
						array_push($clients_from_group, array('cldbid' => $client_from_group['cldbid']));		

			foreach(self::$cfg['info'] as $dbid => $inf)
			{
				foreach($clients_from_group as $cl)	
					if($cl['cldbid'] == $dbid)
					{
						$client_info = $query->getElement('data', $query->clientDbInfo($cl['cldbid']));
						array_push($good_cli, array('cldbid' => $cl['cldbid'], 'channel_id' => $inf['channel_id'], 'format' => $inf['format'], 'status' => "offline", 'nick' => $client_info['client_nickname'], 'fb' => $inf['fb'], 'email' => $inf['email'], 'uid' => $client_info['client_unique_identifier']));
					}
			}
			
			unset($clients_from_group);

			foreach($clients as $client)
			{
				foreach($good_cli as $index => $cl)
				{
					if($cl['cldbid'] == $client['client_database_id'] && !$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']))
					{
						if($client['client_output_muted'] || $client['client_away'] != 0 || $client['client_idle_time'] > 1000*self::$cfg['idle_time'])
							$status = "away";
						else
							$status = "online";	
							
						$good_cli[$index]['status'] = $status;
					}
				}	
			}

			foreach($good_cli as $cl)
			{
				$desc = "[center][hr]\n[size=15][b][ ".$group_name." ][/b][/size][/center]\n   •  [size=9][B]Nick:[/B] [url=client://1/".$cl['uid']."]".$cl['nick']."[/url]".$AutoSpeak::show_link($cl['cldbid'])."[/size]\n";
				
				if($cl['status'] == 'online')
					$desc .= "   •  [size=9][B]Status[/B]: [/size][color=green][b]Online[/b][/color] \n";
				elseif($cl['status'] == 'away')
					$desc .= "   •   [size=9][B]Status[/B]: [/size][color=#dd8300][b]Away[/b][/color] \n";
				else
					$desc .= "   •  [size=9][B]Status[/B]: [/size][color=red][b]Offline[/b][/color] \n";
				
				if($cl['fb'] != '0' || $cl['email'] != '0')
					$desc .= "[hr][center][size=15][b]OPIS[/b][/size][/center]".($cl['fb'] != '0' ? "   •   [B]FB[/B]: [url=".$cl['fb']."]  FB  [/url]\n" : "").($cl['email'] != '0' ? "   •  [B]Email[/B]: [url=mailto:".$cl['email']."]  ".$cl['email']."  [/url]\n" : "" );
			
				$desc .= $language['function']['down_desc'];
				
				$name = self::replace($cl['format'], self::$cfg['status'][$cl['status']], $group_name, $cl['nick']);
				$channel = $query->getElement('data', $query->channelInfo($cl['channel_id']));
				if($name != $channel['channel_name'])
				{
					if(self::$cfg['show_description'])
						$AutoSpeak::check_error($query->channelEdit($cl['channel_id'], array('channel_name' => $name, 'channel_description' => $desc)), self::$name, $cl['channel_id']);
					else
						$AutoSpeak::check_error($query->channelEdit($cl['channel_id'], array('channel_name' => $name)), self::$name, $cl['channel_id']);
				}
						
			}
			unset($good_cli, $stat);
		}
	}
}
?>
