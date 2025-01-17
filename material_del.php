<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
include 'includes/connect.php';
$sql = "DELETE FROM material WHERE material_id='" . $_GET["material_id"] . "'";
if (sqlsrv_query($con, $sql)) {
    echo "<script>window.location.href='material.php';</script>";
} else {
    echo "Error deleting record";
}
sqlsrv_close($con);
?>

