<?php
include 'includes/connect.php';
$sql = "DELETE FROM machine WHERE mc_id='" . $_GET["mc_id"] . "'";
if (sqlsrv_query($con, $sql)) {
    echo "Record deleted successfully";
    header ("refresh:0; url=machine.php");
} else {
    echo "Error deleting record";
}
sqlsrv_close($con);
?>