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
				if(isset($info["ip"]))
                $server1 = new SourceServer($info["ip"], $info["port"]);
                $server1->initialize();
                $server1->getServerInfo();
				echo '<li><a href="index.php?serv='.$serverid.'">'.$server['serverName'].'</a></li>';
				
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