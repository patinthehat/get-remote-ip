#!/bin/bash

USERAGENT="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:25.0) Gecko/20100101 Firefox/25.0"

if [ ! -f data/hosts.conf ]; then
  echo "Error: could not find hosts database in './data/hosts/'."
  exit -1
else
  HOST=$(cat data/hosts.conf | sort -R | head -n 1)
  curl -H "User-agent: $USERAGENT" $HOST
fi