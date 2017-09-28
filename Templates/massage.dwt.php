<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>Untitled Document</title>
<!-- TemplateEndEditable -->
<link rel="stylesheet" href="../002_massageexchange/css/bootstrap.min.css">
<link rel="stylesheet" href="../002_massageexchange/css/style.css">

<script src="../002_massageexchange/js/jquery-3.2.1.min.js"></script>
<script src="../002_massageexchange/js/bootstrap.min.js"></script>

<script src="../002_massageexchange/js/firebase.js"></script>
<script src="../002_massageexchange/js/script.js"></script>
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
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
          <a class="navbar-brand" href="../002_massageexchange/index.php">Massage Exchange</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="../002_massageexchange/home.php">Home</a></li>
            <li><a href="../002_massageexchange/team.php">Our Team</a></li>
            <li><a href="../002_massageexchange/about.php">About</a></li>
            <li><a href="../002_massageexchange/contact.php">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Religions <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="../002_massageexchange/create_religion.php">Create New Religion</a></li>
                <li><a href="../002_massageexchange/home.php">Browse All Religions</a></li>
                <li><a href="../002_massageexchange/my_religions.php">My Created Religions</a></li>
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
                <li><a href="../002_massageexchange/admin/religions.php">Religions (Approve / Block)</a></li>
                <li><a href="../002_massageexchange/admin/views.php">Verses (Approve / Block)</a></li>
                <li><a href="../002_massageexchange/admin/site.php">Site Information</a></li>
				
				
              </ul>
            </li>
			<?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<!-- TemplateBeginEditable name="EditRegion3" -->
<p>body</p>
<!-- TemplateEndEditable -->
</body>
</html>
