<?php
include_once 'db_conf.php';
$connection = mysql_connect($mysqlhost, $mysqluser, $mysqlpwd, $mysqldb) 
    or die("Die Verbindung konnte nicht hergestellt werden! - " . mysql_error());
	
$db_select = mysql_select_db("cocktail_machine", $connection);
if (!$db_select) { 
       die("Database selection failed:: " . mysql_error()); 
} 
?>