<?
header("Cache-Control: no-cache");

include "db.php";

$get=escape($_GET);
$server=escape($_SERVER);

?>
<title>How many people viewed my craigslist add</title>
<style type='text/css'>
*{font-family:georgia;}
p,center{width:500px;margin:20px auto;font-family:georgia;color:#666;}
textarea{width:100%;}
h1{margin-top:5px;text-align:center;height:50px;line-height:50px;vertical-align:middle;background-color:#DEDEDE}
h2{margin-bottom:5px;height:10px;background-color:rgba(200,64,1,0.6);}


</style>
<h2></h2>
<h1>CraigsList Analytics?</h1>
<p>
	This is a free service that allows users to track how many people are clicking their craigslist ads.  
	The view count, the time spent on the page, the repeat views, etc...
	</p>
<?
session_start();

//if someone is here without a token, or they share someone elses, get them a new one,
//they have to be unique
if(!$_GET["token"] || getField("select 'x' from tracks where token='$get[token]'")){
	session_regenerate_id();
	header("Location: ?token=".session_id());
	exit;
}
//if we're here we're fresh
$sql="insert into tracks(token,ip,browser,date) values('$get[token]','$server[REMOTE_ADDR]','$server[HTTP_USER_AGENT]',now());";
query($sql);
	?>
<p>
	Copy and paste what's below into your craigslist ad.
	</p>
	<center>
		<textarea onmouseup="this.select();"><?=htmlspecialchars("<img src='http://code.tagput.com/clist/track.php?token=$get[token]' width=0 height=0 />")?></textarea>
	</center>
	<p>
	Than use this link (already live and activated).. <br/>
	<a style='white-space:nowrap;' href="/clist/view.php?token=<?=$get['token']?>">http://code.tagput.com/clist/view.php?token=<?=$get['token']?></a>
	<br/>to view the statistics in real time.<Br/>
</p>
<p>If you need to track multiple ads, just reload this page for fresh code</p>
