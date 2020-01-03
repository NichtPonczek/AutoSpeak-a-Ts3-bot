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

class cache_icons
{
	private static $name;
	private static $cfg;
	private static $ip;
	
	static public function construct($event_name)
	{
		global $cfg, $connect;
		
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
		self::$ip = $connect['IP'];
	}

	static public function before_clients()
	{
		global $query, $logs_manager;	

		$icons = $query->getElement('data', $query->ftGetFileList(0,'','/icons'));
		$icons_in_dir = array();
		
		if(is_dir(self::$cfg['icons_path']))
			$handler = @opendir(self::$cfg['icons_path']);
		else
			if(@mkdir(self::$cfg['icons_path'], 0777))
				$handler = @opendir(self::$cfg['icons_path']);
				
		while($date = readdir($handler))
			$icons_in_dir[] = $date;
		
		foreach($icons_in_dir as $icon_dir)
		{
			$found = false;
			$icon_dir = explode('.', $icon_dir);
			
			foreach($icons as $icon)
				if($icon['name'] == $icon_dir[0])
				{
					$found = true;
					break;
				}
			
			if(!$found)
				@unlink(self::$cfg['icons_path'].$icon_dir);
		}
		
		foreach($icons as $key => $info)
		{
			if(substr($info['name'], 0, 5)=='icon_')
			{
				$icon_download = $query->ftInitDownload("/".$info['name'], 0);
				$data = '';
				
				if($icon_download['success'])
				{
					$connection = @fsockopen(self::$ip, $icon_download['data']['port'], $errnum, $errstr, 10);
					if($connection)
					{
						fputs($connection, $icon_download['data']['ftkey']);
						$data='';
						while(!feof($connection)) 
							$data .= fgets($connection, 4096);

						$handler2 = @fopen(self::$cfg['icons_path'].$info['name'].".png", "w+");
						if($handler2!==false)
						{
							fwrite($handler2, $data);
							fclose($handler2);
						}
						else
						{
							$logs_manager::write_info("[".self::$name."] - error while opening file: ".self::$cfg['icons_path'].$info['name'].".png");
							break;
						}
					}
					else
					{
						$logs_manager::write_info("[".self::$name."] - error while connecting to server: ".self::$ip);
						break;
					}
						
				}
			}
		}
	}
}
?>