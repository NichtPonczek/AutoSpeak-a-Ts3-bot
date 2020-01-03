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

class random_group
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}

	static private function has_ignored_rang(array $groups)
	{
		$allowed = false;

		foreach($groups as $group)
		{	
			if(in_array($group, self::$cfg['ignored_groups']))
				return true;

			if(!in_array($group, self::$cfg['must_have_group']))
				$allowed = true;
		}
		
		if($allowed)
			return false;
		else
			return true;
	}

	static public function before_clients()
	{
		global $query, $query_sql, $clients, $language, $AutoSpeak;

		$lang = $language['function']['random_group'];
		$last_winner = '';
		
		$res = $query_sql->query('SELECT * FROM random_group ORDER BY date DESC LIMIT 1');
		$result= $res->fetch(PDO::FETCH_ASSOC);

		if($res->rowCount() == 0 || $result['deleted'] == 1)
		{
			$i=0;
			do
			{
				$random = rand(0, count($clients)-1);
				$i++;
			}while(($clients[$random]['client_type'] == 1 || self::has_ignored_rang(explode(",", $clients[$random]['client_servergroups']))) && $i<15);
			
			if($i==15)
				return;
			
			$dbid = $clients[$random]['client_database_id'];
			$client = $clients[$random];

			$sgid = self::$cfg['random_groups'][rand(0, count(self::$cfg['random_groups'])-1)];
	
			foreach($query->getElement('data', $query->serverGroupList()) as $group)
				if($group['sgid'] == $sgid)
				{
					$name = $group['name'];
					break;
				}


			$query->serverGroupAddClient($sgid, $dbid);
			$query->clientPoke($client['clid'], $lang['owner']."[color=red]".$name."[/color] ".$lang['on_time']." ".self::$cfg['time']." (".$lang['days'].")! ".$lang['cong']);

			$query_sql->exec("INSERT INTO random_group (client_dbid, sgid, date, time, deleted) VALUEs (".$dbid.", ".$sgid.", '".time()."', ".(self::$cfg['time']*3600*24).", 0)");
			
			$AutoSpeak::set_action(self::$name, array('client' => $client));
		}
		else
		{
			$start_time = $result['date'];
		
			if(($start_time + $result['time']) < time())
			{
				$query->serverGroupDeleteClient($result['sgid'], $result['client_dbid']);
				$query_sql->exec("UPDATE random_group SET deleted=1");
			}
		}
		
		$result = $query_sql->query('SELECT * FROM `random_group` ORDER BY `date` DESC LIMIT '.self::$cfg['records'])->fetchAll(PDO::FETCH_ASSOC);
	
		$desc = "[hr][center][size=14][b]Randomowe Grupy[/size][/center][hr]";

		foreach($result as $res)
		{
			$info = $query->getElement('data', $query->clientDbInfo($res['client_dbid']));
			foreach($query->getElement('data', $query->serverGroupList()) as $group)
				if($group['sgid'] == $res['sgid'])
				{
					$name = $group['name'];
					break;
				}
			
			if($last_winner == '')
				$last_winner = $info['client_nickname'];

			$desc .= "[list][*][size=8][b]  [URL=client://1/".$info['client_unique_identifier']."]".$info['client_nickname']."[/URL][/b]".$AutoSpeak::show_link($res['client_dbid'])." ".$lang['desc']." [color=red][b]".$name."[/b][/color] ".$lang['day']." [b]".date('d-m-Y G:i', $res['date'])."[/b].[/size]\n[/list]";

		}

		$desc .= $language['function']['down_desc'];
		
		if($AutoSpeak::check_channel_desc(self::$cfg['channel_id'], $desc))
			if($AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_description' => $desc)), self::$name, self::$cfg['channel_id'], true))
				$query->channelEdit(self::$cfg['channel_id'], array('channel_name' => str_replace('[USER]', $last_winner, self::$cfg['channel_name'])));
	}
}
?>