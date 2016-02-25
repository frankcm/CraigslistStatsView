<?
include "db.php";

$get=escape($_GET);
$server=escape($_SERVER);
$cookie=escape($_COOKIE);

if($get["rowid"]){//the image redirects to itself, and then we just time how long they're on the page
	$seconds=1;
	while(true){
		query("update views set timeonpage=timeonpage+1 where id='$get[rowid]'");//not precicely one second, oh well
		sleep(1);
	}
	exit;
}

//see if we can figure out the title of the posted ad without being told
$sql="select posturl from tracks where token='$get[token]'";
$posturl=getField($sql);
if( (!$posturl) && $server["HTTP_REFERER"]){
	$title=file_get_contents($_SERVER["HTTP_REFERER"]);
	$title=preg_replace('/^[\s\S]*postingTitle\s*=\s*"(.*?)(?!<")"[\s\S]*$/','$1',$title);
	if(!$title)$title="nothing";
	$title=mysql_escape_string($title);
	$sql="update tracks set posturl='$server[HTTP_REFERER]',title='$title' where token='$get[token]'";
	query($sql);
}
$sql="insert into views(token,referer,browser,ip,date,cookie) values('$get[token]','$server[HTTP_REFERER]','$server[HTTP_USER_AGENT]','$server[REMOTE_ADDR]',now(),'$cookie[viewid]')";
query($sql);
$rowid=mysql_insert_id();
if(!$_COOKIE["viewid"]){
	header("Set-Cookie: viewid=$rowid; expires=".date('r',time()+60*60*24*360));
	query("update views set cookie='$rowid' where id='$rowid'");
}


header("Cache-Control: no-cache");
//header("Content-Type: image/jpeg");
//fool craiglist maybe
header("Location: track.php?rowid=$rowid&time=".microtime(true));
?>
