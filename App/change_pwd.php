<?php
require_once("../Library/Auth/Auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../Resouce/public.css" type="text/css">
	<title>修改密码</title>
</head>
<body>
	<?php
		require_once("Layouts/nav.php");
		echo "<br>";
	?>
	<h1>修改密码</h1>
	<form action="Driver/change_pwd.php" method="post">
		<br>
		<label>用户名</label>
		<input type="text" name="username" required><br><br>
		<label>原来的密码</label>
		<input type="password" name="old_pwd" required><br><br>
		<label>新密码</label>
		<input type="password" name="new_pwd" required><span>新密码只能为6~12个字符</span><br><br>
		<input type="submit" value="确认">
	</form>
</body>
</html>