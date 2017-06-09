<?php 
/*ob_get_clean();
ob_start();
//header("Content-type:application/vnd.ms-excel"); 
//header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header("Content-Disposition:filename=test.xlsx"); 
echo "test1\t"; 
echo "test2\t\n"; 
echo "test1\t"; 
echo "test2\t\n"; 
echo "test1\t"; 
echo "test2\t\n"; 
echo "test1\t"; 
echo "test2\t\n"; 
echo "test1\t"; 
echo "test2\t\n"; 
echo "test1\t"; 
echo "test2\t\n"; 
header('Content-Disposition: attachment; filename=test.xls');
header('Accept-Ranges:bytes');
header('Content-Length:' . ob_get_length());
header('Content-Type:application/vnd.ms-excel');
//header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
ob_end_flush();*/
$csv_header = ['名称','性别','年龄'];
// 内容
$csv_body = [
 ['张三','男','13'],
 ['李四','女','13'],
 ['王五','男','13'],
 ['赵六','未知','13']
];
 
/**
 * 开始生成
 * 1. 首先将数组拆分成以逗号（注意需要英文）分割的字符串
 * 2. 然后加上每行的换行符号，这里建议直接使用PHP的预定义
 * 常量PHP_EOL
 * 3. 最后写入文件
 */
// 打开文件资源，不存在则创建
//$fp = fopen('test.csv','a');
// 处理头部标题
$header = implode(',', $csv_header) . PHP_EOL;
// 处理内容
$content = '';
foreach ($csv_body as $k => $v) {
 $content .= implode(',', $v) . PHP_EOL;
}
// 拼接
$csv = $header.$content;
$csv = iconv('UTF-8','GB2312',$csv);
// 写入并关闭资源
/*fwrite($fp, $csv);
fclose($fp);*/
header("Content-type:text/csv"); 
header("Content-Disposition:attachment;filename=生成文件名称.csv"); //“生成文件名称”=自定义
header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
header('Expires:0'); 
header('Pragma:public'); 
echo $csv;
?> 
