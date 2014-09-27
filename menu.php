<?php 
session_start();
if(!isset($_SESSION['username'])){
	die();
}
session_write_close();
?>

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