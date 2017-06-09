<?php
require_once("../../Library/Auth/Auth.php");
$table_name = "account";
$dir = "../../Library/Db/Data/";
require_once("../../Library/Db/connectDb.php");
$amount = $_SESSION["amount"];
//支取
if($amount != ""){
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
	if($amount <= 0){
		echo '<script>alert("金额不能为负数或零");location.href="../withdrawal.php";</script>';
		$db->close();
		exit;
	}
	//计算需补息金额
	$sql = "select id,surplus,offset_id,create_date from account where type=1 order by create_date ASC;";
	$res_arr = $db->select($sql);
	if($res_arr){
		$remain_amount = $amount;//本次需要补息的金额
		$offset_amount = 0;//本次补息的总金额
		for ($i = 0; $remain_amount > 0 ; $i++) { 
			if($remain_amount - $res_arr[$i]["surplus"]>=0){
				$tmp_amount = $res_arr[$i]["surplus"];//本次需要补息的部分金额
				$remain_amount = $remain_amount - $res_arr[$i]["surplus"];//本次需要补息的总金额
				$surplus = 0;//单笔进账的未补息额
			}else{
				$tmp_amount = $remain_amount;//本次需要补息的部分金额
				$surplus = $res_arr[$i]["surplus"] - $remain_amount;//单笔进账的未补息额
				$remain_amount = 0;//本次需要补息的总金额
			}
			//更新单笔进账的未补息额
			$map = [];
			$map["surplus"] = $surplus;
			$map["update_date"] = time();
			$where = "id=".$res_arr[$i]["id"];
			$res = $db->update("account",$map,$where);
			if(!$res){
				echo '<script>alert("操作数据库失败，请重试");location.href="../withdrawal.php";</script>';
				$db->close();
				exit;
			}
			//计算天数
			$in_date = intval($res_arr[$i]["create_date"]/86400);
			$out_date = intval(time()/86400);
			$long = $out_date - $in_date;
			$tmp_id = $res_arr[$i]["offset_id"];
			$sql = "select rate,p_rate from interest_rate where id=".$tmp_id.";";
			$res_rate = $db->select($sql);
			if(!$res_rate){
				echo '<script>alert("操作数据库失败，请重试");location.href="../withdrawal.php";</script>';
				$db->close();
				exit;
			}else{
				//需部分补息金额
				$offset_amount = $offset_amount + $tmp_amount*($res_rate[$i]["p_rate"] - $res_rate[$i]["rate"])/360*$long;
			}
		}
		//插入到补息表
		$map = [];
		$map["operator"] = $_SESSION["username"];;
		$map["type"] = 0;
		//使用四舍五入法保留四位小数
		$offset_amount = round($offset_amount,4);
		$map["amount"] = $offset_amount;
		$date = time();
		$map["create_date"] = $date;
		$map["update_date"] = $date;
		$res = $db->insert("offset_interest",$map);
		if(!$res){
			echo '<script>alert("操作数据库失败，请重试");location.href="../withdrawal.php";</script>';
			$db->close();
			exit;
		}
		//向account表添加一条支取记录
		$map = [];
		$map["amount"] = $amount;
		$map["operator"] = $_SESSION["username"];
		$map["type"] = 0;
		$map["surplus"] = 0;
		$date = time();
		$map["create_date"] = $date;
		$map["update_date"] = $date;
		$sql = "SELECT id FROM interest_rate ORDER BY update_date DESC;";
		$res = $db->select($sql);
		$map["offset_id"] = $res[0]["id"];
		$res = $db->insert($table_name,$map);
		if(!$res){
			echo '<script>alert("操作失败，请重试");location.href="../withdrawal.php";</script>';
			$db->close();
			exit;
		}
		$_SESSION["param"] = "操作成功,余额是：".($sum - $amount);
		echo '<script>location.href="../Layouts/result.php";</script>';
		$db->close();
		exit;
	}else{
		echo '<script>alert("操作失败，请重试");location.href="../withdrawal.php";</script>';
		$db->close();
		exit;
	}
}else{
	echo '<script>alert("请输入存入金额");location.href="../withdrawal.php";</script>';
	$db->close();
	exit;
}
$db->close();