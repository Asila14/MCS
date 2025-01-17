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
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
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
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                      <div class="col-md-12">
                  <h4 class="card-title">Add New Feedback
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddUsers">
                    <i class="ti-plus"></i>
                  </button></h4>
                  <!-- Modal -->
                <div class="modal fade" id="AddUsers" tabindex="-1" aria-labelledby="AddUsersLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Feedback</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                    <form action="" method="POST"> 
                        <div class="form-group">
                          <label>Image upload</label>
                          <input type="hidden" name="feed_image" id="feed_image" required>
                          <input type="file" name="feed_image" id="feed_image" class="form-control file-upload-info" name="file-upload-info" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea1">Comment</label>
                            <textarea name="feed_comment" class="form-control" id="exampleTextarea1" rows="4" required></textarea>
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
                          <th class='text-center mt-3'>Image</th>
                          <th class='text-center mt-3'>Comment</th>
                        </tr>
                      </thead>
                      <tbody class="table table-sm">
                        <?php
                        include 'includes/connect.php';

                        $sql1 = "SELECT * FROM feedback inner join users ON users.user_id=feedback.user_id INNER JOIN process ON process.process_id=users.process_id";
                        $result1 = sqlsrv_query($con,$sql1) or die('Database connection error');
                        if (sqlsrv_has_rows($result1) == 0) {
                              echo "<tr>";
                              echo "<td class='text-center mt-3 text-danger' colspan='6'>No Records Found...</td>";
                              echo "</tr>";
                            }else{
                        while ($row = sqlsrv_fetch_array($result1,SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td class='text-center mt-3'>".$row['user_emp']."</td>";
                                echo "<td class='text-center mt-3'>".$row['user_name']."</td>";
                                echo "<td class='text-center mt-3'>".$row['process_name']."</td>";
                                echo "<td class='text-center mt-3'>".$row['user_level']."</td>";
                                echo "<td class='text-center mt-3'>".$row['feed_image']."</td>";
                                echo "<td class='text-center mt-3'>".$row['feed_comment']."</td>";
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
        </form>
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

