<?php 
session_start();

header ("LOCATION:login.php");
setcookie ('user_name','',time() - 3600);
setcookie ('password','',time() - 3600);
setcookie ('id','',time() - 3600);
session_destroy();
?>
