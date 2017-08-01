<?php require_once('../Connections/conn.php'); ?><?php
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
?><?php
$currentPage = $_SERVER["PHP_SELF"];
?>
<?php
$maxRows_rsMyReligions = 10;
$pageNum_rsMyReligions = 0;
if (isset($_GET['pageNum_rsMyReligions'])) {
  $pageNum_rsMyReligions = $_GET['pageNum_rsMyReligions'];
}
$startRow_rsMyReligions = $pageNum_rsMyReligions * $maxRows_rsMyReligions;

$colname_rsMyReligions = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $colname_rsMyReligions = (get_magic_quotes_gpc()) ? $_SESSION['MM_UserId'] : addslashes($_SESSION['MM_UserId']);
}
mysql_select_db($database_conn, $conn);
$query_rsMyReligions = sprintf("SELECT * FROM religions WHERE user_id = %s", $colname_rsMyReligions);
$query_limit_rsMyReligions = sprintf("%s LIMIT %d, %d", $query_rsMyReligions, $startRow_rsMyReligions, $maxRows_rsMyReligions);
$rsMyReligions = mysql_query($query_limit_rsMyReligions, $conn) or die(mysql_error());
$row_rsMyReligions = mysql_fetch_assoc($rsMyReligions);

if (isset($_GET['totalRows_rsMyReligions'])) {
  $totalRows_rsMyReligions = $_GET['totalRows_rsMyReligions'];
} else {
  $all_rsMyReligions = mysql_query($query_rsMyReligions);
  $totalRows_rsMyReligions = mysql_num_rows($all_rsMyReligions);
}
$totalPages_rsMyReligions = ceil($totalRows_rsMyReligions/$maxRows_rsMyReligions)-1;

$queryString_rsMyReligions = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsMyReligions") == false && 
        stristr($param, "totalRows_rsMyReligions") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsMyReligions = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsMyReligions = sprintf("&totalRows_rsMyReligions=%d%s", $totalRows_rsMyReligions, $queryString_rsMyReligions);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
  <h1>My Religions</h1>
  <?php if ($totalRows_rsMyReligions > 0) { // Show if recordset not empty ?>
  <table border="1">
    <tr>
      <td>religion_id</td>
      <td>user_id</td>
      <td>religion_name</td>
      <td>religion_description</td>
      <td>religion_creation_dt</td>
      <td>religion_status</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_rsMyReligions['religion_id']; ?></td>
        <td><?php echo $row_rsMyReligions['user_id']; ?></td>
        <td><?php echo $row_rsMyReligions['religion_name']; ?></td>
        <td><?php echo $row_rsMyReligions['religion_description']; ?></td>
        <td><?php echo $row_rsMyReligions['religion_creation_dt']; ?></td>
        <td><?php echo $row_rsMyReligions['religion_status']; ?></td>
      </tr>
      <?php } while ($row_rsMyReligions = mysql_fetch_assoc($rsMyReligions)); ?>
  </table>
  <p> Records <?php echo ($startRow_rsMyReligions + 1) ?> to <?php echo min($startRow_rsMyReligions + $maxRows_rsMyReligions, $totalRows_rsMyReligions) ?> of <?php echo $totalRows_rsMyReligions ?></p>
  <table border="0" width="50%" align="center">
    <tr>
      <td width="23%" align="center"><?php if ($pageNum_rsMyReligions > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsMyReligions=%d%s", $currentPage, 0, $queryString_rsMyReligions); ?>">First</a>
          <?php } // Show if not first page ?>      </td>
      <td width="31%" align="center"><?php if ($pageNum_rsMyReligions > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsMyReligions=%d%s", $currentPage, max(0, $pageNum_rsMyReligions - 1), $queryString_rsMyReligions); ?>">Previous</a>
          <?php } // Show if not first page ?>      </td>
      <td width="23%" align="center"><?php if ($pageNum_rsMyReligions < $totalPages_rsMyReligions) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsMyReligions=%d%s", $currentPage, min($totalPages_rsMyReligions, $pageNum_rsMyReligions + 1), $queryString_rsMyReligions); ?>">Next</a>
          <?php } // Show if not last page ?>      </td>
      <td width="23%" align="center"><?php if ($pageNum_rsMyReligions < $totalPages_rsMyReligions) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsMyReligions=%d%s", $currentPage, $totalPages_rsMyReligions, $queryString_rsMyReligions); ?>">Last</a>
          <?php } // Show if not last page ?>      </td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_rsMyReligions == 0) { // Show if recordset empty ?>
  <p>No Religion Found. </p>
    <?php } // Show if recordset empty ?></body>
</html>
<?php
mysql_free_result($rsMyReligions);
?>
