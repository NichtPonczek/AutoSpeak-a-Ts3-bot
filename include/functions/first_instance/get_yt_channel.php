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

class get_yt_channel
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
		
		$result = $query_sql->query("SELECT * FROM `yt_channels` ORDER BY `id` ASC");
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
						
					$main_channel_info = $query->getElement('data', $query->channelInfo($channel['main_info']));
						
					if(class_exists('twitch_yt') && $main_channel_info['channel_topic'] != "")
						twitch_yt::$disabled_groups[] = $main_channel_info['channel_topic'];
						
					$query_sql->exec("DELETE FROM `yt_channels` WHERE id=".$channel['id']);	
					
					foreach($result as $res)
					{
						if($res['id'] > $channel['id'])
						{
							$client = $query->getElement('data', $query->clientDbInfo($res['owner_dbid']));
						
							$desc = "[center][size=15][b]".str_replace('[TYPE]', 'YouTube', $language['function']['get_vip_channel']['top_desc']).($res['channel_num']-1)."[/b][/size][/center]\n";
							$desc .= "[left] ● [size=11][b]".$lang['owner']."[URL=client://2/".$client['client_unique_identifier']."]".$client['client_nickname']."[/url][/b][/size][/left][left] ● [size=11][b]".$lang['created']."".date('d-m-Y G:i', $res['created'])."\n[/b][/size][/left]\n".$language['function']['down_desc'];
								
							$query_sql->exec("UPDATE `yt_channels` SET `channel_num`=".($res['channel_num']-1)." WHERE id=".$res['id']);
							$query->channelEdit($res['channel_cid'], array('channel_name' => str_replace('[NUM]', $res['channel_num']-1, self::$cfg['main_channel']), 'channel_description' => $desc));
							$query->channelEdit($res['spacer_cid'], array('channel_name' => str_replace('[NUM]', $res['channel_num']-1, self::$cfg['spacer_between']['spacer_name'])));
						}	
					}
				}
			}
		}
	}
	
	static public function main($client)
	{
		global $query, $language, $clients, $AutoSpeak, $query_sql, $logs_manager;

		if(!isset($query_sql))
		{
			$query->clientPoke($client['clid'], $language['function']['get_vip_channel']['error_db']);
			return;
		}
			
		$result = $query_sql->query("SELECT * FROM `yt_channels` WHERE `owner_dbid`=".$client['client_database_id']."");
		if($result->rowCount() != 0)
		{			
			$query->clientPoke($client['clid'], str_replace('[TYPE]', "YouTube", $language['function']['get_vip_channel']['has_channel']));
			return;
		}

		$result = $query_sql->query("SELECT * FROM `yt_channels` ORDER BY `id` ASC");
		$no_channel = false;
		$edit_db = false;
		$lang = $language['function']['get_private_channel'];
		
		if($result->rowCount() == 0)
		{
			$last_channel = self::$cfg['after_channel'];
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

				if(self::$cfg['spacer_between']['enabled'])
				{
					$spacer_info = $query->getElement('data', $query->channelInfo($channel['spacer_cid']));

					if($spacer_info == NULL)
					{
						$spacer = $query->channelCreate(array
						(
							'channel_name' => str_replace('[NUM]', $channel['channel_num'], self::$cfg['spacer_between']['spacer_name']),
							'channel_flag_semi_permanent' => 0,
							'channel_flag_permanent' => 1,
							'channel_flag_maxclients_unlimited' => 0,
							'channel_flag_maxfamilyclients_unlimited' => 0,
							'channel_flag_maxfamilyclients_inherited' => 0,
							'channel_order' => $channel['channel_cid'],
							'channel_maxclients' => 0,
							'channel_maxfamilyclients' => 0,
						));
						$query->channelAddPerm($spacer['data']['cid'], array(NEEDED_MODIFY_POWER => self::$cfg['spacer_between']['modify_needed'], NEEDED_JOIN_POWER => self::$cfg['spacer_between']['join_needed']));

						$query_sql->query("UPDATE `yt_channels` SET `spacer_cid`=".$spacer['data']['cid']." WHERE `id` = ".$channel['id']);
						$channel['spacer_cid'] = $spacer['data']['cid'];
						usleep(500000);
					}
				}
	
				$last_channel_db = $channel;
			}


			if(!$no_channel)
			{
				if(self::$cfg['spacer_between']['enabled'])
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
					$last_channel = self::$cfg['after_channel'];
					$number = 1;
				}
		
				$edit_db = true;
			}
		}

		$desc = "[center][size=15][b]".str_replace('[TYPE]', "YouTube", $language['function']['get_vip_channel']['top_desc']).$number."[/b][/size][/center]\n";
		$desc .= "[left] ? [size=11][b]".$lang['owner']."[URL=client://2/".$client['client_unique_identifier']."]".$client['client_nickname']."[/url][/b][/size][/left][left] ? [size=11][b]".$lang['created']."".date('d-m-Y G:i')."\n[/b][/size][/left]\n".$language['function']['down_desc'];

		$name_channel = $query->channelCreate(array
		(
			'channel_name' => str_replace('[NUM]', $number, self::$cfg['main_channel']),
			'channel_topic' => date('d-m-Y G:i'),
			'channel_flag_semi_permanent' => 0,
			'channel_flag_permanent' => 1,
			'channel_flag_maxclients_unlimited' => 0,
			'channel_flag_maxfamilyclients_unlimited' => 0,
			'channel_flag_maxfamilyclients_inherited' => 0,
			'channel_order' => $last_channel,
			'channel_description' => $desc,
			'channel_maxclients' => 0,
		));
		usleep(1000000);

		if($name_channel['success'] != 1)
		{
			$logs_manager::write_info(" [".self::$name."] - ".$language['function']['get_vip_channel']['error_main']);
			$query->clientPoke($client['clid'], $language['function']['get_vip_channel']['error']);
			return;
		}
		
		if(self::$cfg['spacer_between']['enabled'])
		{
			$spacer = $query->channelCreate(array
			(
				'channel_name' => str_replace('[NUM]', $number, self::$cfg['spacer_between']['spacer_name']),
				'channel_flag_semi_permanent' => 0,
				'channel_flag_permanent' => 1,
				'channel_flag_maxclients_unlimited' => 0,
				'channel_flag_maxfamilyclients_unlimited' => 0,
				'channel_flag_maxfamilyclients_inherited' => 0,
				'channel_order' => $name_channel['data']['cid'],
				'channel_maxclients' => 0,
			));
			$query->channelAddPerm($spacer['data']['cid'], array(NEEDED_MODIFY_POWER => self::$cfg['spacer_between']['modify_needed'], NEEDED_JOIN_POWER => self::$cfg['spacer_between']['join_needed']));
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

		if(self::$cfg['videos_count'] || self::$cfg['views_count'])
		{
			$info_channels = $query->channelCreate(array
			(
				'channel_name' => "Informacje",
				'channel_flag_semi_permanent' => 0,
				'channel_flag_permanent' => 1,
				'channel_flag_maxclients_unlimited' => 0,
				'channel_flag_maxfamilyclients_unlimited' => 1,
				'channel_flag_maxfamilyclients_inherited' => 0,
				'channel_maxclients' => 0,
				'cpid' => $name_channel['data']['cid'],
			));
			usleep(500000);
			

			if(self::$cfg['videos_count'])
				$videos_count = $query->channelCreate(array
				(
					'channel_name' => "Liczba filmów",
					'channel_flag_semi_permanent' => 0,
					'channel_flag_permanent' => 1,
					'channel_flag_maxclients_unlimited' => 0,
					'channel_flag_maxfamilyclients_unlimited' => 1,
					'channel_flag_maxfamilyclients_inherited' => 0,
					'channel_maxclients' => 0,
					'cpid' => $info_channels['data']['cid'],
				));
			else
				$videos_count['data']['cid'] = 0;

		
			if(self::$cfg['views_count'])
				$views_count = $query->channelCreate(array
				(
					'channel_name' => "Liczba wyświetleń",
					'channel_flag_semi_permanent' => 0,
					'channel_flag_permanent' => 1,
					'channel_flag_maxclients_unlimited' => 0,
					'channel_flag_maxfamilyclients_unlimited' => 1,
					'channel_flag_maxfamilyclients_inherited' => 0,
					'channel_maxclients' => 0,
					'cpid' => $info_channels['data']['cid'],
				));
			else
				$views_count['data']['cid'] = 0;

			$query->setClientChannelGroup(self::$cfg['channel_group_id'], $info_channels['data']['cid'], $client['client_database_id']);
			usleep(1000000);
		}
		else
		{
			$videos_count['data']['cid'] = 0;
			$views_count['data']['cid'] = 0;
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
		
		for($i=1; $i<=self::$cfg['subchannels']; $i++)
		{
			if(self::$cfg['subchannels_red'])
				$subchannels = $query->channelCreate(array
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
				$subchannels = $query->channelCreate(array
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
		 
		$query->setClientChannelGroup(self::$cfg['channel_group_id'], $main['data']['cid'], $client['client_database_id']);
		$query->clientMove($client['clid'], $main['data']['cid']);

		if(!$edit_db)
			$query_sql->exec("INSERT INTO `yt_channels` 
				(`channel_num`,`channel_cid`,`spacer_cid`,`main_info`,`videos_count`,`views_count`,`owner_dbid`,`created`) VALUES 
				($number,".$name_channel['data']['cid'].",".$spacer['data']['cid'].",".$info_channels['data']['cid'].",".$videos_count['data']['cid'].",".$views_count['data']['cid'].",".$client['client_database_id'].",".time().")");
		else
			$query_sql->exec("UPDATE `yt_channels` SET `channel_cid`=".$name_channel['data']['cid'].",`spacer_cid`=".$spacer['data']['cid'].",`main_info`=".$info_channels['data']['cid'].",`videos_count`=".$videos_count['data']['cid'].",`views_count`=".$views_count['data']['cid'].",`owner_dbid`=".$client['client_database_id'].",`created`=".time()." WHERE `id`=".$channel['id']."");

		$query->clientPoke($client['clid'], str_replace(array('[TYPE]', '[NUM]'), array("YouTube", $number), $language['function']['get_vip_channel']['message']));
		$AutoSpeak::set_action(self::$name, array('client' => $client, 'number' => $number));
	}
}
?>