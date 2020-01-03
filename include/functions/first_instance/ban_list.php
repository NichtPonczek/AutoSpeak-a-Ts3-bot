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

class ban_list
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg, $language;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}

	static public function before_clients()
	{
		global $query, $language, $AutoSpeak;	
		
		$lang = $language['function']['ban_list'];
		$how_many = self::$cfg['how_many'];

		$ban_list = $query->getElement('data', $query->banList());
		$list = "";
		$i = 0;
		$j = 0;
		$bans = array();

		if(!empty($ban_list))
		{
			foreach($ban_list as $single_ban)
				if($single_ban['uid'] != '')
				{
					$i++;
					array_push($bans, $single_ban);
				}
			
			$list .= "[hr][center][size=18][/size][/center][hr][size=14]".$lang['header'].$i."[/size]\n\n";
			
			if($how_many >= $i)
				$how_many = 0;
			else
			{
				$old = $how_many;
				$how_many = $i - $how_many;       
			}                             

			for($j=1, $k=$how_many; $j<=($i-$how_many); $j++, $k++)
			{
				$single_ban = $bans[$k];
					
				if($single_ban['duration'] == 0)
					$time = $lang['permament'];
				else
					$time = $AutoSpeak::convert_time($single_ban['duration']);

				$list .= "● [size=13]Ban: ".($how_many+$j)."[/size][list][*][size=9][b] Nick: ".$single_ban['lastnickname']."[/size][/list][list][*][size=9] [b]".$lang['time'].": [/b][b][color=green] ".$time."[/b][/size]\n[/list][list][*] [size=9][b]".$lang['reason'].": [/b]".$single_ban['reason']."[/size]\n[/list][list][*][size=9][b]".$lang['invoker'].": [color=red]".$single_ban['invokername']."[/color][/b][/size]\n[/list][list][*][size=9][b]".$lang['date'].": ".date('d-m-Y G:i', $single_ban['created'])."[/b][/size]\n[/list]\n";	

				if($how_many == 0)	
				{
					if($j != $i)
						$list .= "[hr]";
				}
				elseif($j != $old)
					$list .= "[hr]";
			}
		}
		else
			$list .= "● [size=13][b]Brak banów[/b][/size]\n";
		
		$list .= $language['function']['down_desc'];
		
		if($AutoSpeak::check_channel_desc(self::$cfg['channel_id'], $list))
			$AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_description' => $list)), self::$name, self::$cfg['channel_id'], true);
	}
}
?>