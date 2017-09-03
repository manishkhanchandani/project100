<?php require_once('../../Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

try {
	$return['status'] = 1;
	$_SESSION['MM_Username'] = NULL;
	$_SESSION['MM_UserGroup'] = NULL;
	$_SESSION['MM_UserId'] = NULL;
	$_SESSION['MM_DisplayName'] = NULL;
	$_SESSION['MM_ProfileImg'] = NULL;
	$_SESSION['MM_UID'] = NULL;
	$_SESSION['MM_LoggedInTime'] = NULL;
	$_SESSION['MM_ProfileUID'] = NULL;
	unset($_SESSION['MM_Username']);
	unset($_SESSION['MM_UserGroup']);
	unset($_SESSION['MM_UserId']);
	unset($_SESSION['MM_DisplayName']);
	unset($_SESSION['MM_ProfileImg']);
	unset($_SESSION['MM_UID']);
	unset($_SESSION['MM_LoggedInTime']);
	unset($_SESSION['MM_ProfileUID']);
	
} catch (Exception $e) {
	$return['status'] = 0;
	$return['error_message'] = $e->getMessage();
	$return['error'] = $e->getCode();
}

echo json_encode($return);
?>