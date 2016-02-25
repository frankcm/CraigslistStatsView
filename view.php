<?
include "db.php";
$get=escape($_GET);
$sql="select max(`date`) maxdate,min(`date`) mindate,ip,browser,referer,avg(timeonpage) avgtimeonpage,count(1) `numvisits`,cookie from views where token='$get[token]' group by cookie having cookie!=0 order by `date` desc";

$res=query($sql);
if(mysql_num_rows($res)){
	$row=getRow("select posturl,title from tracks where token='$get[token]' ");
	echo "<Center><p><a href='$row[posturl]'>$row[title]</a><br/>Real Time stats<br/></p>";
	
	echo "<table border='1' cellspacing=0 cellpadding=5 ><tr><Td>First Visit</td><td>Last Visit</td></td><td>Hits</td><td>Average time<br/>Spent</td><td>UID</td><td>IP</td><td>Browser</td></tr>";
	while($row=mysql_fetch_array($res)){
		list($maxdate,$mindate,$ip,$browser,$referer,$avgtimeonpage,$numvisits,$cookie)=$row;
		$mindate=date('g:ia n/d',strtotime($mindate));
		$maxdate=date('g:ia n/d',strtotime($maxdate));
		
		echo "<tr><td>$mindate</td><Td>$maxdate</td><td>$numvisits</td><td>$avgtimeonpage</td><td>$cookie</td><td>$ip</td><td>$referer</td><td>$browser</td></tr>";
	}
	echo "</table>";
	echo "</center>";
}
else{
	echo "<center><Font color='red' >Sorry, no hits yet.  Give it a little time.</font></center>";
}
?>