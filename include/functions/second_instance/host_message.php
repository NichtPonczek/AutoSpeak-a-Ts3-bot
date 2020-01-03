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

class host_message
{
	private static $lang;
	private static $name;
	private static $cfg;
	
	public static function construct($plugin_name)
	{
		global $cfg;
		self::$cfg = $cfg[$plugin_name];
		self::$name = $plugin_name;
	}

	private static function replace($message)
	{
		global $server_info, $AutoSpeak;

		$edited_message = array
		(
			'[SERVER_MAX_CLIENTS]' => $server_info['virtualserver_maxclients'],
			'[SERVER_ONLINE]' => $server_info['virtualserver_clientsonline'] - $server_info['virtualserver_queryclientsonline'],
			'[SERVER_NAME]' => $server_info['virtualserver_name'],
			'[SERVER_UPTIME]' => $AutoSpeak::convert_time($server_info['virtualserver_uptime'])
			
		);
		return str_replace(array_keys($edited_message), array_values($edited_message), $message);
	}

	public static function before_clients()
	{
		global $query, $language, $server_info;
		
		self::$lang = $language['function']['connect_message'];
		$host_message = self::replace($language['function']['host_message']);

		if($server_info['virtualserver_hostmessage'] != $host_message)
			$query->serverEdit(array('virtualserver_hostmessage' => $host_message));
	}
}
?>