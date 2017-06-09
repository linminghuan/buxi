<?php
require_once("../../Library/Auth/Auth.php");
$table_name = "user";
$dir = "../../Library/Db/Data/";
require_once("../../Library/Db/connectDb.php");
$username = $_POST['username'];
$password = $_POST['password'];
if($username != ""){
	$sql = "select password from user where username like '".$username."'";
	$res = $db->select($sql);
	if(!$res){
		echo '<script>alert("用户名不存在");location.href="../login.html";</script>';
		$db->close();
		exit;
	}
	if($password != ""){
		if($password == $res[0]['password']){
			$_SESSION["username"] = $username;
			$_SESSION["operate_type"] = "";//为了结果页不报错所以在这里初始化这个session字段
			Header("Location:../index.php");
		}else{
			echo '<script>alert("密码错误");location.href="../login.html";</script>';
			$db->close();
			exit;
		}
	}else{
		echo '<script>alert("请输入密码");location.href="../login.html";</script>';
		$db->close();
		exit;
	}
}else{
	echo '<script>alert("请输入用户名");location.href="../login.html";</script>';
	$db->close();
	exit;
}
$db->close();
	
