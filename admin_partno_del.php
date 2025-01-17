<?php
include 'includes/connect.php';

$id = $_GET["id"]; // Get the ID from the URL

// Delete the record from the partnumber table
$sqlPartnumber = "DELETE FROM partnumber WHERE id='" . $id . "'";
if (sqlsrv_query($con, $sqlPartnumber)) {

    // Delete the corresponding record from the spec table
    $sqlSpec = "DELETE FROM spec WHERE id='" . $id . "'";
    sqlsrv_query($con, $sqlSpec);

    echo "Record deleted successfully";
    header ("refresh:0; url=admin_partno.php");
} else {
    echo "Error deleting record";
}

sqlsrv_close($con);
?>
