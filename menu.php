<?php 
session_start();
if(!isset($_SESSION['username'])){
	die();
}
session_write_close();
include('common.php');
include('config.php');
?>

<style type="text/css">
.menubar
{
	width:100%;
    height:50px;
    display:block;
	background-color:#000;
    position:fixed;
    top:0;
    left:0;
}
#nav li {
    list-style:none;
    float: left;
    position: relative;
}
#nav li a {
    display: block;
    padding: 8px 12px;
	
    text-decoration: none;
}
#nav li a:hover {

    background-color:#000;
    color:#FFF;
    opacity:1;
}

/* Targeting the first level menu */
#nav {  
    top:0;
	left:0;
    width:100%;
    background-color:#000;
    display: block;
    height: 34px;
    position: fixed;
}
#nav > li > a {
}

/* Targeting the second level menu */
#nav li ul {
    color: #333;
    display: none;
    position: absolute; 
	
    width:150px;
}
#nav li ul li {
    display: inline;
	float:none;
	position:relative
}
#nav li ul li a {
    background: #000;
    border: none;
    line-height: 34px;
    margin: 0;
    padding: 0 8px 0 10px;
}
#nav li ul li a:hover {
    color:#FFF;
    opacity:1;
}

/* Third level menu */
#nav li ul li ul{
    top: 0;
}
ul.child {
background-color:#000;  
}
/* A class of current will be added via jQuery */
#nav li.current > a {
    background: #000;
    float:left;
}
/* CSS fallback */
#nav li:hover > ul.child {
    left:0;
    top:34px;
    display:inline;
    position:absolute;
    text-align:left;
}
#nav li:hover > ul.grandchild  {
    display:block;
}    
</style>
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