<?php require_once('../Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

$currentPage = $_SERVER["PHP_SELF"];

$categories = array(1 => 'General', 2 => 'Economy', 3 => 'Jobs', 4 => 'Education', 5 => 'Environment', 6 => 'Health', 7 => 'Justice & Equality', 8 => 'National Security', 9 => 'God', 10 => 'Humanity');

$keyword = '';
if (!empty($_GET['keyword'])) {
	$keyword = $_GET['keyword'];
}




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


if ((isset($_GET['delete_id'])) && ($_GET['delete_id'] != "")) {
  $deleteSQL = sprintf("UPDATE religions_view SET view_status=3 WHERE view_id=%s",
					   GetSQLValueString($_GET['delete_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
  
  
  header("Location: detail.php?religion_id=".$_GET['religion_id']);
  exit;
}


if ((isset($_GET['delete_religion_id'])) && ($_GET['delete_religion_id'] != "")) {
  $deleteSQL = sprintf("UPDATE religions_view SET view_status=3 WHERE religion_id=%s",
					   GetSQLValueString($_GET['delete_religion_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
  
  header("Location: detail.php?religion_id=".$_GET['religion_id']);
  exit;
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

$maxRows_rsVerses = 25;
$pageNum_rsVerses = 0;
if (isset($_GET['pageNum_rsVerses'])) {
  $pageNum_rsVerses = $_GET['pageNum_rsVerses'];
}
$startRow_rsVerses = $pageNum_rsVerses * $maxRows_rsVerses;

$colname_user_id_rsVerses = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $colname_user_id_rsVerses = (get_magic_quotes_gpc()) ? $_SESSION['MM_UserId'] : addslashes($_SESSION['MM_UserId']);
}
$colname2_rsVerses = "%";
if (isset($_GET['keyword'])) {
  $colname2_rsVerses = (get_magic_quotes_gpc()) ? $_GET['keyword'] : addslashes($_GET['keyword']);
}
$colname_rsVerses = "-1";
if (isset($_GET['religion_id'])) {
  $colname_rsVerses = (get_magic_quotes_gpc()) ? $_GET['religion_id'] : addslashes($_GET['religion_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsVerses = sprintf("SELECT religions_view.*, religions_like.like_id, religions_like.view_id as view_id2, religions_like.like_user_id, religions_like.like_date  FROM religions_view LEFT JOIN religions_like ON religions_view.view_id = religions_like.view_id AND religions_like.like_user_id = %s WHERE religions_view.religion_id = %s AND religions_view.view_status = 1 AND view_description LIKE '%%%s%%'", $colname_user_id_rsVerses,$colname_rsVerses,$colname2_rsVerses);
$query_limit_rsVerses = sprintf("%s LIMIT %d, %d", $query_rsVerses, $startRow_rsVerses, $maxRows_rsVerses);
$rsVerses = mysql_query($query_limit_rsVerses, $conn) or die(mysql_error());
$row_rsVerses = mysql_fetch_assoc($rsVerses);

if (isset($_GET['totalRows_rsVerses'])) {
  $totalRows_rsVerses = $_GET['totalRows_rsVerses'];
} else {
  $all_rsVerses = mysql_query($query_rsVerses);
  $totalRows_rsVerses = mysql_num_rows($all_rsVerses);
}
$totalPages_rsVerses = ceil($totalRows_rsVerses/$maxRows_rsVerses)-1;

$queryString_rsVerses = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsVerses") == false && 
        stristr($param, "totalRows_rsVerses") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsVerses = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsVerses = sprintf("&totalRows_rsVerses=%d%s", $totalRows_rsVerses, $queryString_rsVerses);
?><!doctype html>
<html><!-- InstanceBegin template="/Templates/myReligion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Religion</title>
<!-- InstanceEndEditable -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
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
          <a class="navbar-brand" href="#">Bootstrap theme</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="container">
	<h1 class="page-header"><?php echo $row_rsReligion['religion_name']; ?></h1>
	
	<!-- Religion Content -->
	<div class="row">
		<div class="col-md-5"><img src="<?php echo $row_rsReligion['religion_image']; ?>" class="img-responsive img-thumbnail" /></div>
		<div class="col-md-7">
			<div><?php echo $row_rsReligion['religion_description']; ?></div>
			<div>
			  <p>&nbsp;</p>
			  <p><strong>Religion Type:</strong> <?php echo ucfirst($row_rsReligion['religion_type']); ?></p>
			  <p><a href="views_new.php?religion_id=<?php echo $row_rsReligion['religion_id']; ?>">Add New Verse</a> </p>
			</div>
		</div>
	</div>
	
	
	  <h3 class="page-header">Verses</h3>
	  <form method="get">
	    <strong>Keyword:</strong> 
	    <label>
	    <input name="keyword" type="text" id="keyword" size="32" value="<?php echo $keyword; ?>">
	    </label>
	  
	    <label>
	    <input name="submit" type="submit" id="submit" value="Search">
    </label>
        <input name="religion_id" type="hidden" id="religion_id" value="<?php echo $row_rsReligion['religion_id']; ?>"> <span class="pull-right"><a href="copyAll.php?religion_id=<?php echo $row_rsReligion['religion_id']; ?>">Copy All Verses</a> | <a href="detail.php?religion_id=<?php echo $row_rsReligion['religion_id']; ?>&delete_religion_id=<?php echo $row_rsReligion['religion_id']; ?>">Delete All Verses</a></span>
      </form>
	<?php if ($totalRows_rsVerses > 0) { // Show if recordset not empty ?>

    <div class="table-responsive">
	    <table class="table table-striped">
          <tr>
            <td valign="top">&nbsp;</td>
            <td valign="top"><strong>Verse Description </strong></td>
            <td valign="top"><strong>Category</strong></td>
            <td valign="top"><strong>Detail Verse </strong></td>
            <td valign="top"><strong>Like</strong></td>
            <td valign="top">Copy</td>
            <td valign="top"><strong>Delete</strong></td>
          </tr>
          <?php do { ?>
	        <tr>
	          <td valign="top" class="detailImage">
			  	<?php $images = json_decode($row_rsVerses['view_images'], true);
					
						?>
			  <div><img src="<?php echo $images[0]; ?>" class="img-responsive" /></div>			  </td>
	          <td valign="top"><?php echo $row_rsVerses['view_description']; ?></td>
	          <td valign="top"><?php echo $categories[$row_rsVerses['category_id']]; ?></td>
	          <td valign="top"><a href="detail_verse.php?religion_id=<?php echo $row_rsReligion['religion_id']; ?>&view_id=<?php echo $row_rsVerses['view_id']; ?>">Detail Verse</a> </td>
	          <td valign="top">
			  <?php if (!empty($row_rsVerses['like_id'])) { ?>
			  Liked (<a href="unlike_verses.php?view_id=<?php echo $row_rsVerses['view_id']; ?>&religion_id=<?php echo $row_rsVerses['religion_id']; ?>">Unlike</a>)
			  <?php } else { ?>
			  <a href="like_verses.php?view_id=<?php echo $row_rsVerses['view_id']; ?>&religion_id=<?php echo $row_rsVerses['religion_id']; ?>">Like</a>
			  <?php } ?>
			  </td>
	          <td valign="top"><a href="copy.php?view_id=<?php echo $row_rsVerses['view_id']; ?>&religion_id=<?php echo $row_rsVerses['religion_id']; ?>">Copy</a></td>
	          <td valign="top"><a href="detail.php?delete_id=<?php echo $row_rsVerses['view_id']; ?>&religion_id=<?php echo $row_rsVerses['religion_id']; ?>">Delete</a></td>
            </tr>
	        <?php } while ($row_rsVerses = mysql_fetch_assoc($rsVerses)); ?>
      </table>
	   
    </div>
		  
		   <p> Records <?php echo ($startRow_rsVerses + 1) ?> to <?php echo min($startRow_rsVerses + $maxRows_rsVerses, $totalRows_rsVerses) ?> of <?php echo $totalRows_rsVerses ?></p>
	      <table border="0" width="50%" align="center">
            <tr>
              <td width="23%" align="center"><?php if ($pageNum_rsVerses > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_rsVerses=%d%s", $currentPage, 0, $queryString_rsVerses); ?>">First</a>
                    <?php } // Show if not first page ?>                                </td>
              <td width="31%" align="center"><?php if ($pageNum_rsVerses > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_rsVerses=%d%s", $currentPage, max(0, $pageNum_rsVerses - 1), $queryString_rsVerses); ?>">Previous</a>
                    <?php } // Show if not first page ?>                                </td>
              <td width="23%" align="center"><?php if ($pageNum_rsVerses < $totalPages_rsVerses) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_rsVerses=%d%s", $currentPage, min($totalPages_rsVerses, $pageNum_rsVerses + 1), $queryString_rsVerses); ?>">Next</a>
                    <?php } // Show if not last page ?>                                </td>
              <td width="23%" align="center"><?php if ($pageNum_rsVerses < $totalPages_rsVerses) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_rsVerses=%d%s", $currentPage, $totalPages_rsVerses, $queryString_rsVerses); ?>">Last</a>
                    <?php } // Show if not last page ?>                                </td>
            </tr>
    </table>

	  <?php } // Show if recordset not empty ?><p>&nbsp;</p>
</div>
<!-- InstanceEndEditable -->

</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsReligion);

mysql_free_result($rsVerses);
?>