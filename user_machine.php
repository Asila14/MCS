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
                                <div><span class="text-light-green" style="font-size: 20px; color: navy;"><b>Machine</b></span></div>
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
                                <div><span class="text-light-green">Specification</span></div>
                              </a>
                              </li>
                            </ul>
                            <div class="list align-items-center pt-3">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                  <h4 class="card-title">Registered Machine</h4>
                  <!-- Modal -->
                <?php

                include 'includes/connect.php';
                //to add data
                if (isset ($_POST['addMc'])){

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

                        $mc_name = $_POST["mc_name"];

                    $sql = "INSERT INTO machine (mc_name,process_id) VALUES ('$mc_name','$process_id')";
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
                              <label>Machine Name</label>
                              <input type="text" name="mc_name" autocomplete="off" class="form-control">
                            </div>
                            <div class="modal-footer">
                            <input type="hidden" name="process_id" value="<?php if(isset($_POST['process_id'])){echo $_POST['process_id'];} ?>" class="form-control" />
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="addMc" class="btn btn-primary">Submit</button>
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
                          <th class='text-center mt-3'>Machine</th>
                          <th class='text-center mt-3'>Process</th>
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

                        $sql1 = "SELECT * FROM machine inner join process ON machine.process_id=process.process_id WHERE process.process_id=$process_id ";
                        $result1 = sqlsrv_query($con,$sql1) or die('Database connection error');
                        while ($row = sqlsrv_fetch_array($result1,SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td class='text-center mt-3'>".$row['mc_name']."</td>";
                                echo "<td class='text-center mt-3'>".$row['process_name']."</td>";
                                echo "</tr>";
                            }
                        ?>
                      </tbody>
                    </table>
                    <div class="modal-footer">
                    <a href="user_item.php" class="btn btn-primary">Next</a>
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
