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

	include('../../functions.php');
	$return = array();

	$return['success'] = 1;
	
	$post = file_get_contents('php://input');
	$userData = json_decode($post, true);//true is use to make it in array, else it will object	

	/*$userData = array();
	$userData['displayName'] = 'Manish Khanchandani 2';
	$userData['email'] = 'manishkk74@gmail.com';
	$userData['photoURL'] = 'https://lh6.googleusercontent.com/-nLg0dFRo0DQ/AAAAAAAAAAI/AAAAAAAArjM/wWzo9wl_lFM/photo.jpg';
	$userData['profileUID'] = '112913147917981568678';
	$userData['provider_id'] = 'google.com';
	$userData['refreshToken'] = 'APRrRCKkVmq3FGpHiYfzZd0XKkO_Ql6P3-7-xykM9Dv8ZdUukUqbUaJLCq6M8LQ64o3FHQig6fUjXFjF4vXdGVU6QXgVoaw6tMeYRLgHwzQtwgzZDPlcDvOfxYCAiF750nzYzxMMdZ4E2aSkEH8LmLHqpcr_GCZYUa7wXT7mi5m9xBPyhzBEhKY4sXjisWeE_Q7SByiv35L4aim7K2pUcfs4jHjUlaWa_EdsYbjBAMBrBSbU01WQpPg34Xslr8kMnn5-VIYQYpZGzYPVTAiIfc_clkeYOmFFMFplX4TlmxYKcv72PShV6s_jurYsGnvQJA55iNPkAKh0kxEw95v1GEzTn6Z2P_P3EpOl1aXx9U9Gv1p3R5sT6v-J6DfJgSha-GXVoh3J0skR';
	$userData['uid'] = 'W5F3YbU9OTdrDccldzyEnulJp3G2';*/
	
	//VERIFICATON PROCESS STARTED AND HERE I AM VERIFYING REFRESH TOKEN FROM FRONT END WITH FIREBASE BACKEND
	$refreshToken = $userData['refreshToken'];
	$uid = $userData['uid'];
	
	$url = 'https://securetoken.googleapis.com/v1/token?key=AIzaSyBhpHK-ve2s0ynnr8og8Zx0S69ttEFpDKk';
	
	$params = array('grant_type' => 'refresh_token', 'refresh_token' => $refreshToken);
	$postParams = json_encode($params);
	
	$result = curlpostjson($url, $postParams);
	$output = json_decode($result['output'], true);
	
	if (empty($output['user_id'])) {
		throw new Exception('no valid user');
	}
	
	if ($uid != $output['user_id']) {
		throw new Exception('invalid user');
	}
	//VERIFICATON PROCESS ENDED AND HERE I AM VERIFYING REFRESH TOKEN FROM FRONT END WITH FIREBASE BACKEND
	
	//i HAVE TO CHECK IF THIS USE IS IN MY DATABASE

$colname_rsUserExist = "-1";
if (isset($uid)) {
  $colname_rsUserExist = (get_magic_quotes_gpc()) ? $uid : addslashes($uid);
}
mysql_select_db($database_conn, $conn);
$query_rsUserExist = sprintf("SELECT * FROM users_auth WHERE uid = '%s'", $colname_rsUserExist);
$rsUserExist = mysql_query($query_rsUserExist, $conn) or die(mysql_error());
$row_rsUserExist = mysql_fetch_assoc($rsUserExist);
$totalRows_rsUserExist = mysql_num_rows($rsUserExist);

	
		// THE USER WILL BE IN MY DATABASE - YES
		if ($totalRows_rsUserExist > 0) {
			//UPDATE THE VALUE IN THE DATABASE
			$updateSQL = sprintf("UPDATE users_auth SET display_name=%s, profile_img=%s, email=%s, logged_in_time=%s WHERE user_id=%s",
                       GetSQLValueString($userData['displayName'], "text"),
                       GetSQLValueString($userData['photoURL'], "text"),
                       GetSQLValueString($userData['email'], "text"),
                       GetSQLValueString(time(), "int"),
                       GetSQLValueString($row_rsUserExist['user_id'], "int"));

			  mysql_select_db($database_conn, $conn);
			  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
		}
		
		// THE USER WILL NOT BE IN MY DATABASE - NO
		if ($totalRows_rsUserExist == 0) {
			//INSERT THE USER IN THE DATABASE
			 $insertSQL = sprintf("INSERT INTO users_auth (display_name, profile_img, email, provider_id, user_created_dt, uid, logged_in_time, profile_uid) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($userData['displayName'], "text"),
                       GetSQLValueString($userData['photoURL'], "text"),
                       GetSQLValueString($userData['email'], "text"),
                       GetSQLValueString($userData['provider_id'], "text"),
                       GetSQLValueString(date('Y-m-d H:i:s'), "date"),
                       GetSQLValueString($userData['uid'], "text"),
                       GetSQLValueString(time(), "int"),
                       GetSQLValueString($userData['profileUID'], "text"));

			  mysql_select_db($database_conn, $conn);
			  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
			  
			  	$colname_rsUserExist = "-1";
				if (isset($uid)) {
				  $colname_rsUserExist = (get_magic_quotes_gpc()) ? $uid : addslashes($uid);
				}
				mysql_select_db($database_conn, $conn);
				$query_rsUserExist = sprintf("SELECT * FROM users_auth WHERE uid = '%s'", $colname_rsUserExist);
				$rsUserExist = mysql_query($query_rsUserExist, $conn) or die(mysql_error());
				$row_rsUserExist = mysql_fetch_assoc($rsUserExist);
				$totalRows_rsUserExist = mysql_num_rows($rsUserExist);
		}

	unset($row_rsUserExist['password']);
	$return['user'] = $row_rsUserExist;
	
	$_SESSION['MM_Username'] = $row_rsUserExist['email'];
    $_SESSION['MM_UserGroup'] = $row_rsUserExist['access_level'];
	$_SESSION['MM_UserId'] = $row_rsUserExist['user_id'];
	$_SESSION['MM_DisplayName'] = $row_rsUserExist['display_name'];
	$_SESSION['MM_ProfileImg'] = $row_rsUserExist['profile_img'];
	$_SESSION['MM_UID'] = $row_rsUserExist['uid'];
	$_SESSION['MM_LoggedInTime'] = $row_rsUserExist['logged_in_time'];
	$_SESSION['MM_ProfileUID'] = $row_rsUserExist['profile_uid'];

} catch(Exception $e) {
	$return['success'] = 0;
	$return['error'] = $e->getMessage();
}
echo json_encode($return);

?>
