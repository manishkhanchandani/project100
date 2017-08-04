<?php require_once('../Connections/conn.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsView = 25;
$pageNum_rsView = 0;
if (isset($_GET['pageNum_rsView'])) {
  $pageNum_rsView = $_GET['pageNum_rsView'];
}
$startRow_rsView = $pageNum_rsView * $maxRows_rsView;

mysql_select_db($database_conn, $conn);
$query_rsView = "SELECT * FROM religions WHERE religion_status = 1";
$query_limit_rsView = sprintf("%s LIMIT %d, %d", $query_rsView, $startRow_rsView, $maxRows_rsView);
$rsView = mysql_query($query_limit_rsView, $conn) or die(mysql_error());
$row_rsView = mysql_fetch_assoc($rsView);

if (isset($_GET['totalRows_rsView'])) {
  $totalRows_rsView = $_GET['totalRows_rsView'];
} else {
  $all_rsView = mysql_query($query_rsView);
  $totalRows_rsView = mysql_num_rows($all_rsView);
}
$totalPages_rsView = ceil($totalRows_rsView/$maxRows_rsView)-1;

$queryString_rsView = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsView") == false && 
        stristr($param, "totalRows_rsView") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsView = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsView = sprintf("&totalRows_rsView=%d%s", $totalRows_rsView, $queryString_rsView);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<p>Religions</p>
<p>&nbsp; </p>

<?php if ($totalRows_rsView > 0) { // Show if recordset not empty ?>
  <table border="1">
    <tr>
      <td valign="top">religion_id</td>
      <td valign="top">user_id</td>
      <td valign="top">religion_name</td>
      <td valign="top">religion_description</td>
      <td valign="top">religion_creation_dt</td>
      <td valign="top">religion_status</td>
      <td valign="top">Views / Opinion / Issues / Ideas </td>
      <td valign="top">Add New Views </td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="top"><?php echo $row_rsView['religion_id']; ?></td>
        <td valign="top"><?php echo $row_rsView['user_id']; ?></td>
        <td valign="top"><?php echo $row_rsView['religion_name']; ?></td>
        <td valign="top"><?php echo $row_rsView['religion_description']; ?></td>
        <td valign="top"><?php echo $row_rsView['religion_creation_dt']; ?></td>
        <td valign="top"><?php echo $row_rsView['religion_status']; ?></td>
        <td valign="top"><a href="views.php?religion_id=<?php echo $row_rsView['religion_id']; ?>">Views</a></td>
        <td valign="top"><a href="views_new.php?religion_id=<?php echo $row_rsView['religion_id']; ?>">Create New Views</a></td>
      </tr>
      <?php } while ($row_rsView = mysql_fetch_assoc($rsView)); ?>
  </table>
  <p> Records <?php echo ($startRow_rsView + 1) ?> to <?php echo min($startRow_rsView + $maxRows_rsView, $totalRows_rsView) ?> of <?php echo $totalRows_rsView ?>
  <table border="0" width="50%" align="center">
    <tr>
      <td width="23%" align="center"><?php if ($pageNum_rsView > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_rsView=%d%s", $currentPage, 0, $queryString_rsView); ?>">First</a>
            <?php } // Show if not first page ?>
      </td>
      <td width="31%" align="center"><?php if ($pageNum_rsView > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_rsView=%d%s", $currentPage, max(0, $pageNum_rsView - 1), $queryString_rsView); ?>">Previous</a>
            <?php } // Show if not first page ?>
      </td>
      <td width="23%" align="center"><?php if ($pageNum_rsView < $totalPages_rsView) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_rsView=%d%s", $currentPage, min($totalPages_rsView, $pageNum_rsView + 1), $queryString_rsView); ?>">Next</a>
            <?php } // Show if not last page ?>
      </td>
      <td width="23%" align="center"><?php if ($pageNum_rsView < $totalPages_rsView) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_rsView=%d%s", $currentPage, $totalPages_rsView, $queryString_rsView); ?>">Last</a>
            <?php } // Show if not last page ?>
      </td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?></p>
<?php if ($totalRows_rsView == 0) { // Show if recordset empty ?>
  <p>No Religion Available.</p>
  <?php } // Show if recordset empty ?></body>
</html>
<?php
mysql_free_result($rsView);
?>
