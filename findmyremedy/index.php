<?php
session_start();


if (!empty($_GET['refid'])) {
	//save in the cookie
	setcookie('refid', $_GET['refid'], time() + (60 * 60 * 24 * 365), '/');
}

?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/findmyremedy.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>display</title>
<!-- InstanceEndEditable -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">

<script src="js/jquery-3.2.1.min.js"></script>

<script src="js/bootstrap.min.js"></script>

<script src="js/firebase.js"></script>
<script src="js/script.js"></script>
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>

<body>
<?php include('nav.php'); ?>

<!-- InstanceBeginEditable name="EditRegion3" -->
<p>body</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>