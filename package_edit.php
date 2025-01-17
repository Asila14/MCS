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
      ob_start();
      include 'includes/sidebar.php';
      ?>
      <?php

                //to retrived data
                        if (isset($_GET['pack_id']))
                            $pack_id = $_GET['pack_id'];
                        else
                            $pack_id = 0;
                        
                        include 'includes/connect.php';
                        
                        $query = "SELECT * FROM package WHERE pack_id = $pack_id";
                        $result = sqlsrv_query($con,$query) or die('Database connection eror');
                        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                   ?>
                   <?php
                        
                        //to edit data
                        if (isset($_POST['edit']) && isset($_POST['pack_id'])) {
                            
                            $pack_name = addslashes($_POST['pack_name']);

                            include 'includes/connect.php';
                            
                            $query = "UPDATE package SET 
                                pack_name = '$pack_name'
                                WHERE pack_id = '$pack_id'";
                            
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
                             header ("refresh:1; url=package.php");
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
                  <h4 class="card-title">Edit Package</h4>
                  <form class="forms-sample" action="" method="post">
                    <div class="form-group">
                      <label>Package</label>
                      <input type="text" class="form-control" name="pack_name" value="<?php echo $row['pack_name']; ?>">
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="pack_id" value="<?php echo $row['pack_id']; ?>">
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

