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

class weather
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
		global $query, $server_info, $language, $AutoSpeak, $logs_manager;

		$lang = $language['function']['weather'];
		
		foreach(self::$cfg['info'] as $channel_id => $info)
		{
			$result = json_decode(file_get_contents('http://api.openweathermap.org/data/2.5/weather?q='.$info['city'].','.$info['country_code'].'&appid='.self::$cfg['api_key']), true);
			
			if(isset($result['cod']))
			{
				$weather_info = str_replace(['Thunderstorm', 'Drizzle', 'Rain', 'Snow', 'Atmosphere', 'Clear', 'Clouds', 'Extreme', 'Additional'], ['Burza z piorunami', 'Mżawka', 'Deszcz', 'Śnieg', 'Zanieczyszczona Atmosfera', 'Czyste niebo', 'Chmury', 'Ekstremalna pogoda np. tornada', 'Dodatkowa pogoda np. sztormy'], $result['weather'][0]['main']);
				
				$desc = "[center] [hr][size=14][b]".$lang['weather']." - [i][url=https://openweathermap.org/city/".$result['id']."]".$info['city']."[/url][/i][/b][/size][hr][/center][center][img]http://openweathermap.org/img/w/".$result['weather'][0]['icon'].".png[/img][/center][hr][list][*]| | [size=10][b]".$lang['temperature'].": [I][COLOR=#ff5500]".round($result['main']['temp'] - 273)."°[/COLOR][/I][/b][/size]\n[*]|  | [size=10][b]".$lang['status'].": [I][COLOR=#ff5500]".$weather_info."[/COLOR][/I][/b][/size]\n[*]|  | [size=10][b]".$lang['speed'].": [I][COLOR=#ff5500]".$result['wind']['speed']." m/s[/COLOR][/I][/b][/size][*]| | [size=10][b]".$lang['pressure'].": [I][COLOR=#ff5500]".$result['main']['pressure']." hPa[/COLOR][/I][/b][/size][*]| | [size=10][b]".$lang['humidity'].": [I][COLOR=#ff5500]".$result['main']['humidity']."%[/COLOR][/I][/b][/size]".(isset($result['visibility']) ? "[*]| | [size=10][b]".$lang['visibility'].": [I][COLOR=#ff5500]".$result['visibility']." m[/COLOR][/I][/b][/size]" : "")."[/list]";
			}
			else
			{
				$desc = $language['function']['error']['api'];
				$logs_manager::write_info(" [".self::$name."] API ERROR");
			}
			
			$desc .= $language['function']['down_desc'];
			
			if($AutoSpeak::check_channel_desc($channel_id, $desc))
				if($AutoSpeak::check_error($query->channelEdit($channel_id, array('channel_description' => $desc)), self::$name, $channel_id, true))
					$query->channelEdit($channel_id, array('channel_name' => str_replace('[CITY]',$info['city'],$info['channel_name'])));
		}
	}
}
?>