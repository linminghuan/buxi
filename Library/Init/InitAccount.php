<?php
$table_name = "account";
$dir = "../Db/Data/";
require_once("../../Library/Db/connectDb.php");
$res = Sqlite::tableExist($db,$table_name);
var_dump($res);
if($res == false){
	$sql =<<<EOF
      CREATE TABLE account
      (id INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL,
      type        INT    	  NOT NULL,
      amount      DOUBLE      NOT NULL,
      operator    CHAR(50)    NOT NULL,
      offset_id   INTEGER     NOT NULL,
      surplus     DOUBLE	  NOT NULL,
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
/*$map["type"] = 1;
$map["amount"] = 10000000000;
$map["operator"] = "userA";
$map["create_date"] = 1456735481;
$map["update_date"] = 1456735481;
$map["surplus"] = 10000000000;
$map["offset_id"] = 1;
$res = $db->insert($table_name,$map);
if($res){
	echo "insert";
}else{
	echo $db->lastErrorMsg();
}*/
/*$sql = "update account set surplus = 100 where id=1;";
$res = $db->exec($sql);
var_dump($res);*/
$sql = "select * from account;";
$res = $db->select($sql);
var_dump($res);
/*$sql = "select * from account where type=0;";
$res = $db->select($sql);
var_dump($res);*/
/*$res = Sqlite::dropTable($db,$table_name);
if($res){
	echo "dropTable";
}else{
	echo $db->lastErrorMsg();
}*/
$db->close();