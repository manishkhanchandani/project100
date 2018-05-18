<?php require_once('../../Connections/conn_mysite.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO fmr_symptoms (profile_id, symptom, modalities, symptom_date) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['profile_id'], "int"),
                       GetSQLValueString($_POST['symptom'], "text"),
                       GetSQLValueString($_POST['modalities'], "text"),
                       GetSQLValueString($_POST['symptom_date'], "date"));

  mysql_select_db($database_conn_mysite, $conn_mysite);
  $Result1 = mysql_query($insertSQL, $conn_mysite) or die(mysql_error());
}

$colname_rsProfile = "-1";
if (isset($_GET['profile_id'])) {
  $colname_rsProfile = (get_magic_quotes_gpc()) ? $_GET['profile_id'] : addslashes($_GET['profile_id']);
}
mysql_select_db($database_conn_mysite, $conn_mysite);
$query_rsProfile = sprintf("SELECT * FROM fmr_profiles WHERE profile_id = %s", $colname_rsProfile);
$rsProfile = mysql_query($query_rsProfile, $conn_mysite) or die(mysql_error());
$row_rsProfile = mysql_fetch_assoc($rsProfile);
$totalRows_rsProfile = mysql_num_rows($rsProfile);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<h1>Symptoms of <?php echo $row_rsProfile['first_name']; ?></h1>
<h3>Add New Symptoms</h3>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table>
            <tr valign="baseline">
                <td nowrap align="right">Symptom:</td>
                <td><input type="text" name="symptom" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
                <td nowrap align="right">Modalities:</td>
                <td>&nbsp;</td>
            </tr>
            <tr valign="baseline">
                <td nowrap align="right">Symptom Date:</td>
                <td><input type="text" name="symptom_date" size="32" value="<?php echo date('Y-m-d H:i:s'); ?>"></td>
            </tr>
            <tr valign="baseline">
                <td nowrap align="right">&nbsp;</td>
                <td><input type="submit" value="Insert record"></td>
            </tr>
        </table>
        <input type="hidden" name="profile_id" value="<?php echo $row_rsProfile['profile_id']; ?>">
        <input type="hidden" name="modalities" value="">
        <input type="hidden" name="MM_insert" value="form1">
    </form>
    <p>&nbsp;</p>
    <p>View All Symptoms  </p>
</body>
</html>
<?php
mysql_free_result($rsProfile);
?>
