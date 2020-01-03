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
class anty_vpn
{
	private static $name;
	private static $cfg;
	private static $self_ip;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
		self::$self_ip = exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'");
	}
	static private function has_allowed_ip($ip)
	{
		if($ip == self::$self_ip || in_array($ip, self::$cfg['allowed_ips']))
			return true;
		else
			return false;
	}
	
	static private function has_vpn($ip)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://v2.api.iphub.info/ip/".$ip);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		$headers = [
   		 'X-Key: '.self::$cfg['X-Key'],
       		];
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$server_output = json_decode(curl_exec($ch));
		curl_close ($ch);
		if(isset($server_output->block) && $server_output->block == 1 && !self::has_allowed_ip($ip))
			return true;
		else
			return false;
	}
	static public function clients_different()
	{
		global $query, $difference, $AutoSpeak;	
		
		if(count($difference) > 0)
		{
			foreach($difference as $cli)
			{
				$client = $query->getElement('data', $query->clientInfo($cli));
				if(!$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']) && self::has_vpn($client['connection_client_ip']))
				{
					switch(self::$cfg['type'])
					{
						case 'poke':
							$query->clientPoke($cli, self::$cfg['message_to_client']);
							break;
						case 'kick':
							$query->clientKick($cli, "server", self::$cfg['message_to_client']);
							break;
						case 'ban':
							$query->banClient($cli, self::$cfg['ban_time'], self::$cfg['message_to_client']);
							break;
					}	
					
					$AutoSpeak::set_action(self::$name, array('clid' => $cli));
				}
			}
		}
	}
}
?>
