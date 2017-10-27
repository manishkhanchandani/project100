<?php require_once('../Connections/conn.php'); ?>
<?php
mysql_select_db($database_conn, $conn);
$query_rsSiteInformation = "SELECT * FROM sites WHERE site_id = 2";
$rsSiteInformation = mysql_query($query_rsSiteInformation, $conn) or die(mysql_error());
$row_rsSiteInformation = mysql_fetch_assoc($rsSiteInformation);
$totalRows_rsSiteInformation = mysql_num_rows($rsSiteInformation);

mysql_free_result($rsSiteInformation);
?>