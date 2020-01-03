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

class admins_meeting
{
	private static $name;
	private static $cfg;
	
	static public function construct($plugin_name)
	{
		global $cfg;
		self::$cfg = $cfg[$plugin_name];
		self::$name = $plugin_name;
	}

	static private function difference($meeting_date, &$flag)
	{
		$date_time = explode(" ", $meeting_date);
		$meeting_date = explode(".", $date_time[0]);
		$meeting_time = explode(":", $date_time[1]);

		$current_date[2] = date('Y');
		$current_date[1] = date('m');
		$current_date[0] = date('d');

		if($current_date['2']<$meeting_date['2'])	
			$flag = 1;
		elseif($current_date['2'] == $meeting_date['2'])
		{
			if($current_date['1']<$meeting_date['1'])
				$flag = 1;
			elseif($current_date['1'] == $meeting_date['1'])
			{
				if($current_date['0']<$meeting_date['0'])
					$flag = 1;
				elseif($current_date['0'] == $meeting_date['0'])
				{
					$meeting_time = mktime($meeting_time[0], $meeting_time[1]);
					$current_time = mktime(date('G'), date('i'));

					if($current_time<$meeting_time)
					{
						$difference = $current_time-$meeting_time;
						$flag = 2;

						if($difference<0)
							return -$difference;
						else
							return $difference;

					}
					elseif($current_time == $meeting_time)
					{
						$flag = 5;
						return 0;
					}
					else
						$flag = 3;
				}
				else
					$flag = 3;
			}
			else
				$flag = 3;
		}
		else
			$flag = 3;
	}

	static public function before_clients()
	{
		global $query, $language, $cache_poked, $cache_moved, $logs_manager, $clients;
		$time_good = 0;
		$cfg = self::$cfg['info'];

		$channel = $query->getElement('data', $query->channelInfo($cfg['channel_id']));
		$meeting_date = substr($channel['channel_name'], -16);
		
		$different = self::difference($meeting_date, $time_good);		

		if($time_good == 3)
		{
			if($cache_poked == 1)
				$cache_poked = 0;
			if($cache_moved == 1)
				$cache_moved = 0;

		}
		elseif($time_good == 2 && $different == $cfg['time_to_meeting'] && $cache_poked==0)
		{
			foreach($clients as $client)
			{
				foreach(explode(',', $client['client_servergroups']) as $client_group)
				{
					if(in_array($client_group, $cfg['admins_server_groups']) && $client['client_database_id'] != 1)
						$query->clientPoke($client['clid'], $client['client_nickname'].$language['function']['admins_meeting']['information']);
				}
			}
			$cache_poked = 1;
		}
		elseif($time_good == 5 && $cfg['move_admins'] && $cache_moved==0)
		{
			$moved_admins = 0;
			foreach($clients as $client)
			{
				$client_groups = explode(',', $client['client_servergroups']);
				foreach($client_groups as $client_group)
				{
					if(in_array($client_group, $cfg['admins_server_groups']) && $client['client_database_id'] != 1)
					{
						$query->clientMove($client['clid'], $cfg['channel_id']);
						$moved_admins++;
					}
				}
			}
			$logs_manager::write_info(" [".self::$name."] ".$moved_admins.$language['function']['admins_meetin']['moved']);
			$cache_moved = 1;
		}
		
		elseif(($time_good == 1 || $time_good == 2) && $different != $cfg['time_to_meeting'])
		{
			if($cache_poked)
				$cache_poked = 0;
			if($cache_moved)
				$cache_moved = 0;

		}
	}
}
?>