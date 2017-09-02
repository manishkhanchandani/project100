<?php require_once('../../Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

include('../../functions.php');

$refreshToken = "APRrRCI9jzNQB16MVKadmgbnJ7c8LZyoTZE-Cia7uPCVp8RlFhLxfGzMelnm7YqHFoxJmB-7DRDFRcr4tCCo-ysHFCqNY0i7Gehx7nosN9y679eO6S338VPM6bEcv1x-cTK-vwMeR084sA0bnjVFCk1pTNXQGL2zIosF4zHlM4WkNX3iVBLiKtiLglb8YUdB7HMH_RQ1ND6iXAyN4SvlrQqklJM4SvVoRvHnIlYdOmwwfHoftzpF5FOlzAbwPV_8OQ1Hq-0YAfSx9T595ukIutZXVkrCcPPkYtVDOArrbCSOH2Cj2veq7T9niDCL2AlsnJsZdRrSlCP6iXGc6UWFgk3f9oEPDgkny_YATkge4olhq8I7dDSRoa-kTwTJ9wfADbw2fVMH3dPONLk1rd3RRXu7Wy7Y27RREWbPGVxLO0q1tlbOXlYYcmJsjD1GDZu69cZe_8Y034MKpkuTDdvEbcV22yy_2NyhGQ";

$url = 'https://securetoken.googleapis.com/v1/token?key=AIzaSyBhpHK-ve2s0ynnr8og8Zx0S69ttEFpDKk';

$params = array('grant_type' => 'refresh_token', 'refresh_token' => $refreshToken);
$postParams = json_encode($params);

$result = curlpostjson($url, $postParams);
$output = json_decode($result['output'], true);

pr($output['user_id']);

//if it is some


?>