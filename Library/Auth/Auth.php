<?php
/*require_once("./Library/Db/Sqlite.php");
$table_name = "user";
$db = new Sqlite('buxi',$table_name,"../Db/Data/");
if(!$db){
  echo $db->lastErrorMsg();
} else {
  echo "Opened database successfully\n";
}*/
session_start();
date_default_timezone_set('PRC');
if(!$_SESSION["username"]){
	$url = "/buxi/App/login"; 
	if (isset($url)) 
	{ 
		Header("Location: $url"); 
	} 
}
