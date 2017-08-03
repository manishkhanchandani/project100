<?php require_once('../../Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";

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
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../users/restrict.php";
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
$currentPage = $_SERVER["PHP_SELF"];

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

if ((isset($_GET['delete_id'])) && ($_GET['delete_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM religions WHERE religion_id=%s",
                       GetSQLValueString($_GET['delete_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

if ((isset($_GET['religion_id'])) && ($_GET['religion_id'] != "")) {
  $deleteSQL = sprintf("UPDATE religions SET religion_status=%s WHERE religion_id=%s",
                       GetSQLValueString($_GET['changed_status'], "int"),
					   GetSQLValueString($_GET['religion_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}


$maxRows_rsReligions = 10;
$pageNum_rsReligions = 0;
if (isset($_GET['pageNum_rsReligions'])) {
  $pageNum_rsReligions = $_GET['pageNum_rsReligions'];
}
$startRow_rsReligions = $pageNum_rsReligions * $maxRows_rsReligions;

$colname_rsReligions = "0";
if (isset($_GET['status'])) {
  $colname_rsReligions = (get_magic_quotes_gpc()) ? $_GET['status'] : addslashes($_GET['status']);
}
mysql_select_db($database_conn, $conn);
$query_rsReligions = sprintf("SELECT * FROM religions WHERE religion_status LIKE '%s%%'", $colname_rsReligions);
$query_limit_rsReligions = sprintf("%s LIMIT %d, %d", $query_rsReligions, $startRow_rsReligions, $maxRows_rsReligions);
$rsReligions = mysql_query($query_limit_rsReligions, $conn) or die(mysql_error());
$row_rsReligions = mysql_fetch_assoc($rsReligions);

if (isset($_GET['totalRows_rsReligions'])) {
  $totalRows_rsReligions = $_GET['totalRows_rsReligions'];
} else {
  $all_rsReligions = mysql_query($query_rsReligions);
  $totalRows_rsReligions = mysql_num_rows($all_rsReligions);
}
$totalPages_rsReligions = ceil($totalRows_rsReligions/$maxRows_rsReligions)-1;

$queryString_rsReligions = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsReligions") == false && 
        stristr($param, "totalRows_rsReligions") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsReligions = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsReligions = sprintf("&totalRows_rsReligions=%d%s", $totalRows_rsReligions, $queryString_rsReligions);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<h1>Religions</h1>
<p><a href="religions.php?status=0">Pending</a> | <a href="religions.php?status=1">Approved</a> | <a href="religions.php?status=-1">Blocked</a> | <a href="religions.php?status=%">All</a></p>
<?php if ($totalRows_rsReligions > 0) { // Show if recordset not empty ?>
  <table border="1">
    <tr>
      <td valign="top">religion_id</td>
      <td valign="top">user_id</td>
      <td valign="top">religion_name</td>
      <td valign="top">religion_description</td>
      <td valign="top">religion_creation_dt</td>
      <td valign="top">religion_status</td>
      <td valign="top">Update</td>
      <td valign="top">Delete</td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="top"><?php echo $row_rsReligions['religion_id']; ?></td>
        <td valign="top"><?php echo $row_rsReligions['user_id']; ?></td>
        <td valign="top"><?php echo $row_rsReligions['religion_name']; ?></td>
        <td valign="top"><?php echo $row_rsReligions['religion_description']; ?></td>
        <td valign="top"><?php echo $row_rsReligions['religion_creation_dt']; ?></td>
        <td valign="top"><?php echo $row_rsReligions['religion_status']; ?></td>
        <td valign="top"><a href="religions.php?changed_status=0&status=<?php echo $colname_rsReligions; ?>&religion_id=<?php echo $row_rsReligions['religion_id']; ?>">Pending</a> | <a href="religions.php?changed_status=1&status=<?php echo $colname_rsReligions; ?>&religion_id=<?php echo $row_rsReligions['religion_id']; ?>">Approved</a> | <a href="religions.php?changed_status=-1&status=<?php echo $colname_rsReligions; ?>&religion_id=<?php echo $row_rsReligions['religion_id']; ?>">Blocked</a> | <a href="religions.php?changed_status=2&status=<?php echo $colname_rsReligions; ?>&religion_id=<?php echo $row_rsReligions['religion_id']; ?>">Soft Delete</a></td>
        <td valign="top"><a href="religions.php?delete_id=<?php echo $row_rsReligions['religion_id']; ?>&status=<?php echo $colname_rsReligions; ?>">Hard Delete</a></td>
      </tr>
      <?php } while ($row_rsReligions = mysql_fetch_assoc($rsReligions)); ?>
      </table>
  <p> Records <?php echo ($startRow_rsReligions + 1) ?> to <?php echo min($startRow_rsReligions + $maxRows_rsReligions, $totalRows_rsReligions) ?> of <?php echo $totalRows_rsReligions ?>
  <table border="0" width="50%" align="center">
    <tr>
      <td width="23%" align="center"><?php if ($pageNum_rsReligions > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsReligions=%d%s", $currentPage, 0, $queryString_rsReligions); ?>">First</a>
          <?php } // Show if not first page ?>      </td>
      <td width="31%" align="center"><?php if ($pageNum_rsReligions > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsReligions=%d%s", $currentPage, max(0, $pageNum_rsReligions - 1), $queryString_rsReligions); ?>">Previous</a>
          <?php } // Show if not first page ?>      </td>
      <td width="23%" align="center"><?php if ($pageNum_rsReligions < $totalPages_rsReligions) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsReligions=%d%s", $currentPage, min($totalPages_rsReligions, $pageNum_rsReligions + 1), $queryString_rsReligions); ?>">Next</a>
          <?php } // Show if not last page ?>      </td>
      <td width="23%" align="center"><?php if ($pageNum_rsReligions < $totalPages_rsReligions) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsReligions=%d%s", $currentPage, $totalPages_rsReligions, $queryString_rsReligions); ?>">Last</a>
          <?php } // Show if not last page ?>      </td>
    </tr>
      </table>
  <?php } // Show if recordset not empty ?></p>
<?php if ($totalRows_rsReligions == 0) { // Show if recordset empty ?>
  <p>No Record Found. </p>
  <?php } // Show if recordset empty ?></body>
</html>
<?php
mysql_free_result($rsReligions);
?>
