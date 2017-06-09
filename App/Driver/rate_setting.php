<?php
require_once("../../Library/Auth/Auth.php");
$table_name = "interest_rate";
$dir = "../../Library/Db/Data/";
require_once("../../Library/Db/connectDb.php");
//设置利率
$rate = $_POST["rate"];
$p_rate = $_POST["p_rate"];
if($rate != ""){
	if($p_rate != ""){
		$operator = $_SESSION["username"];
		$date = time();
		$map["operator"] = $operator;
		$map["rate"] = $rate;
		$map["p_rate"] = $p_rate;
		$map["create_date"] = $date;
		$map["update_date"] = $date;
		$res = $db->insert($table_name,$map);
		if($res){
			echo '<script>alert("设置成功");location.href="../rate_setting.php";</script>';
		}else{
			echo '<script>alert("设置失败，请重新设置");location.href="../rate_setting.php";</script>';
		}
	}else{
		echo '<script>alert("请输入客户利率");location.href="../rate_setting.php";</script>';
	}
}else{
	echo '<script>alert("请输入系统利率");location.href="../rate_setting.php";</script>';
}
$db->close();