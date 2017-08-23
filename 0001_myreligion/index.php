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
<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<style type="text/css">
	h1, h2, h3 {
		font-family: 'Oswald', sans-serif;
	}
	
	.jumbotron {
		min-height: 390px;
		background-image: url('<?php echo $row_rsSiteInformation['site_background_img']; ?>');
		background-size: cover;
    	background-repeat: no-repeat;
		
	}
	
	.jumbotron h1 {
		color: #ffffff;
		font-size: 55px;
	}
	.jumbotron p {
		color: #ffffff;
		padding-top: 10px;
	}
	.jumbotron p a {
		display: block;
    	width: 145px;
		margin-top: 20px;
	}
	
	.section-gray {
		background-color: #f4f4f4;
	}
	
	.fa-color {
		color: #0383c0;
	}
	
</style>
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
                <li><a href="#">Login</a></li>
                <li><a href="#">Register as New User</a></li>
                <li><a href="#">Logout</a></li>
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
					<a href="about.php" class="btn btn-primary btn-lg">Find out more</a>
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

<section>

</section>

<section>

</section>


<section>

</section>

<!-- InstanceEndEditable -->

</body>
<!-- InstanceEnd --></html>