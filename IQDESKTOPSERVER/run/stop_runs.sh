#!/bin/bash

USER=$1
DELAYHOURS=$2

# If delay defined then pause execution for so long
if [[ -n $DELAYHOURS ]]; then
	sleep $DELAYHOURS\h
	echo -e "\nShutting down container for $USER after expired $DELAYHOURS hours\n"
fi

# Get running containers for provided user
# On previous version:
# X=$(docker container ls -q -f name="\\_$USER\\_")
# Updated 2025-12-15
X=$(docker container ls -q -f name="_$USER-")

# Exit if no container running for defined user
if [[ -z $X ]]; then 
	echo "IQdesktop for $USER not running"
	exit 0
fi
	
# Stop and clean all containers etc
echo "==> Stopping $USER's IQdesktop"
docker container stop $X

# Remove all running containers
echo "==> Removing $USER's IQdesktop"
docker container rm $X

# Remove all custom networks
echo -e "\n==> Removing $USER's custom networks"
docker network prune -f

# Remove the custom yml folder
echo -e "\n==> Removing $USER's custom yml files"
rm -r -f yml_custom/$USER