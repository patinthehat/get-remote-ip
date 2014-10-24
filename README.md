# get-remote-ip #
---

  `get-remote-ip` is a PHP Class that uses a database of hosts to retrieve the client's external IP address.

---

### Usage ###

```<?php

define('DATA_PATH',             'data');
define('HOSTS_FILENAME',        DATA_PATH.'/hosts.conf');

include('classes/GetExternalIP.php');

//load data file and select a random host
$externip = new \GetExternalIP\GetExternalIP(HOSTS_FILENAME); 
//get and echo the external ip 
echo $externip->getExternalIP() . PHP_EOL;    
```
---

### Configuration ###

Add a new host on a separate line in the `data/hosts.conf` file.
This host should return the client's external ip address, preferably as plain text.
  
By default, `get-external-ip` comes with multiple hosts already configured.

---

### License ###
`get-remote-ip` is licensed under the MIT License.