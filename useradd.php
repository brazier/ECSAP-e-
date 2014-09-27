<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php");
}
session_write_close();
include("config.php");
include('menu.php');
include("common.php");
$userlist = array();
echo '<body style="margin-top:60px;">';
try
{
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO("mysql:host=".$config['dbhost'].";dbname=".$config['dbname'],$config['dbusername'],$config['dbpassword'], $pdo_options);
}
catch (Exception $e)
{
	die('Error : ' . $e->getMessage());
	return false;
}	
$reponse = $bdd->prepare('SELECT username FROM '.$config['users_table'].' ');
$reponse->execute();
while($users = $reponse->fetch())
{
	$userlist[] = $users['username'];
}
$reponse->closeCursor();   

if(isset($_POST['newuser']) AND isset($_POST['newpass']))
{
	if((strlen($_POST['newuser'])>2) AND (strlen($_POST['newpass'])>2))
	{
		if(!in_array($_POST['newuser'],$userlist))
		{
			$newuser = stripslashes($_POST['newuser']);
			$newpass = md5(stripslashes($_POST['newpass']));
			 $bdd->exec("INSERT INTO ".$config['users_table']."(username,password,powers)	
				   VALUES('$newuser','$newpass','Full')");
			echo "<p><font color=#FF9900>".$newuser." has been added in the database</font></p>";
		}
		else echo "<p><font color=#FF9900>This User already exists in the Database</font></p>";
	}
	else echo "<p><font color=#FF9900>Username AND password need to be 3 or more chars</font></p>";
}



echo "<div width=100% style='border:thin #666 solid; border-radius:10px; '>";
echo "<table width='100%'><tr><form name='useradd' method='post' action='useradd.php'><td width='30%'><font color=#FF9900>Name</font></td><td width='30%'><font color=#FF9900>Password</font></td><td width='20%'><font color=#FF9900>Powers</font></td><td></td></tr><tr>";
echo '<td><input name="newuser" type="text" id="newuser"></td>';
echo '<td><input name="newpass" type="text" id="newpass"></td>';
echo '<td>Full</td>';
echo '<td><input type="submit" name="Submit" value="add"></td>';
echo "</form></tr>";
echo "</table>";
echo "</div>";
echo '</body>';
?>