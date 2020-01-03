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

class connect_message
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
		global $query, $server_info, $AutoSpeak;

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
			
			'[SERVER_MAX_CLIENTS]' => $server_info['virtualserver_maxclients'],
			'[SERVER_ONLINE]' => $server_info['virtualserver_clientsonline'] - $server_info['virtualserver_queryclientsonline'],
			'[SERVER_CHANNELS]' => $server_info['virtualserver_channelsonline'],
			'[SERVER_ID]' => $server_info['virtualserver_id'],
			'[SERVER_PORT]' => $server_info['virtualserver_port'],
			'[SERVER_NAME]' => $server_info['virtualserver_name'],
			'[SERVER_VERSION]' => $server_info['virtualserver_version'],
			'[SERVER_VUI]' => $server_info['virtualserver_unique_identifier'],
			'[SERVER_WELCOME_MESSAGE]' => $server_info['virtualserver_welcomemessage'],
			'[SERVER_PLATFORM]' => $server_info['virtualserver_platform'],
			'[SERVER_HOSTMESSAGE]' => $server_info['virtualserver_hostmessage'],
			'[SERVER_UPTIME]' => $AutoSpeak::convert_time($server_info['virtualserver_uptime'])
			
		);
		return str_replace(array_keys($edited_message), array_values($edited_message), $message);
	}

	static public function clients_different()
	{
		global $query, $difference, $language, $AutoSpeak;

		self::$lang = $language['function']['connect_message'];

		if($difference != NULL)
		{
			$message = fread(fopen(self::$cfg['file'], "r"), filesize(self::$cfg['file']));
			if(self::$cfg['many_messages'])
				$message_to_send = array();
			
			foreach($difference as $client)
			{
				$client_info = $query->getElement('data', $query->clientInfo($client));

				if(count(self::$cfg['to_groups']) > 0 && self::$cfg['to_groups'][0] != -1 && !$AutoSpeak::has_group($client_info['client_servergroups'], self::$cfg['to_groups']))
					continue;

				if(self::$cfg['many_messages'])
				{
					$message_to_send = explode("\n", self::replace($message, $client_info));
					foreach($message_to_send as $mess)
						$query->sendMessage(1, $client, $mess);
				}
				else
					$query->sendMessage(1, $client, self::replace($message, $client_info));
			}
		}
	}
}
?>