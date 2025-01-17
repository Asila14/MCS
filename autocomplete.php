<?php

include 'includes/connect.php';

if (isset($_POST['process_name'])) {
  $process_name = $_POST['process_name'];

  $sql = "SELECT * FROM process WHERE process_name LIKE '%$process_name%'";
  $result = sqlsrv_query($con,$sql) or die('Database connection error');

  $data = array();
  while ($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
  }

  echo json_encode($data);
}

?>
