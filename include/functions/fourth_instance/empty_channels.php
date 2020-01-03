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

class empty_channels
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
		global $query, $language, $logs_manager, $AutoSpeak;

		$lang = $language['function']['empty_channels'];
		$numbers = array();
		$number = 1;
		$found = false;

		$today = date('w');
		$tomorrow = array();	

		array_push($tomorrow, date('d-m-Y', time() + 86400),date('d-m-Y', time() + 2 * 86400),date('d-m-Y', time() + 3 * 86400));
		$des[$tomorrow[0]] = "[size=12]●[/size] [b][size=10]".$lang['tomorrow'].": [/size][color=red]";
		$des[$tomorrow[1]] = "\n[size=12]●[/size] [b][size=10]".$lang['days'][(($today+2)%7)].": [/size][color=red]";
		$des[$tomorrow[2]] = "\n[size=12]●[/size] [b][size=10]".$lang['days'][(($today+3)%7)].": [/size][color=red]";

		foreach($channels = $query->getElement('data', $query->channelList("-topic -limits -flags")) as $channel)
		{
			if($channel['cid'] == self::$cfg['channels_zone'])
				$found = true;
			elseif($channel['pid'] == self::$cfg['channels_zone'])
			{
				if($channel['channel_topic'] == self::$cfg['empty_channel_topic'])
					array_push($numbers, $number);
				else
				{
					$date = explode('-', $channel['channel_topic']);
		
					$channel_date = mktime(0,0,0,$date[1],$date[0],$date[2]);
					$del_channel_time = $channel_date + self::$cfg['time_interval_delete'] * 86400;
					$del_channel_date = date('d-m-Y', $del_channel_time);;

					if(in_array($del_channel_date, $tomorrow))
						$des[$del_channel_date] .= "[size=11]".$number."[color=black],[/color][/size] ";
				}
				$number++;
			}	
		}

		if(!$found)
		{
			$logs_manager::set_error("#Ch1:".self::$cfg['channels_zone'], self::$name, true);
			return;
		}
		
		$desc = "[hr][center][size=14][b]".$lang['list']."[/b][/size][/center][hr][size=13][b]| ".$lang['free']." |[/b][/size]\n\n[size=12]●[/size] [size=11][color=green][b]";
		foreach($numbers as $num)
			$desc .= $num.", ";

		$desc .= "[/b][/color][/size]\n[hr]\n[size=13][b]| ".$lang['to_del']." |[/b][/size]\n\n";

		foreach($des as $to_del)
			$desc .= $to_del."[/color][/b]";

		$desc .= "\n".$language['function']['down_desc'];

		$AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_description' => $desc)), self::$name, self::$cfg['channel_id'], true);
	}
}
?>