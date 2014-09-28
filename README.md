ECSAP-e-
========

ECSAP(e) - Easy CS Admin Panel

A fork of CS:GO Web Admin made by Reneb
https://sourceforge.net/projects/csgowebadmin/


At the moment this project is broken, switching lib and rewriting most things.

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


shortname => will be showed in the main menu
ip => 127.0.0.1, localhost can be used if you are using it on a local machine
port => 27015 (default), it is your server's connection port. 
rcon_password => the rcon password of your server

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
