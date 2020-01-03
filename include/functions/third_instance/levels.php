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

class levels
{
	private static $name;
	private static $cfg;
	private static $last_lvl;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
		self::$last_lvl = self::$cfg['all_levels_groups'][count(self::$cfg['all_levels_groups'])-1];
	}	
	
	static private function has_levels_rang(array $groups)
	{
		$rangs = array();
		
		foreach($groups as $group)
		{
			if(in_array($group, self::$cfg['all_levels_groups']))
				array_push($rangs, $group);
		}

		return $rangs;
	}

	static public function before_clients()
	{
		global $query, $query_sql, $language, $clients, $AutoSpeak;
		
		$levels = array();
		$i=0;
		
		foreach($clients as $client)
		{
			if(!$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']) && $client['client_database_id'] != 1)
			{
				$db_info = $query_sql->query("SELECT `time_spent` FROM `clients` WHERE `client_dbid`=".$client['client_database_id'])->fetch(PDO::FETCH_ASSOC);
				
				$good = false;
				$lvl_number = 0;
				$last_time = 0;

				foreach(self::$cfg['info'] as $sgid => $hours)
				{		
					$lvl_number++;

					if($db_info['time_spent'] >= ($hours*1000*60*60))
					{
						$good = true;
						$give = $sgid;
						$last_time = $hours;
					}
					else
					{	
						$hours = round($hours - $db_info['time_spent']/3600000);
						break;
					}
				}

				if(!isset($give))
					continue;

				if($good && !in_array($give, explode(",", $client['client_servergroups'])))
				{
					foreach(self::has_levels_rang(explode(",", $client['client_servergroups'])) as $lvl_sgid)
						if(isset($lvl_sgid) && $lvl_sgid != $give)
							$query->serverGroupDeleteClient($lvl_sgid, $client['client_database_id']);

					if(self::$cfg['info_to_client'] != 'none')
					{
						$server_rangs = $query->getElement('data', $query->serverGroupList());
						foreach($server_rangs as $once)
							if($once['sgid'] == $give)
								break;
					
						if($give != self::$last_lvl)
							$msg = str_replace(array('[NAME]', '[HOURS]'), array($once['name'], $hours), $language['function']['levels']['next']);
						else
							$msg = str_replace(array('[NAME]', '[HOURS]'), array($once['name'], $hours), $language['function']['levels']['last']);

						if(self::$cfg['info_to_client'] == "poke")
							$query->clientPoke($client['clid'], $msg);
						else
							$query->sendMessage(1, $client['clid'], $msg);
					}
					
					$query->serverGroupAddClient($give, $client['client_database_id']);
					$AutoSpeak::set_action(self::$name, array('client' => $client, 'lvl_name' => $once['name']));
				}
				elseif(!$good)
					foreach(self::has_levels_rang(explode(",", $client['client_servergroups'])) as $lvl_sgid)
						if(isset($lvl_sgid))
							$query->serverGroupDeleteClient($lvl_sgid, $client['client_database_id']);

			}
		} 
		
		$data = $query_sql->query('SELECT * FROM `clients` ORDER BY time_spent DESC LIMIT '.(self::$cfg['records']*10))->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($data as $user)
		{	
			if(!$AutoSpeak::has_group($user['server_groups'], self::$cfg['ignored_groups']) && $user['client_dbid'] != 1)
			{
				$good = false;
				$lvl_number = 0;
				$last_time = 0;

				foreach(self::$cfg['info'] as $sgid => $hours)
				{		
					$lvl_number++;

					if($user['time_spent'] >= ($hours*1000*60*60))
					{
						$good = true;
						$give = $sgid;
						$last_time = $hours;
					}
					else
						break;
				}

				if(!isset($give))
					continue;
				
				if(!in_array(self::$last_lvl, explode(',', $user['server_groups'])) && $give == self::$last_lvl)
				{				
					$give = self::$last_lvl;
					$good = true;
				}

				$lvl = array('sgid' => $give, 'nick' => $user['client_nick'], 'dbid' => $user['client_dbid'], 'uid' => $user['client_uid']);

				if($i<self::$cfg['records'])
				{
					array_push($levels, $lvl);
					$i++;
				}
				else
					break;
			}
		} 

		$desc = "[hr][center][size=14][b]".self::$cfg['top_description']."[/b][/size][/center][hr]\n";
		$count = 1;
		$last_id = 0;
		
		 if(count($levels) > 0)
		{
			foreach($levels as $lvl)
			{
				if($lvl['sgid'] != $last_id || !isset($name))
				{
					$server_groups = $query->getElement('data', $query->serverGroupList());

					foreach($server_groups as $gr)
						if($gr['sgid'] == $lvl['sgid'])
						{
							$name = $gr['name'];
							$last_id = $gr['sgid'];
							break;
						}
				}
				
				$desc .= "[list][*] [size=15] ".$count++.". [/size] [size=9][b]  Nick: [url=client://1/".$lvl['uid']."]".$lvl['nick']."[/url]".$AutoSpeak::show_link($lvl['dbid'])." ".$name."[/size][/list]";
			}
		}
		else
			$desc .= "[list][*] [size=15] Brak osób z levelami [/size][/list]";

		$desc .= $language['function']['down_desc'];
	
		if($AutoSpeak::check_channel_desc(self::$cfg['channel_id'], $desc))
			$AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_description' => $desc)), self::$name, self::$cfg['channel_id']); 
		
		unset($data);
	}
}
?>
