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
                                <div><span class="text-light-green" style="font-size: 20px; color: navy;"><b>Process</b></span></div>
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
                  <h4 class="card-title">Register Process
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddProcess">
                    <i class="ti-plus"></i>
                  </button></h4>
                <?php

                include 'includes/connect.php';

                //to add data
                if (isset ($_POST['add'])){

                  $process_name = $_POST["process_name"];
                  $process_code = $_POST["process_code"];

                  // Check if the user_name already exists
                  $sql = "SELECT * FROM process WHERE process_name  LIKE '%$process_name%'";
                  $result = sqlsrv_query($con,$sql);

                  if (sqlsrv_has_rows($result) > 0) {
                    // The user_name already exists
                    echo "
                          <script src='cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                          <script>
                            Swal.fire({
                                title: 'Failed!',
                                text: 'Data already exists!',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        </script>";
                  } else {
                          // The cust_name does not exist in the database, so insert the new data
                          $sql = "INSERT INTO process(process_name,process_code) VALUES('$process_name','$process_code')";
                          $result = sqlsrv_query($con,$sql);

                          // If the insert query succeeded, show a success message
                          if ($result) {
                              echo "
                              <script src='cdn.jsdelivr.net/npm/sweetalert2@11'></script>
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
                              <script src='cdn.jsdelivr.net/npm/sweetalert2@11'></script>
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
                            <div class="form-group">
                              <label>Process Code</label>
                              <input type="text" id="process_code" name="process_code" class="form-control">
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
              <div class="row">
                  <div class="table-responsive">
                    <?php
                    include 'includes/connect.php';

                    // Fetch records from the database with pagination
                    $sql = "SELECT * FROM process ORDER BY process_name ASC";
                    $result = sqlsrv_query($con, $sql) or die('Database connection error');

                    // Display the table header
                    echo "<table id='datatableid' class='table table-sm table-bordered'>";
                    echo "<thead>";
                    echo "<tr class='table-light'>";
                    echo "<th class='text-center mt-3'>Process</th>";
                    echo "<th class='text-center mt-3'>Code</th>";
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
                            echo "<tr style=height:40px>";
                            echo "<td class='text-center mt-3'>".$row['process_name']."</td>";
                            echo "<td class='text-center mt-3'>".$row['process_code']."</td>";
                            echo "<td class='text-center mt-3'><a class=btn btn-primary href=process_edit.php?process_id=".$row['process_id']."><i class=ti-eraser></i></a></td>";
                            echo "<td class='text-center mt-3'><a class='btn btn-delete btn_del' href='process_del.php?process_id=".$row['process_id']."'><i class='ti-trash'></i></a></td>";
                            echo "</tr>";             
                        }
                    }
                    echo "</tbody>";
                    echo "</table><br>";
                    ?>

                      </tbody>
                    </table>
                    <script type="text/javascript">
                      $('btn_del').on('click',function(e)){
                        e.preventDefault();
                        const href = $(this).attr('href')

                        Swal.fire({
                          title : 'Are You Sure?',
                          text : 'Record will be deleted?',
                          type : 'warning',
                          showCancelButton : true,
                          
                        })
                      }
                    </script>
                    <div class="modal-footer">
                    <a href="user.php" class="btn btn-primary">Next</a>
                    </div>
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

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Bootstrap 5 CSS -->
        <link rel="stylesheet" href="path/to/bootstrap-5.min.css">

        <!-- DataTables Bootstrap 5 CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

        <!-- DataTables jQuery script -->
        <script src="datatable1.js"></script>

        <!-- DataTables Bootstrap 5 script -->
        <script src="datatable2.js"></script>


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