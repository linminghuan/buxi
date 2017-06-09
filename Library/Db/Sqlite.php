<?php

class Sqlite extends SQLite3
{
	private $table_name;
	//$db_name数据库名
	//$table_name表名
	//$dir实例化这个类的文件相对于数据库文件的路径
	function __construct($db_name,$table_name,$dir)
	{
		$this->open($dir.$db_name.".db");
		$this->table_name = $table_name;
	}

	function createTable($sql)
	{
		$res = $this->exec($sql);
		return $res;
	}

	function insert($table_name,$arr)
	{
		foreach($arr as $key => $value){
			$value = SQLite3::escapeString($value);//过滤有害字符
			$keyArr[] = "`".$key."`";//防止字段里面有关键词而导致出错的
			if(is_string($value)){
				$valueArr[] = "'".$value."'";
			}else{
				$valueArr[] = $value;
			}
		}

		$keys = implode(",",$keyArr);
		$values = implode(",",$valueArr);
		$sql = "INSERT INTO ".$table_name." (".$keys.") VALUES (".$values.");";
		$res = $this->exec($sql);
		return $res;
	}

	function findId($table_name,$id)
	{
		$sql = "SELECT * from ".$table_name." where ID=".$id;
		$res = $this->query($sql);
		return $res->fetchArray(SQLITE3_ASSOC);
	}

	function select($sql)
	{
		$res = $this->query($sql);
		if(!$res){
			return $this->lastErrorMsg();
		}else{
			$res_arr = [];
			while($temp = $res->fetchArray(SQLITE3_ASSOC) ){
				foreach ($temp as $key => $value) {
					$row_arr[$key] = $value;
				}
				$res_arr[] = $row_arr;
			}
			return $res_arr;
		}
	}

	function update($table_name,$arr,$where)
	{
		foreach($arr as $key => $value){
			$value = SQLite3::escapeString($value);//过滤有害字符
			$key = "`".$key."`";//防止字段里面有关键词而导致出错的
			if(is_string($value)){
				$value = "'".$value."'";
			}else{
				$value = $value;
			}
			$keyAndValuesArr[] = $key."=".$value;
		}
		$keyAndValues = implode(",",$keyAndValuesArr);
		$sql = "UPDATE ".$table_name." set ".$keyAndValues." where ".$where;
		$res = $this->exec($sql);
		return $res;
	}

	function delete($table_name,$where)
	{

		$sql = "DELETE from ".$table_name." where ".$where;
		$res = $this->exec($sql);
		return $res;
	}
	
	function error()
	{
		$err = $this->lastErrorMsg();
		echo $err;
	}

	static function tableExist($db,$table_name)
    {
    	//检测表格是否存在
        $strSql="SELECT COUNT(name) as Rows FROM sqlite_master WHERE type='table' and name='$table_name' ";       
        $dbResults= $db->query($strSql);
        $row = $dbResults->fetchArray();
        if ($row["Rows"]==1)
            return true;
        else
            return false;
    }

    static function dropTable($db,$table_name)
    {
    	$sql = "DROP TABLE ".$table_name;
    	$res = $db->exec($sql);
    	return $res;
    }
}