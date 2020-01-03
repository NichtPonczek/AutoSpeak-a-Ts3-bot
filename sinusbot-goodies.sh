apt update
apt install -y x11vnc xvfb libxcursor1 ca-certificates bzip2 libnss3 libegl1-mesa x11-xkb-utils libasound2 libpci3 libxslt1.1 libxkbcommon0 libxss1 curl
update-ca-certificates
apt install libglib2.0-0
adduser --disabled-login sinusbot
mkdir -p /opt/sinusbot
cd /opt/sinusbot
VERSION="3.3.2"
wget https://files.teamspeak-services.com/releases/client/$VERSION/TeamSpeak3-Client-linux_amd64-$VERSION.run
chmod 0755 TeamSpeak3-Client-linux_amd64-$VERSION.run
./TeamSpeak3-Client-linux_amd64-$VERSION.run
rm TeamSpeak3-Client-linux_amd64/xcbglintegrations/libqxcb-glx-integration.so
mkdir TeamSpeak3-Client-linux_amd64/plugins
cp plugin/libsoundbot_plugin.so TeamSpeak3-Client-linux_amd64/plugins/
chmod 755 sinusbot
#multi instancje#
cd /opt
mkdir bot1
mkdir bot2
mkdir bot3
mkdir bot4
cd /opt/bot1
wget https://www.sinusbot.com/dl/sinusbot.current.tar.bz2
cp sinusbot.current.tar.bz2 /opt/bot2/sinusbot.current.tar.bz2
cp sinusbot.current.tar.bz2 /opt/bot3/sinusbot.current.tar.bz2
cp sinusbot.current.tar.bz2 /opt/bot4/sinusbot.current.tar.bz2
tar -xjf sinusbot.current.tar.bz2
echo TS3Path = \"/opt/sinusbot/TeamSpeak3-Client-linux_amd64/ts3client_linux_amd64\" > config.ini
echo ListenPort = 8090 >> config.ini 
echo YoutubeDLPath = \"/usr/local/bin/youtube-dl\" >> config.ini
chmod 755 sinusbot
cd /opt/bot2
tar -xjf sinusbot.current.tar.bz2
echo TS3Path = \"/opt/sinusbot/TeamSpeak3-Client-linux_amd64/ts3client_linux_amd64\" > config.ini
echo ListenPort = 8091 >> config.ini 
echo YoutubeDLPath = \"/usr/local/bin/youtube-dl\" >> config.ini
chmod 755 sinusbot
cd /opt/bot3
tar -xjf sinusbot.current.tar.bz2
echo TS3Path = \"/opt/sinusbot/TeamSpeak3-Client-linux_amd64/ts3client_linux_amd64\" > config.ini
echo ListenPort = 8092 >> config.ini 
echo YoutubeDLPath = \"/usr/local/bin/youtube-dl\" >> config.ini
chmod 755 sinusbot
cd /opt/bot4
tar -xjf sinusbot.current.tar.bz2
echo TS3Path = \"/opt/sinusbot/TeamSpeak3-Client-linux_amd64/ts3client_linux_amd64\" > config.ini
echo ListenPort = 8093 >> config.ini 
echo YoutubeDLPath = \"/usr/local/bin/youtube-dl\" >> config.ini
chmod 755 sinusbot
chown -R sinusbot:sinusbot /opt/bot1
chown -R sinusbot:sinusbot /opt/bot2
chown -R sinusbot:sinusbot /opt/bot3
chown -R sinusbot:sinusbot /opt/bot4
chown -R sinusbot:sinusbot /opt/sinusbot
chmod -R 777 /opt
pip install youtube-dl
