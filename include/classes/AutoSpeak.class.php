<?php 
class AutoSpeak_functions
{
	static public $disabled_functions = [];
	static private $last_checked = [];
	static private $license_checked = false;
	static public $show_links = [];

	static public function write_loaded_functions($count, $switch)
	{
		global $language;

		if ($count == 1) {
			if ($switch == 1) {
				return $language['core']['plugins'][1];
			}
			else if ($switch == 2) {
				return $language['core']['events'][1];
			}
			else {
				return $language['core']['commands'][1];
			}
		}
		else if (((5 <= $count) || ($count == 0)) && ($language['which'] != 'eng')) {
			if ($switch == 1) {
				return $language['core']['plugins'][3];
			}
			else if ($switch == 2) {
				return $language['core']['events'][3];
			}
			else {
				return $language['core']['commands'][3];
			}
		}
		else if ($switch == 1) {
			return $language['core']['plugins'][2];
		}
		else if ($switch == 2) {
			return $language['core']['events'][2];
		}
		else {
			return $language['core']['commands'][2];
		}
	}

	static public function check_numeric_connect($cfg, $name)
	{
		global $language;
		global $logs_manager;
		$good = true;

		if (!is_numeric($cfg['query_port'])) {
			$logs_manager::write_info($name . 'Query port' . $language['core']['misconfigured']);
			$good = false;
		}

		if (!is_numeric($cfg['port'])) {
			$logs_manager::write_info($name . 'Port' . $language['core']['misconfigured']);
			$good = false;
		}

		if (!is_numeric($cfg['default_channel'])) {
			$logs_manager::write_info($name . 'Bot default channel' . $language['core']['misconfigured']);
			$good = false;
		}

		return $good;
	}

	static public function success(array $output)
	{
		return $output[__FUNCTION__];
	}

	static public function convert_to_seconds($interval)
	{
		$interval['days'] = $interval['days'] + ($interval['weeks'] * 7);
		$interval['hours'] = $interval['hours'] + ($interval['days'] * 24);
		$interval['minutes'] = $interval['minutes'] + ($interval['hours'] * 60);
		return $interval['seconds'] + ($interval['minutes'] * 60);
	}

	static public function if_can($event, $date1, $date2, $interval)
	{
		global $event_info;

		if (!self::$license_checked) {
			global $version;
			global $logs_manager;
			global $name;
			global $language;
			global $addons;

			if ($addons != '') {
				$to_add = '&addons=' . $addons;
			}
			else {
				$to_add = '';
			}

			self::$license_checked = true;
		}

		$time2 = strtotime($date2);
		$time1 = strtotime($date1);
		$sum = $time1 - $time2;

		if ($interval <= $sum) {
			$event_info['data'][$event] = $date1;
			return true;
		}
		else {
			return false;
		}
	}

	static public function language_file($language)
	{
		if ($language == 'pl') {
			if (!file_exists('include/language_file/pl.txt')) {
				$fp = fopen('include/language_file/pl.txt', 'a');
				fclose($fp);

				if (file_exists('include/language_file/eng.txt')) {
					unlink('include/language_file/eng.txt');
				}
			}
		}
		else if ($language == 'eng') {
			if (!file_exists('include/language_file/eng.txt')) {
				$fp = fopen('include/language_file/eng.txt', 'a');
				fclose($fp);

				if (file_exists('include/language_file/pl.txt')) {
					unlink('include/language_file/pl.txt');
				}
			}
		}
	}

	static public function check_connect_database($info, &$sql)
	{
		global $language;
		global $logs_manager;

		try {
			$connection = new PDO('mysql:host=' . $info['db_ip'] . ';dbname=' . $info['db_name'], $info['db_user'], $info['db_password']);
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$connection->exec('SET CHARACTER SET utf8mb4');
			$connection->exec('SET NAMES utf8mb4');
		}
		catch (PDOException $e) {
			return false;
		}

		$sql = $connection;
		require 'db.php';
		$result = $sql->query('SHOW TABLES FROM ' . $info['db_name']);
		$key_name = 'Tables_in_' . $info['db_name'];

		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			if (($row != '') && isset($tables[$row[$key_name]])) {
				$tables[$row[$key_name]] = 1;
			}
		}

		foreach ($tables as $table_name => $good) {
			if (!$good) {
				$created = true;
				$query_sql = create_table($table_name);
				$query_sql = explode('||', $query_sql);

				foreach ($query_sql as $once_query) {
					$sql->query($once_query) || ($created = false);

					if (!$created) {
						break;
					}
				}

				if ($created) {
					$logs_manager::write_info(' - ' . $language['logs']['database']['created'] . $table_name, 0);
				}
				else {
					exit($logs_manager::write_info(str_replace('[TABLE_NAME]', $table_name, ' [ERROR] ' . $language['logs']['database']['cant_created']), 0));
				}
			}
		}

		foreach ($new_columns as $table => $info) {
			foreach ($info as $col => $type) {
				$result = $sql->query('SHOW COLUMNS FROM ' . $table . ' LIKE \'' . $col . '\'');

				if ($result->rowCount() == 0) {
					$sql->exec('ALTER TABLE ' . $table . ' ADD ' . $col . ' ' . $type . '');
				}
			}
		}

		foreach ($edits as $table => $info) {
			foreach ($info as $col => $type) {
				$result = $sql->query('SHOW COLUMNS FROM ' . $table . ' LIKE \'' . $col . '\'');
				$result = $result->fetch(PDO::FETCH_ASSOC);

				if ($result['Type'] == $type['from']) {
					$sql->exec('ALTER TABLE ' . $table . ' MODIFY ' . $col . ' ' . $type['to'] . '');
				}
			}
		}

		return true;
	}

	static public function convert_to_command($text)
	{
		$data = $text['data'];
		$info = [];
		$full_command = [];
		$edited = ['\\s' => ' ', "\t" => '', "\xb" => '', "\r" => '', "\n" => '', "\xc" => '', '\\/' => '/', '\\p' => '|'];

		if ($data['msg'][0] == '!') {
			$msg = str_replace(array_keys($edited), array_values($edited), substr($data['msg'], 1));
			$is_command = 1;
			$full_command = explode('-', $msg);
			$msg = $full_command[0];
		}
		else {
			$msg = '';
			$is_command = 0;
		}

		$info = [
			'command'    => $msg,
			'is_command' => $is_command,
			'clid'       => $data['invokerid'],
			'nick'       => $data['invokername'],
			'parameters' => [$full_command]
		];
		return str_replace(array_keys($edited), array_values($edited), $info);
	}

	static public function send_to_client($clid, $case, $command)
	{
		global $query;
		global $language;
		$lang = $language['command']['class'];

		switch ($case) {
		case 'not_command':
			$message = $lang['not_command'];
			break;
		case 'wrong_command':
			$message = $lang['wrong_command'] . '`' . $command . '`';
			break;
		case 'not_privileged':
			$message = $lang['not_privileged'] . '`' . $command . '`';
			break;
		case 'bad_usage':
			$message = $lang['bad_usage'] . '`' . $command . '`';
			break;
		case 'bad_instance':
			$message = $lang['bad_instance'] . '`' . $command . '`';
			break;
		}

		$query->sendMessage(1, $clid, $message);
	}

	static public function has_privileged_group($pri_groups, $clid)
	{
		global $query;

		if (in_array(0, $pri_groups)) {
			return true;
		}

		$client_info = $query->getElement('data', $query->clientInfo($clid));
		$client_groups = explode(',', $client_info['client_servergroups']);

		foreach ($pri_groups as $pri_group) {
			if (in_array($pri_group, $client_groups)) {
				return true;
			}
		}

		return false;
	}

	static public function has_group($client_groups, $groups)
	{
		$client_groups = explode(',', $client_groups);

		if (gettype($groups) == 'array') {
			foreach ($groups as $group) {
				if (in_array($group, $client_groups)) {
					return true;
				}
			}
		}
		else if (in_array($groups, $client_groups)) {
			return true;
		}

		return false;
	}

	static public function check_group($sgid, $function_name, &$group_name = NULL, $to_disable = false)
	{
		global $logs_manager;
		global $server_groups;
		$result = [];
		$disable = false;

		foreach ($server_groups as $group) {
			if ($group['sgid'] == $sgid) {
				$group_name = $group['name'];
				return true;
			}
		}

		if ($to_disable) {
			array_push(self::$disabled_functions, $function_name);
			$disable = true;
		}

		$logs_manager::set_error('#Gr1:' . $sgid, $function_name, $disable);
		return false;
	}

	static public function check_error($output, $function_name, $cid, $to_disable = false)
	{
		global $logs_manager;
		global $query;
		global $language;

		if ($cid == 0) {
			return true;
		}

		$ignored_errors = [771];

		if (!$output['success']) {
			foreach ($output['errors'] as $error) {
				$error = explode(' | ', $error);
				$error = explode(': ', $error[0]);

				if (in_array($error[1], $ignored_errors)) {
					continue;
				}

				if ($to_disable) {
					array_push(self::$disabled_functions, $function_name);
				}

				switch ($error[1]) {
				case 768:
					$logs_manager::set_error('#Ch1:' . $cid, $function_name, $to_disable);
					return false;
					break;
				case 1541:
					if (!in_array($function_name, ['client_on_channel', 'online_users'])) {
						$query->channelEdit($cid, ['channel_description' => $language['function']['error']['too_long'] . $language['function']['down_desc']]);
					}

					$logs_manager::set_error('#Ch2:' . $cid, $function_name, $to_disable);

					if ($function_name == 'channels_edits') {
						return '#Ch2';
					}

					return false;
					break;
				case 2568:
					exit($logs_manager::set_error('#Ch3:' . $cid, $function_name, false));
					break;
				default:
					$logs_manager::set_error('#Ch~:' . $cid, $function_name, $to_disable);
					break;
				}
			}
		}
		else {
			return true;
		}
	}

	static private function tip_of_words($num, $for1, $for234, $for_others)
	{
		$text = ' ' . $num . ' ';

		if ($num == 1) {
			return $text . $for1;
		}
		else if (in_array($num % 10, [2, 3, 4])) {
			return $text . $for234;
		}
		else {
			return $text . $for_others;
		}
	}

	static public function convert_time($seconds, $info = [])
	{
		global $language;
		$lang = $language['ends_of_words'];
		$text = '';
		if (!isset($info['days']) || $info['days']) {
			$uptime['d'] = floor($seconds / 86400);
		}
		else {
			$uptime['d'] = 0;
		}
		if (!isset($info['hours']) || $info['hours']) {
			$uptime['h'] = floor(($seconds - ($uptime['d'] * 86400)) / 3600);
		}
		else {
			$uptime['h'] = 0;
		}
		if (!isset($info['minutes']) || $info['minutes']) {
			$uptime['m'] = floor(($seconds - (($uptime['d'] * 86400) + ($uptime['h'] * 3600))) / 60);
		}
		else {
			$uptime['m'] = 0;
		}

		if ($uptime['d'] != 0) {
			$text .= self::tip_of_words($uptime['d'], $lang['one_day'], $lang['2_days'], $lang['other_days']);
		}

		if ($uptime['h'] != 0) {
			$text .= self::tip_of_words($uptime['h'], $lang['one_hour'], $lang['2_hours'], $lang['other_hours']);
		}

		if ($uptime['m'] != 0) {
			$text .= self::tip_of_words($uptime['m'], $lang['one_minute'], $lang['2_minutes'], $lang['other_minutes']);
		}

		return $text == '' ? ' ' . $lang['zero'] : $text;
	}

	static public function use_black_list($black_list, $client, $type)
	{
		global $query;
		global $language;

		foreach (explode('\\n', $language['core']['black_list_info']) as $msg) {
			$query->sendMessage(1, $client['clid'], str_replace(['[REASON]', '[DATE]'], [$black_list[$client['client_unique_identifier']]['reason'], $black_list[$client['client_unique_identifier']]['date']], $msg));
		}

		if ($type == 'kick') {
			$query->clientKick($client['clid'], 'server', 'BLACK LIST AutoSpeak');
		}
		else {
			$query->banAddByUid($client['client_unique_identifier'], 0, 'BLACK LIST AutoSpeak');
		}
	}

	static public function check_memory()
	{
		global $instance;
		$cache = json_decode(file_get_contents('include/cache/memory_usage.txt'), 1);
		$cache[$instance['i']] = memory_get_usage(true);
		file_put_contents('include/cache/memory_usage.txt', json_encode($cache));
	}

	static public function check_channel_desc($channel_id, $desc)
	{
		global $query;
		$current_channel = $query->getElement('data', $query->channelInfo($channel_id));
		return str_replace('\\n', "\n", $current_channel['channel_description']) != $desc ? true : false;
	}

	static public function client_url($client, $nick = '')
	{
		return '[URL=client://' . $client['clid'] . '/' . $client['client_unique_identifier'] . ']' . ($nick == '' ? $client['client_nickname'] : $nick) . '[/URL]';
	}

	static public function set_action($name, $data = [])
	{
		global $query_sql;
		global $instance;
		global $clients;
		global $language;
		$action_text = '';
		$lang = $language['function']['actions_logs'][$name];

		if (!isset($query_sql)) {
			return NULL;
		}

		switch ($name) {
		case 'get_vip_channel':
			$action_text .= self::client_url($data['client']) . str_replace(['[TYPE]', '[NUM]'], [$data['type'], $data['number']], $lang);
			break;
		case 'get_yt_channel':
			$action_text .= self::client_url($data['client']) . str_replace('[NUM]', $data['number'], $lang);
			break;
		case 'nicks_security':
			$lang = $lang[$data['type']];

			switch ($data['type']) {
			case 'nick':
				$action_text .= self::client_url($data['client'], '(' . $language['function']['actions_logs']['wrong_nick'] . ')') . $lang;
				break;
			case 'away':
				$action_text .= self::client_url($data['client']) . $lang;
				break;
			default:
				$action_text .= self::client_url($data['client']) . $lang;
				break;
			}

			break;
		case 'groups_assigner':
			$action_text .= self::client_url($data['client']) . $lang;
			break;
		case 'auto_register':
			$action_text .= self::client_url($data['client']) . $lang;
			break;
		case 'block_recording':
			$action_text .= self::client_url($data['client']) . $lang;
			break;
		case 'anty_vpn':
			foreach ($clients as $client) {
				if ($client['clid'] == $data['clid']) {
					break;
				}
			}

			$action_text .= self::client_url($client) . $lang;
			break;
		case 'poke_admins':
			$action_text .= self::client_url($data['client']) . $lang;
			break;
		case 'levels':
			$action_text .= self::client_url($data['client']) . str_replace('[LVL]', $data['lvl_name'], $lang);
			break;
		case 'random_group':
			$action_text .= self::client_url($data['client']) . $lang;
			break;
		case 'get_private_channel':
			$action_text .= self::client_url($data['client']) . str_replace('[NUM]', $data['number'], $lang);
			break;
		case 'channels_guard':
			$action_text .= str_replace('[NUM]', $data['number'], $lang);
			break;
		}

		$query_sql->exec('INSERT INTO `actions` (`date`,`name`,`text`,`instance_id`) VALUES (\'' . time() . '\',\'' . $name . '\',\'' . htmlentities($action_text, ENT_QUOTES, 'UTF-8') . '\',\'' . $instance['i'] . '\')');
	}

	static public function show_link($dbid)
	{
		global $language;
		return self::$show_links['enabled'] ? str_replace('[LINK]', self::$show_links['link'] . $dbid, $language['function'][__FUNCTION__]) : '';
	}
}

?>
