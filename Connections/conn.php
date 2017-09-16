<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conn = "remote-mysql4.servage.net";
$database_conn = "alaw";
$username_conn = "alaw";
$password_conn = "manishkk74";
$conn = mysql_connect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>