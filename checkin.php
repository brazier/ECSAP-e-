<?php
include('config.php');
$host=$config['dbhost']; // Host name 
$username=$config['dbusername']; // Mysql username 
$password=$config['dbpassword']; // Mysql password 
$db_name=$config['dbname']; // Database name 
$tbl_name=$config['users_table']; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// Define $myusername and $mypassword 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword']; 

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = md5(mysql_real_escape_string($mypassword));
$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){
	session_start();
	$_SESSION['username'] = $myusername;
// Register $myusername, $mypassword and redirect to file "login_success.php"
header("Location: success.php");
}
else {
	unset($_SESSION);
	echo "Wrong Username or Password";
}
?>