<?php
require_once("../../Library/Auth/Auth.php");
$table_name = "account";
$dir = "../../Library/Db/Data/";
require_once("../../Library/Db/connectDb.php");
/*补息*/
$amount = $_POST["amount"];
if($amount == ""){
	echo '<script>alert("请输入本次补息金额");history.go(-1);</script>';
	$db->close();
	exit;
}
if($amount < 0){
	echo '<script>alert("本次补息金额必须大于或等于零");history.go(-1);</script>';
	$db->close();
	exit;
}
//计算需进行补息操作的金额
$sql = "select amount from offset_interest where type=0";
$res_n = $db->select($sql);
if(!$res_n){
	$amount_sum_n = 0;
}else{
	$amount_sum_n = 0;
	for ($i=0; $i < count($res_n); $i++) { 
		$amount_sum_n += $res_n[$i]["amount"];
	}
}
//计算已进行补息操作的金额
$sql = "select amount from offset_interest where type=1";
$res_y = $db->select($sql);
if(!$res_y){
	$amount_sum_y = 0;
}else{
	$amount_sum_y = 0;
	for ($i=0; $i < count($res_y); $i++) { 
		$amount_sum_y += $res_y[$i]["amount"];
	}
}
//未补息操作的金额
$amount_sum = $amount_sum_n - $amount_sum_y;
if($amount > $amount_sum){
	echo '<script>alert("本次补息的金额不能大于未补息操作的金额");location.href="../operate.php";</script>';
	$db->close();
	exit;
}
$map = [];
$map["operator"] = $_SESSION["username"];
$map["amount"] = $amount;
$map["type"] = 1;
$date = time();
$map["create_date"] = $date;
$map["update_date"] = $date;
$res = $db->insert("offset_interest",$map);
if(!$res){
	echo '<script>alert("更新数据库失败");history.go(-1);</script>';
}else{
	$_SESSION["param"] = "操作成功,未补息操作的金额是：".($amount_sum-$amount);
	echo '<script>location.href="../Layouts/result.php";</script>';
}
$db->close();