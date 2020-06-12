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

	$language['function']['status_sinusbot']['in_group'] = 'Bots in Gruppe';
	$language['function']['status_sinusbot']['is'] = 'ist';
	$language['function']['status_sinusbot']['active'] = 'Aktiv';
	$language['function']['status_sinusbot']['on_channel'] = 'befindet sich';
	$language['function']['status_sinusbot']['for'] = 'zeit';	

	$language['function']['random_group']['title'] = 'EListe zufälliger Gruppen';
	$language['function']['random_group']['owner'] = 'Du hast gerade eine zufällige Gruppe erhalten: ';
	$language['function']['random_group']['on_time'] = 'für:';
	$language['function']['random_group']['cong'] = 'Herzliche Glückwünsche!';
	$language['function']['random_group']['days'] = 'tage';
	$language['function']['random_group']['desc'] = 'hat einen rang bekommen';
	$language['function']['random_group']['day'] = 'am tag';

	$language['function']['write_statistics']['groups'] = '[center][B][size=11][rang_name]:[/B] [size=11][client][/size][/center]\n[b][size=10]Normale Gruppen:[/size][/b][left]●  heute: [B][today].[/B]\n●  Diese Woche: [B][weekly].[/B]\n● Diesen Monat: [B][monthly].[/B]\n● Die Anzahl aller zugewiesenen Gruppen: [B][total].[/B][/left]\n[b][size=10]Registrierungsgruppen:[/size][/b][left] heute: [B][reg_today].[/B]\ Diese Woche: [B][reg_weekly].[/B]\n Diesen Monat: [B][reg_monthly].[/B]\n  Die Anzahl aller zugewiesenen Gruppen: [B][reg_total].[/B][/left]';
	$language['function']['write_statistics']['time_spent'] = '[center][B][size=11][rang_name]:[/B] [size=11][client][/size][/center][b][size=10] Zeitaufwand: [/size][/b]\n\n[img] [size=9]heute: [B][today][/B] im dem [B][off_today][/B] als nicht verfügbar.[/size]\n [size=9]Diese Woche: [B][weekly][/B] im dem [B][off_weekly][/B] als nicht verfügbar.[/size]\n [size=9]Im laufenden Monat: [B][monthly][/B] im dem [B][off_monthly][/B] als nicht verfügbar.[/size]\n [size=9]Gesamt Zeitaufwand: [B][total][/B] im dem [B][off_total][/B] als nicht verfügbar[/size]';
	$language['function']['write_statistics']['help_center'] = '[center][B][size=11][rang_name]:[/B] [size=11][client][/size][/center]\n[b][size=10]Umfang der geleisteten Unterstützung:[/size][/b][left]● heute: [B][today_count].[/B]\n● Diese Woche: [B][weekly_count].[/B]\n● Diesen Monat: [B][monthly_count].[/B]\n● Anzahl aller Personen: [B][total_count].[/B][/left]\n[b][size=10]Hilfezeit:[/size][/b][left]  heute: [B][today_time].[/B]\n Diese Woche: [B][weekly_time].[/B]\n Diesen Monat: [B][monthly_time].[/B]\n   Gesamt Hilfezeit: [B][total_time].[/B][/left]';
	

	$language['function']['facebook_posts']['header'] = 'Liste der Beiträge von uns';
	$language['function']['facebook_posts']['written'] = 'Geschrieben:';

	$language['function']['live_dj'] = "Kein";

	$language['function']['event_records']['success'] = "Sie wurden erfolgreich aufgeschrieben!";
	$language['function']['event_records']['failed'] = "Fehler beim aufschreiben. Vielleicht bist du schon auf der Liste?";

	$language['function']['top_week_time'] = "zu Beförderung fehlt dir :";

	$language['function']['levels']['next'] = "Herzliche Glückwünsche! Du wurdest zum Level [NAME] befördert. Sie brauchen [STUNDEN] Stunden bis zum nächsten Level.";
	$language['function']['levels']['last'] = "Herzliche Glückwünsche! Du wurdest zum Level [NAME] befördert. Dies ist das letzte Level!";

	$language['function']['delete_client_permissions'] = "Hallo, Berechtigungen für Ihren Client ([PERMS]) wurden gerade entfernt, da Sie sie nicht besitzen können.";
	
	$language['function']['get_server_group']['add'] = "Sie haben gerade eine VIP-Gruppe erhalten!";
	$language['function']['get_server_group']['del'] = "Die VIP-Gruppe wurde gelöscht!";
	
	$language['function']['actions_logs']['groups_assigner'] = " wurde durch Eingabe des Kanals registriert.";
	$language['function']['actions_logs']['auto_register'] = " wurde registriert, weil er genug Zeit auf dem Server verbracht hat.";
	$language['function']['actions_logs']['block_recording'] = " wurde für die Aufnahme bestraft.";
	$language['function']['actions_logs']['anty_vpn'] = " wurde für die Verwendung eines VPN bestraft.";
	$language['function']['actions_logs']['poke_admins'] = " ging auf das hilfszentrum.";
	$language['function']['actions_logs']['get_vip_channel'] = " [TYPE] -Kanal mit der Nummer empfangen: [NUM].";
	$language['function']['actions_logs']['get_yt_channel'] = " erhielt einen YouTube-Kanal mit der Nummer: [NUM].";
	$language['function']['actions_logs']['nicks_security']['nick'] = " wurde für einen falschen Spitznamen bestraft:.";
	$language['function']['actions_logs']['nicks_security']['away'] = " wurde für unangemessene AFK-Nachricht bestraft.";
	$language['function']['actions_logs']['nicks_security']['desc'] = " wurde für unangemessene Kundenbeschreibung bestraft.";
	$language['function']['actions_logs']['wrong_nick'] = "keine keine ahnung";
	$language['function']['actions_logs']['levels'] = " wurde zum LVL befördert: [LVL].";
	$language['function']['actions_logs']['random_group'] = " Er zeichnete eine VIP-Gruppe.";
	$language['function']['actions_logs']['get_private_channel'] = " erhielt eine private Kanalnummer: [NUM].";
	$language['function']['actions_logs']['channels_guard'] = "Datum des privaten Kanals: [NUM] wurde aktualisiert.";
	
	$language['function']['weather']['weather'] = "Wetter";
	$language['function']['weather']['temperature'] = "Temperatur";
	$language['function']['weather']['status'] = "Wetterlage";
	$language['function']['weather']['speed'] = "Windgeschwindigkeit";
	$language['function']['weather']['pressure'] = "Druck";
	$language['function']['weather']['humidity'] = "Feuchtigkeit";
	$language['function']['weather']['visibility'] = "Sichtweite";
	
	$language['function']['check_ip'] = "Limit [NUMBER] Konten auf einer IP überschritten!";
	
	$language['function']['AutoSpeak_info']['instances_info'] = "instanz info";
	$language['function']['AutoSpeak_info']['instance'] = "Instanz";
	$language['function']['AutoSpeak_info']['no_info'] = "keine daten";
	$language['function']['AutoSpeak_info']['total_ram'] = "RAM";
	$language['function']['AutoSpeak_info']['info_from_server'] = "sevinf";
	
	$language['function']['check_description']['header'] = "Verdächtige Links erkannt";
	$language['function']['check_description']['bad_link'] = "[b][color=red]Link nicht erlaubt[/color][/b]";
	$language['function']['check_description']['bad_link_text'] = "falscher Link";
	$language['function']['check_description']['on_channel'] = "auf dem Kanal erkannt";
	
	$language['function']['channels_edits']['header'] = "Aktuelle Kanalausgaben:";
	$language['function']['channels_edits']['channel'] = "kanal:";
	$language['function']['channels_edits']['was_edited'] = "wurde bearbeitet von:";
	
	$language['command']['success'] = "So viele Menschen wurden erfolgreich benachrichtigt: ";
	$language['command']['success_moved'] = "So viele Administratoren wurden erfolgreich übertragen: ";
	$language['command']['success_bot'] = "|Erfolg | Warten Sie einige Sekunden auf das Ergebnis!";
	$language['command']['result'] = "Rezultat: ";
	$language['command']['suc'] = "Erfolg!";
	
	$language['command']['hi'] = "Hallo [NICK]\n :)";

	$language['command']['class']['not_command'] = 'Um den Befehl zu verwenden, verwenden Sie `!` Vor dem Befehl';
	$language['command']['class']['wrong_command'] = 'Es gibt keinen solchen Befehl: ';
	$language['command']['class']['not_privileged'] = 'Sie haben keine Berechtigung, den Befehl zu verwenden: ';
	$language['command']['class']['bad_usage'] = 'Falsche Befehlsverwendung: ';
	$language['command']['class']['bad_instance'] = 'Es gibt keine solche Instanz: ';

	$language['command']['ch']['has_channel'] = 'Der Benutzer hat bereits einen privaten Kanal!';
	$language['command']['ch']['success'] = 'Sie haben erfolgreich einen privaten Kanal mit der Anzahl der Unterkanäle erstellt: ';

	$language['command']['mute']['success'] = 'Eine Person wurde erfolgreich eingestuft: [b] [u] [NICK] [/ u] [/ b] für die Anzahl der Sekunden: ';

	$language['command']['admin']['no_admin'] = 'Diese Person hat keine Administratorgruppe!';
	$language['command']['admin']['no_in_db'] = 'Keine angegebene Person in der Datenbank!';
	$language['command']['admin']['info'] = '\ n ● [b] [u] Allgemeine Informationen: [/ u] [/ b] \ n \ tNick: [b] [nick] [/ b] \ n \ tClient-Datenbank-ID: [b] [dbid] [/ b] \ n \ tClient-UID: [b] [uid] [/ b] \ n \ tVerbindungen zum Server: [b] [con] [/ b] \ n \ tZeit auf dem Server verbrachte Zeit: [b] [time_spent] [ / b] \ n \ n';
	$language['command']['admin']['info_2'] = '\n● [b][u]Zugewiesene Normale Gruppen:[/u][/b]\n\theute: [b][today][/b]\n\tDiese Woche: [b][weekly][/b]\n\tDiesen Monat: [b][monthly][/b]\n\tDie Anzahl aller zugewiesenen Gruppen: [b][total][/b]\n\n● [b][u]Zugewiesene Registrierungsgruppen:[/u][/b]\n\theute: [b][reg_today][/b]\n\tDiese Woche: [b][reg_weekly][/b]\n\tDiesen Monat: [b][reg_monthly][/b]\n\tDie Anzahl aller zugewiesenen Gruppen: [b][reg_total][/b]\n\n● [b][u]Zeitaufwand:[/u][/b] \n\theute: [color=green][b][today_time][/b][/color] w tym [color=red][b][off_today][/b][/color] als nicht verfügbar\n\tDiese Woche: [color=green][b][weekly_time][/b][/color] im dem [color=red][b][off_weekly][/b][/color] als nicht verfügbar\n\tIm laufenden Monat: [color=green][b][monthly_time][/b][/color] w tym [color=red][b][off_monthly][/b][/color] als nicht verfügbar.\n\tGesamt Zeitaufwand: [color=green][b][total_time][/b][/color] w tym [color=red][b][off_total][/b][/color] als nicht verfügbar';
	
	$language['command']['socialspy']['no_in_db'] = 'Keine angegebene Person in der Datenbank!';
	$language['command']['socialspy']['info'] = '\n● [b][u]Infos:[/u][/b]\n\tNick: [b][nick][/b]\n\tClient database id: [b][dbid][/b]\n\tClient UID: [b][uid][/b]\n\tSerververbindungen: [b][con][/b]\n\tZeit auf dem Server verbracht: [b][time_spent][/b]\n\n';
	$language['command']['socialspy']['info_2'] = '\n● [b][u]Ändern der Spitznamen des Benutzers:[/u][/b]\n';
	$language['command']['socialspy']['change_nick'] = 'Spitzname geändert';

	$language['command']['tpclient']['to_small'] = 'Spitzname zu kurz! Sie müssen mindestens 3 Zeichen eingeben!';
	$language['command']['move']['to_small'] = 'Spitzname zu kurz! Sie müssen mindestens 3 Zeichen eingeben!';
	$language['command']['tpclient']['not_finded'] = 'Benutzer wurde nicht gefunden.';
	$language['command']['move']['not_finded'] = 'Benutzer wurde nicht gefunden.';

	$language['command']['tpchannel']['to_small'] = 'kanalname zu kurz! Sie müssen mindestens 5 Zeichen eingeben!';
	$language['command']['tpchannel']['not_finded'] = 'Kanal nicht gefunden.';

	$language['command']['gsecurity']['wrong_group'] = 'Die angegebene Gruppe wird nicht in der Konfiguration gespeichert.';
	$language['command']['gsecurity']['wrong_type'] = 'Ungültiger Typ, verwenden Sie "add" oder "del".';
	$language['command']['gsecurity']['added'] = '[B] [NICK] [/ b] wurde erfolgreich zur [SGID] -Gruppe hinzugefügt [color = green] [/ color].';
	$language['command']['gsecurity']['deleted'] = '[B] [NICK] [/ b] wurde erfolgreich [color = red] [/ color] aus der Gruppe [SGID] entfernt.';
	$language['command']['gsecurity']['wrong_deleted'] = 'Der Benutzer [b] [NICK] [/ b] befindet sich nicht in der Cache-Datei und kann daher nicht gelöscht werden.';
	
	$language['command']['help']['info']['help'] = 'Listet alle Befehle auf';
	$language['command']['help']['info']['pwall'] = 'Sendet eine private Nachricht an alle Clients';
	$language['command']['help']['info']['pokeall'] = 'spricht alle Kunden an';
	$language['command']['help']['info']['pwgroup'] = 'Sendet eine private Nachricht an Clients mit dem ausgewählten Serverrang';
	$language['command']['help']['info']['pokegroup'] = 'spricht alle Kunden an mit dem ausgewählten Serverrang';
	$language['command']['help']['info']['meeting'] = 'Übertragen Sie die Verwaltung auf den ausgewählten Kanal';
	$language['command']['help']['info']['clients'] = 'Zeigt eine Liste aller Clients an';
	$language['command']['help']['info']['channels'] = 'Zeigt eine Liste aller Kanäle an';
	$language['command']['help']['info']['bot'] = 'Verwaltung von Bot-Instanzen';
	$language['command']['help']['info']['ch'] = 'Erstellt einen privaten Kanal für den Benutzer mit der angegebenen Anzahl von Unterkanälen';
	$language['command']['help']['info']['mute'] = 'Gibt dem Benutzer den in der Konfiguration angegebenen Rang für die angegebene Anzahl von Sekunden';
	$language['command']['help']['info']['admin'] = 'Druckt Informationen zum angegebenen Administrator';
	$language['command']['help']['info']['tpclient'] = 'Verschiebt Sie zu dem Benutzer mit dem angegebenen Spitznamen';
	$language['command']['help']['info']['move'] = 'nicht fertig ;/';
	$language['command']['help']['info']['tpchannel'] = 'Verschiebt Sie zu einem Kanal mit dem angegebenen Namen';
	$language['command']['help']['info']['gsecurity'] = 'Sendet / nimmt eine Gruppe aus der Funktion security () der Gruppe';
	$language['command']['help']['info']['socialspy'] = 'Druckt Informationen über den angegebenen Benutzer';

	$language['command']['help']['usage']['help'] = '!help';
	$language['command']['help']['usage']['pwall'] = '!pwall-[Botschaft]';
	$language['command']['help']['usage']['pokeall'] = '!pokeall-[Botschaft]';
	$language['command']['help']['usage']['pwgroup'] = '!pwgroup-[id_grupy]-[Botschaft]';
	$language['command']['help']['usage']['pokegroup'] = '!pokegroup-[id_grupy]-[Botschaft]';
	$language['command']['help']['usage']['meeting'] = '!meeting';
	$language['command']['help']['usage']['clients'] = '!clients';
	$language['command']['help']['usage']['channels'] = '!channels';
	$language['command']['help']['usage']['bot'] = '!bot-[instanz_id]';
	$language['command']['help']['usage']['ch'] = '!ch-[client_database_id]-[Anzahl_der_Unterkanäle]';
	$language['command']['help']['usage']['mute'] = '!mute-[client_database_id]-[Anzahl_der_Sekunden]';
	$language['command']['help']['usage']['admin'] = '!admin-[client_database_id]';
	$language['command']['help']['usage']['tpclient'] = '!tpclient-[client_nick]';
	$language['command']['help']['usage']['move'] = '!move-[client_nick]';
	$language['command']['help']['usage']['tpchannel'] = '!tpchannel-[Kanal_Name]';
	$language['command']['help']['usage']['gsecurity'] = '!gsecurity-[add/del]-[client_database_id]-[group_id]';
	$language['command']['help']['usage']['socialspy'] = '!socialspy-[client_database_id]';

	$language['command']['help']['privileged'] = 'können verwenden: ';
	$language['command']['help']['inf'] = 'Information: ';
	$language['command']['help']['us'] = 'Verwendung: ';

	$language['live_help'] = array
	(
		//Register
		'not_registered' => 'LiveHelp hat festgestellt, dass Sie noch nicht registriert sind.',
		'reg_man' => 'um sich als Mann zu registrieren',
		'reg_woman' => 'um sich als Frau zu registrieren',

		//Menu
		'header' => "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n[b]LiveHelp[/b]\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n \n",
		'menu' => 'um eine Liste von Befehlen anzuzeigen',
		'add' => 'um sich einen Rang zu geben',
		'del' => 'um sich einen Rang zu entfernen',
		'list' => 'um eine Liste von Rängen anzuzeigen',
		'faq' => 'um faq anzuzeigen',
		'client_info' => 'um Informationen über Sie anzuzeigen',
		'!admin' => 'um den admin anzurufen',
		'registered' => 'Sie haben sich gerade registriert!',
		'group_list' => 'Liste der Servergruppen',
		'write' => 'Schrieb',
		'wait_admin' => 'Sie warten auf die Hilfe des Administrators!',
		'cancel_help' => 'um die Hilfe eines Administrators abzubrechen',	
		'success_exit' => 'Die Admin-Hilfe wurde erfolgreich abgebrochen!',
		'channel' => 'um einen privaten Kanal zu bekommen',
		'help_commands' => 'Hilfe bekommen:',

		//Poke admins
		'admin_informed' => 'Der Administrator wurde bereits benachrichtigt!',
		'admin_on_channel' => 'Der Administrator befindet sich bereits im Hilfekanal!',
		'help_status' => 'Hilfe STATUS',

		//Server Groups
		'received_rang' => 'Sie haben gerade Ihren gewählten Rang erhalten!',
		'del_rang' => 'Du wurdest gerade aus dem Rang entfernt!',
		'limit' => 'Du hast den Rang-limit erreicht!',
		'not_have' => 'Du hast keinen solchen Rang!',
		'wrong_rang' => 'Falscher Rang!',
		'group_number' => 'Gruppennummer',

		//FAQ
		'info' => 'Informationen über dich:',
		'version' => 'Anwendungsversion:',
		'country' => 'Land:',

		'bot_nick' => '[NAME] | Leute in: [NUM]',
		'wrong_command' => 'Unbekannter Befehl!',
	);

?>
