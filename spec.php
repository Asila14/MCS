<!DOCTYPE html>
<html lang="en">
<?php
include 'includes/head.php';
?>
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
                              <a href="process.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Process</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="user.php" style="text-decoration: none;">
                                <div><span class="text-light-green">User</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="machine.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Machine</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="item.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Item</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="customer.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Customer</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="package.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Package</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="material.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Material</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="partno.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Part Number</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="spec.php" style="text-decoration: none;">
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
                  <h4 class="card-title">Register Spec
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddSpec"><i class="ti-plus"></i></button></h4>
                  <!-- Modal -->
                  <?php

                  include 'includes/connect.php';

                  // Function to handle validation errors
                  function handleValidationError($message) {
                      echo "
                      <script src='sweetalert2.all.min.js'></script>
                      <script>
                        Swal.fire({
                          title: 'Validation Error!',
                          text: '" . $message . "',
                          icon: 'error',
                          confirmButtonText: 'OK'
                        });
                      </script>";
                  }

                  // Function to handle SQL errors
                  function handleSQLError($error) {
                      echo "
                      <script src='sweetalert2.all.min.js'></script>
                      <script>
                        Swal.fire({
                          title: 'Database Error!',
                          text: 'The operation failed. Error: " . $error . "',
                          icon: 'error',
                          confirmButtonText: 'OK'
                        });
                      </script>";
                  }

                  // Check if the form is submitted
                  if (isset($_POST['addspec'])) {
                      // Retrieve form data and default empty values to 0
                      $spec_sc = $_POST["spec_sc"] ?? null;
                      $spec_csl = $_POST["spec_csl"] ?? null;
                      $spec_usl = !empty($_POST["spec_usl"]) ? $_POST["spec_usl"] : 0;
                      $spec_lsl = !empty($_POST["spec_lsl"]) ? $_POST["spec_lsl"] : 0;
                      $spec_cpk = !empty($_POST["spec_cpk"]) ? $_POST["spec_cpk"] : 0;
                      $spec_spl_point = !empty($_POST["spec_spl_point"]) ? $_POST["spec_spl_point"] : 0;
                      $spec_data_spl = !empty($_POST["spec_data_spl"]) ? $_POST["spec_data_spl"] : 0;
                      $spec_xcl = !empty($_POST["spec_xcl"]) ? $_POST["spec_xcl"] : 0;
                      $spec_xucl = !empty($_POST["spec_xucl"]) ? $_POST["spec_xucl"] : 0;
                      $spec_xlcl = !empty($_POST["spec_xlcl"]) ? $_POST["spec_xlcl"] : 0;
                      $spec_rucl = !empty($_POST["spec_rucl"]) ? $_POST["spec_rucl"] : 0;
                      $id = $_POST["id"] ?? null;
                      $item_id = $_POST["item_id"] ?? null;
                      $spec_correction = $_POST["spec_correction"] ?? 0;

                      // Validate required fields
                      if (empty($id) || empty($item_id) || empty($spec_correction)) {
                          handleValidationError("ID, Item ID, and Correction are required fields.");
                          exit;
                      }

                      // Prepare the SQL statement with placeholders
                      $sql = "INSERT INTO specification (spec_sc, spec_csl, spec_usl, spec_lsl, spec_cpk, spec_spl_point, spec_data_spl, spec_xcl, spec_xucl, spec_xlcl, spec_rucl, id, item_id, spec_correction) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                      // Prepare parameters
                      $params = array(
                          $spec_sc, $spec_csl, $spec_usl, $spec_lsl, $spec_cpk, $spec_spl_point,
                          $spec_data_spl, $spec_xcl, $spec_xucl, $spec_xlcl, $spec_rucl, $id, $item_id, $spec_correction
                      );

                      // Execute the query
                      $stmt = sqlsrv_prepare($con, $sql, $params);

                      if ($stmt === false) {
                          handleSQLError(json_encode(sqlsrv_errors()));
                          exit;
                      }

                      $result = sqlsrv_execute($stmt);

                      if ($result === false) {
                          handleSQLError(json_encode(sqlsrv_errors()));
                      } else {
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
                                      <label class="col-sm-3 col-form-label">Process</label>
                                      <div class="col-sm-9">
                                          <?php
                                          include 'includes/connect.php';
                                          $pro = sqlsrv_query($con, "SELECT * FROM process");
                                          ?>
                                          <select data-live-search="true" name="process_id" id="process_id" class="form-control selectpicker" required>
                                              <option value=""> - Please select - </option>
                                              <?php
                                              if ($pro) {
                                                  while ($pr = sqlsrv_fetch_array($pro, SQLSRV_FETCH_ASSOC)) {
                                                      echo '<option value="' . $pr['process_id'] . '">' . $pr['process_name'] . '</option>';
                                                  }
                                              }
                                              ?>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">Part No.</label>
                                      <div class="col-sm-9">
                                          <select data-live-search="true" name="id" id="part_id" class="form-control selectpicker" required>
                                              <option value=""> - Please select - </option>
                                              <!-- Options will be populated dynamically using AJAX -->
                                          </select>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">Item</label>
                                      <div class="col-sm-9">
                                          <select data-live-search="true" name="item_id" id="item_id" class="form-control selectpicker" required>
                                              <option value=""> - Please select - </option>
                                              <!-- Options will be populated dynamically using AJAX -->
                                          </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <script>
                          $(document).ready(function() {
                              $('#process_id').on('change', function() {
                                  var process_id = $(this).val();
                                  if (process_id) {
                                      $.ajax({
                                          url: 'get_parts.php',
                                          type: 'POST',
                                          data: {process_id: process_id},
                                          success: function(data) {
                                              var result = JSON.parse(data);
                                              $('#part_id').html(result.parts);
                                              $('#part_id').selectpicker('refresh');
                                              $('#item_id').html(result.items);
                                              $('#item_id').selectpicker('refresh');
                                          }
                                      });
                                  } else {
                                      $('#part_id').html('<option value=""> - Please select - </option>');
                                      $('#part_id').selectpicker('refresh');
                                      $('#item_id').html('<option value=""> - Please select - </option>');
                                      $('#item_id').selectpicker('refresh');
                                  }
                              });
                          });
                          </script>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">SC</label>
                                      <div class="col-sm-9">
                                          <select data-live-search="true" name="spec_sc" class="form-control selectpicker" required>
                                              <option value="">- Please select - </option>
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
                                          <input type="text" name="spec_xcl" class="form-control" autocomplete="off">
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

                  // Fetch records from the database with pagination
                  $sql = "SELECT * FROM specification INNER JOIN partnumber ON specification.id = partnumber.id INNER JOIN process ON process.process_id=partnumber.process_id INNER JOIN item ON specification.item_id = item.item_id ORDER BY partnumber.pn_no ASC, process.process_name ASC";
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
                          echo "<td class='text-center mt-3'><a class=btn btn-primary href=spec_edit.php?spec_id=".$row['spec_id']."><i class=ti-eraser></i></a></td>";
                          echo "<td class='text-center mt-3'><a class='btn btn-delete btn_del' href=spec_del.php?spec_id=".$row['spec_id']."><i class=ti-trash></i></a></td>";
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

