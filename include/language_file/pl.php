<?php
	

	$language['which'] = 'pl';

	$language['core'][0] = 'TeamSpeak3 bot';
	$language['core'][1] = 'Wersja';
	$language['core'][2] = 'Wczytywanie funkcji';
	$language['core'][3] = 'Wczytywanie pliku konfiguracyjnego';
	$language['core'][4] = 'Wczytywanie klasy TS3 Admin Class';
	$language['core'][5] = 'Pomyślnie wczytano: ';
	$language['core']['plugins'][1] = ' plugin';
	$language['core']['plugins'][2] = ' pluginy';
	$language['core']['plugins'][3] = ' pluginów';
	$language['core']['events'][1] = ' event';
	$language['core']['events'][2] = ' eventy';
	$language['core']['events'][3] = ' eventów';
	$language['core']['commands'][1] = ' komenda';
	$language['core']['commands'][2] = ' komendy';
	$language['core']['commands'][3] = ' komend';
	$language['core']['misconfigured'] = ' został źle skonfigurowany';
	$language['core']['console'] = 'Konsola:';
	$language['core']['database'] = 'Połączono z bazą danych';
	$language['core']['license'] = 'Sprawdzanie poprawności licencji';
	$language['core']['black_list_info'] = '[color=red]Tak';
	
	$language['logs']['core']['bad_license'] = 'Niet!';
	$language['logs']['core']['error']['database'] = 'Błąd mysql';
	$language['logs']['core']['error']['file'] = 'Podana funckja, która jest w plikach nie została znaleziona w configu';
	$language['logs']['core']['error']['login'] = 'Admin query błąd';
	$language['logs']['core']['error']['port'] = 'Błędny Port';
	$language['logs']['core']['error']['bot_name'] = 'nick fehler dodaję: @';
	$language['logs']['core']['error']['bot_name_2'] = 'nick (zbyt długi)';
	$language['logs']['core']['error']['default_channel'] = 'Bot nie mógł zmienić kanału';
	$language['logs']['core']['error']['connection_lost'] = 'Bot utracił połączenie serwerem!';
	$language['logs']['core']['error']['connection_lost_db'] = 'Bot utracił połączenie z bazą danych!';
	$language['logs']['core']['error']['live_help'] = 'Bot LiveHelp fehler ?';
	$language['logs']['core']['error']['instance_off'] = 'Ta instancja jest wyłączona!';
	$language['logs']['core']['error']['bad_instance'] = 'Bot keine instanz!';
	$language['logs']['core']['error']['php_module'] = 'Bot PHP: fehler ';
	
	$language['logs']['core']['license_info']['downloading'] = 'Pobieranie informacji z serwera: ';
	$language['logs']['core']['license_info']['success'] = 'Sieg HEIL!';
	$language['logs']['core']['license_info']['error'] = 'Fehler';
	$language['logs']['core']['license_info']['poke_info'] = 'Nowa wiadomość z serwera Bot! Patrz pw.';
	$language['logs']['core']['license_info']['welcome'] = '» Witaj administratorze ([b][NICK][/b]), oto najnowsze newsy z serwera Bot:';
	$language['logs']['core']['license_info']['content'] = 'Treść:';
	$language['logs']['core']['license_info']['written'] = 'Napisano:';
	
	$language['logs']['database']['created'] = 'Pomyślnie utworzono tabelę: ';
	$language['logs']['database']['cant_created'] = 'Błąd przy tworzeniu tabeli: [TABLE_NAME]. Trzeba wstawić ją ręcznie!';

	$language['logs']['start'] = 'Bot wystartował';
	$language['logs']['cant_connect'] = 'Bot nie mógł nawiązać połączenia z serwerem!';
	$language['logs']['functions'] = 'Wykonywanie funkcji ';

	$language['logs']['groups_security']['ban'] = ' został zbanowany za posiadanie rangi: ';
	$language['logs']['groups_security']['kick'] = ' został zkickowany za posiadanie rangi: ';
	$language['logs']['groups_security']['nothing'] = " został zpoke'owany i pozbawiony rangi: ";	

	$language['function']['error']['api'] = "[hr][center]\n● [size=13][B]Lista błędów[/B][/size][list][*][size=9][b]Błąd [u]połączenia z API[/u][/size][/list]\n";
	$language['function']['error']['too_long'] = "[hr][center]\n● [size=13][B]Lista błędów[/B][/size][list][*][size=9][b]Błąd [u]nazwa kanału lub opisu jest za długa[/u][/size][/list]\n";
	
	$language['function']['show_link'] = " - [url=[LINK]]Profil[/url]";
	
	$language['ends_of_words']['one_day'] = "dzień";
	$language['ends_of_words']['2_days'] = "dni";
	$language['ends_of_words']['other_days'] = "dni";
	$language['ends_of_words']['one_hour'] = "godzinę";
	$language['ends_of_words']['2_hours'] = "godziny";
	$language['ends_of_words']['other_hours'] = "godzin";
	$language['ends_of_words']['one_minute'] = "minutę";
	$language['ends_of_words']['2_minutes'] = "minuty";
	$language['ends_of_words']['other_minutes'] = "minut";
	$language['ends_of_words']['seconds'] = "sekund";
	$language['ends_of_words']['zero'] = "poniżej jednej minuty";
	
	$language['function']['connect_message']['one_day'] = "dzień";
	$language['function']['connect_message']['2_days'] = "dni";
	$language['function']['connect_message']['other_days'] = "dni";
	$language['function']['connect_message']['one_hour'] = "godzinę";
	$language['function']['connect_message']['2_hours'] = "godziny";
	$language['function']['connect_message']['other_hours'] = "godzin";
	$language['function']['connect_message']['one_minute'] = "minutę";
	$language['function']['connect_message']['2_minutes'] = "minuty";
	$language['function']['connect_message']['other_minutes'] = "minut";
	$language['function']['connect_message']['seconds'] = "sekund";

	$language['function']['get_vip_channel']['message'] = "Właśnie otrzymałeś kanał [TYPE] o numerze: [NUM]! Gratulujemy!";
	$language['function']['get_vip_channel']['has_channel'] = "Posiadasz już kanał [TYPE]";
	$language['function']['get_vip_channel']['top_desc'] = "Kanał [TYPE] nr: ";
	$language['function']['get_vip_channel']['error_db'] = "Bot Brak połączenia z bazą danych!";
	$language['function']['get_vip_channel']['error_main'] = "błąd przy tworzeniu kanału głównego. Może istnieje kanał z taką nazwa?";
	$language['function']['get_vip_channel']['error_spacer'] = "błąd przy tworzeniu spacer'a. Może istnieje już taki spacer?";
	$language['function']['get_vip_channel']['error'] = "[ERROR] Sprawdź logi bota!";
	
	$language['function']['warning_ban']['user_banned'] = "Użytkownik został zbanowany: ";

	$language['function']['twitch_yt']['info'] = "Informacje: ";
	$language['function']['twitch_yt']['playing'] = "Gra w grę: ";
	$language['function']['twitch_yt']['follows'] = "Followersów: ";
	$language['function']['twitch_yt']['views'] = "Wyświetleń: ";
	$language['function']['twitch_yt']['viewers'] = "Oglądających: ";
	$language['function']['twitch_yt']['subs'] = "Subskrybujących: ";
	$language['function']['twitch_yt']['videos'] = "Filmów na kanale: ";
	$language['function']['twitch_yt']['click'] = "[KLIKNIJ]";
	$language['function']['twitch_yt']['streaming'] = "NA ŻYWO";
		
	$language['function']['admins_meetin']['moved'] = " adminów zostało pomyślnie przeniesionych na kanał zebrania.";
	$language['function']['admins_meeting']['information'] = " , pamiętaj o zbliżającym się zebraniu Administracji";

	$language['function']['groups_assigner']['has_rang'] = "Masz już rangę rejestracyjną!";
	$language['function']['groups_assigner']['received_rang'] = "Właśnie otrzymałeś rangę rejestracyjną!";
	$language['function']['groups_assigner']['error'] = "Nie spełniasz wymagań! Musisz spędzić na serwerze minimum:";
	$language['function']['groups_assigner']['min'] = "minut.";

	$language['function']['auto_register']['received_rang'] = "Właśnie otrzymałeś rangę weryfikacyjną, gdyż spędziłeś określoną liczbę czasu na serwerze!";

	$language['function']['connect_message']['one_day'] = "dzień";
	$language['function']['connect_message']['2_days'] = "dni";
	$language['function']['connect_message']['other_days'] = "dni";
	$language['function']['connect_message']['one_hour'] = "godzinę";
	$language['function']['connect_message']['2_hours'] = "godziny";
	$language['function']['connect_message']['other_hours'] = "godzin";
	$language['function']['connect_message']['one_minute'] = "minutę";
	$language['function']['connect_message']['2_minutes'] = "minuty";
	$language['function']['connect_message']['other_minutes'] = "minut";
	$language['function']['connect_message']['seconds'] = "sekund";

	$language['function']['host_message'] = "Witaj na [b][SERVER_NAME][/b]\nAktualnie online jest [b][SERVER_ONLINE]/[SERVER_MAX_CLIENTS][/b].\nSerwer działa już [b][SERVER_UPTIME][/b]. \nŻyczymy przyjemnych rozmów!";

	$language['function']['poke_admins']['hi'] = "Witaj";
	$language['function']['poke_admins']['in_this_moment'] = "W tej chwili do twojej dyspozycji jest tyle adminów: ";
	$language['function']['poke_admins']['help'] = "W krótce na pewno ktoś Ci pomoże!";
	$language['function']['poke_admins']['no_admins'] = "Niestety w tej chwili nie ma dostepnego zadnego admina, zapraszamy pozniej";
	$language['function']['poke_admins']['wants_help'] = "oczekuje na twoją pomoc!";
	$language['function']['poke_admins']['on_channel'] = "Na kanale: ";
	$language['function']['poke_admins']['informed'] = "został powiadomiony o Twoim pobycie na tym kanale!";
	$language['function']['poke_admins']['away'] = "Nie możesz mieć statusu AWAY!";
	$language['function']['poke_admins']['input'] = "Nie możesz mieć wyłączonego mikrofonu!";
	$language['function']['poke_admins']['output'] = "Nie możesz być zmutowany!";

	$language['function']['admin_list']['on_channel'] = "Kanał: ";
	$language['function']['admin_list']['for'] = "od";
	$language['function']['admin_list']['no_admins'] = "Brak adminów w tej grupie serwerowej";
	
	$language['function']['admin_list_online']['on_channel'] = "Na kanale: ";
	$language['function']['admin_list_online']['online'] = "Online od: ";
	$language['function']['admin_list_online']['no_admins'] = "Brak dostępnych adminów";

	$language['function']['online_from_server_group'] = "Brak osób w tej grupie serwerowej"; 

	$language['function']['afk_move']['moved'] = "Zostałeś przeniesiony na kanał AFK";
	$language['function']['afk_move']['moved_back'] = "Zostałeś przeniesiony z powrotem na swój kanał";

	$language['function']['nicks_security']['kick_message'] = "Twój nick zawiera złą frazę: ";
	$language['function']['nicks_security']['bad_away_message'] = "Twoja away message zawiera złą frazę: ";
	$language['function']['nicks_security']['bad_desc'] = "Twój opis zawiera złą frazę: ";
	$language['function']['nicks_security']['ban'] = "Zbyt duża liczba wejść ze złym nickiem";

	$language['function']['top_connections']['connect'] = "połączeń";

	$language['function']['record_online'][0] = "[b]Informacje - Serwer[/b]\nRekord dostępnych użytkowników";
	$language['function']['record_online'][1] = "Obecny rekord wynosi:";
	$language['function']['record_online'][2] = "Rekord ustanowiono:";

	$language['function']['channels_guard']['private_channel'] = "Kanał prywatny nr: ";
	$language['function']['channels_guard']['empty'] = " [WOLNY]";
	$language['function']['channels_guard']['how_to_get'] = "Aby go otrzymać udaj się na odpowiedni kanał";
	$language['function']['channels_guard']['wrong_name'] = "Zła nazwa kanału!";
	$language['function']['channels_guard']['bad_name'] = "Niedozwolona fraza w nazwie!";
		
	$language['function']['get_private_channel']['hasnt_rang'] = "Nie masz odpowiedniej rangi!";
	$language['function']['get_private_channel']['has_channel'] = "Masz już u nas kanał!";
	$language['function']['get_private_channel']['get_channel'] = "Właśnie otrzymałeś prywatny kanał!";
	$language['function']['get_private_channel']['no_empty'] = "Aktualnie brak wolnych kanałów!";
	$language['function']['get_private_channel']['channel_name'] = "Kanał prywatny - ";
	$language['function']['get_private_channel']['created'] = "Data założenia: ";
	$language['function']['get_private_channel']['sub_channel'] = " Podkanał";
	$language['function']['get_private_channel']['private_channel'] = "Kanał prywatny nr: ";
	$language['function']['get_private_channel']['not_empty'] = " [ZAJĘTY]";
	$language['function']['get_private_channel']['owner'] = "Właściciel: ";
	$language['function']['get_private_channel']['hi'] = "Witaj ";
	$language['function']['get_private_channel']['channel_created'] = "Właśnie stworzyliśmy Ci prywatny kanał nr: ";
	$language['function']['get_private_channel']['default_pass'] = "Domyślne hasło to: 123";
	$language['function']['get_private_channel']['gl&hf'] = 'Jeśli zapomnisz hasła wejdź ponowinie na ten [URL=channelid://84]Kanał[/URL] Życzymy miłych rozmów!';

	$language['function']['empty_channels']['list'] = 'Lista kanałów';
	$language['function']['empty_channels']['free'] = 'Wolne';
	$language['function']['empty_channels']['to_del'] = 'Do usunięcia';
	$language['function']['empty_channels']['days'] = array
	(
		0 => 'Niedziela',
		1 => 'Poniedziałek',
		2 => 'Wtorek',
		3 => 'Środa',
		4 => 'Czwartek',
		5 => 'Piątek',
		6 => 'Sobota',
	);
	$language['function']['empty_channels']['tomorrow'] = "Jutro";

	$language['function']['ban_list'] = array
	(
		'header' => "Wszystkich: ",
		'permament' => "permamentnie",
		'user' => "Osoba",
		'time' => "Czas trwania",
		'reason' => "Powód",
		'invoker' => "Twórca bana",
		'date' => "Dnia",
	);

	$language['function']['status_sinusbot']['in_group'] = 'Botów w grupie';
	$language['function']['status_sinusbot']['is'] = 'jest';
	$language['function']['status_sinusbot']['active'] = 'Aktywny';
	$language['function']['status_sinusbot']['on_channel'] = 'przebywa na';
	$language['function']['status_sinusbot']['for'] = 'od';	

	$language['function']['random_group']['title'] = 'Lista randomowych grup';
	$language['function']['random_group']['owner'] = 'Właśnie dostałeś randomową grupę: ';
	$language['function']['random_group']['on_time'] = 'na czas:';
	$language['function']['random_group']['cong'] = 'Gratulujemy!';
	$language['function']['random_group']['days'] = 'dni';
	$language['function']['random_group']['desc'] = 'wylosował/a rangę:';
	$language['function']['random_group']['day'] = 'dnia';

	$language['function']['write_statistics']['groups'] = '[center][B][size=11][rang_name]:[/B] [size=11][client][/size][/center]\n[b][size=10]Grupy normalne:[/size][/b][left]●  W dniu dzisiejszym: [B][today].[/B]\n● W tym tygodniu: [B][weekly].[/B]\n●  W tym miesiącu: [B][monthly].[/B]\n●   Ilość wszystkich nadanych grup: [B][total].[/B][/left]\n[b][size=10]Grupy rejestracyjne:[/size][/b][left]  W dniu dzisiejszym: [B][reg_today].[/B]\n  W tym tygodniu: [B][reg_weekly].[/B]\n W tym miesiącu: [B][reg_monthly].[/B]\n Ilość wszystkich nadanych grup: [B][reg_total].[/B][/left]';
	$language['function']['write_statistics']['time_spent'] = '[center][B][size=11][rang_name]:[/B] [size=11][client][/size][/center][b][size=10] Spędzony czas: [/size][/b]\n\n [size=9]W dniu dzisiejszym: [B][today][/B] w tym [B][off_today][/B] jako niedostępny.[/size]\n [size=9]W obecnym tygodniu: [B][weekly][/B] w tym [B][off_weekly][/B] jako niedostępny.[/size]\n [size=9]W obecnym miesiącu: [B][monthly][/B] w tym [B][off_monthly][/B] jako niedostępny.[/size]\n [size=9]Łączny spędzony czas: [B][total][/B] w tym [B][off_total][/B] jako niedostępny[/size]';
	$language['function']['write_statistics']['help_center'] = '[center][B][size=11][rang_name]:[/B] [size=11][client][/size][/center]\n[b][size=10]Ilość udzielonej pomocy:[/size][/b][left]●  W dniu dzisiejszym: [B][today_count].[/B]\n●  W tym tygodniu: [B][weekly_count].[/B]\n●  W tym miesiącu: [B][monthly_count].[/B]\n● Ilość wszystkich osób: [B][total_count].[/B][/left]\n[b][size=10]Czas pomocy:[/size][/b][left] W dniu dzisiejszym: [B][today_time].[/B]\n W tym tygodniu: [B][weekly_time].[/B]\n W tym miesiącu: [B][monthly_time].[/B]\n Całkowity czas pomocy: [B][total_time].[/B][/left]';
	

	$language['function']['facebook_posts']['header'] = 'Lista postów z naszego';
	$language['function']['facebook_posts']['written'] = 'Napisany:';

	$language['function']['live_dj'] = "Brak";

	$language['function']['event_records']['success'] = "Zostałeś zapisany pomyślnie!";
	$language['function']['event_records']['failed'] = "Błąd podczas zapisywania. Może znajdujesz się już na liście?";

	$language['function']['top_week_time'] = "do awansu brakuje:";

	$language['function']['levels']['next'] = "Gratulacje! Awansowałeś na poziom: [NAME]. Do następnego levelu brakuje Ci [HOURS] godzin.";
	$language['function']['levels']['last'] = "Gratulacje! Awansowałeś na poziom: [NAME]. Jest to ostatni level!";

	$language['function']['delete_client_permissions'] = "Witaj, permisje na Twojego klienta ([PERMS]) zostały właśnie usunięte, ponieważ nie możesz ich posiadać.";
	
	$language['function']['get_server_group']['add'] = "Właśnie otrzymałeś grupę Vip!";
	$language['function']['get_server_group']['del'] = "Grupa Vip została pomyślnie usunięta!";
	
	$language['function']['actions_logs']['groups_assigner'] = " został zarejestrowany przez wejście na kanał.";
	$language['function']['actions_logs']['auto_register'] = " został zarejestrowany, gdyż spędził na serwerze wystarczająco czasu.";
	$language['function']['actions_logs']['block_recording'] = " został ukarany za nagrywanie.";
	$language['function']['actions_logs']['anty_vpn'] = " został ukarany za używanie VPN.";
	$language['function']['actions_logs']['poke_admins'] = " wszedł na centrum pomocy.";
	$language['function']['actions_logs']['get_vip_channel'] = " otrzymał kanał [TYPE] o numerze: [NUM].";
	$language['function']['actions_logs']['get_yt_channel'] = " otrzymał kanał YouTube o numerze: [NUM].";
	$language['function']['actions_logs']['nicks_security']['nick'] = " został ukarany za nieodpowiedni nick:.";
	$language['function']['actions_logs']['nicks_security']['away'] = " został ukarany za nieodpowiednią wiadomość AFK.";
	$language['function']['actions_logs']['nicks_security']['desc'] = " został ukarany za nieodpowiedni opis klienta.";
	$language['function']['actions_logs']['wrong_nick'] = "Niewiem";
	$language['function']['actions_logs']['levels'] = " awansował na LVL: [LVL].";
	$language['function']['actions_logs']['random_group'] = " wylosował grupę VIP.";
	$language['function']['actions_logs']['get_private_channel'] = " otrzymał kanał prywatny numer: [NUM].";
	$language['function']['actions_logs']['channels_guard'] = "Data kanału prywatnego numer: [NUM] została zaktualizowana.";
	
	$language['function']['weather']['weather'] = "Pogoda";
	$language['function']['weather']['temperature'] = "Temperatura";
	$language['function']['weather']['status'] = "Stan pogody";
	$language['function']['weather']['speed'] = "Prędkość wiatru";
	$language['function']['weather']['pressure'] = "Ciśnienie";
	$language['function']['weather']['humidity'] = "Wilgotność";
	$language['function']['weather']['visibility'] = "Widoczność";
	
	$language['function']['check_ip'] = "Przekroczono limit [NUMBER] kont na jednym IP!";
	
	$language['function']['AutoSpeak_info']['instances_info'] = "Informacje o instancjach Bocik";
	$language['function']['AutoSpeak_info']['instance'] = "Instancja";
	$language['function']['AutoSpeak_info']['no_info'] = "brak danych";
	$language['function']['AutoSpeak_info']['total_ram'] = "Całkowite zużycie RAM";
	$language['function']['AutoSpeak_info']['info_from_server'] = "Informacje z serwera Bocik";
	
	$language['function']['check_description']['header'] = "Wykryte podejrzane linki";
	$language['function']['check_description']['bad_link'] = "[b][color=red]Niedozwolony link[/color][/b]";
	$language['function']['check_description']['bad_link_text'] = "zły link";
	$language['function']['check_description']['on_channel'] = "wykryty na kanale";
	
	$language['function']['channels_edits']['header'] = "Ostatnie edycje kanałów:";
	$language['function']['channels_edits']['channel'] = "Kanał:";
	$language['function']['channels_edits']['was_edited'] = "został edytowany przez:";
	
	$language['command']['success'] = "Pomyślnie powiadomiono tyle osób: ";
	$language['command']['success_moved'] = "Pomyślnie przeniesiono tyle adminów: ";
	$language['command']['success_bot'] = "|Sukces| Odczekaj kilka sekund na rezultat!";
	$language['command']['result'] = "Rezultat: ";
	$language['command']['suc'] = "Sukces!";
	
	$language['command']['hi'] = "Witaj [NICK]\n :)";

	$language['command']['class']['not_command'] = 'Aby użyć komendy użyj `!` przed komendą';
	$language['command']['class']['wrong_command'] = 'Nie ma takiej komendy: ';
	$language['command']['class']['not_privileged'] = 'Nie masz uprawnień do użycia komendy: ';
	$language['command']['class']['bad_usage'] = 'Błędne użycie komendy: ';
	$language['command']['class']['bad_instance'] = 'Nie ma takiej instanji: ';

	$language['command']['ch']['has_channel'] = 'Użytkownik posiada już kanał prywatny!';
	$language['command']['ch']['success'] = 'Pomyślnie utworzono kanał prywatny z liczbą podkanałów: ';

	$language['command']['mute']['success'] = 'Pomyślnie nadano rangę osobie: [b][u][NICK][/u][/b] na liczbę sekund: ';

	$language['command']['admin']['no_admin'] = 'Ta osba nie posiada grupy administratora!';
	$language['command']['admin']['no_in_db'] = 'Brak podanej osoby w bazie danych!';
	$language['command']['admin']['info'] = '\n● [b][u]Informacje ogólne:[/u][/b]\n\tNick: [b][nick][/b]\n\tClient database id: [b][dbid][/b]\n\tClient UID: [b][uid][/b]\n\tPołączeń z serwerem: [b][con][/b]\n\tCzas spędzony na serwerze: [b][time_spent][/b]\n\n';
	$language['command']['admin']['info_2'] = '\n● [b][u]Nadane grupy normalne:[/u][/b]\n\tW dniu dzisiejszym: [b][today][/b]\n\tW tym tygodniu: [b][weekly][/b]\n\tW tym miesiącu: [b][monthly][/b]\n\tIlość wszystkich nadanych grup: [b][total][/b]\n\n● [b][u]Nadane grupy rejestracyjne:[/u][/b]\n\tW dniu dzisiejszym: [b][reg_today][/b]\n\tW tym tygodniu: [b][reg_weekly][/b]\n\tW tym miesiącu: [b][reg_monthly][/b]\n\tIlość wszystkich nadanych grup: [b][reg_total][/b]\n\n● [b][u]Spędzony czas:[/u][/b] \n\tW dniu dzisiejszym: [color=green][b][today_time][/b][/color] w tym [color=red][b][off_today][/b][/color] jako niedostępny\n\tW obecnym tygodniu: [color=green][b][weekly_time][/b][/color] w tym [color=red][b][off_weekly][/b][/color] jako niedostępny\n\tW obecnym miesiącu: [color=green][b][monthly_time][/b][/color] w tym [color=red][b][off_monthly][/b][/color] jako niedostępny.\n\tŁączny spędzony czas: [color=green][b][total_time][/b][/color] w tym [color=red][b][off_total][/b][/color] jako niedostępny';
	
	$language['command']['socialspy']['no_in_db'] = 'Brak podanej osoby w bazie danych!';
	$language['command']['socialspy']['info'] = '\n● [b][u]Informacje ogólne:[/u][/b]\n\tNick: [b][nick][/b]\n\tClient database id: [b][dbid][/b]\n\tClient UID: [b][uid][/b]\n\tPołączeń z serwerem: [b][con][/b]\n\tCzas spędzony na serwerze: [b][time_spent][/b]\n\n';
	$language['command']['socialspy']['info_2'] = '\n● [b][u]Zmiana nicków użytkownika:[/u][/b]\n';
	$language['command']['socialspy']['change_nick'] = 'zmienił nick';

	$language['command']['tpclient']['to_small'] = 'Za krótki nick! Musisz podać przynajmniej 3 znaki!';
	$language['command']['move']['to_small'] = 'Za krótki nick! Musisz podać przynajmniej 3 znaki!';
	$language['command']['tpclient']['not_finded'] = 'Użytkownik nie został znaleziony.';
	$language['command']['move']['not_finded'] = 'Użytkownik nie został znaleziony.';

	$language['command']['tpchannel']['to_small'] = 'Za krótka nazwa! Musisz podać przynajmniej 5 znaków!';
	$language['command']['tpchannel']['not_finded'] = 'Kanał nie został znaleziony.';

	$language['command']['gsecurity']['wrong_group'] = 'Podana grupa nie jest zapisana w configu.';
	$language['command']['gsecurity']['wrong_type'] = 'Niepoprawny typ, użyj `add` lub `del`.';
	$language['command']['gsecurity']['added'] = 'Użytkownik [b][NICK][/b] został pomyślnie [color=green]dodany[/color] do grupy [SGID].';
	$language['command']['gsecurity']['deleted'] = 'Użytkownik [b][NICK][/b] został pomyślnie [color=red]usunięty[/color] z grupy [SGID].';
	$language['command']['gsecurity']['wrong_deleted'] = 'Użytkownik [b][NICK][/b] nie znajduje się w pliku cache, więc nie może zostać usunięty.';
	
	$language['command']['help']['info']['help'] = 'Wyświetla listę wszystkich komend';
	$language['command']['help']['info']['pwall'] = 'Wysyła wiadomość prywatną do wszystkich klientów';
	$language['command']['help']['info']['pokeall'] = 'Pokuje wszystkich klientów';
	$language['command']['help']['info']['pwgroup'] = 'Wysyła wiadomość prywatną do klientów z wybraną rangą serwerową';
	$language['command']['help']['info']['pokegroup'] = 'Pokuje klientów z wybraną rangą serwerową';
	$language['command']['help']['info']['meeting'] = 'Przenosi administrację na wybrany kanał';
	$language['command']['help']['info']['clients'] = 'Wyświetla listę wszystkich klientów';
	$language['command']['help']['info']['channels'] = 'Wyświetla listę wszystkich kanałów';
	$language['command']['help']['info']['bot'] = 'Zarządza instancjami bociorka';
	$language['command']['help']['info']['ch'] = 'Tworzy kanał prywatny użytkownikowi z podaną liczbą podkanałów';
	$language['command']['help']['info']['mute'] = 'Nadaje użytkownikowi określoną w configu rangę na podaną liczbę sekund';
	$language['command']['help']['info']['admin'] = 'Wypisuje informacje o podanym adminie';
	$language['command']['help']['info']['tpclient'] = 'Przenosi Cię do użytkownika z podanym nickiem';
	$language['command']['help']['info']['move'] = 'Przenosi użytkownika z podanym nickiem';
	$language['command']['help']['info']['tpchannel'] = 'Przenosi Cię na kanał z podaną nazwą';
	$language['command']['help']['info']['gsecurity'] = 'Nadaje/zabiera grupę z funckji groups_security()';
	$language['command']['help']['info']['socialspy'] = 'Wypisuje informacje o podanym użytkowniku';

	$language['command']['help']['usage']['help'] = '!help';
	$language['command']['help']['usage']['pwall'] = '!pwall-[wiadomość]';
	$language['command']['help']['usage']['pokeall'] = '!pokeall-[wiadomość]';
	$language['command']['help']['usage']['pwgroup'] = '!pwgroup-[id_grupy]-[wiadomość]';
	$language['command']['help']['usage']['pokegroup'] = '!pokegroup-[id_grupy]-[wiadomość]';
	$language['command']['help']['usage']['meeting'] = '!meeting';
	$language['command']['help']['usage']['clients'] = '!clients';
	$language['command']['help']['usage']['channels'] = '!channels';
	$language['command']['help']['usage']['bot'] = '!bot-[id_instancji]';
	$language['command']['help']['usage']['ch'] = '!ch-[client_database_id]-[liczba_podkanałów]';
	$language['command']['help']['usage']['mute'] = '!mute-[client_database_id]-[liczba_sekund]';
	$language['command']['help']['usage']['admin'] = '!admin-[client_database_id]';
	$language['command']['help']['usage']['tpclient'] = '!tpclient-[client_nick]';
	$language['command']['help']['usage']['move'] = '!move-[client_nick]';
	$language['command']['help']['usage']['tpchannel'] = '!tpchannel-[nazwa_kanału]';
	$language['command']['help']['usage']['gsecurity'] = '!gsecurity-[add/del]-[client_database_id]-[group_id]';
	$language['command']['help']['usage']['socialspy'] = '!socialspy-[client_database_id]';

	$language['command']['help']['privileged'] = 'Mogą użyć: ';
	$language['command']['help']['inf'] = 'Informacje: ';
	$language['command']['help']['us'] = 'Użycie: ';

	$language['live_help'] = array
	(
		//Register
		'not_registered' => '(Bocik) LiveHelp wykrył, że nie jesteś jeszcze zarejestrowany.',
		'reg_man' => 'aby zarejestrować się jako mężczyzna',
		'reg_woman' => 'aby zarejestrować się jako kobieta',

		//Menu
		'header' => "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n[b]LiveHelp[/b]\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n \n",
		'menu' => 'aby wyświetlić listę komend',
		'add' => 'aby nadać sobie rangę',
		'del' => 'aby zdjąć sobie rangę',
		'list' => 'aby wyświetlić listę rang',
		'faq' => 'aby wyświetlić faq',
		'client_info' => 'aby wyświetlić informacje o Tobie',
		'!admin' => 'aby wezwać admina',
		'registered' => 'Właśnie się zarejestrowałeś/aś!',
		'group_list' => 'Lista grup serwerowych',
		'write' => 'Napisz',
		'wait_admin' => 'Oczekujesz na pomoc admina!',
		'cancel_help' => 'aby odwołać pomoc u admina',	
		'success_exit' => 'Pomyślnie odwołano pomoc admina!',
		'channel' => 'aby dostać kanał prywatny',
		'help_commands' => 'Uzyskanie pomocy:',

		//Poke admins
		'admin_informed' => 'Admin został już powiadomiony!',
		'admin_on_channel' => 'Admin znajduje się już na kanale pomocy!',
		'help_status' => 'STATUS POMOCY',

		//Server Groups
		'received_rang' => 'Właśnie otrzymałeś wybraną rangę!',
		'del_rang' => 'Właśnie zdjęto Ci rangę!',
		'limit' => 'Osiągnąłeś limi rang!',
		'not_have' => 'Nie posiadasz takiej rangi!',
		'wrong_rang' => 'Niepoprawna ranga!',
		'group_number' => 'numer_grupy',

		//FAQ
		'info' => 'Informacje o Tobie:',
		'version' => 'Wersja aplikacji:',
		'country' => 'Kraj:',

		'bot_nick' => '[NAME] | Osób w kolejce: [NUM]',
		'wrong_command' => 'Nieznana komenda!',
	);

?>
