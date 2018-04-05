<?php
/** $Id lib.php
 *
 * @Auth : Adriaan Woerlee
 * @Data : 2015-07-05
 *
 * Library of Definitions and common functions
 */
// Error Reporting
//error_reporting(0);
/* Some user defined values from a system config file */
ini_set('memory_limit','256M');
date_default_timezone_set('Australia/Sydney');

$self = $_SERVER['SCRIPT_FILENAME'];
if (strpos($self, '/var/www/html/users/') !== FALSE) {
	// This is user pages which can have their own includes
} else {
	require_once 'includes.php';
}


/* Define the 'root' directory for the application */
$BASE_APP_DIR = '/lib';
define('BASE_APP_DIR', $BASE_APP_DIR);

// TODO smarty include actually defines this !!
define('MASTERTEMPLATE_DIR', $_SERVER['DOCUMENT_ROOT'].'/mastertemplates');

set_include_path("/usr/share/php/:$BASE_APP_DIR");

/* get a system parameter defined in the system config text file */
function getSystemParam($param_name) {
    global $SYS_CONFIG;
    //print "\n $SYS_CONFIG \n";
    return trim(getResourceBundle($SYS_CONFIG, $param_name));
}

/**
  *
  **/
function getConfigParameters($filename) {
          $values = array();
          $f = fopen($filename, "r");
          if ($f) {
                while (!feof ($f) ) {
                        $buffer = fgets($f, 4096);
                        $x = stripos($buffer, "=");
                        if ($x < 1) {
                                $value = null;
                        } else {
                                $index = substr($buffer, 0, $x);
                                $value = trim(substr($buffer, $x + 1));
                                $values[$index] = $value;
                        }
                }
          } else {
                print "$filename does not exist";
          }
}
?>
