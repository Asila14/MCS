<?php
include 'includes/connect.php';
$sql = "DELETE FROM machine WHERE mc_id='" . $_GET["mc_id"] . "'";
if (sqlsrv_query($con, $sql)) {
    echo "<script>window.location.href='admin_machine.php';</script>";
} else {
    echo "Error deleting record";
}
sqlsrv_close($con);
?>