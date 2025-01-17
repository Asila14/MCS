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
    ob_start();
    include 'includes/navbar.php';
    ?>
    
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php
      include 'includes/sidebar.php';

                //to retrived data
                        if (isset($_GET['process_id']))
                            $process_id = $_GET['process_id'];
                        else
                            $process_id = 0;
                        
                        include 'includes/connect.php';
                        
                        $query = "SELECT * FROM process  where process_id = $process_id";
                        $result = sqlsrv_query($con,$query) or die('Database connection eror');
                        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                  
                        
                        //to edit data
                        if (isset($_POST['edit']) && isset($_POST['process_id'])) {
              
                            $process_name = addslashes($_POST['process_name']);
                            $process_code = addslashes($_POST['process_code']);

                            include 'includes/connect.php';
                            
                            $query = "UPDATE process SET 
                                process_name = '$process_name',
                                process_code = '$process_code'
                                WHERE process_id = '$process_id'";
                                
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
                             header ("refresh:1; url=process.php");
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
                  <h4 class="card-title">Edit Process</h4>
                  <form class="forms-sample" action="" method="post">
                    <div class="form-group">
                      <label>Process Name</label>
                      <input type="text" class="form-control" name="process_name" value="<?php echo $row['process_name']; ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <label>Process Code</label>
                      <input type="text" class="form-control" name="process_code" value="<?php echo $row['process_code']; ?>" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="process_id" value="<?php echo $row['process_id']; ?>">
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

