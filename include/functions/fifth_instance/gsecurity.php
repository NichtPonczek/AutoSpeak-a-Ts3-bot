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

class gsecurity
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
		global $query, $language, $AutoSpeak, $cfg;
	
		$lang = $language['command']['gsecurity'];
		$msg = '';
		
		if(!in_array($info['parameters'][0][3], self::$cfg['admins_groups']))
		{
			$query->sendMessage(1, $info['clid'], $lang['wrong_group']);
			return;
		}

		if($info['parameters'][0][1] != 'add' && $info['parameters'][0][1] != 'del')
		{
			$query->sendMessage(1, $info['clid'], $lang['wrong_type']);
			return;
		}
		
		$cache = json_decode(file_get_contents("include/cache/groups_security.txt"), true);
		$deleted = false;
		
		if(!empty($cache))
			foreach($cache as $sgid => $users)
			{
				if(!in_array($sgid, self::$cfg['admins_groups']))
				{
					unset($cache[$sgid]);
					continue;
				}
				
				if(in_array($info['parameters'][0][2], $users))
				{
					foreach($users as $index => $cldbid)
						if($cldbid == $info['parameters'][0][2])
						{
							unset($cache[$sgid][$index]);
							$deleted = true;
							break;
						}
				}
			}
		
		$client = $query->getElement('data', $query->clientDbInfo($info['parameters'][0][2]));
		
		if($info['parameters'][0][1] == 'add')
		{
			$cache[$info['parameters'][0][3]][] = $info['parameters'][0][2];
			$query->serverGroupAddClient($info['parameters'][0][3], $info['parameters'][0][2]);
			$msg = str_replace(array('[NICK]', '[SGID]'), array($client['client_nickname'], $info['parameters'][0][3]), $lang['added']);
		}
		else
		{
			if($deleted)
			{
				$query->serverGroupDeleteClient($info['parameters'][0][3], $info['parameters'][0][2]);
				$msg = str_replace(array('[NICK]', '[SGID]'), array($client['client_nickname'], $info['parameters'][0][3]), $lang['deleted']);
			}
			else
				$msg = str_replace('[NICK]', $client['client_nickname'], $lang['wrong_deleted']);
		}

		file_put_contents("include/cache/groups_security.txt", json_encode($cache)); 

		$query->sendMessage(1, $info['clid'], $msg);

	}
}
?>
