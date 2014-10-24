# get-remote-ip #
---

  `get-remote-ip` is a PHP Class that uses a database of hosts to retrieve the client's external IP address.

---

### Usage ###

***As PHP:***
```php
<?php

define('DATA_PATH',             'data');
define('HOSTS_FILENAME',        DATA_PATH.'/hosts.conf');

include('classes/GetExternalIP.php');

//load data file and select a random host
$externip = new \GetExternalIP\GetExternalIP(HOSTS_FILENAME); 
//get and echo the external ip 
echo $externip->getExternalIP() . PHP_EOL;    
```

---

*** As a Bash script: ***

`$ get-remote-ip.sh`

---

### Configuration ###

Add a new host on a separate line in the `data/hosts.conf` file.
This host should return the client's external ip address, preferably as plain text.
  
By default, `get-external-ip` comes with multiple hosts already configured.

#### ***Example*** ####
An example host is <a href="http://echo.tzo.com">echo.tzo.com</a>, which outputs the client's
external ip address (there is other text as well which is filtered out with regex.)

---

### License ###
`get-remote-ip` is licensed under the <a href="LICENSE-MIT">MIT License</a>.