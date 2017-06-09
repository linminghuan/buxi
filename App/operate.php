<?php
require_once("../Library/Auth/Auth.php");
$table_name = "account";
$dir = "../Library/Db/Data/";
require_once("../Library/Db/connectDb.php");
//计算需进行补息操作的金额
$sql = "select amount from offset_interest where type=0";
$res_n = $db->select($sql);
if(!$res_n){
	$amount_sum_n = 0;
}else{
	$amount_sum_n = 0;
	for ($i=0; $i < count($res_n); $i++) { 
		$amount_sum_n += $res_n[$i]["amount"];
	}
}
//计算已进行补息操作的金额
$sql = "select amount from offset_interest where type=1";
$res_y = $db->select($sql);
if(!$res_y){
	$amount_sum_y = 0;
}else{
	$amount_sum_y = 0;
	for ($i=0; $i < count($res_y); $i++) { 
		$amount_sum_y += $res_y[$i]["amount"];
	}
}
$amount_sum = $amount_sum_n - $amount_sum_y;
$amount_sum = round($amount_sum,4);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>补息操作</title>
	<link rel="stylesheet" href="../Resouce/public.css" type="text/css">
</head>
<body>
	<?php
		require_once("Layouts/nav.php");
	?>
	<h1>补息操作</h1>
	<h2>未补息操作金额：<span id="not_yet"><?php echo $amount_sum; ?></span></h2>
	当数字变成红色时未补息操作金额接近500000；
	<form action="Driver/operate.php" method="post" autocomplete="off">
		<br>
		<label>输入本次补息金额</label>
		<input type="number" name="amount" step="0.0001" min="0" required><br><br>
		<input type="submit" value="补息">
	</form>
</body>
</html>
<script type="text/javascript">
function init(){
	var val = document.getElementById("not_yet");
	if("<?php echo $amount_sum; ?>" - 500000 > -1000){
		val.style.color = "red";
	}else{
		val.style.color = "green";
	}
	
}
window.onload = init();
</script>
<?php
$db->close();