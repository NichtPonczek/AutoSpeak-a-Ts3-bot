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

class groups_security
{
	private static $name;
	private static $cfg;
	private static $id_off = array();
	private static $from_cache = array();
	
	static public function construct($plugin_name)
	{
		global $cfg;
		self::$cfg = $cfg[$plugin_name];
		self::$name = $plugin_name;
	}
	
	static public function before_clients()
	{
		$cache = json_decode(file_get_contents("include/cache/groups_security.txt"), true);
		self::$from_cache = array();
		
		if(!empty($cache))
			foreach(self::$cfg['info'] as $index => $info)
				if(in_array($info['group_id'], array_keys($cache)))
					foreach($cache[$info['group_id']] as $user)
						self::$from_cache[$info['group_id']][] = $user;
	}
	
	static public function every_client($client)
	{
		global $query, $logs_manager, $language, $AutoSpeak;
		
		$count = count(self::$cfg['info']);
		$client_groups = explode(',', $client['client_servergroups']);
		
		for($i = 0; $i<$count; $i++)
		{	
			if(in_array($i, self::$id_off))
				continue;
	
			$info = self::$cfg['info'][$i];
			$sgid = $info['group_id'];
			
			if(isset(self::$from_cache[$sgid]))
				$ignored = array_merge($info['ignored_dbid'], self::$from_cache[$sgid]);
			else
				$ignored = $info['ignored_dbid'];
			
			if(!$AutoSpeak::check_group($sgid, self::$name))
			{
				unset(self::$cfg['info'][$i]);
				array_push(self::$id_off, $i);
				continue;
			}
			
			if(self::$cfg['info'][$i]['give_back'])
			{
				if(in_array($client['client_database_id'], $ignored) && !in_array($sgid, $client_groups))
					$query->serverGroupAddClient($sgid, $client['client_database_id']);	
			}
			if(in_array($info['group_id'], $client_groups))
			{
				if($client['client_database_id']!=0)
				{
					$flag = true;
					if(in_array($client['client_database_id'], $ignored))
						$flag = false;
				
					if($flag)
					{	
						$choice = 0;
						$message = $info['message'];
			
						if($info['type'] == 'ban')
						{
							$choice = 1;
							$ban_time = $info['time'];
						}
						else if($info['type'] == 'kick')
							$choice = 2;
						else 
							$choice = 3;

						$uid = $client['client_unique_identifier'];
						$nick = $client['client_nickname'];
						$clid = $client['clid'];

						$query->serverGroupDeleteClient($sgid, $client['client_database_id']);

						switch($choice)
						{
							case 1:
								$query->banAddByUid($uid, $ban_time, $message);
								$logs_manager::write_info(" [".self::$name."] ".$nick.$language['logs']['groups_security']['ban'].$sgid);
								break;
							case 2:
								$query->clientKick($clid, "server", $message);
								$logs_manager::write_info(" [".self::$name."] ".$nick.$language['logs']['groups_security']['kick'].$sgid);
								break;
							case 3: 
								$query->clientPoke($clid, $message);
								$logs_manager::write_info(" [".self::$name."] ".$nick.$language['logs']['groups_security']['nothing'].$sgid);
								break;
						}
					}	
				}
			}
		}
	}
}
?>