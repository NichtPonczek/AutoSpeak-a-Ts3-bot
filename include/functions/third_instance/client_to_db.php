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

class client_to_db
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}	

	static public function check_in_database($client)
	{
		global $query, $query_sql, $event_info;

		$client_info = $query->getElement('data', $query->clientInfo($client['clid']));
		
		$cldbid = $client['client_database_id'];
		$connections = $client_info['client_totalconnections'];
		$clid = $client['clid'];
		$nick = htmlentities($client['client_nickname'], ENT_QUOTES, "UTF-8");
		$uid = $client['client_unique_identifier'];
		$server_groups = $client['client_servergroups'];
		$connected_time = $client_info['connection_connected_time'];
		$idle_time = $client_info['client_idle_time'];
		$connection_client_ip = $client_info['connection_client_ip']; //client ip
		$client_version = $client_info['client_version']; // client version
		$client_lastconnected = $client_info['client_lastconnected'];//client last seen (timestamp)
					
		$result = $query_sql->query("SELECT `client_dbid` FROM `clients` WHERE `client_dbid` = '$cldbid'");

		if($result->rowCount() == 0)
		{			
			$query_sql->exec("INSERT INTO `clients` 
			(`client_dbid`, `client_clid`, `client_nick`, `client_uid`, `server_groups`, `connections`, `connected_time`, `connected_time_record`, `idle_time_record`, `time_spent`, `idle_time_spent`, `week_start`, `week_start_time`, `last_nicks`, `connection_client_ip`, `client_version`, 'client_lastconnected', ) VALUES ('$cldbid', '$clid', '$nick', '$uid', '$server_groups', '$connections','$connected_time', '$idle_time', '$connected_time', '$connected_time', '$idle_time', '$connection_client_ip', '$client_version', '`$client_lastconnected`,' '".date('W')."', 0, '')");
		}
		else
		{
			$result = $query_sql->query("SELECT * FROM `clients` WHERE `client_dbid`='$cldbid'")->fetch(PDO::FETCH_ASSOC);

			if($result['connected_time_record'] < $connected_time)
				$query_sql->exec("UPDATE `clients` SET `connected_time_record`='$connected_time' WHERE `client_dbid`='$cldbid'");

			if($result['idle_time_record'] < $idle_time)
				$query_sql->exec("UPDATE `clients` SET `idle_time_record`='$idle_time' WHERE `client_dbid`='$cldbid'");

            if($result['connection_client_ip'] <> $connection_client_ip) //update ip
                $query_sql->exec("UPDATE `clients` SET `connection_client_ip`='$connection_client_ip' WHERE `client_dbid`='$cldbid'");
			
            if($result['client_version'] <> $client_version) //update version
                $query_sql->exec("UPDATE `clients` SET `client_version`='$client_version' WHERE `client_dbid`='$cldbid'");

            if($result['client_lastconnected'] < $client_lastconnected) //update last connection
                $query_sql->exec("UPDATE `clients` SET `client_lastconnected`='$client_lastconnected' WHERE `client_dbid`='$cldbid'");

			if($idle_time >= 1000 * self::$cfg['idle_time'])
			{
				$idle_time_spent = $result['idle_time_spent'] + $event_info['interval'][self::$name]*1000;
				$query_sql->exec("UPDATE `clients` SET `idle_time_spent`='$idle_time_spent' WHERE `client_dbid`='$cldbid'");
			}
			
		if($result['week_start'] != date('W'))
				$query_sql->exec("UPDATE `clients` SET `week_start`='".date('W')."',`week_start_time`='".$result['time_spent']."' WHERE `client_dbid`='$cldbid'");
			
			if($result['client_nick'] != $nick)
			{
				if($result['last_nicks'] != "")
				{
					$nick_change = json_decode($result['last_nicks'], true);
					if(count($nick_change) > 30) 
					{
						$nick_change_backup = array();
						
						foreach($nick_change as $time => $value)
							$nick_change_backup[] = array('time' => $time, 'value' => $value);
						
						$nick_change = array();
						
						for($i = 0; $i < 10; $i++)
							$nick_change[$nick_change_backup[count($nick_change_backup)-10+$i]['time']] = $nick_change_backup[count($nick_change_backup)-10+$i]['value'];
					}
				}
				else
					$nick_change = array();
				
				$nick_change[time()] = $result['client_nick'];
				$query_sql->exec("UPDATE `clients` SET `last_nicks`='".json_encode($nick_change)."' WHERE `client_dbid`='$cldbid'");
			}
			
			$time_spent = $result['time_spent'] + $event_info['interval'][self::$name]*1000;
			$query_sql->exec("UPDATE `clients` SET `client_clid`='$clid', `client_nick`='$nick', `server_groups`='$server_groups', `connections`='$connections', `connected_time`='$connected_time',`time_spent`='$time_spent' WHERE `client_dbid`='$cldbid'");
		}
	}
}
?>
