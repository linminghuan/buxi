<?php
require_once("../Library/Auth/Auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>存款支取</title>
	<link rel="stylesheet" href="../Resouce/public.css" type="text/css">
	<style type="text/css">
		
	</style>
</head>
<body>
	<?php
		require_once("Layouts/nav.php");
	?>
	<form action="defence.php" method="post" autocomplete="off">
		<br>
		<label for="">支取金额</label><input type="number" step="0.0001" min="0" name="amount" required ><br><br>
		<input type="hidden" name="operate_type" value="w">
		<input type="submit" value="确定">
	</form>
</body>
</html>