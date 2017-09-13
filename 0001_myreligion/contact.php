<?php 
if (!isset($_SESSION)) {
  session_start();
}

include('siteInformation.php');
?>
<?php

//if page will load, there is not post data, and so user will not go inside the following if condition
//but when user clicks submit button, then the post variable will be available and we can send email at that time.
if (!empty($_POST)) {
	$message = "Dear Admin,
User with name '{$_POST['name']}'	
and email '{$_POST['email']}'
has sent following message:

{$_POST['message']}


Thanks
System Generated.
";
	mail('manishkk74@gmail.com', 'New Contact Message at LifeReminder.tk', $message, 'From:admin<admin@lifereminder.tk>');
	
	$status = 'Message Submitted';
}
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/myReligion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>My Religion :: Contact Us</title>
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
<section class="section-title">
	<div class="container">
		<h1>Contact <small>Get In Touch</small></h1>
	</div>
</section>


<section class="section-breadcrumb">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active">Contact Us</li>
				</ol>
			</div>
		</div>
	</div>
</section>
<section class="section-main">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<?php if (!empty($status)) { ?>
				<div class="alert alert-success" role="alert"><?php echo $status; ?></div>
				<?php } ?>
				<iframe
				  height="450"
				  frameborder="0" style="border:0; min-width: 100%"
				  src="http://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=37.0625,-95.677068&amp;spn=56.506174,79.013672&amp;t=m&amp;z=4&amp;output=embed" allowfullscreen>
				</iframe>
				<h3>Contact Us Today!</h3>
				<form method="post">
                  <div class="form-group">
                    <label>Name</label>
                    <input name="name" type="text" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Email address</label>
                    <input name="email" type="email" class="form-control">
                  </div>
                    <div class="form-group">
                    <label>Message</label>
                   <textarea name="message" class="form-control"></textarea>
                  </div>
                  <button type="submit" class="btn btn-default">Submit</button>
              </form>
			</div>
			<div class="col-md-4">
				<h3>Contact Details</h3>
				<p><?php echo $row_rsSiteInformation['site_address']; ?></p>
				<p><i class="fa fa-phone"></i> : <?php echo $row_rsSiteInformation['site_phone']; ?></p>
				<p><i class="fa fa-envelope"></i> : <a href="mailto: <?php echo $row_rsSiteInformation['site_email']; ?>">Email Us</a></p>
				<p><i class="fa fa-clock-o"></i> : <?php echo $row_rsSiteInformation['site_timings']; ?></p>
			</div>
		</div>
	</div>
</section>

<!-- InstanceEndEditable -->

</body>
<!-- InstanceEnd --></html>