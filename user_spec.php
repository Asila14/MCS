<!DOCTYPE html>
<html lang="en">
<?php
include 'includes/head.php';
?>
<body>
    <!-- partial:partials/_navbar.html -->
    <?php
    include 'includes/user_navbar.php';
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php
      include 'includes/user_sidebar.php';
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
                                <a href="user_machine.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Machine</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="user_item.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Item</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="user_customer.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Customer</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="user_package.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Package</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="user_material.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Material</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="user_partno.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Part Number</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="user_spec.php" style="text-decoration: none;">
                                <div><span class="text-light-green" style="font-size: 20px; color: navy;"><b>Specification</b></span></div>
                              </a>
                              </li>
                            </ul>
                            <div class="list align-items-center pt-3">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10"></h4>
                        <h4 class="card-title">Registered Specification</i></h4>
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
                            echo '
                              <script>
                                swal({
                                  title: "Done!",
                                  text: "Data has been succesfully registered.",
                                  icon: "success",
                                  button: "OK",
                                });
                              </script>
                            ';
                          } else {
                            // Use Sweetalert to show an error message
                            echo '
                              <script>
                                swal({
                                  title: "Failed!",
                                  text: "The operation failed.",
                                  icon: "error",
                                  button: "OK",
                                });
                              </script>
                            ';
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
                              <select name="id" class="form-control">
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
                              <select name="item_id" class="form-control">
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
                                <input type="text" name="spec_cpk" class="form-control" autocomplete="off" required>
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
                                <input type="text" name="spec_xucl" class="form-control" autocomplete="off" required>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">XLCL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_xlcl" class="form-control" autocomplete="off" required>
                              </div>
                            </div>
                          </div>
                        </div>
            
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">RUCL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_rucl" class="form-control" autocomplete="off" required>
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
                    <table id="datatableid" class="table table-sm table-bordered">
                      <thead>
                        <tr class="table-light">
                          <th class='text-center mt-3'>Item</th>
                          <th class='text-center mt-3'>#PN</th>
                          <th class='text-center mt-3'>SC</th>
                          <th class='text-center mt-3'>CSL</th>
                          <th class='text-center mt-3'>USL</th>
                          <th class='text-center mt-3'>LSL</th>
                          <th class='text-center mt-3'>Cpk</th>
                          <th class='text-center mt-3'>Spl Size</th>
                          <th class='text-center mt-3'>Data/Spl</th>
                          <th class='text-center mt-3'>XCL</th>
                          <th class='text-center mt-3'>XUCL</th>
                          <th class='text-center mt-3'>XLCL</th>
                          <th class='text-center mt-3'>RUCL</th>
                          <th class='text-center mt-3'>Attempt Limit</th>
                        </tr>
                      </thead>
                      <tbody class="table table-sm">
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

                        $sql1 = "SELECT * FROM specification INNER JOIN partnumber ON specification.id = partnumber.id INNER JOIN item ON specification.item_id = item.item_id inner join process ON partnumber.process_id=process.process_id WHERE process.process_id=$process_id ORDER BY partnumber.pn_no ";


                        $result1 = sqlsrv_query($con,$sql1) or die('Database connection error');
                        while ($row = sqlsrv_fetch_array($result1,SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td class='text-center mt-3'>".$row['item_name']."</td>";
                                echo "<td class='text-center mt-3 text-primary'><b>".$row['pn_no']."</b></td>";
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

