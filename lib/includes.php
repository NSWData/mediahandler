<?php
/**************************************************
 *
 * Make any dependant files and configs available
 *
 **************************************************/
// any CONFIG . cfg file has key = value pairs which become code constantss
foreach (glob("/var/www/config/*.cfg") as $filename) {
        getUserDefinitions($filename, true);
}

foreach (glob("/var/www/config/*.conf.php") as $filename) {
    include $filename;
}

/** take an ini style file and return as a hash of value key pairs as an assoc array
  * 'define' allows settings to be made available as code CONSTANTS
  *
  * @param String : name of file to parse (absolute)
  * @param Boolean : if true set any key value pairs as CONSTANTS
  *
  * @return mixed : associative array of key value pairs
  *
  **/
function getUserDefinitions($filename, $define=true) {
    error_reporting(E_ALL);
        $defs = array();
        $f = fopen($filename, 'r');
        if ($f) {
            while (!feof ($f)) {
                $buffer = fgets($f, 4096);
                $sep = stripos($buffer, '=');
                if (substr($buffer, 0, 1) != '#') {
                    if ($sep < 1) {
                        $value = null;
                    } else {
                        $idx = substr($buffer, 1, $sep);
                        $key = substr($buffer, 0, $sep);
                        $value = trim(substr($buffer, $sep+1));
                        $defs[$key] = $value;
                        if ($define == true) {
                                define($key, $value);
                        }
                    }
                 }
             }
        } else {
                // DEBUG print "Not able to open : $filename";
        }
        return $defs;
}
?>
