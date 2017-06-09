<?php
require_once("../Auth/Auth.php");
//ob_get_clean();//得到当前缓冲区的内容并刷新缓冲区
ob_start();//打开输出控制缓冲
$filename = $_SESSION["filename"];
$csv_head = implode(",",$_SESSION["csv_head"]).PHP_EOL;//从session里或得表头
$csv_param = $_SESSION["csv_param"];//从session里获得表格内容
//将数组拆分成以逗号分割的字符串
$csv_content_str = "";
foreach ($csv_param as $key => $value) {
	$csv_content = implode(",",$value);
	$csv_content_str = $csv_content_str.$csv_content.PHP_EOL;//每一行数据后面加上换行符
}
$csv = $csv_head.$csv_content_str;//拼接成需要输出的内容
$csv = iconv("UTF-8","GBK",$csv);//编码方式转换，防止乱码
//设置http头
header("Content-type:text/csv"); 
header("Content-Disposition:attachment;filename=$filename.csv"); //“生成文件名称”=自定义
header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
header('Expires:0'); 
header('Pragma:public'); 
echo $csv;//把内容输出到缓冲区
ob_end_flush();//冲刷缓冲区，并关闭缓冲
unset($_SESSION["filename"]);
unset($_SESSION["csv_head"]);
unset($_SESSION["csv_param"]);
