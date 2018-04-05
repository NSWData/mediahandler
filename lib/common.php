<?php

/** get argument from Request
  * @param string name of request parameter
  * @param string default value to be returned if null
  *
  **/
function getArgFromUrl($param, $default=null) {
  if (isset($_REQUEST["$param"])) {
      $arg = checkValidInput($_REQUEST["$param"]);
      if (empty($arg)) {
          $arg = $default;
      }
  } else {
      $arg = $default;
  }
  return $arg;
}


/**
  * check value of parameters for anytyhing naughty
  *
  **/
function checkValidInput($str) {
        $return = true;

        $checks = array('<', '>', 'script', '.js');
        for ($i = 0; $i < count($checks); $i++) {
            if (strpos($str, $checks[$i]) > 0) {
                $return = false;
            }
            if (substr($str,0,1) == '<') $return = false;
            if (substr($str,0,1) == '>') $return = false;
        }

        if ($return == false) {
                print "Cannot supply requested page.";
                exit();
        } else {
                $str = filter_var($str, FILTER_SANITIZE_STRING);
                return htmlspecialchars(strip_tags(htmlentities($str)));
        }

}

?>
