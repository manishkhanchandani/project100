<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php 
include('siteInformation.php');

$team = json_decode($row_rsSiteInformation['site_our_team'], true);
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/myReligion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>My Religion :: Our Team</title>
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
<section class="section-title">
	<div class="container">
		<h1>Our Team <small>Meet Our Developers</small></h1>
	</div>
	
	
	
</section>
<section>
	<div class="container">
		
		<div class="row">
			<?php foreach($team as $k => $developer) { ?>
			<div class="col-md-4">
				<img class="img-responsive img-thumbnail img-circle" src="<?php echo $developer['image']; ?>" />
				<h3><?php echo $developer['name']; ?> <small><?php echo $developer['designation']; ?></small></h3>
				<p><?php echo $developer['description']; ?></p>
				<ul class="list-unstyled list-inline list-social-icons">
					<li class="tooltip-social facebook-link"><a href="<?php echo $developer['fb']; ?>" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook-square fa-2x"></i></a></li>
					<li class="tooltip-social facebook-link"><a href="<?php echo $developer['ln']; ?>" data-toggle="tooltip" data-placement="top" title="LinkedIn"><i class="fa fa-linkedin-square fa-2x"></i></a></li>
					<li class="tooltip-social facebook-link"><a href="<?php echo $developer['tw']; ?>" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter-square fa-2x"></i></a></li>
					<li class="tooltip-social facebook-link"><a href="<?php echo $developer['gp']; ?>" data-toggle="tooltip" data-placement="top" title="Google Plus"><i class="fa fa-google-plus-square fa-2x"></i></a></li>
				</ul>
			</div>
			<?php } ?>
		</div>
	</div>
</section>

<!-- InstanceEndEditable -->

</body>
<!-- InstanceEnd --></html>