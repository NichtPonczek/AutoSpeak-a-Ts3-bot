<?php
	
  /********************************
  
          AutoSpeak_info
                                  
	********************************/

class AutoSpeak_info
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
		global $query, $AutoSpeak, $info_on_server, $language, $all_instances;
		
		$lang = $language['function']['AutoSpeak_info'];
		
		if(self::$cfg['translate']['enabled'])
			$traductor = new Stichoza\GoogleTranslate\TranslateClient('pl', self::$cfg['translate']['target_language']);
		else
			$traductor = NULL;
		
		$desc = "[hr][center][size=14][b]".$lang['instances_info']."[/b][/size][/center][hr][size=9][list]";
		$memory_usage = json_decode(file_get_contents("include/cache/memory_usage.txt"), 1);
		$count_memory_usage = 0;
		
		for($i=1; $i<=$all_instances; $i++)
		{
			if(shell_exec('if screen -list | grep -q "AutoSpeak_instance_'.$i.'" ; then echo "1"; else echo "0"; fi') == 1)
			{
				$desc .= "[*] [b]".$lang['instance']." ".$i."[/b] - • [b][COLOR=#00bd00]ON[/COLOR] • [B]Ram[/B] - [B]".(isset($memory_usage[$i]) ? self::convert_memory($memory_usage[$i]) : $lang['no_info'])."[/B]\n";
				
				if(isset($memory_usage[$i]))
					$count_memory_usage += $memory_usage[$i];	
			}
			else
				$desc .= "[*] [b]".$lang['instance']." ".$i."[/b] - • [b][COLOR=#ff0000]OFF[/COLOR] •\n";
		}
		
		if(shell_exec('if screen -list | grep -q "AutoSpeak_run" ; then echo "1"; else echo "0"; fi') == 1)
			$desc .= "[*] [b]AutoSpeak run[/b] - • [b][COLOR=#00bd00]ON[/COLOR] •\n";
		else
			$desc .= "[*] [b]AutoSpeak run[/b] - • [b][COLOR=#ff0000]OFF[/COLOR] •\n";
		
		$desc .= "[/list]\n";
		
		$desc .= " [b]".$lang['total_ram']." - ".self::convert_memory($count_memory_usage)."[/b][/size]\n";
		
		$desc .= "[hr][center][size=14][b]".$lang['info_from_server']."[/b][/size][/center]";
		
		
		if(empty($info_on_server))
			$desc .= $lang['no_info'].".";
		else
			foreach($info_on_server as $info)
				$desc .= "[hr]\n[size=9]■ ".(self::$cfg['translate']['enabled'] ? $traductor->translate($info['text']) : $info['text'])."[/size] [right][i]".$info['date']."[/i][/right]";
		
		$desc .= $language['function']['down_desc'];
		
		$query->channelEdit(self::$cfg['channel_id'], array('channel_description' => $desc));
	}
}
?>
