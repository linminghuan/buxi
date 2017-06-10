<?php
require_once("../Db/Sqlite.php");
$table_name = "user";
$db = new Sqlite('buxi',$table_name,"../Db/Data/");
if(!$db){
  echo $db->lastErrorMsg();
} else {
  echo "Opened database successfully\n";
}
$res = Sqlite::tableExist($db,$table_name);
if($res == false){
	$sql =<<<EOF
      CREATE TABLE user
      (id INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL,
      username    TEXT    NOT NULL,
      password    TEXT    NOT NULL);
EOF;
	$res = $db->createTable($sql);
	if($res){
		echo "createTable";
	}else{
		echo $db->lastErrorMsg();
	}
}
$map["username"] = "userA";
$map["password"] = "123";
$res = $db->insert($table_name,$map);
var_dump($res);
$map["username"] = "userB";
$map["password"] = "123";
$res = $db->insert($table_name,$map);
var_dump($res);
$sql = "select * from user;";
$res = $db->select($sql);
var_dump($res);
/*$res = Sqlite::dropTable($db,$table_name);
if($res){
	echo "dropTable";
}else{
	echo $db->lastErrorMsg();
}*/
$db->close();