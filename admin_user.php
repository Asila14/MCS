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
                                <div><span class="text-light-green" style="font-size: 20px; color: navy;"><b>User</b></span></div>
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
                              <input class="typeahead" type="text" autocomplete="off" name="user_emp"
                                       class="form-control" required/>
                            </div>
                            <div class="form-group">
                              <label >Name</label>
                              <input class="typeahead" type="text" autocomplete="off" name="user_name"
                                       class="form-control" required pattern="[A-Za-z '-]+"
                                       title="Please use all capital letter" />
                            </div>
                            <div class="form-group">
                              <label >Level</label>
                              <select name="user_level" data-live-search="true" class="form-control selectpicker" required>
                              <!-- <option value="SuperAdmin">SuperAdmin</option> -->
                              <option value="Admin">Admin</option>
                              <option value="User">User</option>
                            </select>
                            </div>
                            <div class="form-group">
                              <label>Select Process</label>
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

                                    $process = sqlsrv_query($con,"SELECT * FROM process WHERE process_id='$process_id'");
                              ?>
                              <input type="hidden" name="process_id" value="<?php if(isset($_POST['process_id'])){echo $_POST['process_id'];} ?>" class="form-control" />
                                  <select name="process_id" data-live-search="true" class="form-control selectpicker" required>
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
                              <select name="user_position" data-live-search="true" class="form-control selectpicker">
                                <option value="Manager">Manager</option> 
                                <option value="Engineer">Engineer</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Group Leader">Group Leader</option>
                                <option value="Operator">Operator</option>
                            </select>
                            </div>
                            <div class="form-group">
                              <label >Password</label>
                              <input class="typeahead" id="psw" type="text" autocomplete="off" name="user_password"
                                       class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
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

                  // Fetch records from the database with pagination
                  $sql = "SELECT * FROM users
                          INNER JOIN process ON users.process_id = process.process_id
                          WHERE users.process_id = '$process_id'
                          AND user_level IN ('User')
                          ORDER BY process_name ASC";

                  $result = sqlsrv_query($con, $sql) or die('Database connection error');

                  // Display the table header
                  echo "<table id='datatableid' class='table table-sm table-bordered'>";
                  echo "<thead>";
                  echo "<tr class='table-light'>";
                  echo "<th class='text-center mt-3'>Emp#</th>";
                  echo "<th class='text-center mt-3'>Name</th>";
                  echo "<th class='text-center mt-3'>Process</th>";
                  echo "<th class='text-center mt-3'>Level</th>";
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
                                echo "<td class='text-center mt-3'>".$row['user_emp']."</td>";
                                echo "<td class='text-center mt-3'>".$row['user_name']."</td>";
                                echo "<td class='text-center mt-3'>".$row['process_name']."</td>";
                                echo "<td class='text-center mt-3'>".$row['user_level']."</td>";
                                echo "<td class='text-center mt-3'><a class=btn btn-primary href=admin_user_edit.php?user_emp=".$row['user_emp']."><i class=ti-eraser></i></a></td>";
                                echo "<td class='text-center mt-3'><a class='btn btn-delete btn_del' href=admin_user_del.php?user_emp=".$row['user_emp']."><i class=ti-trash></i></a></td>";
                                echo "</tr>";             
                    }
                  }
                  echo "</tbody>";
                  echo "</table><br>";

                  // Close the database connection
                  sqlsrv_close($con);
                  ?>
                    <div class="modal-footer">
                    <a href="admin_machine.php" class="btn btn-primary">Next</a>
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
<script>
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
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
