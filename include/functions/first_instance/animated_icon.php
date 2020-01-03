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

class animated_icon
{
	private static $name;
	private static $cfg;
	private static $index = array();
	
	static public function construct($plugin_name)
	{
		global $cfg;
		self::$cfg = $cfg[$plugin_name];
		self::$name = $plugin_name;
		
		foreach(self::$cfg['info'] as $i => $info)
			self::$index[$i] = 0;		
	}

	static public function before_clients()
	{
		global $query;
		
		foreach(self::$cfg['info'] as $id => $info)
		{
			if($info['type'] == 'cldbid')
				$query->clientAddPerm($id, array(ICON_ID => array($info['icons'][self::$index[$id]], 1)));
			else
				$query->serverGroupAddPerm($id, array(ICON_ID => array($info['icons'][self::$index[$id]], 1, 0)));
			
			self::$index[$id] = (self::$index[$id]+1)%count($info['icons']);
		}
	}
}
?>