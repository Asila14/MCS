<!DOCTYPE html>
<html lang="en">
<?php
include 'includes/head.php';
?>
<body>
    <!-- partial:partials/_navbar.html -->
    <?php
    ob_start();
    include 'includes/admin_navbar.php';
    ?>
    
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php
      include 'includes/admin_sidebar.php';

                //to retrived data
                        if (isset($_GET['material_id']))
                            $material_id = $_GET['material_id'];
                        else
                            $material_id = 0;
                        
                        include 'includes/connect.php';
                        
                        $query = "SELECT * FROM material inner join process ON material.process_id=process.process_id WHERE material_id = $material_id";
                        $result = sqlsrv_query($con,$query) or die('Database connection eror');
                        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                  
                        
                        //to edit data
                        if (isset($_POST['edit']) && isset($_POST['material_id'])) {
                            
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
                            $material_type = addslashes($_POST['material_type']);
                            $material_part = addslashes($_POST['material_part']);

                            include 'includes/connect.php';
                            
                            $query = "UPDATE material SET 
                            material_type = '$material_type',
                            material_part = '$material_part',
                            process_id = '$process_id'
                            WHERE material_id = '$material_id'";
                                
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
                             header ("refresh:1; url=admin_material.php");
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
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Material</h4>
                  <form class="forms-sample" action="" method="post">
                    <div class="form-group">
                            <label>Select Process</label>
                            <?php
                                  include 'includes/connect.php';
                                  $process = sqlsrv_query($con,"SELECT * FROM process ");
                            ?>
                            <input type="hidden" name="process_id" value="<?php if(isset($_POST['process_id'])){echo $_POST['process_id'];} ?>" class="form-control" />
                                <select name="process_id" data-live-search="true" class="form-control selectpicker" disabled>
                                  <option name="process_id" value="<?php echo $row['process_id']; ?> " selected><?php echo $row['process_name']; ?></option>
                                  <?php 
                                  if($process > 0) {
                                   while($p = sqlsrv_fetch_array($process,SQLSRV_FETCH_ASSOC)){
                                  
                                  ?>
                                    <option name="process_id" value="<?php echo $p['process_id']?> "><?php echo $p['process_name']; ?>
                                      <?php } } ?></option>
                                </select>
                          </div>
                    <div class="form-group">
                      <label>Type</label>
                      <input type="text" class="form-control" name="material_type" value="<?php echo $row['material_type']; ?>">
                    </div>
                    <div class="form-group">
                      <label>Part</label>
                      <input type="text" class="form-control" name="material_part" value="<?php echo $row['material_part']; ?>">
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="material_id" value="<?php echo $row['material_id']; ?>">
                      <input type="submit" name="edit" class="btn btn-danger" value=" Edit ">
                    </div>
                  </form>
                </div>
              </div>
            </div>
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

