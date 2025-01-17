            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Data Analysis</h4>
                  <div class="table-responsive">
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                  <a href="export_CSV.php" download="measurement.csv" id="export-button" name="export" class="btn btn-warning">Export</a>
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
                        include 'includes/connect.php';

                        // Check if the form is submitted
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
                            // Retrieve user inputs
                            $part_id = $_POST['part_id'];
                            $item_id = $_POST['item_id'];
                            $date_from = $_POST['x'];
                            $date_to = $_POST['y'];
                            $measure_id_from = $_POST['measure_id_from'];
                            $measure_id_to = $_POST['measure_id_to'];
                            $mc_id = $_POST['mc_id'];

                            // Define the base query
                            $query = "SELECT * FROM spec_result
                                INNER JOIN measurement ON spec_result.measure_id = measurement.measure_id
                                INNER JOIN process ON process.process_id = measurement.process_id
                                INNER JOIN partnumber ON partnumber.id = spec_result.id
                                INNER JOIN specification ON specification.spec_id = spec_result.spec_id
                                INNER JOIN item ON specification.item_id = item.item_id
                                INNER JOIN machine ON measurement.mc_id = machine.mc_id
                                INNER JOIN material ON measurement.material_id = material.material_id WHERE 1=1"; // Always true condition to start the WHERE clause

                            // Add conditions based on user inputs
                            if ($part_id !== '') {
                                $query .= " AND partnumber.id = '$part_id'";
                            }

                            if ($item_id !== '') {
                                $query .= " AND item.item_id = '$item_id'";
                            }

                            // Use the IN clause for measure_id_from and measure_id_to
                            if ($measure_id_from !== '') {
                                $query .= " AND measurement.measure_id >= '$measure_id_from'";
                            }

                            if ($measure_id_to !== '') {
                                $query .= " AND measurement.measure_id <= '$measure_id_to'";
                            }

                            if ($mc_id !== '') {
                                $query .= " AND machine.mc_id = '$mc_id'";
                            }

                            if ($date_from !== '') {
                                $query .= " AND measurement.measure_datetime >= '$date_from'";
                            }

                            if ($date_to !== '') {
                                $query .= " AND measurement.measure_datetime <= '$date_to'";
                            }

                            // Add more conditions as needed for other input fields
                            // Add ORDER BY clause to sort by pn_no and measure_lot
                            $query .= " ORDER BY measurement.measure_lot ASC";

                            // Execute the query
                            $result = sqlsrv_query($con, $query);

                            // Check for query execution errors
                            if ($result === false) {
                                die(print_r(sqlsrv_errors(), true)); // Print detailed error information
                            }

                            if (sqlsrv_has_rows($result) == 0) {
                                echo "<tr>";
                                echo "<th class='text-center mt-3 text-danger' colspan='24'>No Records Found...</th>";
                                echo "</tr>";
                            } else {
                                // Iterate through the results and display them in the table
                                // Loop through the retrieved data and display each row
                                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                echo '<tr>';
                                echo '<td>' . $row['process_name'] . '</td>';
                                echo '<td>' . $row['measure_datetime']->format('d-m-y') . '</td>';
                                echo '<td>' . $row['pn_no'] . '</td>';
                                echo '<td>' . $row['measure_lot'] . '</td>';
                                echo '<td>' . $row['item_name'] . '</td>';
                                echo '<td>' . $row['result_avg'] . '</td>';
                                echo '<td>' . $row['result_max'] . '</td>';
                                echo '<td>' . $row['result_min'] . '</td>';
                                echo '<td>' . $row['result_range'] . '</td>';
                                echo '<td>' . $row['result_std'] . '</td>';
                                echo '<td>' . $row['result_cpk'] . '</td>';
                                echo '<td>' . ($row['result_judgement'] == 'pass' ? '<label class="badge bg-success"><b>' . $row['result_judgement'] . '</b></label>' : '<label class="badge bg-danger"><b>' . $row['result_judgement'] . '</b></label>') . '</td>';
                                echo '<td>' . $row['measure_emp'] . '</td>';
                                echo '<td>' . $row['mc_name'] . '</td>';
                                echo '<td>' . $row['material_part'] . '</td>';
                                echo '<td>' . $row['measure_mate_lot'] . '</td>';
                                echo '<td>' . $row['spec_lsl'] . '</td>';
                                echo '<td>' . $row['spec_csl'] . '</td>';
                                echo '<td>' . $row['spec_usl'] . '</td>';
                                echo '<td>' . $row['spec_xcl'] . '</td>';
                                echo '<td>' . $row['spec_xucl'] . '</td>';
                                echo '<td>' . $row['spec_xlcl'] . '</td>';
                                echo '<td>' . $row['spec_rucl'] . '</td>';
                                echo '</tr>';
                            }

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
 <!-- jQuery -->
        <script src="jquery-3.6.0.min.js"></script>

        <!-- Bootstrap 5 CSS -->
        <link rel="stylesheet" href="path/to/bootstrap-5.min.css">

        <!-- DataTables Bootstrap 5 CSS -->
        <link rel="stylesheet" href="bootstrap5.min.css">

        <!-- DataTables jQuery script -->
        <script src="dataTables.min.js"></script>

        <!-- DataTables Bootstrap 5 script -->
        <script src="bootstrap5.min.js"></script>
        
          <script>
    new DataTable('#emp-table', {
    initComplete: function () {
        this.api()
            .columns()
            .every(function () {
                let column = this;
                let title = column.header().textContent;

                // Exclude columns with input fields from the search
                if (title !== '') {
                    // Create input element with form-group class
                    let input = document.createElement('input');
                    input.placeholder = title;
                    input.classList.add('form-control', 'form-group'); // Add the form-group class
                    column.footer().replaceChildren(input);

                    // Event listener for user input
                    input.addEventListener('keyup', () => {
                        if (column.search() !== input.value) {
                            column.search(input.value).draw();
                        }
                    });
                }
            });
    }
});

</script>

