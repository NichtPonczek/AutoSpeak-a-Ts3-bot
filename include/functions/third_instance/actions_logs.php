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

class actions_logs
{
	private static $name;
	private static $cfg;
	private static $enabled_functions=array();
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
		
		foreach(self::$cfg['info'] as $func => $enabled)
			if($enabled)
				self::$enabled_functions[] = $func;
	}	

	static public function before_clients()
	{
		global $query, $query_sql, $AutoSpeak, $language;
		
		$actions = $query_sql->query("SELECT * FROM `actions` ORDER BY `id` DESC LIMIT ".(5*self::$cfg['records']))->fetchAll(PDO::FETCH_ASSOC);
		
		$i=0;
		$desc = "[hr][center][size=14][b]".self::$cfg['top_description']."[/b][/size][/center][hr][table][tr]
[th][size=15][/size][size=9]".(self::$cfg['show_id'] ? "        [B][U]ID[/U][/B]" : "")."        [B][U]Data[/U][/B]         [B][U]Godzina[/U][/B]     [B][U]Wykonana akcja na serwerze[/U][/B]     [/size][/th][/table]\n\n";
		
		foreach($actions as $action)
		{
			if(in_array($action['name'], self::$enabled_functions))
			{
				$i++;
				$desc .= "[b]• ".(self::$cfg['show_id'] ? "  | ".$action['id']." " : "").date('| d-m-Y | G:i:s |', $action['date'])."[/b] - ".$action['text']."\n";
			}
			
			if($i == self::$cfg['records'])
				break;
		}
		
		$desc .= $language['function']['down_desc'];
		
		if($AutoSpeak::check_channel_desc(self::$cfg['channel_id'], $desc))
			$AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_description' => $desc)), self::$name, self::$cfg['channel_id'], true);
	}
}
?>