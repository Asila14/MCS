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

      $query = "SELECT * FROM partnumber_measure WHERE process_id = '$process_id' ";
      $query_run = sqlsrv_query($con,$query);
      ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Register Lot</h4>
                  <!-- <p class="card-description">
                    Horizontal form layout
                  </p> -->
                  <form class="forms-sample" method="POST" action="">
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-2 col-form-label">Part Number (PN)</label>
                      <div class="col-sm-8">
                        <?php
                              include 'includes/connect.php';
                              $part = sqlsrv_query($con,"SELECT * FROM partnumber_measure WHERE process_id = '$process_id' ");
                        ?>
                            <input type="hidden" id="id" name="id" value="<?php if(isset($_POST['id'])){echo $_POST['id'];} ?>" class="form-control" />
                            <select data-live-search="true" name="id" class="form-control selectpicker">
                              <option value="" selected>- Please Select -</option>
                              <?php 
                              if($part > 0) {
                               while($pt = sqlsrv_fetch_array($part,SQLSRV_FETCH_ASSOC)){
                              
                              ?>
                                <option name="id" value="<?php echo $pt['id']?> "><?php echo $pt['pn_no']; ?>
                                  <?php } } ?></option>
                            </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Lot Number (LN)</label>
                      <div class="col-sm-8">
                        <input class="form-control" type="text" autocomplete="off" name="SL_LN"
                          value="<?= isset($_POST['SL_LN']) ? strtoupper($_POST['SL_LN']) : '' ?>" required
                          pattern="^(?:[0-9]+[A-Za-z]*(?:-[0-9]+)?,?)+$"
                          title="Please enter a valid Lot No. with capital letter">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputMobile" class="col-sm-2 col-form-label">#Emp</label>
                      <div class="col-sm-8">
                        <input class="typeahead" type="text" autocomplete="off" name="SL_emp" 
                                 value="<?php if(isset($_POST['SL_emp'])){echo strtoupper($_POST['SL_emp']);} ?>"
                                 class="form-control" required pattern="[A-Za-z]\d{4,}" 
                                 title="Please use a capital letter and provide a valid employee number" />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Machine</label>
                      <div class="col-sm-8">
                        <?php
                            include 'includes/connect.php';
                            /*To list machine data*/
                          $machine = sqlsrv_query($con,"SELECT * FROM machine WHERE process_id='$process_id' ");
                          
                      ?>
                          <input type="hidden" id="mc_id" name="mc_id" value="<?php if(isset($_POST['mc_id'])){echo $_POST['mc_id'];} ?>" class="form-control" />
                          <select data-live-search="true" name="mc_id" class="form-control selectpicker" required>
                          <option value="" selected>- Please Select -</option>
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
                      <label for="exampleInputConfirmPassword2" class="col-sm-2 col-form-label">Status</label>
                      <div class="col-sm-8">
                        <input type="hidden" id="SL_status" name="SL_status" value="<?php if(isset($_POST['SL_status'])){echo $_POST['SL_status'];} ?>" class="form-control" />
                          <select data-live-search="true" name="SL_status" class="form-control selectpicker" required>
                          <option value="" selected>- Please Select -</option>
                          <option value="Received">Received</option>
                          <option value="Start">Start</option>
                          <option value="End">End</option>
                          <option value="Transfer">Transfer</option>
                          </select>
                      </div>
                    </div>
                    <button name="submit" type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php

include 'includes/connect.php';

//to add data
if (isset($_POST['submit'])) {

  //$SL_id = $_POST['SL_id'];
  $id = $_POST['id'];
  date_default_timezone_set('Asia/Kuala_Lumpur');
  $SL_datetime = date("Y-m-d H:i:s");
  $mc_id = $_POST['mc_id'];
  $SL_emp = $_POST['SL_emp'];
  $SL_status = $_POST['SL_status'];
  $SL_LN = $_POST['SL_LN'];

  // Check if the Status Lot already exists
$cleanedMeasureLot = trim($SL_LN);  // Trim leading and trailing spaces
$cleanedId = trim($id);  // Trim leading and trailing spaces

$sql_measure = "SELECT * FROM status_lot WHERE SL_LN LIKE ? AND id = ?";
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
  $sqlmeasure = "INSERT INTO status_lot (SL_datetime, mc_id, SL_emp, SL_status, SL_LN, id)
    VALUES ('$SL_datetime', '$mc_id', '$SL_emp', '$SL_status', '$SL_LN', '$id')";
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
    echo "<meta http-equiv='refresh' content='0;url=admin_measurement_list.php'>";
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

