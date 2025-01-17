
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
  
  $query = "SELECT * FROM measurement inner join process ON measurement.process_id=process.process_id inner join package ON measurement.pack_id=package.pack_id inner join machine ON measurement.mc_id=machine.mc_id inner join material ON measurement.material_id=material.material_id inner join customer ON measurement.cust_id=customer.cust_id  inner join partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id = $measure_id AND partnumber.id= $id AND item.item_id=$item_id";
  $result = sqlsrv_query($con,$query) or die('Database connection eror');
  $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

/*untuk check data wujud @ tak*/
  $spec_spl_point = $row['spec_spl_point'];
  $sql_check="SELECT * FROM spec_data WHERE measure_id = $measure_id AND id= $id AND item_id=$item_id AND attempt=$attempt";
  $query_check=sqlsrv_query($con,$sql_check);

    if(sqlsrv_has_rows($query_check)>0){

  $sql_calc = "SELECT count(data) AS N, SUM(data) AS total, MAX(data) AS result_max, MIN(data) AS result_min, AVG(data) AS result_avg FROM spec_data INNER JOIN measurement ON measurement.measure_id=spec_data.measure_id INNER JOIN item ON item.item_id=spec_data.item_id INNER JOIN specification ON specification.spec_id=spec_data.spec_id INNER JOIN partnumber ON partnumber.id=spec_data.id WHERE measurement.measure_id = $measure_id AND partnumber.id= $id AND item.item_id=$item_id AND attempt =$attempt ";
  $result_calc = sqlsrv_query ($con,$sql_calc);
  $row_calc = sqlsrv_fetch_array($result_calc,SQLSRV_FETCH_ASSOC);

  $total = $row_calc['total'];
  $N = $row_calc['N'];
    if (isset($row_calc['result_max'])) {
        $result_max = $row_calc['result_max'];
      } else {
        $result_max = null;
      }
    if (isset($row_calc['result_min'])) {
        $result_min = $row_calc['result_min'];
      } else {
        $result_min = null;
      }
    $result_range = ($result_max - $result_min);
    if (isset($row_calc['result_avg'])) {
        $result_avg = $row_calc['result_avg'];
      } else {
        $result_avg = null;
      }
    $spec_spl_point = $row['spec_spl_point'];
    $sql_std = "SELECT * FROM spec_data WHERE measure_id = '$measure_id' AND id= '$id' AND item_id='$item_id' AND attempt='$attempt' ";
    $result_std1 = sqlsrv_query ($con,$sql_std);

    $squared_deviations = array();
    while ($row_std = sqlsrv_fetch_array($result_std1, SQLSRV_FETCH_ASSOC)) {
      $data = $row_std['data'];
      $squared_deviations[] = pow($data - $result_avg, 2);
    }

    $variance = array_sum($squared_deviations) / (count($squared_deviations)-1);
    $result_std = sqrt($variance);
    
    $result_cpk = min((($row['spec_usl']-$result_avg)/(3*$result_std)),(($result_avg-$row['spec_lsl'])/(3*$result_std)));
?>

<div class="col-md-4 grid-margin stretch-card">
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
      <table class="table table-bordered table-sm">
        <thead>
          <tr class="table-light">
            <?php
            echo "<th class=text-center mt-3>#Spl</th>";
            for ($e=1; $e<=$row['spec_data_spl']; $e++){
                echo "<th class=text-center mt-3>Point ".$e."</th>";
              }
            echo "<th class=text-center mt-3>Result</th>";
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
                    if($row1['data_result'] == 'O')
                      {
                        echo "<td  class='text-center mt-3 text-success'><b>O</b></td>";
                      }
                      else
                      {
                        echo "<td  class='text-center mt-3 text-danger'><b>X</b></td>";
                      }  
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
<div class="col-4 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <form action="" method="POST">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th  class='text-center mt-3'>Average</th>
            <td  class='text-center mt-3'><?php echo round($result_avg,3); ?></td>
          </tr>
          <tr>
            <th  class='text-center mt-3'>Max</th>
            <td  class='text-center mt-3'><?php echo round($result_max,3); ?></td>
          </tr>
          <tr>
            <th  class='text-center mt-3'>Min</th>
            <td  class='text-center mt-3'><?php echo round($result_min,3); ?></td>
          </tr>
          <tr>
            <th  class='text-center mt-3'>Range</th>
            <td  class='text-center mt-3'><?php echo round($result_range,3); ?></td>
          </tr>
          <tr>
            <th  class='text-center mt-3'>Std Dev.</th>
            <td  class='text-center mt-3'><?php echo round($result_std,3); ?></td>
          </tr>
          
          <tr>
            <th  class='text-center mt-3'>Cpk</th>
            <td  class='text-center mt-3'><?php echo round($result_cpk,2); ?></td>
          </tr>
          
          <tr>
            <th  class='text-center mt-3'>Judgement</th>
            <?php
            if ($result_max <= $row['spec_usl'] && $result_min >= $row['spec_lsl'] && $result_cpk >=  $row['spec_cpk'])
            {
              $result_judgement = 'pass';
              echo "<td  class='text-center mt-3'><label class='badge bg-success'>Pass</label></td>";
            }else{
              echo "<td  class='text-center mt-3'><label class='badge bg-danger'>Failed</label></td>";
              $result_judgement = 'failed';
            }
            ?>
          </tr>
        </thead>
      </table>
      <br>
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
  include 'linechart.php';
      } else {
        echo "<div class='alert alert-danger'><strong>No Records Found...</strong></div>";
      }
  ?>