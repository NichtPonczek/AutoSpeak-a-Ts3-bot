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

class poke_admins
{
	public static $clear = 1;
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}

	static public function reset_cache()
	{
		global $clients, $cache_client_poke;
		
		if($cache_client_poke == NULL)
			return;

		foreach($clients as $client)
			if(in_array($client['clid'], array_keys($cache_client_poke)) && $client['cid'] != $cache_client_poke[$client['clid']])
				unset($cache_client_poke[$client['clid']]);
	}

	static private function admin_on_channel($cid, $admin_rangs)
	{
		global $clients, $cache_client_poke;

		foreach($clients as $client)
			if($client['client_database_id'] != 1 && $client['cid'] == $cid)
				foreach(explode(",", $client['client_servergroups']) as $client_group)	
					if(in_array($client_group, $admin_rangs))
					{
						foreach($cache_client_poke as $cache_clid => $cache_cid)	
							if($cache_cid == $cid)
								unset($cache_client_poke[$cache_clid]);

						return true;	
					}	

		return false;
	}

	static private function client_is_on_channel($cid, $cldbid)
	{
		global $clients, $cache_client_poke;

		foreach($clients as $client)
		{
			if($client['client_database_id'] != 1 && $client['cid'] == $cid)
			{ 
				if($client['client_database_id'] == $cldbid)
				{
					foreach($cache_client_poke as $cache_clid => $cache_cid)	
						if($cache_cid == $cid)
							unset($cache_client_poke[$cache_clid]);

					return true;	
				}	
			}
		}
		return false;
	}

	static public function main($client_info)
	{
		global $query, $server_info, $clients, $cache_client_poke, $language, $AutoSpeak, $logs_manager;

		$lang = $language['function']['poke_admins'];
		$admins = array(); 
		$prefix = "\t» ";

		if(self::$cfg['kick_if_away'])
		{
			$msg = "";
			
			if($client_info['client_away'])
				$msg = $lang['away'];
			elseif($client_info['client_input_muted'])
				$msg = $lang['input'];
			elseif($client_info['client_output_muted'])
				$msg = $lang['output'];
			
			if($msg != "")
			{
				$query->clientPoke($client_info['clid'], $msg);
				$query->clientKick($client_info['clid'], 'channel');
				return;
			}
		}
		
		if($AutoSpeak::has_group($client_info['client_servergroups'], self::$cfg['ignored_group_if_on_channel']))
			return;
		
		if(self::$cfg['inform_admin_once'] && isset($cache_client_poke[$client_info['clid']]) && $cache_client_poke[$client_info['clid']] == $client_info['cid'])
			return;
		
		foreach(self::$cfg['info'] as $channel => $admins_group)
		{
			if($client_info['cid'] == $channel)
			{
				if(gettype($admins_group) == 'array' && !self::admin_on_channel($channel, $admins_group))
				{
					$count = 0;
					foreach($admins_group as $admin_group)
					{
						$clients_from_group = $query->serverGroupClientList($admin_group);
						
						if(!$clients_from_group['success'])
						{
							$logs_manager::set_error("#Gr1:".$admin_group, self::$name);
							continue;
						}
						else
							$clients_from_group = $clients_from_group['data'];

						foreach($clients_from_group as $client_from_group)
						{
							if(isset($client_from_group['cldbid']) && $client_from_group['cldbid'] != 1)
							{
								foreach($clients as $client)
								{
									if($client['client_database_id'] != 1 && $client['client_database_id'] == $client_from_group['cldbid'] && !$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']))
									{
										$count++;
										array_push($admins, array('name' => $client['client_nickname'], 'uid' => $client['client_unique_identifier']));
										if(!in_array($client['cid'], self::$cfg['ignored_channels']))
										{
											if(self::$cfg['show_client_link'])
											{
												$query->clientPoke($client['clid'], "[b][url=client://1/".$client_info['client_unique_identifier']."]".$client_info['client_nickname']."[/url][/b]");
												$query->clientPoke($client['clid'], "[color=red]".$lang['wants_help']."[/color]");
											}
											else
												$query->clientPoke($client['clid'], "[color=red][b]".$client_info['client_nickname']."[/b][/color] ".$lang['wants_help']);

											if(self::$cfg['informing_about_channel'])
											{
												$channel = $query->getElement('data', $query->channelInfo($client_info['cid']));
												$query->clientPoke($client['clid'],  $lang['on_channel']."[u][color=blue]".$channel['channel_name']."[/color][/u]");
											}
										}
									}
								}
							}
						}
					}
				
					if($cache_client_poke == NULL || !array_key_exists($client_info['clid'], $cache_client_poke))
					{
						$message_for_client = "\n".$lang['hi']." [b]".$client_info['client_nickname']."[/b]\n";
						if($count > 0)
						{
							$message_for_client .= $prefix.$lang['in_this_moment']."[b]".$count."[/b]\n";
	
							foreach($admins as $admin)
								$message_for_client .= "\t\t[url=client://1/".$admin['uid']."][u]".$admin['name']."[/u][/url]\n";

							$message_for_client .= "\n\n\t[color=green][b]".$lang['help']."[/b][/color]";
						}
						else
							$message_for_client .= $prefix.$lang['no_admins']." :)\n";

						foreach(explode("\n", $message_for_client) as $mess) 
							$query->sendMessage(1, $client_info['clid'], $mess);
							
						$cache_client_poke[$client_info['clid']] = $client_info['cid'];
						
						$AutoSpeak::set_action(self::$name, array('client' => $client_info));
					}
				}
				elseif(gettype($admins_group) != 'array' && !self::client_is_on_channel($channel, $admins_group))
				{
					foreach($clients as $client)
						if($client['client_database_id'] == $admins_group && !$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']))
						{
							if(self::$cfg['show_client_link'])
							{
								$query->clientPoke($client['clid'], "[b][url=client://1/".$client_info['client_unique_identifier']."]".$client_info['client_nickname']."[/url][/b]");
								$query->clientPoke($client['clid'], "[color=red]".$lang['wants_help']."[/color]");
							}
							else
								$query->clientPoke($client['clid'], "[color=red][b]".$client_info['client_nickname']."[/b][/color] ".$lang['wants_help']);

							if(self::$cfg['informing_about_channel'])
							{
								$channel = $query->getElement('data', $query->channelInfo($client_info['cid']));
								$query->clientPoke($client['clid'],  $lang['on_channel']."[u][color=blue]".$channel['channel_name']."[/color][/u]");
							}

							break;
						}

					if($cache_client_poke == NULL || !array_key_exists($client_info['clid'], $cache_client_poke))
					{
						$message_for_client = "\n".$lang['hi']." [b]".$client_info['client_nickname']."[/b]\n";
						$message_for_client .= $client['client_nickname']." ".$lang['informed'];
	
						$query->sendMessage(1, $client_info['clid'], $message_for_client);
						$cache_client_poke[$client_info['clid']] = $client_info['cid'];
						
						$AutoSpeak::set_action(self::$name, array('client' => $client_info));
					}
				}
			}
		}
	}
}
?>