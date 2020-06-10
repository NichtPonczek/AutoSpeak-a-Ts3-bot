#!/bin/sh
#update
apt update
apt install python3-pip
apt install -y x11vnc xvfb libxcursor1 ca-certificates bzip2 libnss3 libegl1-mesa x11-xkb-utils libasound2 libpci3 libxslt1.1 libxkbcommon0 libxss1 curl
update-ca-certificates
apt install libglib2.0-0
pip3 install youtube-dl
#end
#user
adduser --disabled-login sinusbot
mkdir -p /opt/sinusbot
#end
#ts3 & sinusbot dl
cd /opt/sinusbot
VERSION="3.5.3"
wget https://files.teamspeak-services.com/releases/client/$VERSION/TeamSpeak3-Client-linux_amd64-$VERSION.run
chmod 0755 TeamSpeak3-Client-linux_amd64-$VERSION.run
./TeamSpeak3-Client-linux_amd64-$VERSION.run
wget https://www.sinusbot.com/dl/sinusbot.current.tar.bz2
tar -xjf sinusbot.current.tar.bz2
rm TeamSpeak3-Client-linux_amd64/xcbglintegrations/libqxcb-glx-integration.so
mkdir TeamSpeak3-Client-linux_amd64/plugins
cp plugin/libsoundbot_plugin.so TeamSpeak3-Client-linux_amd64/plugins/
chmod 755 sinusbot
#end
cd /opt
#ports
Port1="8090"
Port2="8091"
Port3="8091"
Port4="8091"
#end
#dirs
bot1="bot1"
bot2="bot2"
bot3="bot3"
bot4="bot4"
#end
mkdir $bot1
mkdir $bot2
mkdir $bot3
mkdir $bot4
#bot1
cd /opt/$bot1
cp /opt/sinusbot/sinusbot.current.tar.bz2 /opt/$bot1/sinusbot.current.tar.bz2
cp /opt/sinusbot/sinusbot.current.tar.bz2 /opt/$bot2/sinusbot.current.tar.bz2
cp /opt/sinusbot/sinusbot.current.tar.bz2 /opt/$bot3/sinusbot.current.tar.bz2
cp /opt/sinusbot/sinusbot.current.tar.bz2 /opt/$bot4/sinusbot.current.tar.bz2
tar -xjf sinusbot.current.tar.bz2
echo TS3Path = \"/opt/sinusbot/TeamSpeak3-Client-linux_amd64/ts3client_linux_amd64\" > config.ini
echo ListenHost = \"0.0.0.0\" > config.ini
echo ListenPort = $Port1 >> config.ini
echo YoutubeDLPath = \"/usr/local/bin/youtube-dl\" >> config.ini
chmod 755 sinusbot
#end
#bot2
cd /opt/$bot2
tar -xjf sinusbot.current.tar.bz2
echo TS3Path = \"/opt/sinusbot/TeamSpeak3-Client-linux_amd64/ts3client_linux_amd64\" > config.ini
echo ListenHost = \"0.0.0.0\" > config.ini
echo ListenPort = $Port2 >> config.ini
echo YoutubeDLPath = \"/usr/local/bin/youtube-dl\" >> config.ini
chmod 755 sinusbot
#end
#bot3
cd /opt/$bot3
tar -xjf sinusbot.current.tar.bz2
echo TS3Path = \"/opt/sinusbot/TeamSpeak3-Client-linux_amd64/ts3client_linux_amd64\" > config.ini
echo ListenHost = \"0.0.0.0\" > config.ini
echo ListenPort = $Port3 >> config.ini
echo YoutubeDLPath = \"/usr/local/bin/youtube-dl\" >> config.ini
chmod 755 sinusbot
#end
#bot4
cd /opt/$bot4
tar -xjf sinusbot.current.tar.bz2
echo TS3Path = \"/opt/sinusbot/TeamSpeak3-Client-linux_amd64/ts3client_linux_amd64\" > config.ini
echo ListenHost = \"0.0.0.0\" > config.ini
echo ListenPort = $Port4 >> config.ini
echo YoutubeDLPath = \"/usr/local/bin/youtube-dl\" >> config.ini
chmod 755 sinusbot
#end
#own & mod 
chown -R sinusbot:sinusbot /opt/$bot1
chown -R sinusbot:sinusbot /opt/$bot2
chown -R sinusbot:sinusbot /opt/$bot3
chown -R sinusbot:sinusbot /opt/$bot4
chown -R sinusbot:sinusbot /opt/sinusbot
chmod -R 777 /opt
#end
