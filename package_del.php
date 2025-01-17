<?php
include 'includes/connect.php';
$sql = "DELETE FROM package WHERE pack_id='" . $_GET["pack_id"] . "'";
if (sqlsrv_query($con, $sql)) {
    echo "<script>window.location.href='package.php';</script>";
} else {
    echo "Error deleting record";
}
sqlsrv_close($con);
?>