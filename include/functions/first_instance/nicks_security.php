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

class nicks_security
{
	private static $name;
	private static $cfg;
	private static $bad_nicks;
	private static $cache_kicks = array();
	
	static public function construct($plugin_name)
	{
		global $cfg;
		self::$cfg = $cfg[$plugin_name];
		self::$name = $plugin_name;
		$bad_nicks_file = fread(fopen(self::$cfg['file'], "r"), filesize(self::$cfg['file']));
		self::$bad_nicks = explode(",", str_replace(' ', '', strtolower($bad_nicks_file)));
	}
	
	static private function has_bad_nick(&$nick)
	{
		foreach(self::$bad_nicks as $bad_nick)
		{
			if($bad_nick != "" && strpos($nick, $bad_nick) !== false)
			{
				$nick = $bad_nick;
				return true;
			}
		}

		return false;
	}

	static private function set_cache($cldbid)
	{
		if(self::$cfg['ban']['enabled'])
		{
			if(isset(self::$cache_kicks[$cldbid]))
			{
				self::$cache_kicks[$cldbid]['count']++;
				self::$cache_kicks[$cldbid]['time'] = time();
			}	
			else
				self::$cache_kicks[$cldbid] = array('count' => 1, 'time' => time());
		}
	}
	
	static private function check_cache($cldbid, $uid)
	{
		global $query, $language;
		
		if(isset(self::$cache_kicks[$cldbid]) && self::$cache_kicks[$cldbid]['count'] >= self::$cfg['ban']['min_kicks'])
		{
			$query->banAddByUid($uid, self::$cfg['ban']['ban_time'], $language['function'][self::$name]['ban']);
			unset(self::$cache_kicks[$cldbid]);
			return false;
		}
		
		return true;
	}
	
	static public function before_clients()
	{
		if(!empty(self::$cache_kicks))
			foreach(self::$cache_kicks as $dbid => $info)
				if(time() - $info['time'] >= self::$cfg['ban']['cache_reset'])
					unset(self::$cache_kicks[$dbid]);
	}
	
	static public function every_client($client)
	{
		global $query, $language, $AutoSpeak, $query_sql;

		$nick = strtolower($client['client_nickname']);
		$away_message = strtolower($client['client_away_message']);

		if(!$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']))
		{
			if(self::has_bad_nick($nick))
			{
				if(isset($query_sql)) $query_sql->exec("UPDATE `clients` SET `client_nick`='".$client['client_nickname']."' WHERE `client_dbid`=".$client['client_database_id']);
				if(!self::$cfg['ban']['enabled'] || self::check_cache($client['client_database_id'], $client['client_unique_identifier']))
				{
					$query->clientKick($client['clid'], "server", $language['function'][self::$name]['kick_message'].$nick);
					$AutoSpeak::set_action(self::$name, array('client' => $client, 'type' => 'nick'));
					self::set_cache($client['client_database_id']);
				}
			}
			elseif(self::$cfg['check_away_message'] && self::has_bad_nick($away_message))
			{
				if(!self::$cfg['ban']['enabled'] || self::check_cache($client['client_database_id'], $client['client_unique_identifier']))
				{
					$query->clientKick($client['clid'], "server", $language['function'][self::$name]['bad_away_message'].$away_message);
					$AutoSpeak::set_action(self::$name, array('client' => $client, 'type' => 'away'));
					self::set_cache($client['client_database_id']);
				}
			}
			elseif(self::$cfg['check_away_message'])
			{
				$client_info = $query->getElement('data', $query->clientInfo($client['clid']));
				$desc = strtolower($client_info['client_description']);
				if(self::has_bad_nick($desc))
				{
					if(!self::$cfg['ban']['enabled'] || self::check_cache($client['client_database_id'], $client['client_unique_identifier']))
					{
						$query->clientKick($client['clid'], "server", $language['function'][self::$name]['bad_desc'].$desc);
						$query->clientDbEdit($client['client_database_id'], array('client_description' => ''));		
						$AutoSpeak::set_action(self::$name, array('client' => $client, 'type' => 'desc'));
						self::set_cache($client['client_database_id']);
					}
				}
			}
		}
	}
}
?>