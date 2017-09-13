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
	$_POST['view_images'] = array_filter($_POST['view_images']);
	$_POST['view_videos'] = array_filter($_POST['view_videos']);
	$_POST['view_links'] = array_filter($_POST['view_links']);
	
	$_POST['view_images'] = json_encode($_POST['view_images']);
	$_POST['view_videos'] = json_encode($_POST['view_videos']);
	$_POST['view_links'] = json_encode($_POST['view_links']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO religions_view (view_user_id, religion_id, view_description, category_id, view_created_dt, view_images, view_videos, view_links) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['view_user_id'], "int"),
                       GetSQLValueString($_POST['religion_id'], "int"),
                       GetSQLValueString($_POST['view_description'], "text"),
                       GetSQLValueString($_POST['category_id'], "int"),
                       GetSQLValueString($_POST['view_created_dt'], "date"),
                       GetSQLValueString($_POST['view_images'], "text"),
                       GetSQLValueString($_POST['view_videos'], "text"),
                       GetSQLValueString($_POST['view_links'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}


$colname_rsReligion = "-1";
if (isset($_GET['religion_id'])) {
  $colname_rsReligion = (get_magic_quotes_gpc()) ? $_GET['religion_id'] : addslashes($_GET['religion_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsReligion = sprintf("SELECT * FROM religions WHERE religion_id = %s", $colname_rsReligion);
$rsReligion = mysql_query($query_rsReligion, $conn) or die(mysql_error());
$row_rsReligion = mysql_fetch_assoc($rsReligion);
$totalRows_rsReligion = mysql_num_rows($rsReligion);


include('checking_religion_status.php');

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	mysql_select_db($database_conn, $conn);
	$query_rsSiteInformation = "SELECT * FROM sites WHERE site_id = 1";
	$rsSiteInformation = mysql_query($query_rsSiteInformation, $conn) or die(mysql_error());
	$row_rsSiteInformation = mysql_fetch_assoc($rsSiteInformation);
	$totalRows_rsSiteInformation = mysql_num_rows($rsSiteInformation);
	$msg = '
Dear Admin,
New verse has been created with description "'.$_POST['view_description'].'" and for religion "'.$row_rsReligion['religion_name'].'" on website MyReligion. 

Regards.
	
';
	//mail($row_rsSiteInformation['site_admin_email'], 'New Verse Created for Religion '.$row_rsReligion['religion_name'], $msg, 'From:Info <info@myreligion.tk>');
	$message = 'New Verse Created Successfully. It is under admin approval, so please wait for 24 to 48 hours to get it approved.';
}

?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/myReligion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Add New Verse</title>
<!-- InstanceEndEditable -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">

<script src="js/jquery-3.2.1.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


<script src="js/firebase.js"></script>
<script src="js/script.js"></script>
<!-- InstanceBeginEditable name="head" -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.js"></script>
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
          <a class="navbar-brand" href="index.php">My Religion</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="home.php">Home</a></li>
            <li><a href="team.php">Our Team</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Religions <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="create_religion.php">Create New Religion</a></li>
                <li><a href="home.php">Browse All Religions</a></li>
                <li><a href="my_religions.php">My Created Religions</a></li>
              </ul>
            </li>
			
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
              <ul class="dropdown-menu">
			  	<?php if (empty($_SESSION['MM_UserId'])) { ?>
                <li><a href="#" onClick="googleLogin(); return false;">Google Login</a></li>
                <li><a href="#" onClick="facebookLogin(); return false;">Facebook Login</a></li>
                <li><a href="#" onClick="twitterLogin(); return false;">Twitter Login</a></li>
                <li><a href="#" onClick="gitHubLogin(); return false;">Github Login</a></li>
				<?php } ?>
				<?php if (!empty($_SESSION['MM_UserId'])) { ?>
				<li><a href="#"><strong>Name:</strong> <?php echo $_SESSION['MM_DisplayName']; ?></a></li>
				<li><a href="#"><strong>Email:</strong> <?php echo $_SESSION['MM_Username']; ?></a></li>
				<li><a href="#"><strong>Access Level:</strong> <?php echo $_SESSION['MM_UserGroup']; ?></a></li>
				
                <li><a href="#" onClick="signOut(); return false;">Logout</a></li>
				<?php } ?>
              </ul>
            </li>
			
			<?php if (!empty($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup'] === 'admin') { ?>
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admins <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="admin/religions.php">Religions (Approve / Block)</a></li>
                <li><a href="admin/views.php">Verses (Approve / Block)</a></li>
                <li><a href="admin/site.php">Site Information</a></li>
				
				
              </ul>
            </li>
			<?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="container">
	<h3>Add New Verse For  &quot;<?php echo $row_rsReligion['religion_name']; ?>&quot;</h3>
	<p><a href="detail.php?religion_id=<?php echo $row_rsReligion['religion_id']; ?>">Go Back To Religion Page </a></p>

<?php if (!empty($message)) { ?>
<div class="alert alert-danger" role="alert"><?php echo $message;  ?></div>
<?php } ?>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <div class="table-responsive">
      <table class="table table-striped">
    <tr valign="baseline">
      <td nowrap align="right" valign="top"><strong>Verse:</strong></td>
      <td><textarea name="view_description" cols="50" rows="5"></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><strong>Category Id:</strong></td>
      <td><select name="category_id">
        <option value="1">General</option>
        <option value="2">Economy</option>
        <option value="3">Jobs</option>
        <option value="4">Education</option>
        <option value="5">Environment</option>
        <option value="6">Health</option>
        <option value="7">Justice & Equality</option>
        <option value="8">National Security</option>
        <option value="9">God</option>
        <option value="10">Humanity</option>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><strong>Image:</strong></td>
      <td>
	  	<div id="images">
        <input name="view_images[]" type="text" id="view_images[]" size="55" placeholder="Add Image URL" />
        <input name="moreImage" type="button" id="moreImage" value="Add More Images" onClick="addMoreImages();" />
		</div>
		<div id="images2" style="display:none;">
		<br />
		<input name="view_images[]" type="text" id="view_images[]" size="55" placeholder="Add Image URL" />
		</div>
		<script>
			function addMoreImages() {
				$('#images').append($('#images2').html());
			}
		</script>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><strong>Videos (Youtube URL) </strong></td>
      <td>
	  	<div id="videos">
        <input name="view_videos[]" type="text" id="view_videos[]" size="55" placeholder="Add Youtube URLS" />
        <input name="moreVideos" type="button" id="moreVideos" value="Add More Videos" onClick="addMoreVideos();" />
		</div>
		<div id="videos2" style="display:none;">
			<br />
			<input name="view_videos[]" type="text" id="view_videos[]" size="55" placeholder="Add Youtube URLS" />
		</div>
		<script>
			function addMoreVideos() {
				$('#videos').append($('#videos2').html());
			}
		</script>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><strong>Links / PDF / Document: </strong></td>
      <td>
	  	<div id="links">
			<input name="view_links[]" type="text" id="view_links[]" size="55" placeholder="Add Links" />
      		<input name="moreLinks" type="button" id="moreLinks" value="Add More Links" onClick="addMoreLinks();" />
		</div>
		<div id="links2" style="display:none;">
			<br />
			<input name="view_links[]" type="text" id="view_links[]" size="55" placeholder="Add Links" />
		</div>
		<script>
			function addMoreLinks() {
				$('#links').append($('#links2').html());
			}
		</script>	  </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Add New Verse"></td>
    </tr>
  </table>
  </div>
  <input type="hidden" name="view_user_id" value="<?php echo $_SESSION['MM_UserId']; ?>">
  <input type="hidden" name="religion_id" value="<?php echo $_GET['religion_id']; ?>">
  <input type="hidden" name="view_created_dt" value="<?php echo date('Y-m-d H:i:s'); ?>">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</div>
<!-- InstanceEndEditable -->

</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsReligion);
?>
