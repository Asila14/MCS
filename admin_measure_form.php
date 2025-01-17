<!DOCTYPE html>
<html lang="en">
<?php
include 'includes/head.php';
?>
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
        <?php
        //to retrived data
        if (isset($_GET['spec_id']) && isset($_GET['measure_id']) && isset($_GET['item_id']) && isset($_GET['id']) && isset($_GET['attempt'])){
            $measure_id = $_GET['measure_id'];
            $spec_id = $_GET['spec_id'];
            $item_id = $_GET['item_id'];
            $id = $_GET['id'];
            $attempt = $_GET['attempt'];
        }
        
        include 'includes/connect.php';

        // untuk check data wujud @ tak
      $sql_check="SELECT * FROM spec_data WHERE measure_id = $measure_id AND id= $id AND item_id=$item_id AND attempt=$attempt";
      $query_check=sqlsrv_query($con,$sql_check);

        if(sqlsrv_has_rows($query_check)>0){

          $query = "SELECT * FROM measurement inner join process ON measurement.process_id=process.process_id inner join package ON measurement.pack_id=package.pack_id inner join machine ON measurement.mc_id=machine.mc_id inner join material ON measurement.material_id=material.material_id inner join customer ON measurement.cust_id=customer.cust_id inner join partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id='$measure_id' AND partnumber.id='$id' AND item.item_id='$item_id'";

            $result = sqlsrv_query($con,$query) or die('Database connection eror');
            $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

            if (trim($row['item_name']) == "Pull Back" && ($row['item_id']) == "31") {
              include 'admin_pullback_report.php';
          } else {
              if ($row['spec_data_spl'] > 1) {
                  include 'admin_measure_average.php';
              } else {
                  include 'admin_measure_report.php';
              }
          }
        }
        else {

          $query = "SELECT * FROM measurement inner join process ON measurement.process_id=process.process_id inner join package ON measurement.pack_id=package.pack_id inner join machine ON measurement.mc_id=machine.mc_id inner join material ON measurement.material_id=material.material_id inner join customer ON measurement.cust_id=customer.cust_id  inner join partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id = $measure_id AND partnumber.id= $id AND item.item_id=$item_id";
      $result = sqlsrv_query($con,$query) or die('Database connection eror');
      $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
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
            <form action="" method="POST" onsubmit="numberValidation()"> 
              <p class="text-success">
                  <b>LSL:</b> <?php echo $row['spec_lsl'] ?>
                  <br>
                  <b>USL:</b> <?php echo $row['spec_usl'] ?>
                </p>
              <div class="card-body">
                  <div class="form-group row">
                    <div class="col">
                      <label>Employee</label>
                      <div id="the-basics">
                        <input class="typeahead" autocomplete="off" type="text" id="employeeNumber" name="user_data" pattern="[A-Z]\d{4,}" title="Please enter a valid Employee Number (e.g., M1234)" required>
                      </div>
                    </div>
                    <div class="col">
                      <label>Select Machine</label>
                      <?php
                            include 'includes/connect.php';
                            /*To list machine data*/
                            $process_id = $row['process_id'];
                            $machine = sqlsrv_query($con,"SELECT * FROM machine WHERE process_id='$process_id' ");
                      ?>
                          <input type="hidden" id="mc_id" name="mc_id" required>
                          <select data-live-search="true" name="mc_id" class="form-control selectpicker" >
                          <option value="" selected disabled>- Please Select -</option>
                            <?php 
                            if($machine > 0) {
                             while($rowM = sqlsrv_fetch_array($machine,SQLSRV_FETCH_ASSOC)){
                            
                            ?>
                              <option name="mc_id" value="<?php echo $rowM['mc_id']?> "><?php echo $rowM['mc_name']; ?>
                                <?php } } ?></option>
                          </select>
                    </div> 
                  </div>
                </div>
              <div class="table-responsive">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr class="table-light">
                      <th class='text-center mt-3'>Spl#</th>
                      <?php
                      for ($e=1; $e<=$row['spec_data_spl']; $e++){
                          echo "<th>Point ".$e."</th>";
                        }
                        ?>
                    </tr>
                  </thead>
                  <tbody class="table table-sm">
                    <?php
                    $count = 1;

                    $specSplPoint = $row['spec_spl_point'];
                    $specDataSpl = $row['spec_data_spl'];

                    for ($i = 1; $i <= $specSplPoint; $i++) {
                      echo '<tr>';
                      echo '<td class="text-center mt-3">' . $i . '</td>';

                      if ($specDataSpl > 0) {
                        for ($d = 1; $d <= $specDataSpl; $d++) {
                          echo '<td class="text-center mt-3">
                            <input type="number" name="' . $i . $d . 'data" step="0.001" class="form-control" autocomplete="off" placeholder="Input data" required>
                          </td>';
                        }
                        }
                        ?>
                          <?php
                        $count++;
                      }
                    ?>
                  </tbody>
                </table>
                <br>
                <div class="form-group">
                  <input type="hidden" name="status_judge" value="in" />
                  <input type="hidden" name="attempt" value="<?php echo $_GET['attempt']; ?>" />
                  <input type="hidden" name="measure_id" value="<?php echo $_GET['measure_id']; ?>" />
                  <input type="hidden" name="spec_id" value="<?php echo $_GET['spec_id']; ?>" />
                  <input type="hidden" name="item_id" value="<?php echo $_GET['item_id']; ?>" />
                  <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                  <?php
                  date_default_timezone_set('Asia/Kuala_Lumpur');
                  $data_datetime = date("Y-m-d H:i:s");
                  ?>
                  <a href="admin_measure_add.php?measure_id=<?php echo $_GET['measure_id']; ?>&spec_id=<?php echo $_GET['spec_id']; ?>&item_id=<?php echo $_GET['item_id']; ?>&id=<?php echo $_GET['id']; ?>" class="btn btn-secondary">Back</a>
                  <button type="submit" name="ins" class="btn btn-primary">Statistic</button>
                </div>
                <script>
                  document.querySelector('input').addEventListener('input', e=>{
                    const el = e.target || e
                    if(el.type == "number" && el.max && el.min ){
                      let value = parseInt(el.value)
                      el.value = value // for 000 like input cleanup to 0
                      let max = parseInt(el.max)
                      let min = parseInt(el.min)
                      if ( value >= max ) el.value = el.max
                        if ( value <= min ) el.value = el.min
                      }
                  });
                </script>
                </div>
                </form>
                </div>
              </div>
            </div>
           <?php
            include 'includes/connect.php';
            if (isset($_POST['ins']) && isset($_GET['measure_id']) && isset($_GET['id']) && isset($_GET['spec_id']) && isset($_GET['item_id'])&& isset($_GET['attempt']) ) {

            $measure_id = $row["measure_id"];
            $spec_id = $row["spec_id"];
            $spec_id = $row["spec_id"];
            $item_id = $row["item_id"];
            $id = $row["id"];
            $status_judge = $_POST['status_judge'];
            $count = 1;
            $mc_id = $_POST['mc_id'];
            $user_data = $_POST['user_data'];
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $data_datetime = date("Y-m-d H:i:s");
            for ($i=1; $i <= $row['spec_spl_point']; $i++) { 
            for ($d=1; $d<=$row['spec_data_spl']; $d++){
            $data = $_POST[$i.$d."data"];
            if($data <=$row['spec_usl'] && $data >=$row['spec_lsl'])
            {
              $data_result = 'O';
            }
            else
            {
              $data_result = 'X';
            }
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $data_date = date("d-M-Y  H:i");
            $sql_data = "INSERT INTO spec_data (data,spec_id,measure_id,status_judge,data_result,item_id,id,attempt,data_datetime,mc_id,user_data) VALUES ('$data','$spec_id','$measure_id','$status_judge','$data_result','$item_id','$id','$attempt','$data_datetime','$mc_id','$user_data')";
            $result_sql_data = sqlsrv_query ($con,$sql_data);

            if ($result_sql_data > 0) {
    echo "<script src='sweetalert2.all.min.js'></script>";
    // Success message
    echo "
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Your work has been saved',
            showConfirmButton: true,
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload(); // Reload the page
            }
        });
    </script>";
} else {
    // Error message
    echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Failed!',
            text: 'The operation failed.',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload(); // Reload the page
            }
        });
    </script>";
}
                }
              }
            }

            $query = "SELECT * FROM measurement 
          INNER JOIN process ON measurement.process_id = process.process_id 
          INNER JOIN package ON measurement.pack_id = package.pack_id 
          INNER JOIN machine ON measurement.mc_id = machine.mc_id 
          INNER JOIN material ON measurement.material_id = material.material_id 
          INNER JOIN customer ON measurement.cust_id = customer.cust_id 
          INNER JOIN partnumber ON measurement.id = partnumber.id 
          INNER JOIN specification ON partnumber.id = specification.id 
          INNER JOIN item ON specification.item_id = item.item_id 
          WHERE measure_id='$measure_id' AND partnumber.id='$id' AND item.item_id='$item_id'";

          $result = sqlsrv_query($con, $query);

          if ($result === false) {
              die(print_r(sqlsrv_errors(), true));
          }

          $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

              if (trim($row['item_name']) == "Pull Back" && ($row['item_id']) == "31") {
                  include 'admin_pullback_report.php';
              } else {
              if ($row['spec_data_spl'] > 1) {
                  include 'admin_measure_average.php';
              } else {
                  include 'admin_measure_report.php';
              }
          }
          }
          ?>
          </div>
        </div>
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
