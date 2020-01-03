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

class help
{
	private static $name;
	private static $cfg;
	
	static public function construct($command_name)
	{
		global $cfg;
		self::$cfg = $cfg;
		self::$name = $command_name;
	}	

	static public function find_group_name(array $groups)
	{
		global $query;

		$group_names = array();
		$groups_list = $query->getElement('data', $query->serverGroupList());
	
		foreach($groups as $admin_group)
			foreach($groups_list as $group_info)
				if($group_info['sgid'] == $admin_group)
					array_push($group_names, $group_info['name']);

		return $group_names;
	}

	static public function main($info)
	{
		global $query, $commands, $language;

		$lang = $language['command']['help'];

		foreach($commands as $command)
		{
			if($command != 'hi')
			{
				$message = "[b][color=blue]!".$command."[/color][/b]\n";
				$message .= "[b]".$lang['privileged']."[/b]";
				foreach(self::find_group_name(self::$cfg[$command]['privileged_groups']) as $name)
					$message .= $name.", ";

				$message .= "\n[b]".$lang['inf']."[/b]".$lang['info'][$command]."\n";
				$message .= "[b]".$lang['us']."[/b]".$lang['usage'][$command]."\n";
				
				$query->sendMessage(1,$info['clid'],$message);
			}
		}
	}
}
?>