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
/*for ($i=0; $i < 50; $i++) {
	$temp = rand(0,1);
	$map["type"] = $temp;
	$map["amount"] = 1000;
	$map["operator"] = "userA";
	$map["create_date"] = 1420070400 + $i*36000;
	$map["update_date"] = 1420070400 + $i*36000;
	if($i%2 == 1){
		$map["surplus"] = 1000;
	}else{
		$map["surplus"] = 0;
	}
	$map["offset_id"] = 2;
	$res = $db->insert($table_name,$map);
	if($res){
		echo "insert".$i;
	}else{
		echo $db->lastErrorMsg();
	}
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