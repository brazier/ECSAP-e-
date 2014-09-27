<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php");
}
if(isset($_GET['server'])) $_SESSION['server'] = $_GET['server'];
session_write_close();
include("config.php");
include('menu.php');
include("common.php");


if(isset($_SESSION['server'])) $server = $_SESSION['server'];

$user = $_SESSION['username'];
echo <<<EOF
<html>
<head>
<title>CS:GO Remote Control Panel</title>
$css
<script type="text/javascript">
  function resizeIframe(iframe) {
    iframe.height = iframe.contentWindow.document.body.scrollHeight + "px";
  }
</script> 
<script language="JavaScript"><!--;
EOF;
echo <<<EOF
user = "$user";
EOF;

?>

var namelist;
commandHist = new Array();
commandNr = 0;
function refresh() {
	self.passcmnd.location = "send.php?cmd=status";
}
function send() {
    var cmd = document.input.command.value;
    var a = commandHist.unshift(cmd);
//	alert(cmd);
    if (a > 20) {
	commandHist.pop();
    }
    commandNr = 0;
    cmd = escape(cmd);
    self.passcmnd.location = "send.php?cmd="+cmd;
    document.input.command.value=""; // empty
}
function playersreload(names) {
	window.namelist = names;
    self.players.location = "players.php?list="+window.namelist;
}
function mapreload(map,numplayers,numbots,maxplayers,hostname) {
	window.currentmap = map;
	window.currentplayers = numplayers;
	window.currentbots = numbots;
	window.maxplayers = maxplayers;
	window.hostname = hostname;
    self.map.location = "map.php?map="+window.currentmap+"&pl="+window.currentplayers+"&bot="+window.currentbots+"&max="+window.maxplayers+"&host="+window.hostname;
}
function livereload(live) {
    self.live.location = "live.php?list="+live;
}
function displayCommand(relElem) {
    commandNr += relElem;
    if (commandNr < 0) { commandNr = commandHist.length-1; }
    if (commandNr >= commandHist.length) { commandNr = 0; }
    document.input.command.value = commandHist[commandNr];
}
function popup_cmd(type) {
    var a;
    var act = "";
	
    if (type == 1) { 

    	s=prompt("Dont put any special characters!!!","");
       	c=escape(s);
        document.input.command.value = "say "+c;
    }
    if (type == 2) {
    	alert("Use the PlayerList to use this command");
    }
	if (type == 3) {
        document.input.command.value = "mp_restartround 1 ";
    }
	if (type == 4) {
		var e = document.getElementById("changelevel");
		var strUser = e.options[e.selectedIndex].value;
		if (strUser != "changelevel") {
		document.input.command.value = "changelevel "+strUser;
		}
	}
	if (type == 5) {
        document.input.command.value = "changelevel ";
    }

}
function playercmd(type,value) {
    var a;
    var act = "";
	if (value > 0) {
		if (type == 1) { 
			window.kickid = value;
			self.passcmnd.location = "send.php?cmd=kickid%20"+window.kickid;
		}
		if (type == 2) {
			window.banid = value;
			self.passcmnd.location = "send.php?cmd=banid%20"+window.banid;
		}
	}

}
</script>
</head>
<body style="margin-top:50px;">
<table width="100%" height="100%" border="0" style="margin:5px;">
<tr height="100%" valign="top">
<td width="70%">
<div class="leftside">
<br>
  <?php echo $config[$server]['name']." - ".$config[$server]['ip'].":".$config[$server]['port']; ?> <a href="#" onClick="refresh();">Refresh</a>
  <br><br>
  <div class="playersiframe">
   <iframe onload="resizeIframe(this)" frameborder="0" scrolling="no" height="auto" width="100%" name="players" src="players.php" valign="top" marginwidth="0" marginheight="0" style='border:thin #666 solid; border-radius:10px'>Sorry your browser doesn't support this :S</iframe>
   </div><br><br>
   <div class="consoleiframe">
   <iframe frameborder="0" scrolling="yes" height="300px" width="100%" name="out" src="console.php" valign="top" marginwidth="0" marginheight="0" style='border:thin #666 solid; border-top-left-radius:10px; border-top-right-radius:10px;'>Sorry your browser doesn't support this :S</iframe>
   <div class="commands">
   <form name="input" onSubmit="send();return false;" style="margin:0pt; padding:0pt;">
	    <input type="text" name="command"  style="width:98%; margin-left:5px;"><input type="button" value="Send" onClick="send()">
	    <iframe frameborder="0" height="5" width="5" src="send.php" name="passcmnd" marginwidth="0" marginheight="0"></iframe>
	    <input type="button" value="<" onClick="displayCommand(1)" style="width: 10pt; height: 16pt;">
	    <input type="button" value=">" onClick="displayCommand(-1)" style="width: 10pt; height: 16pt;">
	    </form>
        <br>
        <table width="100%" style="font-size:10px;">
        <tr><td><input type="button" value="say" onClick="popup_cmd(1)"></td><td>Sends a message to online players</td></tr>
        <tr><td><input type="button" value="kick" onClick="popup_cmd(2)"></td><td>kick an online player</td></tr>
        <tr><td><input type="button" value="ban" onClick="popup_cmd(2)"></td><td>ban an online player</td></tr>
        <tr><td><input type="button" value="mp_restartgame" onClick="popup_cmd(3)"></td><td>restarts the map</td></tr>
        <tr><td><?php ServerChangeMap(); ?></td><td>changes map</td></tr>
        </table>
        </div>
    </div>
</div>
</td>
<td width="30%">
<div class="rightside">
  <iframe onload="resizeIframe(this)" scrolling="no" frameborder="0" height="auto" width="100%" name="map" src="map.php" valign="top" marginwidth="0" marginheight="0" style='border:thin #666 solid; border-radius:10px;'>Sorry your browser doesn't support this :S</iframe><br><br>
  <iframe frameborder="0" height="400px" width="100%"  name="live" src="live.php" valign="bottom" marginwidth="0" marginheight="0" style='border:thin #666 solid; border-radius:10px;'>Sorry your browser doesn't support this :S</iframe>
</div>
</td>
</tr>
</table>
</body>




</html>
<?php
function ServerChangeMap()
{
	$maplist = GetMapList();
	if(count($maplist)==0) echo '<input type="button" value="changelevel" onClick="popup_cmd(5)">';
	else
	{
		echo '<select name="changelevel" id="changelevel" onClick="popup_cmd(4)">';
		echo '<option value="changelevel">changelevel</option>';
		foreach($maplist as $mi => $map)
		{
			echo '<option value="'.$map.'">'.$map.'</option>';
		}
		echo '</select>';
	}
	
}
function GetMapList()
{
	global $config,$server;
	$rawdata = shell_exec("find ".$config[$server]['maps_path']." -name '*.bsp'");
//echo var_dump($rawdata);
	$exdata = explode("\n",$rawdata);
	$maplist = array();
	foreach($exdata as $ei => $rawmap)
	{
		if(preg_match("/.*\/(.*?)\.[b][s][p]/",$rawmap,$map))
			$maplist[$ei] = $map[1];
		else ;
	}
	return $maplist;
}
			?>