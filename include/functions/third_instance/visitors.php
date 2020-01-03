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

class visitors
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
		global $query_sql;
		
		$cldbid = $client['client_database_id'];
		
		$result = $query_sql->query("SELECT `client_dbid` FROM `visitors` WHERE `client_dbid` = '$cldbid'");
		
		if($result->rowCount() == 0)
		{
			$data = date('d-m-Y');
			$query_sql->exec("INSERT INTO `visitors` (`client_dbid`, `day`) VALUES ('$cldbid', '$data')");
		}
	}

	static public function before_clients()
	{
		global $query, $query_sql, $AutoSpeak;

		$result = $query_sql->query('SELECT * FROM visitors ORDER BY client_dbid')->fetchAll(PDO::FETCH_ASSOC);

		$count = 0;
		foreach($result as $visitor)
		{
			if($visitor['day'] == date('d-m-Y'))
				$count++;
			elseif($visitor['day'] != date('d-m-Y'))
				$query_sql->query("DELETE FROM `visitors` WHERE `client_dbid` = ".$visitor['client_dbid']."");
		}

		$channel = $query->getElement('data', $query->channelInfo(self::$cfg['channel_id']));
		$name = str_replace("[VISITORS]", $count, self::$cfg['channel_name']);

		if($name != $channel['channel_name'])
			$AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_name' => $name)), self::$name, self::$cfg['channel_id'], true);
	}
}
?>