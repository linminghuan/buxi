<?php
require_once("../../Library/Auth/Auth.php");
$table_name = "account";
$dir = "../../Library/Db/Data/";
require_once("../../Library/Db/connectDb.php");
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
$amount_sum = $amount_sum_n - $amount_sum_y;
$amount_sum = round($amount_sum,4);
$_SESSION["param"] = "未进行补息操作金额是：".$amount_sum;
echo '<script>location.href="../Layouts/result.php";</script>';
$db->close();