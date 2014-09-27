<?php
// DON'T TOUCH //
$config = array();

// SET YOUR DATABASE INFORMATION, it's used for the login system //
$config['dbhost'] = "localhost"; // Host name 
$config['dbusername'] = ""; // Mysql username 
$config['dbpassword'] = ""; // Mysql password 
$config['dbname'] = "";
$config['users_table'] = "users";


/*
Here are the informations for each servers
leave blank like this if you don't want to use a feature: 
$config[0]['maps_path'] = "";

if you want more than 1 server to be supported
add the same informations as bellow but instead of 0 put 1 (or up)
for ex:
$config[0]['shortname'] = "War3";
$config[0]['name'] = "RS War3 Source Mod";
$config[0]['ip'] = "5.135.150.82";
$config[0]['port'] = "27010";
$config[0]['rcon_password'] = "RCONPASS1";
$config[0]['maps_path'] = "/home/steam/serverfiles/csgo/maps";
$config[0]['console_full_path'] = "/home/steam/serverfiles/csgo/console.log";

$config[1]['shortname'] = "Gun Game";
$config[1]['name'] = "RS Gun Game";
$config[1]['ip'] = "5.135.150.82";
$config[1]['port'] = "27015";
$config[1]['rcon_password'] = "RCONPASS2";
$config[1]['maps_path'] = "/home/steam/serverfiles/csgo2/maps";
$config[1]['console_full_path'] = "/home/steam/serverfiles/csgo2/console.log";

*/

$config[0]['shortname'] = "War3";
$config[0]['name'] = "RS War3 Source Mod";
$config[0]['ip'] = "5.135.150.82";
$config[0]['port'] = "27010";
$config[0]['rcon_password'] = "RCONPASS1";
$config[0]['maps_path'] = "/home/steam/serverfiles/csgo/maps";
$config[0]['console_full_path'] = "/home/steam/serverfiles/csgo/console.log";

?>