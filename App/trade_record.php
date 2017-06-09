<?php
require_once("../Library/Auth/Auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>交易流水</title>
	<link rel="stylesheet" href="../Resouce/public.css" type="text/css">
</head>
<body>
	<?php
		require_once("Layouts/nav.php");
	?>
	<h1>交易流水</h1>
	<form action="Driver/trade_record.php" method="post">
		<label>输入时间段</label>
		<input type="date" name="date_from">
		<input type="date" name="date_to"><br><br>
		<label>输入一个金额区间</label>
		<input type="number" name="amount_from" step="0.0001" min="0">
		<input type="number" name="amount_to" step="0.0001" min="0"><br><br>
		<input type="submit" value="查询">
	</form>
</body>
</html>