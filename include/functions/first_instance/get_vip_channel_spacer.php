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

class get_vip_channel_spacer
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
		global $query, $AutoSpeak, $query_sql, $language, $cfg;
		
		if(!isset($query_sql))
			return;
		
		foreach(self::$cfg['info'] as $type => $info)
		{
			$result = $query_sql->query("SELECT * FROM `vip_channels` WHERE `type_id`='".$type."' ORDER BY `id` ASC");
			$lang = $language['function']['get_private_channel'];
		
			if($result->rowCount() != 0)
			{
				$result = $result->fetchAll(PDO::FETCH_ASSOC);
		
				foreach($result as $channel)
				{
					$spacers = explode(',', $channel['channel_cid']);
					
					if($query->getElement('data', $query->channelInfo($spacers[0])) == NULL)
					{
						if($channel['spacer_cid'] != 0 && $query->getElement('data', $query->channelInfo($channel['spacer_cid'])) != NULL)
							$query->channelDelete($channel['spacer_cid']);
								
						foreach($spacers as $spacer)
							if($spacer != NULL && $spacer != "" && $spacer != 0 && $query->getElement('data', $query->channelInfo($spacer)) != NULL)
							{
								$query->channelDelete($spacer);
								usleep(500000);
							}
								
						if(class_exists('get_server_group'))
							foreach($cfg['get_server_group']['if_client_on_channel'] as $index => $cid)
								if($cid == $channel['get_group'])
									unset($cfg['get_server_group']['if_client_on_channel'][$index]);
									
						if(class_exists('online_from_server_group'))
							online_from_server_group::$disabled_groups[] = $channel['group_id'];	
						
						if($cfg['move_groups']['enabled'] && $cfg['move_groups']['vip_channels_from_AutoSpeak']['enabled'])
						{
							foreach(move_groups::$from_vip_channels as $key => $info)
							{
								if(in_array($channel['group_id'], $info['groups']))
								{
									unset(move_groups::$from_vip_channels[$key]);
									break;
								}
							}	
						}
						
						$query->serverGroupDelete($channel['group_id']);
						$query_sql->exec("DELETE FROM `vip_channels` WHERE id=".$channel['id']);
						
						foreach($result as $res)
						{
							if($res['id'] > $channel['id'] && $res['type_id'] == $type)
							{
								$client = $query->getElement('data', $query->clientDbInfo($res['owner_dbid']));
								$res_spacers = explode(',', $res['channel_cid']);
						
								$desc = "[center][size=15][b]".str_replace('[TYPE]', $type, $language['function']['get_vip_channel']['top_desc']).($res['channel_num']-1)."[/b][/size][/center]\n";
								$desc .= "[left] ● [size=11][b]".$lang['owner']."[URL=client://2/".$client['client_unique_identifier']."]".$client['client_nickname']."[/url][/b][/size][/left][left] ● [size=11][b]".$lang['created']."".date('d-m-Y G:i', $res['created'])."\n[/b][/size][/left]\n".$language['function']['down_desc'];
								
								$query_sql->exec("UPDATE `vip_channels` SET `channel_num`=".($res['channel_num']-1)." WHERE id=".$res['id']);
								$query->channelEdit($res_spacers[0], array('channel_description' => $desc));
								
								$i=0;
								
								foreach($info['spacers'] as $spacer_info)
								{
									$query->channelEdit($res_spacers[$i], array('channel_name' => str_replace('[NUM]', $res['channel_num']-1, $spacer_info['spacer']['name'])));
									$i++;
								}
								
								$query->channelEdit($res['spacer_cid'], array('channel_name' => str_replace('[NUM]', $res['channel_num']-1, $info['spacer_between']['spacer_name'])));
								
								foreach($query->getElement('data', $query->serverGroupList()) as $group)
									if($group['name'] == $type.$res['channel_num'])
									{
										$query->serverGroupRename($group['sgid'], $type.($res['channel_num']-1));
										break;
									}
							}		
						}
					}
				}
			}
		}
	}
	
	static public function main($client)
	{
		global $query, $language, $clients, $AutoSpeak, $query_sql, $cfg, $logs_manager;

		if(!isset($query_sql))
		{
			$query->clientPoke($client['clid'], $language['function']['get_vip_channel']['error_db']);
			return;
		}

		foreach(self::$cfg['info'] as $type => $info)
		{
			if($client['cid'] != $info['if_on_channel'])
				continue;
			
			$result = $query_sql->query("SELECT * FROM `vip_channels` WHERE `owner_dbid`=".$client['client_database_id']." AND `type_id`='".$type."'");
			if($result->rowCount() != 0)
			{			
				$query->clientPoke($client['clid'], str_replace('[TYPE]', $type, $language['function']['get_vip_channel']['has_channel']));
				continue;
			}

			$result = $query_sql->query("SELECT * FROM `vip_channels` WHERE `type_id`='".$type."' ORDER BY `id` ASC");
			$data = array();
			$no_channel = false;
			$edit_db = false;
			$lang = $language['function']['get_private_channel'];
		
			if($result->rowCount() == 0)
			{
				$last_channel = $info['after_channel'];
				$number = 1;
			}
			else
			{
				$data = $result->fetchAll(PDO::FETCH_ASSOC);
		
				foreach($data as $channel)
				{
					foreach(explode(',', $channel['channel_cid']) as $spacer_cid)
					{
						if($spacer_cid != NULL)
						{
							$channel_info = $query->getElement('data', $query->channelInfo($spacer_cid));
							$is_spacer = false;
					
							if($channel_info != NULL)
							{
								$is_spacer = true;
								break;
							}
						}
					}

					if(!$is_spacer)
					{
						$no_channel = true;
						break;
					}
					
					if($info['spacer_between']['enabled'])
					{
						$spacer_info = $query->getElement('data', $query->channelInfo($channel['spacer_cid']));

						if($spacer_info == NULL)
						{
							$spacer = $query->channelCreate(array
							(
								'channel_name' => str_replace('[NUM]', $channel['channel_num'], $info['spacer_between']['spacer_name']),
								'channel_flag_semi_permanent' => 0,
								'channel_flag_permanent' => 1,
								'channel_flag_maxclients_unlimited' => 0,
								'channel_flag_maxfamilyclients_unlimited' => 0,
								'channel_flag_maxfamilyclients_inherited' => 0,
								'channel_order' => $channel['channel_cid'],
								'channel_maxclients' => 0,
								'channel_maxfamilyclients' => 0,
							));
							$query->channelAddPerm($spacer['data']['cid'], array(NEEDED_MODIFY_POWER => $info['spacer_between']['modify_needed'], NEEDED_JOIN_POWER => $info['spacer_between']['join_needed']));

							$query_sql->exec("UPDATE `vip_channels` SET `spacer_cid`=".$spacer['data']['cid']." WHERE `id` = ".$channel['id']);
							$channel['spacer_cid'] = $spacer['data']['cid'];
							usleep(500000);
						}
					}
	
					$last_channel_db = $channel;
				}

				if(!$no_channel)
				{
					if($info['spacer_between']['enabled'])
						$last_channel = $channel['spacer_cid'];
					else
						$last_channel = $channel['channel_cid'];

					$number = $channel['channel_num'] + 1;
				}
				else
				{
					if(isset($last_channel_db))
					{
						$number = $channel['channel_num'];
					
						if($info['spacer_between']['enabled'])
							$last_channel = $last_channel_db['spacer_cid'];
						else
							$last_channel = $last_channel_db['channel_cid'];
					}
					else
					{
						$last_channel = $info['after_channel'];
						$number = 1;
					}
		
					$edit_db = true;
				}
			}
 
			$spacers = "";
			$spacer_number = 1;
			$get_group_created = false;
			$online_group_created = false;
			
			foreach($info['spacers'] as $spacer_info)
			{
				if($spacer_number == 1)
				{
					$desc = "[center][size=15][b]".str_replace('[TYPE]', $type, $language['function']['get_vip_channel']['top_desc']).$number."[/b][/size][/center]\n";
					$desc .= "[left] ● [size=11][b]".$lang['owner']."[URL=client://2/".$client['client_unique_identifier']."]".$client['client_nickname']."[/url][/b][/size][/left][left] ● [size=11][b]".$lang['created']."".date('d-m-Y G:i')."\n[/b][/size][/left]\n".$language['function']['down_desc'];
					$topic = date('d-m-Y G:i');
				}
				else
				{
					$desc = "";
					$topic = "";
				}
				
				if($spacer_info['spacer']['spacer_red'])
					$spacer = $query->channelCreate(array
					(
						'channel_name' => str_replace('[NUM]', $number, $spacer_info['spacer']['name']),
						'channel_topic' => $topic,
						'channel_flag_semi_permanent' => 0,
						'channel_flag_permanent' => 1,
						'channel_flag_maxclients_unlimited' => 0,
						'channel_flag_maxfamilyclients_unlimited' => 1,
						'channel_flag_maxfamilyclients_inherited' => 0,
						'channel_maxclients' => 0,
						'channel_order' => $last_channel,
						'channel_description' => $desc,
					));
				else
					$spacer = $query->channelCreate(array
					(
						'channel_name' => str_replace('[NUM]', $number, $spacer_info['spacer']['name']),
						'channel_topic' => $topic,
						'channel_flag_semi_permanent' => 0,
						'channel_flag_permanent' => 1,
						'channel_flag_maxclients_unlimited' => 1,
						'channel_flag_maxfamilyclients_unlimited' => 1,
						'channel_flag_maxfamilyclients_inherited' => 0,
						'channel_order' => $last_channel,
						'channel_description' => $desc,
					));

				$query->channelAddPerm($spacer['data']['cid'], array(NEEDED_JOIN_POWER => $spacer_info['spacer']['join_needed'], NEEDED_SUBSCRIBE_POWER => $spacer_info['spacer']['subscribe_needed']));	
				usleep(self::$cfg['create_interval']);
				
				if($spacer['success'] != 1)
				{
					$logs_manager::write_info(" [".self::$name."] - ".$language['function']['get_vip_channel']['error_main']);
					$query->clientPoke($client['clid'], $language['function']['get_vip_channel']['error']);
					return;
				}
				
				if(isset($spacer_info['online_group_spacer']) && !$online_group_created)
				{
					$online_group_created = true;
					$online_from['data']['cid'] = $spacer['data']['cid'];
				}
				else if(isset($spacer_info['get_group_spacer']) && !$get_group_created)
				{
					$get_group_created = true;
					$get_group['data']['cid'] = $spacer['data']['cid'];
				}
				
				if(isset($spacer_info['online_group_subchannel']) && !$online_group_created)
				{
					$online_from = $query->channelCreate(array
					(
						'channel_name' => "Online",
						'channel_flag_semi_permanent' => 0,
						'channel_flag_permanent' => 1,
						'channel_flag_maxclients_unlimited' => 0,
						'channel_flag_maxfamilyclients_unlimited' => 1,
						'channel_flag_maxfamilyclients_inherited' => 0,
						'channel_maxclients' => 0,
						'cpid' => $spacer['data']['cid'],
					));
					
					$online_group_created = true;
					$spacer_info['subchannels']--;
				}
				if(isset($spacer_info['get_group_subchannel']) && !$get_group_created)
				{
					$get_group = $query->channelCreate(array
					(
						'channel_name' => "Nadaj grupe",
						'channel_flag_semi_permanent' => 0,
						'channel_flag_permanent' => 1,
						'channel_flag_maxclients_unlimited' => 1,
						'channel_flag_maxfamilyclients_unlimited' => 1,
						'channel_flag_maxfamilyclients_inherited' => 0,
						'cpid' => $spacer['data']['cid'],
					));
					
					$get_group_created = true;
					$spacer_info['subchannels']--;
				}
				
				for($i=1; $i<=$spacer_info['subchannels']['count']; $i++)
				{
					if($spacer_info['subchannels']['subchannels_red'])
						$subchannel = $query->channelCreate(array
						(
							'channel_name' => str_replace('[NUM]', $i, $spacer_info['subchannels']['name']),
							'channel_flag_semi_permanent' => 0,
							'channel_flag_permanent' => 1,
							'channel_flag_maxclients_unlimited' => 0,
							'channel_flag_maxfamilyclients_unlimited' => 1,
							'channel_flag_maxfamilyclients_inherited' => 0,
							'channel_maxclients' => 0,
							'cpid' => $spacer['data']['cid'],
						));
					else
						$subchannel = $query->channelCreate(array
						(
							'channel_name' => str_replace('[NUM]', $i, $spacer_info['subchannels']['name']),
							'channel_flag_semi_permanent' => 0,
							'channel_flag_permanent' => 1,
							'channel_flag_maxclients_unlimited' => 1,
							'channel_flag_maxfamilyclients_unlimited' => 1,
							'channel_flag_maxfamilyclients_inherited' => 0,
							'cpid' => $spacer['data']['cid'],
						));
						
					$query->channelAddPerm($subchannel['data']['cid'], array(NEEDED_JOIN_POWER => $spacer_info['subchannels']['join_needed'], NEEDED_SUBSCRIBE_POWER => $spacer_info['subchannels']['subscribe_needed']));	
					usleep(self::$cfg['create_interval']);
				}
				
				$query->setClientChannelGroup($info['channel_group_id'], $spacer['data']['cid'], $client['client_database_id']);
				$spacers .= $spacer['data']['cid'].",";
				$last_channel = $spacer['data']['cid'];
				
				$spacer_number++;
			}
 
			if($info['spacer_between']['enabled'])
			{
				$spacer_separator = $query->channelCreate(array
				(
					'channel_name' => str_replace('[NUM]', $number, $info['spacer_between']['spacer_name']),
					'channel_flag_semi_permanent' => 0,
					'channel_flag_permanent' => 1,
					'channel_flag_maxclients_unlimited' => 0,
					'channel_flag_maxfamilyclients_unlimited' => 0,
					'channel_flag_maxfamilyclients_inherited' => 0,
					'channel_order' => $last_channel,
					'channel_maxclients' => 0,
					'channel_maxfamilyclients' => 0,
				));
				$query->channelAddPerm($spacer_separator['data']['cid'], array(NEEDED_MODIFY_POWER => $info['spacer_between']['modify_needed'], NEEDED_JOIN_POWER => $info['spacer_between']['join_needed']));
				usleep(self::$cfg['create_interval']);
			}
			else
				$spacer_separator['data']['cid'] = 0;
			
			if($spacer_separator['success'] != 1)
			{		
				$logs_manager::write_info(" [".self::$name."] - ".$language['function']['get_vip_channel']['error_spacer']);
				$query->clientPoke($client['clid'], $language['function']['get_vip_channel']['error']);
				return;
			}
		 
			$query->clientMove($client['clid'], $spacer['data']['cid']);

			foreach($query->getElement('data', $query->serverGroupList()) as $group)
				if($group['name'] == $type.$number)
				{
					$query->serverGroupDelete($group['sgid']);
					break;
				}

			$vip_group = $query->serverGroupCopy($info['server_group_copy'], 0, $type.$number, 1);
			$vip_group = $vip_group['data']['sgid'];
			
			$query->serverGroupAddClient($vip_group, $client['client_database_id']);

			if(!in_array($get_group['data']['cid'], $cfg['get_server_group']['if_client_on_channel']))
				array_push($cfg['get_server_group']['if_client_on_channel'], $get_group['data']['cid']); 

			if(!isset($online_from['data']['cid'])) $online_from['data']['cid'] = 0;
			if(!isset($get_group['data']['cid'])) $get_group['data']['cid'] = 0;
			
			if(!$edit_db)
			{
				$query_sql->exec("INSERT INTO `vip_channels` 
				(`type_id`, `channel_num`,`channel_cid`,`spacer_cid`,`online_from`,`get_group`,`owner_dbid`,`group_id`,`created`) VALUES 
				('$type', $number,'".$spacers."',".$spacer_separator['data']['cid'].",".$online_from['data']['cid'].",".$get_group['data']['cid'].",".$client['client_database_id'].",".$vip_group.",".time().")");
			
				if($cfg['move_groups']['enabled'] && $cfg['move_groups']['vip_channels_from_AutoSpeak']['enabled'])
					move_groups::$from_vip_channels[] = array('is_on_channel' => $cfg['move_groups']['vip_channels_from_AutoSpeak']['is_on_channel'], 'move_to_channel' => explode(',', $spacers)[0], 'groups' => array($vip_group), 'ignored_groups' => $cfg['move_groups']['vip_channels_from_AutoSpeak']['ignored_groups']);	
			}
			else
				$query_sql->exec("UPDATE `vip_channels` SET `channel_cid`='".$spacers."',`spacer_cid`=".$spacer_separator['data']['cid'].",`online_from`=".$online_from['data']['cid'].",`get_group`=".$get_group['data']['cid'].",`owner_dbid`=".$client['client_database_id'].",`group_id`=".$vip_group.",`created`=".time()." WHERE `id`=".$channel['id']."");
			
			$query->clientPoke($client['clid'], str_replace(array('[TYPE]', '[NUM]'), array($type, $number), $language['function']['get_vip_channel']['message']));
			$AutoSpeak::set_action('get_vip_channel', array('client' => $client, 'type' => $type, 'number' => $number));
		}
	}
}
?>