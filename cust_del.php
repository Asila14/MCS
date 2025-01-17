<?php
include 'includes/connect.php';
$sql = "DELETE FROM customer WHERE cust_id='" . $_GET["cust_id"] . "'";
if (sqlsrv_query($con, $sql)) {
    echo "Record deleted successfully";
    header ("refresh:0; url=customer.php");
} else {
    echo "Error deleting record";
}
sqlsrv_close($con);
?>