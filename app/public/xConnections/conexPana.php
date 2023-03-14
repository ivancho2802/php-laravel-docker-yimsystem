<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexPana = "ec2-107-20-155-148.compute-1.amazonaws.com:5432";
$database_conexPana = "delcqdglr7h1b8";
$username_conexPana = "kjogxhvdvnkumx";
$password_conexPana = "b42f2b9f3dda672e63925904f1450b38698f03289409be8008efd07f526c20a9";
$conexPana = mysql_pconnect($hostname_conexPana, $username_conexPana, $password_conexPana) or trigger_error(pg_last_error(),E_USER_ERROR); 
?>