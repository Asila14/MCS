<?php
include 'includes/connect.php';
$sql = "DELETE FROM package WHERE pack_id='" . $_GET["pack_id"] . "'";
if (sqlsrv_query($con, $sql)) {
    echo "Record deleted successfully";
    header ("refresh:0; url=admin_package.php");
} else {
    echo "Error deleting record";
}
sqlsrv_close($con);
?>