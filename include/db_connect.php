<?php
mysql_connect($config['db_hostname'], $config['db_username'], $config['db_password']) or die("Could not connect to MySQL database. Check config.php.<br />" . mysql_error());
mysql_select_db($config['db_name']) or die("Could not select the oneapp MySQL database. Check config.php.<br />" . mysql_error());
?>
