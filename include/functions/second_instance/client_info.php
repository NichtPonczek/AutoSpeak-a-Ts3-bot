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

class client_info
{
	private static $lang;
	private static $name;
	private static $cfg;
	
	static public function construct($plugin_name)
	{
		global $cfg;
		self::$cfg = $cfg[$plugin_name];
		self::$name = $plugin_name;
	}

	static private function conver_to_date($seconds)
	{
		return date('d-m-Y G:i', $seconds);
	}
	
	static private function replace($message, $client_info)
	{
		global $query, $AutoSpeak;
		
		$edited_message = array
		(
			'[CLIENT_IP]' => $client_info['connection_client_ip'],
			'[CLIENT_NICK]' => $client_info['client_nickname'],
			'[CLIENT_COUNTRY]' => $client_info['client_country'],
			'[CLIENT_DBID]' => $client_info['client_database_id'],
			'[CLIENT_VERSION]' => $client_info['client_version'],
			'[CLIENT_CONNECTIONS]' => $client_info['client_totalconnections'],
			'[CLIENT_PLATFORM]' => $client_info['client_platform'],
			'[CLIENT_TOTALCONNECTIONS]' => $client_info['client_totalconnections'],
			'[CLIENT_LASTCONNECTED]' => self::conver_to_date($client_info['client_lastconnected']),
			'[CLIENT_AWAY_MESSAGE]' => $client_info['client_away_message'],
			'[CLIENT_CREATED]' => self::conver_to_date($client_info['client_created']),
			'[CLIENT_ON_SERVER_FOR]' =>  $AutoSpeak::convert_time($client_info['client_lastconnected'] - $client_info['client_created']),
		);
		return str_replace(array_keys($edited_message), array_values($edited_message), $message);
	}

	static public function main($client)
	{
		global $query, $language;

		self::$lang = $language['function']['connect_message'];
			
		$client_info = $query->getElement('data', $query->clientInfo($client['clid']));

		$message_to_send = explode('\n', self::replace(self::$cfg['message'], $client_info));

		foreach($message_to_send as $mess)
			$query->clientPoke($client['clid'], $mess);

		$query->clientKick($client['clid'], "channel");
	}
}
?>