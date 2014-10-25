#!/bin/bash
 
remoteip=$(get-remote-ip.sh)

if [ "$remoteip" == "" ]; then
  exit -1
fi

exit 0