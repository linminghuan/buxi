<?php
require_once("../../Library/Auth/Auth.php");
$table_name = "user";
$dir = "../../Library/Db/Data/";
require_once("../../Library/Db/connectDb.php");
/*双重验证*/
$now_pwd = $_POST["now_pwd"];
$sub_pwd = $_POST["sub_pwd"];
if($now_pwd == ""){
	echo '<script>alert("请输入已登录的用户的密码");location.href="../defence.php";</script>';
	$db->close();
	exit;
}
if($sub_pwd == ""){
	echo '<script>alert("请输入第二个用户的密码");location.href="../defence.php";</script>';
	$db->close();
	exit;
}
$sql = "select * from user ;";
$res = $db->select($sql);
if(!$res){
	echo '<script>alert("数据库操作失败");location.href="../defence.php";</script>';
	$db->close();
	exit;
}
if($now_pwd != $res[0]["password"]){
	echo '<script>alert("已登录的用户的密码不一致");location.href="../defence.php";</script>';
	$db->close();
	exit;
}
if($sub_pwd != $res[1]["password"]){
	echo '<script>alert("第二个用户的密码不正确");location.href="../defence.php";</script>';
	$db->close();
	exit;
}
$operate_type = $_SESSION["operate_type"];
if($operate_type == "d"){
	echo '<script>alert("验证通过");location.href="./deposit.php";</script>';
}else{
	echo '<script>alert("验证通过");location.href="./withdrawal.php";</script>';
}
$db->close();
exit;