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

class servers_info
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}
	
	static private function replace($name, $vars)
	{
		$edited_name = array
		(
			'[NAME]' => $vars['name'],
			'[CLIENTS_ONLINE]' => $vars['users'],
			'[CLIENTS_MAX]' => $vars['max_users'],
			'[MAP]' => $vars['map'],
			'[VERSION]' => $vars['ver'],
		);

		return str_replace(array_keys($edited_name), array_values($edited_name), $name);
	}
	
	static private function delete_motd($motd_text)
	{
		$output_text = "";
		$motd_text = mb_convert_encoding($motd_text,'HTML-ENTITIES');
		
		for($i=0; $i<strlen($motd_text); $i++)
		{
			if( $motd_text[$i] == '&' && 
				$motd_text[$i+1] == 'A' && 
				$motd_text[$i+2] == 'c' && 
				$motd_text[$i+3] == 'i' && 
				$motd_text[$i+4] == 'r' && 
				$motd_text[$i+5] == 'c' && 
				$motd_text[$i+6] == ';') 
			{
				$i+=6; 
			}
			elseif( $motd_text[$i] == '&' && 
				$motd_text[$i+1] == 's' && 
				$motd_text[$i+2] == 'e' && 
				$motd_text[$i+3] == 'c' && 
				$motd_text[$i+4] == 't' && 
				$motd_text[$i+5] == ';') 
			{
				$i+=6; 
			}
			else $output_text .= $motd_text[$i];
		}
		
		return $output_text;
	}

	static public function before_clients()
	{
		global $query, $language, $AutoSpeak;
	
		foreach(self::$cfg['info'] as $info)
		{
			$gq = new \GameQ\GameQ();
			
			$index = $info['type'];

			try 
			{
				 $gq->addServer(array(
        				'type' => $index,
        				'host' => $info['host'],
				));
			}
			catch(\GameQ\UserException $e) 
			{
  	  			echo "addServer exception: " . $e->getMessage();
			}
			
			$gq->setOption("curl_connect_timeout", 1000);
			$gq->setOption("connect_timeout", 1);
	
			$results = $gq->process();
			
			$desc = "[hr][center][size=18]".$results[$info['host']]['gq_name']."[/size][/center][hr]\n";
			
			$online = $results[$info['host']]['gq_online'];
			$server = array();

			if($online)
			{
				$server['name'] = $results[$info['host']]['hostname'];
				$server['users'] = $results[$info['host']]['gq_numplayers'];
				$server['max_users'] = $results[$info['host']]['gq_maxplayers'];
				$server['map'] = NULL;
				$server['ver'] = NULL;

				$desc .= "● [size=13] ".($info['custom_server_name'] != "0" && $info['custom_server_name'] != "" ? $info['custom_server_name'] : ($index != "minecraft" ? $server['name'] : self::delete_motd($server['name'])))."[/size][list][*][size=9][b]Online: ".$server['users']."/".$server['max_users']."[/b][/size][/list]";

				if($index != "minecraft")
				{
					$server['map'] = $results[$info['host']]['map'];
					$desc .= "[list][*][size=9] [b]Mapa: ".$server['map']."[/b][/size][/list]";
				}
				
				$server['ver'] = $results[$info['host']]['version'];
				$desc .= "[list][*] [size=9][b]Wersja: ".$server['ver']."[/b][/size][/list]";

				$channel_name = self::replace($info['channel_name'], $server);
			}
			else
			{
				$channel_name = $index." server Offline";
				$desc .= "[list][*] [size=9][b]Server OFFLINE[/b] [/size][/list]\n";
			}
		
			$desc .= $language['function']['down_desc'];
			$AutoSpeak::check_error($query->channelEdit($info['channel_id'], array('channel_name' => $channel_name, 'channel_description' => $desc)), self::$name, $info['channel_id']);
	
			unset($gq);
		}
	}
}
?>