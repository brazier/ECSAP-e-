<?php
session_start();
if(!isset($_SESSION['username'])){
	die();
}
require __DIR__ . '\lib\steam-condenser\steam-condenser.php';
include("config.php");
error_reporting(E_NOTICE);

if(isset($_GET['getPlayers']))
	{
		echo '<table id="players">';
		echo '<tr>
			<th>ID</th>
			<th width="250px">Name</td>
			<th>Ping</th>
			<th>Steam id</th>
			<th>IP</th>
		</tr>
			';
			$server = new SourceServer($config[$_GET['serv']]['ip'],$config[$_GET['serv']]['port']);
			$server->initialize();
			$players = $server->getPlayers($config[$_GET['serv']]['rcon_password']);
		foreach($players as $key => $value){
			echo '<tr>';
			echo "<td>{$value->getrealId()}</td><td>{$value->getName()}</td><td>{$value->getPing()}</td><td>{$value->getSteamId()}</td><td>{$value->getipAddress()}</td>\n";
			echo '</tr>';
			}
		echo '</table>';
	}

if(isset($_GET['getHost']))
	{

		$server = new SourceServer($config[$_GET['serv']]['ip'],$config[$_GET['serv']]['port']);
		$server->initialize();
		$host = $server->getServerInfo();
		echo $host['serverName'];
	}

if(isset($_GET['getMap']))
	{

		$server = new SourceServer($config[$_GET['serv']]['ip'],$config[$_GET['serv']]['port']);
		$server->initialize();
		$info = $server->getServerInfo();
		if(file_exists($info['mapName'])){
			$mapName = $info['mapName'];
		} else {
			$mapName = "error";
		}
		echo $info['serverName'];
		echo '<img src="img/'.$mapName.'.png" /><br />';
		echo ''.$info['numberOfPlayers'].'('.$info['botNumber'].')/'.$info['maxPlayers'];
	}
?>