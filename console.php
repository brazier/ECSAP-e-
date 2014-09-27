<?php
session_start();
if(!isset($_SESSION['username'])){
	die();
}
if(isset($_GET['server'])) $_SESSION['server'] = $_GET['server'];
session_write_close();

if(isset($_SESSION['server'])) $server = $_SESSION['server'];

include("config.php");
$say_preg = '/[0-9]{2}\/[0-9]{2}\/[0-9]{4}\W\-\W([0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}):\W\"(.*?)\<([0-9]{1,})\>\<(.*?)\>\<(.*?)\>\"\W[s][a][y]\W\"(.*)\"$/';
$kill_preg = '/([0-9]{2}\/[0-9]{2}\/[0-9]{4})\W\-\W([0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}):\W\"(.*?)\<([0-9]{1,})\>\<(.*?)\>\<(.*?)\>\".*\"(.*?)\<([0-9]{1,})\>\<(.*?)\>\<(.*?)\>\".*?\"(.*?)\"(.*)/';
$newplayer_preg = '/[L]\W([0-9]{2}\/[0-9]{2}\/[0-9]{4})\W\-\W([0-9]{2}\:[0-9]{2}\:[0-9]{2})\:\W\"(.*?)\<([0-9]{1,})\>\<([S][T][E][A][M]\_.*?)\>\<\>.*?[c][o][n][n][e][c][t].*?\"(.*?)\:.*/';
$disc_preg = '/[L]\W([0-9]{2}\/[0-9]{2}\/[0-9]{4})\W\-\W([0-9]{2}\:[0-9]{2}\:[0-9]{2})\:\W\"(.*?)\<([0-9]{1,})\>\<(.*?)\>\<[a-zA-Z0-9]{0,}\>.*?[d][i][s][c][o][n][n].*/';
$newbot_preg = '/[L]\W([0-9]{2}\/[0-9]{2}\/[0-9]{4})\W\-\W([0-9]{2}\:[0-9]{2}\:[0-9]{2})\:\W\"(.*?)\<([0-9]{1,})\>\<([B][O][T])\>\<\>.*?[c][o][n][n][e][c][t].*/';
$pi_preg = '/^\#\ {0,}([0-9]{1,})\ ([0-9]{1,})\ \"(.*?)\"\ (.*?)\ (.*?)\ (.*?)\ (.*?)\ (.*?)\ (.*?)\ (.*?)$/';
$bot_preg = '/^\#\ {0,1}([0-9]{1,})\ \"(.*?)\"\ (.*?)\ (.*?)$/';
$init_info_preg = '/[a-zA-Z]{7}\ \:\ ([0-9]{1,})\ [a-z]{6}\,\ ([0-9]{1,})\ [a-z]{4}\ \([0-9]{1,}\/([0-9]{1,})\ .*/';
$newmap_preg = '/[L]\W([0-9]{2}\/[0-9]{2}\/[0-9]{4})\W\-\W([0-9]{2}\:[0-9]{2}\:[0-9]{2})\:\ [L][o][a].*?[m][a][p]\ \"(.*?)\"/';
$kills = array();
$bot_count = 0;
$players_count = 0;
$maxplayers = 0;
$init_info = "";
$players = array();
$players_ = array();

if (ob_get_level() == 0) {
    ob_start();
}

require __DIR__ . '/SourceQuery/SourceQuery.class.php';
	define( 'SQ_SERVER_ADDR_P', $config[$server]['ip'] );
    define( 'SQ_SERVER_PORT_P', $config[$server]['port'] );
    define( 'SQ_TIMEOUT_P',     1 );
    define( 'SQ_ENGINE_P',      SourceQuery :: SOURCE );
	$RCP = new SourceQuery( );
	try
	{
		$RCP->Connect( SQ_SERVER_ADDR_P, SQ_SERVER_PORT_P, SQ_TIMEOUT_P, SQ_ENGINE_P );
		$RCP->SetRconPassword( $config[$server]['rcon_password'] );
		$status    = $RCP->Rcon("status");
	}
	
	catch( Exception $e )
	{
		$Exception = $e;
	}
	$RCP->Disconnect( );
	
	$numpl = array();
$ex = explode("\n",$status);
$map = "error";
foreach($ex as $line => $info)
{
	if(strpos($info,"map")===0)
	{
		$map = substr($info,10);
	}
	if(strpos($info,"players")===0)
	{
		if(preg_match($init_info_preg,$info,$output))
		{
			$players_count = $output[1];
			$bot_count = $output[2];
			$maxplayers = $output[3];
		}
	}
	if(strpos($info,"hostname")===0)
	{
		$hostname = substr($info,10);		
	}
}
echo "<script language='JavaScript'>\n<!--;\n\nparent.mapreload('$map','$players_count','$bot_count','$maxplayers','$hostname');\n\n//-->\n</script>";
foreach($ex as $pi => $val)
{
	if(strpos($val,"#")===0)
	{
		if(preg_match($bot_preg,$val,$output))
		{
			$players_[$output[1]] = array("id"=>$output[1],"name"=>$output[2],"steam"=>$output[3],"connection"=>$output[4],"ip"=>"none","ping"=>"0");
		}
		elseif(preg_match($pi_preg,$val,$output))
		{
			$players_[$output[1]] = array("id"=>$output[1],"name"=>$output[3],"steam"=>$output[4],"connection"=>$output[5],"ip"=>substr($output[10],0,strrpos($output[10],":")),"ping"=>$output[6]);
		}
		else ;
	}
}
foreach($players_ as $pid => $pi)
{
	$players[$pid] = $pi["id"]."=>".$pi["steam"]."=>".$pi["ip"]."=>".$pi["name"];
}
$player_list = implode('<br>',$players);
echo "<script language='JavaScript'>\n<!--;\n\nparent.playersreload('$player_list');\n\n//-->\n</script>";
echo 'Getting Server Console... '."<br />\n";

flush();
ob_flush();

$logPath = $config[$server]['console_full_path'];
$lastSize = filesize($logPath);
echo '<div class="console">';
while(1) {
	$file = fopen($logPath,'r');
    fseek($file,$lastSize,SEEK_SET);
	$tab_line = array();
	
	while(!feof($file))
	{
		$buf = fgets($file);
		if($buf === false)
			break;
		
		$tab_line[] = $buf;
	}
	
	fclose($file);
	clearstatcache();
	$lastSize = filesize($logPath);
	
	
	foreach($tab_line as $text)
	{
		
		
		if(preg_match($say_preg,$text,$output))
		{
			$class = $output[5];
			if($class == "Spectator") $color = "#FFF";
			elseif($class == "TERRORIST") $color = "#A17D1C";
			elseif($class == "CT") $color = "#4793CE";
			else $color = "616161";
			
			echo "<div class='say'><font style='font-size:9px;'>(".$output[1].")</font><font style='color:".$color.";'> ".$output[2].": ".$output[6]."</font></div><br>";
		}
		elseif(strpos($text,"map     :")===0)
		{
			$map = substr($text,10,-1);
			echo "<script language='JavaScript'>parent.mapreload('$map','$players_count','$bot_count','$maxplayers','$hostname')</script>";			
			echo htmlentities($text,ENT_NOQUOTES | ENT_HTML5)."<br />";
		}
		elseif(strpos($text,"players :")===0)
		{
			if(preg_match($init_info_preg,$text,$output))
			{
				$players[] = array();
				$players_count = $output[1];
				$bot_count = $output[2];
				$maxplayers = $output[3];
echo "<script language='JavaScript'>\n<!--;\n\nparent.mapreload('$map','$players_count','$bot_count','$maxplayers','$hostname');\n\n//-->\n</script>";				echo $text."<br />\n";
			}
		}
		elseif(preg_match($kill_preg,$text,$output))
		{
			$kills[] = $output[3]." =========> ".$output[7]." - ".$output[11];
			$kills[] = $output[12]==" (headshot)"?"YES":"NO";
			$kill_list = implode('<br>',array_reverse($kills));
			echo "<script language='JavaScript'>\n<!--;\n\nparent.livereload('$kill_list');\n\n//-->\n</script>";
			
		}
		elseif(preg_match($newplayer_preg,$text,$output))
		{
			$players[$output[4]] = $output[4]."=>".$output[5]."=>".$output[6]."=>".$output[3];
			$player_list = implode('<br>',$players);
			echo htmlentities($text,ENT_NOQUOTES | ENT_HTML5)."<br />";
			echo "<script language='JavaScript'>\n<!--;\n\nparent.playersreload('$player_list');\n\n//-->\n</script>";
		}
		elseif(preg_match($newbot_preg,$text,$output))
		{
			$players[$output[4]] = $output[4]."=>".$output[5]."=>none=>".$output[3];
			$player_list = implode('<br>',$players);
			echo htmlentities($text,ENT_NOQUOTES | ENT_HTML5)."<br />";
			echo "<script language='JavaScript'>\n<!--;\n\nparent.playersreload('$player_list');\n\n//-->\n</script>";
			
		}
		elseif(preg_match($disc_preg,$text,$output))
		{
			unset($players[$output[4]]);
			$player_list = implode('<br>',$players);
			echo htmlentities($text,ENT_NOQUOTES | ENT_HTML5)."<br />";
			echo "<script language='JavaScript'>\n<!--;\n\nparent.playersreload('$player_list');\n\n//-->\n</script>";
		}
		elseif(strpos($text,"Loading map")!==false)
		{
			if(preg_match($newmap_preg,$text,$output))
			{
				$players = array();
				$player_list = implode('<br>',$players);
				$bot_count = 0;
				$players_count = 0;
				$map = $output[3];
				echo "<script language='JavaScript'>\n<!--;\n\nparent.mapreload('$map','$players_count','$bot_count','$maxplayers','$hostname');\n\n//-->\n</script>";	
				echo "<script language='JavaScript'>\n<!--;\n\nparent.playersreload('$player_list');\n\n//-->\n</script>";
				echo htmlentities($text,ENT_NOQUOTES | ENT_HTML5)."<br />";
			}
		}
		else
			echo htmlentities($text,ENT_NOQUOTES | ENT_HTML5)."<br />";
		echo '<script>window.scrollTo(0,document.body.scrollHeight);</script>';
		
	}	
    flush();
   	ob_flush();
    sleep(1);
}
echo '</div>';
ob_end_flush();


?>
