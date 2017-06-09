<?php
require_once("../Library/Auth/Auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../Resouce/public.css" type="text/css">
	<title>日报</title>
</head>
<body>
	<?php
		require_once("Layouts/nav.php");
		echo "<br>";
	?>
	<h1>日报</h1>
	<form action="Driver/daily_report.php" method="post">
		<br>
		<label>输入时间段</label>
		<input type="date" name="date"><br><br>
		<input type="submit" value="查询">
	</form>
</body>
</html>