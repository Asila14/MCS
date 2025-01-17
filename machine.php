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
                                <div><span class="text-light-green"style="font-size: 20px; color: navy;"><b>Machine</b></span></div>
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
                  <h4 class="card-title">Register Machine
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddMachine">
                    <i class="ti-plus"></i>
                  </button></h4>
                  <!-- Modal -->
                <?php

                include 'includes/connect.php';
                //to add data
                if (isset ($_POST['addMc'])){

                    $mc_name = $_POST["mc_name"];
                    $process_id = $_POST["process_id"];
                    // Get the user's employee number from the session variable.
                        $user_emp = $_SESSION['user_emp'];

                        // Query the database to get the user's process ID.
                        $sql = "SELECT * FROM users WHERE user_emp = '$user_emp'";
                        $result = sqlsrv_query($con, $sql);
                        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

                        // Set the user's process ID in the session variable.
                        $_SESSION['user_id'] = $row['user_id'];

                        // Get the process ID from the session variable.
                        $user_id = $_SESSION['user_id'];
                    date_default_timezone_set('Asia/Kuala_Lumpur');
                    $mc_date_time = date("Y-m-d H:i:s");


                    // Check if the user_name already exists
                  $sql = "SELECT * FROM machine WHERE mc_name LIKE '%$mc_name%'";
                  $result = sqlsrv_query($con,$sql);

                  if (sqlsrv_has_rows($result) > 0) {
                    // The user_name already exists
                    echo "
                          <script src='sweetalert2.all.min.js'></script>
                          <script>
                            Swal.fire({
                                title: 'Failed!',
                                text: 'Data already exists!',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        </script>";
                  } else {
                        date_default_timezone_set('Asia/Kuala_Lumpur');
                        $mc_date_time = date("Y-m-d H:i:s");
                          // The cust_name does not exist in the database, so insert the new data
                          $sql = "INSERT INTO machine (mc_name,process_id,user_id,mc_date_time) VALUES ('$mc_name','$process_id','$user_id','$mc_date_time')";
                          $result = sqlsrv_query($con,$sql);

                          // If the insert query succeeded, show a success message
                          if ($result) {
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
                              <label>Select Process</label>
                              <?php
                                    include 'includes/connect.php';
                                    $process = sqlsrv_query($con,"SELECT * FROM process ");
                              ?>
                              <input type="hidden" name="process_id" value="<?php if(isset($_POST['process_id'])){echo $_POST['process_id'];} ?>" class="form-control" />
                                  <select data-live-search="true" name="process_id" class="form-control selectpicker">
                                    <?php 
                                    if($process > 0) {
                                     while($p = sqlsrv_fetch_array($process,SQLSRV_FETCH_ASSOC)){
                                    
                                    ?>
                                      <option name="process_id" value="<?php echo $p['process_id']?> "><?php echo $p['process_name']; ?>
                                        <?php } } ?></option>
                                  </select>
                            </div>
                            <div class="form-group">
                              <label>Machine Name</label>
                              <input type="text" name="mc_name" autocomplete="off" class="form-control">
                            </div>
                            <div class="modal-footer">
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
                          <th class='text-center mt-3'>Edit</th>
                          <th class='text-center mt-3'>Delete</th>
                        </tr>
                      </thead>
                      <tbody class="table table-sm">
                        <?php
                        include 'includes/connect.php';

                        $sql1 = "SELECT * FROM machine inner join process ON machine.process_id=process.process_id ORDER BY process.process_name ASC";
                        $result1 = sqlsrv_query($con,$sql1) or die('Database connection error');
                        if (sqlsrv_has_rows($result1) == 0) {
                          echo "<tr>";
                          echo "<td class='text-center mt-3 text-danger' colspan='5'>No Records Found...</td>";
                          echo "</tr>";
                        }else{

                          while ($row = sqlsrv_fetch_array($result1,SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td class='text-center mt-3'>".$row['mc_name']."</td>";
                                echo "<td class='text-center mt-3'>".$row['process_name']."</td>";
                                echo "<td class='text-center mt-3'><a class=btn btn-primary href=machine_edit.php?mc_id=".$row['mc_id']."><i class='ti-eraser'></i></a></td>";
                                echo "<td class='text-center mt-3'><a class='btn btn-delete btn_del' href=machine_del.php?mc_id=".$row['mc_id']."><i class='ti-trash'></i></a></td>";
                                
                            }
                              
                          }
                        ?>
                      </tbody>
                    </table>
                    <br>
                    <div class="modal-footer">
                    <a href="item.php" class="btn btn-primary">Next</a>
                    </div>
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

