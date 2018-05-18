<?php require_once('../../Connections/conn_mysite.php'); ?>
<?php
$colname_rsProfile = "-1";
if (isset($_GET['profile_id'])) {
  $colname_rsProfile = (get_magic_quotes_gpc()) ? $_GET['profile_id'] : addslashes($_GET['profile_id']);
}
mysql_select_db($database_conn_mysite, $conn_mysite);
echo $query_rsProfile = sprintf("SELECT * FROM fmr_profiles WHERE profile_id = %s", $colname_rsProfile);
$rsProfile = mysql_query($query_rsProfile, $conn_mysite) or die(mysql_error());
$row_rsProfile = mysql_fetch_assoc($rsProfile);
$totalRows_rsProfile = mysql_num_rows($rsProfile);

print_r($row_rsProfile);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<p>Profile Detail Page</p>
<p>Dashboard</p>
<p><a href="symptom.php?profile_id=<?php echo $row_rsProfile['profile_id']; ?>">Add Symptom </a> </p>
</body>
</html>
<?php
mysql_free_result($rsProfile);
?>
