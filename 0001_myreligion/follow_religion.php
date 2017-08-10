<?php require_once('../Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../users/login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


$colname_rsReligion = "-1";
if (isset($_GET['religion_id'])) {
  $colname_rsReligion = (get_magic_quotes_gpc()) ? $_GET['religion_id'] : addslashes($_GET['religion_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsReligion = sprintf("SELECT * FROM religions WHERE religion_id = %s", $colname_rsReligion);
$rsReligion = mysql_query($query_rsReligion, $conn) or die(mysql_error());
$row_rsReligion = mysql_fetch_assoc($rsReligion);
$totalRows_rsReligion = mysql_num_rows($rsReligion);

if (!empty($_GET["religion_id"])) {
	$sql = sprintf("SELECT * FROM religions_follower WHERE religion_id = %s AND follower_user_id = %s",
                       GetSQLValueString($_GET['religion_id'], "int"),
                       GetSQLValueString($_SESSION['MM_UserId'], "int"));
	
	$rs = mysql_query($sql, $conn) or die(mysql_error());
	$numberOfRows = mysql_num_rows($rs);
	
	if ($numberOfRows == 0) {
  $insertSQL = sprintf("INSERT INTO religions_follower (religion_id, follower_user_id, follower_date) VALUES (%s, %s, %s)",
                       GetSQLValueString($_GET['religion_id'], "int"),
                       GetSQLValueString($_SESSION['MM_UserId'], "int"),
                       GetSQLValueString(date('Y-m-d H:i:s'), "date"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  
  }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>display</title>

</head>

<body>
<h1>Confirmation</h1>
<p>You are successfully following the &quot;<?php echo $row_rsReligion['religion_name']; ?>&quot; </p>
</body>
</html>
<?php
mysql_free_result($rsReligion);
?>