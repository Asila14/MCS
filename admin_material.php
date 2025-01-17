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
                                <div><span class="text-light-green" style="font-size: 20px; color: navy;"><b>Material</b></span></div>
                              </a>
                              </li>
                              <li>
                                <a href="admin_partno.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Part Number</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="admin_spec.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Specification</span></div>
                              </a>
                              </li>
                            </ul>
                            <div class="list align-items-center pt-3">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10">
                  <h4 class="card-title">Registered Material
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddMaterial">
                    <i class="ti-plus"></i>
                  </button></h4>
                  <!-- Modal -->
                <?php

                include 'includes/connect.php';
                //to add data
                if (isset ($_POST['addmc'])){

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

                    $material_type = $_POST["material_type"];
                    $material_part = $_POST["material_part"];

                    $sql = "INSERT INTO material (material_type, material_part,process_id) VALUES ('$material_type', '$material_part','$process_id')";
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
                <div class="modal fade" id="AddMaterial" tabindex="-1" aria-labelledby="AddMaterialLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Material</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" action="" method="post">
                            <div class="form-group">
                              <label>Material Type</label>
                              <input type="text" name="material_type" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Material Part</label>
                              <input type="text" name="material_part" autocomplete="off" class="form-control">
                            </div>
                            <div class="modal-footer">
                            
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="addmc" class="btn btn-primary">Submit</button>
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
                  $sql = "SELECT * FROM material inner join process ON material.process_id=process.process_id WHERE process.process_id='$process_id' ORDER BY process_name ASC";
                  $result = sqlsrv_query($con, $sql) or die('Database connection error');

                  // Display the table header
                  echo "<table id='datatableid' class='table table-sm table-bordered'>";
                  echo "<thead>";
                  echo "<tr class='table-light'>";
                  echo "<th class='text-center mt-3'>Type</th>";
                  echo "<th class='text-center mt-3'>Part</th>";
                  echo "<th class='text-center mt-3'>Process</th>";
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
                          echo "<td class='text-center mt-3'>".$row['material_type']."</td>";
                          echo "<td class='text-center mt-3'>".$row['material_part']."</td>";
                          echo "<td class='text-center mt-3'>".$row['process_name']."</td>";
                          echo "<td class='text-center mt-3'><a class=btn btn-primary href=admin_material_edit.php?material_id=".$row['material_id']."><i class=ti-eraser></i></a></td>";
                          echo "<td class='text-center mt-3'><a class='btn btn-delete btn_del' href=admin_material_del.php?material_id=".$row['material_id']."><i class=ti-trash></i></a></td>";
                          echo "</tr>";        
                    }
                  }
                  echo "</tbody>";
                  echo "</table><br>";

                  // Close the database connection
                  sqlsrv_close($con);
                  ?>
                    
                    <div class="modal-footer">
                    <a href="admin_partno.php" class="btn btn-primary">Next</a>
                    </div>
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

