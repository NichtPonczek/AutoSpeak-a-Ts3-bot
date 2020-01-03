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

class event_records
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}
	
	static public function main($client)
	{
		global $query, $language;

		$channel = $query->getElement('data', $query->channelInfo(self::$cfg['channel_id']));
		$ch_desc = explode("[hr]", $channel['channel_description']);

		if(count($ch_desc) != 4)
		{
			$desc = "[hr][center][size=14][b]".self::$cfg['top_description']."[/b][/size][/center][hr]\n".$language['function']['down_desc'];
			$query->channelEdit(self::$cfg['channel_id'], array('channel_description' => $desc));
			$ch_desc = explode("[hr]", $desc);
		}

		if(strpos($ch_desc[2], "[URL=client://1/".$client['client_unique_identifier']."]") === false)
		{
			$desc = "[hr][center][size=14][b]".self::$cfg['top_description']."[/b][/size][/center][hr]";
			$desc .= $ch_desc[2];
			$desc .= "[URL=client://1/".$client['client_unique_identifier']."]".$client['client_nickname']."[/url]\n";
			$desc .= $language['function']['down_desc'];

			$query->channelEdit(self::$cfg['channel_id'], array('channel_description' => $desc));
			$msg = $language['function']['event_records']['success'];
		}
		else
			$msg = $language['function']['event_records']['failed'];

		$query->clientKick($client['clid'], "channel");
		$query->clientPoke($client['clid'], $msg);
	}
}
?>