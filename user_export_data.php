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
                  <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Data Analysis</h4>
                  <div class="table-responsive">
                    <div class="form-group">
                  <a href="export.php" download="measurement.csv" id="export-button" name="export" class="btn btn-success">Export to Excel</a>
                  <a href="export_CSV.php" download="measurement.csv" id="export-button" name="export" class="btn btn-warning">Export to CSV</a>
                    </div>
                    <table id="emp-table" class="table table-bordered">
						<thead class="thead-dark">
							<tr class="table-secondary">
								<th col-index = "1" class="text-center mt-3">Process<br></th>
								<th col-index = "2"  class="text-center mt-3">Insp. Date<br></th>
								<th col-index = "3"  class="text-center mt-3">PN<br></th>
								<th col-index = "4"  class="text-center mt-3">LN<br></th>
								<th col-index = "5"  class="text-center mt-3">Item<br></th>
								<th col-index = "6"  class="text-center mt-3">Avg</th>
								<th col-index = "7"  class="text-center mt-3">Max</th>
								<th col-index = "8"  class="text-center mt-3">Min</th>
								<th col-index = "9"  class="text-center mt-3">Range</th>
								<th col-index = "10"  class="text-center mt-3">Std.</th>
								<th col-index = "11"  class="text-center mt-3">CPK</th>
								<th col-index = "12"  class="text-center mt-3">Result</th>
								<th col-index = "13"  class="text-center mt-3">Emp#<br></th>
								<th col-index = "14"  class="text-center mt-3">MC#<br></th>
								<th col-index = "15"  class="text-center mt-3">Material</th>
								<th col-index = "16"  class="text-center mt-3">Material Lot</th>
								<th col-index = "17"  class="text-center mt-3">LSL</th>
								<th col-index = "18"  class="text-center mt-3">CSL</th>
								<th col-index = "19"  class="text-center mt-3">USL</th>
								<th col-index = "20"  class="text-center mt-3">XCL</th>
								<th col-index = "21"  class="text-center mt-3">XUCL</th>
								<th col-index = "22"  class="text-center mt-3">XLCL</th>
								<th col-index = "23"  class="text-center mt-3">RUCL</th>
							</tr>
						</thead>
                        <tbody>
                       <?php

                       // Fetch records from database
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

                          // Fetch records from database
                          include 'includes/connect.php';
                          $sql = "SELECT * FROM spec_result INNER JOIN measurement ON spec_result.measure_id=measurement.measure_id INNER JOIN process ON process.process_id=measurement.process_id INNER JOIN partnumber ON partnumber.id=spec_result.id INNER JOIN specification ON specification.spec_id=spec_result.spec_id INNER JOIN item ON specification.item_id=item.item_id INNER JOIN machine ON measurement.mc_id=machine.mc_id INNER JOIN material ON measurement.material_id=material.material_id WHERE measurement.process_id='$process_id' ORDER BY measure_datetime DESC";
                          $result = sqlsrv_query($con,$sql) or die('Database connection eror');
                          if (sqlsrv_has_rows($result) == 0) {
                              echo "<tr>";
                              echo "<th class='text-center mt-3 text-danger' colspan='24'>No Records Found...</th>";
                              echo "</tr>";
                            }else{
                              // Iterate through the results and display them in the table
                              while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
                                  echo '<tr>';
                                  echo '<td class="text-center mt-3">' . $row['process_name'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['measure_datetime']->format('d-m-y') . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['pn_no'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['measure_lot'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['item_name'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['result_avg'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['result_max'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['result_min'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['result_range'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['result_std'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['result_cpk'] . '</td>';
                                  if($row['result_judgement'] == 'pass'){
                                    echo '<td class="text-center mt-3"><label class="badge bg-success"><b>' . $row['result_judgement'] . '</b></label></td>';
                                  }else{
                                    echo '<td class="text-center mt-3"><label class="badge bg-danger"><b>' . $row['result_judgement'] . '</b></label></td>';
                                  }
                                  echo '<td class="text-center mt-3">' . $row['measure_emp'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['mc_name'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['material_part'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['measure_mate_lot'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['spec_lsl'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['spec_csl'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['spec_usl'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['spec_xcl'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['spec_xucl'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['spec_xlcl'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['spec_rucl'] . '</td>';
                                  echo '</tr>';
                              }
                          }
                          ?>
                        </tbody>
						<tfoot class="thead-dark">
                            <tr class="table-secondary">
                                <th col-index = "1" class="text-center mt-3">Process</th>
                                <th col-index = "2"  class="text-center mt-3">Insp. Date<br></th>
                                <th col-index = "3"  class="text-center mt-3">PN<br></th>
                                <th col-index = "4"  class="text-center mt-3">LN<br></th>
                                <th col-index = "5"  class="text-center mt-3">Item<br></th>
                                <th col-index = "6"  class="text-center mt-3">Avg</th>
                                <th col-index = "7"  class="text-center mt-3">Max</th>
                                <th col-index = "8"  class="text-center mt-3">Min</th>
                                <th col-index = "9"  class="text-center mt-3">Range</th>
                                <th col-index = "10"  class="text-center mt-3">Std.</th>
                                <th col-index = "11"  class="text-center mt-3">CPK</th>
                                <th col-index = "12"  class="text-center mt-3">Result</th>
                                <th col-index = "13"  class="text-center mt-3">Emp#<br></th>
                                <th col-index = "14"  class="text-center mt-3">MC#<br></th>
                                <th col-index = "15"  class="text-center mt-3">Material</th>
                                <th col-index = "16"  class="text-center mt-3">Material Lot</th>
                                <th col-index = "17"  class="text-center mt-3">LSL</th>
                                <th col-index = "18"  class="text-center mt-3">CSL</th>
                                <th col-index = "19"  class="text-center mt-3">USL</th>
                                <th col-index = "20"  class="text-center mt-3">XCL</th>
                                <th col-index = "21"  class="text-center mt-3">XUCL</th>
                                <th col-index = "22"  class="text-center mt-3">XLCL</th>
                                <th col-index = "23"  class="text-center mt-3">RUCL</th>
                            </tr>
                        </tfoot>
                    </table>
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
    new DataTable('#emp-table', {
        initComplete: function () {
            this.api()
                .columns()
                .every(function () {
                    let column = this;
                    let title = column.footer().textContent;

                    // Create input element with form-group class
                    let input = document.createElement('input');
                    input.placeholder = title;
                    input.classList.add('form-control', 'form-group'); // Add the form-group class
                    column.footer().replaceChildren(input);

                    // Event listener for user input
                    input.addEventListener('keyup', () => {
                        if (column.search() !== this.value) {
                            column.search(input.value).draw();
                        }
                    });
                });
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