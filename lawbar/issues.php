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
  $insertSQL = sprintf("INSERT INTO law_issues (issue, subject, template, user_id, hints) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['issue'], "text"),
                       GetSQLValueString($_POST['subject'], "text"),
                       GetSQLValueString($_POST['template'], "text"),
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['hints'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "issues.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_rsIssues = 25;
$pageNum_rsIssues = 0;
if (isset($_GET['pageNum_rsIssues'])) {
  $pageNum_rsIssues = $_GET['pageNum_rsIssues'];
}
$startRow_rsIssues = $pageNum_rsIssues * $maxRows_rsIssues;

$colname_rsIssues = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $colname_rsIssues = (get_magic_quotes_gpc()) ? $_SESSION['MM_UserId'] : addslashes($_SESSION['MM_UserId']);
}
mysql_select_db($database_conn, $conn);
$query_rsIssues = sprintf("SELECT * FROM law_issues WHERE user_id = %s AND issue_deleted = 0 ORDER BY issue_id DESC", $colname_rsIssues);
$query_limit_rsIssues = sprintf("%s LIMIT %d, %d", $query_rsIssues, $startRow_rsIssues, $maxRows_rsIssues);
$rsIssues = mysql_query($query_limit_rsIssues, $conn) or die(mysql_error());
$row_rsIssues = mysql_fetch_assoc($rsIssues);

if (isset($_GET['totalRows_rsIssues'])) {
  $totalRows_rsIssues = $_GET['totalRows_rsIssues'];
} else {
  $all_rsIssues = mysql_query($query_rsIssues);
  $totalRows_rsIssues = mysql_num_rows($all_rsIssues);
}
$totalPages_rsIssues = ceil($totalRows_rsIssues/$maxRows_rsIssues)-1;

$queryString_rsIssues = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsIssues") == false && 
        stristr($param, "totalRows_rsIssues") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsIssues = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsIssues = sprintf("&totalRows_rsIssues=%d%s", $totalRows_rsIssues, $queryString_rsIssues);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/lawbar.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Issues</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
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
<h1>Issues</h1>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1" onsubmit="MM_validateForm('issue','','R');return document.MM_returnValue">
  <div class="table-responsive">
    <table class="table table-striped">
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top"><strong>New Issue </strong></td>
      </tr>
      <tr>
        <td align="right" valign="top"><strong>Subject</strong></td>
        <td valign="top"><select name="subject" id="subject">
          <option value="contracts" <?php if (!(strcmp("contracts", $_GET['subject']))) {echo "selected=\"selected\"";} ?>>Contracts</option>
          <option value="torts" <?php if (!(strcmp("torts", $_GET['subject']))) {echo "selected=\"selected\"";} ?>>Torts</option>
          <option value="criminal" <?php if (!(strcmp("criminal", $_GET['subject']))) {echo "selected=\"selected\"";} ?>>Criminal</option>
        </select>        </td>
      </tr>
      <tr>
        <td align="right" valign="top"><strong>Issue</strong></td>
        <td valign="top"><input name="issue" type="text" id="issue" size="55" /></td>
      </tr>
      <tr>
        <td align="right" valign="top"><strong>Template</strong></td>
        <td valign="top"><textarea name="template" cols="55" rows="10" id="template"></textarea></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right"><strong>Hints:</strong></td>
        <td>
          <input name="hints" type="text" id="hints" size="55" />
        </td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top"><label>
          <input type="submit" name="Submit2" value="Submit" />
          <input name="essay_id" type="hidden" id="essay_id" value="<?php echo $_GET['essay_id']; ?>" />
          <input name="user_id" type="hidden" id="user_id" value="<?php echo $_SESSION['MM_UserId']; ?>" />
        </label></td>
      </tr>
    </table>
  </div>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<?php if ($totalRows_rsIssues > 0) { // Show if recordset not empty ?>
  <h1>View Issues</h1>
  <div class="table-responsive">
	    <table class="table table-striped">

    <tr>
      <td><strong>Issue ID</strong> </td>
      <td><strong>issue</strong></td>
        <td><strong>subject</strong></td>
        <td><strong>template</strong></td>
        <td><strong>hint</strong></td>
        <td><strong>Edit</strong></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_rsIssues['issue_id']; ?></td>
        <td><?php echo $row_rsIssues['issue']; ?></td>
        <td><?php echo $row_rsIssues['subject']; ?></td>
        <td><?php echo nl2br($row_rsIssues['template']); ?></td>
        <td><?php echo $row_rsIssues['hints']; ?></td>
        <td><a href="issues_edit.php?issue_id=<?php echo $row_rsIssues['issue_id']; ?>&subject=<?php echo $row_rsIssues['subject']; ?>&pageNum_rsIssues=<?php echo $pageNum_rsIssues; ?>">Edit</a></td>
      </tr>
      <?php } while ($row_rsIssues = mysql_fetch_assoc($rsIssues)); ?>
</table>
</div>
  <p>&nbsp;</p>
  <p> Records <?php echo ($startRow_rsIssues + 1) ?> to <?php echo min($startRow_rsIssues + $maxRows_rsIssues, $totalRows_rsIssues) ?> of <?php echo $totalRows_rsIssues ?></p>
    <p>
    <table border="0" width="50%" align="center">
      <tr>
        <td width="23%" align="center"><?php if ($pageNum_rsIssues > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_rsIssues=%d%s", $currentPage, 0, $queryString_rsIssues); ?>">First</a>
            <?php } // Show if not first page ?>        </td>
        <td width="31%" align="center"><?php if ($pageNum_rsIssues > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_rsIssues=%d%s", $currentPage, max(0, $pageNum_rsIssues - 1), $queryString_rsIssues); ?>">Previous</a>
            <?php } // Show if not first page ?>        </td>
        <td width="23%" align="center"><?php if ($pageNum_rsIssues < $totalPages_rsIssues) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_rsIssues=%d%s", $currentPage, min($totalPages_rsIssues, $pageNum_rsIssues + 1), $queryString_rsIssues); ?>">Next</a>
            <?php } // Show if not last page ?>        </td>
        <td width="23%" align="center"><?php if ($pageNum_rsIssues < $totalPages_rsIssues) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_rsIssues=%d%s", $currentPage, $totalPages_rsIssues, $queryString_rsIssues); ?>">Last</a>
            <?php } // Show if not last page ?>        </td>
      </tr>
      </table>
  <?php } // Show if recordset not empty ?>
<script>
document.getElementById('issue').focus();
</script>
</div>
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsIssues);
?>
