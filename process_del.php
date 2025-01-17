<?php
include 'includes/connect.php';
$sql = "DELETE FROM process WHERE process_id='" . $_GET["process_id"] . "'";
if (sqlsrv_query($con, $sql)) {
    echo "<script>window.location.href='process.php';</script>";
} else {
    echo "Error deleting record";
}
sqlsrv_close($con);
?>
