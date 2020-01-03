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

class facebook_posts
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

		$lang = $language['function'][self::$name];

		$desc = "[center][hr][B][size=11]".$lang['header']." [url=".self::$cfg['link_to_fanpage']."]fanpage[/url][/size][/B][hr][/center]";
		$i = 0;
		$count = 0;
		$error_api = false;

		$page_posts = json_decode(file_get_contents('https://graph.facebook.com/'.self::$cfg['page_id'].'/posts?access_token='.self::$cfg['access_token'])); 
		$likes = json_decode(file_get_contents('https://graph.facebook.com/'.self::$cfg['page_id'].'?access_token='.self::$cfg['access_token'].'&fields=name,fan_count'));		
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		
		
		if(isset($page_posts) && isset($likes))
		{
			foreach($page_posts->data as $fppost) 
             	if(property_exists($fppost, 'message')) 
					$count++;

			foreach($page_posts->data as $fppost) 
			{
             	if(property_exists($fppost, 'message')) 
				{ 
					if($i >= self::$cfg['posts'])
						break;

					$date = $fppost->created_time;
					$date = explode('T', $date);
					$time = explode('+', $date[1]);

					$date_text = $date[0].' '.$time[0];

					if(preg_match_all($reg_exUrl, $fppost->message, $url)) 
						foreach($url[0] as $url_to_change)
							$fppost->message = str_replace($url_to_change, '[url]'.$url_to_change.'[/url]', $fppost->message);
 

					$desc .= "[b]".$fppost->message."[/b]\n[right][b][i][color=grey]".$lang['written']." ".$date_text."[/color][/i][/b][/right]";
			
					if($count > self::$cfg['posts'])	
					{
						if($i != (self::$cfg['posts'] - 1))
							$desc .= "[hr]\n";
					}
					elseif($i != ($count-1))
						$desc .= "[hr]\n";
					$i++;
             	}
			}
		}
		else
		{
			$error_api = true;
			$desc = $language['function']['error']['api'];
			$logs_manager::write_info(" [".self::$name."] API ERROR");
		}
		
		$desc .= $language['function']['down_desc'];
		if(!$error_api)
			$AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_name' => str_replace('[LIKES]', $likes->fan_count, self::$cfg['channel_name']))), self::$name, self::$cfg['channel_id'], true);
		$AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_description' => $desc)), self::$name, self::$cfg['channel_id'], true);
	}
}
?>