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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO religions_view (user_id, religion_id, view_description, category_id) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['religion_id'], "int"),
                       GetSQLValueString($_POST['view_description'], "text"),
                       GetSQLValueString($_POST['category_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Views</title>
<style type="text/css">

</style>
</head>

<body>
<h1>Create Views </h1>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Your Views:</td>
      <td><textarea name="view_description" cols="50" rows="5"></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Category ID:</td>
      <td><select name="category_id">
        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>General</option>
        <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>Economy</option>
        <option value="3" <?php if (!(strcmp(3, ""))) {echo "SELECTED";} ?>>Jobs</option>
        <option value="4" <?php if (!(strcmp(4, ""))) {echo "SELECTED";} ?>>Education</option>
        <option value="5" <?php if (!(strcmp(5, ""))) {echo "SELECTED";} ?>>Environment</option>
        <option value="6" <?php if (!(strcmp(6, ""))) {echo "SELECTED";} ?>>Health</option>
        <option value="7" <?php if (!(strcmp(7, ""))) {echo "SELECTED";} ?>>Justice & Equality</option>
        <option value="8" <?php if (!(strcmp(8, ""))) {echo "SELECTED";} ?>>National Security</option>
        <option value="9" <?php if (!(strcmp(9, ""))) {echo "SELECTED";} ?>>God</option>
        <option value="10" <?php if (!(strcmp(10, ""))) {echo "SELECTED";} ?>>Humanity</option>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="user_id" value="<?php echo $_SESSION['MM_UserId']; ?>">
  <input type="hidden" name="religion_id" value="<?php echo $_GET['religion_id']; ?>">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>