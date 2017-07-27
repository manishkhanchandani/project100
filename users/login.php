<?php require_once('../Connections/conn.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}


$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {
  $loginUsername=$_POST['email'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "access_level";
  $MM_redirectLoginSuccess = "login_success.php";
  $MM_redirectLoginFailed = "login_failure.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_conn, $conn);
  	
  $LoginRS__query=sprintf("SELECT email, password, access_level, user_id, display_name, profile_img, uid, logged_in_time, profile_uid FROM users_auth WHERE email='%s' AND password='%s'",
  get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $conn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'access_level');
    $user_id  = mysql_result($LoginRS,0,'user_id');
    $display_name  = mysql_result($LoginRS,0,'display_name');
    $profile_img  = mysql_result($LoginRS,0,'profile_img');
    $uid  = mysql_result($LoginRS,0,'uid');
    $logged_in_time  = mysql_result($LoginRS,0,'logged_in_time');
    $profile_uid  = mysql_result($LoginRS,0,'profile_uid');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	
	$_SESSION['MM_UserId'] = $user_id;
	$_SESSION['MM_DisplayName'] = $display_name;
	$_SESSION['MM_ProfileImg'] = $profile_img;
	$_SESSION['MM_UID'] = $uid;
	$_SESSION['MM_LoggedInTime'] = $logged_in_time;
	$_SESSION['MM_ProfileUID'] = $profile_uid; 

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>display</title>
</head>

<body>
<h1>Login</h1>
<form name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  <table>
    <tr valign="baseline">
      <td nowrap align="right">Email:</td>
      <td><input type="text" name="email" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Password:</td>
      <td><input type="password" name="password" value="" size="32"></td>
    </tr>

    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input name="submit" type="submit" value="Login"></td>
    </tr>
  </table>
</form>
<p>&nbsp; </p>
</body>
</html>