<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexPana = "localhost";
$database_conexPana = "panaderia";
$username_conexPana = "root";
$password_conexPana = "";
$conexPana = mysql_pconnect($hostname_conexPana, $username_conexPana, $password_conexPana) or trigger_error(mysql_error(),E_USER_ERROR); 
?>