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

class check_public_zone
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
		global $query, $language, $logs_manager;

		$channels = $query->getElement('data', $query->channelList());

		foreach(self::$cfg['info'] as $info)
		{
			$all=0;
			$taken=0;
			$found = false;
			$num=0;
			$max_clients = $info['max_users'];

			foreach($channels as $ch)
			{
				if($ch['cid'] == $info['channels_zone'])
					$found = true;
				
				if($ch['pid'] == $info['channels_zone'])
				{
					$num++;
					
					if($ch['total_clients'] > 0)
						$taken++;

					$all++;
					$last = $ch;
					
					
					if($ch['channel_name'] != str_replace('[NUM]', $num, $info['channel_name']))
						$query->channelEdit($ch['cid'], array('channel_name' => str_replace('[NUM]', $num, $info['channel_name'])));
				}
			}

			if(!$found)
			{
				$logs_manager::set_error("#Ch1:".$info['channels_zone'], self::$name);
				continue;
			}
			
			if($all-$taken < $info['mininum_channels'] && $all < $info['maximum_channels'])
			{
				for($i=1; $i<=$info['mininum_channels']-($all-$taken) && $all+$i <= $info['maximum_channels']; $i++)
				{
					if($max_clients != 0)
						$result = $query->channelCreate(array
						(
							'channel_name' => str_replace('[NUM]', $all+$i, $info['channel_name']),
							'channel_maxclients' => $max_clients,
							'channel_maxfamilyclients' => $max_clients,
							'channel_flag_semi_permanent' => 0,
							'channel_flag_permanent' => 1,
							'channel_flag_maxclients_unlimited' => 0,
							'channel_codec_quality' => 10,
							'channel_flag_maxfamilyclients_unlimited' => 0,
							'channel_flag_maxfamilyclients_inherited' => 0,
							'cpid' => $info['channels_zone'],
							'channel_description' => $info['desc'],
						));
					else
						$result = $query->channelCreate(array
						(
							'channel_name' => str_replace('[NUM]', $all+$i, $info['channel_name']),
							'channel_flag_semi_permanent' => 0,
							'channel_flag_permanent' => 1,
							'channel_flag_maxclients_unlimited' => 1,
							'channel_codec_quality' => 10,
							'channel_flag_maxfamilyclients_unlimited' => 1,
							'cpid' => $info['channels_zone'],
							'channel_description' => $info['desc'],
						));
					
					$query->channelAddPerm($result['data']['cid'], array(ICON_ID => $info['icon_id'], '124' => $info['modify_power']));
				}
			}
			elseif($all-$taken > $info['mininum_channels'])
				if($last['total_clients'] == 0)
					$query->channelDelete($last['cid']);

		}

	}
}
?>
