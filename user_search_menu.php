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
         <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Search Menu</h4>
                  <form class="form-sample" action="" method="post" id="search-form" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Part Number</label>
                          <div class="col-sm-9">
                        <?php
                            include 'includes/connect.php';

                            // Fetch all part numbers ordered by process_name
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
                            $part = sqlsrv_query($con, "SELECT partnumber.id, partnumber.pn_no, process.process_name, process.process_id
                                                        FROM partnumber 
                                                        INNER JOIN process ON partnumber.process_id = process.process_id 
                                                        WHERE process.process_id='$process_id'
                                                        ORDER BY process.process_name ASC");

                            $currentProcess = null; // To track the current process during iteration

                            if ($part !== false) {
                                echo '<select data-live-search="true" name="part_id" class="form-control selectpicker">';
                                echo '<option value="" selected>- Please Select -</option>';

                                while ($pt = sqlsrv_fetch_array($part, SQLSRV_FETCH_ASSOC)) {
                                    // Check if the process has changed
                                    if ($currentProcess !== $pt['process_name']) {
                                        // If yes, close the previous optgroup and start a new one
                                        if ($currentProcess !== null) {
                                            echo '</optgroup>';
                                        }
                                        echo '<optgroup label="' . $pt['process_name'] . '">';
                                        $currentProcess = $pt['process_name'];
                                    }
                                    $selected = (isset($_POST['part_id']) && $_POST['part_id'] == $pt['id']) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $pt['id'] ?>" data-process-id="<?php echo $pt['process_id']; ?>" <?php echo $selected; ?>>
                                        <?php echo $pt['pn_no']; ?>
                                    </option>
                                <?php } 

                                echo '</optgroup>'; // Close the last optgroup
                                echo '</select>';
                            }
                    ?>
                    </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Item</label>
                          <div class="col-sm-9">
                            <?php
                                include 'includes/connect.php';

                                // Fetch all items ordered by process_name
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
                                $itemsQuery = sqlsrv_query($con, "SELECT item.item_id, item.item_name, item.process_id, process.process_name 
                                                                   FROM item 
                                                                   INNER JOIN process ON item.process_id = process.process_id 
                                                                   WHERE process.process_id='$process_id'
                                                                   ORDER BY process.process_name ASC");

                                $currentProcess = null; // To track the current process during iteration

                                if ($itemsQuery !== false) {
                                    echo '<select data-live-search="true" name="item_id" class="form-control selectpicker">';
                                    echo '<option value="" selected>- Please Select -</option>';

                                    while ($item = sqlsrv_fetch_array($itemsQuery, SQLSRV_FETCH_ASSOC)) {
                                        // Check if the process has changed
                                        if ($currentProcess !== $item['process_name']) {
                                            // If yes, close the previous optgroup and start a new one
                                            if ($currentProcess !== null) {
                                                echo '</optgroup>';
                                            }
                                            echo '<optgroup label="' . $item['process_name'] . '">';
                                            $currentProcess = $item['process_name'];
                                        }
                                        $selected = (isset($_POST['item_id']) && $_POST['item_id'] == $item['item_id']) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $item['item_id'] ?>" data-process-id="<?php echo $item['process_id']; ?>" <?php echo $selected; ?>>
                                            <?php echo $item['item_name']; ?>
                                        </option>
                                    <?php } 

                                    echo '</optgroup>'; // Close the last optgroup
                                    echo '</select>';
                                }
                            ?>

                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Date From</label>
                          <div class="col-sm-9">
                            <input type="date" name="x" class="form-control" value="<?php echo isset($_POST['x']) ? $_POST['x'] : ''; ?>" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Date To</label>
                          <div class="col-sm-9">
                            <input type="date" name="y" class="form-control" value="<?php echo isset($_POST['y']) ? $_POST['y'] : ''; ?>" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Lot From</label>
                            <div class="col-sm-9">
                                <?php
                                include 'includes/connect.php';

                                // Fetch all items ordered by process_name from the measurement table
                                $itemsQuery = sqlsrv_query($con, "SELECT DISTINCT measurement.measure_id, measurement.measure_lot, measurement.process_id, process.process_name FROM measurement INNER JOIN process ON measurement.process_id = process.process_id ORDER BY process.process_name ASC"); 

                                $currentProcess = null; // To track the current process during iteration

                                if ($itemsQuery !== false) {
                                    echo '<select data-live-search="true" name="measure_id_from" class="form-control selectpicker">';
                                    echo '<option value="" selected>- Please Select -</option>';

                                    while ($item = sqlsrv_fetch_array($itemsQuery, SQLSRV_FETCH_ASSOC)) {
                                        // Check if the process has changed
                                        if ($currentProcess !== $item['process_name']) {
                                            // If yes, close the previous optgroup and start a new one
                                            if ($currentProcess !== null) {
                                                echo '</optgroup>';
                                            }
                                            echo '<optgroup label="' . $item['process_name'] . '">';
                                            $currentProcess = $item['process_name'];
                                        }
                                        $selected = (isset($_POST['measure_id_from']) && $_POST['measure_id_from'] == $item['measure_id']) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $item['measure_id'] ?>" data-process-id="<?php echo $item['process_id']; ?>" <?php echo $selected; ?>>
                                            <?php echo $item['measure_lot']; ?>
                                        </option>
                                    <?php } 

                                    echo '</optgroup>'; // Close the last optgroup
                                    echo '</select>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Lot To</label>
                            <div class="col-sm-9">
                                <?php
                                // Fetch all items ordered by process_name from the measurement table
                                $itemsQuery = sqlsrv_query($con, "SELECT DISTINCT measurement.measure_id, measurement.measure_lot, measurement.process_id, process.process_name
                                                                   FROM measurement 
                                                                   INNER JOIN process ON measurement.process_id = process.process_id 
                                                                   ORDER BY process.process_name ASC");

                                $currentProcess = null; // To track the current process during iteration

                                if ($itemsQuery !== false) {
                                    echo '<select data-live-search="true" name="measure_id_to" class="form-control selectpicker">';
                                    echo '<option value="" selected>- Please Select -</option>';

                                    while ($item = sqlsrv_fetch_array($itemsQuery, SQLSRV_FETCH_ASSOC)) {
                                        // Check if the process has changed
                                        if ($currentProcess !== $item['process_name']) {
                                            // If yes, close the previous optgroup and start a new one
                                            if ($currentProcess !== null) {
                                                echo '</optgroup>';
                                            }
                                            echo '<optgroup label="' . $item['process_name'] . '">';
                                            $currentProcess = $item['process_name'];
                                        }

                                        // Check if the value is selected
                                        $selected = (isset($_POST['measure_id_to']) && $_POST['measure_id_to'] == $item['measure_id']) ? 'selected' : '';

                                        echo '<option value="' . $item['measure_id'] . '" data-process-id="' . $item['process_id'] . '" ' . $selected . '>';
                                        echo $item['measure_lot'];
                                        echo '</option>';
                                    }

                                    echo '</optgroup>'; // Close the last optgroup
                                    echo '</select>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Machine</label>
                          <div class="col-sm-9">
                            <?php
                                include 'includes/connect.php';

                                // Fetch all machines ordered by process_name
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
                                $machinesQuery = sqlsrv_query($con, "SELECT DISTINCT machine.mc_id, machine.mc_name, machine.process_id, process.process_name 
                                                                      FROM machine INNER JOIN process ON machine.process_id = process.process_id WHERE process.process_id='$process_id' ORDER BY process.process_name ASC");

                                $currentProcess = null; // To track the current process during iteration

                                if ($machinesQuery !== false) {
                                    echo '<select data-live-search="true" name="mc_id" class="form-control selectpicker">';
                                    echo '<option value="" selected>- Please Select -</option>';

                                    while ($machine = sqlsrv_fetch_array($machinesQuery, SQLSRV_FETCH_ASSOC)) {
                                        // Check if the process has changed
                                        if ($currentProcess !== $machine['process_name']) {
                                            // If yes, close the previous optgroup and start a new one
                                            if ($currentProcess !== null) {
                                                echo '</optgroup>';
                                            }
                                            echo '<optgroup label="' . $machine['process_name'] . '">';
                                            $currentProcess = $machine['process_name'];
                                        }

                                        // Check if the value is selected
                                        $selected = (isset($_POST['mc_id']) && $_POST['mc_id'] == $machine['mc_id']) ? 'selected' : '';

                                        echo '<option value="' . $machine['mc_id'] . '" data-process-id="' . $machine['process_id'] . '" ' . $selected . '>';
                                        echo $machine['mc_name'];
                                        echo '</option>';
                                    }

                                    echo '</optgroup>'; // Close the last optgroup
                                    echo '</select>';
                                }
                                ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button type="submit" name="table" class="btn btn-primary me-2">Table View</button>
                    <button type="submit" name="chart" class="btn btn-info me-2">Chart View</button>
                    <!-- <button type="submit" name="export" class="btn btn-warning">Export</button> -->
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
        </div>
        <div class="col-12 grid-margin">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['table'])) {
                    include 'search_table.php';
                } elseif (isset($_POST['chart'])) {
                    include 'search_chart.php';
                } elseif (isset($_POST['export'])) {
                    // Check if the form is submitted
                    // Retrieve user inputs
                    $part_id = $_POST['part_id'];
                    $item_id = $_POST['item_id'];
                    $date_from = $_POST['x'];
                    $date_to = $_POST['y'];
                    $measure_id_from = $_POST['measure_id_from'];
                    $measure_id_to = $_POST['measure_id_to'];
                    $mc_id = $_POST['mc_id'];

                    include 'includes/connect.php';

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

                    // Execute the query
                    $result = sqlsrv_query($con, $query);

                    // Generate a unique filename (e.g., timestamp-based)
                    $fileName = 'export_' . date('YmdHis') . '.csv';

                    // Create a CSV file with the generated file name in the web server's document root
                    $filePath = __DIR__ . "/Downloads/$fileName";

                    // Check if fopen is successful
                    $csv = fopen($filePath, 'w');
                    if (!$csv) {
                        die('Failed to open the CSV file');
                    }

                    // Output CSV column headers
                    fputcsv($csv, array('Process', 'Inspection Date', 'PN', 'LN', 'Item', 'Avg', 'Max', 'Min', 'Range', 'Std.', 'CPK', 'Result', 'Emp#', 'MC#', 'Material', 'Material Lot', 'LSL', 'CSL', 'USL', 'XCL', 'XUCL', 'XLCL', 'RUCL'));

                    // Check if there are rows to process
                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        // Adjust the fields based on your actual database structure
                        $data = array(
                            $row['process_name'],
                            $row['measure_datetime']->format('d-m-y'),
                            $row['pn_no'],
                            $row['measure_lot'],
                            $row['item_name'],
                            $row['result_avg'],
                            $row['result_max'],
                            $row['result_min'],
                            $row['result_range'],
                            $row['result_std'],
                            $row['result_cpk'],
                            $row['result_judgement'],
                            $row['measure_emp'],
                            $row['mc_name'],
                            $row['material_part'],
                            $row['measure_mate_lot'],
                            $row['spec_lsl'],
                            $row['spec_csl'],
                            $row['spec_usl'],
                            $row['spec_xcl'],
                            $row['spec_xucl'],
                            $row['spec_xlcl'],
                            $row['spec_rucl']
                        );

                        fputcsv($csv, $data);
                    }

                    // Check if fclose is successful
                    if (!fclose($csv)) {
                        die('Failed to close the CSV file');
                    }

                    // Output the CSV file to the client
        header('Content-Type: application/csv');
        header("Content-Disposition: attachment; filename=$fileName");
        header('Cache-Control: no-store, no-cache');
        header('Content-Length: ' . filesize($filePath));

        // Flush the output buffer
        ob_clean();
        flush();

        // Read and output the file
        readfile($filePath);

        // End the script
        exit;
                } 
            }
            ?>
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

