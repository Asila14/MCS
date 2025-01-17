<!DOCTYPE html>
<html lang="en">
<?php
include 'includes/head.php';
?>
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
                        if (isset($_GET['cust_id']))
                            $cust_id = $_GET['cust_id'];
                        else
                            $cust_id = 0;
                        
                        include 'includes/connect.php';
                        
                        $query = "SELECT * FROM customer WHERE cust_id = $cust_id ORDER BY cust_name ASC";
                        $result = sqlsrv_query($con,$query) or die('Database connection eror');
                        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                  
                        
                        //to edit data
                        if (isset($_POST['edit']) && isset($_POST['cust_id'])) {
                            
                            $cust_name = addslashes($_POST['cust_name']);

                            include 'includes/connect.php';
                            
                            $query = "UPDATE customer SET 
                                cust_name = '$cust_name'
                                WHERE cust_id = '$cust_id'";
                                
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
                             header ("refresh:1; url=customer.php");
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
                  <h4 class="card-title">Edit Customer</h4>
                  <form class="forms-sample" action="" method="post">
                    <div class="form-group">
                      <label>Customer Name</label>
                      <input type="text" class="form-control" name="cust_name" value="<?php echo $row['cust_name']; ?>">
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="cust_id" value="<?php echo $row['cust_id']; ?>">
                      <input type="submit" name="edit" class="btn btn-danger" value=" Edit ">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
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

