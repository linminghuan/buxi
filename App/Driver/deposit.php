<?php
require_once("../../Library/Auth/Auth.php");
$table_name = "account";
$dir = "../../Library/Db/Data/";
require_once("../../Library/Db/connectDb.php");
//存入
$amount = $_SESSION["amount"];
if($amount != ""){
	if($amount <= 0){
		echo '<script>alert("金额不能为负数或零");location.href="../deposit.php";</script>';
		$db->close();
		exit;
	}else{
		$map["amount"] = $amount;
		$map["operator"] = $_SESSION["username"];
		$map["type"] = 1;
		$map["surplus"] = $amount;
		$date = time();
		$map["create_date"] = $date;
		$map["update_date"] = $date;
		$sql = "SELECT id FROM interest_rate ORDER BY update_date DESC;";
		$res = $db->select($sql);
		$map["offset_id"] = $res[0]["id"];
		$res = $db->insert($table_name,$map);
		if($res){
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
			$_SESSION["param"] = "操作成功,余额是：".$sum;
			unset($_SESSION["amount"]);
			echo '<script>location.href="../Layouts/result.php";</script>';
		}else{
			echo '<script>alert("操作失败，请重试");location.href="../deposit.php";</script>';
			exit;
			$db->close();
		}
	}
}else{
	echo '<script>alert("请输入存入金额");location.href="../deposit.php";</script>';
}
$db->close();