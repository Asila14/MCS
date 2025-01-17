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
  <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="library/dselect.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <!-- Add this line in your <head> section -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
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

      $query = "SELECT * FROM partnumber WHERE process_id = '$process_id' ";
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

                        // Fetch all part numbers ordered by process_name
                        $part = sqlsrv_query($con, "SELECT partnumber.id, partnumber.pn_no, process.process_name 
                                                     FROM partnumber 
                                                     INNER JOIN process ON partnumber.process_id = process.process_id 
                                                     ORDER BY process.process_name ASC");

                        $currentProcess = null; // To track the current process during iteration

                        if ($part > 0) {
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
                                ?>
                                <option value="<?php echo $pt['id'] ?>" data-process-id="<?php echo $process_id; ?>">
                                    <?php echo $pt['pn_no']; ?>
                                </option>
                            <?php } 

                            echo '</optgroup>'; // Close the last optgroup
                            echo '</select>';
                        }
                        ?>
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

                            // To list machine data with process name
                            $query = "SELECT machine.mc_id, machine.mc_name, process.process_name
                                      FROM machine
                                      INNER JOIN process ON machine.process_id = process.process_id ORDER BY process.process_name ASC";
                            $machine = sqlsrv_query($con, $query);

                            $currentProcess = null; // To track the current process during iteration

                            ?>
                            <input type="hidden" id="mc_id" name="mc_id" value="<?php if(isset($_POST['mc_id'])){echo $_POST['mc_id'];} ?>" class="form-control" />
                            <select data-live-search="true" name="mc_id" class="form-control selectpicker" required>
                                <option value="" selected>- Please Select -</option>
                                <?php 
                                if($machine > 0) {
                                    while($rowM = sqlsrv_fetch_array($machine, SQLSRV_FETCH_ASSOC)){
                                        // Check if the process has changed
                                        if ($currentProcess !== $rowM['process_name']) {
                                            // If yes, close the previous optgroup and start a new one
                                            if ($currentProcess !== null) {
                                                echo '</optgroup>';
                                            }
                                            echo '<optgroup label="' . $rowM['process_name'] . '">';
                                            $currentProcess = $rowM['process_name'];
                                        }
                                ?>
                                        <option name="mc_id" value="<?php echo $rowM['mc_id']?> " data-process-name="<?php echo $rowM['process_name']; ?>">
                                            <?php echo $rowM['mc_name']; ?>
                                        </option>
                                <?php
                                    }
                                    echo '</optgroup>'; // Close the last optgroup
                                }
                                ?>
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
      <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Bootstrap 5 CSS -->
        <link rel="stylesheet" href="path/to/bootstrap-5.min.css">

        <!-- DataTables Bootstrap 5 CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

        <!-- DataTables jQuery script -->
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

        <!-- DataTables Bootstrap 5 script -->
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

