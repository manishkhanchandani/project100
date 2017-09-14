<?php require_once('../Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}


$currentPage = $_SERVER["PHP_SELF"];


$keyword = '';
if (!empty($_GET['keyword'])) {
	$keyword = $_GET['keyword'];
}

$type = '';
if (!empty($_GET['type'])) {
	$type = $_GET['type'];
}

$sorting = '';
if (!empty($_GET['sorting'])) {
	$type = $_GET['sorting'];
}

$sortingType = '';
if (!empty($_GET['sortingType'])) {
	$type = $_GET['sortingType'];
}

$maxRows_rsView = 25;
$pageNum_rsView = 0;
if (isset($_GET['pageNum_rsView'])) {
  $pageNum_rsView = $_GET['pageNum_rsView'];
}
$startRow_rsView = $pageNum_rsView * $maxRows_rsView;

$colname2_rsView = "%";
if (isset($_GET['keyword'])) {
  $colname2_rsView = (get_magic_quotes_gpc()) ? $_GET['keyword'] : addslashes($_GET['keyword']);
}
$colname_rsView = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $colname_rsView = (get_magic_quotes_gpc()) ? $_SESSION['MM_UserId'] : addslashes($_SESSION['MM_UserId']);
}
mysql_select_db($database_conn, $conn);
$query_rsView = sprintf("SELECT religions.*, religions_follower.follower_id, religions_follower.religion_id as religion_id2, religions_follower.follower_user_id, religions_follower.follower_date FROM religions LEFT JOIN religions_follower ON religions.religion_id = religions_follower.religion_id AND follower_user_id = %s WHERE religions.religion_status = 1 AND (religion_name LIKE '%%%s%%' OR religion_description LIKE '%%%s%%')", $colname_rsView,$colname2_rsView,$colname2_rsView);
$query_limit_rsView = sprintf("%s LIMIT %d, %d", $query_rsView, $startRow_rsView, $maxRows_rsView);
$rsView = mysql_query($query_limit_rsView, $conn) or die(mysql_error());
$row_rsView = mysql_fetch_assoc($rsView);

if (isset($_GET['totalRows_rsView'])) {
  $totalRows_rsView = $_GET['totalRows_rsView'];
} else {
  $all_rsView = mysql_query($query_rsView);
  $totalRows_rsView = mysql_num_rows($all_rsView);
}
$totalPages_rsView = ceil($totalRows_rsView/$maxRows_rsView)-1;

$queryString_rsView = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsView") == false && 
        stristr($param, "totalRows_rsView") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsView = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsView = sprintf("&totalRows_rsView=%d%s", $totalRows_rsView, $queryString_rsView);
?><!doctype html>
<html><!-- InstanceBegin template="/Templates/myReligion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Browse Religions</title>
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

  <h1>Religions</h1>
 	
    <div class="row">
    	<div class="col-md-3">
<form method="get">
  <label for="keyword">Keyword:</label> 

  <input name="keyword" type="text" id="keyword" class="form-control " value="<?php echo $keyword; ?>"><br />
  
  <label for="type_1">Religion Type:</label> 
	<div class="form-control text-center">
  <input  <?php if (!(strcmp($type,"public"))) {echo "checked=\"checked\"";} ?> name="type" type="radio" id="type_1" value="public"> Public
  <input  <?php if (!(strcmp($type,"closed"))) {echo "checked=\"checked\"";} ?> name="type" type="radio" id="type_2" value="closed"> Closed
  <input  <?php if (!(strcmp($type,""))) {echo "checked=\"checked\"";} ?> name="type" type="radio" id="type_3" value=""> Both
  </div><br /><br />

  <input name="submit" type="submit" id="submit" value="Search"  class="form-control btn-primary">
<br /><br />
</form>
      	</div>
    	<div class="col-md-5">
<?php if ($totalRows_rsView > 0) { // Show if recordset not empty ?>
<ul class="media-list"> 
	<?php do { ?>
	<li class="media"> 
    	<div class="media-left"> <a href="detail.php?religion_id=<?php echo $row_rsView['religion_id']; ?>"> <img alt="64x64" class="media-object" src="<?php echo $row_rsView['religion_image']; ?>" style="max-width: 100px;"> </a> 
       	</div> 
        <div class="media-body"> 
            <h4 class="media-heading"><a href="detail.php?religion_id=<?php echo $row_rsView['religion_id']; ?>"><?php echo $row_rsView['religion_name']; ?></a></h4> 
            <p class="truncate"><?php echo nl2br($row_rsView['religion_description']); ?></p> 
            <div class="media"> 
            	<div class="media-body"> 
            		<h4 class="media-heading">Actions</h4> 
            		<p><?php echo ucwords($row_rsView['religion_type']); ?> Religion<?php if (!empty($_SESSION['MM_UserId'])) { ?>
                    	 | <?php if (!empty($row_rsView['follower_id'])) { ?>
                          Following (<a href="unfollow_religion.php?religion_id=<?php echo $row_rsView['religion_id']; ?>">UnFollow</a>)
                          <?php } else { ?>
                          <a href="follow_religion.php?religion_id=<?php echo $row_rsView['religion_id']; ?>">Follow</a>
                          <?php } ?>
                      <?php } ?>
                     </p>
                 
              	</div> 
            </div> 
            
		</div> 
	</li>
    <?php } while ($row_rsView = mysql_fetch_assoc($rsView)); ?> 
</ul>

  <p> Records <?php echo ($startRow_rsView + 1) ?> to <?php echo min($startRow_rsView + $maxRows_rsView, $totalRows_rsView) ?> of <?php echo $totalRows_rsView ?>
  <table border="0" width="50%" align="center">
    <tr>
      <td width="23%" align="center"><?php if ($pageNum_rsView > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_rsView=%d%s", $currentPage, 0, $queryString_rsView); ?>">First</a>
            <?php } // Show if not first page ?>
      </td>
      <td width="31%" align="center"><?php if ($pageNum_rsView > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_rsView=%d%s", $currentPage, max(0, $pageNum_rsView - 1), $queryString_rsView); ?>">Previous</a>
            <?php } // Show if not first page ?>
      </td>
      <td width="23%" align="center"><?php if ($pageNum_rsView < $totalPages_rsView) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_rsView=%d%s", $currentPage, min($totalPages_rsView, $pageNum_rsView + 1), $queryString_rsView); ?>">Next</a>
            <?php } // Show if not last page ?>
      </td>
      <td width="23%" align="center"><?php if ($pageNum_rsView < $totalPages_rsView) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_rsView=%d%s", $currentPage, $totalPages_rsView, $queryString_rsView); ?>">Last</a>
            <?php } // Show if not last page ?>
      </td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?></p>
<?php if ($totalRows_rsView == 0) { // Show if recordset empty ?>
  <p>No Religion Available.</p>
  <?php } // Show if recordset empty ?>
        
        </div>
    	<div class="col-md-4"></div>
    </div>
  
</div>
<!-- InstanceEndEditable -->

</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsView);
?>
