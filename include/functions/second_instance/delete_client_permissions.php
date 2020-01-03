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

class delete_client_permissions
{
	private static $lang;
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}
	
	static public function every_client($client)
	{
		global $query, $AutoSpeak, $language;
		
		if(!$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']) && !in_array($client['client_database_id'], self::$cfg['ignored_dbids']))
		{
			$to_delete = array();
			$client_perms = $query->getElement('data', $query->clientPermList($client['client_database_id'], true));
			$perms = "";
			
			if(empty($client_perms))
				return;
				
			foreach($client_perms as $perm)
				if(!in_array($perm['permsid'], self::$cfg['ignored_perms']))
				{
					$to_delete[] = $perm['permsid'];
					$perms .= "[b]".$perm['permsid']."[/b], ";
				}
			
			if(!empty($to_delete))
			{
				$query->clientDelPerm($client['client_database_id'], $to_delete);
				$query->sendMessage(1, $client['clid'], str_replace('[PERMS]', $perms, $language['function']['delete_client_permissions']));
			}
		}
	}
}
?>