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
                                <a href="user_user.php" style="text-decoration: none;">
                                <div><span class="text-light-green" style="font-size: 20px; color: navy;"><b>User</b></span></div>
                              </a>
                              </li>
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
                  <h4 class="card-title">Register User
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddUsers">
                    <i class="ti-plus"></i>
                  </button></h4>
                  <!-- Modal -->
                <?php

              include 'includes/connect.php';

              //to add data
              if (isset ($_POST['add'])){

                $user_name = $_POST["user_name"];
                $user_emp = $_POST["user_emp"];
                $process_id = $_POST["process_id"];

                // Check if the user_name already exists
                $sql = "SELECT * FROM users WHERE user_emp = '$user_emp' AND process_id='$process_id' ";
                $result = sqlsrv_query($con,$sql);

                if (sqlsrv_num_rows($result) > 0) {
                  // The user_name already exists
                  echo '
                    <script>
                      swal({
                        title: "Failed!",
                        text: "Data already exists!",
                        icon: "error",
                        button: "OK",
                      });
                    </script>
                  ';
                } else {

                  $user_emp = $_POST["user_emp"];
                  $user_name = $_POST["user_name"];
                  $user_level = $_POST["user_level"];
                  $process_id = $_POST["process_id"];
                  $user_position = $_POST["user_position"];
                  $user_password = $_POST["user_password"];
                  // The user_name does not exist
                  $sql = "INSERT INTO users (user_emp,user_name,user_level,process_id,user_password,user_position) VALUES ('$user_emp','$user_name','$user_level','$process_id', '$user_password','$user_position')";
                  $result = sqlsrv_query($con,$sql);

                  if ($result) {
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
              }

              ?>



                <div class="modal fade" id="AddUsers" tabindex="-1" aria-labelledby="AddUsersLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New User</h1>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" action="" method="post">
                            <div class="form-group">
                              <label >Emp#</label>
                              <input type="text" id="user_emp" name="user_emp" class="form-control">
                            </div>
                            <div class="form-group">
                              <label >Name</label>
                              <input type="text" name="user_name" class="form-control">
                            </div>
                            <div class="form-group">
                              <label >Level</label>
                              <select name="user_level" class="form-control">
                              <option value="SuperAdmin">SuperAdmin</option>
                              <option value="Admin">Admin</option>
                              <option value="User">User</option>
                            </select>
                            </div>
                            <div class="form-group">
                              <label>Select Process</label>
                              <?php
                                    include 'includes/connect.php';
                                    $process = sqlsrv_query($con,"SELECT * FROM process ");
                              ?>
                              <input type="hidden" name="process_id" value="<?php if(isset($_POST['process_id'])){echo $_POST['process_id'];} ?>" class="form-control" />
                                  <select name="process_id" class="form-control">
                                    <?php 
                                    if($process > 0) {
                                     while($p = sqlsrv_fetch_array($process,SQLSRV_FETCH_ASSOC)){
                                    
                                    ?>
                                      <option name="process_id" value="<?php echo $p['process_id']?> "><?php echo $p['process_name']; ?>
                                        <?php } } ?></option>
                                  </select>
                            </div>
                            <div class="form-group">
                              <label >Position</label>
                              <select name="user_position" class="form-control">
                                <option value="Manager">Manager</option>
                                <option value="Engineer">Engineer</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Group Leader">Group Leader</option>
                                <option value="Operator">Operator</option>
                            </select>
                            </div>
                            <div class="form-group">
                              <label >Password</label>
                              <input type="password" id="user_password" name="user_password" class="form-control">
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

                <form action="" method="POST">
                    <h6 class="text-warning">If USER is not listed, please REGISTER. </h6>
                    <div class="row">
                      <div class="form-group row">
                        <div class="col-md-12">
                          <input type="text" class="form-control" id="search" name="" autocomplete="off" placeholder="Search...">
                          <div id="no-results-message" style="display: none; color: red;">Record not found...</div>
                          <br>
                        </div>
                      </div>
                </div>
              </form>
                  <div class="table-responsive">
                    <table id="datatableid" class="table table-sm table-bordered">
                      <thead>
                        <tr class="table-light">
                          <th class='text-center mt-3'>Emp#</th>
                          <th class='text-center mt-3'>Name</th>
                          <th class='text-center mt-3'>Process</th>
                          <th class='text-center mt-3'>Level</th>
                        </tr>
                      </thead>
                      <tbody class="table table-sm">
                        <?php
                        include 'includes/connect.php';
                        if(isset($_GET['user_id'])){

                            $user_id=$_GET['user_id'];
                            $delete = sqlsrv_query($con,"DELETE FROM users WHERE user_id='$user_id'");

                        }

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

                        $sql1 = "SELECT * FROM users inner join process ON users.process_id=process.process_id WHERE users.process_id=$process_id";
                        $result1 = sqlsrv_query($con,$sql1) or die('Database connection error');
                        while ($row = sqlsrv_fetch_array($result1,SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td class='text-center mt-3'>".$row['user_emp']."</td>";
                                echo "<td class='text-center mt-3'>".$row['user_name']."</td>";
                                echo "<td class='text-center mt-3'>".$row['process_name']."</td>";
                                echo "<td class='text-center mt-3'>".$row['user_level']."</td>";
                                echo "</tr>";
                            }
                        ?>
                      </tbody>
                    </table>
                    <div class="modal-footer">
                    <a href="user_machine.php" class="btn btn-primary">Next</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
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

