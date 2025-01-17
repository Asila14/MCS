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
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Registered Machine
                  <button type="button" class="btn btn-primary btn-rounded btn-icon" data-bs-toggle="modal" data-bs-target="#AddMachine">
                    <i class="ti-plus"></i>
                  </button></h4>
                  <!-- Modal -->
                <?php

                include 'includes/connect.php';
                //to add data
                if (isset ($_POST['add'])){
                
                    $mc_input = $_POST["mc_input"];
                    $mc_name = $_POST["mc_name"];

                    $sql = "INSERT INTO machine (mc_input,mc_name) VALUES ('$mc_input','$mc_name')";
                    $result = sqlsrv_query($con,$sql) or die('Database connection error');
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
                <div class="modal fade" id="AddMachine" tabindex="-1" aria-labelledby="AddMachineLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Machine</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" action="" method="post">
                            <div class="form-group">
                              <label >Machine Input</label>
                              <input type="text" name="mc_input" class="form-control">
                            </div>
                            <div class="form-group">
                              <label >Machine Name</label>
                              <input type="text" name="mc_name" class="form-control">
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="add" class="btn btn-primary">Submit</button>
                          </div>
                          </form>
                      </div>
                      
                    </div>
                  </div>
                </div>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Input</th>
                          <th>Name</th>
                          <th>Edit</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        include 'includes/connect.php';
                        $sql = "SELECT * FROM machine ";
                        $result = sqlsrv_query($con,$sql) or die('Database connection error');
                        while ($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>".$row['mc_id']."</td>";
                                echo "<td>".$row['mc_input']."</td>";
                                echo "<td>".$row['mc_name']."</td>";
                                echo "<td><a class=btn btn-primary href=machine_edit.php?mc_id=".$row['mc_id']."><i class=ti-eraser></i></a></td>";
                                echo "<td><a class=btn btn-primary href=machine_del.php?mc_id=".$row['mc_id']."><i class=ti-trash></i></a></td>";
                                echo "</tr>";
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

