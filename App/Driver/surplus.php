<?php
require_once("../../Library/Auth/Auth.php");
$table_name = "account";
$dir = "../../Library/Db/Data/";
require_once("../../Library/Db/connectDb.php");
//计算余额
$sql = "select amount from account where type=1";
$res_arr_in = $db->select($sql);
$sql = "select amount from account where type=0";
$res_arr_out = $db->select($sql);
$in_sum = 0;//存入的总金额
$out_sum = 0;//支取的总结
if($res_arr_in){
	for( $i = 0 ; $i < count($res_arr_in) ; $i++ ){
		$in_sum += $res_arr_in[$i]["amount"];
	}
}
if($res_arr_out){
	for( $i = 0 ; $i < count($res_arr_out) ; $i++ ){
		$out_sum += $res_arr_out[$i]["amount"];
	}
}
$sum = $in_sum - $out_sum;//余额
$_SESSION["param"] = "你的余额是：".$sum;
echo '<script>location.href="../Layouts/result.php";</script>';
$db->close();
