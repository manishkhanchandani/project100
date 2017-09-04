<?php require_once('../Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin,member";
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

$MM_restrictGoTo = "users/auth.php";
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
  $insertSQL = sprintf("INSERT INTO law_essays (essay_id, essay, month_year, user_id, subject) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['subject'], "int"),
                       GetSQLValueString($_POST['essay'], "text"),
                       GetSQLValueString($_POST['month_year'], "text"),
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['subject'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "essays.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_rsMyEssays = 25;
$pageNum_rsMyEssays = 0;
if (isset($_GET['pageNum_rsMyEssays'])) {
  $pageNum_rsMyEssays = $_GET['pageNum_rsMyEssays'];
}
$startRow_rsMyEssays = $pageNum_rsMyEssays * $maxRows_rsMyEssays;

$colname_rsMyEssays = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $colname_rsMyEssays = (get_magic_quotes_gpc()) ? $_SESSION['MM_UserId'] : addslashes($_SESSION['MM_UserId']);
}
mysql_select_db($database_conn, $conn);
$query_rsMyEssays = sprintf("SELECT * FROM law_essays WHERE user_id = %s AND deleted = 0 ORDER BY essay_id DESC", $colname_rsMyEssays);
$query_limit_rsMyEssays = sprintf("%s LIMIT %d, %d", $query_rsMyEssays, $startRow_rsMyEssays, $maxRows_rsMyEssays);
$rsMyEssays = mysql_query($query_limit_rsMyEssays, $conn) or die(mysql_error());
$row_rsMyEssays = mysql_fetch_assoc($rsMyEssays);

if (isset($_GET['totalRows_rsMyEssays'])) {
  $totalRows_rsMyEssays = $_GET['totalRows_rsMyEssays'];
} else {
  $all_rsMyEssays = mysql_query($query_rsMyEssays);
  $totalRows_rsMyEssays = mysql_num_rows($all_rsMyEssays);
}
$totalPages_rsMyEssays = ceil($totalRows_rsMyEssays/$maxRows_rsMyEssays)-1;

$queryString_rsMyEssays = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsMyEssays") == false && 
        stristr($param, "totalRows_rsMyEssays") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsMyEssays = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsMyEssays = sprintf("&totalRows_rsMyEssays=%d%s", $totalRows_rsMyEssays, $queryString_rsMyEssays);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/lawbar.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Essays</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- include summernote css/js-->
<link href="library/wysiwyg/summernote.css" rel="stylesheet">
<script src="library/wysiwyg/summernote.js"></script>

<!-- InstanceBeginEditable name="head" -->


<style type="text/css">
 body {
 	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
 }
</style>
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
<!-- InstanceEndEditable -->
</head>

<body>


    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Law Bar</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="team.php">Our Team</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Essays <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="essays.php">Manage Essay</a></li>
                <li><a href="issues.php?subject=contracts">Manage Issues - Contracts</a></li>
                <li><a href="issues.php?subject=torts">Manage Issues - Torts</a></li>
                <li><a href="issues.php?subject=criminal">Manage Issues - Criminal</a></li>
              </ul>
            </li>
			
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
              <ul class="dropdown-menu">
			  	<li><a href="users/auth.php">Login/Logout</a></li>
              </ul>
            </li>
			
			
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">MBE <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Coming soon</a></li>
				
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="container">
<h1>Enter New Essay</h1>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" onsubmit="MM_validateForm('month_year','','R','essay','','R');return document.MM_returnValue">
  <div class="table-responsive">
	    <table class="table table-striped">

    <tr valign="baseline">
      <td nowrap align="right">Month Year / Reference:</td>
      <td><input type="text" name="month_year" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Subject:</td>
      <td><label>
        <select name="subject" id="subject">
          <option value="contracts">Contracts</option>
          <option value="torts">Torts</option>
          <option value="criminal">Criminal</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Essay:</td>
      <td><textarea name="essay" cols="50" rows="10"></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
</table>
</div>
  <input type="hidden" name="MM_insert" value="form1">
  <input name="user_id" type="hidden" id="user_id" value="<?php echo $_SESSION['MM_UserId']; ?>" />
</form>
<?php if ($totalRows_rsMyEssays > 0) { // Show if recordset not empty ?>
    <h1>View My Essays </h1>
  <div class="table-responsive">
	    <table class="table table-striped">

    <tr>
      <td valign="top"><strong>Subject</strong></td>
      <td valign="top"><strong>Month / Year or Reference </strong></td>
      <td valign="top"><strong>Essay</strong></td>
      <td valign="top"><strong>Create Date </strong></td>
      <td valign="top"><strong>Delete</strong></td>
      <td valign="top"><strong>Issues</strong></td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="top"><?php echo $row_rsMyEssays['subject']; ?></td>
        <td valign="top"><?php echo $row_rsMyEssays['month_year']; ?></td>
        <td valign="top"><?php echo stripslashes(nl2br($row_rsMyEssays['essay'])); ?></td>
        <td valign="top"><?php echo $row_rsMyEssays['created_dt']; ?></td>
        <td valign="top"><a href="essays_delete.php?essay_id=<?php echo $row_rsMyEssays['essay_id']; ?>" onclick="var a = confirm('do you really want to delete this?'); return a;">Delete</a></td>
        <td valign="top"><a href="essays_issues.php?essay_id=<?php echo $row_rsMyEssays['essay_id']; ?>&subject=<?php echo $row_rsMyEssays['subject']; ?>">Issues</a></td>
      </tr>
      <?php } while ($row_rsMyEssays = mysql_fetch_assoc($rsMyEssays)); ?>
</table>
</div>
  <p> Records <?php echo ($startRow_rsMyEssays + 1) ?> to <?php echo min($startRow_rsMyEssays + $maxRows_rsMyEssays, $totalRows_rsMyEssays) ?> of <?php echo $totalRows_rsMyEssays ?></p>
  <table border="0" width="50%" align="center">
    <tr>
      <td width="23%" align="center"><?php if ($pageNum_rsMyEssays > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsMyEssays=%d%s", $currentPage, 0, $queryString_rsMyEssays); ?>">First</a>
      <?php } // Show if not first page ?>      </td>
      <td width="31%" align="center"><?php if ($pageNum_rsMyEssays > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsMyEssays=%d%s", $currentPage, max(0, $pageNum_rsMyEssays - 1), $queryString_rsMyEssays); ?>">Previous</a>
      <?php } // Show if not first page ?>      </td>
      <td width="23%" align="center"><?php if ($pageNum_rsMyEssays < $totalPages_rsMyEssays) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsMyEssays=%d%s", $currentPage, min($totalPages_rsMyEssays, $pageNum_rsMyEssays + 1), $queryString_rsMyEssays); ?>">Next</a>
      <?php } // Show if not last page ?>      </td>
      <td width="23%" align="center"><?php if ($pageNum_rsMyEssays < $totalPages_rsMyEssays) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsMyEssays=%d%s", $currentPage, $totalPages_rsMyEssays, $queryString_rsMyEssays); ?>">Last</a>
      <?php } // Show if not last page ?>      </td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
</div>
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsMyEssays);
?>
