<?php	


function connect(){
	global $conn;
	//this is my actual user/pass, but it can only connect from localhost, 
	//and only has access to this one database
	list($host,$user,$pwd,$db)=array("localhost","clist","jLR6xDVZvdTGVE2z","clist");
	if(!$conn=mysql_connect($host,$user,$pwd))
		throw new Exception("Unable to connect to DB: " . mysql_error());
	if (!mysql_select_db($db))//webphotomastercom_ecom
		throw new Exception("Unable to select closedu1_cua: " . mysql_error());
}
function query($query){
	$connect_result = mysql_query($query);
	if (!$connect_result){
		echo "Bad query " . $query . "<br/>\r\n" .mysql_error()."<br/>";
		mysql_query("rollback");
		echo mysql_error();
	}
	return $connect_result;
}
function getRow($query){
	$res=query($query);
	if(mysql_num_rows($res)<1){
		//trigger_error("No Rows Returned in ".$query,2);
		return null;
	}
	return mysql_fetch_assoc($res);
}
function getField($query){
	$res=query($query);
	if(mysql_num_rows($res)<1){
		//trigger_error("No Rows Returned in ".$query,2);
		return null;
	}
	$res=mysql_fetch_array($res);
	return $res[0];
}
function escape($str){
	global $conn;
	if(is_array($str))
		foreach($str as $key=>$val)
			$str[$key]=escape($val);
	else
		$str=mysql_real_escape_string($str,$conn);
	return $str;
}
function htmlEscape($str){
	if(is_array($str))
		foreach($str as $key=>$val)
			$str[$key]=htmlEscape($val);
	else
		$str=htmlspecialchars($str,ENT_QUOTES);
	return $str;
}
$conn;
connect();
//echo "conn=$conn,<br/>stat=".mysql_stat()."<br/>";
?>
