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

class bot
{
	private static $name;
	private static $cfg;
	
	static public function construct($command_name)
	{
		global $cfg;
		self::$cfg = $cfg[$command_name];
		self::$name = $command_name;
	}	

	static public function main($info)
	{
		global $query, $AutoSpeak, $language, $all_instances;		

		$instance = $info['parameters'][0][1];

		if($instance != "all" && (!is_numeric($instance) || $instance > $all_instances))
		{		
			$AutoSpeak::send_to_client($info['clid'], "bad_instance", $instance);
			return;
		}

		$query->sendMessage(1,$info['clid'],$language['command']['success_bot']);
		
		if($instance != "all")
		{
			shell_exec("screen -S AutoSpeak_instance_".$instance." -X quit");
			shell_exec("screen -dmS AutoSpeak_instance_".$instance." php core.php -i ".$instance);
		}
		else
			shell_exec("./starter.sh restart");
	}
}
?>
