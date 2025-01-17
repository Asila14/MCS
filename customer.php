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
                              <a href="user.php" style="text-decoration: none;">
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
                                <div><span class="text-light-green" style="font-size: 20px; color: navy;"><b>Customer</b></span></div>
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
                  <h4 class="card-title">Register Customer
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddCustomer">
                    <i class="ti-plus"></i>
                  </button></h4>
                  <!-- Modal -->
                    <?php

                    if (isset ($_POST['add'])){

                      $cust_name = $_POST["cust_name"];

                      // Check if the cust_name already exists in the database
                      $sql = "SELECT * FROM customer WHERE cust_name  LIKE '%$cust_name%'";
                      $result = sqlsrv_query($con,$sql);

                      // If the cust_name already exists in the database, show an error message
                      if (sqlsrv_has_rows($result) > 0) {
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
                          // The cust_name does not exist in the database, so insert the new data
                          $sql = "INSERT INTO customer(cust_name) VALUES('$cust_name')";
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
                <div class="modal fade" id="AddCustomer" tabindex="-1" aria-labelledby="AddCustomerLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Customer</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" action="" method="post">
                            <div class="form-group">
                              <label >Customer Name</label>
                              <input id="inputcust" type="text" name="cust_name" class="form-control">
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
                  <div>
                    <table id="datatableid" class="table table-sm table-bordered">
                      <thead >
                        <tr class="table-light">
                          <th class='text-center mt-3'>Customer</th>
                          <th class='text-center mt-3'>Edit</th>
                          <th class='text-center mt-3'>Delete</th>
                        </tr>
                      </thead>
                      <tbody class="table table-sm">
                        <?php
                        include 'includes/connect.php';
                        $sql = "SELECT * FROM customer ORDER BY cust_name ASC";
                        $result = sqlsrv_query($con,$sql) or die('Database connection error');
                        if (sqlsrv_has_rows($result) == 0) {
                              echo "<tr>";
                              echo "<td class='text-center mt-3 text-danger' colspan='4'>No Records Found...</td>";
                              echo "</tr>";
                            }else{
                        while ($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td class='text-center mt-3'>".$row['cust_name']."</td>";
                                echo "<td class='text-center mt-3'><a class=btn btn-primary href=cust_edit.php?cust_id=".$row['cust_id']."><i class=ti-eraser></i></a></td>";
                                echo "<td class='text-center mt-3'><a class='btn btn-delete btn_del' href=cust_del.php?cust_id=".$row['cust_id']."><i class=ti-trash></i></a></td>";
                                echo "</tr>";
                            }
                          }
                        ?>
                      </tbody>
                    </table>
                    <br>
                    <div class="modal-footer">
                    <a href="package.php" class="btn btn-primary">Next</a>
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
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

        <!-- DataTables Bootstrap 5 script -->
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>


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


