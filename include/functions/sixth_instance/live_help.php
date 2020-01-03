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

class live_help
{
	static public $addon = 'livehelp';
	static private $name;
	static private $cfg;
	static private $lang;
	static private $reg_groups = [];
	static private $start_date;
	static private $sinusbot;
	static private $tracks;

	static public function construct($event_name)
	{
		global $cfg;
		global $language;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
		self::$lang = $language[__CLASS__];

		foreach (self::$cfg['registration_groups'] as $info) {
			array_push(self::$reg_groups, $info['sgid']);
		}

		self::$cfg['registration_groups']['man']['command'] = '!m';
		self::$cfg['registration_groups']['woman']['command'] = '!k';
		self::$start_date = date('d-m-Y G:i:s');

		if (self::$cfg['sinusbot']['enabled']) {
			require 'include/classes/sinusbot.class.php';
			self::$sinusbot = new SinusBot(self::$cfg['sinusbot']['host']);
			self::$sinusbot->login(self::$cfg['sinusbot']['login'], self::$cfg['sinusbot']['password']);
			self::$sinusbot->selectInstance(self::$cfg['sinusbot']['instance_uid']);
			self::$tracks = self::$sinusbot->getPlaylistTracks(self::$cfg['sinusbot']['playlist_id']);

			foreach (self::$sinusbot->getQueueTracks() as $once) {
				self::$sinusbot->playNext();
			}

			self::$sinusbot->stop();
		}
	}

	static public function change_sb_name($name)
	{
		$settings = self::$sinusbot->getSettings();

		if ($settings['nick'] != $name) {
			self::$sinusbot->editSettings(['nick' => $name]);
		}
	}

	static private function sb_playing()
	{
		global $logs_manager;
		$status = self::$sinusbot->getStatus();
		if (!isset($status['playing']) && self::$cfg['sinusbot']['enabled']) {
			self::$sinusbot = NULL;
			self::$sinusbot = new SinusBot(self::$cfg['sinusbot']['host']);
			self::$sinusbot->login(self::$cfg['sinusbot']['login'], self::$cfg['sinusbot']['password']);
			self::$sinusbot->selectInstance(self::$cfg['sinusbot']['instance_uid']);
			self::$tracks = self::$sinusbot->getPlaylistTracks(self::$cfg['sinusbot']['playlist_id']);

			foreach (self::$sinusbot->getQueueTracks() as $once) {
				self::$sinusbot->playNext();
			}

			self::$sinusbot->stop();
		}

		if ($status['playing'] != 1) {
			return false;
		}
		else {
			return true;
		}
	}

	static private function has_group($cl_groups, $groups)
	{
		foreach ($groups as $group) {
			if (in_array($group, $cl_groups)) {
				return true;
			}
		}

		return false;
	}

	static private function check_limit($limit, $cl_gr, $sgids)
	{
		$i = 0;

		foreach ($cl_gr as $group) {
			if (in_array($group, $sgids)) {
				$i++;
			}
		}

		if ($i < $limit) {
			return true;
		}
		else {
			return false;
		}
	}

	static private function show_menu($clid, $registered)
	{
		global $cache_live_help;
		global $query;

		if (!self::$cfg['commands_enabled']) {
			return NULL;
		}

		$msg = self::$lang['header'];

		if ($cache_live_help[$clid]['status'] == 'help_admin') {
			$msg .= '[b][STATUS] - [color=green]' . self::$lang['wait_admin'] . '[/color][/b]' . "\n" . ' ' . "\n";
		}
		if (self::$cfg['server_groups']['enabled'] && $registered) {
			$msg .= '[b]!add [' . self::$lang['group_number'] . '][/b] - ' . self::$lang['add'] . "\n";
			$msg .= '[b]!del [' . self::$lang['group_number'] . '][/b] - ' . self::$lang['del'] . "\n";
			$msg .= '[b]!list[/b] - ' . self::$lang['list'] . "\n";
		}

		if (self::$cfg['faq']['enabled']) {
			$msg .= '[b]!faq[/b] - ' . self::$lang['faq'] . "\n";
		}

		if (self::$cfg['client_info']['enabled']) {
			$msg .= '[b]!my_info[/b] - ' . self::$lang['client_info'] . "\n";
		}
		if (self::$cfg['get_private_channel']['enabled'] && $registered) {
			$msg .= '[b]!channel[/b] - ' . self::$lang['channel'] . "\n";
		}
		if (self::$cfg['poke_admins']['enabled'] && self::$cfg['poke_admins']['with_command']['enabled']) {
			$msg .= "\n" . ' ' . "\n" . ' [b]' . self::$lang['help_commands'] . '[/b]' . "\n";

			foreach (self::$cfg['poke_admins']['with_command']['commands'] as $command => $info) {
				$msg .= "\t\t" . '[b]!' . $command . '[/b] - ' . $info['description'] . "\n";
			}

			if ($cache_live_help[$clid]['status'] == 'help_admin') {
				$msg .= '[b]!exit[/b] - ' . self::$lang['cancel_help'] . "\n";
			}
		}

		self::send_msg($clid, $msg);
	}

	static private function send_msg($clid, $msg, $menu = false)
	{
		global $query;

		if ($menu) {
			$msg .= ' ' . "\n" . '[b]!menu[/b] - ' . self::$lang['menu'] . "\n";
		}

		foreach (explode("\n", $msg) as $mes) {
			$query->sendMessage(1, $clid, $mes);
		}
	}

	static public function reset_cache()
	{
		global $query;
		global $clients;
		global $cache_live_help;
		$good_clids = [];

		if ($cache_live_help == NULL) {
			if (self::$cfg['sinusbot']['enabled']) {
				foreach (self::$sinusbot->getQueueTracks() as $once) {
					self::$sinusbot->playNext();
				}

				self::$sinusbot->stop();
			}

			return NULL;
		}

		foreach ($clients as $client) {
			if (!isset($client['clid'])) {
				$clid = $client['invokerid'];
			}
			else {
				$clid = $client['clid'];
			}
			if (in_array($clid, array_keys($cache_live_help)) && ($client['cid'] == self::$cfg['support_channel_id'])) {
				array_push($good_clids, $client['clid']);
			}
		}

		foreach ($cache_live_help as $key => $status) {
			if (!in_array($key, $good_clids)) {
				unset($cache_live_help[$key]);
			}
		}
	}

	static private function admin_on_channel($cid, $admin_rangs)
	{
		global $clients;
		global $cache_live_help;

		foreach ($clients as $client) {
			if (($client['client_database_id'] != 1) && ($client['cid'] == $cid) && !self::has_group(explode(',', $client['client_servergroups']), self::$cfg['poke_admins']['ignored_groups'])) {
				foreach (explode(',', $client['client_servergroups']) as $client_group) {
					if (in_array($client_group, $admin_rangs)) {
						foreach ($cache_live_help as $lh) {
							if ($lh['status'] == 'help_admin') {
								unset($lh);
							}
						}

						return true;
					}
				}
			}
		}

		return false;
	}

	static public function check_help_admin($command = 'none', $clid = 'none', $check = false, $more, &$admins = [], &$count = NULL, $poke = true)
	{
		global $query;
		global $server_info;
		global $clients;
		global $cache_live_help;
		global $language;
		$lang = $language['function']['poke_admins'];
		$config = self::$cfg['poke_admins'];
		$admin_groups = ($command == 'none' ? $config['admins_groups'] : $config['with_command']['commands'][$command]['admins_groups']);

		if ($clid != 'none') {
			$client_info = $query->getElement('data', $query->clientInfo($clid));
		}
		if ($check && self::admin_on_channel(self::$cfg['support_channel_id'], $config['admins_groups'])) {
			return NULL;
		}

		$count = 0;

		foreach ($admin_groups as $admin_group) {
			$clients_from_group = $query->getElement('data', $query->serverGroupClientList($admin_group));

			foreach ($clients_from_group as $client_from_group) {
				if (isset($client_from_group['cldbid']) && ($client_from_group['cldbid'] != 1)) {
					foreach ($clients as $client) {
						if (($client['client_database_id'] != 1) && ($client['client_database_id'] == $client_from_group['cldbid']) && !self::has_group(explode(',', $client['client_servergroups']), self::$cfg['poke_admins']['ignored_groups'])) {
							if (!in_array($client['cid'], $config['ignored_channels'])) {
								if ($poke) {
									$com = ($command != 'none' ? '(!' . $command . ')' : '');

									if ($config['show_client_link']) {
										$query->clientPoke($client['clid'], '[b][url=client://1/' . $client_info['client_unique_identifier'] . ']' . $client_info['client_nickname'] . '[/url][/b]');
										$query->clientPoke($client['clid'], '[color=red]' . $lang['wants_help'] . ' ' . $com . '[/color]');
									}
									else {
										$query->clientPoke($client['clid'], '[color=red][b]' . $client_info['client_nickname'] . '[/b][/color] ' . $lang['wants_help'] . ' ' . $com);
									}
								}

								if ($more) {
									$count++;
									array_push($admins, ['name' => $client['client_nickname']]);
								}
							}
						}
					}
				}
			}
		}
	}

	static private function poke_admins($clid, $command = NULL)
	{
		global $query;
		global $server_info;
		global $clients;
		global $cache_live_help;
		global $language;
		$lang = $language['function'][__FUNCTION__];
		$admins = [];
		$config = self::$cfg[__FUNCTION__];
		$client_info = $query->getElement('data', $query->clientInfo($clid));
		$message_for_client = (self::$cfg['commands_enabled'] ? "\n" . ' ' : '') . "\n" . '[b]' . self::$lang['help_status'] . '[/b]' . "\n";
		$prefix = "\t" . '» ';

		if (!isset($client_info['clid'])) {
			$client_info['clid'] = $clid;
		}
		if (array_key_exists($client_info['clid'], $cache_live_help) && ($cache_live_help[$client_info['clid']]['status'] == 'help_admin')) {
			self::send_msg($client_info['clid'], self::$lang['admin_informed']);
			return NULL;
		}
		if ((!$config['with_command']['enabled'] && !self::admin_on_channel(self::$cfg['support_channel_id'], $config['admins_groups'])) || ($config['with_command']['enabled'] && !self::admin_on_channel(self::$cfg['support_channel_id'], $config['with_command']['commands'][$command]['admins_groups']))) {
			$command = ($config['with_command']['enabled'] ? $command : 'none');
			self::check_help_admin($command, $clid, false, true, $admins, $count);
			if (array_key_exists($client_info['clid'], $cache_live_help) && ($cache_live_help[$client_info['clid']]['status'] != 'help_admin')) {
				if (0 < $count) {
					$message_for_client .= $prefix . $lang['in_this_moment'] . '[b]' . $count . '[/b]' . "\n";

					foreach ($admins as $admin) {
						$message_for_client .= "\t\t" . '[u]' . $admin['name'] . '[/u]' . "\n";
					}

					$message_for_client .= "\n" . ' ' . "\n\t" . '[color=green][b]' . $lang['help'] . '[/b][/color]';
				}
				else {
					$message_for_client .= $prefix . $lang['no_admins'] . ' :)' . "\n";
				}

				self::send_msg($client_info['clid'], $message_for_client);
				$cache_live_help[$client_info['clid']] = ['status' => 'help_admin', 'command' => $command];
			}
		}
		else {
			$message_for_client .= $prefix . self::$lang['admin_on_channel'];
			self::send_msg($clid, $message_for_client);

			if ($cache_live_help != NULL) {
				foreach ($cache_live_help as $user) {
					if ($user['status'] == 'help_admin') {
						unset($user);
					}
				}
			}
		}
	}

	static public function main($client)
	{
		global $query;
		global $cache_live_help;
		global $query_sql;
		$client_groups = explode(',', $client['client_servergroups']);

		if (self::has_group($client_groups, self::$cfg['ignored_groups'])) {
			return NULL;
		}

		if (!isset($client['clid'])) {
			$clid = $client['invokerid'];
		}
		else {
			$clid = $client['clid'];
		}

		if (isset($query_sql)) {
			$result = $query_sql->query('SELECT * FROM `clients` WHERE `client_dbid`=\'' . $client['client_database_id'] . '\'');
			$db = true;

			if ($result->rowCount() == 0) {
				$time_spent = 0;
			}
			else {
				$result = $result->fetch(PDO::FETCH_ASSOC);
				$time_spent = $result['time_spent'] / 60 / 1000;
			}
		}
		else {
			$db = false;
		}
		if (self::$cfg['registration_groups']['enabled'] && self::$cfg['commands_enabled'] && !self::has_group($client_groups, self::$reg_groups) && (!$db || (self::$cfg['registration_groups']['min_time'] == 0) || ($db && (self::$cfg['registration_groups']['min_time'] <= $time_spent)))) {
			if (self::$cfg['sinusbot']['enabled'] && !self::sb_playing()) {
				if (self::$cfg['sinusbot']['type'] != 385) {
					self::$sinusbot->playTrack(self::$tracks['entries'][0]['file']);
					self::$sinusbot->appendQueueTrack(self::$tracks['entries'][1]['file']);
					self::$sinusbot->appendQueueTrack(self::$tracks['entries'][2]['file']);
				}
				else {
					self::$sinusbot->playTrack(self::$tracks['entries'][9]['file']);
				}

				sleep(10);
			}

			$cache_live_help[$clid] = ['status' => 'registration'];
			self::send_msg($clid, self::$lang['not_registered'] . "\n" . '[b]!m[/b] - ' . self::$lang['reg_man'] . "\n" . '[b]!k[/b] - ' . self::$lang['reg_woman'] . "\n");
		}
		else {
			if (self::$cfg['sinusbot']['enabled'] && !self::sb_playing()) {
				if (self::$cfg['sinusbot']['type'] != 385) {
					self::$sinusbot->playTrack(self::$tracks['entries'][0]['file']);

					if (!isset($cache_live_help[$clid])) {
						self::$sinusbot->appendQueueTrack(self::$tracks['entries'][1]['file']);
					}
				}

				$admins = [];
				self::check_help_admin('none', 'none', false, true, $admins, $count, false);

				if (self::$cfg['sinusbot']['type'] != 385) {
					$delay = 9;

					if ($count == 0) {
						self::$sinusbot->appendQueueTrack(self::$tracks['entries'][6]['file']);
					}
					else {
						self::$sinusbot->appendQueueTrack(self::$tracks['entries'][3]['file']);

						if ($count <= 10) {
							self::$sinusbot->appendQueueTrack(self::$tracks['entries'][$delay + $count]['file']);
						}
						else {
							self::$sinusbot->appendQueueTrack(self::$tracks['entries'][9]['file']);
						}
						if (self::$cfg['poke_admins']['enabled'] && self::$cfg['poke_admins']['with_command']) {
							self::$sinusbot->appendQueueTrack(self::$tracks['entries'][4]['file']);
						}
						else {
							self::$sinusbot->appendQueueTrack(self::$tracks['entries'][5]['file']);
						}
					}

					self::$sinusbot->appendQueueTrack(self::$tracks['entries'][7]['file']);
					self::$sinusbot->appendQueueTrack(self::$tracks['entries'][8]['file']);
				}
				else {
					$delay = -1;

					if ($count == 0) {
						self::$sinusbot->playTrack(self::$tracks['entries'][8]['file']);
					}
					else {
						self::$sinusbot->playTrack(self::$tracks['entries'][3]['file']);

						if ($count <= 7) {
							self::$sinusbot->playTrack(self::$tracks['entries'][$delay + $count]['file']);
						}
						else {
							self::$sinusbot->playTrack(self::$tracks['entries'][7]['file']);
						}
					}

					self::$sinusbot->appendQueueTrack(self::$tracks['entries'][11]['file']);
				}
			}

			$cache_live_help[$clid] = ['status' => 'asked'];

			if (self::$cfg['commands_enabled']) {
				self::show_menu($clid, self::has_group($client_groups, self::$reg_groups));
			}

			if (!self::$cfg['poke_admins']['with_command']['enabled']) {
				self::poke_admins($clid);
			}
		}
	}

	static public function usage($clid, $uid, $msg)
	{
		global $query;
		global $cache_live_help;
		$client = $query->getElement('data', $query->clientInfo($clid));
		$client_groups = explode(',', $client['client_servergroups']);
		$cldbid = $client['client_database_id'];
		$registered = self::has_group($client_groups, self::$reg_groups);
		$command = substr($msg, 1);
		$message_to_client = '';
		$good = false;
		if (($client['cid'] != self::$cfg['support_channel_id']) || ($msg[0] != '!')) {
			return NULL;
		}
		if (isset($cache_live_help[$clid]) && ($cache_live_help[$clid]['status'] == 'registration')) {
			foreach (self::$cfg['registration_groups'] as $info) {
				if ($msg == $info['command']) {
					$query->serverGroupAddClient($info['sgid'], $cldbid);
					$query->sendMessage(1, $clid, self::$lang['registered']);
					$cache_live_help[$clid]['status'] = 'registered';
				}
			}

			return NULL;
		}
		if (($command == 'list') && self::$cfg['server_groups']['enabled'] && $registered) {
			$groups_all = $query->getElement('data', $query->serverGroupList());
			$groups = [];

			foreach ($groups_all as $group) {
				$groups[$group['sgid']] = $group;
			}

			unset($groups_all);
			$message_to_client .= '[b]' . self::$lang['group_list'] . '[/b]' . "\n";
			$message_to_client .= self::$lang['write'] . ' [b]!add [nr grupy][/b] lub [b]!del [numer grupy][/b]' . "\n";

			foreach (self::$cfg['server_groups']['info'] as $info) {
				$message_to_client .= ' ' . "\n" . '[u]' . $info['name'] . '[/u] limit: [color=red]' . $info['limit'] . '[/color]' . "\n";

				foreach ($info['server_groups'] as $group) {
					if (isset($groups[$group])) {
						$message_to_client .= '[b]' . $group . '[/b] - ' . $groups[$group]['name'] . (in_array($group, $client_groups) ? ' [color=green]✔[/color]' : '') . "\n";
					}
				}
			}

			$good = true;
		}
		else if (((substr($command, 0, 3) == 'add') || (substr($command, 0, 3) == 'del')) && $registered) {
			$selected_group = substr($command, 4);
			$find = false;

			foreach (self::$cfg['server_groups']['info'] as $info) {
				if (in_array($selected_group, $info['server_groups'])) {
					if (strstr($command, 'add') !== false) {
						if (self::check_limit($info['limit'], $client_groups, $info['server_groups'])) {
							$query->serverGroupAddClient($selected_group, $cldbid);
							$message_to_client = '[color=green]' . self::$lang['received_rang'] . '[/color]';
						}
						else {
							$message_to_client = '[color=red]' . self::$lang['limit'] . ' (Limit: ' . $info['limit'] . ')[/color]';
						}
					}
					else if (in_array($selected_group, $client_groups)) {
						$query->serverGroupDeleteClient($selected_group, $cldbid);
						$message_to_client = '[color=green]' . self::$lang['del_rang'] . '[/color]';
					}
					else {
						$message_to_client = self::$lang['not_have'];
					}

					$find = true;
				}
			}

			if (!$find) {
				$message_to_client = '[color=red]' . self::$lang['wrong_rang'] . '[/color]';
			}

			$good = true;
		}
		else if (($command == 'faq') && self::$cfg['faq']['enabled']) {
			$message_to_client .= '[b]FAQ[/b]' . "\n" . ' ' . "\n" . self::$cfg['faq']['info'];
			$good = true;
		}
		else if (($command == 'my_info') && self::$cfg['client_info']['enabled']) {
			$client_info = $query->getElement('data', $query->clientInfo($clid));
			$message_to_client .= '[b]' . self::$lang['info'] . '[/b]' . "\n" . ' ' . "\n";
			$message_to_client .= 'IP: ' . $client_info['connection_client_ip'] . "\n" . 'Platform: ' . $client_info['client_platform'] . "\n" . 'Unique ID: ' . $client_info['client_unique_identifier'] . "\n";
			$message_to_client .= 'DatabaseId: ' . $client_info['client_database_id'] . "\n" . 'Id: ' . $clid . "\n";
			$message_to_client .= self::$lang['version'] . ' ' . $client_info['client_version'] . "\n" . 'Nick: ' . $client_info['client_nickname'] . "\n" . self::$lang['country'] . ' ' . $client_info['client_country'] . "\n";
			$good = true;
		}
		else if (($command == 'exit') && self::$cfg['poke_admins']['enabled']) {
			$cache_live_help[$clid]['status'] = 'asked';
			$message_to_client .= '[b]' . self::$lang['success_exit'] . '[/b]';
			$good = true;
		}
		else if (($command == 'channel') && $registered) {
			self::get_private_channel($message_to_client, $clid, $cldbid, $client);
			$good = true;
		}
		else if ($command == 'menu') {
			self::show_menu($clid, $registered);
			$good = true;
			return NULL;
		}
		else if (self::$cfg['poke_admins']['enabled'] && self::$cfg['poke_admins']['with_command']['enabled']) {
			foreach (self::$cfg['poke_admins']['with_command']['commands'] as $com => $info) {
				if ($command == $com) {
					echo 'dasd';
					self::poke_admins($clid, $com);
					$good = true;
					break;
				}
			}
		}

		if (!$good) {
			$message_to_client .= '[b][u]' . self::$lang['wrong_command'] . '[/u][/b]';
		}

		self::send_msg($clid, $message_to_client, 1);
	}

	static private function get_private_channel(&$message_to_client, $clid, $cldbid, $client)
	{
		global $query;
		global $language;
		$lang = $language['function'][__FUNCTION__];
		$conf = self::$cfg[__FUNCTION__];
		$has_channel = false;
		$give_channel = false;
		$cgcl = $query->getElement('data', $query->channelGroupClientList(NULL, $cldbid));

		foreach ($cgcl as $once_cgcl) {
			if (($once_cgcl['cldbid'] == $cldbid) && ($once_cgcl['cgid'] == $conf['head_channel_admin_group'])) {
				$has_channel = true;
				$message_to_client .= $lang['has_channel'];
				break;
			}
		}

		if (!$has_channel) {
			$number = 0;

			foreach ($query->getElement('data', $query->channelList('-topic -limits -flags')) as $channel) {
				if (!$give_channel && ($channel['pid'] == $conf['channels_zone'])) {
					$number++;

					if ($channel['channel_topic'] == $conf['empty_channel_topic']) {
						$message_to_client .= $lang['get_channel'];
						$message_to_client .= "\n" . '[b]' . $lang['hi'] . $client['client_nickname'] . '![/b]' . "\n";
						$message_to_client .= $lang['channel_created'] . '[b]' . $number . '[/b]' . "\n" . $lang['default_pass'] . "\n" . '[color=green]' . $lang['gl&hf'] . '[/color]';
						$query->clientMove($clid, $channel['cid']);

						if (self::$cfg['sinusbot']['enabled']) {
							foreach (self::$sinusbot->getQueueTracks() as $once) {
								self::$sinusbot->playNext();
							}

							self::$sinusbot->stop();
							$settings = self::$sinusbot->getSettings();

							foreach ($query->getElement('data', $query->clientList()) as $cli) {
								if ($cli['client_nickname'] == $settings['nick']) {
									$sbot_clid = $cli['clid'];
									break;
								}
							}

							sleep(1);
							$query->clientMove($sbot_clid, $channel['cid']);
						}

						$query->setClientChannelGroup($conf['head_channel_admin_group'], $channel['cid'], $client['client_database_id']);
						$data = date('d-m-Y');
						$desc_main = '[center][size=15][b]' . $lang['private_channel'] . $number . $lang['not_empty'] . '[/b][/size][/center]';
						$desc_main .= "\n" . '[size=11][b]' . $lang['owner'] . '[/b]' . $client['client_nickname'] . "\n" . '[b]' . $lang['created'] . '[/b]' . $data . "\n" . '[/size]' . "\n\n" . $language['function']['down_desc'];

						if (20 <= strlen($client['client_nickname'])) {
							$name = $number . '. ' . $language['function'][__FUNCTION__]['channel_name'];
						}
						else {
							$name = $number . '. ' . $language['function'][__FUNCTION__]['channel_name'] . $client['client_nickname'];
						}

						$query->channelEdit($channel['cid'], ['channel_name' => $name, 'channel_description' => $desc_main, 'channel_topic' => $data, 'channel_flag_maxclients_unlimited' => 1, 'channel_flag_maxfamilyclients_unlimited' => 1, 'channel_flag_maxfamilyclients_inherited' => 0, 'channel_maxclients' => 1, 'channel_maxfamilyclients' => 1, 'channel_password' => '123']);
						$desc_sub = $lang['sub_channel'] . '[/b][/size][/center]' . "\n";
						$desc_sub .= "\n" . '[size=11][b]' . $lang['owner'] . '[/b]' . $client['client_nickname'] . '[/size]' . "\n\n\n" . $language['function']['down_desc'];
						$i = 0;

						while ($i < $conf['sub_channels']) {
							$num = $i;
							$num++;
							$query->channelCreate(['channel_flag_permanent' => 1, 'cpid' => $channel['cid'], 'channel_name' => $num . $language['function'][__FUNCTION__]['sub_channel'], 'channel_flag_maxclients_unlimited' => 1, 'channel_flag_maxfamilyclients_unlimited' => 1, 'channel_password' => '123', 'channel_description' => '[center][size=15][b]' . $num . $desc_sub]);
							$i++;
						}

						$give_channel = true;

						if (self::$cfg['sinusbot']['enabled']) {
							if (self::$cfg['sinusbot']['type'] != 385) {
								self::$sinusbot->playTrack(self::$tracks['entries'][20]['file']);
							}
							else {
								self::$sinusbot->playTrack(self::$tracks['entries'][10]['file']);
							}

							sleep(self::$cfg[__FUNCTION__]['sb_delay']);
							$query->clientMove($sbot_clid, self::$cfg['support_channel_id']);
						}

						break;
					}
				}
			}

			if (!$give_channel) {
				$message_to_client .= $lang['no_empty'];
			}
		}
	}
}

?>