<?php 
session_start();
if(!isset($_SESSION['username'])){
	die();
}
session_write_close();
?>

<div class="menubar">
<ul id="nav">
    <li><a href="#"><font color="#FF9900">Welcome <?php echo $_SESSION['username']; ?></font></a></li>
    <li>
        <a href="#">Servers</a>
        <ul class="child">
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
        <a href="#">Members</a>
        <ul class="child">
            <li><a href="userlist.php">List</a></li>
            <li><a href="useradd.php">Add</a></li>
        </ul>
    </li>
    <li><a href="logout.php">Logout</a></li>
</ul>
</div>