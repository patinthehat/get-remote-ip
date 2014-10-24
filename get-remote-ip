#!/usr/bin/php
<?php

define('DATA_PATH',             'data');
define('HOSTS_FILENAME',        DATA_PATH.'/hosts.conf');

include('classes/GetExternalIP.php');

$externip = new \GetExternalIP\GetExternalIP(HOSTS_FILENAME);  //load data file and select a random host
echo $externip->getExternalIP() . PHP_EOL;    //get the external ip