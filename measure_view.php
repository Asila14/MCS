<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Measurement Control System</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/typicons/typicons.css">
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  <script src="sweetalert.js"></script>
  <script src="library/dselect.js"></script>
  <link rel="stylesheet" href="deliver.css">
  <!-- Add this line in your <head> section -->
<link rel="stylesheet" href="dataTables.css">
</head>
<body>
    <!-- partial:partials/_navbar.html -->
    <?php
    include 'includes/navbar.php';
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php
      include 'includes/sidebar.php';
      ?>
      <div class="main-panel">
<div class="content-wrapper">
  <div class="row">
<?php
include 'includes/connect.php';

if (isset($_GET['measure_id']) && isset($_GET['item_id'])) {
  $measure_id = $_GET['measure_id'];
  $item_id = $_GET['item_id'];
  } else {
    $measure_id = 0;
    $item_id = 0;
  }

  $sql1 = "SELECT * FROM spec_data WHERE measure_id = $measure_id AND item_id = $item_id ";
  $result1 = sqlsrv_query($con,$sql1) or die('Database connection error');

  $num_rows = sqlsrv_num_rows($result1);

  if ($num_rows == 0) {
    echo "<div class='alert alert-danger'>No records found</div>";
  } else {
?>

    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Data Result</h4>
          <table id="datatableid" class="table table-sm table-bordered">
              <thead>
                <tr class="table-light">
                  <th class='text-center mt-3'>#</th>
                  <th class='text-center mt-3'>Data</th>
                  <th class='text-center mt-3'>Result</th>
                </tr>
              </thead>
              <tbody class="table table-sm">
                <?php
                $no = 1;
                while ($row1 = sqlsrv_fetch_array($result1,SQLSRV_FETCH_ASSOC)) {
                  echo "<tr>";
                  echo "<td class='text-center mt-3'>".$no."</td>";
                  echo "<td class='text-center mt-3'>".$row1['data']."</td>";
                  echo "<td class='text-center mt-3'>".$row1['data_result']."</td>";
                  echo "</tr>";
                  $no++;
                }
                ?>
              </tbody>
            </table>
        </div>
      </div>
    </div>
<?php
}
?>
</div>
</div>
</div>
</div>
<!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
         <?php
        include 'includes/footer.php';
        ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <?php
  include 'script.php';
  ?>
</body>
</html>
