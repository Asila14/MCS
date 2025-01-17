<?php
include 'includes/connect.php';
$sql = "DELETE FROM customer WHERE cust_id='" . $_GET["cust_id"] . "'";
if (sqlsrv_query($con, $sql)) {
    echo "<script>window.location.href='admin_customer.php';</script>";
} else {
    echo "Error deleting record";
}
sqlsrv_close($con);
?>