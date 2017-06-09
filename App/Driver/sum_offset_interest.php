<?php
require_once("../../Library/Auth/Auth.php");
$table_name = "offset_interest";
$dir = "../../Library/Db/Data/";
require_once("../../Library/Db/connectDb.php");
//计算累计补息的金额
$sql = "select amount from offset_interest where type=1";
$res = $db->select($sql);
if(!$res){
	$amount_sum = 0;
}else{
	$amount_sum = 0;
	for ($i=0; $i < count($res); $i++) { 
		$amount_sum += $res[$i]["amount"];
	}
}
$_SESSION["param"] = " 累计补息的金额是：".$amount_sum;
echo '<script>location.href="../Layouts/result.php";</script>';
$db->close();