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

class channels_guard
{
	private static $name;
	private static $cfg;
	
	static public function construct($plugin_name)
	{
		global $cfg;
		self::$cfg = $cfg[$plugin_name];
		self::$name = $plugin_name;
	}
	
	static private function find_previous_channel($cid, &$num)
	{
		global $query;
		$chan = 0;
		$num = 0;
		
		foreach($channels = $query->getElement('data', $query->channelList("-topic -limits -flags")) as $channel)
		{
			if($channel['pid'] == self::$cfg['channels_zone'])
			{	
				if($channel['cid'] == $cid)
					return $chan;

				$chan = $channel['cid'];
				$num++;
			}
		}
		return 0;
	}

	static private function creat_free_channel($number, $order)
	{
		global $query, $language;
		$lang = $language['function']['channels_guard'];
	
		$desc = "[center][size=15][b]".$lang['private_channel'].$number.$lang['empty']."[/b][/size][/center]\n\n[size=11]".$lang['how_to_get']."[/size]\n\n\n".$language['function']['down_desc'];
		

		if($order == 'none')
		{
			$result = $query->channelCreate(array
			(
				'channel_name' => $number.". ".self::$cfg['free_channel_name'],
				'channel_topic' => self::$cfg['empty_channel_topic'],
				'cpid' => self::$cfg['channels_zone'],
				'channel_flag_semi_permanent' => 0,
				'channel_flag_permanent' => 1,
				'channel_flag_maxclients_unlimited' => 0,
				'channel_flag_maxfamilyclients_unlimited' => 0,
				'channel_flag_maxfamilyclients_inherited' => 0,
				'channel_maxclients' => 0,
				'channel_maxfamilyclients' => 0,
				'channel_description' => $desc,
			));
			$query->channelAddPerm($result['data']['cid'], array(ICON_ID => self::$cfg['make_empty_channels']['icon_id']));
		}
		else
		{
			$result = $query->channelCreate(array
			(
				'channel_name' => $number.". ".self::$cfg['free_channel_name'],
				'channel_topic' => self::$cfg['empty_channel_topic'],
				'cpid' => self::$cfg['channels_zone'],
				'channel_flag_semi_permanent' => 0,
				'channel_flag_permanent' => 1,
				'channel_flag_maxclients_unlimited' => 0,
				'channel_flag_maxfamilyclients_unlimited' => 0,
				'channel_flag_maxfamilyclients_inherited' => 0,
				'channel_maxclients' => 0,
				'channel_maxfamilyclients' => 0,
				'channel_order' => $order,
				'channel_description' => $desc,
			));
			$query->channelAddPerm($result['data']['cid'], array(ICON_ID => self::$cfg['make_empty_channels']['icon_id']));
		}
	}

	static private function check_channels()
	{
		global $query, $clients, $language, $logs_manager, $AutoSpeak;
		
		$lang = $language['function']['channels_guard'];
		$config = self::$cfg['check_date'];
			
		$taken = 0;
		$free = 0;
		$channels_to_check = array();	
		$cids = array();
		$found = false;
			
		if($config['new_date_if_owner'])
		{
			foreach($channels = $query->getElement('data', $query->channelList("-topic")) as $channel)
				if($channel['pid'] == self::$cfg['channels_zone'])
				{
					if($channel['channel_topic'] != self::$cfg['empty_channel_topic'] && $channel['channel_topic'] != date('d-m-Y'))
					{
						array_push($channels_to_check, $channel);
						array_push($cids, $channel['cid']);
					}
				}
				elseif(in_array($channel['pid'], $cids))
					array_push($channels_to_check, $channel);
		}

		foreach($channels = $query->getElement('data', $query->channelList("-topic -limits -flags")) as $channel)
		{
			if($channel['cid'] == self::$cfg['channels_zone'])
				$found = true;
			elseif($channel['pid'] == self::$cfg['channels_zone'])
			{	
				if($channel['channel_topic'] != self::$cfg['empty_channel_topic'])
				{
					$taken++;
					
					if(self::$cfg['check_date']['enabled'])
					{
						if(!preg_match("/^[0-9]{2}\-[0-9]{2}\-[0-9]{4}$/", $channel['channel_topic']))
							$query->channelEdit($channel['cid'], array('channel_topic' => date('d-m-Y')));

						elseif($channel['channel_topic'] != date('d-m-Y'))
						{
							if($config['new_date_if_owner'])
							{
								foreach($channels_to_check as $channel_child)
								{
									if(($channel_child['pid'] == $channel['cid'] || $channel_child['cid'] == $channel['cid']) && $channel_child['total_clients'] > 0)
									{
										$find = false;
										$channel_admins = $query->getElement('data', $query->channelGroupClientList($channel['cid']));
									
										if($channel_admins != NULL)
										{
											$clients_on_channel = $query->getElement('data', $query->channelClientList($channel_child['cid']));

											foreach($channel_admins as $cli)
											{
												foreach($clients_on_channel as $client_on_channel)
													if($client_on_channel['client_database_id'] == $cli['cldbid'] && in_array($cli['cgid'], self::$cfg['check_date']['channel_groups']))
													{
														$query->channelEdit($channel['cid'], array('channel_topic' => date('d-m-Y')));
														$AutoSpeak::set_action(self::$name, array('number' => $taken));
														$find = true;
														break;
													}
												
												if($find)
													break;

											}
										}
									}	
								}
							}
							
							$channel_date = explode("-", $channel['channel_topic']);
							$channel_time = mktime(0,0,0,$channel_date[1],$channel_date[0],$channel_date[2]);
							$time_delete = mktime(0,0,0,$channel_date[1],$channel_date[0] + self::$cfg['check_date']['time_interval_delete'],$channel_date[2]);
							$time_change_name = mktime(0,0,0,$channel_date[1],$channel_date[0] + self::$cfg['check_date']['time_interval_warning'],$channel_date[2]);

							if(time() < $channel_time)
								$query->channelEdit($channel['cid'], array('channel_topic' => date('d-m-Y')));

							if(time() >= $time_delete)
							{
								$number = 1;
								$previous = self::find_previous_channel($channel['cid'], $number);
								$query->channelDelete($channel['cid']);

								if($previous == 0)
									self::creat_free_channel($number, '0');
								else
									self::creat_free_channel($number, $previous);
							}
							elseif(strpos($channel['channel_name'],$config['warning_text']) === False && time()>=$time_change_name)
									$query->channelEdit($channel['cid'], array('channel_name' => $channel['channel_name']." ".$config['warning_text']));

							elseif(strpos($channel['channel_name'],$config['warning_text']) !== False && time()<$time_change_name)
									$query->channelEdit($channel['cid'], array('channel_name' => substr($channel['channel_name'], 0, strlen($channel['channel_name'])-strlen($config['warning_text']))));
						}
						elseif(strpos($channel['channel_name'],$config['warning_text']) !== False)
							$query->channelEdit($channel['cid'], array('channel_name' => substr($channel['channel_name'], 0, strlen($channel['channel_name'])-strlen($config['warning_text']))));
					}
					if(self::$cfg['check_channel_name']['enabled'] && self::has_bad_nick(strtolower($channel['channel_name'])))
					{
						self::find_previous_channel($channel['cid'], $number);
						$number++;
						$query->channelEdit($channel['cid'], array('channel_name' => $number.". ".$lang['bad_name']));	
					}
				}
				else	
					$free++;
			}
		}
		
		if(!$found)
		{
			$logs_manager::set_error("#Ch1:".self::$cfg['channels_zone'], self::$name, true);
			return;
		}
		
		if(self::$cfg['make_empty_channels']['enabled'])
			self::make_empty_channels($free, $taken);
	}

	static private function check_channel_num()
	{
		global $query, $language;
		$lang = $language['function']['channels_guard'];
		
		$number = 1;
		foreach($channels = $query->getElement('data', $query->channelList("-topic -limits -flags")) as $channel)
		{
			if($channel['pid'] == self::$cfg['channels_zone'])
			{
				if(strpos($channel['channel_name'],$number.". ") === False)
				{
					$created = false;

					for($i=1; $i<=5; $i++)
					{
						$num = $number+$i;
				
						if(strpos($channel['channel_name'],$num.". ") !== False)
						{
							for($j=0; $j<$i; $j++)
							{
								$channel_nr = 1;
								$previous = self::find_previous_channel($channel['cid'], $channel_nr);

								$channel_nr++;

								if($previous == 0)
									self::creat_free_channel($channel_nr, '0');
								else
									self::creat_free_channel($channel_nr, $previous);
							}		

							$number += $i;
				
							$created = true;
							break;
						}
					}
		
					
					if(!$created)
					{	
						if($channel['channel_topic'] == self::$cfg['empty_channel_topic'])	
							$query->channelEdit($channel['cid'], array('channel_name' => $number.". ".self::$cfg['free_channel_name'], 'channel_description' => 
								"[center][size=15][b]".$language['function']['channels_guard']['private_channel'].$number.$language['function']['channels_guard']['empty']."[/b][/size][/center]\n\n[size=11]".$language['function']['channels_guard']['how_to_get']."[/size]\n\n\n".$language['function']['down_desc']
							));
						else
							$query->channelEdit($channel['cid'], array('channel_name' => $number.". ".$lang['wrong_name']));

					}
				}
				$number++;
			}
		}
	}

	static private function has_bad_nick($name)
	{
		$bad_names = explode(",", strtolower(fread(fopen(self::$cfg['check_channel_name']['file'], "r"), filesize(self::$cfg['check_channel_name']['file']))));
		
		foreach($bad_names as $bad_name)
		{
			if($bad_name != "" && $bad_name != "." && $bad_name != "!" && $bad_name != " " && strpos($name,$bad_name) !== False)
				return true;
		}

		return false;
	}


	static private function make_empty_channels($free, $taken)
	{
		global $query;

		$config = self::$cfg['make_empty_channels'];

		if($free<$config['minimum_free_channels'])
		{
			$count = $config['minimum_free_channels'] - $free;
			$num = $free+$taken+1;
			
			for($i=0; $i<$count; $i++)
			{
				self::creat_free_channel($num, 'none');
				$num++;
			}
		}
	}

	static public function before_clients()
	{
		global $query, $language;

		self::check_channels();

		if(self::$cfg['check_channel_num']['enabled'])
			self::check_channel_num();
	}
}
?>