<?php
require_once("../Library/Auth/Auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>补息查询</title>
	<link rel="stylesheet" href="../Resouce/public.css" type="text/css">
	<style type="text/css">
	
	</style>
</head>
<body>
	<?php
		require_once("Layouts/nav.php");
		echo "<br>";
	?>
	<h1>补息明细</h1>
	<form action="Driver/offset_interest_detail.php" method="post">
		<label>输入时间段</label>
		<input type="date" name="date_from">
		<input type="date" name="date_to"><br><br>
		<label>输入一个金额区间</label>
		<input type="number" name="amount_from" step="0.0001"> 
		<input type="number" name="amount_to" step="0.0001"><br><br>
		<input type="submit" value="查询">
	</form>
</body>
</html>