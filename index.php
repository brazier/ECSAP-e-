<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php");
}
if(isset($_GET['server'])) $_SESSION['server'] = $_GET['server'];
session_write_close();
require __DIR__ . '\lib\steam-condenser\steam-condenser.php';
include("config.php");


if(isset($_SESSION['server'])) $server = $_SESSION['server'];

$user = $_SESSION['username'];



?>


<html>
	<head>
		<title>ECSAP(e)</title>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<link rel="stylesheet" type="text/css" href="style/menu.css">

		<script src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.2.0/prototype.js"></script>

	</head>
	<body>
		<div class="menubar">
			<ul id="nav">
			    <li>
			        <a href="#">Servers</a>
			        <ul>
			        <?php
						foreach($config as $serverid => $info)
						{
							if(isset($info["shortname"]))
							echo '<li><a href="index.php?server='.$serverid.'">'.$info['shortname'].'</a></li>';
				
						}
					?>
			        </ul>
			    </li>
			    <li>
			        <a href="#">Users</a>
			        <ul>
			            <li><a href="userlist.php">List</a></li>
			            <li><a href="useradd.php">Add</a></li>
			        </ul>
			    </li>
			    <li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
		<div id="msg"></div>
		<div id="left">
			<div id="hostName"></div>
			<div id="players"></div>
			    <textarea disabled></textarea>
			    <input type="text" name="command"><input type="submit" value="Submit">
		</div>
		<div id="right">
			<div id="map"></div>
		</div>
<script>new Ajax.PeriodicalUpdater('players', '/send.php?getPlayers=1&serv=<?PHP echo $_GET['server']; ?>', {
  method: 'get',
  insertion: Element.update,
  frequency: 10,
  decay: 2
});

</script>
<script>new Ajax.Updater('hostName', '/send.php?getHost=1&serv=<?PHP echo $_GET['server']; ?>', { method: 'get' });</script>
<script>new Ajax.Updater('map', '/send.php?getMap=1&serv=<?PHP echo $_GET['server']; ?>', { method: 'get' });</script>
<script>var dgram = require('dgram'),
    server = dgram.createSocket('udp4');

server.on('message', function (message, rinfo) {
var msg = message.toString('ascii').slice(5,-1);    
console.log(msg);
    });
server.on('listening', function () {
    var address = server.address();
    console.log('UDP Server listening ' + address.address + ':' + address.port);
});

server.bind(8006); 
</script>
<script> function kickPlayer(user){
	new Ajax.Updater('msg', '/send.php?kickPlayer='+user+'&serv=<?PHP echo $_GET['server']; ?>', { method: 'get' })
}
</script>
	</body>
</html>
