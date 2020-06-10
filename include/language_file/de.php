  <?php
	

	$language['which'] = 'de';

	$language['core'][0] = 'TeamSpeak3 bot';
	$language['core'][1] = 'Version';
	$language['core'][2] = 'Lade funktions';
	$language['core'][3] = 'Konfigurationsdatei wird geladen';
	$language['core'][4] = 'laden Klasse TS3 Admin Class';
	$language['core'][5] = 'Erfolgreich geladen: ';
	$language['core']['plugins'][1] = ' plugin';
	$language['core']['plugins'][2] = ' plugins';
	$language['core']['plugins'][3] = ' plugins';
	$language['core']['events'][1] = ' event';
	$language['core']['events'][2] = ' events';
	$language['core']['events'][3] = ' evente';
	$language['core']['commands'][1] = ' Befehl';
	$language['core']['commands'][2] = ' Befehle';
	$language['core']['commands'][3] = ' Befehlw';
	$language['core']['misconfigured'] = ' wurde falsch konfiguriert';
	$language['core']['console'] = 'Konsole:';
	$language['core']['database'] = 'Mit der Datenbank verbunden';
	$language['core']['license'] = 'Lizenzvalidierung';
	$language['core']['black_list_info'] = '[color=red]Ja';
	
	$language['logs']['core']['bad_license'] = 'Nien!';
	$language['logs']['core']['error']['database'] = 'Mysql Fehler';
	$language['logs']['core']['error']['file'] = 'Die angegebene Funktion, die sich in den Dateien befindet, wurde in der Konfiguration nicht gefunden';
	$language['logs']['core']['error']['login'] = 'Admin query Fehler';
	$language['logs']['core']['error']['port'] = 'Fehlerhadter Port';
	$language['logs']['core']['error']['bot_name'] = 'nick fehler gebe: @ zu den namen';
	$language['logs']['core']['error']['bot_name_2'] = 'nick (zu lang)';
	$language['logs']['core']['error']['default_channel'] = 'Bot konnte den Kanal nicht wechseln';
	$language['logs']['core']['error']['connection_lost'] = 'Der Bot hat die Serververbindung verloren!';
	$language['logs']['core']['error']['connection_lost_db'] = 'Bot hat die Verbindung zur Datenbank verloren!';
	$language['logs']['core']['error']['live_help'] = 'Bot LiveHelp fehler ?';
	$language['logs']['core']['error']['instance_off'] = 'Diese Instanz ist deaktiviert!';
	$language['logs']['core']['error']['bad_instance'] = 'Bot keine instanz!';
	$language['logs']['core']['error']['php_module'] = 'Bot PHP: fehler ';
	
	$language['logs']['core']['license_info']['downloading'] = 'Informationen vom Server abrufen: ';
	$language['logs']['core']['license_info']['success'] = 'Sieg HEIL!';
	$language['logs']['core']['license_info']['error'] = 'Fehler';
	$language['logs']['core']['license_info']['poke_info'] = 'Neue Nachricht vom Bot-Server! Siehe pw.';
	$language['logs']['core']['license_info']['welcome'] = '»Hallo Administrator ([b] [NICK] [/ b]), hier sind die neuesten Nachrichten vom Bot-Server:';
	$language['logs']['core']['license_info']['content'] = 'Inhalt:';
	$language['logs']['core']['license_info']['written'] = 'Schrieb:';
	
	$language['logs']['database']['created'] = 'Die Tabelle wurde erfolgreich erstellt: ';
	$language['logs']['database']['cant_created'] = 'Fehler beim Erstellen der Tabelle: [TABLE_NAME]. Sie müssen es manuell einfügen!';

	$language['logs']['start'] = 'Bot hatt gestartet';
	$language['logs']['cant_connect'] = 'Der Bot könnte nicht eine Verbindung zum Server herstellen!';
	$language['logs']['functions'] = 'Funktion ausführen ';

	$language['logs']['groups_security']['ban'] = 'wurde wegen folgenden Ranges verboten: ';
	$language['logs']['groups_security']['kick'] = 'wurde rausgeworfen, weil er den Rang hatte: ';
	$language['logs']['groups_security']['nothing'] = " wurde angesprochen und des Ranges beraubt: ";	

	$language['function']['error']['api'] = "[hr][center]\n● [size=13][B]Lista błędów[/B][/size][list][*][size=9][b]Błąd [u]połączenia z API[/u][/size][/list]\n";
	$language['function']['error']['too_long'] = "[hr][center]\n● [size=13][B]Lista błędów[/B][/size][list][*][size=9][b]Błąd [u]nazwa kanału lub opisu jest za długa[/u][/size][/list]\n";
	
	$language['function']['show_link'] = " - [url=[LINK]]Profil[/url]";
	
	$language['ends_of_words']['one_day'] = "tag";
	$language['ends_of_words']['2_days'] = "tage";
	$language['ends_of_words']['other_days'] = "tage";
	$language['ends_of_words']['one_hour'] = "stunde";
	$language['ends_of_words']['2_hours'] = "stunden";
	$language['ends_of_words']['other_hours'] = "stunden";
	$language['ends_of_words']['one_minute'] = "minute";
	$language['ends_of_words']['2_minutes'] = "minuten";
	$language['ends_of_words']['other_minutes'] = "minuten";
	$language['ends_of_words']['seconds'] = "sekunden";
	$language['ends_of_words']['zero'] = "unter eine minute";
	
	$language['function']['connect_message']['one_day'] = "tag";
	$language['function']['connect_message']['2_days'] = "tage";
	$language['function']['connect_message']['other_days'] = "tage";
	$language['function']['connect_message']['one_hour'] = "stunde";
	$language['function']['connect_message']['2_hours'] = "stunden";
	$language['function']['connect_message']['other_hours'] = "stunden";
	$language['function']['connect_message']['one_minute'] = "minute";
	$language['function']['connect_message']['2_minutes'] = "minuten";
	$language['function']['connect_message']['other_minutes'] = "minuten";
	$language['function']['connect_message']['seconds'] = "sekunden";

	$language['function']['get_vip_channel']['message'] = "Sie haben gerade ein Kanal [TYP] mit der Nummer [NUM] erhalten! Herzliche Glückwünsche!";
	$language['function']['get_vip_channel']['has_channel'] = "Du hast bereits einen Kanal [TYPE]";
	$language['function']['get_vip_channel']['top_desc'] = "Kanal [TYPE] nr: ";
	$language['function']['get_vip_channel']['error_db'] = "Bot Keine Datenbankverbindung!";
	$language['function']['get_vip_channel']['error_main'] = "Fehler beim Erstellen des Hauptkanals. Vielleicht gibt es einen Kanal mit diesem Namen?";
	$language['function']['get_vip_channel']['error_spacer'] = "Fehler beim Erstellen des Abstandshalters. Vielleicht gibt es schon so einen spacer?";
	$language['function']['get_vip_channel']['error'] = "[ERROR] Überprüfen Sie die Bot-Protokolle!";
	
	$language['function']['warning_ban']['user_banned'] = "benutzer Wurde gebannt: ";

	$language['function']['twitch_yt']['info'] = "Information: ";
	$language['function']['twitch_yt']['playing'] = "Spielt: ";
	$language['function']['twitch_yt']['follows'] = "Followersów: ";
	$language['function']['twitch_yt']['views'] = "Ansichten: ";
	$language['function']['twitch_yt']['viewers'] = "Zuschauer: ";
	$language['function']['twitch_yt']['subs'] = "Subskribente: ";
	$language['function']['twitch_yt']['videos'] = "Filme auf dem Kanal: ";
	$language['function']['twitch_yt']['click'] = "[KLIK]";
	$language['function']['twitch_yt']['streaming'] = "LIVE";
		
	$language['function']['admins_meetin']['moved'] = " Administratoren wurden erfolgreich auf den Meeting-Kanal übertragen.";
	$language['function']['admins_meeting']['information'] = " , Erinnern Sie sich an die bevorstehende Verwaltungssitzung";

	$language['function']['groups_assigner']['has_rang'] = "Sie haben bereits einen Registrierungsrang!";
	$language['function']['groups_assigner']['received_rang'] = "Sie haben gerade den Registrierungsrang erhalten!";
	$language['function']['groups_assigner']['error'] = "Sie erfüllen die Anforderungen nicht! Sie müssen ein Minimum von:";
	$language['function']['groups_assigner']['min'] = "minuten.";

	$language['function']['auto_register']['received_rang'] = "Sie haben gerade den Bestätigungsrang erhalten, weil Sie eine bestimmte Zeit auf dem Server verbracht haben!";

	$language['function']['connect_message']['one_day'] = "tag";
	$language['function']['connect_message']['2_days'] = "tage";
	$language['function']['connect_message']['other_days'] = "tage";
	$language['function']['connect_message']['one_hour'] = "stunde";
	$language['function']['connect_message']['2_hours'] = "stunden";
	$language['function']['connect_message']['other_hours'] = "stunden";
	$language['function']['connect_message']['one_minute'] = "minute";
	$language['function']['connect_message']['2_minutes'] = "minuten";
	$language['function']['connect_message']['other_minutes'] = "minut";
	$language['function']['connect_message']['seconds'] = "sekunden";

	$language['function']['host_message'] = "Willkommen bei [b] [SERVER_NAME] [/ b] \ n Derzeit ist [b] [SERVER_ONLINE] / [SERVER_MAX_CLIENTS] [/ b] online. \ NServer ist bereits seit [b] [SERVER_UPTIME] online [/ b]. \ n Wir wünschen Ihnen angenehme Gespräche!";

	$language['function']['poke_admins']['hi'] = "Hallo";
	$language['function']['poke_admins']['in_this_moment'] = "Momentan stehen Ihnen so viele Administratoren zur Verfügung: ";
	$language['function']['poke_admins']['help'] = "Bald wird dir jemand helfen!";
	$language['function']['poke_admins']['no_admins'] = "Leider ist momentan kein Administrator verfügbar. Bitte kommen Sie später wieder";
	$language['function']['poke_admins']['wants_help'] = "wartet auf deine hilfe!";
	$language['function']['poke_admins']['on_channel'] = "Auf Kanal: ";
	$language['function']['poke_admins']['informed'] = "wurde über Ihren Aufenthalt auf diesem Kanal informiert!";
	$language['function']['poke_admins']['away'] = "Sie können keinen AWAY Status haben !";
	$language['function']['poke_admins']['input'] = "Sie können das Mikrofon nicht ausschalten!";
	$language['function']['poke_admins']['output'] = "Sie können nicht stummgeschaltet sein!";

	$language['function']['admin_list']['on_channel'] = "Kanal ";
	$language['function']['admin_list']['for'] = "zeit";
	$language['function']['admin_list']['no_admins'] = "In dieser Servergruppe befinden sich keine Administratoren";
	
	$language['function']['admin_list_online']['on_channel'] = "Auf dem Kanal: ";
	$language['function']['admin_list_online']['online'] = "Online zeit: ";
	$language['function']['admin_list_online']['no_admins'] = "Keine Administratoren verfügbar";

	$language['function']['online_from_server_group'] = "In dieser Servergruppe befinden sich keine Personen"; 

	$language['function']['afk_move']['moved'] = "Sie wurden zum AFK-Kanal verschoben";
	$language['function']['afk_move']['moved_back'] = "Du wurdest zurück zu deinem Kanal verschoben";

	$language['function']['nicks_security']['kick_message'] = "Dein Spitzname enthält eine falsche Phrase: ";
	$language['function']['nicks_security']['bad_away_message'] = "Deine away message enthält eine falsche Phrase: ";
	$language['function']['nicks_security']['bad_desc'] = "Ihre Beschreibung enthält den falschen Satz: ";
	$language['function']['nicks_security']['ban'] = "Zu viele Einträge mit einem schlechten Spitznamen";

	$language['function']['top_connections']['connect'] = "verbindungen";

	$language['function']['record_online'][0] = "[b] Information - Server [/ b] \ n Aufzeichnung der verfügbaren Benutzer";
	$language['function']['record_online'][1] = "Der aktuelle rekord ist:";
	$language['function']['record_online'][2] = "Der Rekord wurde eingestellt:";

	$language['function']['channels_guard']['private_channel'] = "Privater Kanal Nr: ";
	$language['function']['channels_guard']['empty'] = " [FREI]";
	$language['function']['channels_guard']['how_to_get'] = "Um es zu bekommen, gehe zum richtigen Kanal";
	$language['function']['channels_guard']['wrong_name'] = "Falscher Kanalname!";
	$language['function']['channels_guard']['bad_name'] = "Illegale Phrase im Namen!";
		
	$language['function']['get_private_channel']['hasnt_rang'] = "Du hast nicht den richtigen Rang!";
	$language['function']['get_private_channel']['has_channel'] = "Sie haben bereits einen Kanal bei uns!";
	$language['function']['get_private_channel']['get_channel'] = "Sie haben gerade einen privaten Kanal erhalten!";
	$language['function']['get_private_channel']['no_empty'] = "Derzeit gibt es keine freien Kanäle!";
	$language['function']['get_private_channel']['channel_name'] = "Privater Kanal - ";
	$language['function']['get_private_channel']['created'] = "Erstellungsdatum: ";
	$language['function']['get_private_channel']['sub_channel'] = " Unterkanal";
	$language['function']['get_private_channel']['private_channel'] = "Privater Kanal Nr: ";
	$language['function']['get_private_channel']['not_empty'] = " [besetzt]";
	$language['function']['get_private_channel']['owner'] = "Inhaber: ";
	$language['function']['get_private_channel']['hi'] = "Hallo ";
	$language['function']['get_private_channel']['channel_created'] = "Wir haben für dich gerade einen privaten Kanal erstellt Nr: ";
	$language['function']['get_private_channel']['default_pass'] = "Das Standardkennwort lautet: 123";
	$language['function']['get_private_channel']['gl&hf'] = 'Änderung in include / language_file / de.php';

	$language['function']['empty_channels']['list'] = 'Kanalliste';
	$language['function']['empty_channels']['free'] = 'freie';
	$language['function']['empty_channels']['to_del'] = 'Zu entfernen';
	$language['function']['empty_channels']['days'] = array
	(
		0 => 'Sonntag',
		1 => 'Montag',
		2 => 'Dienstag',
		3 => 'Mittwoch',
		4 => 'Donnerstag',
		5 => 'Freitag',
		6 => 'Samstag',
	);
	$language['function']['empty_channels']['tomorrow'] = "Morgen";

	$language['function']['ban_list'] = array
	(
		'header' => "alle: ",
		'permament' => "permanent",
		'user' => "benutzer",
		'time' => "Dauer",
		'reason' => "Grund",
		'invoker' => "Ban Schöpfer",
		'date' => "Am Tag",
	);
