<?php
require_once("../Library/Auth/Auth.php");
$table_name = "account";
$dir = "../Library/Db/Data/";
require_once("../Library/Db/connectDb.php");
$amount = $_POST["amount"];
$operate_type = $_POST["operate_type"];
if($amount != ""){
	if($operate_type == "w"){
		//判断余额是否足够
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
		if($sum < $amount){
			echo '<script>alert("支取金额不能超过余额");location.href="../withdrawal.php";</script>';
			$db->close();
			exit;
		}
	}
	if($amount <= 0){
		echo '<script>alert("金额不能为负数或零");location.href="../deposit.php";</script>';
		$db->close();
		exit;
	}else{
		$_SESSION["amount"] = $amount;
		$_SESSION["operate_type"] = $operate_type;
		$db->close();
	}
}else{
	echo '<script>alert("请输入存入金额");location.href="../deposit.php";</script>';
	$db->close();
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../Resouce/public.css" type="text/css">
	<title>验证</title>
</head>
<body>
	<form action="Driver/defence.php" method="post">
		<br>
		<label>当前用户的密码</label>
		<input type="password" name="now_pwd" require><br><br>
		<label>第二个用户的密码</label>
		<input type="password" name="sub_pwd" require><br><br>
		<input type="submit" value="确认">
	</form>
</body>
</html>