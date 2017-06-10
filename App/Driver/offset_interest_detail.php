<?php
require_once("../../Library/Auth/Auth.php");
$table_name = "offset_interest";
$dir = "../../Library/Db/Data/";
require_once("../../Library/Db/connectDb.php");
/*补息明细处理*/
$date_from = $_POST["date_from"];
$date_to = $_POST["date_to"];
$amount_from = $_POST["amount_from"];
$amount_to = $_POST["amount_to"];
//检查传进来的参数
if($date_from > $date_to){
	echo '<script>alert("起始时间不能超过结束时间");history.go(-1);</script>';
	$db->close();
	exit;
}
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
//
$sql = "select * from offset_interest where update_date>".$date_from." AND update_date<".$date_to." AND amount>".$amount_from." AND amount<".$amount_to.";";
$res = $db->select($sql);
if(!$res){
	echo '<script>alert("查询结果为空");history.go(-1);</script>';
	$db->close();
	exit;
}
unset($_SESSION["filename"]);
unset($_SESSION["csv_head"]);
unset($_SESSION["csv_param"]);

$filename = "补息明细——".date("Y-m-d",time());
$_SESSION["filename"] = $filename;
$csv_head = ["id","类型","金额","操作者","操作日期"];
$_SESSION["csv_head"] = $csv_head;
for ($i=0; $i < count($res); $i++) { 
	$map[0] = $res[$i]["id"];
	if($res[$i]["type"] == 1){
		$map[1] = "已补息";
	}else{
		$map[1] = "未补息";
	}
	$map[2] = $res[$i]["amount"];
	$map[3] = $res[$i]["operator"];
	$map[4] = date("Y-m-d",$res[$i]["create_date"]);
	$csv_param[$i] = $map; 
}
$_SESSION["csv_param"] = $csv_param;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>补息明细</title>
	<link rel="stylesheet" href="../../Resouce/public.css" type="text/css">
	<style type="text/css">
		td,th{
			text-align: center;
			width:200px;
		}
	</style>
</head>
<body>
	<h1>补息明细</h1>
	<table border="1" cellspacing="0">
		<tr>
			<th>id</th>
			<th>类型</th>
			<th>金额</th>
			<th>操作者</th>
			<th>操作日期</th>
		</tr>
		<?php
			for ($i=0; $i < count($res); $i++) { 
				echo "<tr>";
				echo "<td>".$res[$i]["id"]."</td>";
				if($res[$i]["type"] == 0 ){
					echo "<td>未补息</td>";
				}else{
					echo "<td>已补息</td>";
				}
				echo "<td>".round($res[$i]["amount"],4)."</td>";
				echo "<td>".$res[$i]["operator"]."</td>";
				$date_w = date("Y-m-d H:i:s ",$res[$i]["update_date"]);
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
?>