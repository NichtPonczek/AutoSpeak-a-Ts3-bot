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

class get_vip_channel
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
					if($query->getElement('data', $query->channelInfo($channel['channel_cid'])) == NULL)
					{
						if($channel['spacer_cid'] != 0 && $query->getElement('data', $query->channelInfo($channel['spacer_cid'])) != NULL)
							$query->channelDelete($channel['spacer_cid']);
												
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
						
								$desc = "[center][size=15][b]".str_replace('[TYPE]', $type, $language['function']['get_vip_channel']['top_desc']).($res['channel_num']-1)."[/b][/size][/center]\n";
								$desc .= "[left] ● [size=11][b]".$lang['owner']."[URL=client://2/".$client['client_unique_identifier']."]".$client['client_nickname']."[/url][/b][/size][/left][left] ● [size=11][b]".$lang['created']."".date('d-m-Y G:i', $res['created'])."\n[/b][/size][/left]\n".$language['function']['down_desc'];
								
								$query_sql->exec("UPDATE `vip_channels` SET `channel_num`=".($res['channel_num']-1)." WHERE id=".$res['id']);
								$query->channelEdit($res['channel_cid'], array('channel_name' => str_replace('[NUM]', $res['channel_num']-1, $info['main_channel']), 'channel_description' => $desc));
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
			$empty = false;
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
				$result = $result->fetchAll(PDO::FETCH_ASSOC);
		
				foreach($result as $channel)
				{
					$channel_info = $query->getElement('data', $query->channelInfo($channel['channel_cid']));
				
					if($channel_info == NULL)
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

					if($channel_info['channel_topic'] == $info['empty_topic'])
					{
						$empty = true;
						break;
					}
	
					$last_channel_db = $channel;
				}


				if(!$empty && !$no_channel)
				{
					if($info['spacer_between']['enabled'])
						$last_channel = $channel['spacer_cid'];
					else
						$last_channel = $channel['channel_cid'];

					$number = $channel['channel_num'] + 1;
				}
				elseif($no_channel)
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
				else
				{
					$number = $channel['channel_num'];
					$edit_db = true;
				}
			}

			$desc = "[center][size=15][b]".str_replace('[TYPE]', $type, $language['function']['get_vip_channel']['top_desc']).$number."[/b][/size][/center]\n";
			$desc .= "[left] ● [size=11][b]".$lang['owner']."[URL=client://2/".$client['client_unique_identifier']."]".$client['client_nickname']."[/url][/b][/size][/left][left] ● [size=11][b]".$lang['created']."".date('d-m-Y G:i')."\n[/b][/size][/left]\n".$language['function']['down_desc'];
 
			if(!$empty)
			{
				$name_channel = $query->channelCreate(array
				(
					'channel_name' => str_replace('[NUM]', $number, $info['main_channel']),
					'channel_topic' => date('d-m-Y G:i'),
					'channel_flag_semi_permanent' => 0,
					'channel_flag_permanent' => 1,
					'channel_flag_maxclients_unlimited' => 1,
					'channel_flag_maxfamilyclients_unlimited' => 1,
					'channel_flag_maxfamilyclients_inherited' => 0,
					'channel_order' => $last_channel,
					'channel_description' => $desc,
				));
				$query->channelAddPerm($name_channel['data']['cid'], array(NEEDED_JOIN_POWER => $info['join_needed']));
				usleep(1000000);

				if($name_channel['success'] != 1)
				{
					$logs_manager::write_info(" [".self::$name."] - ".$language['function']['get_vip_channel']['error_main']);
					$query->clientPoke($client['clid'], $language['function']['get_vip_channel']['error']);
					return;
				}
				
				if($info['spacer_between']['enabled'])
				{
					$spacer = $query->channelCreate(array
					(
						'channel_name' => str_replace('[NUM]', $number, $info['spacer_between']['spacer_name']),
						'channel_flag_semi_permanent' => 0,
						'channel_flag_permanent' => 1,
						'channel_flag_maxclients_unlimited' => 0,
						'channel_flag_maxfamilyclients_unlimited' => 0,
						'channel_flag_maxfamilyclients_inherited' => 0,
						'channel_order' => $name_channel['data']['cid'],
						'channel_maxclients' => 0,
						'channel_maxfamilyclients' => 0,
					));
					$query->channelAddPerm($spacer['data']['cid'], array(NEEDED_MODIFY_POWER => $info['spacer_between']['modify_needed'], NEEDED_JOIN_POWER => $info['spacer_between']['join_needed']));
					usleep(1000000);
				}
				else
					$spacer['data']['cid'] = 0;
				
				if($spacer['success'] != 1)
				{		
					$logs_manager::write_info(" [".self::$name."] - ".$language['function']['get_vip_channel']['error_spacer']);
					$query->clientPoke($client['clid'], $language['function']['get_vip_channel']['error']);
					return;
				}
			}
			else
			{
				$spacer['data']['cid'] = $channel['spacer_cid'];
				$name_channel['data']['cid'] = $channel['channel_cid'];
		
				$query->channelEdit($channel['channel_cid'], array('channel_topic' => date('d-m-Y G:i'), 'channel_description' => $desc));
			}


			if($info['online_from_server_group'] || $info['get_server_group'])
			{
				$info_channels = $query->channelCreate(array
				(
					'channel_name' => "Grupa",
					'channel_flag_semi_permanent' => 0,
					'channel_flag_permanent' => 1,
					'channel_flag_maxclients_unlimited' => 0,
					'channel_flag_maxfamilyclients_unlimited' => 1,
					'channel_flag_maxfamilyclients_inherited' => 0,
					'channel_maxclients' => 0,
					'cpid' => $name_channel['data']['cid'],
				));
				usleep(500000);

				if($info['online_from_server_group'])
					$online_from = $query->channelCreate(array
					(
						'channel_name' => "Online z grupy",
						'channel_flag_semi_permanent' => 0,
						'channel_flag_permanent' => 1,
						'channel_flag_maxclients_unlimited' => 0,
						'channel_flag_maxfamilyclients_unlimited' => 1,
						'channel_flag_maxfamilyclients_inherited' => 0,
						'channel_maxclients' => 0,
						'cpid' => $info_channels['data']['cid'],
					));
				else
					$online_from['data']['cid'] = 0;

		
				if($info['get_server_group'])
					$get_group = $query->channelCreate(array
					(
						'channel_name' => "Nadaj/zdejmij rangę",
						'channel_flag_semi_permanent' => 0,
						'channel_flag_permanent' => 1,
						'channel_flag_maxclients_unlimited' => 0,
						'channel_flag_maxfamilyclients_unlimited' => 1,
						'channel_flag_maxfamilyclients_inherited' => 0,
						'channel_maxclients' => 0,
						'cpid' => $info_channels['data']['cid'],
					));
				else
					$get_group['data']['cid'] = 0;

				$query->setClientChannelGroup($info['channel_group_id'], $info_channels['data']['cid'], $client['client_database_id']);
				usleep(1000000);
			}
			else
			{
				$online_from['data']['cid'] = 0;
				$get_group['data']['cid'] = 0;
			}

			$main = $query->channelCreate(array
			(
				'channel_name' => "Kanał główny",
				'channel_flag_semi_permanent' => 0,
				'channel_flag_permanent' => 1,
				'channel_flag_maxclients_unlimited' => 0,
				'channel_flag_maxfamilyclients_unlimited' => 1,
				'channel_flag_maxfamilyclients_inherited' => 0,
				'channel_maxclients' => 0,
				'cpid' => $name_channel['data']['cid'],
			));
			usleep(1000000);


			for($i=1; $i<=$info['subchannels']; $i++)
			{
				if($info['subchannels_red'])
					$info_channels = $query->channelCreate(array
					(
						'channel_name' => str_replace('[NUM]', $i, "Podkanał #[NUM]"),
						'channel_flag_semi_permanent' => 0,
						'channel_flag_permanent' => 1,
						'channel_flag_maxclients_unlimited' => 0,
						'channel_flag_maxfamilyclients_unlimited' => 1,
						'channel_flag_maxfamilyclients_inherited' => 0,
						'channel_maxclients' => 0,
						'cpid' => $main['data']['cid'],
					));
				else
					$info_channels = $query->channelCreate(array
					(
						'channel_name' => str_replace('[NUM]', $i, "Podkanał #[NUM]"),
						'channel_flag_semi_permanent' => 0,
						'channel_flag_permanent' => 1,
						'channel_flag_maxclients_unlimited' => 1,
						'channel_flag_maxfamilyclients_unlimited' => 1,
						'channel_flag_maxfamilyclients_inherited' => 0,
						'cpid' => $main['data']['cid'],
					));

				usleep(1000000);
			}
		 
			$query->setClientChannelGroup($info['channel_group_id'], $main['data']['cid'], $client['client_database_id']);
			$query->clientMove($client['clid'], $main['data']['cid']);

			foreach($query->getElement('data', $query->serverGroupList()) as $group)
				if($group['name'] == $type.$number)
				{
					$query->serverGroupDelete($group['sgid']);
					break;
				}

			$vip_group = $query->serverGroupCopy($info['server_group_copy'], 0, $type.$number, 1);
			$vip_group = $vip_group['data']['sgid'];
			
			$query->serverGroupAddClient($vip_group, $client['client_database_id']);

			if(!in_array($get_group['data']['cid'], $cfg['get_server_group']['if_client_on_channel']) && $info['get_server_group'])
				array_push($cfg['get_server_group']['if_client_on_channel'], $get_group['data']['cid']);

			if(!$edit_db)
			{
				$query_sql->exec("INSERT INTO `vip_channels` 
				(`type_id`, `channel_num`,`channel_cid`,`spacer_cid`,`online_from`,`get_group`,`owner_dbid`,`group_id`,`created`) VALUES 
				('$type', $number,".$name_channel['data']['cid'].",".$spacer['data']['cid'].",".$online_from['data']['cid'].",".$get_group['data']['cid'].",".$client['client_database_id'].",".$vip_group.",".time().")");
			
				if($cfg['move_groups']['enabled'] && $cfg['move_groups']['vip_channels_from_AutoSpeak']['enabled'])
					move_groups::$from_vip_channels[] = array('is_on_channel' => $cfg['move_groups']['vip_channels_from_AutoSpeak']['is_on_channel'], 'move_to_channel' => $name_channel['data']['cid'], 'groups' => array($vip_group), 'ignored_groups' => $cfg['move_groups']['vip_channels_from_AutoSpeak']['ignored_groups']);	
			}
			else
				$query_sql->exec("UPDATE `vip_channels` SET `channel_cid`=".$name_channel['data']['cid'].",`spacer_cid`=".$spacer['data']['cid'].",`online_from`=".$online_from['data']['cid'].",`get_group`=".$get_group['data']['cid'].",`owner_dbid`=".$client['client_database_id'].",`group_id`=".$vip_group.",`created`=".time()." WHERE `id`=".$channel['id']."");

			$query->clientPoke($client['clid'], str_replace(array('[TYPE]', '[NUM]'), array($type, $number), $language['function']['get_vip_channel']['message']));
			$AutoSpeak::set_action(self::$name, array('client' => $client, 'type' => $type, 'number' => $number));
		}
	}
}
?>