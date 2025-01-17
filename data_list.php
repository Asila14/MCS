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
      include 'includes/sidebar.php';
      ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">

            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Search Process</h4>
                  <form action="" method="POST">
                    <p class="card-description">Select Process.<code>If the PROCESS is not listed, please REGISTER. </code></p>
                    <div class="row">
                      <div class="form-group row">
                        <div class="col-md-6">
                          <label>Select Process</label>
                          <?php
                                include 'includes/connect.php';
                                $process = sqlsrv_query($con,"SELECT * FROM process ");
                          ?>
                                <input type="hidden" id="process_name" name="process_name" value="<?php if(isset($_POST['process_name'])){echo $_POST['process_name'];} ?>" class="form-control" />
                              <select name="process_id" class="form-control">
                                <?php 
                                if($process > 0) {
                                 while($p = sqlsrv_fetch_array($process,SQLSRV_FETCH_ASSOC)){
                                
                                ?>
                                  <option name="process_id" value="<?php echo $p['process_id']?> "><?php echo $p['process_name']; ?>
                                    <?php } } ?></option>
                              </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="input-group-append">
                        <button type="submit" name="search" class="btn btn-sm btn-primary">Search</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                <?php
                include 'includes/connect.php';

                if(isset($_POST['search']))

                  {     
                        /*To list item data*/
                        $process_name = $_POST['process_name'];

                        $item = sqlsrv_query($con,"SELECT * FROM item WHERE process_name='$process_name' ");
                          
                          ?>
                          <div class="form-group">
                          <div class="table-responsive">
                            <h4 class="card-title">Registered Item
                            <button type="button" class="btn btn-primary btn-rounded btn-icon" data-bs-toggle="modal" data-bs-target="#AddItem">
                              <i class="ti-plus"></i>
                            </button></h4>
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Item</th>
                                  <th>Edit</th>
                                  <th>Delete</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tbody>
                                <?php
                                if($item > 0)
                                {
                                  while ($row = sqlsrv_fetch_array($item,SQLSRV_FETCH_ASSOC)) 
                                {
                                        echo "<tr>";
                                        echo "<td>".$row['item_id']."</td>";
                                        echo "<td>".$row['item_name']."</td>";
                                        echo "<td><a class=btn btn-primary href=item_edit.php?item_id=".$row['item_id']."><i class=ti-eraser></i></a></td>";
                                        echo "<td><a class=btn btn-primary href=item_del.php?item_id=".$row['item_id']."><i class=ti-trash></i></a></td>";
                                        echo "</tr>";
                                }
                                
                                
                                
                                ?>
                              </tbody>
                            </table>
                        </div>
                        </div>
                          <?php 
                        }
                        else
                        {
                        
                          echo "<p class=card-description><code>No Records Found !</code></p>";
                          
                        }
                        /*To list material data*/
                        $material = sqlsrv_query($con,"SELECT * FROM material WHERE process_name='$process_name' ");

                        if($material)
                        {
                          ?>
                          <div class="form-group">
                          <div class="table-responsive">
                            <h4 class="card-title">Registered Material
                            <button type="button" class="btn btn-primary btn-rounded btn-icon" data-bs-toggle="modal" data-bs-target="#AddMaterial">
                              <i class="ti-plus"></i>
                            </button></h4>
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Type</th>
                                  <th>Part</th>
                                  <th>Edit</th>
                                  <th>Delete</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tbody>
                                <?php
                                if($material > 0)
                                {
                                while ($rowm = sqlsrv_fetch_array($material,SQLSRV_FETCH_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td>".$rowm['material_id']."</td>";
                                        echo "<td>".$rowm['material_type']."</td>";
                                        echo "<td>".$rowm['material_part']."</td>";
                                        echo "<td><a class=btn btn-primary href=material_edit.php?material_id=".$rowm['material_id']."><i class=ti-eraser></i></a></td>";
                                        echo "<td><a class=btn btn-primary href=material_del.php?material_id=".$rowm['material_id']."><i class=ti-trash></i></a></td>";
                                        echo "</tr>";
                                            }
                                ?>
                              </tbody>
                            </table>
                        </div>
                      </div>
                          <?php 
                        }
                        else
                        {
                           echo "<p class=card-description><code>No Records Found !</code></p>";
                        }

                        /*To list machine data*/
                        $machine = sqlsrv_query($con,"SELECT * FROM machine WHERE process_name='$process_name' ");

                        if($machine)
                        {
                          ?>
                          <div class="form-group">
                          <div class="table-responsive">
                            <h4 class="card-title">Registered Machine
                            <button type="button" class="btn btn-primary btn-rounded btn-icon" data-bs-toggle="modal" data-bs-target="#AddMachine">
                              <i class="ti-plus"></i>
                            </button></h4>
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Process</th>
                                <th>Edit</th>
                                <th>Delete</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              if($machine > 0)
                                {
                              while ($rowmc = sqlsrv_fetch_array($machine,SQLSRV_FETCH_ASSOC)) {
                                      echo "<tr>";
                                      echo "<td>".$rowmc['mc_id']."</td>";
                                      echo "<td>".$rowmc['mc_name']."</td>";
                                      echo "<td><a class=btn btn-primary href=machine_edit.php?mc_id=".$rowmc['mc_id']."><i class=ti-eraser></i></a></td>";
                                      echo "<td><a class=btn btn-primary href=machine_del.php?mc_id=".$rowmc['mc_id']."><i class=ti-trash></i></a></td>";
                                      echo "</tr>";
                                  }
                              ?>
                            </tbody>
                            </table>
                        </div>
                      </div>
                          <?php 
                        }
                        else
                        {
                           echo "<p class=card-description><code>No Records Found !</code></p>";
                        }

                        /*To list package data*/
                        $package = sqlsrv_query($con,"SELECT * FROM package WHERE process_name='$process_name' ");

                        if($package)
                        {
                          ?>
                          <div class="form-group">
                          <div class="table-responsive">
                            <h4 class="card-title">Registered Package
                            <button type="button" class="btn btn-primary btn-rounded btn-icon" data-bs-toggle="modal" data-bs-target="#AddPackage">
                            <i class="ti-plus"></i>
                          </button></h4>
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                <th>#</th>
                                <th>Package</th>
                                <th>Edit</th>
                                <th>Delete</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              if($package > 0)
                                {
                              while ($rowp = sqlsrv_fetch_array($package,SQLSRV_FETCH_ASSOC)) {
                                      echo "<tr>";
                                      echo "<td>".$rowp['pack_id']."</td>";
                                      echo "<td>".$rowp['pack_name']."</td>";
                                      echo "<td><a class=btn btn-primary href=package_edit.php?pack_id=".$rowp['pack_id']."><i class=ti-eraser></i></a></td>";
                                      echo "<td><a class=btn btn-primary href=package_del.php?pack_id=".$rowp['pack_id']."><i class=ti-trash></i></a></td>";
                                      echo "</tr>";
                                  }
                              ?>
                            </tbody>
                            </table>
                        </div>
                      </div>
                          <?php 
                        }
                        else
                        {
                           echo "<p class=card-description><code>No Records Found !</code></p>";
                        }
                      }
                    }
                  }
                }
                      
                      ?>
                    
                  </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
        </div>
        <!-- item add -->
        <?php

                include 'includes/connect.php';
                //to add data
                if (isset ($_POST['addM'])){
                
                    $item_name = $_POST["item_name"];
                    $process_name = $_POST['process_name'];

                    $sql = "INSERT INTO item (item_name,process_name) VALUES ('$item_name','$process_name')";
                    $result = sqlsrv_query($con,$sql) or die('Database connection error');
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
                <div class="modal fade" id="AddItem" tabindex="-1" aria-labelledby="AddItemLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Item</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" action="" method="post">
                          <input type="hidden" name="process_name" value="<?php echo $process_name ?>" />
                            <div class="form-group">
                              <label >Item Name</label>
                              <input type="text" name="item_name" class="form-control">
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="addM" class="btn btn-primary">Submit</button>
                          </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End of item add -->
                <!-- Material add -->
                <?php

                include 'includes/connect.php';
                //to add data
                if (isset ($_POST['add'])){
                
                    $material_type = $_POST["material_type"];
                    $material_part = $_POST["material_part"];
                    $process_name = $_POST['process_name'];

                    $sql = "INSERT INTO material (material_type,material_part,process_name) VALUES ('$material_type','$material_part','$process_name')";
                    $result = sqlsrv_query($con,$sql) or die('Database connection error');
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
                <div class="modal fade" id="AddMaterial" tabindex="-1" aria-labelledby="AddMaterialLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Material</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" action="" method="post">
                          <input type="hidden" name="process_name" value="<?php echo $process_name ?>" />
                            <div class="form-group">
                              <label >Type</label>
                              <input type="text" name="material_type" class="form-control">
                            </div>
                            <div class="form-group">
                              <label >Part</label>
                              <input type="text" name="material_part" class="form-control">
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="add" class="btn btn-primary">Submit</button>
                          </div>
                          </form>
                      </div>
                      
                    </div>
                  </div>
                </div>
                <!-- End of material add -->
                <?php

                include 'includes/connect.php';
                //to add data
                if (isset ($_POST['addmc'])){
                
                    $mc_name = $_POST["mc_name"];
                    $process_name = $_POST["process_name"];

                    $sql = "INSERT INTO machine (mc_name,process_name) VALUES ('$mc_name','$process_name')";
                    $result = sqlsrv_query($con,$sql) or die('Database connection error');
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
                <div class="modal fade" id="AddMachine" tabindex="-1" aria-labelledby="AddMachineLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Machine</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" action="" method="post">
                            <div class="form-group">
                              <label >Machine Name</label>
                              <input type="hidden" name="process_name" value="<?php echo $process_name ?>" />
                              <input type="text" name="mc_name" class="form-control">
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="addmc" class="btn btn-primary">Submit</button>
                          </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- To add package data -->
                <?php

                include 'includes/connect.php';
                //to add data
                if (isset ($_POST['addp'])){
                
                    $pack_name = $_POST["pack_name"];
                    $process_name = $_POST["process_name"];

                    $sql = "INSERT INTO package (pack_name,process_name) VALUES ('$pack_name','$process_name')";
                    $result = sqlsrv_query($con,$sql) or die('Database connection error');
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
                <div class="modal fade" id="AddPackage" tabindex="-1" aria-labelledby="AddPackageLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Package</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" action="" method="post">
                            <div class="form-group">
                              <label >Package</label>
                              <input type="hidden" name="process_name" value="<?php echo $process_name ?>" />
                              <input type="text" name="pack_name" class="form-control">
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="addp" class="btn btn-primary">Submit</button>
                          </div>
                          </form>
                      </div>
                      
                    </div>
                  </div>
                </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2023. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/jquery.cookie.js" type="text/javascript"></script>
  <script src="js/dashboard.js"></script>
  <script src="js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

