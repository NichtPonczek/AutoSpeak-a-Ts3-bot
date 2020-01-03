#!/bin/bash
# Colors
ESC_SEQ="\x1b["
COL_RESET=$ESC_SEQ"39;49;00m"
COL_RED=$ESC_SEQ"31;01m"
COL_GREEN=$ESC_SEQ"32;01m"
COL_YELLOW=$ESC_SEQ"33;01m"
COL_BLUE=$ESC_SEQ"34;01m"
COL_MAGENTA=$ESC_SEQ"35;01m"
COL_CYAN=$ESC_SEQ"36;01m"
version="6.0"
php_ver="7.2"

echo ">AutoSpeak"
echo "A teamspeak Bot "
echo "> Version [$version] +"
instances=6

installing()
{
	echo;
   	echo -e "$COL_CYAN ****************************************$COL_RESET";
   	echo -e "$COL_GREEN   	INSTALLING: $1 $COL_RESET";
   	echo -e "$COL_CYAN ****************************************$COL_RESET";
   	echo;
}

write()
{
	echo;
   	echo -e "$COL_CYAN **************************************** $COL_RESET";
   	echo -e "$2  $1 $COL_RESET";
   	echo -e "$COL_CYAN **************************************** $COL_RESET";
   	echo;
}

check_installed_packets()
{
	if [ -z `which sudo` ]; then
		installing "sudo"
		apt-get install sudo
		echo -e "$COL_RESET"
	fi

	if [ -z `which unzip` ]; then
		installing "unzip"
		apt-get install unzip
		echo -e "$COL_RESET"
	fi

	if [ -z `which wget` ]; then
		installing "wget"
		apt-get install wget
		echo -e "$COL_RESET"
	fi

	if [ -z `which screen` ]; then
		installing "screen"
		apt-get install screen	
		echo -e "$COL_RESET"
	fi

	if [[ -z `which php$pvp_ver` && -z `which php` ]]; then
		installing "PHP5"
		apt-get install php5
		echo -e "$COL_RESET"
	fi

	if [[ -z `dpkg -l | grep php$php_ver-gd` ]]; then
		installing "$php_ver-GD"
		apt-get install php$php_ver-gd
		echo -e "$COL_RESET"
	fi

	if [[ -z `dpkg -l | grep php$php_ver-curl` ]]; then
		installing "PHP$php_ver-CURL"
		apt-get install php$php_ver-curl
		echo -e "$COL_RESET"
	fi
	
	if [[ -z `dpkg -l | grep php$php_ver-mysql` ]]; then
		installing "PHP$php_ver-Mysql"
		apt-get install php$php_ver-mysql
		echo -e "$COL_RESET"
	fi
}

if [[ "$1" == "start" ]]; then
	check_installed_packets

	if [[ -f include/language_file/eng.txt || "$2" == "eng" ]]; then
		echo
		echo "You started `basename $0`"
		echo Your choice: "$@"
		for (( i=1; $i <= $instances; i++ )) ; do
			if  ! screen -list | grep -q "AutoSpeak_instance_$i" ; then
				sudo screen -dmS AutoSpeak_instance_$i php core.php -i $i
				echo -e "AutoSpeak instance $i $COL_GREEN is ON! $COL_RESET"
				sleep 3
			else
				echo -e "AutoSpeak instance $i $COL_GREEN is already ON! $COL_RESET"
			fi
		done
	else
		echo
		echo "Uruchomiles program `basename $0`"
		echo Wybrales: "$@"
		for (( i=1; $i <= $instances; i++ )) ; do
			if  ! screen -list | grep -q "AutoSpeak_instance_$i" ; then
				sudo screen -dmS AutoSpeak_instance_$i php core.php -i $i
				echo -e "AutoSpeak instancja $i $COL_GREEN została włączona! $COL_RESET"
				sleep 3
			else
				echo -e "AutoSpeak instancja $i $COL_GREEN jest już włączony! $COL_RESET"
			fi
		done
	fi

elif [[ "$1" == "stop" ]]; then
	if [[ -f include/language_file/eng.txt || "$2" == "eng" ]]; then
		echo
		echo "You started `basename $0`"
		echo Your choice: "$@"
		for (( i=1; $i <= $instances; i++ )) ; do
			screen -S AutoSpeak_instance_$i -X quit
		done
		echo -e "AutoSpeak $COL_RED is OFF! $COL_RESET"
	else
		echo
		echo "Uruchomiles program `basename $0`"
		echo Wybrales: "$@"
		for (( i=1; $i <= $instances; i++ )) ; do
			screen -S AutoSpeak_instance_$i -X quit
		done
		echo -e "AutoSpeak $COL_RED został wyłączony! $COL_RESET"
	fi

elif [[ "$1" == "restart" ]]; then
	check_installed_packets

	if [[ -f include/language_file/eng.txt || "$2" == "eng" ]]; then
		echo
		echo "You started `basename $0`"
		echo Your choice: "$@"
		for (( i=1; $i <= $instances; i++ )) ; do
			if [ "$i" == 1 ]; then
				echo -n -e "$COL_BLUE Restarting "
			else
				echo -n ". "
			fi
			screen -S AutoSpeak_instance_$i -X quit
			screen -dmS AutoSpeak_instance_$i php core.php -i $i
			sleep 3
		done
		echo ""
		echo -e "AutoSpeak $COL_GREEN has been restarted successfully! $COL_RESET"
	else
		echo
		echo "Uruchomiles program `basename $0`"
		echo Wybrales: "$@"
		for (( i=1; $i <= $instances; i++ )) ; do
			if [ "$i" == 1 ]; then
				echo -n -e "$COL_BLUE Restartuję "
			else
				echo -n "."
			fi
			screen -S AutoSpeak_instance_$i -X quit
			screen -dmS AutoSpeak_instance_$i php core.php -i $i	
			sleep 3
		done
		echo -e "$COL_RESET"
		echo -e "AutoSpeak $COL_GREEN został zrestartowany pomyślnie! $COL_RESET"
	fi

elif [[ "$1" == "run" ]]; then
	check_installed_packets

	if [[ -f include/language_file/eng.txt || "$2" == "eng" ]]; then
		echo
		echo "You started `basename $0`"
		echo Your choice: "$@"
		if  ! screen -list | grep -q "AutoSpeak_run" ; then
			sudo screen -dmS AutoSpeak_run ./starter.sh exec_run yes
			echo -e "AutoSpeak run $COL_GREEN is ON! $COL_RESET"
		else
			screen -S AutoSpeak_run -X quit
			echo -e "AutoSpeak run $COL_RED is OFF! $COL_RESET"
		fi
	else
		echo
		echo "Uruchomiles program `basename $0`"
		echo Wybrales: "$@"
		if  ! screen -list | grep -q "AutoSpeak_run" ; then
			sudo screen -dmS AutoSpeak_run ./starter.sh exec_run yes
			echo -e "AutoSpeak run $COL_GREEN została włączona! $COL_RESET"
		else
			screen -S AutoSpeak_run -X quit
			echo -e "AutoSpeak run $COL_RED został wyłączony! $COL_RESET"
		fi
	fi


elif [[ "$1" == "exec_run" ]]; then
	while [ 1 ]; do
		sleep 3
		if [ -f include/cache/command.txt ]; then
			for (( i=1; $i<=2; i++ )) ; do
				command=`sed -n "$i"p include/cache/command.txt`
				$command
			done;
			rm include/cache/command.txt
		fi
		if [[ "$2" == "yes" ]]; then
			for (( i=1; $i <= $instances; i++ )) ; do
				if  ! screen -list | grep -q "AutoSpeak_instance_$i" ; then
					sudo screen -dmS AutoSpeak_instance_$i php core.php -i $i
					sleep 3
				fi
			done
		fi
	done
elif [[ "$1" == "install" ]]; then
	
	echo;
	echo -e "$COL_CYAN Wybierz jaką masz wersje systemu $COL_RESET"
	echo "[1] Debian 8 lub Debian9"
	echo "[2] Ubuntu 14 lub Ubuntu 16"
	read -p "» " SYSTEM;
	
	apt-get update -y
	apt-get upgrade	-y
	apt-get install -y sudo nano screen htop unzip wget
	apt-get install -y mysql-server
	apt-get install -y apache2
	
	case $SYSTEM in
		1)
			sudo apt-get install -y apt-transport-https lsb-release ca-certificates
			wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
			echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
			sudo apt-get update -y;;
		2)
			sudo apt-get install -y software-properties-common python-software-properties
			sudo LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php
			sudo apt-get update -y;;
	esac
	
	apt-get install -y php$php_ver libapache2-mod-php$php_ver php$php_ver-curl php$php_ver-gd php$php_ver-mysql php$php_ver-mbstring php$php_ver-bz2 php$php_ver-xml
	apt-get install -y phpmyadmin
	ln -s /usr/share/phpmyadmin /var/www/html/phpmyadmin
	sudo a2dismod php7
	sudo a2dismod php5
	sudo a2dismod php7.1
	sudo a2dismod php5.6
	sudo a2enmod php$php_ver
	service apache2 restart
	
	install_ioncube
	
	write " Potrzebne pakiety zostały zainstalowane" "$COL_GREEN"
	
else
	if [[ -f include/language_file/eng.txt || "$2" == "eng" ]]; then
		echo
		echo -e "$COL_GREEN USAGE: ${0} {start/stop/restart/run/install} $COL_RESET"	
	else
		echo
		echo -e "$COL_GREEN UŻYCIE: ${0} {start/stop/restart/run/install} $COL_RESET"	
	fi	
fi

