<?php 
include('siteInformation.php');
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/myReligion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>My Religion</title>
<!-- InstanceEndEditable -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- InstanceBeginEditable name="head" -->
<?php include('customCSS.php'); ?>
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
                <li><a href="users/login.php">Login</a></li>
                <li><a href="users/register.php">Register as New User</a></li>
				<?php } ?>
				<?php if (!empty($_SESSION['MM_UserId'])) { ?>
                <li><a href="users/logout.php">Logout</a></li>
				<?php } ?>
              </ul>
            </li>
			
			
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admins <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="admin/religions.php">Religions (Approve / Block)</a></li>
                <li><a href="admin/views.php">Verses (Approve / Block)</a></li>
				
              </ul>
            </li>
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