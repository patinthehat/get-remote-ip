<?php
/**
 * GetRemoteIP.php --
 *    Retrieves the external IP using a variety of hosts.
 *
 *
 * @var unknown
 */
namespace GetExternalIP;


dl('curl.so');

define('APP_TITLE',           'GetExternalIP');
define('DEFAULT_IP',          "127.0.0.1");
define('DEFAULT_HOST',        "http://echo.tzo.com");
define('DEFAULT_CONFIG_FILE', "data/hosts.conf");


Class GetExternalIP {

  protected $data = array();
  protected $hasCachedIP      = false;
  protected $lastHost         = "";
  protected $lastIP           = DEFAULT_IP;
  protected $hostsConfigFile  = DEFAULT_CONFIG_FILE;
  protected $defaultHost      = DEFAULT_HOST;

  //--------
  protected function executeCURL($url, $useragent) {
    $headers = array(
        'X-Client-name: '.APP_TITLE,
    );

    $defaults = array(
        CURLOPT_URL => $url,//. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($get),
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_USERAGENT => $useragent,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_VERBOSE => 0,
        CURLOPT_FOLLOWLOCATION => 1,

    );

    $options = array(
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 2,
    );

    $ch = curl_init($url);
    curl_setopt_array($ch, ($options + $defaults));
    curl_setopt ($ch , CURLOPT_HTTPHEADER, $headers);

    if( !$result = curl_exec($ch)) {
      trigger_error(curl_error($ch));
    }
    curl_close($ch);

    return $result;
  }

  public function __constructor($hostsFile, $hostsConfigFile=DEFAULT_CONFIG_FILE) {
    $this->hostsFile = $hostsFile;
    if (file_exists($hostsConfigFile) && filesize($hostsConfigFile))
      $this->hostsConfigFile = $hostsConfigFile;
  }

  public function __destruct() {
    //
  }

  function __get($name) {
    if (isset($this->data[$name]))
      return $this->data[$name];
    return FALSE;
  }

  function __set($name, $value) {
    $this->data[$name] = $value;
  }

  function loadHostsConf() {
    if (file_exists($this->hostsConfigFile)) {
      $text = file_get_contents($this->hostsConfigFile);
    } else {
      $text = $this->defaultHost;
    }
    return $text;
  }

  function loadRandomHost($filename) {
    $contents = file($filename);
    $count = count($contents);
    $line = trim($contents[array_rand($contents)]);
    if (trim($line)=='' || substr($line,0,1) == "#") {  //ignore empty lines and commented lines
      if ($count <= 1)
        return $line; //if only one array item exists, return it (return defaultHost instead?)
      return $this->loadRandomHost($filename); //try again, last line was unacceptable
    }
    return $line;
  }

  function getExternalIpFromHost($host) {
    echo "[debug] host = $host\n";
    $re = '/([0-9]{1,3}\.{1}){4}/';
    $re = '/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}(\.[0-9]{1,3}){0,1}/';
    $html = $this->executeCURL($host, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:25.0) Gecko/20100101 Firefox/25.0");

    $html = str_replace("\n", "", $html);
    if (preg_match_all($re, $html, $m)!==FALSE) {
      return $m[0][0];
    }
    return FALSE;
  }

  function getExternalIP() {
    $host = $this->loadRandomHost($this->hostsConfigFile);
    $ip   = $this->getExternalIpFromHost($host);

    if ($ip === FALSE)
      return FALSE;

    $this->lastHost     = $host;
    $this->lastIP       = $ip;
    $this->hasCachedIP  = TRUE;
    return $ip;
  }

  function getLastHost() {
    return $this->lastHost;
  }

  function getCachedIP() {
    if ($this->hasCachedIP())
      return $this->lastIP;

    return DEFAULT_IP;
  }

  function hasCachedIP() {
    return $this->hasCachedIP;
  }

}
