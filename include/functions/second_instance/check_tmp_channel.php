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

class check_tmp_channel
{
	private static $name;
	private static $cfg;
	private static $bad_phrases;
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
		$bad_phrases_file = fread(fopen(self::$cfg['file'], "r"), filesize(self::$cfg['file']));
		self::$bad_phrases = explode(",", str_replace(' ', '', strtolower($bad_phrases_file)));
	}

	static public function before_clients()
	{
		global $query, $language;

		$i=0;

		foreach($query->getElement('data', $query->channelList("-flags")) as $channel)
		{
			if($channel['channel_flag_permanent'] != 1 && $channel['channel_flag_semi_permanent'] != 1)
			{
				$i++;

				foreach(self::$bad_phrases as $bad_phrase)
					if($bad_phrase != "" && strpos(strtolower($channel['channel_name']), $bad_phrase) !== false)
						$query->channelEdit($channel['cid'], array('channel_name' => $i.". ".$language['function']['channels_guard']['bad_name']));
			}	
		}
	}
}
?>