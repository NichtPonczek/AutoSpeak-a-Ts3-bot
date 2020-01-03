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
class multi_function
{
	private static $name;
	private static $cfg;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}
	
	static private function convert_memory($size)
	{
		$unit=array('b','kb','mb','gb','tb','pb');
		return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}
	
	static public function before_clients()
	{
		global $server_info, $query, $AutoSpeak;

		if(self::$cfg['content']['total_ping']['enabled'])
		{
			$ping = $server_info['virtualserver_total_ping'];
			$function = self::$cfg['content']['total_ping'];
			if($function['integer'])
			{
				$ping = explode(".", $ping);
				$ping = $ping[0];
			}

			$AutoSpeak::check_error($query->channelEdit($function['channel_id'], array('channel_name' => str_replace("[PING]", $ping, $function['channel_name']))), self::$name, $function['channel_id']);
		}

		if(self::$cfg['content']['packet_loss']['enabled'])
		{
			$packet_loss = $server_info['virtualserver_total_packetloss_total'];
			$function = self::$cfg['content']['packet_loss'];
			if($function['integer'])
			{
				$packet_loss = explode(".", $packet_loss);
				$packet_loss = $packet_loss[0];
			}
			
			$AutoSpeak::check_error($query->channelEdit($function['channel_id'], array('channel_name' => str_replace("[PACKETLOSS]", $packet_loss, $function['channel_name']))), self::$name, $function['channel_id']);
		}
		if(self::$cfg['content']['channels_count']['enabled'])
		{
			$channels = $server_info['virtualserver_channelsonline'];
			$function = self::$cfg['content']['channels_count'];

			$AutoSpeak::check_error($query->channelEdit($function['channel_id'], array('channel_name' => str_replace("[CHANNELS]", $channels, $function['channel_name']))), self::$name, $function['channel_id']);
		}
		if(self::$cfg['content']['bytes_upload']['enabled'])
		{
			$upload = $server_info['virtualserver_total_bytes_uploaded'];
			$function = self::$cfg['content']['bytes_upload'];
			
			if($upload != 0)
				$upload = self::convert_memory($upload);
			else
				$upload = "0b";

			$AutoSpeak::check_error($query->channelEdit($function['channel_id'], array('channel_name' => str_replace("[UPLOAD]", $upload, $function['channel_name']))), self::$name, $function['channel_id']);
		}
		if(self::$cfg['content']['bytes_download']['enabled'])
		{
			$download = $server_info['virtualserver_total_bytes_downloaded'];
			$function = self::$cfg['content']['bytes_download'];
			
			if($download != 0)
				$download = self::convert_memory($download);
			else
				$download = "0b";

			$AutoSpeak::check_error($query->channelEdit($function['channel_id'], array('channel_name' => str_replace("[DOWNLOAD]", $download, $function['channel_name']))), self::$name, $function['channel_id']);
		}
	}
}
?>