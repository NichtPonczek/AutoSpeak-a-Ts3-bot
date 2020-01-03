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

class afk_move
{
	private static $name;
	private static $cfg;
	
	static public function construct($plugin_name)
	{
		global $cfg;
		self::$cfg = $cfg[$plugin_name];
		self::$name = $plugin_name;
	}

	static private function client_to_move($client_info)
	{
		if((self::$cfg['move_if_away'] && $client_info['client_away'] == 1) || (self::$cfg['move_if_muted'] && $client_info['client_output_muted']) || ($client_info['client_idle_time'] >= 1000 * self::$cfg['idle_time']))
			return true;
		else 
			return false;
	}

	static private function delete_value($array, $key)
	{
		$new_array = array();

		foreach($array as $num => $ar)
		{
			if($num != $key)
			{
				array_push($new_array, $ar);
			}
		}
		return $new_array;
	}

	static public function every_client($client)
	{
		global $query, $clients, $clients_channels_afk, $language, $AutoSpeak;

		if(in_array(self::$name, $AutoSpeak::$disabled_functions))
			return;
		
		if(!$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']) && !in_array($client['cid'], self::$cfg['ignored_channels']))
		{
			if($client['cid'] != self::$cfg['channel_id'] && self::client_to_move($client))
			{
				if(isset($clients_channels_afk))
					array_push($clients_channels_afk, array('clid' => $client['clid'], 'last_channel' => $client['cid']));

				if(self::$cfg['message_type'] == "poke")
					$query->clientPoke($client['clid'], $language['function']['afk_move']['moved']);
				elseif(self::$cfg['message_type'] == "message")
					$query->sendMessage(1, $client['clid'], $language['function']['afk_move']['moved']);	

				$AutoSpeak::check_error($query->clientMove($client['clid'], self::$cfg['channel_id']), self::$name, self::$cfg['channel_id'], true);
			}
			elseif($client['cid'] == self::$cfg['channel_id'])
			{
				if(self::$cfg['move_back'] && !self::client_to_move($client))
				{
					foreach($clients_channels_afk as $num => $last)
					{
						if($last['clid'] == $client['clid'])
						{
							if(self::$cfg['message_type'] == "poke")
								$query->clientPoke($client['clid'], $language['function']['afk_move']['moved_back']);
							elseif(self::$cfg['message_type'] == "message")
								$query->sendMessage(1, $client['clid'], $language['function']['afk_move']['moved_back']);

							$query->clientMove($last['clid'], $last['last_channel']);
							$client_channel_afk[$num] = array();
							$clients_channels_afk = self::delete_value($clients_channels_afk, $num);
						}
					}	
				}
				elseif($client['cid'] == self::$cfg['channel_id'] && self::$cfg['kick_from_server']['enabled'] && ($client['client_idle_time'] >= 1000 * self::$cfg['kick_from_server']['min_idle_time']))
					$query->clientKick($client['clid'], 'server', self::$cfg['kick_from_server']['msg']);
			}
		}
	}
}
?>