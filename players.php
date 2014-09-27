<?php include("common.php"); 
?>

<div class="playerlist">
<table class="playerlist" height="100%" cellpadding="1" cellspacing="1">
<tr height="100%"><td class="playerlistbody" height="100%">
<?php

$list = $_GET['list'];
$list_ = explode("<br>",$list);
//var_dump($list_);

//$user = $_GET['username'];

$cmd = $_GET['cmd'];

if($list==NULL)
{
	echo 'No Players Online';
}
else
{
	
	//echo '<nav><ul>';
	echo "<table><tr><td width='5%'>ID</td><td width='30%'>Name</td><td width='5%'>Ping</td><td width='20%'>Steam</td><td width='20%'>IP</td><td width='20%'>Actions</td></tr>";
	foreach($list_ as $Pid => $Player)
	{
		$pex = explode("=>",$Player);

			echo "<tr><td>".$pex[0]."</td><td><a href='#'>".$pex[3]."</a></td><td></td><td>".$pex[1]."</td><td>".$pex[2]."</td><td><button onClick='parent.playercmd(1,".$pex[0].")' class='action'>Kick</button><button class='action'>Ban</button></td></tr>";	
        
	}
	//echo '</ul></nav>';
	echo "</table>";
}
	

?></td></tr></table></div>