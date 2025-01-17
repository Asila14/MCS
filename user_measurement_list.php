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
          <div class="col-12 grid-margin">
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
                              <a href="user_measurement_list.php" style="text-decoration: none;">
                                <div><span class="text-light-green" style="font-size: 20px; color: navy;"><b>In Progress</b></span></div>
                              </a>
                              </li>
                              <li>
                                <a href="user_measurement_list_complete.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Complete</span></div>
                              </a>
                              </li>
                            </ul>
                            <div class="list align-items-center pt-3">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10">
                  <h4 class="card-title">Daily Registered Measurement</h4>

                <?php

                include 'includes/connect.php';
                //to add data
                if (isset ($_POST['add'])){
                
                    $item_name = $_POST["item_name"];

                    $sql = "INSERT INTO item (item_name,process_id) VALUES ('$item_name','$process_id')";
                    $result = sqlsrv_query($con,$sql) or die('Database connection error');
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
                <div class="table-responsive">
                  <table id="datatableid" class="table table-sm table-bordered">
                    <thead>
                      <tr class="table-light">
                        <th class='text-center mt-3'>Process</th>
                        <th class='text-center mt-3'>#Emp</th>  
                        <th class='text-center mt-3'>Part No</th>
                        <th class='text-center mt-3'>Lot No</th>
                        <th class='text-center mt-3'>Date & Time Submitted</th>
                        <th class='text-center mt-3'>Status</th>
                        <th class='text-center mt-3'>Manage</th>
                        <th class='text-center mt-3'>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php 

                            date_default_timezone_set('Asia/Kuala_Lumpur');
                            $datetime = date('m/d/Y h:i:s a', time());
                            ?>
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


                      $sql = "SELECT measurement.measure_id, measurement.id, measurement.process_id, measurement.measure_emp, measurement.measure_lot, measurement.measure_datetime, process.process_name, partnumber.pn_no, complete_lot.measure_id AS c_measure_id, complete_lot.id AS c_id FROM measurement 
                      LEFT JOIN complete_lot ON measurement.measure_id = complete_lot.measure_id AND measurement.id = complete_lot.id 
                      INNER JOIN process ON process.process_id = measurement.process_id 
                      INNER JOIN partnumber ON partnumber.id = measurement.id 
                      WHERE complete_lot.measure_id IS NULL AND complete_lot.id IS NULL AND process.process_id='$process_id' 
                      ORDER BY measurement.measure_datetime DESC";

                      $result = sqlsrv_query($con,$sql) or die('Database connection error');
                      if (sqlsrv_has_rows($result) == 0) {
                            echo "<tr>";
                            echo "<td class='text-center mt-3 text-danger' colspan='8'>No Records Found...</td>";
                            echo "</tr>";
                          }else{
                      while ($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
                              echo "<tr>";
                              echo "<td class='text-center mt-3 text-success'><b>".$row['process_name']."</b></td>";
                              echo "<td class='text-center mt-3'>".$row['measure_emp']."</td>";
                              echo "<td class='text-center mt-3 text-danger'><b>".$row['pn_no']."</b></td>";
                              echo "<td class='text-center mt-3'>".$row['measure_lot']."</td>";
                              echo "<td class='text-center mt-3 text-primary'><b>".$row['measure_datetime']->format('d/m/Y h:i:s a')."</b></td>";
                              $measure_id = $row['measure_id'];
                              $id = $row['id'];
                              $sql_check = "SELECT * FROM complete_lot WHERE measure_id = $measure_id AND id= $id ";
                              $result_check = sqlsrv_query($con, $sql_check) or die('Database connection error');
                              $row_check = sqlsrv_fetch_array($result_check, SQLSRV_FETCH_ASSOC);

                              if ($row_check == null) {
                                echo "<td class='text-center mt-3'><label class='badge bg-primary'>In Progress</label></td>";
                              } else {
                                echo "<td class='text-center mt-3'><label class='badge bg-success'>Complete</label></td>";
                              }

                              echo "<td class='text-center mt-3'><a class=btn btn-primary href=user_measure_add.php?measure_id=".$row['measure_id']."&id=".$row['id']."><i class=ti-pencil></i></a></td>";
                              echo "<td class='text-center mt-3'><a class='btn btn-delete btn_del' href=user_measure_del.php?measure_id=".$row['measure_id']."><i class=ti-trash></i></a></td>";
                              echo "</tr>";
                          }
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

