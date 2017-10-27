<?php 
if (!isset($_SESSION)) {
  session_start();
}
include('siteInformation.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/massage.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Untitled Document</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>

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
          <a class="navbar-brand" href="index.php">Massage Exchange</a>
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
<section class="jumbotron">
	<div class="container">
		<div class="row">
			<div class="col-md-7">
				<h1><?php echo $row_rsSiteInformation['site_title']; ?></h1>
				<p class="lead"><?php echo $row_rsSiteInformation['site_subtitle']; ?>
					<a href="home.php" class="btn btn-primary btn-lg">Browse Religions</a>
				</p>
			</div>
			<div class="col-md-5">
			</div>
		</div>
	</div>
</section>
<section class="section-gray">
	<div class="container">
		<div class="row">
			<div class="col-md-3 text-center">
				<span class="fa-stack fa-lg fa-4x">
				  <i class="fa fa-circle fa-stack-2x fa-color"></i>
				  <i class="fa <?php echo $row_rsSiteInformation['site_icon1']; ?> fa-stack-1x fa-inverse"></i>
				</span>
				<h3><?php echo $row_rsSiteInformation['site_icon1_title']; ?></h3>
				<p><?php echo $row_rsSiteInformation['site_icon1_desc']; ?></p>
			</div>
			<div class="col-md-3 text-center">
				<span class="fa-stack fa-lg fa-4x">
				  <i class="fa fa-circle fa-stack-2x fa-color"></i>
				  <i class="fa <?php echo $row_rsSiteInformation['site_icon2']; ?> fa-stack-1x fa-inverse"></i>
				</span>
				<h3><?php echo $row_rsSiteInformation['site_icon2_title']; ?></h3>
				<p><?php echo $row_rsSiteInformation['site_icon2_desc']; ?></p>
			</div>
			<div class="col-md-3 text-center">
				<span class="fa-stack fa-lg fa-4x">
				  <i class="fa fa-circle fa-stack-2x fa-color"></i>
				  <i class="fa <?php echo $row_rsSiteInformation['site_icon3']; ?> fa-stack-1x fa-inverse"></i>
				</span>
				<h3><?php echo $row_rsSiteInformation['site_icon3_title']; ?></h3>
				<p><?php echo $row_rsSiteInformation['site_icon3_desc']; ?></p>
			</div>
			<div class="col-md-3 text-center">
				<span class="fa-stack fa-lg fa-4x">
				  <i class="fa fa-circle fa-stack-2x fa-color"></i>
				  <i class="fa <?php echo $row_rsSiteInformation['site_icon4']; ?> fa-stack-1x fa-inverse"></i>
				</span>
				<h3><?php echo $row_rsSiteInformation['site_icon4_title']; ?></h3>
				<p><?php echo $row_rsSiteInformation['site_icon4_desc']; ?></p>
			</div>
		</div>
	</div>
</section>

<section class="section-secondary slogan text-center">
	<h1><?php echo $row_rsSiteInformation['site_sec_title']; ?></h1>
	<p><?php echo $row_rsSiteInformation['site_sec_desc']; ?></p>
	<a href="<?php echo $row_rsSiteInformation['site_sec_link']; ?>" class="btn btn-lg btn-default">More Info</a>
</section>

<section>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2 class="page-header"><?php echo $row_rsSiteInformation['site_default_title']; ?></h2>
				<?php echo $row_rsSiteInformation['site_default_desc']; ?>
			</div>
			<div class="col-md-6">
				<img src="<?php echo $row_rsSiteInformation['site_default_image']; ?>" class="img-responsive" />
			</div>
		</div>
	</div>
</section>


<section class="section-primary">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<img src="<?php echo $row_rsSiteInformation['site_primary_image']; ?>" class="img-responsive img-circle" />
			</div>
			<div class="col-md-6">
				<h2 class="page-header"><?php echo $row_rsSiteInformation['site_primary_title']; ?></h2>
				<?php echo $row_rsSiteInformation['site_primary_desc']; ?>
				
				
			</div>
		</div>
	</div>
</section>
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
