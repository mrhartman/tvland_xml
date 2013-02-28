<?php
// define database connection
define('CONST_DB_SERVER', 'localhost');
define('CONST_DB_SERVER_USERNAME', 'root');
define('CONST_DB_SERVER_PASSWORD', 'password');
define('CONST_DB_NAME', 'tvland_tagging_v2');

$conn = mysql_connect(CONST_DB_SERVER, CONST_DB_SERVER_USERNAME, CONST_DB_SERVER_PASSWORD)
  or die(mysql_error()); 
$db = mysql_select_db(CONST_DB_NAME)
  or die(mysql_error());
?>
