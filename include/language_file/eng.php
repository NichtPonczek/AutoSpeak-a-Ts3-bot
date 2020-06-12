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
	$language['which'] = 'eng';


	$language['core'][0] = 'TeamSpeak3 bot by';
	$language['core'][1] = 'Version';
	$language['core'][2] = 'Loading functions';
	$language['core'][3] = 'Loading config';
	$language['core'][4] = 'Loading TeamSpeak3 Admin Class';
	$language['core'][5] = 'Successfully loaded: ';
	$language['core']['plugins'][1] = ' plugin';
	$language['core']['plugins'][2] = ' plugins';
	$language['core']['events'][1] = ' event';
	$language['core']['events'][2] = ' events';
	$language['core']['commands'][1] = ' command';
	$language['core']['commands'][2] = ' commands';
	$language['core']['misconfigured'] = ' misconfigured';
	$language['core']['console'] = 'Console:';
	$language['core']['database'] = 'Connected to the database';
	$language['core']['license'] = 'Checking license validity';
	$language['core']['black_list_info'] = '[color=red] You are thrown away because you are on the black list of the AutoSpeak application. [/color] Reason: [b][REASON][/b].';
	
	$language['logs']['core']['bad_license'] = 'License not valid. The creator has been informed!';
	$language['logs']['core']['error']['database'] = 'AutoSpeak could not connect to the database';
	$language['logs']['core']['error']['file'] = 'Function given in files could not be found in config';
	$language['logs']['core']['error']['login'] = 'AutoSpeak could not login to server admin query';
	$language['logs']['core']['error']['port'] = 'AutoSpeak could not get through the specified port';
	$language['logs']['core']['error']['bot_name'] = 'AutoSpeak could not change his nickname, adding: @';
	$language['logs']['core']['error']['bot_name_2'] = 'AutoSpeak could not change his nickname (too long)';
	$language['logs']['core']['error']['default_channel'] = 'AutoSpeak could not change the channel';
	$language['logs']['core']['error']['connection_lost'] = 'AutoSpeak - connection lost!';
	$language['logs']['core']['error']['connection_lost_db'] = 'AutoSpeak - database connection lost!';
	$language['logs']['core']['error']['live_help'] = 'You do not have a LiveHelp license!';
	$language['logs']['core']['error']['instance_off'] = 'This instance is off!';
	$language['logs']['core']['error']['bad_instance'] = 'The wrong instance was selected!';
	$language['logs']['core']['error']['php_module'] = 'Package PHP not found: ';

	$language['logs']['core']['license_info']['downloading'] = 'Downloading data from AutoSpeak server: ';
	$language['logs']['core']['license_info']['success'] = 'SUCCESS';
	$language['logs']['core']['license_info']['error'] = 'ERROR';
	$language['logs']['core']['license_info']['poke_info'] = 'New meesage from AutoSpeak server! Watch priv.';
	$language['logs']['core']['license_info']['welcome'] = '» Hi administrator ([b][NICK][/b]), there are some newest informations from AutoSpeak server:';
	$language['logs']['core']['license_info']['content'] = 'Content:';
	$language['logs']['core']['license_info']['written'] = 'Written:';
	
	$language['logs']['database']['created'] = 'Successfully created table: ';
	$language['logs']['database']['cant_created'] = 'Error creating table: [TABLE_NAME]. You have to insert it manually!';

	$language['logs']['start'] = 'AutoSpeak has been started';
	$language['logs']['cant_connect'] = 'AutoSpeak cant connect to the server!';
	$language['logs']['functions'] = 'Performing function: ';

	$language['logs']['groups_security']['ban'] = ' was banned for having rang: ';
	$language['logs']['groups_security']['kick'] = ' was kicked for having rang: ';
	$language['logs']['groups_security']['nothing'] = " was poked for having rang: ";	

	$language['function']['error']['api'] = "[hr][center][/center]\n● [size=13][B]Errors list[/B][/size][list][*][size=9][b]Error [u]with API connection[/u][/size][/list]\n";
	$language['function']['error']['too_long'] = "[hr]\n● [size=13][B]Errors list[/B][/size][list][*][size=9][b]Error [u]channel name or description is too long[/u][/size][/list]\n";

	$language['function']['show_link'] = " - [url=[LINK]]Profil[/url]";
	
	$language['function']['get_vip_channel']['message'] = "You just received a [TYPE] channel number: [NUM]! Congratulations!";
	$language['function']['get_vip_channel']['has_channel'] = "You already own a [TYPE] channel!";
	$language['function']['get_vip_channel']['top_desc'] = "Channel [TYPE] number: ";
	$language['function']['get_vip_channel']['error_db'] = "Could not connect to the database!";
	$language['function']['get_vip_channel']['error_main'] = "error when creating the main channel. Maybe there is a channel with this name?";
	$language['function']['get_vip_channel']['error_spacer'] = "error when creating a walk. Maybe there is such a walk already?";
	$language['function']['get_vip_channel']['error'] = "[ERROR] Check the bot logs!";

	$language['function']['warning_ban']['user_banned'] = "User was banned: ";

	$language['function']['twitch_yt']['info'] = "Information: ";
	$language['function']['twitch_yt']['playing'] = "Is playing: ";
	$language['function']['twitch_yt']['follows'] = "Followers: ";
	$language['function']['twitch_yt']['views'] = "Views: ";
	$language['function']['twitch_yt']['viewers'] = "Viewers: ";
	$language['function']['twitch_yt']['subs'] = "Subscribers: ";
	$language['function']['twitch_yt']['videos'] = "Videos on the channel: ";
	$language['function']['twitch_yt']['click'] = "[CLICK]";
	$language['function']['twitch_yt']['streaming'] = "ON LIVE";

	$language['function']['admins_meetin']['moved'] = " admins have been successfully moved to the meeting channel.";
	$language['function']['admins_meeting']['information'] = " , remember about the upcoming administration meeting";

	$language['function']['groups_assigner']['has_rang'] = "You already have the registered group assigned!";
	$language['function']['groups_assigner']['received_rang'] = "You have just been assigned the registered group!";
	$language['function']['groups_assigner']['error'] = "You do not meet the requirements! You need to spend on a minimum server:";
	$language['function']['groups_assigner']['min'] = "minutes.";

	$language['function']['auto_register']['received_rang'] = "You just received a registration group!";

	$language['ends_of_words']['one_day'] = "day";
	$language['ends_of_words']['2_days'] = "days";
	$language['ends_of_words']['other_days'] = "days";
	$language['ends_of_words']['one_hour'] = "hour";
	$language['ends_of_words']['2_hours'] = "hours";
	$language['ends_of_words']['other_hours'] = "hours";
	$language['ends_of_words']['one_minute'] = "minute";
	$language['ends_of_words']['2_minutes'] = "minutes";
	$language['ends_of_words']['other_minutes'] = "minutes";
	$language['ends_of_words']['seconds'] = "seconds";
	$language['ends_of_words']['zero'] = "less than one minute";
	
	$language['function']['connect_message']['one_day'] = "day";
	$language['function']['connect_message']['2_days'] = "days";
	$language['function']['connect_message']['other_days'] = "days";
	$language['function']['connect_message']['one_hour'] = "hour";
	$language['function']['connect_message']['2_hours'] = "hours";
	$language['function']['connect_message']['other_hours'] = "hours";
	$language['function']['connect_message']['one_minute'] = "minute";
	$language['function']['connect_message']['2_minutes'] = "minutes";
	$language['function']['connect_message']['other_minutes'] = "minutes";
	$language['function']['connect_message']['seconds'] = "seconds";

	$language['function']['host_message'] = "Welcome on [b][SERVER_NAME][/b]\nNow online [b][SERVER_ONLINE]/[SERVER_MAX_CLIENTS][/b].\nUptime [b][SERVER_UPTIME][/b]. \nHave a nice day!";

	$language['function']['poke_admins']['hi'] = "Hello";
	$language['function']['poke_admins']['in_this_moment'] = "The current number of available admins is ";
	$language['function']['poke_admins']['help'] = "Someone will help you soon!";
	$language['function']['poke_admins']['no_admins'] = "unfortunately no admins are available right now, come back later";
	$language['function']['poke_admins']['wants_help'] = "awaits your help!";
	$language['function']['poke_admins']['on_channel'] = "On channel: ";
	$language['function']['poke_admins']['informed'] = "was informed about your stay on this channel!";
	$language['function']['poke_admins']['away'] = "You can not be AWAY!";
	$language['function']['poke_admins']['input'] = "You can not have the microphone turned off!";
	$language['function']['poke_admins']['output'] = "You can not be muted!";

	$language['function']['admin_list']['on_channel'] = "Channel: ";
	$language['function']['admin_list']['for'] = "for";
	$language['function']['admin_list']['no_admins'] = "None admins in this server group";
	
	$language['function']['admin_list_online']['on_channel'] = "On channel: ";
	$language['function']['admin_list_online']['online'] = "Online from: ";

	$language['function']['online_from_server_group'] = "None users in this server group";

	$language['function']['afk_move']['moved'] = "You have been moved to the AFK channel";
	$language['function']['afk_move']['moved_back'] = "You have been moved back to your channel";

	$language['function']['nicks_security']['kick_message'] = "Your nickname contains a bad phrase: ";
	$language['function']['nicks_security']['bad_away_message'] = "Your away message contains a bad phrase: ";
	$language['function']['nicks_security']['bad_desc'] = "Your description contains a bad phrase: ";
	$language['function']['nicks_security']['ban'] = "Too many entries with bad nickname";

	$language['function']['top_connections']['connect'] = "connections";

	$language['function']['record_online'][0] = "[b]Information - Serwer[/b]\nRecord Online";
	$language['function']['record_online'][1] = "The current record is:";
	$language['function']['record_online'][2] = "It was set on:";

	$language['function']['channels_guard']['private_channel'] = "Private channel number: ";
	$language['function']['channels_guard']['empty'] = " [EMPTY]";
	$language['function']['channels_guard']['how_to_get'] = "To get it go to the adequate channel";
	$language['function']['channels_guard']['wrong_name'] = "Invalid channel name!";
	$language['function']['channels_guard']['bad_name'] = "Forbidden phrase in channel name!";
		
	$language['function']['get_private_channel']['hasnt_rang'] = "You do not have the required group assigned!";
	$language['function']['get_private_channel']['has_channel'] = "You already own a channel!";
	$language['function']['get_private_channel']['get_channel'] = "You have just received a private channel!";
	$language['function']['get_private_channel']['no_empty'] = "No empty channels currently!";
	$language['function']['get_private_channel']['channel_name'] = "Private channel - ";
	$language['function']['get_private_channel']['created'] = "Created: ";
	$language['function']['get_private_channel']['sub_channel'] = " Subchannel";
	$language['function']['get_private_channel']['private_channel'] = "Private channel number: ";
	$language['function']['get_private_channel']['not_empty'] = " [TAKEN]";
	$language['function']['get_private_channel']['owner'] = "Owner: ";
	$language['function']['get_private_channel']['hi'] = "Hello ";
	$language['function']['get_private_channel']['channel_created'] = "We have just created you a private channel number: ";
	$language['function']['get_private_channel']['default_pass'] = "The default password is: 123";
	$language['function']['get_private_channel']['gl&hf'] = 'We wish you pleasant conversations!';

	$language['function']['empty_channels']['list'] = 'List of channels';
	$language['function']['empty_channels']['free'] = 'Empty';
	$language['function']['empty_channels']['to_del'] = 'To delete';
	$language['function']['empty_channels']['days'] = array
	(
		0 => 'Sunday',
		1 => 'Monday',
		2 => 'Tuesday',
		3 => 'Wednesday',
		4 => 'Thursday',
		5 => 'Friday',
		6 => 'Saturday',
	);
	$language['function']['empty_channels']['tomorrow'] = "Tomorrow";


	$language['function']['ban_list'] = array
	(
		'header' => "Total: ",
		'permament' => "permamently",
		'user' => "User",
		'time' => "Duration",
		'reason' => "Reason",
		'invoker' => "Creator",
		'date' => "Created",
	);

	$language['function']['status_sinusbot']['in_group'] = "Bot's in group";
	$language['function']['status_sinusbot']['is'] = 'is';
	$language['function']['status_sinusbot']['active'] = 'Active';
	$language['function']['status_sinusbot']['on_channel'] = 'on channel';
	$language['function']['status_sinusbot']['for'] = 'for';	

	$language['function']['random_group']['title'] = 'List of random groups';
	$language['function']['random_group']['owner'] = 'You achieved random group: ';
	$language['function']['random_group']['on_time'] = 'on time:';
	$language['function']['random_group']['cong'] = 'Congratulations!';
	$language['function']['random_group']['days'] = 'days';
	$language['function']['random_group']['desc'] = 'Has drawn a rank:';
	$language['function']['random_group']['day'] = 'at day';

	$language['function']['write_statistics']['groups'] = '[center][B][size=11][rang_name]:[/B] [size=11][client][/size][/center]\n[b][size=10] Normal Groups:[/size][/b][left]●  Today: [B][today].[/B]\n●  This Week: [B][weekly].[/B]\n● This Month: [B][monthly].[/B]\n●  Sum of groups added: [B][total].[/B][/left]\n[b][size=10]Register Groups:[/size][/b][left] Today: [B][reg_today].[/B]\n This Week: [B][reg_weekly].[/B]\n This Month: [B][reg_monthly].[/B]\n  Sum of gropus added: [B][reg_total].[/B][/left]';
	$language['function']['write_statistics']['time_spent'] = '[center][B][size=11][rang_name]:[/B] [size=11][client][/size][/center][b][size=10] Time Spend: [/size][/b]\n\n [size=9]Today: [B][today][/B] as [B][off_today][/B] afk.[/size]\n [size=9]Weekly: [B][weekly][/B] as [B][off_weekly][/B] away.[/size]\n [size=9]Monthly: [B][monthly][/B] as [B][off_monthly][/B] away.[/size]\n [size=9]Total Time: [B][total][/B] as [B][off_total][/B] away[/size]';
	$language['function']['write_statistics']['help_center'] = '[center][B][size=11][rang_name]:[/B] [size=11][client][/size][/center]\n[b][size=10]Amount clients:[/size][/b][left]●  Today: [B][today_count].[/B]\n● This Week: [B][weekly_count].[/B]\n●  Monthly: [B][monthly_count].[/B]\n●  Sum of persons: [B][total_count].[/B][/left]\n[b][size=10]Time spend helping:[/size][/b][left]  Today: [B][today_time].[/B]\n Weekly: [B][weekly_time].[/B]\n  Monthly: [B][monthly_time].[/B]\n  Total time helped: [B][total_time].[/B][/left]';

	$language['function']['facebook_posts']['header'] = 'Post from our';
	$language['function']['facebook_posts']['written'] = 'Written:';

	$language['function']['live_dj'] = "none";

	$language['function']['event_records']['success'] = "You saved successfully!";
	$language['function']['event_records']['failed'] = "Error. Maybe you are already on the list?";

	$language['function']['top_week_time'] = "to promotion:";

	$language['function']['levels']['next'] = "Congratulations! You upgraded to lvl: [NAME]. You need [HOURS] hours to achieve the next level.";
	$language['function']['levels']['last'] = "Congratulations! You upgraded to lvl: [NAME]. It's the last level!";

	$language['function']['delete_client_permissions'] = "Hello, permisions on your client ([PERMS]) have just been removed because you can not have them.";
	
	$language['function']['get_server_group']['add'] = "You just received a guild group!";
	$language['function']['get_server_group']['del'] = "The guild group has been successfully removed!";
	
	$language['function']['actions_logs']['groups_assigner'] = " was registered by entering the channel.";
	$language['function']['actions_logs']['auto_register'] = " was registered because he spent enough time on the server.";
	$language['function']['actions_logs']['block_recording'] = " was punished for recording.";
	$language['function']['actions_logs']['anty_vpn'] = " was punished for using VPN.";
	$language['function']['actions_logs']['poke_admins'] = " joined to the help center.";
	$language['function']['actions_logs']['get_vip_channel'] = " received the [TYPE] channel number: [NUM].";
	$language['function']['actions_logs']['get_yt_channel'] = " received a YouTube channel number: [NUM].";
	$language['function']['actions_logs']['nicks_security']['nick'] = " was punished for the wrong nickname.";
	$language['function']['actions_logs']['nicks_security']['away'] = " was punished for the wrong away message.";
	$language['function']['actions_logs']['nicks_security']['desc'] = " was punished for the wrong client description.";
	$language['function']['actions_logs']['wrong_nick'] = "Bad Nick";
	$language['function']['actions_logs']['levels'] = " promoted to LVL: [LVL].";
	$language['function']['actions_logs']['random_group'] = " drew a VIP group.";
	$language['function']['actions_logs']['get_private_channel'] = " received a private channel number: [NUM].";
	$language['function']['actions_logs']['channels_guard'] = "Date private channel number: [NUM] has been updated.";
	
	$language['function']['weather']['weather'] = "Weather";
	$language['function']['weather']['temperature'] = "Temperature";
	$language['function']['weather']['status'] = "Weather status";
	$language['function']['weather']['speed'] = "Wind speed";
	$language['function']['weather']['pressure'] = "Pressure";
	$language['function']['weather']['humidity'] = "Humidity";
	$language['function']['weather']['visibility'] = "Visibility";
	
	$language['function']['check_ip'] = "Max [NUMBER] accounts on the same IP!";
	
	$language['function']['AutoSpeak_info']['instances_info'] = "Informations about AutoSpeak's instances";
	$language['function']['AutoSpeak_info']['instance'] = "Instance";
	$language['function']['AutoSpeak_info']['no_info'] = "no data";
	$language['function']['AutoSpeak_info']['total_ram'] = "Total RAM usage";
	$language['function']['AutoSpeak_info']['info_from_server'] = "Informations from AutoSpeak's server";
	
	$language['function']['check_description']['header'] = "Suspicious links detected";
	$language['function']['check_description']['bad_link'] = "[b][color=red]Wrong link[/color] (by AutoSpeak)[/b]";
	$language['function']['check_description']['bad_link_text'] = "wrong link";
	$language['function']['check_description']['on_channel'] = "detected on the channel";
	
	$language['function']['channels_edits']['header'] = "The last channels' edits:";
	$language['function']['channels_edits']['channel'] = "Channel:";
	$language['function']['channels_edits']['was_edited'] = "was edited by:";
	
	$language['command']['success'] = "Successfully informed people: ";
	$language['command']['success_moved'] = "Successfully moved admins: ";
	$language['command']['success_bot'] = "|Success| Wait a few seconds for results!";
	$language['command']['result'] = "Results: ";
	$language['command']['suc'] = "Success";
	
	$language['command']['hi'] = "Hello [NICK]\nThank you for using my bot ~Razor Meister :)";

	$language['command']['class']['not_command'] = 'To use a command put `!` before it';
	$language['command']['class']['wrong_command'] = 'There is no such command: ';
	$language['command']['class']['not_privileged'] = "You don't have the priviledges needed to use this command: ";
	$language['command']['class']['bad_usage'] = 'Wrong use of the command: ';
	$language['command']['class']['bad_instance'] = 'There is no such instance: ';

	$language['command']['ch']['has_channel'] = 'User already has a private channel!';
	$language['command']['ch']['success'] = 'Successfully created a private channel with a number of subchannels: ';

	$language['command']['mute']['success'] = 'Successfully assigned the rank of person: [b][u][NICK][/u][/b] for the number of seconds:';

	$language['command']['admin']['no_admin'] = 'This user does not have an administrator!';
	$language['command']['admin']['no_in_db'] = 'No person in the database!';
	$language['command']['admin']['info'] = '\n● [b][u]General information:[/u][/b]\n\tNick: [b][nick][/b]\n\tClient database id: [b][dbid][/b]\n\tClient UID: [b][uid][/b] \n\tServer Connections: [b][con][/b]\n\tTime spent on server: [b][time_spent][/b]\n\n';
	$language['command']['admin']['info_2'] = '\n● [b][u]Normal Groups: [/u][/b]\n\tToday: [b][today][/b]\n\tRegister: [B][reg_today][/b]\n\tThis week: [b][reg_weekly][/b]\n\tThis month:[b][reg_monthly][/b]\n\tThe total number of assigned groups: [b][reg_total][/b]\n\n● [b][u]Time spent: [/u][/b]\n\tToday[color=green][b][today_time][/b][/color]\n\tThis week: [color=green][b][weekly_time][/b][/color]\n\tThis month: [color=green][b][monthly_time][/b][/color]\n\tTotal time: [color=green][b][total_time][/color]';

	$language['command']['clientinfo']['no_in_db'] = 'No person in the database!';
	$language['command']['clientinfo']['info'] = '\n● [b][u]General information:[/u][/b]\n\tNick: [b][nick][/b]\n\tClient database id: [b][dbid][/b]\n\tClient UID: [b][uid][/b] \n\tServer Connections: [b][con][/b]\n\tTime spent on server: [b][time_spent][/b]\n\n';
	$language['command']['clientinfo']['info_2'] = '\n● [b][u]Users change nicks:[/u][/b]\n';
	$language['command']['clientinfo']['change_nick'] = 'changed nick';
	
	$language['command']['tpclient']['to_small'] = 'Too short nick! You must provide at least 3 characters!';
	$language['command']['tpclient']['not_finded'] = 'The user was not found.';

	$language['command']['tpchannel']['to_small'] = 'Too short channel name! You must provide at least 3 characters!';
	$language['command']['tpchannel']['not_finded'] = 'The channel was not found.';
	
	$language['command']['gsecurity']['wrong_group'] = 'The specified group is not saved in the config.';
	$language['command']['gsecurity']['wrong_type'] = 'Incorrect type, use `add` or `del`.';
	$language['command']['gsecurity']['added'] = 'User [b][NICK][/b] successfully [color=green]added[/color] to the group [SGID].';
	$language['command']['gsecurity']['deleted'] = 'User [b][NICK][/b] was successfully [color=red] removed[/color] from the group [SGID].';
	$language['command']['gsecurity']['wrong_deleted'] = 'The user [b][NICK][/b] is not in the cache file, so it can not be deleted.';
	
	$language['command']['help']['info']['help'] = 'Shows the list of commands';
	$language['command']['help']['info']['pwall'] = 'Sends a private message to all clients';
	$language['command']['help']['info']['pokeall'] = 'Pokes all clients';
	$language['command']['help']['info']['pwgroup'] = 'Sends a private message to clients from the chosen server group';
	$language['command']['help']['info']['pokegroup'] = 'Pokes clients from the chosen server group';
	$language['command']['help']['info']['meeting'] = 'Moves the administration to the chosen channel';
	$language['command']['help']['info']['clients'] = 'Shows a list of all clients';
	$language['command']['help']['info']['channels'] = 'Shows a list of all channels';
	$language['command']['help']['info']['bot'] = 'Manages AutoSpeak`s instances';
	$language['command']['help']['info']['ch'] = 'Creates a private channel to the client with the specified number of subchannels';
	$language['command']['help']['info']['mute'] = 'Gives the user the specified in config rank on the specified number of seconds';
	$language['command']['help']['info']['admin'] = 'Prints information about the specified admin';
	$language['command']['help']['info']['tpclient'] = 'Moves you to the user with the given nickname';
	$language['command']['help']['info']['tpchannel'] = 'Moves you to the channel with the given name';
	$language['command']['help']['info']['gsecurity'] = 'Add/delete group from function groups_security()';
	$language['command']['help']['info']['clientinfo'] = 'Prints information about the specified client';

	$language['command']['help']['usage']['help'] = '!help';
	$language['command']['help']['usage']['pwall'] = '!pwall-[message]';
	$language['command']['help']['usage']['pokeall'] = '!pokeall-[message]';
	$language['command']['help']['usage']['pwgroup'] = '!pwgroup-[group_id]-[message]';
	$language['command']['help']['usage']['pokegroup'] = '!pokegroup-[group_id]-[message]';
	$language['command']['help']['usage']['meeting'] = '!meeting';
	$language['command']['help']['usage']['clients'] = '!clients';
	$language['command']['help']['usage']['channels'] = '!channels';
	$language['command']['help']['usage']['bot'] = '!bot-[instance_id]';
	$language['command']['help']['usage']['ch'] = '!ch-[client_database_id]-[num_of_subchannels]';
	$language['command']['help']['usage']['mute'] = '!mute-[client_database_id]-[time_in_seconds]';
	$language['command']['help']['usage']['admin'] = '!admin-[client_database_id]';
	$language['command']['help']['usage']['tpclient'] = '!tpclient-[client_nick]';
	$language['command']['help']['usage']['tpchannel'] = '!tpchannel-[channel_name]';
	$language['command']['help']['usage']['gsecurity'] = '!gsecurity-[add/del]-[client_database_id]-[group_id]';
	$language['command']['help']['usage']['clientinfo'] = '!clientinfo-[client_database_id]';

	$language['command']['help']['privileged'] = 'Can use: ';
	$language['command']['help']['inf'] = 'Information: ';
	$language['command']['help']['us'] = 'Usage: ';

	$language['live_help'] = array
	(
		//Register
		'not_registered' => '(AutoSpeak) LiveHelp has detected that you are not registered yet.',
		'reg_man' => 'to register as a man',
		'reg_woman' => 'to register as a woman',

		//Menu
		'header' => "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n[b]AutoSpeak - LiveHelp[/b]\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n \n",
		'menu' => 'to show list of commands',
		'add' => 'to give server group',
		'del' => 'to delete server group',
		'list' => 'to show list of server groups',
		'faq' => 'to show FAQ',
		'client_info' => 'to view information about You',
		'!admin' => 'to call the admin',
		'registered' => 'You have just registered!',
		'group_list' => 'List of server groups',
		'write' => 'Write',
		'wait_admin' => 'You are waiting for admin help!',
		'cancel_help' => 'To cancel help from admin',	
		'success_exit' => 'Successfully canceled admin help!',
		'channel' => 'to get a private channel',
		'help_commands' => 'How to get help:',		

		//Poke admins
		'admin_informed' => 'Admin has already been notified!',
		'admin_on_channel' => 'Admin is already on the help channel!',
		'help_status' => 'HELP STATUS',

		//Server Groups
		'received_rang' => 'You have just received your rank!',
		'del_rang' => 'Your rank has been removed!',
		'limit' => 'You have reached the limit!',
		'not_have' => 'You do not have this rank!',
		'wrong_rang' => 'Incorrect rank!',
		'group_number' => 'number_of_group',

		//FAQ
		'info' => 'Informations about You:',
		'version' => 'Application version:',
		'country' => 'Country:',

		'bot_nick' => '[NAME] | Clients in queue: [NUM]',
		'wrong_command' => 'Incorrect command!',
	);
?>
