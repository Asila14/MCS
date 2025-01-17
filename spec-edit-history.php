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
                              </li>
                              <li>-->
                                <a href="partno-edit-history.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Part Number</span></div>
                              </a>
                              </li> 
                              <li>
                                <a href="spec-edit-history.php" style="text-decoration: none;">
                                <div><span class="text-light-green" style="font-size: 20px; color: navy;"><b>Specification</b></span></div>
                              </a>
                              </li>
                            </ul>
                            <div class="list align-items-center pt-3">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10">
                  <h4 class="card-title">Spec History</h4>
                  <div class="table-responsive">
                  <?php
include 'includes/connect.php';

// Fetch records from the database with pagination
$sql = "SELECT * FROM spec_history 
        INNER JOIN partnumber ON spec_history.id = partnumber.id 
        INNER JOIN process ON process.process_id = partnumber.process_id 
        INNER JOIN item ON spec_history.item_id = item.item_id 
        INNER JOIN users ON users.user_id = spec_history.user_id 
        ORDER BY datetime DESC";
$result = sqlsrv_query($con, $sql) or die('Database connection error');

// Display the table header
echo "<table id='datatableid' class='table table-sm table-bordered'>";
echo "<thead>";
echo "<tr class='table-light'>";
echo "<th class='text-center mt-3'>#PN</th>";
echo "<th class='text-center mt-3'>Process</th>";
echo "<th class='text-center mt-3'>Item</th>";
echo "<th class='text-center mt-3'>SC</th>";
echo "<th class='text-center mt-3'>CSL</th>";
echo "<th class='text-center mt-3'>USL</th>";
echo "<th class='text-center mt-3'>LSL</th>";
echo "<th class='text-center mt-3'>Cpk</th>";
echo "<th class='text-center mt-3'>Spl Size</th>";
echo "<th class='text-center mt-3'>Data/Spl</th>";
echo "<th class='text-center mt-3'>XCL</th>";
echo "<th class='text-center mt-3'>XUCL</th>";
echo "<th class='text-center mt-3'>XLCL</th>";
echo "<th class='text-center mt-3'>RUCL</th>";
echo "<th class='text-center mt-3'>Attempt Limit</th>";
echo "<th class='text-center mt-3'>Edited By</th>";
echo "<th class='text-center mt-3'>Date Submited</th>";
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
        echo "<td class='text-center mt-3 text-primary'><b>".$row['pn_no']."</b></td>";
        echo "<td class='text-center mt-3 text-info'><b>".$row['process_name']."</b></td>";
        echo "<td class='text-center mt-3 text-success'><b>".$row['item_name']."</b></td>";
        echo "<td class='text-center mt-3'>".$row['spec_sc']."</td>";
        echo "<td class='text-center mt-3'>".$row['spec_csl']."</td>";
        echo "<td class='text-center mt-3'>".$row['spec_usl']."</td>";
        echo "<td class='text-center mt-3'>".$row['spec_lsl']."</td>";
        echo "<td class='text-center mt-3'>".$row['spec_cpk']."</td>";
        echo "<td class='text-center mt-3'>".$row['spec_spl_point']."</td>";
        echo "<td class='text-center mt-3'>".$row['spec_data_spl']."</td>";
        echo "<td class='text-center mt-3'>".$row['spec_xcl']."</td>";
        echo "<td class='text-center mt-3'>".$row['spec_xucl']."</td>";
        echo "<td class='text-center mt-3'>".$row['spec_xlcl']."</td>";
        echo "<td class='text-center mt-3'>".$row['spec_rucl']."</td>";
        echo "<td class='text-center mt-3'>".$row['spec_correction']."</td>";
        echo "<td class='text-center mt-3'>".$row['user_emp']."</td>";
        echo "<td class='text-center mt-3'>".$row['datetime']->format('Y-m-d H:i:s')."</td>";
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

