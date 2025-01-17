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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
          if (isset($_GET['measure_id']))
              $measure_id = $_GET['measure_id'];
          else
              $measure_id = 0;
          
          include 'includes/connect.php';
          
          $query = "SELECT * FROM measurement inner join process ON measurement.process_id=process.process_id inner join package ON measurement.pack_id=package.pack_id inner join machine ON measurement.mc_id=machine.mc_id inner join material ON measurement.material_id=material.material_id inner join customer ON measurement.cust_id=customer.cust_id  inner join partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id = $measure_id";
          $result = sqlsrv_query($con,$query) or die('Database connection eror');
          $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

        ?>
        <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Lot Information</h4>
                  <form class="forms-sample" action="" method="post">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Part No</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="pn_no" value="<?php echo $row['pn_no'] ?>" readonly/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Package Size</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="pack_name" value="<?php echo $row['pack_name'] ?>" readonly/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Lot No</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="measure_lot" value="<?php echo $row['measure_lot'] ?>" readonly/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Customer</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="cust_name" value="<?php echo $row['cust_name'] ?>" readonly/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Emp#</label>
                          <div class="col-sm-9">
                            <input class="form-control" name="measure_emp" value="<?php echo $row['measure_emp'] ?>" readonly/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Machine#</label>
                          <div class="col-sm-9">
                            <input class="form-control" name="mc_name" value="<?php echo $row['mc_name'] ?>" readonly/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Of Measurement Item</h4>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                          <tr class="table-light">
                            <th class='text-center mt-3'>Action</th>
                            <th class='text-center mt-3'>Item</th>
                            <th class='text-center mt-3'>Judgement</th>
                          </tr>
                        </thead>
                        <tbody class="table table-sm">
                          <?php
                          $sqls = "SELECT * FROM measurement INNER JOIN partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id = '$measure_id'";
                          $results = sqlsrv_query($con,$sqls) or die('Database connection error');
                          while ($rows = sqlsrv_fetch_array($results,SQLSRV_FETCH_ASSOC)) {
                                  echo "<tr style=height:40px>";
                                  echo "<td class='text-center mt-3'><a class=btn btn-primary href=measure_manage1.php?spec_id=".$rows['spec_id']."><i class=ti-pencil></i></a></td>";
                                  echo "<td class='text-center mt-3'>".$rows['item_name']."</td>";
                                  $sqlcek="SELECT * FROM spec_data WHERE measure_id = '$measure_id'";
                                  $result_cek = sqlsrv_query($con,$sqlcek) or die('Database connection error');
                                  $row_check = sqlsrv_fetch_array($result_cek,SQLSRV_FETCH_ASSOC);

                                  if ($row_check == null) {
                                    echo "<td class='text-center mt-3'><label class='badge badge-danger'>Failed</label></td>";
                                  } else if ($row_check['status_judge'] == 'in') {
                                    echo "<td class='text-center mt-3'><label class='badge badge-success'>Pass</label></td>";
                                  } else {
                                    echo "<td class='text-center mt-3'><label class='badge badge-danger'>Failed</label></td>";
                                  }

                              }
                          ?>
                        </tbody>
                      </head>
                    </table>
                  </div>
                </div>
              </div>
            </div>
    <?php
      $check_input="SELECT * FROM spec_data inner join measurement on spec_data.measure_id=measurement.measure_id INNER JOIN partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id";
      $result_input = sqlsrv_query($con,$check_input) or die('Database connection error');
      $row_input = sqlsrv_fetch_array($result_input,SQLSRV_FETCH_ASSOC);

      if ($row_input == null) {
        echo "";
      } else if ($row_input['status_judge'] == 'in') {?>
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Measurement Input Data</h4>
                    <input type="text" class="form-control " id="search" autocomplete="off" placeholder="Search...">
                    <div id="no-results-message" style="display: none; color: red;">Record not found...</div>
                    <br>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                          <tr class="table-light">
                            <th class='text-center mt-3'>#</th>
                            <th class='text-center mt-3'>Item</th>
                            <th class='text-center mt-3'>Data</th>
                            <th class='text-center mt-3'>Result</th>
                          </tr>
                        </thead>
                        <tbody class="table table-sm">
                          <?php
                          $sql_data = "SELECT * FROM spec_data inner join specification ON spec_data.spec_id=specification.spec_id inner join item ON specification.item_id=item.item_id WHERE measure_id = '$measure_id' ";
                          $result_data = sqlsrv_query($con,$sql_data) or die('Database connection error');
                           $total_data = sqlsrv_num_rows($result_data);
                           $no = 0;
                           $item_name = "";
                           while ($row_data = sqlsrv_fetch_array($result_data,SQLSRV_FETCH_ASSOC)){
                            if ($item_name != $row_data['item_name']) {
                              $item_name = $row_data['item_name'];
                              $no = 1;
                            } else {
                              $no++;
                            }
                            echo "<tr style=height:40px>";
                            echo "<td class='text-center mt-3'>".$no."</td>";
                            echo "<td class='text-center mt-3'>".$row_data['item_name']."</td>";
                            echo "<td class='text-center mt-3'>".$row_data['data']."</td>";
                            echo "<td class='text-center mt-3'>".$row_data['data_result']."</td>";
                          }
                          ?>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <?php
            $sql_item_name = "SELECT DISTINCT item_name FROM spec_data inner join specification ON spec_data.spec_id=specification.spec_id inner join item ON specification.item_id=item.item_id WHERE measure_id = '$measure_id' ";
            $result_sql_item_name = sqlsrv_query ($con,$sql_item_name);
            while ($row_item_name = sqlsrv_fetch_array ($result_sql_item_name, SQLSRV_FETCH_ASSOC)) {
              $item_name = $row_item_name['item_name'];
              $sql_result_max = "SELECT MAX(data) AS result_max, MIN(data) AS result_min, AVG(data) AS result_avg FROM spec_data inner join specification ON spec_data.spec_id=specification.spec_id inner join item ON specification.item_id=item.item_id WHERE measure_id = '$measure_id' AND item_name = '$item_name'";
              $result_sql_result_max = sqlsrv_query ($con,$sql_result_max);
              $spec_usl = "";
              $spec_lsl = "";
              while ($row = sqlsrv_fetch_array ($result_sql_result_max, SQLSRV_FETCH_ASSOC)) {
                $result_max = $row['result_max'];
                $result_min = $row['result_min'];
                $result_range = $row['result_max'] - $row['result_min'];
                $result_avg = $row['result_avg'];
                $result_std = sqrt(($result_max - $result_avg)**2 + ($result_avg - $result_min)**2) / 3; 
                //$result_cpk =(($spec_usl - $result_avg) / (3 * $result_std)), (($result_avg - $spec_lsl) / (3 * $result_std)));
                ?>

                      <div class="col-lg-3 grid-margin stretch-card">
                          <div class="card">
                            <div class="card-body">
                              <form action="" method="POST" >
                              <h4 class="card-title">Data Result By Item : <?php echo $item_name; ?></h4>
                              <div class="table-responsive pt-3">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th  class='text-center mt-3'>Average</th>
                                      <td  class='text-center mt-3'><?php echo round($result_avg, 3); ?></td>
                                    </tr>
                                    <tr>
                                      <th  class='text-center mt-3'>Max</th>
                                      <td  class='text-center mt-3'><?php echo $result_max; ?></td>
                                    </tr>
                                    <tr>
                                      <th  class='text-center mt-3'>Min</th>
                                      <td  class='text-center mt-3'><?php echo $result_min; ?></td>
                                    </tr>
                                    <tr>
                                      <th  class='text-center mt-3'>Range</th>
                                      <td  class='text-center mt-3'><?php echo $result_range; ?></td>
                                    </tr>
                                    <tr>
                                      <th  class='text-center mt-3'>Std Dev.</th>
                                      <td  class='text-center mt-3'><?php echo round($result_std,3); ?></td>
                                    </tr>
                                    <tr>
                                      <th  class='text-center mt-3'>Cpk</th>
                                      <td  class='text-center mt-3'></td>
                                    </tr>
                                    <tr>
                                      <th  class='text-center mt-3'>Judgement</th>
                                      <td  class='text-center mt-3'><label class='badge badge-danger'>Failed</label></td>
                                    </tr>
                                  </thead>
                                </table>
                                <!-- <br>
                              <input type="hidden" name="measure_id" value="<?php echo $measure_id; ?>">
                              <input type="submit" name="result" class="btn btn-primary" value=" Submit "> -->
                              </div>
                            </form>
                            </div>
                          </div>
                        </div>
                        <?php
                          }if(isset($_POST['result'])){
                            $sql_insert_spec_result = "INSERT INTO spec_result (measure_id, result_max, result_min, result_range, result_avg, result_std) VALUES ('$measure_id', '$result_max', '$result_min', '$result_range', '$result_avg', '$result_std')";
                          $result_sql_insert_spec_result = sqlsrv_query ($con,$sql_insert_spec_result);
                            if ($result_sql_insert_spec_result === false) {
                              die(sqlsrv_errors());
                            }
                          }
                        ?>

                        <?php
                  } 
                }else {
                    echo "No Data";
                  }
            ?>
<script>
// Add an event listener to the search input to listen for changes
  document.getElementById("search").addEventListener("input", function() {
// Get the value of the search input
    const query = this.value.toLowerCase();

// Loop through each table row and check if it matches the search query
    let visibleRows = false;
    document.querySelectorAll("tbody tr").forEach(row => {
  // Get the columns in the row
      const columns = row.querySelectorAll("td");

  // Loop through each column and check if it contains the search query
      let match = false;
      columns.forEach(col => {
        if (col.textContent.toLowerCase().includes(query)) {
          match = true;
        }
      });

  // If the row matches the search query, show it. Otherwise, hide it.
      if (match) {
        row.style.display = "";
        visibleRows = true;
      } else {
        row.style.display = "none";
      }
    });

// If no rows match the search query, display a message
    const message = document.getElementById("no-results-message");
    if (!visibleRows) {
      message.style.display = "";
    } else {
      message.style.display = "none";
    }
  });
</script>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap adresult_min template</a> from BootstrapDash.</span>
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

  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../js/chart.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

