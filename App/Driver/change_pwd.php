<?php
require_once("../../Library/Auth/Auth.php");
$table_name = "user";
$dir = "../../Library/Db/Data/";
require_once("../../Library/Db/connectDb.php");
$username = $_POST["username"];
$old_pwd = $_POST["old_pwd"];
$new_pwd = $_POST["new_pwd"];
if($username == ""){
	echo '<script>alert("请输入用户名");history.go(-1);</script>';
	$db->close();
	exit;
}
if($old_pwd == ""){
	echo '<script>alert("请输入原来的密码");history.go(-1);</script>';
	$db->close();
	exit;
}
if($new_pwd == ""){
	echo '<script>alert("请输入新密码");history.go(-1);</script>';
	$db->close();
	exit;
}else{
	$length = strlen($new_pwd);
	if($length < 6){
		echo '<script>alert("密码长度不能小于6");history.go(-1);</script>';
		$db->close();
		exit;
	}else if($length > 12){
		echo '<script>alert("密码长度不能大于12");history.go(-1);</script>';
		$db->close();
		exit;
	}
}
$sql = "select password from user where username = '".$username."';";
$res = $db->select($sql);
if(!$res){
	echo '<script>alert("用户名不存在");history.go(-1);</script>';
	$db->close();
	exit;
}
if($old_pwd == $res[0]["password"]){
	$map["password"] = $new_pwd;
	$where = "username='".$username."'";
	$res1 = $db->update("user",$map,$where);
	if(!$res1){
		echo '<script>alert("修改失败");history.go(-1);</script>';
		$db->close();
		exit;
	}else{
		echo '<script>alert("密码修改成功");history.go(-1);</script>';
		$db->close();
		exit;
	}
}