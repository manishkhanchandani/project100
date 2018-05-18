<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conn_mysite = "localhost";
$database_conn_mysite = "mysite";
$username_conn_mysite = "root";
$password_conn_mysite = "";
$conn_mysite = mysql_connect($hostname_conn_mysite, $username_conn_mysite, $password_conn_mysite) or trigger_error(mysql_error(),E_USER_ERROR); 
?>