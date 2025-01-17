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
      <?php
        //to retrived data
        if (isset($_GET['spec_id']) && isset($_GET['measure_id']) && isset($_GET['item_id']) && isset($_GET['id'])){
            $measure_id = $_GET['measure_id'];
            $spec_id = $_GET['spec_id'];
            $item_id = $_GET['item_id'];
            $id = $_GET['id'];
        }
        
        include 'includes/connect.php';
        
        $query = "SELECT * FROM measurement inner join process ON measurement.process_id=process.process_id inner join package ON measurement.pack_id=package.pack_id inner join machine ON measurement.mc_id=machine.mc_id inner join material ON measurement.material_id=material.material_id inner join customer ON measurement.cust_id=customer.cust_id  inner join partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id = $measure_id AND partnumber.id= $id AND item.item_id=$item_id";
      $result = sqlsrv_query($con,$query) or die('Database connection eror');
      $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
      ?>
      <div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Please Select to Input Data</h4>
                  <p class="card-description">
                    <code>Please note that you only have <?php echo $row['spec_correction']; ?> attempts to complete this task. If you fail to complete the task within attempts, you will need to start over</code>
                  </p>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                      <tr>
                        <th class='text-center mt-3'>#</th>
                        <!-- <th class='text-center mt-3'>Result</th> -->
                        <th class='text-center mt-3'>Status</th>
                        <th class='text-center mt-3'>Attempt</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $spec_correction = $row['spec_correction'];

                      for ($b = 1; $b <= $spec_correction; $b++) {
                        ?>
                        <tr>
                          <td class='text-center mt-3'><?php echo $b; ?></td>
                          <!-- <?php 
                        $sqlcek="SELECT * FROM spec_result WHERE measure_id = '$measure_id' AND item_id = '$item_id' ";
                        $result_cek = sqlsrv_query($con,$sqlcek) or die('Database connection error');
                        $row_check = sqlsrv_fetch_array($result_cek,SQLSRV_FETCH_ASSOC);

                        if ($row_check == null) {
                          echo "<td class='text-center mt-3'><label class='badge badge-warning'>No Data</label></td>";
                        } else if ($row_check['result_judgement'] == 'pass') {
                          echo "<td class='text-center mt-3'><label class='badge badge-success'>Pass</label></td>";
                        } else {
                          echo "<td class='text-center mt-3'><label class='badge badge-danger'>Failed</label></td>";
                        } ?> -->
                        <?php
                         $sql_cekD = "SELECT * FROM spec_data INNER JOIN spec_result ON spec_data.measure_id=spec_result.measure_id WHERE $measure_id = $measure_id AND $spec_id = $spec_id AND $item_id = $item_id AND status_judge = 'in' AND attempt = $b";
                        $result_cekD = sqlsrv_query($con, $sql_cekD) or die('Database connection error');
                        $row_checkD = sqlsrv_fetch_array($result_cekD, SQLSRV_FETCH_ASSOC);

                       /* if ($row_checkD == null) {
                          echo "<td class='text-center mt-3'><label class='badge badge-warning'>No Data</label></td>";
                        } else if ($row_checkD['attempt'] == $row_checkD['attempt'] && $row_checkD['status_judge'] == 'in' && $row_checkD['result_judgement'] == 'pass') {
                          echo "<td class='text-center mt-3'><label class='badge badge-danger'>Failed</label></td>";
                        } else {
                          echo "<td class='text-center mt-3'><label class='badge badge-danger'>Failed</label></td>";
                        }*/

                        if ($row_checkD == null) {
                          echo "<td class='text-center mt-3'><label class='badge badge-warning'>No Data</label></td>";
                        } else if ($row_checkD['result_judgement'] == 'pass') {
                          echo "<td class='text-center mt-3'><label class='badge badge-success'>Pass</label></td>";
                        } else if ($row_checkD['result_judgement'] == null) {
                          echo "<td class='text-center mt-3'><label class='badge badge-danger'>Failed</label></td>";
                        } else {
                          echo "<td class='text-center mt-3'><label class='badge badge-warning'>No Data</label></td>";
                        }
                        ?>

                        <td class='text-center mt-3'>
                          <button href="measure_form.php" class="btn btn-outline-primary btn-icon-text" type="button" name="attempt<?php echo $b; ?>" onclick="window.location.href = 'measure_form.php?attempt=<?php echo $b; ?>&measure_id=<?php echo $row['measure_id']; ?>&spec_id=<?php echo $row['spec_id']; ?>&item_id=<?php echo $row['item_id']; ?>&id=<?php echo $row['id']; ?>';"><i class="ti-file btn-icon-prepend"> Attempt <?php echo $b; ?> </i>
                          </button>
                        </td>
                      </tr>
                        <?php
                      }
                      ?>
                    </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2021. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/jquery.cookie.js" type="text/javascript"></script>
  <script src="js/dashboard.js"></script>
  <script src="js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

