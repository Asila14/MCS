<!DOCTYPE html>
<html lang="en">
<?php
include 'includes/head.php';
?>
<body>
    <!-- partial:partials/_navbar.html -->
    <?php
    include 'includes/admin_navbar.php';
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php
      include 'includes/admin_sidebar.php';
      ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                      <div class="col-md-2">
                        <div class="form-group row">
                          <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                              <h4 class="card-title card-title-dash">Activities</h4>
                            </div>
                            <ul class="bullet-line-list">
                              <li>
                                <a href="admin_user.php" style="text-decoration: none;">
                                <div><span class="text-light-green">User</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="admin_machine.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Machine</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="admin_item.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Item</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="admin_customer.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Customer</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="admin_package.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Package</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="admin_material.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Material</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="admin_partno.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Part Number</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="admin_spec.php" style="text-decoration: none;">
                                <div><span class="text-light-green" style="font-size: 20px; color: navy;"><b>Specification</b></span></div>
                              </a>
                              </li>
                            </ul>
                            <div class="list align-items-center pt-3">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10">
                  <h4 class="card-title">Registered Spec
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddSpec"><i class="ti-plus"></i></button></h4>
                  <!-- Modal -->
                <?php

                include 'includes/connect.php';
                //to add data
                if (isset ($_POST['addspec'])){
                
                    $spec_sc = $_POST["spec_sc"];
                    $spec_csl = $_POST["spec_csl"];
                    $spec_usl = $_POST["spec_usl"];
                    $spec_lsl = $_POST["spec_lsl"];
                    $spec_cpk = $_POST["spec_cpk"];
                    $spec_spl_point = $_POST["spec_spl_point"];
                    $spec_data_spl = $_POST["spec_data_spl"];
                    $spec_xcl = $_POST["spec_xcl"];
                    $spec_xucl = $_POST["spec_xucl"];
                    $spec_xlcl = $_POST["spec_xlcl"];
                    $spec_rucl = $_POST["spec_rucl"];
                    $id = $_POST["id"];
                    $item_id = $_POST["item_id"];
                    $spec_correction = $_POST["spec_correction"];

                    $sql = "INSERT INTO specification (spec_sc,spec_csl,spec_usl,spec_lsl,spec_cpk,spec_spl_point,spec_data_spl,spec_xcl,spec_xucl,spec_xlcl,spec_rucl,id,item_id,spec_correction) VALUES ('$spec_sc','$spec_csl','$spec_usl','$spec_lsl','$spec_cpk','$spec_spl_point','$spec_data_spl','$spec_xcl','$spec_xucl','$spec_xlcl','$spec_rucl','$id','$item_id','$spec_correction')";
                    $result = sqlsrv_query($con,$sql) or die('Database connection error');
                    if($result > 0){
                      // Use Sweetalert to show a success message
                        echo "
                      <script src='sweetalert2.all.min.js'></script>
                        <script>
                          Swal.fire({
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: 'false',
                            timer: '1500'
                          });
                      </script>";
                    } else {
                      // Use Sweetalert to show an error message
                      echo "
                      <script src='sweetalert2.all.min.js'></script>
                        <script>
                          Swal.fire({
                              title: 'Failed!',
                              text: 'The operation failed.',
                              icon: 'error',
                              confirmButtonText: 'OK'
                          });
                      </script>";
                }
				}
                ?>

                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="AddSpecLabel" id="AddSpec" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-6" id="exampleModalLabel">Add New Spec</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" action="" method="post">

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Part No.</label>
                              <div class="col-sm-9">
                                <?php
                                include 'includes/connect.php';

                                // Get the user's employee number from the session variable.
                                $user_emp = $_SESSION['user_emp'];

                                // Query the database to get the user's process ID.
                                $sql = "SELECT process_id FROM users WHERE user_emp = '$user_emp'";
                                $result = sqlsrv_query($con, $sql);
                                $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

                                // Set the user's process ID in the session variable.
                                $_SESSION['process_id'] = $row['process_id'];

                                // Get the process ID from the session variable.
                                $process_id = $_SESSION['process_id'];

                                $part = sqlsrv_query($con,"SELECT * FROM partnumber inner join process ON partnumber.process_id=process.process_id WHERE process.process_id=$process_id ");
                              ?>
                              <input type="hidden" name="id" value="<?php if(isset($_POST['id']))?>" />
                              <select data-live-search="true" name="id" class="form-control selectpicker">
                                <option> - Please select - </option>
                                <?php 
                            if($part > 0) {
                                 while($pa = sqlsrv_fetch_array($part,SQLSRV_FETCH_ASSOC)){
                                ?>

                                  <option value="<?php echo $pa['id']?> "><?php echo $pa['pn_no']; ?><?php } } ?></option>
                              </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Item</label>
                              <div class="col-sm-9">
                                <?php
                                include 'includes/connect.php';

                                // Get the user's employee number from the session variable.
                                $user_emp = $_SESSION['user_emp'];

                                // Query the database to get the user's process ID.
                                $sql = "SELECT process_id FROM users WHERE user_emp = '$user_emp'";
                                $result = sqlsrv_query($con, $sql);
                                $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

                                // Set the user's process ID in the session variable.
                                $_SESSION['process_id'] = $row['process_id'];

                                // Get the process ID from the session variable.
                                $process_id = $_SESSION['process_id'];

                                $item = sqlsrv_query($con,"SELECT * FROM item inner join process ON item.process_id=process.process_id WHERE process.process_id='$process_id'");
                              ?>
                                <input type="hidden" name="item_id" value="<?php if(isset($_POST['item_id']))?>" />
                              <select data-live-search="true" name="item_id" class="form-control selectpicker">
                                <option> - Please select - </option>
                                <?php 
                                if($item > 0) {
                                 while($i = sqlsrv_fetch_array($item,SQLSRV_FETCH_ASSOC)){
                                ?>
                                  <option value="<?php echo $i['item_id']?> "><?php echo $i['item_name']; ?>
                                    <?php } } ?></option>
                              </select>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">SC</label>
                              <div class="col-sm-9">
                                <select name="spec_sc" class="form-control" autocomplete="off" required>
                                <option>- Please select - </option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                              </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">CSL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_csl" class="form-control" autocomplete="off" required>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">USL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_usl" class="form-control" autocomplete="off" required>
                              </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">LSL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_lsl" class="form-control" autocomplete="off" required>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">CPK</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_cpk" class="form-control" autocomplete="off">
                              </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Spl Size</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_spl_point" class="form-control" autocomplete="off" required>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Data/Spl</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_data_spl" class="form-control" autocomplete="off" required>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">XCL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_xcl" class="form-control" autocomplete="off" required>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">XUCL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_xucl" class="form-control" autocomplete="off">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">XLCL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_xlcl" class="form-control" autocomplete="off">
                              </div>
                            </div>
                          </div>
                        </div>
            
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">RUCL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_rucl" class="form-control" autocomplete="off">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Attempt Limit</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_correction" class="form-control" autocomplete="off" required>
                              </div>
                            </div>
                          </div>
                        </div>
            
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="addspec" class="btn btn-primary">Submit</button>
                          </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>
                  <div class="table-responsive">
                    <?php
                  include 'includes/connect.php';

                  // Get the user's employee number from the session variable.
                  $user_emp = $_SESSION['user_emp'];

                  // Query the database to get the user's process ID.
                  $sql = "SELECT process_id FROM users WHERE user_emp = '$user_emp'";
                  $result = sqlsrv_query($con, $sql);
                  $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

                  // Set the user's process ID in the session variable.
                  $_SESSION['process_id'] = $row['process_id'];

                  // Get the process ID from the session variable.
                  $process_id = $_SESSION['process_id'];

                  // Fetch records from the database with pagination
                  $sql = "SELECT * FROM specification INNER JOIN partnumber ON specification.id = partnumber.id INNER JOIN process ON process.process_id=partnumber.process_id INNER JOIN item ON specification.item_id = item.item_id WHERE process.process_id='$process_id' ORDER BY partnumber.pn_no ASC, process.process_name ASC";
                  $result = sqlsrv_query($con, $sql) or die('Database connection error');

                  // Display the table header
                  echo "<table id='datatableid' class='table table-sm table-bordered'>";
                  echo "<thead>";
                  echo "<tr class='table-light'>";
                  echo "<th class='text-center mt-3'>#PN</th>";
                  echo "<th class='text-center mt-3'>Process</th>";
                  echo "<th class='text-center mt-3'>Item</th>";
                  echo "<th class='text-center mt-3'>SC</th>";
                  echo "<th class='text-center mt-3'>CSL</th>";
                  echo "<th class='text-center mt-3'>USL</th>";
                  echo "<th class='text-center mt-3'>LSL</th>";
                  echo "<th class='text-center mt-3'>Cpk</th>";
                  echo "<th class='text-center mt-3'>Spl Size</th>";
                  echo "<th class='text-center mt-3'>Data/Spl</th>";
                  echo "<th class='text-center mt-3'>XCL</th>";
                  echo "<th class='text-center mt-3'>XUCL</th>";
                  echo "<th class='text-center mt-3'>XLCL</th>";
                  echo "<th class='text-center mt-3'>RUCL</th>";
                  echo "<th class='text-center mt-3'>Attempt Limit</th>";
                  echo "<th class='text-center mt-3'>Edit</th>";
                  echo "<th class='text-center mt-3'>Delete</th>";
                  echo "</tr>";
                  echo "</thead>";

                  echo "<tbody>";
                  if (sqlsrv_has_rows($result) == 0) {
                      echo "<tr>";
                      echo "<td class='text-center mt-3 text-danger' colspan='8'>No Records Found...</td>";
                      echo "</tr>";
                  } else {
                      while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                          echo "<tr>";
                          echo "<td class='text-center mt-3 text-primary'><b>".$row['pn_no']."</b></td>";
                          echo "<td class='text-center mt-3 text-info'><b>".$row['process_name']."</b></td>";
                          echo "<td class='text-center mt-3 text-success'><b>".$row['item_name']."</b></td>";
                          echo "<td class='text-center mt-3'>".$row['spec_sc']."</td>";
                          echo "<td class='text-center mt-3'>".$row['spec_csl']."</td>";
                          echo "<td class='text-center mt-3'>".$row['spec_usl']."</td>";
                          echo "<td class='text-center mt-3'>".$row['spec_lsl']."</td>";
                          echo "<td class='text-center mt-3'>".$row['spec_cpk']."</td>";
                          echo "<td class='text-center mt-3'>".$row['spec_spl_point']."</td>";
                          echo "<td class='text-center mt-3'>".$row['spec_data_spl']."</td>";
                          echo "<td class='text-center mt-3'>".$row['spec_xcl']."</td>";
                          echo "<td class='text-center mt-3'>".$row['spec_xucl']."</td>";
                          echo "<td class='text-center mt-3'>".$row['spec_xlcl']."</td>";
                          echo "<td class='text-center mt-3'>".$row['spec_rucl']."</td>";
                          echo "<td class='text-center mt-3'>".$row['spec_correction']."</td>";
                          echo "<td class='text-center mt-3'><a class=btn btn-primary href=admin_spec_edit.php?spec_id=".$row['spec_id']."><i class=ti-eraser></i></a></td>";
                          echo "<td class='text-center mt-3'><a class='btn btn-delete btn_del' href=admin_spec_del.php?spec_id=".$row['spec_id']."><i class=ti-trash></i></a></td>";
                          echo "</tr>";     
                    }
                  }
                  echo "</tbody>";
                  echo "</table><br>";

                  // Close the database connection
                  sqlsrv_close($con);
                  ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<!-- jQuery -->
<script src="jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 CSS -->
      <link rel="stylesheet" href="path/to/bootstrap-5.min.css">

      <!-- DataTables Bootstrap 5 CSS -->
      <link rel="stylesheet" href="dataTables.bootstrap5.min.css">

      <!-- DataTables jQuery script -->
      <script src="jquery.dataTables.min.js"></script>

      <!-- DataTables Bootstrap 5 script -->
      <script src="dataTables.bootstrap5.min.js"></script>


          <script>
          $(document).ready(function() {
            // Initialize DataTables
            const table = $('#datatableid').DataTable();

            // Event listener for DataTables search
            $('#search').on('input', function() {
              const query = this.value.toLowerCase();
              table.search(query).draw();
            });

            // Custom row-based search
            document.getElementById("search").addEventListener("input", function() {
              const query = this.value.toLowerCase();

              const rows = document.querySelectorAll("#datatableid tbody tr");
              let visibleRows = false;

              rows.forEach(row => {
                const columns = row.querySelectorAll("td");
                let match = false;

                columns.forEach(col => {
                  if (col.textContent.toLowerCase().includes(query)) {
                    match = true;
                  }
                });

                if (match) {
                  row.style.display = "";
                  visibleRows = true;
                } else {
                  row.style.display = "none";
                }
              });

              const message = document.getElementById("no-results-message");
              if (!visibleRows) {
                message.style.display = "";
              } else {
                message.style.display = "none";
              }
            });
          });
        </script>
        <script src="sweetalert2.all.min.js"></script>
        <script type="text/javascript">
            $('.btn_del').on('click', function(e){
                e.preventDefault();
                const href = $(this).attr('href')
                Swal.fire({
                    title: 'Are You Sure?',
                    text: 'Record will be deleted?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete Record',
                }).then((result) => {
                    if (result.value){
                        // Redirect to the delete page
                        window.location.href = href;
                    }
                })
            });
        </script>
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


