<?php require_once('../../Connections/conn_mysite.php'); ?>
<?php
session_start();
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
  $insertSQL = sprintf("INSERT INTO mysite_partners (user_id, partner_created_dt, name, gender, city_id, city, `state`, country, county, address, licence_number, licence_image, education, profession, lat, lon) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['partner_created_dt'], "date"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['city_id'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['state'], "text"),
                       GetSQLValueString($_POST['country'], "text"),
                       GetSQLValueString($_POST['county'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['licence_number'], "text"),
                       GetSQLValueString($_POST['licence_image'], "text"),
                       GetSQLValueString($_POST['education'], "text"),
                       GetSQLValueString($_POST['profession'], "text"),
                       GetSQLValueString($_POST['lat'], "double"),
                       GetSQLValueString($_POST['lon'], "double"));

  mysql_select_db($database_conn_mysite, $conn_mysite);
  $Result1 = mysql_query($insertSQL, $conn_mysite) or die(mysql_error());

  $insertGoTo = "confirm.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

?><!doctype html>
<html><!-- InstanceBegin template="/Templates/mysite.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>display</title>
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
<h3>Apply As a New Partner</h3>
<p>&nbsp; </p>

<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
    <table>
        <tr valign="baseline">
            <td nowrap align="right">Name:</td>
            <td><input type="text" name="name" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
            <td nowrap align="right">Gender:</td>
            <td><select name="gender">
                <option value="" >Select Gender</option>
                <option value="Male" <?php if (!(strcmp("Male", ""))) {echo "SELECTED";} ?>>Male</option>
                <option value="Female" <?php if (!(strcmp("Female", ""))) {echo "SELECTED";} ?>>Female</option>
            </select>
            </td>
        </tr>
        <tr valign="baseline">
            <td nowrap align="right">Address:</td>
            <td><input type="text" name="address" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
            <td nowrap align="right">Licence Number:</td>
            <td><input type="text" name="licence_number" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
            <td nowrap align="right">Licence_image:</td>
            <td><input type="text" name="licence_image" value="" size="32">
                <label>
                <input type="file" name="file">
                </label></td>
        </tr>
        <tr valign="baseline">
            <td nowrap align="right">Education:</td>
            <td><input type="text" name="education" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
            <td nowrap align="right">Profession:</td>
            <td><input type="text" name="profession" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
            <td nowrap align="right">&nbsp;</td>
            <td><input type="submit" value="Insert record"></td>
        </tr>
    </table>
    <input type="text" name="user_id" id="user_id" placeholder="user_id" value="<?php echo $_SESSION['MM_UserId']; ?>">
    <input type="text" name="partner_created_dt" id="partner_created_dt" placeholder="partner_created_dt" value="<?php echo date('Y-m-d H:i:s'); ?>">
    <input type="hidden" name="MM_insert" value="form1">
	<div style="width:500px;">
	
	<?php include('../map.php'); ?>
	</div>
	
	
	
	
	
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<!-- InstanceEndEditable -->
</body><!-- InstanceEnd -->
</html>