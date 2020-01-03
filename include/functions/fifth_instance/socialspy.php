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

class socialspy
{
	private static $name;
	private static $cfg;
	
	static public function construct($command_name)
	{
		global $cfg;
		self::$cfg = $cfg[$command_name];
		self::$name = $command_name;
	}	

	static private function tip_of_words($num, $for1, $for234, $for_others)
	{
		$text = " ".$num." ";
		if($num == 1)
			return $text.$for1;
		elseif(in_array($num%10, array(2,3,4)))
			return $text.$for234;
		else return $text.$for_others; 
	}

	static private function convert_to_time($seconds)
	{
		global $language;

		$lang = $language['function']['connect_message'];

		$text = "";
		$uptime['d']=floor($seconds / 86400);
		$uptime['h']=floor(($seconds - ($uptime['d'] * 86400)) / 3600);
		$uptime['m']=floor(($seconds - (($uptime['d'] * 86400)+($uptime['h']*3600))) / 60);
		$uptime['s']=floor(($seconds - (($uptime['d'] * 86400)+($uptime['h']*3600)+($uptime['m'] * 60))));

		
		if($uptime['d'] != 0)
			$text .= self::tip_of_words($uptime['d'], $lang['one_day'], $lang['2_days'], $lang['other_days']);
		if($uptime['h'] != 0)
			$text .= self::tip_of_words($uptime['h'], $lang['one_hour'], $lang['2_hours'], $lang['other_hours']);
		if($uptime['m'] != 0)
			$text .= self::tip_of_words($uptime['m'], $lang['one_minute'], $lang['2_minutes'], $lang['other_minutes']);
		if($text == '') 
			$text .= $uptime['s'].' '.$lang['seconds'].' ';


		return $text;	}

	static private function replace($message, $db_info)
	{		
		$edited_message = array
		(
			'[nick]' => $db_info['client_nick'],
			'[dbid]' => $db_info['client_dbid'],
			'[uid]' => $db_info['client_uid'],
			'[con]' => $db_info['connections'],
			'[time_spent]' => self::convert_to_time($db_info['time_spent']/1000),
		);
		return str_replace(array_keys($edited_message), array_values($edited_message), $message);
	}


	static public function main($info)
	{
		global $query, $query_sql, $language, $kakadu;
	
		$lang = $language['command']['socialspy'];
		$msg = '';

		$result = $query_sql->query("SELECT * FROM `clients` WHERE `client_dbid`='".$info['parameters'][0][1]."'");
		
		if($result->rowCount() > 0)
		{
			$result = $result->fetch(PDO::FETCH_ASSOC);
			
			$msg .= self::replace($lang['info'], $result);
			$query->sendMessage(1, $info['clid'], $msg);
			$nicks_change = json_decode($result['last_nicks'], true);
			
			if(!empty($nicks_change))
			{
				$i=0;
				$msg = $lang['info_2'];
				$index = array();
				$j=0;
				
				foreach($nicks_change as $time => $nick)
					$index[$j++] = $time;
				
				foreach($nicks_change as $time => $nick)
				{	
					if(($i+1)%20 == 0)
					{
						$query->sendMessage(1, $info['clid'], $msg);
						$msg = "\n";
					}
				
					$msg .= "\t[b]".date('d-m-Y G:i', $time)."[/b] ".$lang['change_nick']." [i][b]".$nick."[/b][/i]  -> [b][u]".(isset($index[$i+1]) ? $nicks_change[$index[$i+1]] : $result['client_nick'])."[/u][/b]\n";
					$i++;
				}
				
				$query->sendMessage(1, $info['clid'], $msg);
			}
		}
		else
			$query->sendMessage(1, $info['clid'], $lang['no_in_db']);
	}
}
?>