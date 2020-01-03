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

class record_online
{
	private static $name;
	private static $cfg;

	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}


	static function before_clients()
	{
		global $query, $server_info, $language, $AutoSpeak;

		$current_online = $server_info['virtualserver_clientsonline'] - $server_info['virtualserver_queryclientsonline'];
		$date = date('d-m-Y G:i:s');
		
		if(!file_exists("include/cache/record_online.txt"))
		{
			file_put_contents("include/cache/record_online.txt", json_encode(array('online' => $current_online, 'time' => time())));
		}
		else
		{
			$record = @array_reverse(json_decode(file_get_contents("include/cache/record_online.txt"), true));
			
			if(!is_array($record) || $record[0]['online'] < $current_online)
			{
				$record = array_reverse($record);
				$record[] = array('online' => $current_online, 'time' => time());
				file_put_contents("include/cache/record_online.txt", json_encode($record));
				$record = array_reverse($record);
			}
			else
			{
				$current_online = $record[0]['online'];
				$date = date('d-m-Y G:i:s', $record[0]['time']);
			}	
		}
		$desc ="[hr][center][size=15][/center][hr]\n[size=10]\n● ".$language['function']['record_online'][1]." [b]".$current_online."[/b].\n● ".$language['function']['record_online'][2]." [b]".$date."[/b][/size]";
		
		if(self::$cfg['show_history'] && count($record) > 1)
		{
			$desc .= "\n [hr] \n [size=14][b]Historia rekordów:[/b][/size]\n\n";
			$i = 0;
			
			foreach($record as $info)
			{
				if(($i++) == 0) continue;
				$desc .= "* Rekord [b]".$info['online']."[/b] ustanowiono [b]".date('d-m-Y G:i:s', $info['time'])."[/b]\n";
				if($i >= 10) break;
			}
		}
		
		$desc .= $language['function']['down_desc'];
		
		$name = str_replace('[RECORD]', $current_online, self::$cfg['channel_name']);
		$channel = $query->getElement('data', $query->channelInfo(self::$cfg['channel_id']));
		if($name != $channel['channel_name'])
			$AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_name' => $name, 'channel_description' => $desc)), self::$name, self::$cfg['channel_id'], true);
	}
}
?>