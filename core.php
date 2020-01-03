<?php
echo 'AutoSpeak';
error_reporting(32767);
date_default_timezone_set('Europe/Berlin');
ini_set('default_charset', 'UTF-8');
setlocale(LC_ALL, 'UTF-8');
$version = '0.1';
define('OWNER', 'AutoSpeak ');
define('VERSION', 'TS3 ' . $version);
define('PREFIX', ':> ');
define('PREFIX_2', '» ');
define('END', "\n");
$instance = getopt('i:');
$delay = getopt('d:');
$error = false;
$name = ' [SYSTEM] ';
$addons = '';
require_once 'include/composer/vendor/autoload.php';
require 'include/configs/language.php';
require 'include/language_file/' . $config['bot_language'] . '.php';
$language['function']['down_desc'] = '[hr][right]Fancy Bot[/right]';
echo PREFIX . $language['core'][0] . OWNER . END;
echo PREFIX . 'AutoSpeak' . END;
echo PREFIX . $language['core'][1] . VERSION . END . END;
echo PREFIX_2 . $language['core'][3] . END;
require 'include/configs/config.php';
$all_instances = count($config['instance']);
if (!isset($instance['i']) || !is_numeric($instance['i']) || ($instance['i'] < 1) || ($all_instances < $instance['i'])) {
    exit(END . $name . $language['logs']['core']['error']['bad_instance'] . END);
}

$settings = $config['general']['instances_settings']['instances'][$instance['i']];

if (!$settings['enabled']) {
    exit(END . $name . $language['logs']['core']['error']['instance_off'] . END);
}

$connect = $config['general']['connection_ts3'];
$connect['bot_name'] = $settings['bot_name'];
$connect['default_channel'] = $settings['default_channel'];
if (isset($settings['individual_login']) && $settings['individual_login']['enabled']) {
    $connect['login'] = $settings['individual_login']['login'];
    $connect['password'] = $settings['individual_login']['password'];
}

$logs_system = $config['instance'][$instance['i']]['logs_system']['logs'];
$bot_interval = $config['instance'][$instance['i']]['options']['bot_interval'];
$options = $config['instance'][$instance['i']]['options'];

if ($options['function_type'] != 'commands') {
    $cfg = $config['instance'][$instance['i']]['functions'];
} else {
    $cfg = $config['instance'][$instance['i']]['commands'];
}

$connect_database = $config['general']['connection_database'];
$functions_info = [];
echo PREFIX_2 . $language['core'][2] . END;
require 'include/classes/AutoSpeak.class.php';
require 'include/classes/logs.class.php';
$AutoSpeak = new AutoSpeak_functions();
$logs_manager = new logs();
$AutoSpeak::$show_links = $config['general']['instances_settings']['settings']['show_links'];
$main_admins_dbid = $config['general']['instances_settings']['settings']['main_admins_dbid'];

if ($logs_system['enabled']) {
    $logs = $logs_manager::logs_create($connect['bot_name']);
}

if ($settings['database_enabled']) {
    if ($AutoSpeak::check_connect_database($connect_database, $query_sql)) {
        echo PREFIX_2 . $language['core']['database'] . END;
    } else {
        exit($logs_manager::write_info($name . $language['logs']['core']['error']['database']));
    }
} else {
    unset($connect_database);
}

if (!in_array('curl', get_loaded_extensions())) {
    exit($logs_manager::write_info($name . $language['logs']['core']['error']['php_module'] . 'PHP CURL (apt-get install php7.2-curl)'));
}

if (!in_array('gd', get_loaded_extensions())) {
    exit($logs_manager::write_info($name . $language['logs']['core']['error']['php_module'] . 'PHP GD (apt-get install php7.2-gd)'));
}

$plugins_events_commands = [];
$plugins = [];
$events = [];
$commands = [];
$folder = $options['folder'];

foreach (new DirectoryIterator('include/functions/' . $folder) as $fileInfo) {
    $file = pathinfo($fileInfo->getFilename());
    if (isset($file['extension']) && ($file['extension'] == 'php')) {
        array_push($plugins_events_commands, $file['filename']);
    }
}

unset($file, $fileInfo);

if ($options['function_type'] != 'commands') {
    foreach ($plugins_events_commands as $function) {
        if (array_key_exists($function, $cfg) && $cfg[$function]['enabled']) {
            if ($cfg['plugins'] && !array_key_exists('time_interval', $cfg[$function])) {
                require 'include/functions/' . $folder . '/' . $function . '.php';
                array_push($plugins, $function);
                $function::construct($function);
            } else if ($cfg['events'] && array_key_exists('time_interval', $cfg[$function])) {
                if (in_array('live_help', $plugins_events_commands) && !$cfg['live_help']['poke_admins']['poke_once']) {
                    $event_info['data']['poke_admins'] = '1970-01-01 00:00:00';
                    $event_info['interval']['poke_admins'] = $AutoSpeak::convert_to_seconds($cfg[$function]['poke_admins']['poking_interval']);
                }

                require 'include/functions/' . $folder . '/' . $function . '.php';
                array_push($events, $function);
                $function::construct($function);
                $event_info['data'][$function] = '1970-01-01 00:00:00';
                $event_info['interval'][$function] = $AutoSpeak::convert_to_seconds($cfg[$function]['time_interval']);
            }

            if (property_exists($function, 'addon')) {
                $addons .= $function::$addon . ',';
            }
        } else if (!array_key_exists($function, $cfg)) {
            exit($logs_manager::write_info($name . '`' . $function . '.php` ' . $language['logs']['core']['error']['file']));
        }
    }

    unset($function);
    array_push($events, 'check_memory');
    $event_info['data']['check_memory'] = date('Y-d-m G:i:s');
    $event_info['interval']['check_memory'] = 30;
} else {
    foreach ($plugins_events_commands as $command) {
        if (array_key_exists($command, $cfg) && $cfg[$command]['enabled']) {
            require 'include/functions/' . $folder . '/' . $command . '.php';
            array_push($commands, $command);
            $command::construct($command);
        } else if ($command == 'hi') {
            require 'include/functions/' . $folder . '/' . $command . '.php';
            array_push($commands, $command);
            $cfg[$command]['privileged_groups'] = [0];
        } else if (!array_key_exists($command, $cfg)) {
            exit($logs_manager::write_info($name . '`' . $command . '.php` ' . $language['logs']['core']['error']['file']));
        }
    }

    unset($command);
}

unset($plugins_events_commands, $folder);
$AutoSpeak::check_memory();
echo PREFIX_2 . $language['core'][5] . count($plugins) . $AutoSpeak::write_loaded_functions(count($plugins), 1) . END;
echo PREFIX_2 . $language['core'][5] . count($events) . $AutoSpeak::write_loaded_functions(count($events), 2) . END;
echo PREFIX_2 . $language['core'][5] . count($commands) . $AutoSpeak::write_loaded_functions(count($commands), 3) . END;
echo PREFIX_2 . $language['core'][4] . END;
include 'include/classes/ts3admin.class.php';
$AutoSpeak::language_file($config['bot_language']);
unset($config);
echo PREFIX_2 . $language['core']['license'] . END . END;
if ($AutoSpeak::check_numeric_connect($connect, $name)) {
    echo END . $language['core']['console'] . END;
    $query = new ts3admin($connect['IP'], $connect['query_port'], 10);

    if ($AutoSpeak::success($query->connect())) {
        if (!$AutoSpeak::success($query->login($connect['login'], $connect['password']))) {
            exit($logs_manager::write_info($name . $language['logs']['core']['error']['login']));
        }

        if (!$AutoSpeak::success($query->selectServer($connect['port']))) {
            exit($logs_manager::write_info($name . $language['logs']['core']['error']['port']));
        }

        if (!$AutoSpeak::success($query->setName($connect['bot_name']))) {
            $logs_manager::write_info($name . (25 < strlen($connect['bot_name']) ? $language['logs']['core']['error']['bot_name_2'] : $language['logs']['core']['error']['bot_name']));
            $bot_name = (25 < strlen($connect['bot_name']) ? 'AutoSpeak_' . $instance['i'] : $connect['bot_name'] . '@');

            while (!$AutoSpeak::success($query->setName($bot_name))) {
                $bot_name .= '@';
            }
        }

        $whoAmI = $query->getElement('data', $query->whoAmI());

        if (!$AutoSpeak::success($query->clientMove($whoAmI['client_id'], $connect['default_channel']))) {
            $logs_manager::write_info($name . $language['logs']['core']['error']['default_channel']);
        }

        if ($logs_system['enabled']) {
            $logs_date = date('d-m-Y');
            $logs_manager::logs_delete($connect['bot_name'], $logs_system['delete_interval']);
            fwrite($logs, date('d-m-Y G:i:s') . ' ' . $name . $language['logs']['start'] . END);
        }

        echo date('d-m-Y G:i:s') . ' ' . $name . $language['logs']['start'] . END;

        if (in_array('change_channel', $events)) {
            $cache = 1;
        }

        if (in_array('admins_meeting', $plugins)) {
            $cache_poked = 0;
            $cache_moved = 0;
        }

        if (in_array('poke_admins', $events)) {
            $cache_client_poke = [];
        }
        if (in_array('afk_move', $plugins) && $cfg['afk_move']['move_back']) {
            $clients_channels_afk = [];
        }

        if (in_array('live_help', $events)) {
            $cache_live_help = [];
        }
        if (in_array('get_server_group', $events) && isset($query_sql)) {
            $result = $query_sql->query('SELECT get_group, group_id FROM vip_channels');

            if (0 < $result->rowCount()) {
                $result = $result->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $once) {
                    if (!in_array($once['get_group'], $cfg['get_server_group']['if_client_on_channel']) && ($once['get_group'] != 0)) {
                        array_push($cfg['get_server_group']['if_client_on_channel'], $once['get_group']);
                    }
                }
            }
        }
        if (in_array('move_groups', $plugins) && isset($query_sql) && $cfg['move_groups']['vip_channels_from_AutoSpeak']['enabled']) {
            $result = $query_sql->query('SELECT channel_cid, group_id FROM vip_channels');

            if (0 < $result->rowCount()) {
                $result = $result->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $once) {
                    move_groups::$from_vip_channels[] = [
                        'is_on_channel' => $cfg['move_groups']['vip_channels_from_AutoSpeak']['is_on_channel'],
                        'move_to_channel' => explode(',', $once['channel_cid'])[0],
                        'groups' => [$once['group_id']],
                        'ignored_groups' => $cfg['move_groups']['vip_channels_from_AutoSpeak']['ignored_groups']
                    ];
                }
            }
        }

        if ($options['function_type'] == 'commands') {
            $lang = $language['command']['help'];
            $desc = '[hr][center][size=15][b]Spis komend[/b][/size]' . "\n" . '[size=11]Bot - [URL=client://' . $whoAmI['client_id'] . '/' . $whoAmI['client_unique_identifier'] . ']' . $whoAmI['client_nickname'] . '[/URL][/size][/center][hr]' . "\n";

            if (!empty($commands)) {
                foreach ($commands as $command) {
                    if ($command != 'hi') {
                        $desc .= '[center][b][size=12]!' . $command . '[/size][/b][/center]' . "\n";
                        $desc .= '[b]' . $lang['privileged'] . '[/b]';

                        foreach (help::find_group_name($cfg[$command]['privileged_groups']) as $name) {
                            $desc .= $name . ', ';
                        }

                        $desc .= "\n" . '[b]' . $lang['inf'] . '[/b]' . $lang['info'][$command] . "\n";
                        $desc .= '[b]' . $lang['us'] . '[/b]' . $lang['usage'][$command] . "\n\n";
                    }
                }
            } else {
                $desc .= 'No Commands';
            }

            $desc .= $language['function']['down_desc'];
            $query->channelEdit($options['commands_list'], ['channel_description' => $desc]);
            $socket = $query->runtime['socket'];
            fputs($socket, 'servernotifyregister event=textprivate' . "\n");

            if ($cfg['mute']['enabled']) {
                $cache_mute = [];
            }
        }

        if ($options['function_type'] != 'commands') {
            $old_clients = [];
            $clients = $query->getElement('data', $query->clientList('-uid -groups'));

            foreach ($clients as $client) {
                if (($client['clid'] != $whoAmI['client_id']) && ($client['client_database_id'] != 1)) {
                    array_push($old_clients, $client['clid']);
                }
            }
        }

        while (true) {
            if (($instance['i'] != 6) && ($instance['i'] != 5)) {
                sleep($bot_interval);
            } else {
                usleep($bot_interval * 1000);
            }


            if (isset($query_sql)) {
                $query_sql->exec('SET NAMES utf8mb4');
            }
            if (isset($logs_date) && ($logs_date != date('d-m-Y')) && $logs_system) {
                $logs_manager::logs_delete($connect['bot_name'], $logs_system['delete_interval']);
                $logs = $logs_manager::logs_create($connect['bot_name']);
                $logs_date = date('d-m-Y');
            }

            $clients = $query->clientList('-uid -groups -ip -times -away -voice -country');

            if (!$AutoSpeak::success($clients)) {
                exit($logs_manager::write_info($name . $language['logs']['core']['error']['connection_lost']));
            }

            $clients = $clients['data'];

            if ($options['function_type'] != 'commands') {
                $loop_date = date('Y-m-d G:i:s');
                $server_info = $query->getElement('data', $query->serverInfo());
                $server_groups = $query->getElement('data', $query->serverGroupList());
                $new_clients = [];

                foreach ($clients as $client) {
                    if ($client['client_database_id'] != 1) {
                        if (!isset($client['clid'])) {
                            $client['clid'] = $client['invokerid'];
                        }

                        array_push($new_clients, $client['clid']);
                    }
                }

                $difference = array_diff($new_clients, $old_clients);
                if (($instance['i'] == 1) && isset($check_license_info) && $check_license_info && $AutoSpeak::if_can('check_license_info', $loop_date, $event_info['data']['check_license_info'], $event_info['interval']['check_license_info'])) {
                    $check_license_info = $lic::get_license_info(true, $black_list, $info_on_server);
                }
            }

            if ($options['function_type'] == 'live_help') {
                $AutoSpeak::check_memory();
                $count = 0;
                if ($cfg['live_help']['poke_admins']['enabled'] && !$cfg['live_help']['poke_admins']['poke_once'] && $AutoSpeak::if_can('poke_admins', $loop_date, $event_info['data']['poke_admins'], $event_info['interval']['poke_admins'])) {
                    foreach ($cache_live_help as $key => $lh) {
                        if ($lh['status'] == 'help_admin') {
                            live_help::check_help_admin($lh['command'], $key, true, false);
                        }
                    }
                }

                foreach ($clients as $client) {
                    if (($client['cid'] == $cfg['live_help']['support_channel_id']) && isset($client['clid']) && !$AutoSpeak::has_group($client['client_servergroups'], $cfg['live_help']['ignored_groups'])) {
                        if (!in_array($client['clid'], array_keys($cache_live_help)) || ($cache_live_help[$client['clid']]['status'] == 'registered')) {
                            live_help::main($client);
                        }

                        $count++;
                    }
                }
                if ($cfg['live_help']['sinusbot']['enabled'] && $cfg['live_help']['sinusbot']['queue_in_nick']) {
                    if (1 <= $count) {
                        live_help::change_sb_name(str_replace(['[NAME]', '[NUM]'], [$cfg['live_help']['sinusbot']['bot_nick'], $count], $language['live_help']['bot_nick']));
                    } else {
                        live_help::change_sb_name($cfg['live_help']['sinusbot']['bot_nick']);
                    }
                } else if ($cfg['live_help']['sinusbot']['enabled']) {
                    live_help::change_sb_name($cfg['live_help']['sinusbot']['bot_nick']);
                }
                if ((1 <= $count) && $cfg['live_help']['commands_enabled']) {
                    $msgData = $query->readChatMessage('textprivate', true, -1, $cfg['live_help']['read_chat']);

                    if ($msgData['success'] == 1) {
                        $msgData = $msgData['data'];
                        $clientID = $msgData['invokerid'];
                        $clientUID = $msgData['invokeruid'];
                        $clientName = $msgData['invokername'];
                        $msg = $msgData['msg'];
                        $targetMode = $msgData['targetmode'];

                        if ($msg != NULL) {
                            live_help::usage($clientID, $clientUID, $msg);
                        }
                    }
                }

                continue;
            }

            foreach ($plugins as $plugin) {
                if (in_array($plugin, $AutoSpeak::$disabled_functions)) {
                    continue;
                }

                if (method_exists($plugin, 'before_clients')) {
                    $plugin::before_clients();
                }

                if (method_exists($plugin, 'clients_different')) {
                    $plugin::clients_different();
                }

                foreach ($clients as $client) {
                    if (!isset($client['clid'])) {
                        $client['clid'] = $client['invokerid'];
                    }
                    if (($client['clid'] != $whoAmI['client_id']) && ($client['client_database_id'] != 1)) {
                        if ($plugin == 'black_list') {
                            if (in_array($client['client_unique_identifier'], array_keys($black_list))) {
                                $AutoSpeak::use_black_list($black_list, $client, $options['black_list_type']);
                            }

                            continue;
                        }

                        if (method_exists($plugin, 'every_client')) {
                            $plugin::every_client($client);
                        }

                        if (array_key_exists('with_rang', $cfg[$plugin])) {
                            if (in_array($cfg[$plugin]['with_rang'], explode(',', $client['client_servergroups']))) {
                                $plugin::main($client);
                            }
                        }

                        if (array_key_exists('if_client_on_channel', $cfg[$plugin])) {
                            if (in_array($client['cid'], $cfg[$plugin]['if_client_on_channel'])) {
                                $plugin::main($client);
                            }
                        }
                    }
                }
            }

            foreach ($events as $event) {
                if ($AutoSpeak::if_can($event, $loop_date, $event_info['data'][$event], $event_info['interval'][$event]) && !in_array($event, $AutoSpeak::$disabled_functions)) {
                    if ($event == 'check_memory') {
                        $AutoSpeak::check_memory();
                        continue;
                    }

                    if (method_exists($event, 'before_clients')) {
                        $event::before_clients();
                    }

                    if (method_exists($event, 'reset_cache')) {
                        $event::reset_cache();
                    }
                    if (method_exists($event, 'every_client') || method_exists($event, 'main') || method_exists($event, 'check_in_database')) {
                        foreach ($clients as $client) {
                            if (!isset($client['clid'])) {
                                $client['clid'] = $client['invokerid'];
                            }
                            if (($client['clid'] != $whoAmI['client_id']) && ($client['client_database_id'] != 1)) {
                                if (method_exists($event, 'every_client')) {
                                    $event::every_client($client);
                                }

                                if (property_exists($event, 'if_client_on_channel_before')) {
                                    if (in_array($client['cid'], $cfg[$event]['if_client_on_channel'])) {
                                        $event::main();
                                        break;
                                    }
                                }

                                if (array_key_exists('if_client_on_channel', $cfg[$event])) {
                                    if (in_array($client['cid'], $cfg[$event]['if_client_on_channel'])) {
                                        $event::main($client);
                                    }
                                }

                                if (method_exists($event, 'check_in_database')) {
                                    if (array_key_exists('with_rang', $cfg[$event])) {
                                        if (in_array($cfg[$event]['with_rang'], explode(',', $client['client_servergroups']))) {
                                            $event::check_in_database($client);
                                        }
                                    } else {
                                        $event::check_in_database($client);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if ($options['function_type'] == 'commands') {
                if (isset($cache_mute) && (0 < count($cache_mute))) {
                    $interval = 3;
                } else {
                    $interval = 10;
                }

                $text = $query->readChatMessage('textprivate', true, -1, $interval);
                if (($text['data']['msg'] == 'ok') || ($text['data']['msg'] == '')) {
                    $AutoSpeak::check_memory();
                    if (isset($cache_mute) && (0 < count($cache_mute))) {
                        mute::check_cache();
                    }

                    continue;
                }

                $info = $AutoSpeak::convert_to_command($text);

                if (!$info['is_command']) {
                    $AutoSpeak::send_to_client($info['clid'], 'not_command', 0);
                } else if (!in_array($info['command'], $commands)) {
                    $AutoSpeak::send_to_client($info['clid'], 'wrong_command', $info['command']);
                } else if ($AutoSpeak::has_privileged_group($cfg[$info['command']]['privileged_groups'], $info['clid'])) {
                    $info['command']::main($info);
                } else {
                    $AutoSpeak::send_to_client($info['clid'], 'not_privileged', $info['command']);
                }
            }
            if (($options['function_type'] != 'live_help') && ($options['function_type'] != 'commands')) {
                $old_clients = $new_clients;
            }
        }
    } else {
        $logs_manager::write_info($name . $language['logs']['cant_connect']);
    }
}

?>
