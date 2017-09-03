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
  $insertSQL = sprintf("INSERT INTO law_issues (issue, subject, template, user_id) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['issue'], "text"),
                       GetSQLValueString($_POST['subject'], "text"),
                       GetSQLValueString($_POST['template'], "text"),
                       GetSQLValueString($_POST['user_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$_POST['issue_id'] = mysql_insert_id();
	
	if (!empty($_POST['comments'])) {
		$_POST["MM_insert"] = "form2";
	}
}

if (empty($_POST['issue_id']) && (isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
	echo 'empty issue id';
	exit;
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO law_essay_issues (user_id, issue_id, comments, sorting, essay_id, statementHint) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['issue_id'], "int"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['sorting'], "int"),
                       GetSQLValueString($_POST['essay_id'], "int"),
                       GetSQLValueString($_POST['statementHint'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "essays_issues.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$coluser_rsEssays = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $coluser_rsEssays = (get_magic_quotes_gpc()) ? $_SESSION['MM_UserId'] : addslashes($_SESSION['MM_UserId']);
}
$colname_rsEssays = "-1";
if (isset($_GET['essay_id'])) {
  $colname_rsEssays = (get_magic_quotes_gpc()) ? $_GET['essay_id'] : addslashes($_GET['essay_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsEssays = sprintf("SELECT * FROM law_essays WHERE essay_id = %s AND user_id = %s AND deleted = 0", $colname_rsEssays,$coluser_rsEssays);
$rsEssays = mysql_query($query_rsEssays, $conn) or die(mysql_error());
$row_rsEssays = mysql_fetch_assoc($rsEssays);
$totalRows_rsEssays = mysql_num_rows($rsEssays);

$coluser_rsIssues = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $coluser_rsIssues = (get_magic_quotes_gpc()) ? $_SESSION['MM_UserId'] : addslashes($_SESSION['MM_UserId']);
}
$colname_rsIssues = "-1";
if (isset($_GET['subject'])) {
  $colname_rsIssues = (get_magic_quotes_gpc()) ? $_GET['subject'] : addslashes($_GET['subject']);
}
mysql_select_db($database_conn, $conn);
$query_rsIssues = sprintf("SELECT * FROM law_issues WHERE subject = '%s' AND user_id = %s ORDER BY law_issues.issue", $colname_rsIssues,$coluser_rsIssues);
$rsIssues = mysql_query($query_rsIssues, $conn) or die(mysql_error());
$row_rsIssues = mysql_fetch_assoc($rsIssues);
$totalRows_rsIssues = mysql_num_rows($rsIssues);

$maxRows_rsEssayIssues = 15;
$pageNum_rsEssayIssues = 0;
if (isset($_GET['pageNum_rsEssayIssues'])) {
  $pageNum_rsEssayIssues = $_GET['pageNum_rsEssayIssues'];
}
$startRow_rsEssayIssues = $pageNum_rsEssayIssues * $maxRows_rsEssayIssues;

$coluser_rsEssayIssues = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $coluser_rsEssayIssues = (get_magic_quotes_gpc()) ? $_SESSION['MM_UserId'] : addslashes($_SESSION['MM_UserId']);
}
$colname_rsEssayIssues = "-1";
if (isset($_GET['essay_id'])) {
  $colname_rsEssayIssues = (get_magic_quotes_gpc()) ? $_GET['essay_id'] : addslashes($_GET['essay_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsEssayIssues = sprintf("SELECT * FROM law_essay_issues as a LEFT JOIN law_issues as b ON a.issue_id = b.issue_id WHERE a.essay_id = %s AND a.user_id = %s ORDER BY a.sorting ASC", $colname_rsEssayIssues,$coluser_rsEssayIssues);
$query_limit_rsEssayIssues = sprintf("%s LIMIT %d, %d", $query_rsEssayIssues, $startRow_rsEssayIssues, $maxRows_rsEssayIssues);
$rsEssayIssues = mysql_query($query_limit_rsEssayIssues, $conn) or die(mysql_error());
$row_rsEssayIssues = mysql_fetch_assoc($rsEssayIssues);

if (isset($_GET['totalRows_rsEssayIssues'])) {
  $totalRows_rsEssayIssues = $_GET['totalRows_rsEssayIssues'];
} else {
  $all_rsEssayIssues = mysql_query($query_rsEssayIssues);
  $totalRows_rsEssayIssues = mysql_num_rows($all_rsEssayIssues);
}
$totalPages_rsEssayIssues = ceil($totalRows_rsEssayIssues/$maxRows_rsEssayIssues)-1;

$queryString_rsEssayIssues = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsEssayIssues") == false && 
        stristr($param, "totalRows_rsEssayIssues") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsEssayIssues = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsEssayIssues = sprintf("&totalRows_rsEssayIssues=%d%s", $totalRows_rsEssayIssues, $queryString_rsEssayIssues);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/lawbar.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Add Issues</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<!-- InstanceBeginEditable name="head" -->


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
<h1>Essay</h1>
<p><strong>Read the following Essay and Find the Issues</strong></p>
<p><strong><?php echo $row_rsEssays['month_year']; ?> </strong></p>
<p><?php echo nl2br($row_rsEssays['essay']); ?></p>
<?php if ($totalRows_rsEssayIssues > 0) { // Show if recordset not empty ?>
  <h1>View Current Issues </h1>
  <div class="table-responsive">
	    <table class="table table-striped">

    <tr>
      <td valign="top"><strong>Sorting</strong></td>
      <td valign="top"><strong>Issue</strong></td>
      <td valign="top"><strong>Comments</strong></td>
      <td valign="top"><strong>Why is this issue present? </strong></td>
      <td valign="top"><strong>Template</strong></td>
      <td valign="top"><strong>Subject</strong></td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="top"><?php echo $row_rsEssayIssues['sorting']; ?></td>
        <td valign="top"><?php echo nl2br($row_rsEssayIssues['issue']); ?></td>
        <td valign="top"><?php echo nl2br($row_rsEssayIssues['comments']); ?></td>
        <td valign="top"><?php echo nl2br($row_rsEssayIssues['statementHint']); ?></td>
        <td valign="top"><?php echo nl2br($row_rsEssayIssues['template']); ?></td>
        <td valign="top"><?php echo $row_rsEssayIssues['subject']; ?></td>
      </tr>
      <?php } while ($row_rsEssayIssues = mysql_fetch_assoc($rsEssayIssues)); ?>
</table>
</div>
  <p> Records <?php echo ($startRow_rsEssayIssues + 1) ?> to <?php echo min($startRow_rsEssayIssues + $maxRows_rsEssayIssues, $totalRows_rsEssayIssues) ?> of <?php echo $totalRows_rsEssayIssues ?></p>
  <table border="0" width="50%" align="center">
    <tr>
      <td width="23%" align="center"><?php if ($pageNum_rsEssayIssues > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsEssayIssues=%d%s", $currentPage, 0, $queryString_rsEssayIssues); ?>">First</a>
          <?php } // Show if not first page ?>      </td>
      <td width="31%" align="center"><?php if ($pageNum_rsEssayIssues > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsEssayIssues=%d%s", $currentPage, max(0, $pageNum_rsEssayIssues - 1), $queryString_rsEssayIssues); ?>">Previous</a>
          <?php } // Show if not first page ?>      </td>
      <td width="23%" align="center"><?php if ($pageNum_rsEssayIssues < $totalPages_rsEssayIssues) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsEssayIssues=%d%s", $currentPage, min($totalPages_rsEssayIssues, $pageNum_rsEssayIssues + 1), $queryString_rsEssayIssues); ?>">Next</a>
          <?php } // Show if not last page ?>      </td>
      <td width="23%" align="center"><?php if ($pageNum_rsEssayIssues < $totalPages_rsEssayIssues) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsEssayIssues=%d%s", $currentPage, $totalPages_rsEssayIssues, $queryString_rsEssayIssues); ?>">Last</a>
          <?php } // Show if not last page ?>      </td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<h1>Add New Issue</h1>
<table border="1" cellspacing="0" cellpadding="5">
  <tr>
    <td valign="top"><form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1" onsubmit="MM_validateForm('issue','','R');return document.MM_returnValue">
      <div class="table-responsive">
	    <table class="table table-striped">

        <tr>
          <td valign="top">&nbsp;</td>
          <td valign="top"><strong>New Issue </strong></td>
        </tr>
        <tr>
          <td valign="top"><strong>Issue</strong></td>
          <td valign="top"><input name="issue" type="text" id="issue" size="55" /></td>
        </tr>
        <tr>
          <td valign="top"><strong>Template</strong></td>
          <td valign="top"><textarea name="template" cols="55" rows="10" id="template"></textarea></td>
        </tr>
        <tr>
          <td valign="top"><strong>Comments / Analysis </strong></td>
          <td valign="top"><textarea name="comments" cols="55" rows="10" id="comments"></textarea></td>
        </tr>
        <tr>
          <td valign="top"><strong>Hint About Why this issue is prese</strong>nt? </td>
          <td valign="top"><textarea name="statementHint" cols="55" rows="10" id="statementHint"></textarea></td>
        </tr>
        <tr>
          <td valign="top"><strong>Sorting</strong></td>
          <td valign="top"><label>
            <input name="sorting" type="text" id="sorting" value="0" />
          </label></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td valign="top"><label>
            <input type="submit" name="Submit2" value="Submit" />
            <input name="essay_id" type="hidden" id="essay_id" value="<?php echo $_GET['essay_id']; ?>" />
            <input name="user_id" type="hidden" id="user_id" value="<?php echo $_SESSION['MM_UserId']; ?>" />
            <input name="subject" type="hidden" id="subject" value="<?php echo $_GET['subject']; ?>" />
          </label></td>
        </tr>
     </table>
</div>
      <input type="hidden" name="MM_insert" value="form1">
</form></td>
    <td valign="top"><form action="<?php echo $editFormAction; ?>" method="POST" name="form2" id="form2">
      <div class="table-responsive">
	    <table class="table table-striped">

        <tr>
          <td valign="top"><strong>Existing Issue</strong></td>
          <td valign="top"><strong>
            <select name="issue_id" id="issue_id">
              <option value="">Select</option>
              <?php
do {  
?>
              <option value="<?php echo $row_rsIssues['issue_id']?>"><?php echo $row_rsIssues['issue']?> / <?php echo $row_rsIssues['issue_id']?></option>
              <?php
} while ($row_rsIssues = mysql_fetch_assoc($rsIssues));
  $rows = mysql_num_rows($rsIssues);
  if($rows > 0) {
      mysql_data_seek($rsIssues, 0);
	  $row_rsIssues = mysql_fetch_assoc($rsIssues);
  }
?>
            </select>
          </strong></td>
        </tr>
        <tr>
          <td valign="top"><strong>Comments / Analysis </strong></td>
          <td valign="top"><textarea name="comments" cols="55" rows="10" id="comments"></textarea></td>
        </tr>
        <tr>
          <td valign="top"><strong>Sorting</strong></td>
          <td valign="top"><label>
            <input name="sorting" type="text" id="sorting" value="0" />
          </label></td>
        </tr>
        <tr>
          <td valign="top"><strong>Hint About Why this issue is prese</strong>nt? </td>
          <td valign="top"><textarea name="statementHint" cols="55" rows="10" id="statementHint"></textarea></td>
        </tr>
        <tr>
          <td valign="top"><input name="essay_id" type="hidden" id="essay_id" value="<?php echo $_GET['essay_id']; ?>" />
            <input name="user_id" type="hidden" id="user_id" value="<?php echo $_SESSION['MM_UserId']; ?>" />
            <input name="subject" type="hidden" id="subject" value="<?php echo $_GET['subject']; ?>" /></td>
          <td valign="top"><label>
            <input type="submit" name="Submit" value="Submit" />
          </label></td>
        </tr>
      </table>
</div>
      <input type="hidden" name="MM_insert" value="form2">
    </form></td>
  </tr>
</table>



</div>
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsEssays);

mysql_free_result($rsIssues);

mysql_free_result($rsEssayIssues);
?>
