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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$developers = array();
	if (!empty($_POST['developer_name'])) {
		foreach ($_POST['developer_name'] as $k => $v) {
			if (empty($v)) {
				continue;
			}
			$developers[$k]['name'] = $v;
			$developers[$k]['image'] = $_POST['developers_image'][$k];
			$developers[$k]['designation'] = $_POST['developer_designation'][$k];
			$developers[$k]['fb'] = $_POST['developer_fb'][$k];
			$developers[$k]['tw'] = $_POST['developer_tw'][$k];
			$developers[$k]['ln'] = $_POST['developer_ln'][$k];
			$developers[$k]['gp'] = $_POST['developer_gp'][$k];
			$developers[$k]['description'] = $_POST['developer_description'][$k];
		}
	}
	
	$jsonDeveloper = json_encode($developers);
	$_POST['site_our_team'] = $jsonDeveloper;
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE sites SET site_name=%s, site_title=%s, site_domain=%s, site_subtitle=%s, site_background_img=%s, site_rightside_img=%s, site_icon1=%s, site_icon1_title=%s, site_icon1_desc=%s, site_icon2=%s, site_icon2_title=%s, site_icon2_desc=%s, site_icon3=%s, site_icon3_title=%s, site_icon3_desc=%s, site_icon4=%s, site_icon4_title=%s, site_icon4_desc=%s, site_findoutmorelink=%s, site_sec_title=%s, site_sec_desc=%s, site_sec_link=%s, site_default_title=%s, site_default_desc=%s, site_default_image=%s, site_primary_title=%s, site_primary_desc=%s, site_primary_image=%s, site_our_team=%s, site_about_desc=%s, site_about_image=%s, site_address=%s, site_phone=%s, site_email=%s, site_timings=%s, site_links=%s, site_admin_email=%s, site_lat=%s, site_lng=%s WHERE site_id=%s",
                       GetSQLValueString($_POST['site_name'], "text"),
                       GetSQLValueString($_POST['site_title'], "text"),
                       GetSQLValueString($_POST['site_domain'], "text"),
                       GetSQLValueString($_POST['site_subtitle'], "text"),
                       GetSQLValueString($_POST['site_background_img'], "text"),
                       GetSQLValueString($_POST['site_rightside_img'], "text"),
                       GetSQLValueString($_POST['site_icon1'], "text"),
                       GetSQLValueString($_POST['site_icon1_title'], "text"),
                       GetSQLValueString($_POST['site_icon1_desc'], "text"),
                       GetSQLValueString($_POST['site_icon2'], "text"),
                       GetSQLValueString($_POST['site_icon2_title'], "text"),
                       GetSQLValueString($_POST['site_icon2_desc'], "text"),
                       GetSQLValueString($_POST['site_icon3'], "text"),
                       GetSQLValueString($_POST['site_icon3_title'], "text"),
                       GetSQLValueString($_POST['site_icon3_desc'], "text"),
                       GetSQLValueString($_POST['site_icon4'], "text"),
                       GetSQLValueString($_POST['site_icon4_title'], "text"),
                       GetSQLValueString($_POST['site_icon4_desc'], "text"),
                       GetSQLValueString($_POST['site_findoutmorelink'], "text"),
                       GetSQLValueString($_POST['site_sec_title'], "text"),
                       GetSQLValueString($_POST['site_sec_desc'], "text"),
                       GetSQLValueString($_POST['site_sec_link'], "text"),
                       GetSQLValueString($_POST['site_default_title'], "text"),
                       GetSQLValueString($_POST['site_default_desc'], "text"),
                       GetSQLValueString($_POST['site_default_image'], "text"),
                       GetSQLValueString($_POST['site_primary_title'], "text"),
                       GetSQLValueString($_POST['site_primary_desc'], "text"),
                       GetSQLValueString($_POST['site_primary_image'], "text"),
                       GetSQLValueString($_POST['site_our_team'], "text"),
                       GetSQLValueString($_POST['site_about_desc'], "text"),
                       GetSQLValueString($_POST['site_about_image'], "text"),
                       GetSQLValueString($_POST['site_address'], "text"),
                       GetSQLValueString($_POST['site_phone'], "text"),
                       GetSQLValueString($_POST['site_email'], "text"),
                       GetSQLValueString($_POST['site_timings'], "text"),
                       GetSQLValueString($_POST['site_links'], "text"),
                       GetSQLValueString($_POST['site_admin_email'], "text"),
                       GetSQLValueString($_POST['site_lat'], "double"),
                       GetSQLValueString($_POST['site_lng'], "double"),
                       GetSQLValueString($_POST['site_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
}

mysql_select_db($database_conn, $conn);
$query_rsEdit = "SELECT * FROM sites WHERE site_id = 2";
$rsEdit = mysql_query($query_rsEdit, $conn) or die(mysql_error());
$row_rsEdit = mysql_fetch_assoc($rsEdit);
$totalRows_rsEdit = mysql_num_rows($rsEdit);

mysql_select_db($database_conn, $conn);
$query_rsSiteInformation = "SELECT * FROM sites WHERE site_id = 2";
$rsSiteInformation = mysql_query($query_rsSiteInformation, $conn) or die(mysql_error());
$row_rsSiteInformation = mysql_fetch_assoc($rsSiteInformation);
$totalRows_rsSiteInformation = mysql_num_rows($rsSiteInformation);


$team = json_decode($row_rsSiteInformation['site_our_team'], true);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/massage.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Site Information</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">

<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script src="../js/firebase.js"></script>
<script src="../js/script.js"></script>
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
	.name {
		color: red;
		font-weight:bold;
	}
</style>
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
          <a class="navbar-brand" href="../index.php">Massage Exchange</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="../home.php">Home</a></li>
            <li><a href="../team.php">Our Team</a></li>
            <li><a href="../about.php">About</a></li>
            <li><a href="../contact.php">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Religions <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="../create_religion.php">Create New Religion</a></li>
                <li><a href="../home.php">Browse All Religions</a></li>
                <li><a href="../my_religions.php">My Created Religions</a></li>
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
                <li><a href="religions.php">Religions (Approve / Block)</a></li>
                <li><a href="views.php">Verses (Approve / Block)</a></li>
                <li><a href="site.php">Site Information</a></li>
				
				
              </ul>
            </li>
			<?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="container">
<h1>Site Information</h1>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
   <div class="table-responsive">
	    <table class="table table-striped">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_name:</td>
      <td><input type="text" name="site_name" value="<?php echo $row_rsEdit['site_name']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_title:</td>
      <td><input type="text" name="site_title" value="<?php echo $row_rsEdit['site_title']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_domain:</td>
      <td><input type="text" name="site_domain" value="<?php echo $row_rsEdit['site_domain']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Site_subtitle:</td>
      <td><textarea name="site_subtitle" cols="50" rows="5"><?php echo $row_rsEdit['site_subtitle']; ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_background_img:</td>
      <td><input type="text" name="site_background_img" value="<?php echo $row_rsEdit['site_background_img']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_rightside_img:</td>
      <td><input type="text" name="site_rightside_img" value="<?php echo $row_rsEdit['site_rightside_img']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_icon1:</td>
      <td><input type="text" name="site_icon1" value="<?php echo $row_rsEdit['site_icon1']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_icon1_title:</td>
      <td><input type="text" name="site_icon1_title" value="<?php echo $row_rsEdit['site_icon1_title']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Site_icon1_desc:</td>
      <td><textarea name="site_icon1_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_icon1_desc']; ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_icon2:</td>
      <td><input type="text" name="site_icon2" value="<?php echo $row_rsEdit['site_icon2']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_icon2_title:</td>
      <td><input type="text" name="site_icon2_title" value="<?php echo $row_rsEdit['site_icon2_title']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Site_icon2_desc:</td>
      <td><textarea name="site_icon2_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_icon2_desc']; ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_icon3:</td>
      <td><input type="text" name="site_icon3" value="<?php echo $row_rsEdit['site_icon3']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_icon3_title:</td>
      <td><input type="text" name="site_icon3_title" value="<?php echo $row_rsEdit['site_icon3_title']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Site_icon3_desc:</td>
      <td><textarea name="site_icon3_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_icon3_desc']; ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_icon4:</td>
      <td><input type="text" name="site_icon4" value="<?php echo $row_rsEdit['site_icon4']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_icon4_title:</td>
      <td><input type="text" name="site_icon4_title" value="<?php echo $row_rsEdit['site_icon4_title']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Site_icon4_desc:</td>
      <td><textarea name="site_icon4_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_icon4_desc']; ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_findoutmorelink:</td>
      <td><input type="text" name="site_findoutmorelink" value="<?php echo $row_rsEdit['site_findoutmorelink']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_sec_title:</td>
      <td><input type="text" name="site_sec_title" value="<?php echo $row_rsEdit['site_sec_title']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Site_sec_desc:</td>
      <td><textarea name="site_sec_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_sec_desc']; ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_sec_link:</td>
      <td><input type="text" name="site_sec_link" value="<?php echo $row_rsEdit['site_sec_link']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_default_title:</td>
      <td><input type="text" name="site_default_title" value="<?php echo $row_rsEdit['site_default_title']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Site_default_desc:</td>
      <td><textarea name="site_default_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_default_desc']; ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_default_image:</td>
      <td><input type="text" name="site_default_image" value="<?php echo $row_rsEdit['site_default_image']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_primary_title:</td>
      <td><input type="text" name="site_primary_title" value="<?php echo $row_rsEdit['site_primary_title']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Site_primary_desc:</td>
      <td><textarea name="site_primary_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_primary_desc']; ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_primary_image:</td>
      <td><input type="text" name="site_primary_image" value="<?php echo $row_rsEdit['site_primary_image']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Site_about_desc:</td>
      <td><textarea name="site_about_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_about_desc']; ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_about_image:</td>
      <td><input type="text" name="site_about_image" value="<?php echo $row_rsEdit['site_about_image']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_address:</td>
      <td><input type="text" name="site_address" value="<?php echo $row_rsEdit['site_address']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_phone:</td>
      <td><input type="text" name="site_phone" value="<?php echo $row_rsEdit['site_phone']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_email:</td>
      <td><input type="text" name="site_email" value="<?php echo $row_rsEdit['site_email']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_timings:</td>
      <td><input type="text" name="site_timings" value="<?php echo $row_rsEdit['site_timings']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_admin_email:</td>
      <td><input type="text" name="site_admin_email" value="<?php echo $row_rsEdit['site_admin_email']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_latitutde:</td>
      <td><input type="text" name="site_lat" value="<?php echo $row_rsEdit['site_lat']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site_longitude:</td>
      <td><input type="text" name="site_lng" value="<?php echo $row_rsEdit['site_lng']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Developers:</td>
      <td>
	  <?php if (!empty($team)) { ?>
	  	<?php foreach ($team as $k => $v) { ?>
		<fieldset id="developer_<?php echo $k; ?>"><legend class="name"><?php echo $v['name']; ?></legend>
		<p><strong>Developers Information</strong></p>
        <p>Image:
          <input name="developers_image[]" type="text" id="developers_image[]" value="<?php echo $v['image']; ?>" />
          Name:
          <input name="developer_name[]" type="text" id="developer_name[]" value="<?php echo $v['name']; ?>" />
          Designation
          <input name="developer_designation[]" type="text" id="developer_designation[]" value="<?php echo $v['designation']; ?>" />
              <br />
          Fb URL:
          <input name="developer_fb[]" type="text" id="developer_fb[]" value="<?php echo $v['fb']; ?>" />
          Twitter URL:
          <input name="developer_tw[]" type="text" id="developer_tw[]" value="<?php echo $v['tw']; ?>" />
          LinkedIn:
          <label>
            <input name="developer_ln[]" type="text" id="developer_ln[] value="<?php echo $v['ln']; ?>>
              </label>
              <br />
          Google Plus:
          <label>
            <input name="developer_gp[]" type="text" id="developer_gp[]" value="<?php echo $v['gp']; ?>" />
              </label>
          </p>
        <p>Description <br />
            <label>
              <textarea name="developer_description[]" cols="55" rows="4" id="developer_description[]"><?php echo $v['description']; ?></textarea>
            </label>
        </p> 
		</fieldset>
		<?php } ?>
		<hr />
	  <?php } ?>
	  <div id="dev1">
	  	<p><strong>New Developer's Information</strong></p>
        <p>Image:
          <input name="developers_image[]" type="text" id="developers_image[]" />
          Name:
          <input name="developer_name[]" type="text" id="developer_name[]" />
          Designation
          <input name="developer_designation[]" type="text" id="developer_designation[]" />
              <br />
          Fb URL:
          <input name="developer_fb[]" type="text" id="developer_fb[]" />
          Twitter URL:
          <input name="developer_tw[]" type="text" id="developer_tw[]" />
          LinkedIn:
          <label>
            <input name="developer_ln[]" type="text" id="developer_ln[]" />
                </label>
              <br />
          Google Plus:
          <label>
            <input name="developer_gp[]" type="text" id="developer_gp[]" />
                </label>
          </p>
        <p>Description <br />
            <label>
              <textarea name="developer_description[]" cols="55" rows="4" id="developer_description[]"></textarea>
            </label>
        </p> 
	  
	  </div>       </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="button" name="Submit" value="Add More Developers"  onclick="addMoreDevelopers();" />
	  	<div id="dev2" style="display:none;">
		<p><strong>Developers Information</strong></p>
        <p>Image:
          <input name="developers_image[]" type="text" id="developers_image[]" />
          Name:
          <input name="developer_name[]" type="text" id="developer_name[]" />
          Designation
          <input name="developer_designation[]" type="text" id="developer_designation[]" />
              <br />
          Fb URL:
          <input name="developer_fb[]" type="text" id="developer_fb[]" />
          Twitter URL:
          <input name="developer_tw[]" type="text" id="developer_tw[]" />
          LinkedIn:
          <label>
            <input name="developer_ln[]" type="text" id="developer_ln[]" />
                </label>
              <br />
          Google Plus:
          <label>
            <input name="developer_gp[]" type="text" id="developer_gp[]" />
                </label>
          </p>
        <p>Description <br />
            <label>
              <textarea name="developer_description[]" cols="55" rows="4" id="developer_description[]"></textarea>
            </label>
        </p> 
		</div>
		
		<script>
			function addMoreDevelopers() {
				$('#dev1').append($('#dev2').html());
			}
		</script>
	  </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  </div>
  <input type="hidden" name="site_our_team" value="<?php echo htmlspecialchars($row_rsEdit['site_our_team']); ?>" />
  <input type="hidden" name="site_links" value="<?php echo $row_rsEdit['site_links']; ?>" />
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="site_id" value="<?php echo $row_rsEdit['site_id']; ?>" />
</form>
</div>
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsEdit);

mysql_free_result($rsSiteInformation);
?>
