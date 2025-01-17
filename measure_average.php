<?php

//to retrived data
  if (isset($_GET['spec_id']) && isset($_GET['measure_id']) && isset($_GET['item_id']) && isset($_GET['id'])&& isset($_GET['id']) && isset($_GET['attempt'])){
      $measure_id = $_GET['measure_id'];
      $spec_id = $_GET['spec_id'];
      $item_id = $_GET['item_id'];
      $id = $_GET['id'];
      $attempt = $_GET['attempt'];
  }
include 'includes/connect.php';

$query = "SELECT * FROM measurement inner join process ON measurement.process_id=process.process_id inner join package ON measurement.pack_id=package.pack_id inner join machine ON measurement.mc_id=machine.mc_id inner join material ON measurement.material_id=material.material_id inner join customer ON measurement.cust_id=customer.cust_id inner join partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id='$measure_id' AND partnumber.id='$id' AND item.item_id='$item_id'";

$result = sqlsrv_query($con, $query) or die('Database connection error');
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

/*untuk check data wujud @ tak*/
  $spec_spl_point = $row['spec_spl_point'];
  $sql_check="SELECT * FROM spec_data WHERE measure_id = $measure_id AND id= $id AND item_id=$item_id AND attempt=$attempt";
  $query_check=sqlsrv_query($con,$sql_check);

    if(sqlsrv_has_rows($query_check)>0){

$sql_data = "SELECT * FROM spec_data WHERE measure_id='$measure_id' AND item_id='$item_id' AND id='$id' AND attempt=$attempt ";
$result_data = sqlsrv_query($con, $sql_data) or die('Database connection error');

$data = [];
while ($row_data = sqlsrv_fetch_array($result_data, SQLSRV_FETCH_ASSOC)) {
  $data[] = $row_data['data'];
}
$spec_data_spl = $row['spec_data_spl'];

$averages = [];
function getAverageEveryNItems(array $data, int $spec_data_spl)
{
  $averages = [];
  for ($i = 0; $i < count($data); $i += $spec_data_spl) {
    $average = 0;
    for ($j = 0; $j < $spec_data_spl; $j++) {
      $average += $data[$i + $j];
    }
    $average /= $spec_data_spl;
    $averages[] = $average;
  }
  return $averages;
}

$averages = getAverageEveryNItems($data, $spec_data_spl);

$total_sum_of_averages = 0;

foreach ($averages as $average) {
  // Add the current element of the $averages array to the $total_sum_of_averages variable
  $total_sum_of_averages += $average;
}

// Calculate the maximum and minimum values of the averages
$result_max = 0;
if (!empty($averages)) {
  $result_max = max($averages);
}

$result_min = 0;
if (!empty($averages)) {
  $result_min = min($averages);
}
$result_range = $result_max - $result_min;

// Check if the $row['spec_spl_point'] variable is empty. If it is, return a default value of 1.
$spec_spl_point = $row['spec_spl_point'];
if (empty($spec_spl_point)) {
  $spec_spl_point = 1;
}

// Calculate the average of the averages
$result_avg = round($total_sum_of_averages/$spec_spl_point,3);

$squared_deviations = array();
foreach ($averages as $average) {
  $squared_deviations[] = pow($average - $result_avg, 2);
}

$variance = 0;
if (!empty($averages) && $spec_data_spl > 0) {
  $squared_deviations = [];
  foreach ($averages as $average) {
    $squared_deviations[] = pow($average - $result_avg, 2);
  }

  $variance = array_sum($squared_deviations) / count($squared_deviations);
}
$result_std = round(sqrt($variance),3);

$result_cpk = 0;
if ($result_std > 0 && $row['spec_usl'] > 0 && $row['spec_lsl'] > 0) {
  $result_cpk = round(min((($row['spec_usl']-$result_avg)/(3*$result_std)),(($result_avg-$row['spec_lsl'])/(3*$result_std))),2);
}


$counter = 1;

?>

<div class="col-md-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
    <h4 class="card-title"><b>
            <?php
                $status = trim($row['spec_sc']);

                // Check if the status is 'Yes'
                if ($status == 'Yes') {
                    // If 'Yes', display the image
                    echo '<img src="images/symbol.png" alt="Symbol Image" width="30" height="30">';
                }
            ?>
            <?php echo $row['item_name'] ?></b></h4>
      <h4 class="card-title text-primary"><b><?php echo $row['pn_no'] ?> - <?php echo $row['measure_lot'] ?></b></h4>
        <p class="text-success">
        <b>LSL:</b> <?php echo $row['spec_lsl'] ?>
        <br>
        <b>USL:</b> <?php echo $row['spec_usl'] ?>
      </p>
      <?php
      $sql_data1 = "SELECT TOP 1 * FROM spec_data INNER JOIN machine ON machine.mc_id=spec_data.mc_id WHERE measure_id='$measure_id' AND item_id='$item_id' AND id='$id' AND attempt='$attempt'";
      $result_data1 = sqlsrv_query($con, $sql_data1);

      if ($result_data1 === false) {
          die(print_r(sqlsrv_errors(), true));
      }

      $row_data1 = sqlsrv_fetch_array($result_data1, SQLSRV_FETCH_ASSOC); 
      ?>
      <b>#Emp:</b> <?php echo isset($row_data1['user_data']) ? $row_data1['user_data'] : 'N/A'; ?>
      <br>
      <b>Machine:</b> <?php echo isset($row_data1['mc_name']) ? $row_data1['mc_name'] : 'N/A'; ?>
      <br>
      <b>Date Submitted:</b> <?php echo isset($row_data1['data_datetime']) ? $row_data1['data_datetime']->format('d-m-Y H:i:s') : 'N/A'; ?>
      </p>
      <table class="table table-bordered ">
        <thead>
          <tr class="table-light">
            <?php
            echo "<th class=text-center mt-3>#Spl</th>";
            for ($e=1; $e<=$row['spec_data_spl']; $e++){
                echo "<th class=text-center mt-3>Point ".$e."</th>";
              }
              ?>
          </tr>
        </thead>
        <tbody>
        <?php
            $count = 1;
            $sql1 = "SELECT * FROM spec_data WHERE measure_id = $measure_id AND id= $id AND item_id=$item_id AND attempt= $attempt ";
            $result1 = sqlsrv_query($con,$sql1) or die('Database connection error 1');
            $num_data = 1;
            while ($row1 = sqlsrv_fetch_array($result1,SQLSRV_FETCH_ASSOC)) {
              // Print the average values
                if ($count == 1) {
                    echo "<tr>";
                    echo "<td class='text-center mt-3'>".$num_data."</td>";
                    echo "<td class='text-center mt-3'>".$row1['data']."</td>";
                    $num_data++;
                } else {
                    echo "<td class='text-center mt-3'>".$row1['data']."</td>";  
                }
                if ($count == $row['spec_data_spl']) {
                    echo "</tr>";
                    $count = 1;
                } else {
                    $count++;
                }
            }
        ?>
      </tbody>
    </table>
    </div>
  </div>
</div>
<div class="col-3 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
    <h4 class="card-title text-primary"><b><?php echo $row['pn_no'] ?> - <?php echo $row['measure_lot'] ?></b></h4>
        <p class="text-success">
        <b>LSL:</b> <?php echo $row['spec_lsl'] ?>
        <br>
        <b>USL:</b> <?php echo $row['spec_usl'] ?>
      </p>
      <form action="" method="POST">
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th  class='text-center mt-3'>#</th>
            <th  class='text-center mt-3'>Average</th>
            <th  class='text-center mt-3'>Result</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach ($averages as $average): ?>
          <tr>
            <td  class='text-center mt-3'><?php echo $counter; ?></td>
            <td  class='text-center mt-3'><?php echo round($average,3); ?></td>
            <input type="hidden" name="averages[]" value="<?php echo round($average,3); ?>">
            <?php 
            if($average <=$row['spec_usl'] && $average >=$row['spec_lsl'])
            {
              echo "<td  class='text-center mt-3 text-success'><b>O</b></td>";
            }
            else
            {
              echo "<td  class='text-center mt-3 text-danger'><b>X</b></td>";
            }
            ?>
            
          </tr>
        <?php $counter++; endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="col-3 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th  class='text-center mt-3'>Average</th>
            <td  class='text-center mt-3'><?php echo round($result_avg,3); ?></td>
            <input type="hidden" name="result_avg" value="<?php echo round($result_avg,3); ?>">
          </tr>
          <tr>
            <th  class='text-center mt-3'>Max</th>
            <td  class='text-center mt-3'><?php echo round($result_max,3); ?></td>
            <input type="hidden" name="result_max" value="<?php echo round($result_max,3); ?>">
          </tr>
          <tr>
            <th  class='text-center mt-3'>Min</th>
            <td  class='text-center mt-3'><?php echo  round($result_min,3); ?></td>
            <input type="hidden" name="result_min" value="<?php echo round($result_min,3); ?>">
          </tr>
          <tr>
            <th  class='text-center mt-3'>Range</th>
            <td  class='text-center mt-3'><?php echo round($result_range,3); ?></td>
            <input type="hidden" name="result_range" value="<?php echo round($result_range,3); ?>">
          </tr>
          <tr>
            <th  class='text-center mt-3'>Std Dev.</th>
            <td  class='text-center mt-3'><?php echo $result_std ?></td> 
            <input type="hidden" name="result_std" value="<?php echo $result_std; ?>">
          </tr>
          
          <tr>
            <th  class='text-center mt-3'>Cpk</th>
            <td  class='text-center mt-3'><?php echo $result_cpk ?></td>
            <input type="hidden" name="result_cpk" value="<?php echo $result_cpk; ?>">
          </tr>
          
          <tr>
            <th  class='text-center mt-3'>Judgement</th>
            <?php
            if ($result_max <= $row['spec_usl'] && $result_min >= $row['spec_lsl'] && $result_cpk >= $row['spec_cpk'])
            {
              $result_judgement = 'pass';
              echo "<td  class='text-center mt-3'><label class='badge bg-success'>Pass</label></td>";
              echo "<input type='hidden' name='result_judgement' value='$result_judgement'>";
            }else{

              $result_judgement = 'failed';
              echo "<td  class='text-center mt-3'><label class='badge bg-danger'>Failed</label></td>";
              echo "<input type='hidden' name='result_judgement' value='$result_judgement'>";
            }
            ?>
          </tr>
        </thead>
      </table>
      <?php
      include 'includes/connect.php';

      // Initialize the remark variable
      $remark = "";

      // Retrieve the relevant IDs from GET parameters
      $measure_id = $_GET['measure_id'];
      $item_id = $_GET['item_id'];
      $attempt = $_GET['attempt'];

      // Check if remark exists in spec_result table
      $sql_check_remark = "SELECT remark FROM spec_result WHERE measure_id = ? AND item_id = ? AND attempt = ?";
      $params = array($measure_id, $item_id, $attempt);
      $stmt = sqlsrv_query($con, $sql_check_remark, $params);

      if ($stmt === false) {
          die(print_r(sqlsrv_errors(), true));
      }

      if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
          $remark = $row['remark'];
      }

      // Close the statement
      sqlsrv_free_stmt($stmt);
      ?>
          <!-- Add the remark form before the back and submit buttons -->
          <div class="form-group">
              <label for="remark">Remark:</label>
              <input type="text" class="form-control" id="remark" name="remark" value="<?php echo htmlspecialchars($remark); ?>">
          </div>

        <input type="hidden" name="attempt" value="<?php echo $_GET['attempt']; ?>" />
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <input type="hidden" name="spec_id" value="<?php echo $_GET['spec_id']; ?>">
        <input type="hidden" name="measure_id" value="<?php echo $_GET['measure_id']; ?>">
        <input type="hidden" name="item_id" value="<?php echo $_GET['item_id']; ?>">
        <?php
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $result_datetime = date("Y-m-d H:i:s");
        ?>
        <?php
        //Check data 
          $sqlcek="SELECT * FROM spec_result WHERE measure_id = '$measure_id' AND item_id = '$item_id' AND attempt = '$attempt' AND result_datetime = (SELECT MAX(result_datetime)FROM spec_result WHERE measure_id = '$measure_id' AND item_id = '$item_id')";
          $result_cek = sqlsrv_query($con,$sqlcek) or die('Database connection error');
          $row_check = sqlsrv_fetch_array($result_cek,SQLSRV_FETCH_ASSOC);

          if ($row_check == null) {
            $measureId = $_GET['measure_id'];
            $specId = $_GET['spec_id'];
            $itemId = $_GET['item_id'];
            $id = $_GET['id'];

            if (isset($measureId) && !empty($measureId) && isset($specId) && !empty($specId) && isset($itemId) && !empty($itemId) && isset($id) && !empty($id)) {
              $escapedMeasureId = htmlspecialchars($measureId);
              $escapedSpecId = htmlspecialchars($specId);
              $escapedItemId = htmlspecialchars($itemId);
              $escapedId = htmlspecialchars($id);

              echo " <a href='measure_add.php?measure_id={$escapedMeasureId}&spec_id={$escapedSpecId}&item_id={$escapedItemId}&id={$escapedId}' class='btn btn-secondary'>Back</a>";
              echo "&nbsp;";
            }
            echo "<input type='submit' name='result' class='btn btn-primary' value='Submit'>";
          } else {
            $measureId = $_GET['measure_id'];
            $specId = $_GET['spec_id'];
            $itemId = $_GET['item_id'];
            $id = $_GET['id'];

            if (isset($measureId) && !empty($measureId) && isset($specId) && !empty($specId) && isset($itemId) && !empty($itemId) && isset($id) && !empty($id)) {
              $escapedMeasureId = htmlspecialchars($measureId);
              $escapedSpecId = htmlspecialchars($specId);
              $escapedItemId = htmlspecialchars($itemId);
              $escapedId = htmlspecialchars($id);

              echo " <a href='measure_add.php?measure_id={$escapedMeasureId}&spec_id={$escapedSpecId}&item_id={$escapedItemId}&id={$escapedId}' class='btn btn-secondary'>Back</a>";
              echo "&nbsp;";
            }
              echo "<button type='submit' name='result' class='btn btn-primary' disabled>Submit</button>";
          }
        ?>
      </form>
<?php
// Check if the form is submitted
if(isset($_POST['result'])){
    // Retrieve form data
    $remark = isset($_POST['remark']) ? $_POST['remark'] : '';
    $result_datetime = date("Y-m-d H:i:s"); // Current datetime
    $attempt = $_POST['attempt'];
    $spec_id = $_POST['spec_id']; // Assuming spec_id is submitted via POST
    $averages = $_POST['averages'];
        $measure_id = $_GET['measure_id'];
        $item_id = $_GET['item_id'];
        $id = $_GET['id'];
        $attempt = $_GET['attempt'];
        if (isset($_POST['result_avg'])) {
        // The result_avg variable is set
        $result_avg = $_POST['result_avg'];
        } else {
        // The result_avg variable is not set
        $result_avg = null;
        }
        if (isset($_POST['result_max'])) {
        // The result_avg variable is set
        $result_max = $_POST['result_max'];
        } else {
        // The result_avg variable is not set
        $result_max = null;
        }
        if (isset($_POST['result_min'])) {
        // The result_avg variable is set
        $result_min = $_POST['result_min'];
        } else {
        // The result_avg variable is not set
        $result_min = null;
        }
        if (isset($_POST['result_range'])) {
        // The result_avg variable is set
        $result_range = $_POST['result_range'];
        } else {
        // The result_avg variable is not set
        $result_range = null;
        }
        if (isset($_POST['result_std'])) {
        // The result_avg variable is set
        $result_std = $_POST['result_std'];
        } else {
        // The result_avg variable is not set
        $result_std = null;
        }
        if (isset($_POST['result_cpk'])) {
        // The result_avg variable is set
        $result_cpk = $_POST['result_cpk'];
        } else {
        // The result_avg variable is not set
        $result_cpk = null;
        }

        if (isset($_POST['result_judgement'])) {
        // The result_avg variable is set
        $result_judgement = $_POST['result_judgement'];
        } else {
            // The result_avg variable is not set
        $result_judgement = null;
        }
    
    // Fetch relevant data from specification table based on spec_id
    $fetch_spec_sql = "SELECT * FROM specification WHERE spec_id = '$spec_id'";
    $fetch_spec_result = sqlsrv_query($con, $fetch_spec_sql);

    if ($fetch_spec_result === false) {
        // Query execution failed
        die(print_r(sqlsrv_errors(), true));
    }

    // Fetch data if the query executed successfully
    $spec_data = sqlsrv_fetch_array($fetch_spec_result, SQLSRV_FETCH_ASSOC);

    if ($spec_data) {
        // Extract data from specification table
        $spec_sc = $spec_data['spec_sc'];
        $spec_csl = $spec_data['spec_csl'];
        $spec_usl = $spec_data['spec_usl'];
        $spec_lsl = $spec_data['spec_lsl'];
        $spec_cpk = $spec_data['spec_cpk'];
        $spec_spl_point = $spec_data['spec_spl_point'];
        $spec_data_spl = $spec_data['spec_data_spl'];
        $spec_xcl = $spec_data['spec_xcl'];
        $spec_xucl = $spec_data['spec_xucl'];
        $spec_xlcl = $spec_data['spec_xlcl'];
        $spec_rucl = $spec_data['spec_rucl'];

        // Assuming other form data is retrieved via POST or GET
        $measure_id = $_POST['measure_id']; // Assuming measure_id is submitted via POST
        $item_id = $_POST['item_id']; // Assuming item_id is submitted via POST
        $id = $_POST['id']; // Assuming id is submitted via POST

        // Proceed with insertion into spec_result table
        $sql_insert = "INSERT INTO spec_result (spec_id, result_max, result_min, result_range, result_avg, result_std , result_judgement, result_cpk, measure_id , item_id , id, result_datetime, attempt, user_emp, remark, spec_sc, spec_csl, spec_usl, spec_lsl, spec_cpk, spec_spl_point, spec_data_spl, spec_xcl, spec_xucl, spec_xlcl, spec_rucl) 
        VALUES ('$spec_id', '$result_max', '$result_min', '$result_range', '$result_avg', '$result_std' , '$result_judgement', '$result_cpk', '$measure_id' , '$item_id' , '$id', '$result_datetime', '$attempt', '$user_emp', '$remark', '$spec_sc', '$spec_csl', '$spec_usl', '$spec_lsl', '$spec_cpk', '$spec_spl_point', '$spec_data_spl', '$spec_xcl', '$spec_xucl', '$spec_xlcl', '$spec_rucl')";

        $result_insert = sqlsrv_query($con, $sql_insert);

        if ($result_insert) {
            // Use Sweetalert to show a success message
            echo "
                <script src='sweetalert2.all.min.js'></script>
        <script>
          Swal.fire({
            icon: 'success',
            title: 'Your work has been saved',
            showConfirmButton: true,
                    timer: 15000,
      }).then((result) => {
        // The 'result' parameter will contain information about the user's interaction
        if (result.isConfirmed) {
          // Alternative: Reload the page after the user clicks 'OK'
          // window.location.reload();

          // Alternative: Reload the page by navigating to the current URL
          location.href = location.href;
        }
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
    } else {
        // Spec ID not found, show an error message
        echo "
        <script src='sweetalert2.all.min.js'></script>
        <script>
            Swal.fire({
                title: 'Spec ID Not Found!',
                text: 'The specified Spec ID does not exist.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
    }
}
?>
    </div>
  </div>
</div>
<?php

include 'includes/connect.php';

if(isset($_POST['submit'])){

        $averages = $_POST['averages'];
        $measure_id = $_GET['measure_id'];
        $item_id = $_GET['item_id'];
        $id = $_GET['id'];
        $attempt = $_GET['attempt'];

        // Prepare a SQL INSERT statement with multiple values
        $sql_send = "INSERT INTO average_values (measure_id, id, item_id, attempt, value_avg) VALUES (?, ?, ?, ?, ?)";

        // Execute a query for each average value in the array
        foreach ($averages as $value_avg) {

        $params = array();
        $params[] = $measure_id;
        $params[] = $id;
        $params[] = $item_id;
        $params[] = $attempt;
        $params[] = $value_avg;

        // Execute the prepared statement
        $result_send = sqlsrv_query($con, $sql_send, $params);

        if($result_insert1 > 0){
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
<?php include 'linechart.php'; ?>
  <?php
      } else {
        echo "<div class='alert alert-danger'><strong>No Records Found...</strong></div>";
      }
  ?>