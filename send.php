<?php
session_start();
if(!isset($_SESSION['username'])){
	die();
}
if(isset($_GET['server'])) $_SESSION['server'] = $_GET['server'];
session_write_close();

if(isset($_SESSION['server'])) $server = $_SESSION['server'];
//$user = $_GET['username'];
$cmd = $_GET['cmd'];
if(($cmd == "") OR (strpos($cmd,"exec")!==false)) die();
require __DIR__ . '/SourceQuery/SourceQuery.class.php';
	define( 'SQ_SERVER_ADDR', $config[$server]['ip'] );
        define( 'SQ_SERVER_PORT', $config[$server]['port'] );
        define( 'SQ_TIMEOUT',     1 );
        define( 'SQ_ENGINE',      SourceQuery :: SOURCE );
	$RCP = new SourceQuery( );
	try
	{
		$RCP->Connect( SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_TIMEOUT, SQ_ENGINE );
		$RCP->SetRconPassword( $config[$server]['rcon_password'] );
		$Return = $RCP->Rcon( $cmd );
	}
	
	catch( Exception $e )
	{
		$Exception = $e;
	}
	$RCP->Disconnect( );
	//echo $Return;

?>