<?php require_once('../../Connections/conn.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsReligions = 10;
$pageNum_rsReligions = 0;
if (isset($_GET['pageNum_rsReligions'])) {
  $pageNum_rsReligions = $_GET['pageNum_rsReligions'];
}
$startRow_rsReligions = $pageNum_rsReligions * $maxRows_rsReligions;

mysql_select_db($database_conn, $conn);
$query_rsReligions = "SELECT * FROM religions";
$query_limit_rsReligions = sprintf("%s LIMIT %d, %d", $query_rsReligions, $startRow_rsReligions, $maxRows_rsReligions);
$rsReligions = mysql_query($query_limit_rsReligions, $conn) or die(mysql_error());
$row_rsReligions = mysql_fetch_assoc($rsReligions);

if (isset($_GET['totalRows_rsReligions'])) {
  $totalRows_rsReligions = $_GET['totalRows_rsReligions'];
} else {
  $all_rsReligions = mysql_query($query_rsReligions);
  $totalRows_rsReligions = mysql_num_rows($all_rsReligions);
}
$totalPages_rsReligions = ceil($totalRows_rsReligions/$maxRows_rsReligions)-1;

$queryString_rsReligions = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsReligions") == false && 
        stristr($param, "totalRows_rsReligions") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsReligions = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsReligions = sprintf("&totalRows_rsReligions=%d%s", $totalRows_rsReligions, $queryString_rsReligions);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<p>Religions</p>
<p>Pending | Approved | Blocked | All</p>
<table border="1">
  <tr>
    <td>religion_id</td>
    <td>user_id</td>
    <td>religion_name</td>
    <td>religion_description</td>
    <td>religion_creation_dt</td>
    <td>religion_status</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsReligions['religion_id']; ?></td>
      <td><?php echo $row_rsReligions['user_id']; ?></td>
      <td><?php echo $row_rsReligions['religion_name']; ?></td>
      <td><?php echo $row_rsReligions['religion_description']; ?></td>
      <td><?php echo $row_rsReligions['religion_creation_dt']; ?></td>
      <td><?php echo $row_rsReligions['religion_status']; ?></td>
    </tr>
    <?php } while ($row_rsReligions = mysql_fetch_assoc($rsReligions)); ?>
</table>
<p> Records <?php echo ($startRow_rsReligions + 1) ?> to <?php echo min($startRow_rsReligions + $maxRows_rsReligions, $totalRows_rsReligions) ?> of <?php echo $totalRows_rsReligions ?>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_rsReligions > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rsReligions=%d%s", $currentPage, 0, $queryString_rsReligions); ?>">First</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_rsReligions > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rsReligions=%d%s", $currentPage, max(0, $pageNum_rsReligions - 1), $queryString_rsReligions); ?>">Previous</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_rsReligions < $totalPages_rsReligions) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rsReligions=%d%s", $currentPage, min($totalPages_rsReligions, $pageNum_rsReligions + 1), $queryString_rsReligions); ?>">Next</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_rsReligions < $totalPages_rsReligions) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rsReligions=%d%s", $currentPage, $totalPages_rsReligions, $queryString_rsReligions); ?>">Last</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
</p>
</body>
</html>
<?php
mysql_free_result($rsReligions);
?>
