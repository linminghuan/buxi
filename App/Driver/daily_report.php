<?php
require_once("../../Library/Auth/Auth.php");
$table_name = "account";
$dir = "../../Library/Db/Data/";
require_once("../../Library/Db/connectDb.php");
/*生成日报*/
$date = $_POST["date"];
$date = strtotime($date);//日期转时间戳
//检查传进来的参数
if($date == ""){
	$date = time();
	$date_num = intval($date/86400);//计算天数
	$date = $date_num*86400;//所查询日期的零点时间戳
}
$date_n = $date + 86400;//第二天的零点的时间戳
$sql = "select amount,type from account where create_date>".$date." AND create_date<".$date_n.";";
$res_a = $db->select($sql);//account表的结果集
$sql = "select amount,type from offset_interest where create_date>=".$date." AND create_date<".$date_n.";";
$res_b = $db->select($sql);//offset_interest表的结果集
/*if(!$res_a){
	echo '<script>alert("操作数据库失败，请重试");location.href="../daily_report.php";</script>';
	exit;
}
if(!$res_b){
	
	echo '<script>alert("操作数据库失败，请重试");location.href="../daily_report.php";</script>';
	exit;
}*/
$in_amount = 0;//存入金额
$out_amount = 0;//支取金额
//计算当天的存入金额和支取金额
for($i = 0 ; $i < count($res_a) ; $i++){
	if($res_a[$i]["type"] == 1){
		$in_amount += $res_a[$i]["amount"];
	}else{
		$out_amount += $res_a[$i]["amount"];
	}
}
$offset = 0;//未补息金额
$need_offset = 0;//需补息
$has_offset = 0;//已补息金额
for($i = 0 ; $i < count($res_b) ; $i++){
	if($res_b[$i]["type"] == 0){
		$need_offset += $res_b[$i]["amount"];//需补息
	}else{
		$has_offset += $res_b[$i]["amount"];
	}
}
$offset = $need_offset - $has_offset;
unset($_SESSION["filename"]);
unset($_SESSION["csv_head"]);
unset($_SESSION["csv_param"]);

//把本页的数据存到session中以便导出时调用
$filename = "日报——".date("Y-m-d",$date);
$_SESSION["filename"] = $filename;
$csv_head = ["日期","本日存入金额","本日支取金额","本日未补息金额","本日已补息金额"];
$_SESSION["csv_head"] = $csv_head;
$csv_param_arr = [date("Y-m-d",$date),$in_amount,$out_amount,$need_offset,$has_offset];
$csv_param = [$csv_param_arr];
$_SESSION["csv_param"] = $csv_param;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>日报</title>
	<link rel="stylesheet" href="../../Resouce/public.css" type="text/css">
	<style type="text/css">
		td,th{
			text-align: center;
			width:200px;
		}
	</style>
</head>
<body>
	<h1>日报</h1>
	<table border="1" cellspacing="0">
		<tr>
			<th>日期</th>
			<th>本日存入金额</th>
			<th>本日支取金额</th>
			<th>本日未补息金额</th><!-- 
			<th>本日未补息金额</th> -->
			<th>本日补息操做金额</th>
		</tr>
		<?php
			echo "<tr>";
			echo "<td>".date("Y-m-d",$date)."</td>";
			echo "<td>".$in_amount."</td>";
			echo "<td>".$out_amount."</td>";
			echo "<td>".$need_offset."</td>";
			/*echo "<td>".$offset."</td>";*/
			echo "<td>".$has_offset."</td>";			
			echo "</tr>";
		?>
	</table>
	<a href="../../Library/Tools/output_csv.php">导出</a><br>
	<a href="" onclick="javascript:history.go(-1);">返回</a>
</body>
</html>
<?php
$db->close();