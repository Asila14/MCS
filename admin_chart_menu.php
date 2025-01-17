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
  <script src="jquery-3.6.0.min.js"></script>
  <script src="sweetalert.js"></script>
  <script src="library/dselect.js"></script>
  <link rel="stylesheet" href="deliver.css">
  <!-- Add this line in your <head> section -->
  <link rel="stylesheet" href="dataTables.css">
</head>
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
          <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Chart Analysis</h4>
                  <form action="" method="POST">
                    <div class="row">
                      <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-2">Part Number</label>
                            <div class="col-sm-9">
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

                                $part = sqlsrv_query($con, "SELECT * FROM partnumber WHERE process_id = '$process_id' ");
                                ?>
                                <input type="hidden" id="id" name="id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>" class="form-control" required/>
                                <select data-live-search="true" name="id" class="form-control selectpicker">
                                    <option>- Please Select -</option>
                                    <?php
                                    if ($part > 0) {
                                        while ($pt = sqlsrv_fetch_array($part, SQLSRV_FETCH_ASSOC)) {
                                            $selected = (isset($_POST['id']) && $pt['id'] == $_POST['id']) ? 'selected' : '';
                                            // Check if the pn_no is null.
                                            if ($pt['pn_no'] === null) {
                                                // The pn_no is null. Display an error message to the user.
                                                echo '<p style="align:center; color:red">No records found.</p>';
                                            } else {
                                                // The pn_no is not null. Display the pn_no to the user.
                                                echo '<option name="id" value="' . $pt['id'] . '" ' . $selected . '>' . $pt['pn_no'] . '</option>';
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Item</label>
                            <div class="col-sm-9">
                                <?php
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

                                $item = sqlsrv_query($con, "SELECT * FROM item WHERE process_id = '$process_id'");
                                ?>
                                <input type="hidden" name="item_id" value="<?php echo isset($_POST['item_id']) ? $_POST['item_id'] : ''; ?>" />
                                <select data-live-search="true" name="item_id" class="form-control selectpicker">
                                    <option> - Please select - </option>
                                    <?php
                                    if ($item > 0) {
                                        while ($i = sqlsrv_fetch_array($item, SQLSRV_FETCH_ASSOC)) {
                      
                                            $selected = (isset($_POST['item_id']) && $i['item_id'] == $_POST['item_id']) ? 'selected' : '';
                                            echo '<option value="' . $i['item_id'] . '" ' . $selected . '>' . $i['item_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                      <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Date From</label>
                          <div class="col-sm-9">
                            <input type="date" name="x" class="form-control" value="<?php echo isset($_POST['x']) ? $_POST['x'] : ''; ?>" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Date To</label>
                          <div class="col-sm-9">
                            <input type="date" name="y" class="form-control" value="<?php echo isset($_POST['y']) ? $_POST['y'] : ''; ?>" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Lot From</label>
                          <div class="col-sm-9">
                            <?php
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

                                $lotstart = sqlsrv_query($con, "SELECT * FROM measurement WHERE process_id = '$process_id'");
                                ?>
                                <input type="hidden" name="a" value="<?php echo isset($_POST['a']) ? $_POST['a'] : ''; ?>" />
                                <select data-live-search="true" name="measure_id" class="form-control selectpicker">
                                    <option> - Please select - </option>
                                    <?php
                                    if ($lotstart > 0) {
                                        while ($ls = sqlsrv_fetch_array($lotstart, SQLSRV_FETCH_ASSOC)) {
                                            $selected = (isset($_POST['measure_id']) && $ls['measure_id'] == $_POST['measure_id']) ? 'selected' : '';
                                            echo '<option value="' . $ls['measure_id'] . '" ' . $selected . '>' . $ls['measure_lot'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Lot To</label>
                          <div class="col-sm-9">
                            <?php
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

                                $lotEnd = sqlsrv_query($con, "SELECT * FROM measurement WHERE process_id = '$process_id'");
                                ?>
                                <input type="hidden" name="b" value="<?php echo isset($_POST['b']) ? $_POST['b'] : ''; ?>" />
                                <select data-live-search="true" name="measure_id" class="form-control selectpicker">
                                    <option> - Please select - </option>
                                    <?php
                                    if ($lotEnd > 0) {
                                        while ($ls = sqlsrv_fetch_array($lotEnd, SQLSRV_FETCH_ASSOC)) {
                                            $selected = (isset($_POST['measure_id']) && $ls['measure_id'] == $_POST['measure_id']) ? 'selected' : '';
                                            echo '<option value="' . $ls['measure_id'] . '" ' . $selected . '>' . $ls['measure_lot'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Machine</label>
                            <div class="col-sm-9">
                                <?php
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

                                $machine = sqlsrv_query($con, "SELECT * FROM machine WHERE process_id = '$process_id'");
                                ?>
                                <input type="hidden" name="mc_id" value="<?php echo isset($_POST['mc_id']) ? $_POST['mc_id'] : ''; ?>" />
                                <select data-live-search="true" name="mc_id" class="form-control selectpicker">
                                    <option> - Please select - </option>
                                    <?php
                                    if ($machine > 0) {
                                        while ($m = sqlsrv_fetch_array($machine, SQLSRV_FETCH_ASSOC)) {
                                            $selected = (isset($_POST['mc_id']) && $m['mc_id'] == $_POST['mc_id']) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $m['mc_id'] ?>" <?php echo $selected ?>><?php echo $m['mc_name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                      <div class="row">
                        <div class="form-group row">
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="input-group-append">
                              <input type="hidden" name="process_id" value="<?php echo $process_id ?>" />
                          <button type="submit" name="S" class="btn btn-sm btn-primary">Search</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
                <?php
include 'includes/connect.php';

if (isset($_POST['S'])) {
    $conditions = array();
    $parameters = array();

    // Define variables to capture user inputs
    $id = isset($_POST["id"]) ? $_POST["id"] : null;
    $item_id = isset($_POST["item_id"]) ? $_POST["item_id"] : null;
    $mc_id = isset($_POST["mc_id"]) ? $_POST["mc_id"] : null;
    $x = isset($_POST['x']) ? $_POST['x'] : null;
    $y = isset($_POST['y']) ? $_POST['y'] : null;
    $a = isset($_POST['a']) ? $_POST['a'] : null;
    $b = isset($_POST['b']) ? $_POST['b'] : null;

    // Define the base query
$query = "SELECT * FROM spec_result
    INNER JOIN measurement ON spec_result.measure_id = measurement.measure_id
    INNER JOIN process ON process.process_id = measurement.process_id
    INNER JOIN partnumber ON partnumber.id = spec_result.id
    INNER JOIN specification ON specification.spec_id = spec_result.spec_id
    INNER JOIN item ON specification.item_id = item.item_id
    INNER JOIN machine ON measurement.mc_id = machine.mc_id
    INNER JOIN material ON measurement.material_id = material.material_id
    WHERE process.process_id = ?";

// Always add the process_id as the first parameter
$parameters[] = $process_id;

// Check for other conditions and add them to the query and parameters
if (!empty($id)) {
    $conditions[] = "partnumber.id = ?";
    $parameters[] = $id;
}
if (!empty($item_id)) {
    $conditions[] = "item.item_id = ?";
    $parameters[] = $item_id;
}
if (!empty($mc_id)) {
    $conditions[] = "machine.mc_id = ?";
    $parameters[] = $mc_id;
}
if (!empty($x) && !empty($y)) {
    $conditions[] = "measure_datetime BETWEEN ? AND ?";
    $parameters[] = $x;
    $parameters[] = $y;
}
if (!empty($a) && !empty($b)) {
    $conditions[] = "measure_lot BETWEEN ? AND ?";
    $parameters[] = $a;
    $parameters[] = $b;
}

// If there are conditions, add them to the base query
if (!empty($conditions)) {
    $query .= " AND " . implode(" AND ", $conditions);
}

// Finally, add the ORDER BY clause
$query .= " ORDER BY partnumber.pn_no";

// Create a prepared statement
$stmt = sqlsrv_prepare($con, $query, $parameters);

// Execute the prepared statement
$result = sqlsrv_execute($stmt);
    if ($result) {
      $result_avg = array();
                 $result_range = array();
                 $measure_lot = array();
                 $spec_xlcl = array();
                 $spec_xucl = array();
                 $spec_xucl = array();
                 $spec_xcl = array();
                 $spec_rucl = array();
                 $result_max = array();
                 $result_min = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $result_max[] = $row["result_max"];
                      $result_min[] = $row["result_min"];
                      $result_avg[] = $row["result_avg"];
                      $result_range[] = $row["result_range"];
                      $measure_lot[] = $row["measure_lot"];
                      $spec_xlcl[] = $row["spec_xlcl"];
                      $spec_xucl[] = $row["spec_xucl"];
                      $spec_xcl[] = $row["spec_xcl"];
                      $spec_xucl[] = $row["spec_xucl"];
                      $spec_rucl[] = $row["spec_rucl"];
        }
    
?>
          
          <div class="col-12 grid-margin stretch-card">
        <div class="card card-rounded">
          <div class="card-body">
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>
            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
            </symbol>
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
          </svg>
          <div class="alert alert-warning d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
              <b>Note:</b> This graph function only allows users to view <b>(1) one</b> item at a time.
              <br><b>Nota:</b> Fungsi graf ini hanya membenarkan pengguna untuk melihat <b>(1) satu</b> item pada satu masa.
            </div>
          </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="mt-3">
                  <div class="row">
<?php

// Check if the row is empty.
if (empty($row)) {
    // The row is empty. Do not display the process name heading.
    echo '';
} else {
    // The row is not empty. Check if the row contains an item name key.
    if (isset($row['process_name'])) {
        // The item name key exists. Display the item name heading.
        echo '<h4 style="align:center; color:blue;"><b>Process: ' . $row['process_name'] . '</b></h4>';
    } else {
        // The item name key does not exist. Do not display the item name heading.
        echo '';
    }
}

?>
<?php

// Check if the row is empty.
if (empty($row)) {
    // The row is empty. Do not display the process name heading.
    echo '';
} else {
    // The row is not empty. Check if the row contains an item name key.
    if (isset($row['item_name'])) {
        // The item name key exists. Display the item name heading.
        echo '<h4 style="align:center; color:blue;"><b>Item: ' . $row['item_name'] . '</b></h4>';
    } else {
        // The item name key does not exist. Do not display the item name heading.
        echo '';
    }
}

?>

<div class="row flex-grow">
  <div class="col-12 grid-margin stretch-card">
    <div class="card card-rounded">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div>
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Chart Type </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                    <h6 class="dropdown-header">Select Chart Type</h6>
                    <a class="dropdown-item" href="#" onclick="showBarChart()">Bar Chart</a>
                    <a class="dropdown-item" href="#" onclick="showHiLoChart()">Hi-Lo Chart</a>
                  </div>
                </div>
              </div>
            </div>
            <div id="barchart" class="mt-3" style="display: none;">
              <div class="row">
                <div class="col-md-6">
                  <h4 class="card-title card-title-dash">X Trend Chart</h4>
                  <p style="align:center;"><canvas id="myChartX"></canvas></p>
                </div>
                <div class="col-md-6">
                  <h4 class="card-title card-title-dash">R Trend Chart</h4>
                  <p style="align:center;"><canvas id="myChartR"></canvas></p>
                </div>
              </div>
            </div>
            <div id="hilo" class="mt-3" style="display: none;">
              <div class="row">
                <div class="col-md-6">
                  <h4 class="card-title card-title-dash">Hi-Lo Chart</h4>
                  <p style="align:center;"><canvas id="hiLoChart"></canvas></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group row">
    <p style="align:center;"></p>
    <script src="graf.js"></script>
    <script>
      // Setup block
      const dataValue = <?php echo json_encode($result_avg); ?>;
      const dataLSL = <?php echo json_encode($spec_xlcl); ?>;
      const dataUSL = <?php echo json_encode($spec_xucl); ?>;
      const dataCSL = <?php echo json_encode($spec_xcl); ?>;
      const labels = <?php echo json_encode($measure_lot); ?>;
      const data = {
        labels: labels,
        datasets: [{
           label: 'Average',
           backgroundColor: 'rgb(135, 206, 250)',
           borderColor: 'rgb(135, 206, 250)',
           data: dataValue,
           fill:false,
        },{
          label: 'USL',
          backgroundColor: 'rgb(239, 95, 67)',
          borderColor: 'rgb(239, 95, 67)',
          pointStyle: false,
          borderDash: [5, 5],
          data: dataUSL,
          fill:false,
        },
        {
          label: 'CSL',
          backgroundColor: 'rgb(239, 95, 67)',
          borderColor: 'rgb(239, 95, 67)',
          pointStyle: false,
          data: dataCSL,
          fill:false,
        },
        {
          label: 'LSL',
          backgroundColor: 'rgb(239, 95, 67)',
          borderColor: 'rgb(239, 95, 67)',
          pointStyle: false,
          borderDash: [5, 5],
          data: dataLSL,
          fill:false,
        }]
      };
      //config block
      const config = {
        type: 'line',
        data: data,
        options: {
        plugins:{
          legend: {
            display: false
          }
        }
      }
    };
      //render block
      var myChartX = new Chart (
        document.getElementById('myChartX'),
        config
        );
    </script>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
    <p style="align:center;"></p>
    <script src="graf.js"></script>
    <script>
      // Setup block
      const dataValueR =<?php echo json_encode($result_range);?>;
        const labelsR = <?php echo json_encode($measure_lot); ?>;
        const dataRUSL = <?php echo json_encode($spec_rucl); ?>;
        const dataR = {
          labels: labelsR,
          datasets: [{
             label: 'Range',
            backgroundColor: 'rgb(178, 37, 150)',
            borderColor: 'rgb(178, 37, 150)',
            data: dataValueR,
            fill:false,
          },{
            label: 'USL',
            backgroundColor: 'rgb(239, 95, 67)',
            borderColor: 'rgb(239, 95, 67)',
            pointStyle: false,
            borderDash: [5, 5],
            data: dataRUSL,
            fill:false,
          }]
        };
      //configR block
      const configR = {
        type: 'line',
        data: dataR,
        options: {
        plugins:{
          legend: {
            display: false
          }
        }
      }
    };

      //render block
      var myChartR = new Chart (
        document.getElementById('myChartR'),
        configR
        );

    </script>
<div class="col-md-12">
    <div class="form-group row">
        <p style="text-align: center;"></p>
        <script src="graf.js"></script>
        <script>
            // Retrieve data from your PHP code
            const dataHigh = <?php echo json_encode($result_max); ?>;
            const dataLow = <?php echo json_encode($result_min); ?>;
            const dataAvg = <?php echo json_encode($result_avg); ?>;
            const LSLH = <?php echo json_encode($spec_xlcl); ?>;
            const USLH = <?php echo json_encode($spec_xucl); ?>;
            const CSLH = <?php echo json_encode($spec_xcl); ?>;
            const labelsH = <?php echo json_encode($measure_lot); ?>;
            
            // Create your chart using the retrieved data
            const dataH = labelsH.map((labelH, index) => ({
                x: labelH,
                y: {
                    high: dataHigh[index],
                    average: dataAvg[index],
                    low: dataLow[index],
                },
            }));
            
            const ctx = document.getElementById('hiLoChart').getContext('2d');
            
            new Chart(ctx, {
    type: 'scatter',
    data: {
        datasets: [
            {
                label: 'High',
                data: dataH.map(item => ({ x: item.x, y: item.y.high })),
                borderColor: 'rgba(255, 123, 27, 1)',
                backgroundColor: 'rgba(255, 123, 27, 1)',
                pointRadius: 4,
                pointStyle: 'rectRounded',
            },
            {
                label: 'Average',
                data: dataH.map(item => ({ x: item.x, y: item.y.average })),
                borderColor: 'rgba(0, 123, 255, 1)',
                backgroundColor: 'rgba(0, 123, 255, 1)',
                pointRadius: 4,
                pointStyle: 'triangle',
            },
            {
                label: 'Low',
                data: dataH.map(item => ({ x: item.x, y: item.y.low })),
                borderColor: 'rgba(169, 169, 169, 1)', // Grey border color
                backgroundColor: 'rgba(192, 192, 192, 1)', // Grey background color
                pointRadius: 4,
                pointStyle: 'rectRounded', // You can change the point style to 'circle' or any other supported shape
            },
            {
                label: 'USLH',
                data: USLH,
                borderColor: 'rgb(239, 95, 67)',
                borderWidth: 2,
                fill: false, // Use '-1' to fill the area under the line
                pointRadius: 0, // Set pointRadius to 0 to hide data points
                borderDash: [5, 5], // Add a dashed line for USL
                type: 'line', // Set the type to 'line'
            },
            {
                label: 'CSLH',
                data: CSLH,
                borderColor: 'rgb(239, 95, 67)',
                borderWidth: 2,
                fill: false, // Use '-1' to fill the area under the line
                pointRadius: 0, // Set pointRadius to 0 to hide data points
                type: 'line', // Set the type to 'line'
            },
            {
                label: 'LSLH',
                data: LSLH,
                borderColor: 'rgb(239, 95, 67)',
                borderWidth: 2,
                fill: false, // Use '-1' to fill the area under the line
                pointRadius: 0, // Set pointRadius to 0 to hide data points
                borderDash: [5, 5], // Add a dashed line for LSL
                type: 'line', // Set the type to 'line'
            },
        ],
    },
    options: {
        scales: {
            x: {
                position: 'bottom',
                beginAtZero: false,
                type: 'category',
            },
            y: {
                beginAtZero: false,
            },
        },
        plugins: {
            legend: {
                display: false, // Hide the legend
            },
        },
    },
});
        </script>
    </div>
</div>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
      <?php
    }else {  
echo "<div class='alert alert-danger' role='alert'>No data, please input data all the data required...</div>";   
        }}
       ?>
</div>
</div>
</div>
</div>
<!-- Add this code to your existing PHP/HTML code -->
<script>
    function updateCharts() {
        // Get the selected values from the form inputs
        const selectedId = document.getElementById('id').value;
        const selectedItem = document.getElementById('item_id').value;
        const selectedMcId = document.getElementById('mc_id').value;
        const selectedDateFrom = document.getElementById('x').value;
        const selectedDateTo = document.getElementById('y').value;
        const selectedLotFrom = document.getElementById('a').value;
        const selectedLotTo = document.getElementById('b').value;
        
        // Construct an object containing the selected values
        const selectedData = {
            id: selectedId,
            item_id: selectedItem,
            mc_id: selectedMcId,
            x: selectedDateFrom,
            y: selectedDateTo,
            a: selectedLotFrom,
            b: selectedLotTo,
        };
        
        // Make an AJAX request to your PHP script to fetch chart data based on selectedData
        // Update the charts with the new data

        // You can use the selectedData object to make an AJAX request to your PHP script
        // for fetching the data based on the user's selections. Then, you can update the charts
        // with the new data.
        // You need to handle the AJAX part in your JavaScript.

        // Example AJAX code using Fetch API:
        fetch('your_php_script.php', {
            method: 'POST',
            body: JSON.stringify(selectedData),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update your charts with the new data
            // Use 'data' to populate your charts
        })
        .catch(error => console.error('Error:', error));
    }

    // Add an event listener to the "Search" button
    document.getElementById('searchButton').addEventListener('click', updateCharts);
</script>
<script>
function showBarChart() {
    document.getElementById('barchart').style.display = 'block';
    document.getElementById('hilo').style.display = 'none';
}

function showHiLoChart() {
    document.getElementById('barchart').style.display = 'none';
    document.getElementById('hilo').style.display = 'block';
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

