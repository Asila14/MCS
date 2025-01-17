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
  <link src="sweetalert.js"></link>
  <script src="library/dselect.js"></script>
  <link rel="stylesheet" href="deliver.css">
  <!-- Add this line in your <head> section -->
  <link rel="stylesheet" href="dataTables.css">
</head>
<body>
    <!-- partial:partials/_navbar.html -->
    <?php
    include 'includes/navbar.php';
    ?>
    
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php
      ob_start();
      include 'includes/sidebar.php';
      ?>
      <?php

          include 'includes/connect.php';
            //to retrived data
            if (isset($_GET['spec_id']))
                $spec_id = $_GET['spec_id'];
            else
                $spec_id = 0;
            
            include 'includes/connect.php';

            $query = "SELECT * FROM specification INNER JOIN partnumber ON specification.id = partnumber.id INNER JOIN item ON specification.item_id = item.item_id WHERE spec_id = $spec_id ";
            $result = sqlsrv_query($con,$query) or die('Database connection eror');
            $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            
      ?>
                   <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Spec</h4>
                  <form class="forms-sample" action="" method="post">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Part No.</label>
                              <div class="col-sm-9">
                                <?php
                                include 'includes/connect.php';
                                $part = sqlsrv_query($con,"SELECT * FROM partnumber ");
                              ?>
                               
                              <select name="id" class="form-control">
                                <option name="id" value="<?php echo $row['id']; ?> " selected><?php echo $row['pn_no']; ?></option>
                                <?php 
                            if($part > 0) {
                                 while($pa = sqlsrv_fetch_array($part,SQLSRV_FETCH_ASSOC)){
                                ?>
                                  <option value="<?php echo $pa['id']?> "><?php echo $pa['pn_no']; ?><?php } } ?></option>
                              </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                           <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Item</label>
                              <div class="col-sm-9">
                                <?php
                                include 'includes/connect.php';
                                $item = sqlsrv_query($con,"SELECT * FROM item ");
                              ?>
         
                              <select name="item_id" class="form-control">
                                <option name="item_id" value="<?php echo $row['item_id']; ?> " selected><?php echo $row['item_name']; ?></option>
                                <?php 
                                if($item > 0) {
                                 while($i = sqlsrv_fetch_array($item,SQLSRV_FETCH_ASSOC)){
                                ?>
                                  <option value="<?php echo $i['item_id']?> "><?php echo $i['item_name']; ?>
                                    <?php } } ?></option>
                              </select>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">SC</label>
                              <div class="col-sm-9">
                                <select name="spec_sc" class="form-control" autocomplete="off" required>
                                <option name="spec_sc" value="<?php echo $row['spec_sc']; ?> " selected><?php echo $row['spec_sc']; ?></option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                              </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">CSL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_csl" class="form-control" autocomplete="off" value="<?php echo $row['spec_csl']; ?>">
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">USL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_usl" class="form-control" autocomplete="off" value="<?php echo $row['spec_usl']; ?>">
                              </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">LSL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_lsl" class="form-control" autocomplete="off" value="<?php echo $row['spec_lsl']; ?>">
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">CPK</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_cpk" class="form-control" autocomplete="off" value="<?php echo $row['spec_cpk']; ?>">
                              </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Spl Size</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_spl_point" class="form-control" autocomplete="off" value="<?php echo $row['spec_spl_point']; ?>">
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Data/Spl</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_data_spl" class="form-control" autocomplete="off" value="<?php echo $row['spec_data_spl']; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">XCL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_xcl" class="form-control" autocomplete="off" value="<?php echo $row['spec_xcl']; ?>">
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">XUCL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_xucl" class="form-control" autocomplete="off" value="<?php echo $row['spec_xucl']; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">XLCL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_xlcl" class="form-control" autocomplete="off" value="<?php echo $row['spec_xlcl']; ?>">
                              </div>
                            </div>
                          </div>
                        </div>
            
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">RUCL</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_rucl" class="form-control" autocomplete="off" value="<?php echo $row['spec_rucl']; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Attempt Limit</label>
                              <div class="col-sm-9">
                                <input type="text" name="spec_correction" class="form-control" autocomplete="off" value="<?php echo $row['spec_correction']; ?>">
                              </div>
                            </div>
                          </div>
                        </div>
            
                    <div class="modal-footer">
                      <input type="hidden" name="spec_id" value="<?php echo $row['spec_id']; ?>">
                      <input type="submit" name="edit" class="btn btn-danger" value=" Edit ">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
    // To edit data
    if (isset($_POST['edit']) && isset($_POST['spec_id'])) {
        // Retrieve the spec_id
        $spec_id = addslashes($_POST['spec_id']);

        // Include the database connection file
        include 'includes/connect.php';

        // Select data based on spec_id
        $select_query = "SELECT * FROM specification WHERE spec_id = '$spec_id'";
        $select_result = sqlsrv_query($con, $select_query);

        // Check if data was found
        if ($select_result) {
            // Fetch the data
            $row = sqlsrv_fetch_array($select_result, SQLSRV_FETCH_ASSOC);

            // Get the current datetime in Kuala Lumpur timezone
          date_default_timezone_set('Asia/Kuala_Lumpur');
          $current_datetime = date("Y-m-d H:i:s");

          // Get the user's employee number from the session variable.
          $user_emp = $_SESSION['user_emp'];

          // Query the database to get the user's data.
          $sql = "SELECT * FROM users WHERE user_emp = '$user_emp'";
          $result = sqlsrv_query($con, $sql);

          // Check if the query was successful
          if ($result) {
              // Fetch the user's data
              $user_row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

              // Retrieve the user's ID
              $user_id = $user_row['user_id']; // Assuming the column name is user_id

              // Insert fetched data into spec_history table along with user_id and current datetime
              $insert_query = "INSERT INTO spec_history 
                  (spec_id, spec_sc, spec_csl, spec_usl, spec_lsl, spec_cpk, spec_spl_point, spec_data_spl, spec_xcl, spec_xucl, spec_xlcl, spec_rucl, item_id, spec_correction, id, user_id, datetime)
                  VALUES ('$row[spec_id]', '$row[spec_sc]', '$row[spec_csl]', '$row[spec_usl]', '$row[spec_lsl]', '$row[spec_cpk]', '$row[spec_spl_point]', '$row[spec_data_spl]', '$row[spec_xcl]', '$row[spec_xucl]', '$row[spec_xlcl]', '$row[spec_rucl]', '$row[item_id]', '$row[spec_correction]', '$row[id]', '$user_id', '$current_datetime')";
              $insert_result = sqlsrv_query($con, $insert_query);
            } else {
              // Handle query failure
              echo "Query failed: " . sqlsrv_errors();
          }

            // Check if data was inserted successfully into spec_history
            if ($insert_result) {
                // Proceed with updating the data in the specification table
                $spec_sc = addslashes($_POST['spec_sc']);
                $spec_csl = addslashes($_POST['spec_csl']);
                $spec_usl = addslashes($_POST['spec_usl']);
                $spec_lsl = addslashes($_POST['spec_lsl']);
                $spec_cpk = addslashes($_POST['spec_cpk']);
                $spec_spl_point = addslashes($_POST['spec_spl_point']);
                $spec_data_spl = addslashes($_POST['spec_data_spl']);
                $spec_xcl = addslashes($_POST['spec_xcl']);
                $spec_xucl = addslashes($_POST['spec_xucl']);
                $spec_xlcl = addslashes($_POST['spec_xlcl']);
                $spec_rucl = addslashes($_POST['spec_rucl']);
                $item_id = addslashes($_POST['item_id']);
                $id = addslashes($_POST['id']);
                $spec_correction = addslashes($_POST['spec_correction']);

                // Update query for specification table
                $update_query = "UPDATE specification SET 
                                spec_sc = '$spec_sc',
                                spec_csl = '$spec_csl',
                                spec_usl = '$spec_usl',
                                spec_lsl = '$spec_lsl',
                                spec_cpk = '$spec_cpk',
                                spec_spl_point = '$spec_spl_point',
                                spec_data_spl = '$spec_data_spl',
                                spec_xcl = '$spec_xcl',
                                spec_xucl = '$spec_xucl',
                                spec_xlcl = '$spec_xlcl',
                                spec_rucl = '$spec_rucl',
                                item_id = '$item_id',
                                spec_correction = '$spec_correction',
                                id = '$id'
                                WHERE spec_id = '$spec_id'";
                
                // Execute the update query
                $update_result = sqlsrv_query($con, $update_query);

                // Check if update was successful
                if ($update_result) {
                    // Use Sweetalert to show a success message
                    echo '
                        <script>
                            swal({
                                title: "Done!",
                                text: "Data edit was successful",
                                icon: "success",
                                button: "OK",
                            });
                        </script>
                    ';
                    header("refresh:1; url=spec.php");
                } else {
                    // Use Sweetalert to show an error message for update failure
                    echo '
                        <script>
                            swal({
                                title: "Failed!",
                                text: "Edit failed.",
                                icon: "error",
                                button: "OK",
                            });
                        </script>
                    ';
                }
            } else {
                // Use Sweetalert to show an error message for insert failure
                echo '
                    <script>
                        swal({
                            title: "Failed!",
                            text: "Failed to insert data into spec_history.",
                            icon: "error",
                            button: "OK",
                        });
                    </script>
                ';
            }
        } else {
            // Use Sweetalert to show an error message for select failure
            echo '
                <script>
                    swal({
                        title: "Failed!",
                        text: "Failed to select data.",
                        icon: "error",
                        button: "OK",
                    });
                </script>
            ';
        }

        // Close the database connection
        sqlsrv_close($con);

        exit();
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
