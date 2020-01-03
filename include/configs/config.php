<?php

define('ICON_ID', 144);
define('NEEDED_JOIN_POWER', 139);
define('NEEDED_SUBSCRIBE_POWER', 141);
define('NEEDED_MODIFY_POWER', 124);
	
$config['general'] = array
(
	'connection_ts3' => array
	(
		/**************************************************************************************

	 	   ENG [MAIN LOGIN TO TEAMSPEAK3 SERVER]      

		**************************************************************************************/

		// ENG [TeamSpeak3 Server IP Adress]   
			'IP' 			=> '',
		
		// ENG [TeamSpeak3 Server Query Port]  
			'query_port'		=> '10011',

		// ENG [TeamSpeak3 Server Port]   #  
			'port' 			=> '9987',

		// ENG [TeamSpeak3 Server Query Login]   
			'login' 		=> 'serveradmin',

		// ENG [TeamSpeak3 Server Query Password]   
			'password' 		=> '',
	),
	'connection_database' => array
	(
		/**************************************************************************************

	 	   ENG [MAIN LOGIN TO DATABASE]      

		**************************************************************************************/
		
		// ENG [Database IP]  
			'db_ip' 		=> '127.0.0.1',

		// ENG [Database user]   
			'db_user'		=> '',

		// ENG [Database password]   
			'db_password' 		=> '',

		// ENG [Database name]   
			'db_name' 		=> 'autospeak',
	),
	'instances_settings' => array
	(
		/**************************************************************************************

	 	   ENG [MAIN INSTANCES SETTINGS]      

		**************************************************************************************/
		
		'settings' => array
		(
			// ENG [Show links to profile]  
			'show_links' => array('enabled' => false, 'link' => ''),
			// ENG [Main admins databases] 
			'main_admins_dbid' => array(15,54,56),
		),
		'instances' => array
		(
			'1' => array
			(
				'enabled' => true,
				'database_enabled' => true,
				'bot_name' => '(AutoSpeak)Updater',
				'default_channel' => 79,
			),
			'2' => array	
			(
				'enabled' => true,
				'database_enabled' => true,
				'bot_name' => '(AutoSpeak)Admin',
				'default_channel' => 79,
			),
			'3' => array	//Db
			(
				'enabled' => true,
				'database_enabled' => true,
				'bot_name' => '(AutoSpeak)Base',
				'default_channel' => 79,
			),
			'4' => array	
			(
				'enabled' => true,
				'database_enabled' => true,
				'bot_name' => '(AutoSpeak)Channels',
				'default_channel' => 79,
			),
			'5' => array	//Cmd
			(
				'enabled' => false,
				'database_enabled' => true,
				'bot_name' => '(AutoSpeak)Commands',
				'default_channel' => 79,

				// ENG [Set individual ts3 login and password]   
				'individual_login' => array
				(
					'enabled' => false,
					'login' => 'fancyname',
					'password' => '',
				),
			),
			'6' => array	//LiveHelp
			(
				'enabled' => false,
				'database_enabled' => false,
				'bot_name' => '(AutoSpeak)LiveHelp',
				'default_channel' => 79,

				// ENG [Set individual ts3 login and password]   
				'individual_login' => array
				(
					'enabled' => false,
					'login' => 'fancyname2',
					'password' => '',
				),
			),
		),
	),
);

$config['instance']['1']['logs_system'] = array
(
	/****************************************************************************

	 	       ENG [LOGS SYSTEM]      

	****************************************************************************/

	'logs' => array
	(
		// ENG [Turn on/off logs system (false or false)] 
			'enabled' => true,  

		// ENG [Days, after which, log files will be deleted]   
			'delete_interval' => '3',
	),
);

$config['instance']['1']['options'] = array
(
	/****************************************************************************

	 	    ENG [INSTANCE OPTIONS]       #       

	****************************************************************************/

	// ENG [Folder for functions containing all events and plugins]   
		'folder' 	=> 'first_instance',

	// ENG [Bot interval in seconds] 
		'bot_interval' 	=> 5,

	// ENG ['events_plugins' or 'commands' (default 'events_plugins')]
		'function_type' => 'events_plugins',
		
	// ENG [Black list type, 'ban' | 'kick']  
		'black_list_type' => 'kick',
);

$config['instance']['1']['functions'] = array
(

	/**************************************

	    ENG [PLUGINS]   #   PL [PLUGINY]

	**************************************/

	'plugins' => true,

	// ENG [Informing admins about upcoming meeting]  
	'admins_meeting' => array
	(
		'enabled' => false,
		'info' => array
		(
			'admins_server_groups' => array(11,12,13,14,15,16,17),	//all admins server groups
			'channel_id' => 7,					//meeting channel id
			'channel_name' => '» Zebranie [x]', 	//[x] - meeting date (in format: dd.mm.yyyy hh:mm for example 18.02.2017 18:00) !important you must have channel with that name
			'information_before' => false, 				//informing admins `time_to_meeting` seconds before meeting
			'time_to_meeting' => 900, 				//in seconds
			'move_admins' => false,					//move admins to meeting channel on time
		),
	),

	// ENG [Nicknames security]    
	'nicks_security' => array
	(
		'enabled' => true,
		'ignored_groups' => array(12,105,18,14,15,16,17,19,20,41,2),	//ignored groups
		'file' => 'include/cache/nicks_security.txt',	//bad phrases separated by ,(comma) without spaces, enters etc
		'check_away_message' => false,
		'check_client_description' => false, // Can slow down instance
		'ban' => array
		(
			'enabled' => true,		// false or false
			'min_kicks' => 3,		// ban after X kicks
			'ban_time' => 5 * 60,	// in seconds
			'cache_reset' => 120,	// in seconds
		),
	),

	// ENG [Server groups limit]  
	'groups_limit' => array
	(
		'enabled' => false,
		'ignored_groups' => array(2),	//ignored groups which will not be check
		'info' => array
		(
			/****************************************
			
				'1' => array 				    //growing number, for example 1, 2, 3...
				(
					'checking_groups' => array(52,53,54,55,56),	//checking server groups
					'limit' => 1,					//limit of checking groups 
				), 
				
			****************************************/
		
			'1' => array
			(
				'checking_groups' => array(37,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,98,99,105),	//checking server groups
				'limit' => 5,					//limit of checking groups 
			),
			'2' => array
			(
				'checking_groups' => array(108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123),	//checking server groups
				'limit' => 1,					//limit of checking groups 
			),
		),		
	),

	// ENG [Move specified groups to channel from specified channel] 
	'move_groups' => array
	(
		'enabled' => false,
		'if_client_on_channel' => array(135), //All channels from which bot must move clients |
		'vip_channels_from_AutoSpeak' => array
		(
			'enabled' => false,
			'is_on_channel' => 135,
			'ignored_groups' => array(),
		),
		'info' => array
		(
			/*************************

			0 => array	//growing number: 0,1,2 etc.
			(
				'is_on_channel' => 50,	//form which channel bot must move people
				'move_to_channel' => 25,	//to which channel bot must move people
				'groups' => array(14,13),	//groups which will be checking
			),

			*************************/
			
			0 => array
			(
				'is_on_channel' => 135,
				'move_to_channel' => 98,
				'groups' => array(),
			),
			1 => array
			(
				'is_on_channel' => 135,
				'move_to_channel' => 115,
				'groups' => array(25,61),
			),
		),
	),

	//  ENG [Animated icon] 
	'animated_icon' => array
	(
		'enabled' => false,
		'info' => array
		(
			/*************************************************
			
				id => array
				(
					'type' => 'servergroup' OR 'cldbid' //If servergroup, id = sgid || if cldbid, id = client database id
					'icons' =>  array(-2072408170,968796862,1023685817,-1634246665,1726830382),
				),
			
			*************************************************/
		
			44 => array
			(
				'type' => 'servergroup',
				'icons' =>  array(-2072408170,968796862,1023685817,-1634246665,1726830382),
			),
			15 => array
			(
				'type' => 'cldbid',
				'icons' =>  array(-2072408170,968796862,1023685817,-1634246665,1726830382),
			),
		),
	),

	/**************************************

	     ENG [EVENTS]   #

	**************************************/

	'events' => true,

	// ENG [Online users]  #  
	'online_users' => array
	(
		'enabled' => false,
		'channel_id' => 6,
		'ignored_groups' => array(50,51),
		'channel_name' => '» Online: [ONLINE]', //[ONLINE] - online users
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 60),
	),

	// ENG [Record amount of clients online]
	'record_online' => array
	(
		'enabled' => false,
		'channel_id' => 9,
		'channel_name' => '» Rekord Serwera: [RECORD]', //[RECORD] - record online users
		'show_history' => false,
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 30),
	),

	// ENG [List of admins online] 
	'admin_list_online' => array
	(
		'enabled' =>false,
		'channel_id' => 945,
		'admins_server_groups' => array(105,14,15,16,17,18,19,20),
		'ignored_groups' => array(60),
		'channel_name' => '[lspacer][ » ] Lista Adminów', 			//[ONLINE] - Admins online
		'top_description' => 'Lista Administracji online',
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 5,'seconds' => 0),
	),

	// ENG [Admin list]  
	'admin_list' => array
	(
		'enabled' => true,
		'min_idle_time' => 5*60,	//minimal client idle time to be away (in seconds)
		'admins_count' => false,		//enable admins count in description
		'info' => array
		(
			27 => array	//channel id
			(
				'admins_server_groups' => array(12,105,14,15,16,17,18,19,20),	
				'ignored_groups' => array(107),
				'top_description' => '|> Lista Adminów <|',
				'icons_enabled' => false,		//Convert rang name to icon
				'icons' => array
				(
					/*************************

					group_id => 'url_to_image',

					************************/

					11 => '',
					12 => '',
				),
			),
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 5,'seconds' => 0),
	),	

	// ENG [Change channel name]  
	'change_channel' => array
	(
		'enabled' => false, 	
		'channel_id' => 70,
		'channel_name' => array
		(
			'[cspacer]1',
			'[cspacer]2',
			'[cspacer]3',
		),	
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 10),
	),

	// ENG [Multifunction] 
	'multi_function' => array
	(
		'enabled' => false,
		'content' => array
		(
			'total_ping' => array     // ENG [server total ping in channel name]  
			(
				'enabled' => false,
				'channel_id' => 11,
				'channel_name' => '» Średni ping wynosi: [PING]', 		// [PING] = ping
				'integer' => false, 						// false or false (ping in integer)
			),
			'packet_loss' => array    // ENG [server packet loss in channel name] 
			(
				'enabled' => false,
				'channel_id' => 12,
				'channel_name' => '» Packetloss wynosi: [PACKETLOSS]%', 	// [PACKETLOSS] = packetloss
				'integer' => false, 						// false or false (packetloss in integer)
			),
			'channels_count' => array // ENG [channels count in channel name] 
			(
				'enabled' => false,
				'channel_id' => 939,
				'channel_name' => '» Kanałów ogółem: [CHANNELS]', 	// [CHANNELS] = channels count
			),
			'bytes_upload' => array // ENG [bytes upload on server in channel name] 
			(
				'enabled' => false,
				'channel_id' => 940,
				'channel_name' => '» Danych wysłanych: [UPLOAD]', 	// [UPLOAD] = bytes upload
			), 
			'bytes_download' => array // ENG [bytes download on server in channel name]  
			(
				'enabled' => false,
				'channel_id' => 13,
				'channel_name' => '» Danych pobranych: [DOWNLOAD]', 	// [DWONLOAD] = bytes download
			),
		),	
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 25),
	),

	// ENG [Support channels] 
	'support_channels' => array
	(
		'enabled' => false,
		'content' => array
		(
			'time_open' => array		//Channels open at a specific time 
			(
				'0' => array						                     // growing number for example 1, 2, 3...
				(
					'channelId' => 938,				                     	// channel id				
					'time_open' => '09:00',				                     	// time of opening				
					'time_close' => '23:50',			                    	 // time of closing				
					'channel_name_open' => '[»] Centrum Pomocy [ON]',	     // channel name when opened	
					'channel_name_close' => '[»] Centrum Pomocy [OFF]',     // channel name when closed
					'needed_join_power' => 1500,						//when close
					'change_maxfamily_clients' => false,			             	// close family channels too		
				),
				'1' => array						                     // growing number for example 1, 2, 3...
				(
					'channelId' => 942,				                     	// channel id				
					'time_open' => '09:00',				                     	// time of opening				
					'time_close' => '23:50',			                    	 // time of closing				
					'channel_name_open' => '[»] Chcę zakupić usługę[ON]',	     // channel name when opened	
					'channel_name_close' => '[»] Chcę zakupić usługę [OFF]',     // channel name when closed
					'needed_join_power' => 1500,						//when close
					'change_maxfamily_clients' => false,			             	// close family channels too		
				),
			),
			'open_when_admin' => array	//Channels open when admin from server group is online
			(
				/*************************

				###
				#	open when admin from groups online: 'admin' => array(server_groups separated by comma),
				###

				###
				#	open when client online: 'admin' => client_database_id,
				###

				*************************/

				'0' => array						                     // growing number for example 1, 2, 3...
				(
					'channelId' => 941,				                     	// channel id				
					'admin' => 2,				
					'channel_name_open' => '» Centrum pomocy [ON]',	     // channel name when opened	
					'channel_name_close' => '» Centrum pomocy[OFF]',     // channel name when closed
					'needed_join_power' => 200,						//when close
					'change_maxfamily_clients' => false,			            	 // close family channels too		
				),
			),
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 20),
	),

	// ENG [Get vip channel]  #  
	'get_vip_channel' => array	// Db must be on
	(
		'enabled' => false,
		'if_client_on_channel' => array(15,16), 		// all checking channels id

		'info' => array
		(
			'VIP' => array	//Zone name for example 'VIP' | 'GOLD'
			(
				'if_on_channel' => 19,
				'server_group_copy' => 55,			// server group to copy
				'channel_group_id' => 12,			// default channel admin group
				'subchannels' => 5,				// how many subchannels
				'subchannels_red' => false,		// false - max cleints = 0 | false - max clients = unlimited
				'online_from_server_group' => false,	// create channel with information about clients from server group
				'get_server_group' => false,		// create channel add/del server group
				'after_channel' => 171,			// the first channel for example spacer
				'join_needed' => 100,
		
				'spacer_between' => array
				(
					'enabled' => false,
					'spacer_name' => '[*spacerVIP[NUM]]___',
					'join_needed' => 150,
					'modify_needed' => 100,
				),
				'main_channel' => '[lspacer] [[NUM]] ViP',	// [NUM] - vip channel number	
				'empty_topic' => '#WOLNY',			// Topic in empty channel (remember it)	
			),
			'Diamond' => array //Zone name for example 'VIP' | 'GOLD'
			(
				'if_on_channel' => 20,
				'server_group_copy' => 57,			// server group to copy
				'channel_group_id' => 12,			// default channel admin group
				'subchannels' => 15,				// how many subchannels
				'subchannels_red' => false,		// false - max cleints = 0 | false - max clients = unlimited
				'online_from_server_group' => false,	// create channel with information about clients from server group
				'get_server_group' => false,		// create channel add/del server group
				'after_channel' => 96,			// the first channel for example spacer
				'join_needed' => 150,
				
				'spacer_between' => array
				(
					'enabled' => false,
					'spacer_name' => '[*spacerDiamond[NUM]]---',
					'join_needed' => 100,
					'modify_needed' => 100,
				),
				'main_channel' => '[lspacer] [[NUM]] Diamond',	// [NUM] - vip channel number	
				'empty_topic' => '#WOLNY_D',			// Topic in empty channel (remember it)
			),
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 15),
	),

	// ENG [Get vip channel spacer]  
	'get_vip_channel_spacer' => array	// Db must be on
	(
		'enabled' => false,
		'if_client_on_channel' => array(21), 		// all checking channels id
		'create_interval' => 1000000,		// In miliseconds

		'info' => array
		(
			'Premium' => array	//Zone name for example 'VIP' | 'GOLD'
			(
				'if_on_channel' => 21,
				'server_group_copy' => 57,			// server group to copy
				'channel_group_id' => 12,			// default channel admin group
				'after_channel' => 82,			// the first channel for example spacer
				'online_from_server_group_name' => '[rspacer] [SERVER_GROUP]: [ONLINE]/[MAX]',	// [SERVER_GROUP] - group name, [ONLINE], 
			
				'spacers' => array
				(
					/*************************************
					
						'1' => array	// Growing number
						(
							'spacer' => array
							(
								'name' => '[cspacer] [[NUM]] Premium',	// [NUM] - vip channel number
								'spacer_red' => false, 					// false - max clients = 0 | false - max clients = unlimited
								'join_needed' => 10, 					// Join needed permission
								'subscribe_needed' => 0, 				// Subscribe needed permission
							),
							'subchannels' => array
							(
								'count' => 0,						// How many subchannels
								'name' => 'Podkanał [NUM]',			// [NUM] - subchannel number
								'subchannels_red' => false,			// false - max clients = 0 | false - max clients = unlimited
								'join_needed' => 0,					// Join needed permission
								'subscribe_needed' => 0, 			// Subscribe needed permission
							),
						),
						
						add `'get_group_spacer' => false` if get group must be a spacer
						add `'online_group_spacer' => false` if online from group must be a spacer
						
						add `'get_group_subchannel' => false` if get group must be in the subchannel
						add `'online_group_subchannel' => false` if online from group must be in the subchannel
					
					*************************************/
				
					'1' => array	// Main channel
					(
						'spacer' => array
						(
							'name' => '[cspacer] [[NUM]] Premium',	// [NUM] - vip channel number
							'spacer_red' => false, 					// false - max clients = 0 | false - max clients = unlimited
							'join_needed' => 10, 					// Join needed permission
							'subscribe_needed' => 0, 				// Subscribe needed permission
						),
						'subchannels' => array
						(
							'count' => 0,						// How many subchannels
							'name' => 'Podkanał [NUM]',			// [NUM] - subchannel number
							'subchannels_red' => false,			// false - max clients = 0 | false - max clients = unlimited
							'join_needed' => 0,					// Join needed permission
							'subscribe_needed' => 0, 			// Subscribe needed permission
						),
					),
					'2' => array	// Main channel
					(
						'spacer' => array
						(
							'name' => '[rspacer[NUM]] Online z:',	// [NUM] - vip channel number
							'spacer_red' => false, 					// false - max clients = 0 | false - max clients = unlimited
							'join_needed' => 10, 					// Join needed permission
							'subscribe_needed' => 0, 				// Subscribe needed permission
						),
						'subchannels' => array
						(
							'count' => 0,						// How many subchannels
							'name' => 'Podkanał [NUM]',			// [NUM] - subchannel number
							'subchannels_red' => false,			// false - max clients = 0 | false - max clients = unlimited
							'join_needed' => 0,					// Join needed permission
							'subscribe_needed' => 0, 			// Subscribe needed permission
						),
						'online_group_spacer' => false,
					),
					'3' => array	// Main channel
					(
						'spacer' => array
						(
							'name' => '[rspacer[NUM]] Nadaj grupe',	// [NUM] - vip channel number
							'spacer_red' => false, 					// false - max clients = 0 | false - max clients = unlimited
							'join_needed' => 10, 					// Join needed permission
							'subscribe_needed' => 0, 				// Subscribe needed permission
						),
						'subchannels' => array
						(
							'count' => 0,						// How many subchannels
							'name' => 'Podkanał [NUM]',			// [NUM] - subchannel number
							'subchannels_red' => false,			// false - max clients = 0 | false - max clients = unlimited
							'join_needed' => 0,					// Join needed permission
							'subscribe_needed' => 0, 			// Subscribe needed permission
						),
						'get_group_spacer' => false,
					),
					'4' => array
					(
						'spacer' => array
						(
							'name' => '[lspacerzarzad[NUM]]Zarząd',	// [NUM] - vip channel number
							'spacer_red' => false, 					// false - max clients = 0 | false - max clients = unlimited
							'join_needed' => 10, 					// Join needed permission
							'subscribe_needed' => 0, 				// Subscribe needed permission
						),
						'subchannels' => array
						(
							'count' => 3,						// How many subchannels
							'name' => 'Zarząd: [NUM]',			// [NUM] - subchannel number
							'subchannels_red' => false,			// false - max clients = 0 | false - max clients = unlimited
							'join_needed' => 20,					// Join needed permission
							'subscribe_needed' => 50, 			// Subscribe needed permission
						),
					),
					'5' => array
					(
						'spacer' => array
						(
							'name' => '[lspacerkanaly[NUM]]Kanały',	// [NUM] - vip channel number
							'spacer_red' => false, 					// false - max clients = 0 | false - max clients = unlimited
							'join_needed' => 10, 					// Join needed permission
							'subscribe_needed' => 30, 				// Subscribe needed permission
						),
						'subchannels' => array
						(
							'count' => 4,						// How many subchannels
							'name' => 'Kanał #[NUM]',			// [NUM] - subchannel number
							'subchannels_red' => false,			// false - max clients = 0 | false - max clients = unlimited
							'join_needed' => 0,					// Join needed permission
							'subscribe_needed' => 0, 			// Subscribe needed permission
						),
					),
				),
				'spacer_between' => array
				(
					'enabled' => false,
					'spacer_name' => '[*spacerPremium[NUM]]___',
					'join_needed' => 150,
					'modify_needed' => 100,
				),
			),
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 15),
	),

	// ENG [Information on channel about twitch/youtube channel]  
	'twitch_yt' => array
	(
		'enabled' => false,
		'info' => array
		(
			'twitch_enabled' => false,
			'twitch_api_key' => 'oaocbf2zpmv6807kp9jcxkwmcjvq5a', // you can change it if you want https://www.twitch.tv/settings/connections
			'twitch' => array
			(
				'izakooo' => array	//Twitch channel name
				(
					'main_channel' => array		//Channel where will be description
					(
						'channel_id' => 23,
						'channel_name' => '» [Twitch] izakooo [STATUS_TWITCH]',	//[STATUS_TWITCH] - on live or no
					),
					'follows' => array 	//Channel where will be followers count in channel name
					(
						'channel_id' => 464,
						'channel_name' => '» Followersów: [FOLLOWS]',	//[FOLLOWS] - FOLLOWS count
					),
				),
			),
			'youtube_enabled' => true,
			'youtube_api_key' => 'AIzaSyCetrt_hBJxA703e2PZXlgUB9tlAwDC3Os',
			'youtube' => array
			(
				/*****************************************
				
					'UC-suExuAUNgJmyKcxA-PGzg' => array		//YouTube channel id
					(
						'main_channel' => array		//Channel where will be description and SUBS in channel name
						(
							'channel_id' => 0,
							'channel_name' => '[ YouTuber ] Ramzes: [SUBS] subów',	//[SUBS] - subscribers	//[NAME] - youtuber nick
						),
						'videos_count' => array 	//Channel where will be Videos count in channel name
						(
							'channel_id' => 0,
							'channel_name' => '» Filmów na kanale: [VIDEOS]',	//[VIDEOS] - videos count
						),
						'views_count' => array 		//Channel where will be views count in channel name
						(
							'channel_id' => 0,
							'channel_name' => '» Wyświetleń: [VIEWS]',		//[VIEWS] - views count
						),
					),

				******************************************/
			
				'UC-lHJZR3Gqxm24_Vd_AJ5Yw' => array		//YouTube channel id
				(
					'main_channel' => array		//Channel where will be description and SUBS in channel name
					(
						'channel_id' => 75,
						'channel_name' => '»PewDiePie: [SUBS] subów',	//[SUBS] - subscribers	//[NAME] - youtuber nick
					),
					'videos_count' => array 	//Channel where will be Videos count in channel name
					(
						'channel_id' => 76,
						'channel_name' => '»Filmów na kanale:[VIDEOS]',	//[VIDEOS] - videos count
					),
					'views_count' => array 		//Channel where will be views count in channel name
					(
						'channel_id' => 77,
						'channel_name' => '»Wyświetleń:[VIEWS]',		//[VIEWS] - views count
					),
				),
			),
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 7,'seconds' => 0),
	),

	// ENG [clients online from server group] 
	'online_from_server_group' => array
	(
		'enabled' => true,
		'show_time' => true,		//only for groups which have maximal 15 members | false / false
		'max_users' => 15,			//max users in description
	
		'info' => array
		(
			/*******************************
			
			233 => array // Channel ID
			(
			//	'server_groups' => array(10), // Server groups separated by comma
				'show_description' => false,	  // Show users in description
				'only_online' => false,		  // Show only online clients
				'channel_name' => '[rspacer]Online z [SERVER_GROUP]: [ONLINE]/[MAX]', // Channel name
				'top_description' => '| Lista osób z rangi: [SERVER_GROUP] |', // Top description
			),
			
			*******************************/
			828 => array // ASS ID
			(
				'server_groups' => array(145), // Server groups separated by comma top1
				'show_description' => true,	  // Show users in description
				'only_online' => false,		  // Show only online clients
				'channel_name' => 'Online z  [SERVER_GROUP] : [ONLINE]/[MAX]', // Channel name
				'top_description' => '| [SERVER_GROUP] |', // Top description
			),
			432 => array // Channel ID 
			(
				'server_groups' => array(132), // Server groups separated by comma
				'show_description' => true,	  // Show users in description
				'only_online' => false,		  // Show only online clients
				'channel_name' => 'Online z  [SERVER_GROUP] : [ONLINE]/[MAX]', // Channel name
				'top_description' => '| [SERVER_GROUP] |', // Top description
			),
			815 => array // Channel ID 
			(
				'server_groups' => array(144), // Server groups separated by comma
				'show_description' => true,	  // Show users in description
				'only_online' => false,		  // Show only online clients
				'channel_name' => 'Online z  [SERVER_GROUP] : [ONLINE]/[MAX]', // Channel name
				'top_description' => '| [SERVER_GROUP] |', // Top description
			),
			879 => array // Channel ID
			(
				'server_groups' => array(147), // Server groups separated by comma
				'show_description' => true,	  // Show users in description
				'only_online' => false,		  // Show only online clients
				'channel_name' => 'Online z  [SERVER_GROUP] : [ONLINE]/[MAX]', // Channel name
				'top_description' => '| [SERVER_GROUP] |', // Top description
			),
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 5,'seconds' => 0),
	),

	// ENG [assign server group if client enters a channel]  
	'get_server_group' => array
	(
		'enabled' => true,
		'if_client_on_channel' => array(433,829,605,816,880),	//all checking channels id
		'delete_rang' => true, 	//delete rang if client is on channel
		'client_kick' => false, 	//Kick client from channel after assignment/deleted group | false / false
		'poke_client' => false,	//Poke client for example: You have just received clan group!
		'info' => array
		(
			//21410 => 227,	//channel id => server group id 
			433 => 132, 
			//16 => 49,
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 1),
	),

	// ENG [Ddos information] 
	'ddos_information' => array
	(
		'enabled' => false,
		'file' => 'include/cache/ddos_information.txt',
		'packet_loss' => 10,		//from what packet loss%(numeric) send global information
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 30),
	),
	
	// ENG [Informing about client in channel name]  
	'client_on_channel' => array
	(
		'enabled' => true,
		'server_groups_id' => array(105,14,15,16,17,18,19,20,12),	//all checking client's server groups
		'ignored_groups' => array(54216),
		'idle_time' => 600,	//idle time to have away status (in seconds)
		'show_description' => false,		//show description on channels
		'status' => array
		(
			'online' => 'Online',
			'offline' => 'Offline',
			'away' => 'AFK',
		),
		'info' => array
		(
			/***************************************************************

				(you can copy this to use this function many times)
			
			10 => array   //client databse id => array	
			(
				'channel_id' => 432,	//channel id	
				'format' => '[RANG] >> [NICK] >> [STATUS]',    //format on channel name [RANG] - server group name, [NICK] - client nick, [STATUS] - client status (online/away/offline)
				'fb' => '',		//If none set 0

				'email' => '',	//If none set 0
			),

			***************************************************************/

			1 => array		// client dbid => array
			(
				'channel_id' => 3,	//channel id
				'format' => '◦ [NICK] - [STATUS] ◦',		//format on channel name [RANG] - server group name, [NICK] - client nick, [STATUS] - client status (online/away/offline)
				'fb' => '',
				'email' => '',	
			),
			2 => array		// client dbid => array
			(
				'channel_id' => 4,	//channel id
				'format' => '◦ [NICK] - [STATUS] ◦',		//format on channel name [RANG] - server group name, [NICK] - client nick, [STATUS] - client status (online/away/offline)
				'fb' => '',
				'email' => '',
			),
			1344 => array		// client dbid => array
			(
				'channel_id' => 270,	//channel id
				'format' => '◦ [NICK] - [STATUS] ◦',		//format on channel name [RANG] - server group name, [NICK] - client nick, [STATUS] - client status (online/away/offline)
				'fb' => '0',
				'email' => '0',
			),
			12 => array		// client dbid => array
			(
				'channel_id' => 35,	//channel id
				'format' => '◦ [NICK] - [STATUS] ◦',		//format on channel name [RANG] - server group name, [NICK] - client nick, [STATUS] - client status (online/away/offline)
				'fb' => '0',
				'email' => '0',
			),
			1282 => array		// client dbid => array
			(
				'channel_id' => 50,	//channel id
				'format' => '◦ [NICK] - [STATUS] ◦',		//format on channel name [RANG] - server group name, [NICK] - client nick, [STATUS] - client status (online/away/offline)
				'fb' => '',
				'email' => 'random@gmail.com',
			),
			19800033 => array		// client dbid => array
			(
				'channel_id' => 25841,	//channel id
				'format' => '[[RANG]] [NICK] - [STATUS]',		//format on channel name [RANG] - server group name, [NICK] - client nick, [STATUS] - client status (online/away/offline)
				'fb' => '0',
				'email' => '0',
			),
			11000605 => array		// client dbid => array
			(
				'channel_id' => 20000007,	//channel id
				'format' => '» [[RANG]] [NICK] - [STATUS]',		//format on channel name [RANG] - server group name, [NICK] - client nick, [STATUS] - client status (online/away/offline)
				'fb' => '',
				'email' => '',	
			),
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 5,'seconds' => 0),
	),

	// ENG [Status sinusbot]  
	'status_sinusbot' => array
	(
		'enabled' => false,
		'channel_id' => 14,
		'bots_server_groups' => array(51),			
		'top_description' => 'Bots',
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0),
	),

	// ENG [List of server queries online] 
	'server_query_online' => array
	(
		'enabled' => false,
		'channel_id' => 944,
		'channel_name' => '» Server Query online: [ONLINE]', 			//[ONLINE] - Server Query online
		'top_description' => '',
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 20),
	),

	// ENG [Ban list]  
	'ban_list' => array
	(
		'enabled' => false,
		'channel_id' => 943,
		'how_many' => 10,
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0),
	),

	// ENG [Facebook posts]  
	'facebook_posts' => array
	(
		'enabled' => false,
		'channel_id' => 977,
		'channel_name' => '» Fanpage (Likes: [LIKES])',	//[LIKES] - likes count
		'page_id' => '', //You can find it on website: https://findmyfbid.com/
		'access_token' => '',
		'posts' => 5,
		'link_to_fanpage' => '',
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 1,'minutes' => 0,'seconds' => 0),
	),

	// ENG [Game servers' info]  
	'servers_info' => array
	(
		'enabled' => false,
		'info' => array
		(
			/******************************************
			
				0 => array
				(
					'type' => 'server_type',
					'host' => 'ip:port', 			//for example 195.32.532.321:1045
					'channel_id' => channel_id(value),	//for exaple 45
					'channel_name' => 'channel_name(value)',
				),

				server_type: 'cs16' - CS 1.6 server | 'csgo' - CS:GO server | 'minecraft' - Minecraft server
				All servers: https://github.com/Austinb/GameQ/tree/v3/src/GameQ/Protocols

				vars in channel name: [NAME] - name of server | [CLIENTS_ONLINE] - online clients | [CLIENTS_MAX] - max clients | [MAP] - map in CS servers | [VERSION] - version in minecraft server

				For example:
			
				0 => array	growing number from 0	(0,1,2,3,4,5,itd)
				(	
					'type' => 'cs16',
					'host' => '193.70.125.254:27030',
					'channel_id' => 20922,
					'channel_name' => 'Online: [CLIENTS_ONLINE] | Mapa: [MAP]',
					'custom_server_name' => '0',	// Set 0 if none
				),

			******************************************/

			0 => array
			(
				'type' => 'minecraft',
				'host' => '32.123.205.35:25565',
				'channel_id' => 78,
				'channel_name' => '» MC ([CLIENTS_ONLINE]/[CLIENTS_MAX])',
				'custom_server_name' => '0',	// Set 0 if none
			),
			1 => array
			(
				'type' => 'cs16',
				'host' => '213.238.173.177:27015',
				'channel_id' => 34000,
				'channel_name' => '» COD MOD ([CLIENTS_ONLINE]/[CLIENTS_MAX])',
				'custom_server_name' => '0',	// Set 0 if none
			),
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 5,'seconds' => 0),
	),

	// ENG [Users' country list]  
	'country_list' => array
	(
		'enabled' => false,
		'channel_id' => 951,
		'channel_name' => '» Osób online spoza Polski: [ONLINE]',	//[ONLINE] online clients outside the specified country
		'default_country' => 'PL',
		'top_description' => 'Lista osób ONLINE spoza Polski',
		'ignored_groups' => array(50,51),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 2,'seconds' => 0),
	),

	// ENG [Name_day in channel name] 
	'name_day' => array
	(
		'enabled' => false,
		'channel_id' => 952,
		'channel_name' => '» Imieniny: [NAME]',	//[NAME] - name
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 2,'seconds' => 0),
	),

	// ENG [Partners]  
	'partners' => array
	(
		'enabled' => false, 	
		'channel_id' => 23,
		'info' => array
		(
			'[cspacer] SomeName' => "[center][/center]",
			'[cspacer] AutoSpeak App' => "",
		),	
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0),
	),
	
	// ENG [Generate cache]  
	'generate_cache' => array
	(
		'enabled' => false, 	
		'target_file' => '/var/www/html/vip/cache/cache.txt',
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5),
	),
	
	// ENG [Get YT channel] 
	'get_yt_channel' => array	// Db must be on
	(
		'enabled' => false,
		'if_client_on_channel' => array(38), 		// all checking channels id

		'if_on_channel' => 38,
		'channel_group_id' => 12,			// default channel admin group
		'subchannels' => 5,				// how many subchannels
		'subchannels_red' => false,		// false - max cleints = 0 | false - max clients = unlimited
		'videos_count' => false,			// create channel with information about videos count on yt channel
		'views_count' => false,			// create channel with information about views count on yt channel
		'after_channel' => 79,			// the first channel for example spacer
		
		'spacer_between' => array
		(
			'enabled' => false,
			'spacer_name' => '[*spacerYT[NUM]]___',
			'join_needed' => 150,
			'modify_needed' => 100,
		),
		'main_channel' => '[cspacer]■ [[NUM]] YT ■',	// [NUM] - vip channel number	
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 10,'seconds' => 0),
	),
	
	// ENG [Away Group] 
	'away_group' => array
	(
		'enabled' => false, 	
		'server_group_copy' => 107,
		'min_idle_time' => 5*60,
		'ignored_groups' => array(51,50),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 20),
	),
	
	// ENG [Cache icons] 
	'cache_icons' => array
	(
		'enabled' => false, 	
		'icons_path' => '/var/www/html/server_icons/',
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 5,'seconds' => 0),
	),

	// ENG [Weather in cities] 
	'weather' => array
	(
		'enabled' => false, 	
		'api_key' => '47b51f4a518ec2d0adb569f7c1491ead',  //You can find api on website: openweathermap.org
		'info' =>  array
		(
			39 => array
			(
				'country_code' => 'PL', //country code	for example: Poland - PL
				'city' => 'Warszawa',	//without polish symbols
				'channel_name' => '» Pogoda - [CITY]',		//[CITY] - city name
			),
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 5,'seconds' => 0),
	),
	
	// ENG [Countdown]  
	'countdown' => array
	(
		'enabled' => false, 	
		'time_settings' => array('days' => true, 'hours' => true, 'minutes' => true),
		'info' => array
		(
			/**************************************
			
				'0' => array	// Growing number: 0, 1, 2, etc
				(
					'channel_id' => 5761,
					'channel_name' => 'Do wakacji [COUNT]',	//[COUNT] - time to/from date
					'date' => '22-06-2018 09:00',	// Format: dd-mm-YYYY GG:MM for example: 22-06-2018 09:00
					'count_type' => 'to_date',		// Count type: 'to_date' (for example time to next event), 'from_date' (for example time from server start)
				),
			
			***************************************/
		
			'0' => array
			(
				'channel_id' => 26,
				'channel_name' => '» Do [COUNT]',	//[COUNT] - time to/from date
				'date' => '03-09-2018 09:00',	// Format: dd-mm-YYYY GG:MM for example: 22-06-2018 09:00
				'count_type' => 'to_date',		// Count type: 'to_date' (for example time to next event), 'from_date' (for example time from server start)
			),
			'1' => array
			(
				'channel_id' => 27,
				'channel_name' => '» Od [COUNT]',	//[COUNT] - time to/from date
				'date' => '01-01-2018 09:00',	// Format: dd-mm-YYYY GG:MM for example: 22-06-2018 09:00
				'count_type' => 'from_date',		// Count type: 'to_date' (for example time to next event), 'from_date' (for example time from server start)
			),
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 5,'seconds' => 0),
	),
);

$config['instance']['2']['logs_system'] = array
(
	/****************************************************************************

	 	      ENG [LOGS SYSTEM]       

	****************************************************************************/

	'logs' => array
	(
		// ENG [Turn on/off logs system (false or false)]   #   PL [Wlaczenie lub wylaczenie systemu logów]
			'enabled' => true,  

		// ENG [Days, after which, log files will be deleted]   #   PL [Czas w dniach, po których pliki logów zostana usunięte]
			'delete_interval' => '1',
	),
);

$config['instance']['2']['options'] = array
(
	/****************************************************************************

	 	    ENG [INSTANCE OPTIONS]      

	****************************************************************************/

	// ENG [Folder for functions containing all events and plugins]   #   PL [Folder w którym sa wszystkie eventy i pluginy]
		'folder' 	=> 'second_instance',

	// ENG [Bot interval in seconds]  #  PL [Interwal bota w sekundach]
		'bot_interval' 	=> 5,

	// ENG ['events_plugins' or 'commands' (default 'events_plugins')]  #  PL ['events_plugins' lub 'commands' (domyślnie 'events_plugins')]
		'function_type' => 'events_plugins',
);

$config['instance']['2']['functions'] = array
(

	/**************************************

	    ENG [PLUGINS]   #   PL [PLUGINY]

	**************************************/

	'plugins' => true,

	// ENG [Connect message]  
	'connect_message' => array
	(
		'enabled' => true,
		'file' => 'include/cache/connect_message.txt',	//file to connect message
		'many_messages' => false, 			//false if single line = one message || false for one message
		'to_groups' => array(11),				//connect message to specified server_groups | set -1 to all server groups | set gorups_id separated by comma

		/************************************

		[CLIENT_IP] =  Client nickname
		[CLIENT_NICK] = Client nickname
		[CLIENT_COUNTRY] = Client country
		[CLIENT_DBID] = Client databse id
		[CLIENT_VERSION] = Client TS3 version
		[CLIENT_CONNECTIONS] = Client total connections
		[CLIENT_PLATFORM] = Client platform
		[CLIENT_TOTALCONNECTIONS] = Client total connections
		[CLIENT_LASTCONNECTED] = Client lastconnected
		[CLIENT_AWAY_MESSAGE] = Client away message
		[CLIENT_CREATED] = Client created
		[CLIENT_ON_SERVER_FOR] = Client is with server for ... for example 2 days and 1 minute

		[SERVER_MAX_CLIENTS] = Server max clients
		[SERVER_ONLINE] = Online users
		[SERVER_CHANNELS] = Channel number
		[SERVER_ID] = Virtual server id
		[SERVER_PORT] = Server port
		[SERVER_NAME] = Server name
		[SERVER_VERSION] = Server version
		[SERVER_VUI] = Server unique identifier
		[SERVER_WELCOME_MESSAGE] = Virtualserver welcomemessage
		[SERVER_PLATFORM] = Server platform
		[SERVER_HOSTMESSAGE] = Server hostmessage
		[SERVER_UPTIME] = Server uptime


		*************************************/
	),

	// ENG [Register groups assigner] 
	'groups_assigner' => array
	(
		'enabled' => true,
		'if_client_on_channel' => array(81,82), 		//all checking channels id
		'register_groups' => array(39,40),				//all register groups
		'info' => array
		(	
			81 => 39,	//channel_id => server group id,
			82 => 40,
		),
		//Minimal time on server to be registered [Db connect must be on]
		'min_time_on_server' => 0,	//in minutes
	),

	// ENG [Assign afk group] 
	'afk_group' => array
	(
		'enabled' => false,
		'afk_group' => 107,		//afk group id
		'idle_time' => 1800,		//in seconds 
		'set_group_if_away' => false, 	//set afk group if client has away status
		'set_group_if_muted'=> false,	//set afk group if client is muted
		'ignored_groups' => array(51,50,60),
		'ignored_channels' => array(),
	),

	// ENG [Move afk clients to channel]  
	'afk_move' => array
	(
		'enabled' => false,
		'channel_id' => 955,		//afk channel id
		'idle_time' => 2400,		//in seconds 
		'move_if_away' => false, 	//move client if has away status
		'move_if_muted'=> false,	//move client if is muted
		'move_back' => false,		//if client no longer afk move him back (false or false)
		'message_type' => 'poke',	//poke | message | none
		'ignored_groups' => array(50,51,60),
		'ignored_channels' => array(),
		'kick_from_server' => array
		(
			'enabled' => false,
			'min_idle_time' => 600,	//in seconds
			'msg' => 'Zbyt długi AFK!',	//Message in kick
		),
	),

	// ENG [Server groups security]   
	'groups_security' => array
	(
		'enabled' => false,
		'info' => array
		(
			/*'0' => array 				    //growing number, for example 1, 2, 3...
			(
				'group_id' => 209,		    //group Id
				'ignored_dbid' => array(10,16,42),  //privilege client database id's
				'give_back' => false,		    //give the rank back for people in ignoredId
				'type' => 'nothing', 		    //`ban`, `kick`, `nothing` (just group delete and poke)
				'message' => '',		    //message to the client; if `ban` or `kick` it's the reason, if `nothing` it's a poke message
				'time' => 5, 			    //ban timeout
			), */

			'0' => array
			(
				'group_id' => 9,					
				'ignored_dbid' => array(15),
				'give_back' => false,					
				'type' => 'ban', 					
				'message' => 'Nie mozesz miec rangi CEO!',		
				'time' => 9999999, 						
			),
			'1' => array
			(
				'group_id' => 25,					
				'ignored_dbid' => array(),
				'give_back' => false,					
				'type' => 'kick', 					
				'message' => 'Nie mozesz miec rangi Support!',	
				'time' => 5, 						
			),
			'2' => array
			(
				'group_id' => 61,					
				'ignored_dbid' => array(),
				'give_back' => false,					
				'type' => 'kick', 					
				'message' => 'Nie mozesz miec rangi TEST Support!',	
				'time' => 5, 						
			),
		),
	),

	// ENG [Baning for having warning rangs]    
	'warning_ban' => array
	(
		'enabled' => false,
		'ban_time' => '1200', // in seconds
		'ban_message' => 'Za duzo ostrzezen!',
		'with_rang' => 212, // the last warning id, for example Warning #3 (if you have 3 warnings)
		'warning_id' => array
		(
			212, // the last warning id, for example Warning #3 (if you have 3 warnings)
			146,
			144,
		),	
	),

	// ENG [Block recording users]    
	'block_recording' => array
	(
		'enabled' => false,
		'ignored_groups' => array(9),
		'type' => 'kick', 		    //`ban`, `kick`,
		'message' => 'Nie możesz nagrywać!',		    //message to the client; if `ban` or `kick` it's the reason
		'time' => 60, 			    //ban timeout

	),

	// ENG [Anty VPN]  #
	'anty_vpn' => array
	(
		'enabled' => false,
		'X-Key' => 'MjgyOnlESTNMRUJLU2FidzlTcW05Ym5VSmtaVUIwZVlQZFNp', 	// You can change at website `https://iphub.info/pricing`
		'ignored_groups' => array(9,25,61,67,59),			#ignorowane grupy
		'allowed_ips' => array('265.194.334.122'),			//dozwolone ip
		'type' => 'kick', 	//`poke`, `kick`, `ban`
		'ban_time' => '60', 	//in seconds
		'message_to_client' => "Używasz VPN'a!",
	),

	/**************************************

	     ENG [EVENTS]  

	**************************************/

	'events' => true,

	// ENG [Auto register]  
	'auto_register' => array
	(
		'enabled' => false,
		'ignored_groups' => array(41,42),
		'register_group' => 10,				//register group
		//Minimal time on server to be registered [Db connect must be on]
		'min_time_on_server' => 30,	//in minutes
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 10,'seconds' => 0),
	),

	// ENG [Advertisement message]  
	'advertisement_message' => array
	(
		'enabled' => false,
		'type' => 'chat',		//'chat' - global chat | 'pw' - pw to all users | 'poke' - poke to all users
		'advertisements' => array
		(
			/***********************

			'Zapraszamy do rejestracji!',
			'Wiadmość testowa',

			***********************/

			'[b]Supp[/b]',
			'[b]Edit me[/b]',
			'[b][color=red]Welcome on to the test server![/b]',
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 10,'minutes' => 0,'seconds' => 0),
	),

	// ENG [Time and date]  
	'clock_date' => array
	(
		'enabled' => false,
		'content' => array
		(
			'clock' => array //clock in channel name
			(
				'enabled' => false,
				'channel_id' => 15,
				'channel_name' => '» Time : [CLOCK]', 		// [CLOCK] = clock
				'format' => 'G:i', 					// format G: hours, i: minutes, s: seconds
			),
			'date' => array //date in channel name
			(
				'enabled' => false,
				'channel_id' => 17,
				'channel_name' => '» Date: [DATE]', 		// [DATE] = date
				'format' => 'd-m-Y', 					// format m: month numeric, M: month in words, d: day numeric, D: day in words, Y: year
			),
			'date_and_clock' => array
			(
				'enabled' => false,
				'channel_id' => 950,
				'channel_name' => '» Today Is : [DATE&CLOCK]', 		// [DATE&CLOCK] = date & clock
				'format' => 'd-m-Y G:i', 					// format m: month numeric, M: month in words, d: day numeric, D: day in words, Y: year, G: hours, i: minutes, s: seconds
			),		
		),	
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0),
	),

	// ENG [Change server name]  
	'change_server_name' => array
	(
		/****************************************
	
				DATE FORMAT

		m: month numeric, 
		M: month in words, 
		d: day numeric, 
		D: day in words, 
		Y: year, 
		G: hours, 
		i: minutes, 
		s: seconds

		****************************************/

		'enabled' => false,
		'ignored_groups' => array(2), //ignored groups, not included in online number
		'server_name' => 'PgUp.eu [ONLINE]/[MAX_CLIENTS] użycie slotów [%]%', //[ONLINE] - online users, [MAX_CLIENTS] - max clients, [DATE] - format higher, [%] %online
		'format' => 'd-m-Y G:i',
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 30),
		'data' => '1970-01-01 00:00:00',  //Do not change
	),

	// ENG [Client platform]  
	'client_platform' => array
	(
		'enabled' => false,
		'ignored_groups' => array(0),

		'windows_enabled' => false,
		'windows_group' => 137,

		'linux_enabled' => false,
		'linux_group' => 136,

		'android_enabled' => false,
		'android_group' => 138,
		
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 20),
	),

	// ENG [Poke admins] 
	'poke_admins' => array
	(
		'enabled' => true,
		'if_client_on_channel' => array(72),		//all checking channels
		'ignored_groups' => array(109),				//if admin has this group, bot will not poke him
		'ignored_group_if_on_channel' => array(105,14,15,16,17,18,19,20),	//if client has this group, bot will not poke admins
		'info' => array
		(
			/*************************

			###
			#	poking server groups: channel_id => array(server_groups separated by comma),
			###

			###
			#	poking client: channel_id => client_database_id,
			###

			*************************/

			72 => array(105,14,15,16,17,18,19,20),
			#114 => array(9,25,61,67),
		),
		'ignored_channels' => array(94), 	//channels where bot doesn't poke admins
		'inform_admin_once' => true,		//Poke admin only one time
		'informing_about_channel' => true, 	//inform admin about the channel on which the user needs help
		'show_client_link' => true,		//show client link ([url])
		'kick_if_away' => true,			//kick client if is away (muted microphone/headphones)
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 30),
	),
	
	// ENG [Generate banner] 
    'generate_banner' => array
    (
        /****************************************
 
        font - 'arial', 'calibri', 'inconsolata', 'tahoma'
        color - in RGB array(x, x, x) you can check colors on https://www.w3schools.com/colors/colors_rgb.asp
        co-ordinates - array(size, rotation, x, y)     
 
        ****************************************/
 
        'enabled' => false,
        'admins_online' => array    //Liczba adminow online
        (
            'enabled' => false,
            'admins_server_groups' => array(11,12,13,14,15,16,17), 
            'font' => 'calibri',
            'color' => array(255, 255, 255),
            'co-ordinates' => array(20,0,118,160),
        ),
        'clients_online' => array   //Klienci online
        (
            'enabled' => false,
            'show_max_clients' => false,
            'font' => 'calibri',
            'color' => array(255, 255, 255),
            'co-ordinates' => array(20,0,118,235),
        ),
        'record_online' => array    //Rekord online
        (
            'enabled' => false,
            'font' => 'calibri',
            'color' => array(255,255,255),
            'co-ordinates' => array(20,0,770,160),
        ),
        'clock' => array    //Zegar
        (
            'enabled' => false,
            'font' => 'calibri',
            'color' => array(255, 255, 255),
            'co-ordinates' => array(20,0,110,80),
        ),
        'channels_count' => array   //Liczba kanałów
        (
            'enabled' => false,
            'font' => 'calibri',
            'color' => array(255,255,255),
            'co-ordinates' => array(20,0,500,300),
        ),
        'name_day' => array //Imieniny
        (
            'enabled' => false,
            'font' => 'calibri',
            'color' => array(255,255,255),
            'co-ordinates' => array(15,0,455,255),
        ),
        'fanpage_likes' => array //Like'i z fanpage'a
        (
            'enabled' => false,
            'page_id' => '1719172075053504', //You can find it on website: https://findmyfbid.com/
            'access_token' => '',
            'font' => 'calibri',
            'color' => array(255,255,255),
            'co-ordinates' => array(20,0,770,80),
        ),
        'uptime' => array   //Uptime
        (
            'enabled' => false,
            'font' => 'calibri',
            'color' => array(255,255,255),
            'co-ordinates' => array(20,0,150,100),
        ),
        'date' => array //Data
        (
            'enabled' => false,
            'font' => 'calibri',
            'format' => 'd.m.Y',
            'color' => array(255,255,255),
            'co-ordinates' => array(20,0,765,240),
        ),
       
        'image_file' => array('include/cache/banner.png', 'include/cache/banner1.png', 'include/cache/banner2.png', 'include/cache/banner3.png'),
        'target_image_file' => '/var/www/html/banner.png',
        'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 10),
    ),

	// ENG [Host message]  
	'host_message' => array
	(
		'enabled' => false,
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 30),
	),

	// ENG [Live DJ]  
	'live_dj' => array
	(
		'enabled' => false,
		'info' => array
		(
			/*********************************

			channel_id => 'nazwa_kanalu', //[DJ] - dj's nick
			
			*********************************/

			48 => '» Obecny DJ: [DJ]',	//[DJ] - dj's nick
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 45),
	),

	// ENG [Count users (registered/total)]  
	'count_users' => array
	(
		'enabled' => false,	//DB must be on
		'channel_id' => 41,
		'channel_name' => '» Zarejestrowani użytkownicy: [REG]/[TOTAL]', //[REG] - registered users | [TOTAL] - total users in Db
		'unregistered_group_id' => 9,
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 30),
	),
	
	// ENG [Show client_info after join the channel]  
	'client_info' => array
	(
		'enabled' => false,
		'if_client_on_channel' => array(747),
		'message' => '[color=purple][b]Hello [u][CLIENT_NICK][/u]![/b]\n [color=blue][b][i]Poniżej przedstawimy Twoje dane:[/i][/b]\n[color=blue]IP: [CLIENT_IP]\n[color=blue]Client Database ID: [CLIENT_DBID]\n[color=blue]Wszystkich połączeń: [CLIENT_TOTALCONNECTIONS]\n[color=blue]Wersja klienta TS3: [CLIENT_VERSION]\n[color=blue]Pierwsze połączenie: [CLIENT_CREATED]\n[color=blue]Ostatnie połączenie: [CLIENT_LASTCONNECTED]\n[color=blue]Platforma: [CLIENT_PLATFORM]\n[color=blue]Kraj: [CLIENT_COUNTRY]',
		
		/************************************

		[CLIENT_IP] =  Client nickname
		[CLIENT_NICK] = Client nickname
		[CLIENT_COUNTRY] = Client country
		[CLIENT_DBID] = Client databse id
		[CLIENT_VERSION] = Client TS3 version
		[CLIENT_CONNECTIONS] = Client total connections
		[CLIENT_PLATFORM] = Client platform
		[CLIENT_TOTALCONNECTIONS] = Client total connections
		[CLIENT_LASTCONNECTED] = Client lastconnected
		[CLIENT_AWAY_MESSAGE] = Client away message
		[CLIENT_CREATED] = Client created
		[CLIENT_ON_SERVER_FOR] = Client is with server for ... for example 2 days and 1 minute

		*************************************/

		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 10),
	),

	// ENG [Event records in the channel descrition]  
	'event_records' => array
	(
		'enabled' => false,
		'if_client_on_channel' => array(52),
		'channel_id' => 5,
		'top_description' => 'Zapisy na event',	//Do not use [hr] in name!
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5),
	),
	
	// ENG [Check temporary channels' name]   
	'check_tmp_channel' => array
	(
		'enabled' => true,
		'file' => 'include/cache/nicks_security.txt',	//bad phrases separated by ,(comma) without spaces, enters etc
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 45),
	),
	
	// ENG [Check public zone]   
	'check_public_zone' => array
	(
		'enabled' => true,
		'info' => array
		(
			'0' => array	// Growing number
			(
				'channels_zone' => 131,
				'channel_name' => '» Kanał [NUM]',	//[Num] channel number
				'max_users' => 2,	// 0 = unlimited
				'mininum_channels' => 5,
				'maximum_channels' => 8,
				'icon_id' => 0,
				'modify_power' => 100,			//channel needed modify power
				'desc' => '',
			),
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5 ),
	),

	// ENG [Clear clients ranks]    
	'clear_ranks' => array
	(
		'enabled' => false,
		'if_client_on_channel' => array(43),	//all channels
		'info' => array
		(
			/**********************************

			channel_id => array(ranks_to_clear),

			**********************************/
			
			43 => array(37,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,98,99,105,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,39,63,64,65,66,41,68,69,70,71,72,73,74,75,76,77,97),
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5),
	),
	
	// ENG [Delete client permissions]    
	'delete_client_permissions' => array
	(
		'enabled' => false,
		'ignored_groups' => array(2),			//ignored server groups
		'ignored_dbids' => array(1),			//ignored database clients id
		'ignored_perms' => array('i_icon_id'),	//this perms won't be deleted
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 20),
	),
	
	// ENG [Check urls in the channel description]   
	'check_description' => array
	(
		'enabled' => false,
		// Allowed links are in the file: include/cache/allowed_links.txt
		'channels' => array(53),	// Type only parent channels
		'channel_info' => 565,		// Info about not allowed links on channels
		'check_vip_channels' => false,	// false or false
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5),
	),
	
	// ENG [Save channel edits logs in description]   
	'channels_edits' => array
	(
		'enabled' => false,
		'zones' => array
		(
			/*********************
			
			channel_id => array(checking_channels),
			
			*********************/
		
			54 => array(55,56),
		),
		'ignored_groups' => array(),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5),
	),
	
	// ENG [Fill channels' description when is empty]    
	'fill_empty_channels' => array
	(
		'enabled' => false,
		'description' => "[hr][center][/center][hr]\n\n[center][size=12][b]Change Me.[/b][/size][/center]\n[hr]",
		'needed_phrase' => "spacer",		// Channel need this phrase in name
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 1,'minutes' => 0,'seconds' => 0),
	),
);

$config['instance']['3']['logs_system'] = array
(
	/****************************************************************************

	 	      ENG [LOGS SYSTEM]      

	****************************************************************************/

	'logs' => array
	(
		// ENG [Turn on/off logs system (false or false)]   #   PL [Wlaczenie lub wylaczenie systemu logów]
			'enabled' => true,  

		// ENG [Days, after which, log files will be deleted]   #   PL [Czas w dniach, po których pliki logów zostana usunięte]
			'delete_interval' => '3',
	),
);

$config['instance']['3']['options'] = array
(
	/****************************************************************************

	 	    ENG [INSTANCE OPTIONS]      

	****************************************************************************/

	// ENG [Folder for functions containing all events and plugins]   #   PL [Folder w którym sa wszystkie eventy i pluginy]
		'folder' 	=> 'third_instance',

	// ENG [Bot interval in seconds]  #  PL [Interwal bota w sekundach]
		'bot_interval' 	=> 6,

	// ENG ['events_plugins' or 'commands' (default 'events_plugins')]  #  PL ['events_plugins' lub 'commands' (domyślnie 'events_plugins')]
		'function_type' => 'events_plugins',
);

$config['instance']['3']['functions'] = array
(
	/**************************************

	    ENG [PLUGINS]   #   PL [PLUGINY]

	**************************************/
	
	'plugins' => true,

	/**************************************

	     ENG [EVENTS]   #   PL [EVENTY]

    **************************************/

	'events' => true,

	// ENG [New users daily] 
	'new_daily_users' => array
	(
		'enabled' => false,
		'channel_id' => 44,
		'with_rang' => 9,	//checking if client has one of these rangs 
		'channel_name' => '» Nowi Użytkownicy: [NEW]', //[NEW] - how many new users
		'top_description' => 'Nowi uzytkownicy dzisiaj',
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0),
	),
	
	// ENG [Visitors] 
	'visitors' => array
	(
		'enabled' => false,
		'channel_id' => 45,
		'channel_name' => '» Odwiedzin: [VISITORS]', //[VISITORS] - how many visitors
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 15),
	),

	// ENG [Clients in your database] 
	'client_to_db' => array		//you need this event if you want to use these events -> (top_connections, top_connection_time, top_idle_t, levels)
	(	
		'enabled' => true,
		'idle_time' => 5 * 60,	//idle time in seconds
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 10),
	),

	// ENG [Top connections]  
	'top_connections' => array
	(
		'enabled' => true,
		'channel_id' =>  11,
		'top_description' => 'TOP 10 -  Liczba Połączeń',
		'records' => 10,	//how many clients
		'ignored_groups' => array(11,41,42),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 10,'seconds' => 0),
	),

	// ENG [Top connection time]  
	'top_connection_time' => array
	(
		'enabled' => true,
		'channel_id' => 13,
		'top_description' => 'TOP 10 -  Połączenie',
		'records' => 10,	//how many clients
		'ignored_groups' => array(11,41,42),
		'time_settings' => array('days' => true, 'hours' => true, 'minutes' => true),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 10,'seconds' => 0),
	),

	// ENG [Top client idle time]
	'top_idle_time' => array
	(
		'enabled' => true,
		'channel_id' => 14,
		'top_description' => 'TOP 10 - Away',
		'records' => 10,	//how many clients
		'ignored_groups' => array(11,41,42),
		'time_settings' => array('days' => true, 'hours' => true, 'minutes' => true),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 10,'seconds' => 0),
	),

	// ENG [Top time spent on server] 
	'top_time_spent' => array
	(
		'enabled' => true,
		'channel_id' => 15,
		'show_afk_time' => false,
		'top_description' => 'Top 10 Czasu Na Serwerze',
		'records' => 10,	//how many clients
		'ignored_groups' => array(11,41,42),
		'time_settings' => array('days' => true, 'hours' => true, 'minutes' => true),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 10,'seconds' => 0),
	),

	// ENG [Top week time spent on server]  
	'top_week_time' => array
	(
		'enabled' => false,
		'channel_id' => 443,
		'show_afk_time' => true,
		'top_description' => 'TOP 10 -  Czasu w Tygodniu',
		'records' => 10,	//how many clients
		'ignored_groups' => array(11,41,42),
		'time_settings' => array('days' => true, 'hours' => true, 'minutes' => true),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 10,'seconds' => 0),
	),

	// ENG [Clients levels]  
	'levels' => array
	(
		'enabled' => true,
		'ignored_groups' => array(11,41,42,14,105),
		'info' => array
		(
			44 => 48,	//lvl group sgid => hours spent on server on which the rang will be given
			50 => 96,
			51 => 144,
			52 => 192,
			53 => 240,
			54 => 288,
			55 => 336,
			56 => 384,
			57 => 432,
			58 => 480,
		),
		'all_levels_groups' => array(44,50,51,52,53,54,55,56,57,58),
		'top_description' => 'Top 10 Poziomów',
		'records' => 10,		
		'channel_id' => 12,
		'info_to_client' => 'pw',	//Info to client | 'poke' / 'pw' / 'none'
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0),
	),

	// ENG [Random group] 
	'random_group' => array
	(
		'enabled' => false,
		'must_have_group' => array(10,28),
		'ignored_groups' => array(31,43,9,25,61,67,30,81),
		'random_groups' => array(30),
		'time' => '1',	//in days	
		'records' => 15,
		'channel_id' => 66,
		'channel_name' => '» Randomowe grupy',	//[USER] - last winner's nickname		
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 4,'seconds' => 0),
	),
	
	// ENG [Statistics of admins]  
	'statistics_of_admins' => array
	(
		'enabled' => false,
		'admins_groups' => array(11,12,13,14,15,16,17),
		'max_idle_time' => 300, //in seconds
		'register' => array(48,49),
		'support_channels' => array(113,114),
		'ignored_groups' => array(),	//groups will not be counted to helped people
		'ignored_channels' => array(),	//channels where admins will not be check
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5), //Default: 5 seconds
	),

	// ENG [Write statistics of admins] 
	'write_statistics' => array
	(
		'enabled' => false,
		'admins_groups' => array(11,12,13,14,15,16,17),	//Admins groups to write on the channel description

		'groups' => array
		(
			'top_description' => '[size=14][b]Statystyki administracji[/b][/size][size=13][b]\nNadane grupy[/b][/size]',
			'channelid' => 58,
		),
		'timespent' => array
		(
			'top_description' => '[size=14][b]Statystyki administracji[/b][/size][size=13][b]\nSpędzony czas[/b][/size]',
			'channelid' => 59,
		),
		'help_center' => array
		(
			'top_description' => '[size=14][b]Statystyki administracji[/b][/size][size=13][b]\nCentrum pomocy[/b][/size]',
			'channelid' => 62,
		),

		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0),
	),
	
	// ENG [Actions logs in the channel description] 
	'actions_logs' => array
	(
		'enabled' => false, 	
		'channel_id' => 63,
		'top_description' => 'Akcje Na Serwerze',
		'records' => 30,
		'show_id' => false,	// Show action id
		'info' => array
		(
			/************************
			
				'function_name' => false/false,	//enable if you want to see logs from this function
				DO NOT ADD FUNCTIONS!
	
			************************/
		
			//Instance I
			'get_vip_channel' => true,
			'get_yt_channel' => true,
			'nicks_security' => true,
		
			//Instance II
			'groups_assigner' => true,
			'auto_register' => true,
			'block_recording' => true,
			'anty_vpn' => false,
			'poke_admins' => false,
			
			//Instance III
			'levels' => true,
			'random_group' => false,
			
			//Instance IV
			'get_private_channel' => true,
			'channels_guard' => true,
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 15),
	),
	
	// ENG [Server achievements]
	'achievements' => array
	(
		'enabled' => false, 	
		'ignored_groups' => array(31,43,11),
		'header_group' => 84,
		'footer_group' => 85,
		'info' => array
		(
			'connections' => array
			(
				'enabled' => false,
				'header_group' => 99,
				'groups' => array
				(
					/********************
					
					group_sgid => required_connections,
					
					*********************/
				
					86 => 10,
					87 => 50,
					88 => 100,
					89 => 150,
					90 => 200,
					91 => 1000,
				),
			),
			'time_spent' => array
			(
				'enabled' => false,
				'header_group' => 100,
				'groups' => array
				(
					/********************
					
					group_sgid => required_time_spent,
					
					*********************/
				
					92 => 10 * 60 * 60,
					93 => 50 * 60 * 60,
					94 => 100 * 60 * 60,
					95 => 150 * 60 * 60,
					96 => 200 * 60 * 60,
					97 => 1000 * 60 * 60,
				),
			),
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0),
	),
);

$config['instance']['4']['logs_system'] = array
(
	/****************************************************************************

	 	       ENG [LOGS SYSTEM]       

	****************************************************************************/

	'logs' => array
	(
		// ENG [Turn on/off logs system (false or false)]   

			'enabled' => true,  

		// ENG [Days, after which, log files will be deleted]   

			'delete_interval' => '3',
	),
);

$config['instance']['4']['options'] = array
(
	/****************************************************************************

	 	    ENG [INSTANCE OPTIONS]      
	****************************************************************************/

	// ENG [Folder for functions containing all events and plugins]  
		'folder' 	=> 'fourth_instance',

	// ENG [Bot interval in seconds]  #  PL [Interwal bota w sekundach]
		'bot_interval' 	=> 7,

	// ENG ['events_plugins' or 'commands' (default 'events_plugins')]  
		'function_type' => 'events_plugins',
);

$config['instance']['4']['functions'] = array
(
	/**************************************

	    ENG [PLUGINS]   #   PL [PLUGINY]

	**************************************/

	'plugins' => true,

	/**************************************

	     ENG [EVENTS]   #   PL [EVENTY]

	**************************************/

	'events' => true,

	// ENG [Channels guard] 
	'channels_guard' => array
	(
		'enabled' => true,
		'channels_zone' => 220,				//parent channel id
		'empty_channel_topic' => '$wolny',			//topic in empty channels
		'free_channel_name' => 'Prywatny Kanał - Wolny',
		'head_channel_admin_group' => 13,			//main head channel admin group id
		'check_date' => array			//check channel date in topic
		(
			'enabled' => true,
			'new_date_if_owner' => true,			//new date if the owner is on the channel
			'channel_groups' => array(13, 14, 15),			//new date must be on, type groups which can update the date on the channel
			'time_interval_warning' => 5,			//days after which the channel name will be changed
			'time_interval_delete' => 7,			//days after which the channel will be deleted	
			'warning_text' => '(ZMIEŃ DATĘ)',		//warning text added to channel name after 'time_interval_warning'
		),
		'check_channel_num' => array		//check if the next channel has number for example 1., 2., etc
		(
			'enabled' => true,	
		),
		'check_channel_name' => array		//check if the next channel has number for example 1., 2., etc
		(
			'enabled' => true,
			'file' => 'include/cache/nicks_security.txt',		//bad phrases separated by ,(comma) without spaces, enters etc
		),
		'make_empty_channels' => array		//make empty channels
		(
			'enabled' => true,
			'minimum_free_channels' => 10,
			'icon_id' => 1547656004,
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 30),
	),

	// ENG [Get private channel] 
	'get_private_channel' => array
	(
		'enabled' => true,
		'if_client_on_channel' => array(84),		//channel id
		'sub_channels' => 2,				//how many sub channels
		'head_channel_admin_group' => 13,		//main head channel admin group id
		'needed_server_group' => array(39,40),		//needed server group (you need one of them to get a private channel)
		'message_type' => 'poke',			//message type (poke or message)
		'empty_channel_topic' => '$wolny',		//topic in empty channels
		'channels_zone' => 220,			//parent channel id
		'icon_id' => 968796862,
		'subchannel_icon_id' => 968796862,
		'needed_modify_power' => 50,	//needed modify power on main channel
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5),
	),

	// ENG [Empty channels' numbers in channel description]  
	'empty_channels' => array
	(
		'enabled' => false,
		'channel_id' => 541,				//channel id
		'empty_channel_topic' => '$wolny',		//topic in empty channels
		'channels_zone' => 220,			//parent channel id
		'time_interval_delete' => 7,			//days after which the channel will be deleted
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 5,'minutes' => 0,'seconds' => 0),
	),

	// ENG [Number of private channels in channel name]  
	'private_channels_info' => array
	(
		'enabled' => false,				
		'empty_channel_topic' => '#free',		//topic in empty channels
		'channels_zone' => 958,			//parent channel id
		'total' => array
		(
			'enabled' => false,
			'channel_id' => 959,
			'channel_name' => 'Kanalow prywatnych: [NUM]',		//[NUM] - number of channels
		),
		'taken' => array
		(
			'enabled' => false,
			'channel_id' => 960,
			'channel_name' => 'Zajete: [NUM]',			//[NUM] - number of taken channels
		),
		'empty' => array
		(
			'enabled' => false,
			'channel_id' => 961,
			'channel_name' => 'Liczba wolnych kanałów: [NUM]',			//[NUM] - number of empty channels
		),
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0),
	),
);

$config['instance']['5']['logs_system'] = array
(
	/****************************************************************************

	 	       ENG [LOGS SYSTEM]       

	****************************************************************************/

	'logs' => array
	(
		// ENG [Turn on/off logs system (false or false)]  
			'enabled' => true,  

		// ENG [Days, after which, log files will be deleted]   
			'delete_interval' => '3',
	),
);

$config['instance']['5']['options'] = array
(
	/****************************************************************************

	 	    ENG [INSTANCE OPTIONS]       

	****************************************************************************/

	// ENG [Folder for functions containing all events and plugins]  
		'folder' 	=> 'fifth_instance',

	// ENG [Bot interval in miliseconds] 
		'bot_interval' 	=> 100,		//1000 = one second

	// ENG ['events_plugins' or 'commands' (default 'commands')]  #  
		'function_type' => 'commands',
		
	// ENG [Channel id for commands list] 
		'commands_list' => 65,
);

$config['instance']['5']['commands'] = array
(
	/*********************************************

	  ENG [COMMANDS]       #       PL [KOMENDY]

			
		      Explanation:

		[sgid] - server group id
		[message] - text message 
		[instance_id] -  instance id
		
	*********************************************/

	// ENG [Usage: !help]
	'help' => array
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),	// 0 - all groups
	),
	
	// ENG [Usage: !pwall-[message]]
	'pwall' => array
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),	// 0 - all groups
	),

	// ENG [Usage: !pokeall-[message]]
	'pokeall' => array
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),	// 0 - all groups
	),

	// ENG [Usage: !pwgroup-[sgid]-[message]]
	'pwgroup' => array
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),	// 0 - all groups
	),

	// ENG [Usage: !pokegroup-[sgid]-[message]]
	'pokegroup' => array
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),	// 0 - all groups
	),

	// ENG [Usage: !meeting]
	'meeting' => array
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),	// 0 - all groups
		'admins_server_groups' => array(105,12,14,15,16,17,18,19,20),
		'meeting_channel_id' => 26,
	),

	// ENG [Usage: !clients]
	'clients' => array	//clients list
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),	// 0 - all groups
	),

	// ENG [Usage: !channels]
	'channels' => array	//channels list
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),	// 0 - all groups
	),

	// ENG [Usage: !bot-[instance_id]] [Function is restarting AutoSpeak's instance]
	'bot' => array	//bot management (`starter.sh run` must be ON)	
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),	// 0 - all groups
	),

	// ENG [Usage: !ch-[client_dbid]-[subchannels]]
	'ch' => array
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),		// 0 - all groups
		'head_channel_admin_group' => 13,		//main head channel admin group id
		'message_type' => 'poke',			//message type (poke or message)
		'empty_channel_topic' => '$wolny',		//topic in empty channels
		'channels_zone' => 220,			//parent channel id
	),

	// ENG [Usage: !mute-[client_dbid]-[time_in_seconds]]
	'mute' => array		//give user specified group on specified time in seconds
	(
		'enabled' => false,
		'privileged_groups' => array(105,12,14,15,16,17,18),		// 0 - all groups
		'give_group' => 21,
	),

	// ENG [Usage: !admin-[client_dbid]]	|| Database must be connect with
	'admin' => array		//show information about specified admin
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),		// 0 - all groups
		'admins_groups' => array(105,12,14,15,16,17,18,19,20),	//all admins groups
	),

	// ENG [Usage: !tpclient-[client_nick]]
	'tpclient' => array		//moving to specified client
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),		// 0 - all groups
	),
	// ENG [Usage: !tpclient-[client_nick]]
	'move' => array		//moving to specified client
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),		// 0 - all groups
	),

	// ENG [Usage: !tpchannel-[channel_name]]
	'tpchannel' => array		//moving to specified channel
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),		// 0 - all groups
	),
	
	// ENG [Usage: !gsecurity-[type]-[client_dbid]-[group_id]	type=add or type=del
	'gsecurity' => array		//adding/del user to groups security function
	(
		'enabled' => false,
		'privileged_groups' => array(9),		// 0 - all groups
		'admins_groups' => array( 11,12,13,14,15,16,17,61,67),			//all admins groups checking in groups_security event
	),
	
	// ENG [Usage: !clientinfo-[client_dbid]]	|| Database must be connect with
	'socialspy' => array		//show information about specified client
	(
		'enabled' => true,
		'privileged_groups' => array(105,12,14,15,16,17,18),		// 0 - all groups
	),
);

$config['instance']['6']['logs_system'] = array
(
	/****************************************************************************

	 	       ENG [LOGS SYSTEM]     

	****************************************************************************/

	'logs' => array
	(
		// ENG [Turn on/off logs system (false or false)]  
			'enabled' => false,  

		// ENG [Days, after which, log files will be deleted]   
			'delete_interval' => '3',
	),
);

$config['instance']['6']['options'] = array
(
	/****************************************************************************

	 	    ENG [INSTANCE OPTIONS]     

	****************************************************************************/

	// ENG [Folder for functions containing all events and plugins]  
		'folder' 	=> 'sixth_instance',

	// ENG [Bot interval in miliseconds] 
		'bot_interval' 	=> 100,		//1000 = one second

	// ENG ['events_plugins' or 'commands' (default 'live_help')] 
		'function_type' => 'live_help', // Do not change
);

$config['instance']['6']['functions'] = array
(
	/**************************************

	    ENG [PLUGINS]   #   PL [PLUGINY]

	**************************************/

	'plugins' => false,

	/**************************************

	     ENG [EVENTS]   #   PL [EVENTY]

	**************************************/

	'events' => true,

	// ENG [Live Help]  
	'live_help' => array
	(
		'enabled' => false,
		'support_channel_id' => 956,
		'ignored_groups' => array(50,51),
		'commands_enabled' => false,

		//if not registered commands !m, !k
		'registration_groups' => array
		(
			'enabled' => false,
			'min_time' => 5,	//in minutes (DB must be on)
			'man' => array
			(
				'sgid' => 49,
				//command - !m
			),
			'woman' => array
			(
				'sgid' => 48,
				//commdn - !k
			),	
		),

		//!list, !add, !del
		'server_groups' => array
		(
			'enabled' => false,
			'info' => array
			(
				/****************************************
			
					'1' => array 				    //growing number, for example 1, 2, 3...
					(
						'server_groups' => array(52,53,54,55,56),	//server groups
						'limit' => 1,					//limit of checking groups
						'name' => 'Grupy wiekowe',
					), 
					
				****************************************/
			
				'1' => array
				(
					'server_groups' => array(39,63,64,65,66),	//checking server groups
					'limit' => 1,					//limit of checking groups 
					'name' => 'Grupy wiekowe',
				),
				'2' => array
				(
					'server_groups' => array(37,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,98,99,105),	//server groups
					'limit' => 2,					//limit of checking groups 
					'name' => 'Grupy 4Fun',
				),
				'3' => array
				(
					'server_groups' => array(108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123),	//server groups
					'limit' => 1,					//limit of checking groups 
					'name' => 'Grupy województw',
				),
			),
		),

		//!faq
		'faq' => array
		(
			'enabled' => false,
			'info' => "1. Co ja tu robię? - tak\n",
		),

		//!my_info
		'client_info' => array
		(
			'enabled' => false,
		),

		//!admin
		'poke_admins' => array
		(	
			'enabled' => false,
			
			'ignored_groups' => array(107),
			'ignored_channels' => array(), 	//channels where bot doesn't poke admins
			'show_client_link' => false,		//show client link ([url])
			'with_command' => array
			(
				'enabled' => false,
				'commands' => array
				(
					'admin' => array
					(
						'description' => 'aby uzykać pomoc',
						'admins_groups' => array(),
					),
					'groups' => array
					(
						'description' => 'aby zmienić grupy',
						'admins_groups' => array(),
					),
				),
			),
			'admins_groups' => array(), 	//all admins groups
			'poke_once' => false,			//send one poke to admin (false) or more (false)
			'poking_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5),	//Only if poke_once = false
			
		),

		//!channel
		'get_private_channel' => array
		(
			'enabled' => false,
			'sub_channels' => 2,				//how many sub channels
			'head_channel_admin_group' => 16,		//main head channel admin group id
			'message_type' => 'poke',			//message type (poke or message)
			'empty_channel_topic' => '#free',		//topic in empty channels
			'channels_zone' => 193,			//parent channel id
			'sb_delay' => 16,
		),

		//`talking` sinusbot
		'sinusbot' => array
		(
			'enabled' => false,
			'host' => '',
			'login' => 'admin',
			'password' => '',
			'instance_uid' => '7dcec583-2dc5-48de-8d11-2de90e7c7793',
			//'playlist_id' => 'a9d6335a-0b9d-460c-9e07-14da1d22cc3a',
			'playlist_id' => 'b9e1bc2c-ffbd-4e62-9b70-1a09b099b5d9',
			'bot_nick' => 'bajlandos',
			'queue_in_nick' => false,		//Show in nick number of people in queue
			'type' => 385,
		),
		
		'read_chat' => 1,	//in seconds Default 1
		'time_interval' => array('weeks' => 0,'days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 0), //Default: 0 seconds
	),
);

?>

