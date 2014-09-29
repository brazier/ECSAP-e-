ECSAP-e-
========

ECSAP(e) - Easy CS Admin Panel

*A fork of CS:GO Web Admin made by Reneb
https://sourceforge.net/projects/csgowebadmin/*

~~At the moment this project is broken, switching lib and rewriting most things.~~
At the moment this program has very limited abilities.
-list/add/remove users of the panel, all with the same powers
-add multiple servers through config.php
-view hostname and map being played.
-view players in game, and certain info about them(id, steam_id, ip, ping)
-kick said players.



**Todo list(very near future)**
* Add the option to ban.
* Add the option to add reason when kicking/banning.
* Fetch available maps from server, and the ability to switch/restart map.

**(in the future)**
* Add different levels of users.
* Recieve console.
* Chat.
* Better security/login


**REQUIREMENTS:**
- PHP5
- MySQL
- Active CS:GO Server

**INSTALLATION:**

1) Database
Import users.sql into your database. Set database info in config.php

2) Files
Put all files inside the root of your webserver.

**CONFIGURATION**
Only file to configure is config.php, Add your servers here.

```
shortname => will be showed in the main menu
ip => 127.0.0.1, localhost can be used if you are using it on a local machine
port => 27015 (default), it is your server's connection port. 
rcon_password => the rcon password of your server
```
**ADDING USERS**

All users have the same powers, it is a very simple login system.
Initial login is: Admin
and Password: password
Add a new user before deleting this user.
(members -> add)

**MAPS**

Add images of maps you want shown in the preview to /img/maps/
