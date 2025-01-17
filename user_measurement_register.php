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
            <!-- Register Process for the 1st time -->
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Register New Measurement</h4>

                <!-- Add new process input by user -->
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

                        $query = "SELECT * FROM partnumber WHERE process_id = '$process_id' ";
                        $query_run = sqlsrv_query($con,$query);

                        /*If process registered success , directly go to register item*/
                        if($query_run)
                        {
                          ?>
                            <form action="" method="POST">
                              <h6 class="text-danger">If PN is not listed, please REGISTER PART NO</h6>
                              <br>
                                <div class="row">
                                  <div class="form-group row">
                                    <div class="col-md-6">
                                      <label>Select Part No.</label>
                                      <?php
                                            include 'includes/connect.php';
                                            $part = sqlsrv_query($con,"SELECT * FROM partnumber WHERE process_id = '$process_id' ");
                                      ?>
                                          <input type="hidden" id="id" name="id" value="<?php if(isset($_POST['id'])){echo $_POST['id'];} ?>" class="form-control" />
                                          <select data-live-search="true" name="id" class="form-control selectpicker">
                                            <option>- Please Select -</option>
                                            <?php 
                                            if($part > 0) {
                                             while($pt = sqlsrv_fetch_array($part,SQLSRV_FETCH_ASSOC)){
                                            
                                            ?>
                                              <option name="id" value="<?php echo $pt['id']?> "><?php echo $pt['pn_no']; ?>
                                                <?php } } ?></option>
                                          </select>
                                    </div>
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
                          <?php 
                        }  
                ?>
                <!-- If total id already submit , next will go to measure_lot name input -->
                <?php
                include 'includes/connect.php';

                if (isset ($_POST['S']))
                {
                  $id = $_POST['id'];
                  $process_id = $_POST['process_id'];
                  /*To list customer data*/
                  $cust = sqlsrv_query($con,"SELECT * FROM partnumber inner join customer ON partnumber.cust_id=customer.cust_id inner join package ON partnumber.pack_id=package.pack_id inner join process ON partnumber.process_id=process.process_id INNER JOIN material ON partnumber.material_id=material.material_id WHERE id='$id' ");
                  $rowC = sqlsrv_fetch_array($cust,SQLSRV_FETCH_ASSOC);
                ?>
                <div class="col-6 grid-margin">
                <h3 class="text-dark">Process: <?php echo $rowC['process_name']; ?> </h3><h3 class="text-primary">(<?php echo $rowC['pn_no']; ?>)</h3>
                <br>
                <h4 class="text-dark">Register New Lot</h4>
                <br>
                <form action="" method="POST">
                  <div class="form-group row">
                    <input type="hidden" name="id" value="<?php if(isset($_POST['id'])){echo $_POST['id'];} ?>" class="form-control" />
                    <?php
                    date_default_timezone_set('Asia/Kuala_Lumpur');
                    $measure_datetime = date("Y-m-d H:i:s");
                    ?>
                    <div class="col">
                      <label>Lot No.</label>
                      <div id="bloodhound">
                        <input class="form-control" type="text" autocomplete="off" name="measure_lot"
                          value="<?= isset($_POST['measure_lot']) ? strtoupper($_POST['measure_lot']) : '' ?>" required
                          pattern="^(?:[0-9]+[A-Za-z]*(?:-[0-9]+)?,?)+$"
                          title="Please enter a valid Lot No. with capital letter">
                    </div>
                  </div>
                    <div class="col">
                      <label>Customer</label>
                      <div id="the-basics">
                        <input class="typeahead" type="hidden" name="cust_id" value="<?php echo $rowC['cust_id']; ?>"/>
                        <input class="typeahead" type="text" value="<?php echo $rowC['cust_name'] ?>" readonly/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col">
                      <label>Employee No.</label>
                      <div id="the-basics">
                          <input class="typeahead" type="text" autocomplete="off" name="measure_emp" 
                                 value="<?php if(isset($_POST['measure_emp'])){echo strtoupper($_POST['measure_emp']);} ?>"
                                 class="form-control" required pattern="[A-Za-z]\d{4,}" 
                                 title="Please use a capital letter and provide a valid employee number" />
                      </div>
                  </div>
                    <div class="col">
                      <label>Package</label>
                      <div id="bloodhound">
                        <input class="typeahead" type="hidden" name="pack_id" value="<?php echo $rowC['pack_id']; ?>"/>
                        <input class="typeahead" type="text" value="<?php echo $rowC['pack_name'] ?>" readonly/>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col">
                      <label>Select Machine</label>
                      <?php
                            include 'includes/connect.php';
                            /*To list machine data*/
                          $machine = sqlsrv_query($con,"SELECT * FROM machine WHERE process_id='$process_id' ");
                          
                      ?>
                          <input type="hidden" id="mc_id" name="mc_id" value="<?php if(isset($_POST['mc_id'])){echo $_POST['mc_id'];} ?>" class="form-control" />
                          <select data-live-search="true" name="mc_id" class="form-control selectpicker" required>
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

                  <div class="form-group row">
				  <div class="col">
                      <label>Material</label>
                      <div id="the-basics">
                        <input class="typeahead" type="hidden" name="material_id" value="<?php echo $rowC['material_id']; ?>"/>
                        <input class="typeahead" type="text" value="<?php echo $rowC['material_part'] ?>" readonly/>
                      </div>
                    </div>
					<!-- <div class="col">
                      <label>Select Material</label>
                      <?php
                            include 'includes/connect.php';
                            /*To list machine data*/
                          $material = sqlsrv_query($con,"SELECT * FROM material WHERE process_id='$process_id' ");
                          
                      ?>
                          <input type="hidden" id="material_id" name="material_id" value="<?php if(isset($_POST['material_id'])){echo $_POST['material_id'];} ?>" class="form-control" />
                          <select data-live-search="true" name="material_id" class="form-control selectpicker" required>
                            <option value="" selected disabled>- Please Select -</option>
                            <?php 
                            if ($material > 0) {
                                while ($rowMe = sqlsrv_fetch_array($material, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $rowMe['material_id']?>"><?php echo $rowMe['material_part']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div> -->
                    <div class="col">
                      <label>Material Lot</label>
                      <div id="bloodhound">
                        <input class="typeahead" type="text" autocomplete="off" name="measure_mate_lot" value="<?php if(isset($_POST['measure_mate_lot'])){echo $_POST['measure_mate_lot'];} ?>" class="form-control" required />
                      </div>
                    </div>
                  </div>
                  <div id="bloodhound">
                    <input type="hidden" name="process_id" value="<?php echo $process_id ?>" />
                    <button type="submit" name="submitmeasure" class="btn btn-sm btn-primary">Submit</button>
                  </div>
                </form>
              </div>
              <?php 
              }
                      
              ?>
        </div>
      </div>
    </div>
  </div>

<?php

include 'includes/connect.php';

//to add data
if (isset($_POST['submitmeasure'])) {

  $id = $_POST['id'];

  //Check in spec either the data already register or not
  $spec_check = "SELECT * FROM specification WHERE id = $id";
  $spec_result = sqlsrv_query($con,$spec_check);
  if (sqlsrv_has_rows($spec_result) == 0) {
  echo "<div id='myModal' class='modal fade' role='dialog'>
          <div class='modal-dialog'>
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
              <strong>Specification Not Register ! </strong> The specification with the given <strong>PN</strong> is not registered yet. Please register the specification before continuing.
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
      </div>
    </div>
  </div>
";
}
  else{

  $id = $_POST['id'];
  $measure_lot = strtoupper($_POST['measure_lot']);
  $measure_emp = strtoupper($_POST['measure_emp']);
  date_default_timezone_set('Asia/Kuala_Lumpur');
  $measure_datetime = date("Y-m-d H:i:s");
  $cust_id = $_POST['cust_id'];
  $process_id = $_POST['process_id'];
  $pack_id = $_POST['pack_id'];
  $mc_id = $_POST['mc_id'];
  $material_id = $_POST['material_id'];
  $measure_mate_lot = $_POST['measure_mate_lot'];

  // Check if the measurement already exists
$cleanedMeasureLot = trim($measure_lot);  // Trim leading and trailing spaces
$cleanedId = trim($id);  // Trim leading and trailing spaces

$sql_measure = "SELECT * FROM measurement WHERE measure_lot LIKE ? AND id = ?";
$params = array($cleanedMeasureLot, $cleanedId);
$result_measure = sqlsrv_query($con, $sql_measure, $params);

if ($result_measure === false) {
    die(print_r(sqlsrv_errors(), true));  // Check for query execution errors
}

if (sqlsrv_has_rows($result_measure) > 0) {
    // The measure_lot already exists
    echo '
      <script>
        swal({
          title: "Failed!",
          text: "Data already exists!",
          icon: "error",
          button: "OK",
        });
      </script>
    ';
} else {

  // insert data into measurement table
  $sqlmeasure = "INSERT INTO measurement (id, measure_lot, measure_emp, measure_datetime, cust_id, process_id, pack_id, mc_id, material_id, measure_mate_lot)
    VALUES ('$id', '$measure_lot', '$measure_emp', '$measure_datetime', '$cust_id', '$process_id', '$pack_id', '$mc_id', '$material_id', '$measure_mate_lot')";
  $resultmeasure = sqlsrv_query($con, $sqlmeasure) or die('Database connection error');
  $row = sqlsrv_fetch_array($resultmeasure,SQLSRV_FETCH_ASSOC);

  // check if data is inserted successfully
  if ($resultmeasure > 0) {
  // Use Sweetalert to show a success message
  echo '
    <script>
      swal({
        title: "Done!",
        text: "The operation was successful.",
        icon: "success",
        button: "OK",
      });
    </script>';
    echo "<meta http-equiv='refresh' content='0;url=user_measurement_list.php'>";
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
}
?>

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
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


