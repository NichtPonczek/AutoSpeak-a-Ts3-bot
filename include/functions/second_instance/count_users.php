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

class count_users
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}

	static private function replace_name($name, $all, $un)
	{
		$edited_name = array
		(
			'[REG]' => $all - $un,
			'[TOTAL]' => $all,
		);

		return str_replace(array_keys($edited_name), array_values($edited_name), $name);
	}
	
	static public function before_clients()
	{
		global $query, $query_sql, $AutoSpeak;	

		$result = $query_sql->query("SELECT * FROM clients");
		$clients_all = $result->rowCount();
		$result = $query_sql->query("SELECT * FROM clients WHERE server_groups='".self::$cfg['unregistered_group_id']."'");
		$unregistered = $result->rowCount();

		$AutoSpeak::check_error($query->channelEdit(self::$cfg['channel_id'], array('channel_name' => self::replace_name(self::$cfg['channel_name'], $clients_all, $unregistered))), self::$name, self::$cfg['channel_id'], true);
	}
}
?>