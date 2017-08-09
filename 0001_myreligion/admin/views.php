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

if ((isset($_GET['view_id'])) && ($_GET['view_id'] != "")) {
  $deleteSQL = sprintf("UPDATE religions_view SET view_status=%s WHERE view_id=%s",
                       GetSQLValueString($_GET['changeStatus'], "int"),
					   GetSQLValueString($_GET['view_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

$maxRows_rsViews = 10;
$pageNum_rsViews = 0;
if (isset($_GET['pageNum_rsViews'])) {
  $pageNum_rsViews = $_GET['pageNum_rsViews'];
}
$startRow_rsViews = $pageNum_rsViews * $maxRows_rsViews;

mysql_select_db($database_conn, $conn);
$query_rsViews = "SELECT * FROM religions_view";
$query_limit_rsViews = sprintf("%s LIMIT %d, %d", $query_rsViews, $startRow_rsViews, $maxRows_rsViews);
$rsViews = mysql_query($query_limit_rsViews, $conn) or die(mysql_error());
$row_rsViews = mysql_fetch_assoc($rsViews);

if (isset($_GET['totalRows_rsViews'])) {
  $totalRows_rsViews = $_GET['totalRows_rsViews'];
} else {
  $all_rsViews = mysql_query($query_rsViews);
  $totalRows_rsViews = mysql_num_rows($all_rsViews);
}
$totalPages_rsViews = ceil($totalRows_rsViews/$maxRows_rsViews)-1;

$queryString_rsViews = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsViews") == false && 
        stristr($param, "totalRows_rsViews") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsViews = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsViews = sprintf("&totalRows_rsViews=%d%s", $totalRows_rsViews, $queryString_rsViews);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<h1>Views</h1>
<p>Pending | Approved | Blocked | Deleted Views  </p>
<?php if ($totalRows_rsViews > 0) { // Show if recordset not empty ?>
  <table border="1">
    <tr>
      <td valign="top"><strong>view_id</strong></td>
      <td valign="top"><strong>view_user_id</strong></td>
      <td valign="top"><strong>religion_id</strong></td>
      <td valign="top"><strong>view_description</strong></td>
      <td valign="top"><strong>category_id</strong></td>
      <td valign="top"><strong>view_created_dt</strong></td>
      <td valign="top"><strong>view_status</strong></td>
      <td valign="top"><strong>view_images</strong></td>
      <td valign="top"><strong>view_videos</strong></td>
      <td valign="top"><strong>view_links</strong></td>
      <td valign="top"><strong>Change Status </strong></td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="top"><?php echo $row_rsViews['view_id']; ?></td>
        <td valign="top"><?php echo $row_rsViews['view_user_id']; ?></td>
        <td valign="top"><?php echo $row_rsViews['religion_id']; ?></td>
        <td valign="top"><?php echo $row_rsViews['view_description']; ?></td>
        <td valign="top"><?php echo $row_rsViews['category_id']; ?></td>
        <td valign="top"><?php echo $row_rsViews['view_created_dt']; ?></td>
        <td valign="top"><?php echo $row_rsViews['view_status']; ?></td>
        <td valign="top"><?php $images = json_decode($row_rsViews['view_images'], true);
			foreach ($images as $k => $v) {
				?>
				<?php echo $k + 1; ?>. <a href="<?php echo $v; ?>" target="_blank"><?php echo $v; ?></a><br /><br />
				<?php
			}
			
		 ?></td>
        <td valign="top"><?php $videos = json_decode($row_rsViews['view_videos'], true); 
		
			foreach ($videos as $k  => $v) {
				?>
				<?php echo $k + 1; ?>. <a href="<?php echo $v; ?>" target="_blank"><?php echo $v; ?></a><br /><br />
				<?php
			}
		
		
		?></td>
        <td valign="top"><?php $links = json_decode($row_rsViews['view_links'], true); 
		
			foreach ($links as $k  => $v) {
				?>
				<?php echo $k + 1; ?>. <a href="<?php echo $v; ?>" target="_blank"><?php echo $v; ?></a><br /><br />
				<?php
			}
		
		
		?></td>
        <td valign="top"><a href="views.php?changeStatus=0&view_id=<?php echo $row_rsViews['view_id']; ?>">Pending</a> | <a href="views.php?changeStatus=1&view_id=<?php echo $row_rsViews['view_id']; ?>">Approved</a> | <a href="views.php?changeStatus=2&view_id=<?php echo $row_rsViews['view_id']; ?>">Blocked</a> | <a href="views.php?changeStatus=3&view_id=<?php echo $row_rsViews['view_id']; ?>">Deleted</a> </td>
      </tr>
      <?php } while ($row_rsViews = mysql_fetch_assoc($rsViews)); ?>
  </table>
  <p> Records <?php echo ($startRow_rsViews + 1) ?> to <?php echo min($startRow_rsViews + $maxRows_rsViews, $totalRows_rsViews) ?> of <?php echo $totalRows_rsViews ?>
  <table border="0" width="50%" align="center">
        <tr>
          <td width="23%" align="center"><?php if ($pageNum_rsViews > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_rsViews=%d%s", $currentPage, 0, $queryString_rsViews); ?>">First</a>
                <?php } // Show if not first page ?>
          </td>
          <td width="31%" align="center"><?php if ($pageNum_rsViews > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_rsViews=%d%s", $currentPage, max(0, $pageNum_rsViews - 1), $queryString_rsViews); ?>">Previous</a>
                <?php } // Show if not first page ?>
          </td>
          <td width="23%" align="center"><?php if ($pageNum_rsViews < $totalPages_rsViews) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_rsViews=%d%s", $currentPage, min($totalPages_rsViews, $pageNum_rsViews + 1), $queryString_rsViews); ?>">Next</a>
                <?php } // Show if not last page ?>
          </td>
          <td width="23%" align="center"><?php if ($pageNum_rsViews < $totalPages_rsViews) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_rsViews=%d%s", $currentPage, $totalPages_rsViews, $queryString_rsViews); ?>">Last</a>
                <?php } // Show if not last page ?>
          </td>
        </tr>
  </table>
  <?php } // Show if recordset not empty ?>
</p>
<?php if ($totalRows_rsViews == 0) { // Show if recordset empty ?>
  <p>No Views Available
    <?php } // Show if recordset empty ?>
</p>
</body>
</html>
<?php
mysql_free_result($rsViews);
?>
