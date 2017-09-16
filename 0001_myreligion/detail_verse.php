<?php require_once('../Connections/conn.php'); ?>
<?php
$colname_rsVerse = "-1";
if (isset($_GET['view_id'])) {
  $colname_rsVerse = (get_magic_quotes_gpc()) ? $_GET['view_id'] : addslashes($_GET['view_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsVerse = sprintf("SELECT * FROM religions_view WHERE view_id = %s", $colname_rsVerse);
$rsVerse = mysql_query($query_rsVerse, $conn) or die(mysql_error());
$row_rsVerse = mysql_fetch_assoc($rsVerse);
$totalRows_rsVerse = mysql_num_rows($rsVerse);



$images = json_decode($row_rsVerse['view_images'], true);
$videos = json_decode($row_rsVerse['view_videos'], true); 
$links = json_decode($row_rsVerse['view_links'], true); 


?><!doctype html>
<html><!-- InstanceBegin template="/Templates/myReligion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Detail Verse Page</title>
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
<h1 class="page-header">Detail Verse</h1>
<div class="row">
	<div class="col-md-7">
		<div><?php echo $row_rsVerse['view_description']; ?></div>
	</div>
	<div class="col-md-5">
		<img src="<?php echo $images[0]; ?>" class="img-responsive" />
	</div>
</div>

<?php if (!empty($images)) { ?>
<h3 class="page-header">Images</h3>
<div class="row">
	<?php
	foreach ($images as $k => $v) {
	?>
		<div class="col-md-3"><img src="<?php echo $v; ?>" class="img-responsive" /></div>
	<?php
	}
	?>
</div>
<?php } ?>
<?php if (!empty($videos)) { ?>
<h3 class="page-header">Videos</h3><div class="row">
	<?php
	foreach ($videos as $k => $v) {
	?>
		<div class="col-md-4">
			<div class="embed-responsive embed-responsive-16by9">
			  <iframe class="embed-responsive-item" src="<?php echo str_replace('watch?v=', 'embed/', $v); ?>" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
	<?php
	}
	?>
</div>
<?php } ?>
<?php if (!empty($links)) { ?>
<h3 class="page-header">Links</h3>
	<div class="list-group">
		<?php
			foreach ($links as $k => $v) {
			?>
	  <a href="<?php echo $v; ?>" class="list-group-item" target="_blank"><?php echo $v; ?></a>
	  <?php
		}
	?>
	</div>
</div>
<?php } ?>
<!-- InstanceEndEditable -->

</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsVerse);
?>