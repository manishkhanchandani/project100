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
?><?php
$currentPage = $_SERVER["PHP_SELF"];
?>
<?php
$maxRows_rsMyReligions = 10;
$pageNum_rsMyReligions = 0;
if (isset($_GET['pageNum_rsMyReligions'])) {
  $pageNum_rsMyReligions = $_GET['pageNum_rsMyReligions'];
}
$startRow_rsMyReligions = $pageNum_rsMyReligions * $maxRows_rsMyReligions;

$colname_rsMyReligions = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $colname_rsMyReligions = (get_magic_quotes_gpc()) ? $_SESSION['MM_UserId'] : addslashes($_SESSION['MM_UserId']);
}
mysql_select_db($database_conn, $conn);
$query_rsMyReligions = sprintf("SELECT * FROM religions WHERE user_id = %s AND religion_status < 3", $colname_rsMyReligions);
$query_limit_rsMyReligions = sprintf("%s LIMIT %d, %d", $query_rsMyReligions, $startRow_rsMyReligions, $maxRows_rsMyReligions);
$rsMyReligions = mysql_query($query_limit_rsMyReligions, $conn) or die(mysql_error());
$row_rsMyReligions = mysql_fetch_assoc($rsMyReligions);

if (isset($_GET['totalRows_rsMyReligions'])) {
  $totalRows_rsMyReligions = $_GET['totalRows_rsMyReligions'];
} else {
  $all_rsMyReligions = mysql_query($query_rsMyReligions);
  $totalRows_rsMyReligions = mysql_num_rows($all_rsMyReligions);
}
$totalPages_rsMyReligions = ceil($totalRows_rsMyReligions/$maxRows_rsMyReligions)-1;

$queryString_rsMyReligions = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsMyReligions") == false && 
        stristr($param, "totalRows_rsMyReligions") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsMyReligions = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsMyReligions = sprintf("&totalRows_rsMyReligions=%d%s", $totalRows_rsMyReligions, $queryString_rsMyReligions);
?><!doctype html>
<html><!-- InstanceBegin template="/Templates/myReligion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>My Religions</title>
<!-- InstanceEndEditable -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">

<script src="js/jquery-3.2.1.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


<script src="js/firebase.js"></script>
<script src="js/script.js"></script>
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
 <h1>My Religions</h1>
  <?php if ($totalRows_rsMyReligions > 0) { // Show if recordset not empty ?>
  <div class="table-responsive">
	    <table class="table table-striped">

    <tr>
      <td><strong>Religion Name </strong></td>
      <td><strong>Description</strong></td>
      <td><strong>Created Date </strong></td>
      <td><strong>Religion Status </strong></td>
      <td><strong>Edit Religion</strong> </td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_rsMyReligions['religion_name']; ?></td>
        <td><?php echo $row_rsMyReligions['religion_description']; ?></td>
        <td><?php echo $row_rsMyReligions['religion_creation_dt']; ?></td>
        <td><?php switch($row_rsMyReligions['religion_status']) {
			case 0:
				echo 'Pending';
				break;
			case 1:
				echo 'Approved';
				break;
			case 2:
				echo 'Blocked';
				break;
			default:
				echo '';
				break;
		} ?></td>
        <td><a href="my_religion_edit.php?religion_id=<?php echo $row_rsMyReligions['religion_id']; ?>">Edit</a></td>
      </tr>
      <?php } while ($row_rsMyReligions = mysql_fetch_assoc($rsMyReligions)); ?>
  </table>
  <p> Records <?php echo ($startRow_rsMyReligions + 1) ?> to <?php echo min($startRow_rsMyReligions + $maxRows_rsMyReligions, $totalRows_rsMyReligions) ?> of <?php echo $totalRows_rsMyReligions ?></p>
  <table border="0" width="50%" align="center">
    <tr>
      <td width="23%" align="center"><?php if ($pageNum_rsMyReligions > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsMyReligions=%d%s", $currentPage, 0, $queryString_rsMyReligions); ?>">First</a>
          <?php } // Show if not first page ?>      </td>
      <td width="31%" align="center"><?php if ($pageNum_rsMyReligions > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsMyReligions=%d%s", $currentPage, max(0, $pageNum_rsMyReligions - 1), $queryString_rsMyReligions); ?>">Previous</a>
          <?php } // Show if not first page ?>      </td>
      <td width="23%" align="center"><?php if ($pageNum_rsMyReligions < $totalPages_rsMyReligions) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsMyReligions=%d%s", $currentPage, min($totalPages_rsMyReligions, $pageNum_rsMyReligions + 1), $queryString_rsMyReligions); ?>">Next</a>
          <?php } // Show if not last page ?>      </td>
      <td width="23%" align="center"><?php if ($pageNum_rsMyReligions < $totalPages_rsMyReligions) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsMyReligions=%d%s", $currentPage, $totalPages_rsMyReligions, $queryString_rsMyReligions); ?>">Last</a>
          <?php } // Show if not last page ?>      </td>
    </tr>
</table>
</div>
  <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_rsMyReligions == 0) { // Show if recordset empty ?>
  <p>No Religion Found. </p>
    <?php } // Show if recordset empty ?>
	
	
</div>
	
	<!-- InstanceEndEditable -->

</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsMyReligions);
?>
