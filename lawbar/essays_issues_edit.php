<?php require_once('../Connections/conn.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE law_essay_issues SET comments=%s, sorting=%s, statementHint=%s WHERE essay_issue_id=%s",
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['sorting'], "int"),
                       GetSQLValueString($_POST['statementHint'], "text"),
                       GetSQLValueString($_POST['essay_issue_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "essays_issues.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsEdit = "-1";
if (isset($_GET['essay_issue_id'])) {
  $colname_rsEdit = (get_magic_quotes_gpc()) ? $_GET['essay_issue_id'] : addslashes($_GET['essay_issue_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsEdit = sprintf("SELECT * FROM law_essay_issues WHERE essay_issue_id = %s", $colname_rsEdit);
$rsEdit = mysql_query($query_rsEdit, $conn) or die(mysql_error());
$row_rsEdit = mysql_fetch_assoc($rsEdit);
$totalRows_rsEdit = mysql_num_rows($rsEdit);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/lawbar.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Edit Issue</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- include summernote css/js-->
<link href="library/wysiwyg/summernote.css" rel="stylesheet">
<script src="library/wysiwyg/summernote.js"></script>

<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
<h1>Edit Issue</h1>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <div class="table-responsive">
	    <table class="table table-striped">

      <tr valign="baseline">
        <td nowrap align="right" valign="top">Comments:</td>
        <td valign="top"><textarea name="comments" id="comments" cols="50" rows="10"><?php echo $row_rsEdit['comments']; ?></textarea>        </td>
      </tr>
      <tr valign="baseline">
        <td align="right" valign="top" nowrap>Sorting:</td>
        <td valign="top"><input type="text" name="sorting" value="<?php echo $row_rsEdit['sorting']; ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td align="right" valign="top" nowrap>Hint:</td>
        <td valign="top"><textarea name="statementHint" cols="50" rows="5" id="statementHint" ><?php echo $row_rsEdit['statementHint']; ?>          </textarea></td>
      </tr>
      <tr valign="baseline">
        <td align="right" valign="top" nowrap>&nbsp;</td>
        <td valign="top"><input type="submit" value="Update record"></td>
      </tr>
    </table>
</div>
    <input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="essay_issue_id" value="<?php echo $row_rsEdit['essay_issue_id']; ?>">
  </form>
<script>
document.getElementById('comments').focus();
 	$(document).ready(function() {
        $('#comments').summernote();
    });
</script>
</div>
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsEdit);
?>
