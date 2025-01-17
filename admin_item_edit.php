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

                //to retrived data
                        if (isset($_GET['item_id']))
                            $item_id = $_GET['item_id'];
                        else
                            $item_id = 0;
                        
                        include 'includes/connect.php';
                        
                        $query = "SELECT * FROM item inner join process ON item.process_id=process.process_id WHERE item_id = $item_id";
                        $result = sqlsrv_query($con,$query) or die('Database connection eror');
                        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                   ?>
                   <?php
                        
                        //to edit data
                        if (isset($_POST['edit']) && isset($_POST['item_id'])) {
                            
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
                            $item_name = addslashes($_POST['item_name']);
                            $item_code = addslashes($_POST['item_code']);

                            include 'includes/connect.php';
                            
                            $query = "UPDATE item SET 
                                item_name = '$item_name',
                                item_code = '$item_code',
                                process_id = '$process_id'
                                WHERE item_id = '$item_id'";
                            
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
                             header ("refresh:1; url=admin_item.php");
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
                  <h4 class="card-title">Edit Item</h4>
                  <form class="forms-sample" action="" method="post">
                    <div class="form-group">
                      <label>Item Name</label>
                      <input type="text" class="form-control" name="item_name" value="<?php echo $row['item_name']; ?>">
                    </div>
                    <div class="form-group">
                      <label>Item Code</label>
                      <input type="text" class="form-control" name="item_code" value="<?php echo $row['item_code']; ?>">
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
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

