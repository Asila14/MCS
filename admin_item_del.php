<?php
include 'includes/connect.php';
$sql = "DELETE FROM item WHERE item_id='" . $_GET["item_id"] . "'";
if (sqlsrv_query($con, $sql)) {
    echo "<script>window.location.href='admin_item.php';</script>";
} else {
    echo "Error deleting record";
}
sqlsrv_close($con);
?>