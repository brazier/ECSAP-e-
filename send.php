<?php
session_start();
if(!isset($_SESSION['username'])){
	die();
}
require __DIR__ . '\lib\steam-condenser\steam-condenser.php';
include("config.php");
error_reporting(E_NOTICE);

if(isset($_GET['getPlayers'])){
	echo '<table id="players">';
	echo '<tr>
		<th>ID</th>
		<th width="250px">Name</td>
		<th>Ping</th>
		<th>Steam id</th>
		<th>IP</th>
		<th>Actions</th>
		</tr>';

	$server = new SourceServer($config[$_GET['serv']]['ip'],$config[$_GET['serv']]['port']);
	$server->initialize();
	$players = $server->getPlayers($config[$_GET['serv']]['rcon_password']);

	foreach($players as $key => $value){
		echo '<tr>';
		echo '<td>'.$value->getrealId().'</td><td>'.$value->getName().'</td><td>'.$value->getPing().'</td><td>'.$value->getSteamId().'</td><td>'.$value->getipAddress().'</td><td>  <a href="javascript:kickPlayer('.$value->getrealId().');">[KICK]</a>   <a nohref >[BAN]</a>   <a nohref>[MSG]</a>';
		echo '</tr>';
	}
	echo '</table>';
}

if(isset($_GET['getHost'])){
	$server = new SourceServer($config[$_GET['serv']]['ip'],$config[$_GET['serv']]['port']);
	$server->initialize();
	$host = $server->getServerInfo();
	echo $host['serverName'];
}

if(isset($_GET['getMap'])){
	$server = new SourceServer($config[$_GET['serv']]['ip'],$config[$_GET['serv']]['port']);
	$server->initialize();
	$info = $server->getServerInfo();

	if(file_exists($info['mapName'])){
		$mapName = $info['mapName'];
	} else { $mapName = "error"; }

	echo $info['serverName'];
	echo '<img src="img/maps/'.$mapName.'.png" /><br />';
	echo ''.$info['numberOfPlayers'].'('.$info['botNumber'].')/'.$info['maxPlayers'].' - '.$info['mapName'];
}

	if(isset($_GET['kickPlayer'])){
		if(isset($_GET['kickReason'])){ 
			$kickReason = $_GET['kickReason'];
		} else { $kickReason = "";}

		$server = new SourceServer($config[$_GET['serv']]['ip'],$config[$_GET['serv']]['port']);
		try {
 			$server->rconAuth($config[$_GET['serv']]['rcon_password']);
 			echo $server->rconExec('ma_kick '.$_GET['kickPlayer'].' '.$kickReason);
		}
		catch(RCONNoAuthException $e) {
 			trigger_error('Could not authenticate with the game server.',
 			E_USER_ERROR);
		}
	}

	if(isset($_GET['banPlayer'])){
		if(isset($_GET['banReason'])){ 
			$banReason = $_GET['banReason'];
		} else { $banReason = "";}
		if(isset($_GET['banTime'])){ 
			$banTime = $_GET['banTime'];
		} else { $banTime = 1;}


		$server = new SourceServer($config[$_GET['serv']]['ip'],$config[$_GET['serv']]['port']);
		try {
 			 $server->rconAuth($config[$_GET['serv']]['rcon_password']);
 			 echo $server->rconExec('ban '.$_GET['kickPlayer'].' '.$banReason);
			}
			catch(RCONNoAuthException $e) {
 				trigger_error('Could not authenticate with the game server.',
 			   	E_USER_ERROR);
			}
	}
?>