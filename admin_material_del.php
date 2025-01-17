<script src="jquery-3.6.0.min.js"></script>
  <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="sweetalert.js"></script>
<?php
include 'includes/connect.php';
$sql = "DELETE FROM material WHERE material_id='" . $_GET["material_id"] . "'";
if (sqlsrv_query($con, $sql)) {
    echo "<script>window.location.href='admin_material.php';</script>";
} else {
    echo "Error deleting record";
}
sqlsrv_close($con);
?>

