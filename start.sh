#!/bin/bash

# Function to update IP address in .env file
echo "Are you using a Windows or Unix/Linux based PC?"
echo "Press 1 for Unix/Linux (This includes MacOS)"
echo "Press 2 for Windows"
read -p "Enter 1 or 2: " system_os

# Function to grab 
update_ip_unix(){
  # Grab the current IP address of the machine and store it in a variable. Use SED to replace old IP with current IP
  UNIX_CURRENT_IP=`ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'`
  sed -i '' -e "s/[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}/$UNIX_CURRENT_IP/g" .env
}

update_ip_windows(){
  WINDOWS_CURRENT_IP=`hostname -I | grep -oE '[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}'`
  PRIMARY_WINDOWS_IP=`echo $WINDOWS_CURRENT_IP | awk '{print $1}'`
  sed -i '.env' -e "s/[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}/$PRIMARY_WINDOWS_IP/g"
}

if [[ $system_os == 1 ]]; then
  echo "You are using a Unix system"
  update_ip_unix
elif [[ $system_os = 2 ]]; then  
  echo "You're using Windows, go buy a Mac or install Linux"
  update_ip_windows
else
  echo "Invalid input, select 1 or 2. Exiting script"
fi


# Additional arguments "up" or "down" will also bring up/down the docker stack
# if [[ $1 == "up" ]]; then
#   docker-compose up -d
#   update_ip
#   echo "Started checkpoint dev environment..."
#   echo "IP address updated in .env file"
# elif [[ $1 == "down" ]]; then
#   docker-compose down
#   echo "Stopped checkpoint dev environment"
# else
#   update_ip
#   echo "IP address updated in .env file"
# fi