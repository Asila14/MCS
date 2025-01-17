<?php
include 'includes/connect.php';
$sql = "DELETE FROM specification WHERE spec_id='" . $_GET["spec_id"] . "'";
if (sqlsrv_query($con, $sql)) {
    echo "Record deleted successfully";
    header ("refresh:0; url=admin_spec.php");
} else {
    echo "Error deleting record";
}
sqlsrv_close($con);
?>