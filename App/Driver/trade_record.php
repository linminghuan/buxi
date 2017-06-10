<?php
require_once("../../Library/Auth/Auth.php");
$table_name = "account";
$dir = "../../Library/Db/Data/";
require_once("../../Library/Db/connectDb.php");
/*补息明细处理*/
$date_from = $_POST["date_from"];
$date_to = $_POST["date_to"];
$amount_from = $_POST["amount_from"];
$amount_to = $_POST["amount_to"];
//检查传进来的参数
if($date_from == ""){
	$date_from = 0;
}else{
	//把日期转换为时间戳
	$date_from = strtotime($date_from);
}
if($date_to == ""){
	$date_to = time();
}else{
	//把日期转换为时间戳
	$date_to = $res = strtotime($date_to);
}
if($date_from > $date_to){
	echo '<script>alert("起始时间不能超过结束时间");history.go(-1);</script>';
	$db->close();
	exit;
}
if($amount_from > $amount_to){
	echo '<script>alert("起始金额不能超过结束金额");history.go(-1);</script>';
	$db->close();
	exit;
}
if($amount_from == ""){
	/*echo '<script>alert("请输入起始金额");history.go(-1);</script>';
	exit;*/
	$amount_from = 0;
}
if($amount_to == ""){
	/*echo '<script>alert("请输入结束金额");history.go(-1);</script>';
	exit;*/
	$amount_to = 100000000000000;
}
if($amount_from < 0 || $amount_to < 0){
	echo '<script>alert("请输入金额不能小于零");history.go(-1);</script>';
	$db->close();
	exit;
}
$sql = "select * from account where create_date>=".$date_from." AND create_date<=".$date_to." AND amount>=".$amount_from." AND amount<=".$amount_to.";";
$res = $db->select($sql);
if(!$res){
	echo '<script>alert("数据查询结果为空");location.href="../trade_record.php";</script>';
	$db->close();
	exit;
}
unset($_SESSION["filename"]);
unset($_SESSION["csv_head"]);
unset($_SESSION["csv_param"]);
//把本页的数据存到session中以便导出时调用
$filename = "交易流水——".date("Y-m-d",$date_from)."~".date("Y-m-d",$date_to);
$_SESSION["filename"] = $filename;
$csv_head = ["id","类型","金额","系统利率","客户利率","操作者","操作日期"];
$_SESSION["csv_head"] = $csv_head;
for ($i=0; $i < count($res); $i++) { 
	$map[0] = $res[$i]["id"];
	if($res[$i]["type"] == 1){
		$map[1] = "存入";
	}else{
		$map[1] = "支取";
	}
	$map[2] = $res[$i]["amount"];
	$sql = "select rate,p_rate from interest_rate where id=".$res[$i]["offset_id"].";";
	$res_rate = $db->select($sql);
	if($res_rate){
		$map[3] = $res_rate[0]["rate"];
		$map[4] = $res_rate[0]["p_rate"];
	}else{
		echo '<script>alert("查询数据库失败");history.go(-1);</script>';
		$db->close();
		exit;
	}
	$map[5] = $res[$i]["operator"];
	$map[6] = date("Y-m-d",$res[$i]["create_date"]);
	$csv_param[$i] = $map;
}
$_SESSION["csv_param"] = $csv_param;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>交易流水</title>
	<link rel="stylesheet" href="../../Resouce/public.css" type="text/css">
	<style type="text/css">
		td,th{
			text-align: center;
			width:200px;
		}
	</style>
</head>
<body>
	<h1>交易流水</h1>
	<table border="1" cellspacing="0">
		<tr>
			<th>id</th>
			<th>类型</th>
			<th>金额</th>
			<th>系统利率</th>
			<th>客户利率</th>
			<th>操作者</th>
			<th>操作日期</th>
		</tr>
		<?php
			for ($i=0; $i < count($res); $i++) { 
				echo "<tr>";
				echo "<td>".$res[$i]["id"]."</td>";
				if($res[$i]["type"] == 0 ){
					echo "<td>支取</td>";
				}else{
					echo "<td>存入</td>";
				}
				echo "<td>".$res[$i]["amount"]."</td>";
				$sql = "select rate,p_rate from interest_rate where id=".$res[$i]["offset_id"].";";
				$res_rate = $db->select($sql);
				if($res_rate){
					echo "<td>".$res_rate[0]["rate"]."</td>";
					echo "<td>".$res_rate[0]["p_rate"]."</td>";
				}else{
					echo '<script>alert("数据库操作失败");history.go(-1);</script>';
					$db->close();
					exit;
				}
				echo "<td>".$res[$i]["operator"]."</td>";
				$date_w = date("Y-m-d H:i:s ",$res[$i]["create_date"]);
				echo "<td>".$date_w."</td>";
				echo "</tr>";
			}
		?>
	</table>
	<a href="../../Library/Tools/output_csv.php">导出</a><br>
	<a href="" onclick="javascript:history.go(-1);">返回</a>
</body>
</html>
<?php
$db->close();