<?php
$table_name = "interest_rate";
$dir = "../Db/Data/";
require_once("../../Library/Db/connectDb.php");
$res = Sqlite::tableExist($db,$table_name);
var_dump($res);
if($res == false){
	$sql =<<<EOF
      CREATE TABLE interest_rate
      (id INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL,
      rate      REAL    	NOT NULL,
      p_rate    REAL    	NOT NULL,
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
/*$map["rate"] = 0.053;
$map["p_rate"] = 1.255;
$map["operator"] = "userA";
$map["date"] = 1654845568;
$res = $db->insert($table_name,$map);
if($res){
	echo "insert";
}else{
	echo $db->lastErrorMsg();
}*/
$sql = "select * from interest_rate;";
$res = $db->select($sql);
var_dump($res);
/*$res = Sqlite::dropTable($db,$table_name);
if($res){
	echo "dropTable";
}else{
	echo $db->lastErrorMsg();
}*/
$db->close();