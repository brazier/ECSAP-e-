<?php
include("common.php");

$list = $_GET['list'];

?>
<div class="live">
<table class="live" height="100%">
<tr height="100%"><td class="livebody" height="100%">

<?php
$list_ = explode("<br>",$list);
foreach($list_ as $lid => $k)
{
	if(strpos($k,"=========>")!==false)
	{
	$posB = strrpos($k,"-");
	$weapon = substr($k,$posB+2);
	$k_ = explode("=========>",$k);
	$player1 = $k_[0];
	//echo $k_[0].'////'.$k_[1].'<br>';
	$player2 = substr($k_[1],0,strrpos($k_[1],"-"));
	$hs = "";
	if($list_[$lid+1]=="YES") $hs = '<img height="30px" src="img/headshot.png">';
	echo '<div style="vertical-align:middle; align="left"">'.$player1.' <img height="30px" src="img/'.$weapon.'.png"> '.$player2.' '.$hs.'</div>';
	}
}

 ?>














</td></tr></table></div>