<?php

$hostname = system('cat /etc/hostname', $output);

print "<h1>$hostname</h1>";

?>
