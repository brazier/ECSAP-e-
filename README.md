ECSAP-e-
========

ECSAP(e) - Easy CS Admin Panel

A fork of CS:GO Web Admin made by Reneb
https://sourceforge.net/projects/csgowebadmin/

REQUIREMENTS:
- PHP5
- MySQL
- Active CS:GO Server

INSTALLATION:

1) Database
Import users.sql into your database.
Not doing that will make the script unusable, unless you delete the top part of all the files that are used to PROTECT the files!!
So it's important that you use the database

2) Files
Import the entire csgo file onto your website example:
http://roguesoldiers.eu/csgo/ (this is link doesn't really exist ...)
( on linux it would be somewhere like: /var/www/csgo )

CONFIGURATION
Only file to configurate is config.php

Here are examples of what should be in config.php:

<?php
$config[0]['shortname'] = "War3";
$config[0]['name'] = "RS War3 Source Mod";
$config[0]['ip'] = "5.135.150.82";
$config[0]['port'] = "27010";
$config[0]['rcon_password'] = "RCONPASS1";
$config[0]['maps_path'] = "/home/steam/serverfiles/csgo/maps";

$config[1]['shortname'] = "Gun Game";
$config[1]['name'] = "RS Gun Game";
$config[1]['ip'] = "5.135.150.82";
$config[1]['port'] = "27015";
$config[1]['rcon_password'] = "RCONPASS2";
$config[1]['maps_path'] = "/home/steam/serverfiles/csgo2/maps";
?>

shortname => will be showed in the main menu
name => will be the main name of your server on the RCP
ip => 127.0.0.1, localhost can be used if you are using it on a local machine
port => 27015 (default), it is your server's connection port. 
rcon_password => the rcon password of your server
maps_path => the full path to access the server's maps, this feature can only be working if you are launching the website from the same machine your servers are. leave it empty if you don't or can't use it.

ADDING USERS

All users have the same powers, it is a very simple login system, made just to protect your files.
Initial Login is: Admin
and Password: password
Add a new user before deleting this user.
(members -> add)

MAPS

supports workshop maps also
if you want to add a new image minimap
add it in csgo/maps/
with NAMEOFMAP.png
example: de_rats_1337.png

For any other help

Contact me on sourceforge or http://roguesoldiers.eu
