<?php
require_once("../../Library/Auth/Auth.php");
$param = $_SESSION["param"];
?>
<h1 style="font-size: 25px">
	<?php
		echo $param;
		unset($_SESSION["param"]);
	?>
</h1>
<?php 
	if($_SESSION["operate_type"]){
		echo '<a href="" style="font-size: 25px" onclick="javascript:history.go(-2);">返回</a>';
		$_SESSION["operate_type"] = "";
	}else{
		echo '<a href="" style="font-size: 25px" onclick="javascript:history.go(-1);">返回</a>';
	}
?>
