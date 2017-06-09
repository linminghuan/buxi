<?php
require_once("../Library/Auth/Auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>利率设置</title>
	<link rel="stylesheet" href="../Resouce/public.css" type="text/css">
	<style type="text/css">
		
	</style>
</head>
<body>
	<?php
		require_once("Layouts/nav.php");
	?>
	<form action="Driver/rate_setting.php" method="post" autocomplete="off">
		<br>
		<label for="rate">系统利率</label><input id="rate" type="number" step="0.0001" min="0" name="rate" required ><br><br>
		<label for="p_rate">客户利率</label><input id="p_rate" type="number" step="0.0001" min="0" name="p_rate" required ><br><br>
		<input type="submit" value="确定">
	</form>
</body>
</html>