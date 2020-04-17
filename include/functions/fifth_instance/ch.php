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

class ch
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
		global $query, $language;

		$sub_channels = $info['parameters'][0][2];

		foreach($query->getElement('data', $query->clientList("-uid")) as $client)
			if($client['client_database_id'] == $info['parameters'][0][1])
				break;

		$lang = $language['function']['get_private_channel'];
		$has_channel = false;
		$give_channel = false;

		if(self::$cfg['message_type'] == 'poke')
			$poke = true;
		else
			$poke = false;

		$cgcl = $query->getElement('data', $query->channelGroupClientList(NULL, $client['client_database_id']));
		foreach($cgcl as $once_cgcl)
		{
			if($once_cgcl['cldbid'] == $client['client_database_id'] && $once_cgcl['cgid'] == self::$cfg['head_channel_admin_group'])
			{
				$has_channel = true;
				if($poke)
					$query->clientPoke($client['clid'], $lang['has_channel']);
				else
					$query->sendMessage(1, $client['clid'], $lang['has_channel']);

				$query->sendMessage(1, $info['clid'], $language['command']['ch']['has_channel']);
				$query->clientMove($client['clid'], $once_cgcl['cid']);

				break;
			}
		}
		if(!$has_channel)
		{
			$number = 0;
			foreach($query->getElement('data', $query->channelList("-topic -limits -flags")) as $channel)
			{
				if(!$give_channel && $channel['pid'] == self::$cfg['channels_zone'])
				{						
					$number++;
					if($channel['channel_topic'] == self::$cfg['empty_channel_topic'])
					{
						if($poke)
							$query->clientPoke($client['clid'], $lang['get_channel']);
						else
							$query->sendMessage(1, $client['clid'], $lang['get_channel']);

						$query->sendMessage(1, $info['clid'], $language['command']['ch']['success'].$sub_channels);
							
						$message = "\n[b]".$lang['hi'].$client['client_nickname']."![/b]\n";
						$message .= $lang['channel_created']."[b]".$number."[/b]\n".$lang['default_pass']."\n[color=green]".$lang['gl&hf']."[/color]";
						
						$query->sendMessage(1, $client['clid'], $message);
						$query->clientMove($client['clid'], $channel['cid']);
						$query->setClientChannelGroup(self::$cfg['head_channel_admin_group'], $channel['cid'], $client['client_database_id']);

						$data = date('d-m-Y');
						$desc_main = "[center][size=15][b]".$lang['private_channel'].$number.$lang['not_empty']."[/b][/size][/center]\n";
						$desc_main .= "[left] ● [size=11][b]".$lang['owner']."[URL=client://2/".$client['client_unique_identifier']."]".$client['client_nickname']."[/url][/b][/size][/left][left] ● [size=11][b]".$lang['created']."".$data."\n[/b][/size][/left]\n".$language['function']['down_desc'];

						if(strlen($client['client_nickname']) >=20 )
							$name = $number.". ".$language['function']['get_private_channel']['channel_name'];
						else
							$name = $number.". ".$language['function']['get_private_channel']['channel_name'].$client['client_nickname'];

						$query->channelEdit($channel['cid'], array
						(
							'channel_name' => $name,
							'channel_description' => $desc_main,
							'channel_topic' => $data,
							'channel_flag_maxclients_unlimited'=>1, 
							'channel_flag_maxfamilyclients_unlimited'=>1, 
							'channel_flag_maxfamilyclients_inherited'=>0,
							'channel_maxclients' => 1,
							'channel_maxfamilyclients' => 1,
							'channel_password' => '123',
						));
						
						$desc_sub = $lang['sub_channel']."[/b][/size][/center]\n";
						$desc_sub .= "\n[size=11][b]".$lang['owner']."[/b]".$client['client_nickname']."[/size]\n\n\n".$language['function']['down_desc_img'];
						for($i=0; $i<$sub_channels; $i++)
						{
							$num = $i;
							$num++;
							$query->channelCreate(array
							(
								'channel_flag_permanent' => 1, 
								'cpid' => $channel['cid'], 
								'channel_name' => $num.$language['function']['get_private_channel']['sub_channel'], 
								'channel_flag_maxclients_unlimited' => 1, 
								'channel_flag_maxfamilyclients_unlimited' => 1,
								'channel_password' => '123',
								'channel_description' => "[center][size=15][b]".$num.$desc_sub,
							));
						}

						$give_channel = true;
						break;
					}
				}
			}
			if(!$give_channel)
				$query->sendMessage(1, $info['clid'], $lang['no_empty']);
		}
	}
}
?>
