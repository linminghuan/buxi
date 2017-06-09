<?php
$table_name = "offset_interest";
$dir = "../Db/Data/";
require_once("../../Library/Db/connectDb.php");
$res = Sqlite::tableExist($db,$table_name);
var_dump($res);
if($res == false){
	$sql =<<<EOF
      CREATE TABLE offset_interest
      (id INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL,
      type      INT    	    NOT NULL,
      amount    DOUBLE    	NOT NULL,
      operator  CHAR(50)    NOT NULL,
      create_date INTEGER     NOT NULL,
      update_date INTEGER     NOT NULL);
EOF;
	$res = $db->createTable($sql);
	if($res){
		echo "createTable";
	}else{
		echo $db->lastErrorMsg();
	}
}
/*$map["type"] = 0;
$map["amount"] = 1242255;
$map["operator"] = "userA";
$map["date"] = 1154845568;
$res = $db->insert($table_name,$map);
if($res){
	echo "insert";
}else{
	echo $db->lastErrorMsg();
}*/
$sql = "select * from offset_interest;";
$res = $db->select($sql);
var_dump($res);
/*$res = Sqlite::dropTable($db,$table_name);
if($res){
	echo "dropTable";
}else{
	echo $db->lastErrorMsg();
}*/
$db->close();