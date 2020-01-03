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

class twitch_yt
{
	private static $name;
	private static $cfg;
	public static $disabled_channels = array();
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}
	
	static private function convert_subs($subs)
	{
		$subscribers['mln'] = floor($subs / 1000000);
		$subscribers['k'] = floor(($subs - ($subscribers['mln'] * 1000000)) / 1000);
		
		if($subscribers['mln']>0)
			return $subscribers['mln']."mln";
		elseif($subscribers['k'] > 0)
			return $subscribers['k']."k";
		else
			return $subs;
	}

	static public function before_clients()
	{
		global $query, $logs_manager, $language, $AutoSpeak, $query_sql;

		$cfg = self::$cfg['info'];
		$lang = $language['function']['twitch_yt'];
		
		if($cfg['twitch_enabled'])
		{
			foreach($cfg['twitch'] as $twitch_channel => $info)
			{
				$channels_api = 'https://api.twitch.tv/kraken/users/';
 				$channel_name = $twitch_channel;
 				$client_id = $cfg['twitch_api_key'];
 				$ch = curl_init();
				$status = '';
 
 				curl_setopt_array
				(
					$ch, array
					(
   		 				CURLOPT_HTTPHEADER => array
						(
      		 					'Client-ID: ' . $client_id
   		 				),
   						CURLOPT_RETURNTRANSFER => true,
    						CURLOPT_URL => $channels_api . $channel_name
 					)
				);
				
 				$response = curl_exec($ch);
				curl_close($ch);
				$twitch_user = json_decode($response);
	
				$channels_api = 'https://api.twitch.tv/kraken/streams/';
 				$ch = curl_init();
 
 				curl_setopt_array
				(
					$ch, array
					(
   		 				CURLOPT_HTTPHEADER => array
						(
      		 					'Client-ID: ' . $client_id
   		 				),
   						CURLOPT_RETURNTRANSFER => true,
    						CURLOPT_URL => $channels_api . $channel_name
 					)
				);
 
 				$response = curl_exec($ch);
				curl_close($ch);
				$twitch_stream = json_decode($response);
				
				$channels_api = 'https://api.twitch.tv/kraken/channels/';
 				$ch = curl_init();
 
 				curl_setopt_array
				(
					$ch, array
					(
   		 				CURLOPT_HTTPHEADER => array
						(
      		 					'Client-ID: ' . $client_id
   		 				),
   						CURLOPT_RETURNTRANSFER => true,
    						CURLOPT_URL => $channels_api . $channel_name
 					)
				);
 
 				$response = curl_exec($ch);
				curl_close($ch);
				$twitch_info = json_decode($response);
			
				if(@$twitch_stream->error != NULL)
				{	
					$desc = $language['function']['error']['api'];
					$logs_manager::write_info(" [".self::$name."] API ERROR");
				}
				elseif($twitch_stream->stream != NULL)
				{
					$desc = "[center][hr]\n[size=20]".$twitch_user->display_name."\n[color=green] [ONLINE][/color][/size][/center]\n\n\n";
					$desc .= "[size=12][b]".$lang['info']."[/b]".$twitch_user->bio."[/size]\n\n";
					$desc .= "[size=12][b]".$lang['follows']."[/b]".$twitch_info->followers."[/size]\n\n";
					$desc .= "[size=12][b]".$lang['views']."[/b]".$twitch_info->views."[/size]\n\n";
					$desc .= "[size=12][b]".$lang['playing']."[/b]".$twitch_stream->stream->game."\n\n[b]".$lang['viewers']."[/b]".$twitch_stream->stream->viewers."[/size]\n\n";	
					$desc .= "[size=11][b]Link:[/b] [url=http://twitch.tv/".$channel_name."][color=purple]".$lang['click']."[/color][/size]\n";
					$desc .= $language['function']['down_desc'];
					$status = $lang['streaming'];
				}
				else
				{
					$desc = "[center][hr]\n[size=20]".$twitch_user->display_name."\n[color=red] [OFFLINE][/color][/size][/center]\n\n\n";
					$desc .= "[size=12][b]".$lang['info']."[/b]".$twitch_user->bio."[/size]\n\n";
					$desc .= "[size=12][b]".$lang['follows']."[/b]".$twitch_info->followers."[/size]\n\n";
					$desc .= "[size=12][b]".$lang['views']."[/b]".$twitch_info->views."[/size]\n\n";
					$desc .= "[size=11][b]Link:[/b] [url=http://twitch.tv/".$channel_name."][color=purple]".$lang['click']."[/color][/size]\n";
					$desc .= $language['function']['down_desc'];
				}

				if($AutoSpeak::check_channel_desc($info['main_channel']['channel_id'], $desc))
					$query->channelEdit($info['main_channel']['channel_id'], array('channel_description' => $desc));

				if($desc != "ERROR")
					$AutoSpeak::check_error($query->channelEdit($info['main_channel']['channel_id'], array('channel_name' => str_replace('[STATUS_TWITCH]', $status, $info['main_channel']['channel_name']))), self::$name, $info['main_channel']['channel_id']);
				
				$AutoSpeak::check_error($query->channelEdit($info['follows']['channel_id'], array('channel_name' => str_replace('[FOLLOWS]', self::convert_subs($twitch_info->followers), $info['follows']['channel_name']))), self::$name, $info['follows']['channel_id']);
			}
		}
		
		if($cfg['youtube_enabled'])
		{
			$key = $cfg['youtube_api_key'];
			
			if(isset($query_sql))
			{
				$result = $query_sql->query("SELECT `main_info`, `videos_count`, `views_count` FROM `yt_channels`");
				if($result->rowCount() > 0)
				{	
					$result = $result->fetchAll(PDO::FETCH_ASSOC);

					foreach($result as $once)
					{
						if($once['main_info'] != 0)
						{							
							$main_channel = $query->getElement('data', $query->channelInfo($once['main_info']));
	
							if($main_channel['channel_topic'] != "")
							{
								self::$cfg['info']['youtube'][$main_channel['channel_topic']]['main_channel']['channel_id'] = $once['main_info'];
								self::$cfg['info']['youtube'][$main_channel['channel_topic']]['main_channel']['channel_name'] = '[ YouTuber ] [NAME]: [SUBS] subów';
								
								self::$cfg['info']['youtube'][$main_channel['channel_topic']]['videos_count']['channel_id'] = $once['videos_count'];
								self::$cfg['info']['youtube'][$main_channel['channel_topic']]['videos_count']['channel_name'] = 'Filmów: [VIDEOS]';
								
								self::$cfg['info']['youtube'][$main_channel['channel_topic']]['views_count']['channel_id'] = $once['views_count'];
								self::$cfg['info']['youtube'][$main_channel['channel_topic']]['views_count']['channel_name'] = 'Wyświetleń: [VIEWS]';
							}
						}	
					}
				
					$cfg = self::$cfg['info'];
				}
			}
			
			foreach($cfg['youtube'] as $yt_id => $info) 
			{
				if(in_array($yt_id, self::$disabled_channels))
					continue;
				
				$yt_user = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id='.$yt_id.'&key='.$key));
				$yt_user_live = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?part=snippet&channelId='.$yt_id.'&type=video&eventType=live&key='.$key));
				
				if(isset($yt_user->error) || !isset($yt_user))
				{	
					$desc = $language['function']['error']['api'];
					$logs_manager::write_info(" [".self::$name."] API ERROR");
				}
				else
				{
					$api_good = true;
					
					$desc = "[center]".$yt_user->items[0]->snippet->thumbnails->default->url."[/img][hr]\n[size=15][b]".$yt_user->items[0]->snippet->title."[/b][/size][/center]\n\n";
					
					if(isset($yt_user_live->items[0])) $desc .= "[list][*]  [size=11] [b]Live[/b]: [u]".$yt_user_live->items[0]->snippet->title."[/u][/size][/list]";
					$desc .= "[list][*]  [size=11] [b]".$lang['subs']."[/b][u]".$yt_user->items[0]->statistics->subscriberCount."[/u][/size][/list]";
					$desc .= "[list][*]  [size=11] [b]".$lang['videos']."[/b][u]".$yt_user->items[0]->statistics->videoCount."[/u][/size][/list]";
					$desc .= "[list][*]  [size=11] [b]Link:[/b] [u][url=https://youtube.com/channel/".$yt_id."?sub_confirmation=1][color=red]".$lang['click']."[/color][/url][/u][/size][/list]";
					$desc .= "[list][*]  [b]".$lang['info']."[/b]".$yt_user->items[0]->snippet->description."[/size][/list]\n";
					$desc .= $language['function']['down_desc'];
				}
				
				if(isset($yt_user_live->items[0])) $info['main_channel']['channel_name'] .= "[LIVE]";
				
				$AutoSpeak::check_error($query->channelEdit($info['main_channel']['channel_id'], array('channel_name' => str_replace(array("[SUBS]", "[NAME]"), array(self::convert_subs($yt_user->items[0]->statistics->subscriberCount), $yt_user->items[0]->snippet->title), $info['main_channel']['channel_name']))), self::$name, $info['main_channel']['channel_id']);
				
				if($desc != "ERROR")
				{
					if($AutoSpeak::check_channel_desc($info['main_channel']['channel_id'], $desc))
						$query->channelEdit($info['main_channel']['channel_id'], array('channel_description' => $desc));
					
					$AutoSpeak::check_error($query->channelEdit($info['videos_count']['channel_id'], array('channel_name' => str_replace("[VIDEOS]", $yt_user->items[0]->statistics->videoCount, $info['videos_count']['channel_name']))), self::$name, $info['videos_count']['channel_id']);
					$AutoSpeak::check_error($query->channelEdit($info['views_count']['channel_id'], array('channel_name' => str_replace("[VIEWS]", self::convert_subs($yt_user->items[0]->statistics->viewCount), $info['views_count']['channel_name']))), self::$name, $info['views_count']['channel_id']);
				}
			}
		}
	}
}
?>