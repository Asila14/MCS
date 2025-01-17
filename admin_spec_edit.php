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
      ob_start();
      include 'includes/admin_sidebar.php';
      ?>
      <?php

      include 'includes/connect.php';
                //to retrived data
                        if (isset($_GET['spec_id']))
                            $spec_id = $_GET['spec_id'];
                        else
                            $spec_id = 0;
                        
                        include 'includes/connect.php';

                        $query = "SELECT * FROM specification INNER JOIN partnumber ON specification.id = partnumber.id INNER JOIN item ON specification.item_id = item.item_id INNER JOIN process ON partnumber.process_id=process.process_id WHERE spec_id = $spec_id ";
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
                                 $query = "SELECT * FROM specification INNER JOIN partnumber ON specification.id = partnumber.id INNER JOIN item ON specification.item_id = item.item_id INNER JOIN process ON partnumber.process_id=process.process_id WHERE spec_id = $spec_id ";
                                $result = sqlsrv_query($con,$query) or die('Database connection eror');
                                $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                                $part = sqlsrv_query($con,"SELECT * FROM partnumber WHERE process_id='$process_id'");
                              ?>
                              <input type="hidden" name="id" value="<?php if(isset($_POST['id'])){echo $row['pn_no'];} ?>" /> 
                              <select name="id" data-live-search="true" class="form-control selectpicker">
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
                                // Get the user's employee number from the session variable.
                                    $user_emp = $_SESSION['user_emp'];

                                    // Query the database to get the user's process ID.
                                    $sql = "SELECT process_id FROM users WHERE user_emp = '$user_emp'";
                                    $result = sqlsrv_query($con, $sql);
                                    $row1 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

                                    // Set the user's process ID in the session variable.
                                    $_SESSION['process_id'] = $row1['process_id'];

                                    // Get the process ID from the session variable.
                                    $process_id = $_SESSION['process_id'];
                                $item = sqlsrv_query($con,"SELECT * FROM item WHERE process_id='$process_id'");
                              ?>
                                <input type="hidden" name="item_id" value="<?php if(isset($_POST['item_id'])){echo $row['item_name'];} ?>" /> 
                              <select name="item_id" data-live-search="true" class="form-control selectpicker">
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
                                <select name="spec_sc" data-live-search="true" class="form-control selectpicker" autocomplete="off" required>
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
                        //to edit data
                        if (isset($_POST['edit']) && isset($_POST['spec_id'])) {

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

                            include 'includes/connect.php';
                            
                            $query = "UPDATE specification SET 

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
                            
                            $result = sqlsrv_query($con,$query);
                             if ($result) {
                            // Use Sweetalert to show a success message
                            echo '
                              <script>
                                swal({
                                  title: "Done!",
                                  text: "Data edited was successful",
                                  icon: "success",
                                  button: "OK",
                                });
                              </script>
                            ';
                             header ("refresh:1; url=admin_spec.php");
                          } else {
                            // Use Sweetalert to show an error message
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

