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
$reponse = $bdd->prepare('SELECT id FROM '.$config['users_table'].' ');
$reponse->execute();
while($users = $reponse->fetch())
{
	$userlist[] = $users['id'];
}
$reponse->closeCursor(); 

if(isset($_GET['remove']))
{
	if(is_numeric($_GET['remove']))
	{
		if(in_array($_GET['remove'],$userlist))
		{
			$remove = $_GET['remove'];
			$bdd->exec("DELETE FROM ".$config['users_table']." WHERE id ='$remove'");
			
			echo "<p><font color=#FF9900>ID ".$remove." has been removed from the database</font></p>";
		}
		else echo "<p><font color=#FF9900>This ID doesn\'t exist in the Database</font></p>";
	}
	else echo "<p><font color=#FF9900>id has to be numeric</font></p>";
}


echo "<div width=100% style='border:thin #666 solid; border-radius:10px; '>";
echo "<table width='100%'><tr><td width='20%'><font color=#FF9900>ID</font></td><td><font color=#FF9900>Username</font></td><td width='20%'><font color=#FF9900>Powers</font></td><td width='5%'>Remove</td></tr>";

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
$reponse = $bdd->prepare('SELECT id,username FROM '.$config['users_table'].' ');
$reponse->execute();
while($users = $reponse->fetch())
{
	echo "<tr><td>".$users['id']."</td><td>".$users['username']."</td><td>Full</td><td><a style='color:#FF0000;' href='userlist.php?remove=".$users['id']."'>R</a></td></tr>";
}
$reponse->closeCursor();   

echo "</table>";
echo "</div>";
echo '</body>';
?>
<a 