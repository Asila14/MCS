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
                              <!-- <li>
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
                              </li> -->
                              <li>
                                <a href="partno-del-history.php" style="text-decoration: none;">
                                <div><span class="text-light-green" style="font-size: 20px; color: navy;"><b>Part Number</b></span></div>
                              </a>
                              </a>
                              <li>
                                <a href="spec-del-history.php" style="text-decoration: none;">
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
                  <h4 class="card-title">Delete History</h4>
                  <div class="table-responsive">
                  <?php
include 'includes/connect.php';

// Fetch records from the database with pagination
$sql = "SELECT * FROM deleted_partnumber 
inner join process ON deleted_partnumber.process_id=process.process_id  
inner join customer ON deleted_partnumber.cust_id=customer.cust_id 
inner join package ON deleted_partnumber.pack_id=package.pack_id 
inner join material ON deleted_partnumber.material_id=material.material_id 
inner join users ON deleted_partnumber.user_emp=users.user_emp
ORDER BY process_name ASC";
$result = sqlsrv_query($con, $sql);

// Check for query execution errors
if ($result === false) {
    if (($errors = sqlsrv_errors()) != null) {
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
            echo "Code: " . $error['code'] . "<br />";
            echo "Message: " . $error['message'] . "<br />";
        }
    } else {
        echo "Database connection error";
    }
    die();
}

// Display the table header
echo "<table id='datatableid' class='table table-sm table-bordered'>";
echo "<thead>";
echo "<tr class='table-light'>";
echo "<th class='text-center mt-3'>Process</th>";
echo "<th class='text-center mt-3'>Part No</th>";
echo "<th class='text-center mt-3'>Category</th>";
echo "<th class='text-center mt-3'>Customer</th>";
echo "<th class='text-center mt-3'>Package</th>";
echo "<th class='text-center mt-3'>Material</th>";
echo "<th class='text-center mt-3'>Deleted By</th>";
echo "<th class='text-center mt-3'>Date Deleted</th>";
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
        echo "<td class='text-center mt-3'>".$row['process_name']."</td>";
        echo "<td class='text-center mt-3'>".$row['pn_no']."</td>";
        echo "<td class='text-center mt-3'>".$row['category']."</td>";
        echo "<td class='text-center mt-3'>".$row['cust_name']."</td>";
        echo "<td class='text-center mt-3'>".$row['pack_name']."</td>";
        echo "<td class='text-center mt-3'>".$row['material_part']."</td>";
        echo "<td class='text-center mt-3'>".$row['user_emp']."</td>";
        echo "<td class='text-center mt-3'>".$row['deleted_at']->format('d-m-Y H:i:s')."</td>";
        echo "</tr>";     
    }
}
echo "</tbody>";
echo "</table><br>";

// Close the database connection
sqlsrv_close($con);
?>


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

