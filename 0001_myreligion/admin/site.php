<?php require_once('../../Connections/conn.php'); ?>
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
$query_rsEdit = "SELECT * FROM sites WHERE site_id = 1";
$rsEdit = mysql_query($query_rsEdit, $conn) or die(mysql_error());
$row_rsEdit = mysql_fetch_assoc($rsEdit);
$totalRows_rsEdit = mysql_num_rows($rsEdit);
?><!doctype html>
<html><!-- InstanceBegin template="/Templates/myReligion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Site Information</title>
<!-- InstanceEndEditable -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- InstanceBeginEditable name="head" -->

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
          <a class="navbar-brand" href="../index.php">My Religion</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
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
                <li><a href="#">Login</a></li>
                <li><a href="#">Register as New User</a></li>
                <li><a href="#">Logout</a></li>
              </ul>
            </li>
			
			
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admins <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="religions.php">Religions (Approve / Block)</a></li>
                <li><a href="views.php">Verses (Approve / Block)</a></li>
				
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="container">
<h1>Site Information</h1>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
   <div class="table-responsive">
	    <table class="table table-striped">
    <tr valign="baseline">
      <td nowrap align="right">Site_name:</td>
      <td><input type="text" name="site_name" value="<?php echo $row_rsEdit['site_name']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_title:</td>
      <td><input type="text" name="site_title" value="<?php echo $row_rsEdit['site_title']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_domain:</td>
      <td><input type="text" name="site_domain" value="<?php echo $row_rsEdit['site_domain']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Site_subtitle:</td>
      <td><textarea name="site_subtitle" cols="50" rows="5"><?php echo $row_rsEdit['site_subtitle']; ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_background_img:</td>
      <td><input type="text" name="site_background_img" value="<?php echo $row_rsEdit['site_background_img']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_rightside_img:</td>
      <td><input type="text" name="site_rightside_img" value="<?php echo $row_rsEdit['site_rightside_img']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_icon1:</td>
      <td><input type="text" name="site_icon1" value="<?php echo $row_rsEdit['site_icon1']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_icon1_title:</td>
      <td><input type="text" name="site_icon1_title" value="<?php echo $row_rsEdit['site_icon1_title']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Site_icon1_desc:</td>
      <td><textarea name="site_icon1_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_icon1_desc']; ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_icon2:</td>
      <td><input type="text" name="site_icon2" value="<?php echo $row_rsEdit['site_icon2']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_icon2_title:</td>
      <td><input type="text" name="site_icon2_title" value="<?php echo $row_rsEdit['site_icon2_title']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Site_icon2_desc:</td>
      <td><textarea name="site_icon2_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_icon2_desc']; ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_icon3:</td>
      <td><input type="text" name="site_icon3" value="<?php echo $row_rsEdit['site_icon3']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_icon3_title:</td>
      <td><input type="text" name="site_icon3_title" value="<?php echo $row_rsEdit['site_icon3_title']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Site_icon3_desc:</td>
      <td><textarea name="site_icon3_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_icon3_desc']; ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_icon4:</td>
      <td><input type="text" name="site_icon4" value="<?php echo $row_rsEdit['site_icon4']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_icon4_title:</td>
      <td><input type="text" name="site_icon4_title" value="<?php echo $row_rsEdit['site_icon4_title']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Site_icon4_desc:</td>
      <td><textarea name="site_icon4_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_icon4_desc']; ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_findoutmorelink:</td>
      <td><input type="text" name="site_findoutmorelink" value="<?php echo $row_rsEdit['site_findoutmorelink']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_sec_title:</td>
      <td><input type="text" name="site_sec_title" value="<?php echo $row_rsEdit['site_sec_title']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Site_sec_desc:</td>
      <td><textarea name="site_sec_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_sec_desc']; ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_sec_link:</td>
      <td><input type="text" name="site_sec_link" value="<?php echo $row_rsEdit['site_sec_link']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_default_title:</td>
      <td><input type="text" name="site_default_title" value="<?php echo $row_rsEdit['site_default_title']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Site_default_desc:</td>
      <td><textarea name="site_default_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_default_desc']; ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_default_image:</td>
      <td><input type="text" name="site_default_image" value="<?php echo $row_rsEdit['site_default_image']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_primary_title:</td>
      <td><input type="text" name="site_primary_title" value="<?php echo $row_rsEdit['site_primary_title']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Site_primary_desc:</td>
      <td><textarea name="site_primary_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_primary_desc']; ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_primary_image:</td>
      <td><input type="text" name="site_primary_image" value="<?php echo $row_rsEdit['site_primary_image']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Site_about_desc:</td>
      <td><textarea name="site_about_desc" cols="50" rows="5"><?php echo $row_rsEdit['site_about_desc']; ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_about_image:</td>
      <td><input type="text" name="site_about_image" value="<?php echo $row_rsEdit['site_about_image']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_address:</td>
      <td><input type="text" name="site_address" value="<?php echo $row_rsEdit['site_address']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_phone:</td>
      <td><input type="text" name="site_phone" value="<?php echo $row_rsEdit['site_phone']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_email:</td>
      <td><input type="text" name="site_email" value="<?php echo $row_rsEdit['site_email']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_timings:</td>
      <td><input type="text" name="site_timings" value="<?php echo $row_rsEdit['site_timings']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_admin_email:</td>
      <td><input type="text" name="site_admin_email" value="<?php echo $row_rsEdit['site_admin_email']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_latitutde:</td>
      <td><input type="text" name="site_lat" value="<?php echo $row_rsEdit['site_lat']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site_longitude:</td>
      <td><input type="text" name="site_lng" value="<?php echo $row_rsEdit['site_lng']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  </div>
  <input type="hidden" name="site_our_team" value="<?php echo $row_rsEdit['site_our_team']; ?>">
  <input type="hidden" name="site_links" value="<?php echo $row_rsEdit['site_links']; ?>">
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="site_id" value="<?php echo $row_rsEdit['site_id']; ?>">
</form>
</div>
<!-- InstanceEndEditable -->

</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsEdit);
?>
