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

class new_daily_users
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
		global $query, $query_sql, $AutoSpeak;

		$client_info = $query->getElement('data', $query->clientInfo($client['clid']));
		if($client_info['client_totalconnections'] == 1)
		{
			$cldbid = $client['client_database_id'];
			$nick = htmlentities($client['client_nickname'], ENT_QUOTES, "UTF-8");
			$uid = $client['client_unique_identifier'];
			$clid = $client['clid'];
		
			$result = $query_sql->query("SELECT `client_dbid` FROM `new_daily_users` WHERE `client_dbid` = '$cldbid'");
		
			if($result->rowCount() == 0)
			{
				$data = date('d-m-Y');
				$query_sql->exec("INSERT INTO `new_daily_users` (`client_dbid`, `client_clid`, `client_nick`, `client_uid`, `day`) VALUES ('$cldbid', '$clid', '$nick', '$uid', '$data')");
			}
		}
	}

	static public function before_clients()
	{
		global $query, $query_sql, $language, $AutoSpeak;
		
		$desc = '[hr][center][size=14][b]'.self::$cfg['top_description'].'[/b][/size][/center][hr]';
		$data = array();

		$result = $query_sql->query('SELECT * FROM new_daily_users ORDER BY client_dbid')->fetchAll(PDO::FETCH_ASSOC);

		$count = 0;
		
		if(!empty($data))
		{
			foreach($data as $new_user)
			{
				if($count == 30)
					break;
				
				if($new_user['day'] == date('d-m-Y'))
				{
					$desc .= "[list][*][size=9] [URL=client://".$new_user['client_clid']."/".$new_user['client_uid']."]".$new_user['client_nick']."[/url]".$AutoSpeak::show_link($new_user['client_dbid'])."[/list]";
					$count++;
				}
				elseif($new_user['day'] != date('d-m-Y'))
					$query_sql->exec("DELETE FROM `new_daily_users` WHERE `client_dbid` = ".$new_user['client_dbid']."");
			}
		}
		
		$desc .= $language['function']['down_desc'];
	
		$channel = $query->getElement('data', $query->channelInfo(self::$cfg['channel_id']));
		$name = str_replace("[NEW]", count($data), self::$cfg['channel_name']);

		if($name != $channel['channel_name'])
		{
			if($AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_name' => $name)), self::$name, self::$cfg['channel_id'], true))
				$query->channelEdit(self::$cfg['channel_id'], array('channel_description' => $desc));
		}
	}
}
?>