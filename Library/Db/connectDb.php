<?php
require_once("Sqlite.php");
$db = new Sqlite('buxi',$table_name,$dir);
if(!$db){
  echo $db->lastErrorMsg();
} else {
}