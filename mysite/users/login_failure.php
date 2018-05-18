<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/mysite.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Login Failure</title>
<!-- InstanceEndEditable -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">

<script src="../js/jquery-3.2.1.min.js"></script>

<script src="../js/bootstrap.min.js"></script>

<script src="../js/firebase.js"></script>
<script src="../js/script.js"></script>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
</head>

<body>
<?php include('../nav.php'); ?>

<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="container">
<p>Login Failed </p>
<p>Email and password does not match, please go back and change it. </p>
</div>
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>