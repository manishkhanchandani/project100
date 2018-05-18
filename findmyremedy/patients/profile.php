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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO fmr_profiles (user_id, first_name, last_name, gender, birthyear) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['first_name'], "text"),
                       GetSQLValueString($_POST['last_name'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['birthyear'], "int"));

  mysql_select_db($database_conn_mysite, $conn_mysite);
  $Result1 = mysql_query($insertSQL, $conn_mysite) or die(mysql_error());
}

$maxRows_rsProfile = 10;
$pageNum_rsProfile = 0;
if (isset($_GET['pageNum_rsProfile'])) {
  $pageNum_rsProfile = $_GET['pageNum_rsProfile'];
}
$startRow_rsProfile = $pageNum_rsProfile * $maxRows_rsProfile;

$colname_rsProfile = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $colname_rsProfile = (get_magic_quotes_gpc()) ? $_SESSION['MM_UserId'] : addslashes($_SESSION['MM_UserId']);
}
mysql_select_db($database_conn_mysite, $conn_mysite);
$query_rsProfile = sprintf("SELECT * FROM fmr_profiles WHERE user_id = %s", $colname_rsProfile);
$query_limit_rsProfile = sprintf("%s LIMIT %d, %d", $query_rsProfile, $startRow_rsProfile, $maxRows_rsProfile);
$rsProfile = mysql_query($query_limit_rsProfile, $conn_mysite) or die(mysql_error());
$row_rsProfile = mysql_fetch_assoc($rsProfile);

if (isset($_GET['totalRows_rsProfile'])) {
  $totalRows_rsProfile = $_GET['totalRows_rsProfile'];
} else {
  $all_rsProfile = mysql_query($query_rsProfile);
  $totalRows_rsProfile = mysql_num_rows($all_rsProfile);
}
$totalPages_rsProfile = ceil($totalRows_rsProfile/$maxRows_rsProfile)-1;

$queryString_rsProfile = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsProfile") == false && 
        stristr($param, "totalRows_rsProfile") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsProfile = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsProfile = sprintf("&totalRows_rsProfile=%d%s", $totalRows_rsProfile, $queryString_rsProfile);
?><!doctype html>
<html><!-- InstanceBegin template="/Templates/findmyremedy.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>My Profiles</title>
<!-- InstanceEndEditable -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">

<script src="../js/jquery-3.2.1.min.js"></script>

<script src="../js/bootstrap.min.js"></script>

<script src="../js/firebase.js"></script>
<script src="../js/script.js"></script>
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>

<body>
<?php include('../nav.php'); ?>

<!-- InstanceBeginEditable name="EditRegion3" -->
<h1>My Profiles</h1>
<h3>Add New Profile</h3>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table>
            <tr valign="baseline">
                <td nowrap align="right">First Name:</td>
                <td><input type="text" name="first_name" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
                <td nowrap align="right">Last Name:</td>
                <td><input type="text" name="last_name" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
                <td nowrap align="right">Gender:</td>
                <td>
                <select name="gender" id="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                </td>
            </tr>
            <tr valign="baseline">
                <td nowrap align="right">Birth Year:</td>
                <td><input type="text" name="birthyear" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
                <td nowrap align="right">&nbsp;</td>
                <td><input type="submit" value="Insert record">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['MM_UserId']; ?>">
        <input type="hidden" name="MM_insert" value="form1"></td>
            </tr>
        </table>
    </form>
    <?php if ($totalRows_rsProfile > 0) { // Show if recordset not empty ?>
        <h3>View My Profiles  </h3>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <td><strong>First Name </strong></td>
                <td><strong>Last Name </strong></td>
                <td><strong>Gender</strong></td>
                <td><strong>Age</strong></td>
                <td>Edit</td>
                <td>Delete</td>
                <td>Manage</td>
            </tr>
            <?php do { ?>
                <tr>
                    <td><?php echo $row_rsProfile['first_name']; ?></td>
                    <td><?php echo $row_rsProfile['last_name']; ?></td>
                    <td><?php echo $row_rsProfile['gender']; ?></td>
                    <td><?php echo $row_rsProfile['birthyear']; ?></td>
                    <td>Edit</td>
                    <td>Delete</td>
                    <td><a href="profile_details.php?profile_id=<?php echo $row_rsProfile['profile_id']; ?>">Manage</a></td>
                </tr>
                <?php } while ($row_rsProfile = mysql_fetch_assoc($rsProfile)); ?>
                </table>
        <p>
    <p> Records <?php echo ($startRow_rsProfile + 1) ?> to <?php echo min($startRow_rsProfile + $maxRows_rsProfile, $totalRows_rsProfile) ?> of <?php echo $totalRows_rsProfile ?> 
    <table border="0" width="50%" align="center">
        <tr>
            <td width="23%" align="center"><?php if ($pageNum_rsProfile > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_rsProfile=%d%s", $currentPage, 0, $queryString_rsProfile); ?>">First</a>
                        <?php } // Show if not first page ?>
            </td>
            <td width="31%" align="center"><?php if ($pageNum_rsProfile > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_rsProfile=%d%s", $currentPage, max(0, $pageNum_rsProfile - 1), $queryString_rsProfile); ?>">Previous</a>
                        <?php } // Show if not first page ?>
            </td>
            <td width="23%" align="center"><?php if ($pageNum_rsProfile < $totalPages_rsProfile) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_rsProfile=%d%s", $currentPage, min($totalPages_rsProfile, $pageNum_rsProfile + 1), $queryString_rsProfile); ?>">Next</a>
                        <?php } // Show if not last page ?>
            </td>
            <td width="23%" align="center"><?php if ($pageNum_rsProfile < $totalPages_rsProfile) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_rsProfile=%d%s", $currentPage, $totalPages_rsProfile, $queryString_rsProfile); ?>">Last</a>
                        <?php } // Show if not last page ?>
            </td>
        </tr>
    </table>
    <?php } // Show if recordset not empty ?></p>
<p>&nbsp;</p>
<!-- InstanceEndEditable -->
</body><!-- InstanceEnd -->
</html>
<?php
mysql_free_result($rsProfile);
?>
