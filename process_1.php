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
  <link rel="shortcut icon" href="images/favicon.png" />
  <link src="sweetalert.js"></link>
  <script src="library/dselect.js"></script>
  <link rel="stylesheet" href="deliver.css">
  <!-- Add this line in your <head> section -->
  <link rel="stylesheet" href="dataTables.css">
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
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

          <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <form class="form-sample">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group row">
                          <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <h4 class="card-title card-title-dash">Activities</h4>
                </div>
                <ul class="bullet-line-list">
                  <li>
                    <div class="d-flex justify-content-between">
                    <div><span class="text-light-green" style="font-size: 20px; color: navy;"><b>Process</b></span></div>
                  </div>
                  </li>
                  <li>
                    <div class="d-flex justify-content-between" class="align-items-center">
                      <div><span class="text-light-green">User</span></div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex justify-content-between">
                      <div><span class="text-light-green">Customer</span></div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex justify-content-between">
                      <div><span class="text-light-green">Item</span></div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex justify-content-between">
                      <div><span class="text-light-green">Material</span></div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex justify-content-between">
                      <div><span class="text-light-green">Machine</span></div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex justify-content-between">
                      <div><span class="text-light-green">Part Number</span></div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex justify-content-between">
                      <div><span class="text-light-green">Specification</span></div>
                    </div>
                  </li>
                </ul>
                <div class="list align-items-center pt-3">
                </div>
              </div>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="form-group row">
                <div class="card-body">
                  <h4 class="card-title">Register Process
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddProcess">
                    <i class="ti-plus"></i>
                  </button></h4>

                  <br>                
                  <?php

                include 'includes/connect.php';

                //to add data

                $output = "";
                if (isset ($_POST['add'])){

                  $process_name = $_POST["process_name"];

                  // Check if the process_name already exists
                  $get_process = sqlsrv_query($con,"SELECT * FROM process WHERE process_name = '$process_name'");
                  $checkprocess = sqlsrv_num_rows($get_process);

                  if ($checkprocess > 0) {
                    // The process_name already exists
                    $output .="<p class='alert alert-danger'>Process Already Exist !</p>";
                  } else {

                    $query = "INSERT INTO process(process_name) VALUES('$process_name')";
                    $res = sqlsrv_query($con,$query);

                    if ($res){
                      $output .= "<p class='alert alert-success'>Sucessfully add new process</p>";
                    }else{
                      $output .= "<p class='alert alert-danger'>Failed to add new process</p>";
                    }

                  }
                }

                ?> 
                <?php

                include 'includes/connect.php';

                //to add data
                if (isset ($_POST['add'])){

                  $process_name = $_POST["process_name"];

                  // Check if the user_name already exists
                  $sql = "SELECT COUNT(*) FROM process WHERE process_name = '$process_name'";
                  $result = sqlsrv_query($con,$sql);

                  if (sqlsrv_has_rows($result) > 0) {
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
                    // The user_name does not exist
                    $sql = "INSERT INTO process(process_name) VALUES('$process_name')";
                    $result = sqlsrv_query($con,$sql);

                    if (sqlsrv_has_rows($con) > 0) {
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
                <div class="modal fade" id="AddProcess" tabindex="-1" aria-labelledby="AddProcessLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Process</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" action="" method="post">
                            <div class="form-group">
                              <label>Process Name</label>
                              <input type="text" id="process_name" name="process_name" class="form-control">
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
                <!-- <div><?php echo $output; ?></div> -->
                <form action="" method="POST">
                    <h6 class="text-warning">If PROCESS is not listed, please REGISTER. </h6>
                    <div class="row">
                      <div class="form-group row">
                        <div class="col-md-12">
                          <input type="text" class="form-control" id="search" name="" autocomplete="off" placeholder="Search...">
                          <div id="no-results-message" style="display: none; color: red;">Record not found.</div>
                          <br>
                      </div>
                </div>
              </form>
              <div class="row">
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                      <thead>
                        <tr class="table-light">
                          <th class='text-center mt-3'>Process</th>
                          <th class='text-center mt-3'>Edit</th>
                          <th class='text-center mt-3'>Delete</th>
                        </tr>
                      </thead>
                      <tbody class="table table-sm">
                        <?php
                        include 'includes/connect.php';
                        $sql = "SELECT * FROM process ";
                        $result = sqlsrv_query($con,$sql) or die('Database connection error');
                        while ($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
                                echo "<tr style=height:40px>";
                                echo "<td class='text-center mt-3'>".$row['process_name']."</td>";
                                echo "<td class='text-center mt-3'><a class=btn btn-primary href=process_edit.php?process_id=".$row['process_id']."><i class=ti-eraser></i></a></td>";
                                echo "<td class='text-center mt-3'><a class=btn btn-primary href=process_del.php?process_id=".$row['process_id']."><i class=ti-trash></i></a></td>";
                                echo "</tr>";
                            }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </form>
          </div>
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
