<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
include 'includes/connect.php';
$sql = "DELETE FROM users WHERE user_emp='" . $_GET["user_emp"] . "'";
if (sqlsrv_query($con, $sql)) {
    echo "<script>window.location.href='admin_user.php';</script>";
} else {
    echo "Error deleting record";
}
sqlsrv_close($con);
?>