<?php
include 'includes/connect.php';
$sql = "DELETE FROM item WHERE item_id='" . $_GET["item_id"] . "'";
if (sqlsrv_query($con, $sql)) {
    echo "Record deleted successfully";
    header ("refresh:0; url=item.php");
} else {
    echo "Error deleting record";
}
sqlsrv_close($con);
?>