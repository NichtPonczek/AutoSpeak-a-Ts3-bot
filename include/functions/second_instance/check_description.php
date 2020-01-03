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

class check_description
{
	private static $lang;
	private static $name;
	private static $cfg;
	private static $allowed_links;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
		self::$allowed_links = explode(',', strtolower(file_get_contents("include/cache/allowed_links.txt")));
	}
	
	static public function before_clients()
	{
		global $query, $AutoSpeak, $language, $query_sql;
		
		$channels = array();
		$subchannels = array();
		
		$channel_info = $query->getElement('data', $query->channelInfo(self::$cfg['channel_info']));
		$channel_desc = count(explode("[hr]", $channel_info['channel_description'])) == 4 ? explode("[hr]", $channel_info['channel_description'])[2] : "";
		$header = "[hr][center][b][size=15]".$language['function']['check_description']['header']."[/size][/b][/center][hr]";
		$to_add = "";
		
		if(self::$cfg['check_vip_channels'] && isset($query_sql))
		{
			$vip_channels = $query_sql->query("SELECT channel_cid, spacer_cid FROM vip_channels")->fetchAll(PDO::FETCH_ASSOC);
			
			if(count($vip_channels) > 0)
			{
				foreach($vip_channels as $vip_channel)
				{
					foreach(explode(',', $vip_channel['channel_cid']) as $cid)
						if($cid != "" && $cid != "0")
							$channels[] = $cid;
				
					if($vip_channel['spacer_cid'] != "" && $vip_channel['spacer_cid'] != "0")
						$channels[] = $vip_channel['spacer_cid'];
				}
			}
		}
	
		foreach($query->getElement('data', $query->channelList()) as $channel)
			if(in_array($channel['pid'], array_merge(self::$cfg['channels'], $channels)))
				$subchannels[] = $channel['cid'];
	
		foreach(array_merge(self::$cfg['channels'], $channels, $subchannels) as $channel)
		{
			$channel_info = $query->getElement('data', $query->channelInfo($channel));
			
			$found_links = array();
			preg_match_all("/(\[img\]|\[url\])(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?(\[\/img\]|\[\/url\])/", strtolower($channel_info['channel_description']), $found_links);
			
			$desc = $channel_info['channel_description'];

			foreach($found_links[0] as $link)
			{
				$bad_link = true;
				
				
				foreach(self::$allowed_links as $allowed_link)
				{
					if($allowed_link != "" && strpos($link, $allowed_link) !== false)
					{
						$bad_link = false;
						break;
					}
				}
				
				if($bad_link)
				{
					$desc = str_replace($link, $language['function']['check_description']['bad_link'], strtolower($desc));	
					$to_add .= "[b]".date('d-m-Y G:i:s')."[/b] - ".$language['function']['check_description']['bad_link_text']." ([b][color=red]".str_replace(array('[url]', '[/url]'), array('', ''), strtolower($link))."[/color][/b]) ".$language['function']['check_description']['on_channel']." ([b]id:".$channel."[/b]) [b][url=channelId://".$channel."]".$channel_info['channel_name']."[/url][/b]\n";
				}
			}
			
			if($channel_info['channel_description'] != $desc)
				$query->channelEdit($channel, array('channel_description' => $desc));
		}
		
		if($to_add != "")
		{
			if($AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_info'], array('channel_description' => $header.$to_add.$channel_desc.$language['function']['down_desc'])), self::$name, self::$cfg['channel_info']) != true)
				$query->channelEdit(self::$cfg['channel_info'], array('channel_description' => $header.$to_add.$language['function']['down_desc']));	
		}
		elseif($to_add == "" && $channel_desc == "")
			$AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_info'], array('channel_description' => $header.$language['function']['down_desc'])), self::$name, self::$cfg['channel_info']);
			
	}
}
?>