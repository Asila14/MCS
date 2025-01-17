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
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                      <div class="col-md-2">
                        <div class="form-group row">
                          <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                              <h4 class="card-title card-title-dash">Activities</h4>
                            </div>
                            <ul class="bullet-line-list">
                              <li>
                              <a href="process.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Process</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="user.php" style="text-decoration: none;">
                                <div><span class="text-light-green">User</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="machine.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Machine</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="item.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Item</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="customer.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Customer</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="package.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Package</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="material.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Material</span></div>
                              </a>
                              </li>
                              <li>
                                <a href="partno.php" style="text-decoration: none;">
                                <div><span class="text-light-green" style="font-size: 20px; color: navy;"><b>Part Number</b></span></div>
                              </a>
                              </li>
                              <li>
                                <a href="spec.php" style="text-decoration: none;">
                                <div><span class="text-light-green">Specification</span></div>
                              </a>
                              </li>
                            </ul>
                            <div class="list align-items-center pt-3">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10">
                  <h4 class="card-title">Register Part Number
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Addpartnumber">
                    <i class="ti-plus"></i></h4>
                  </button>
                  <!-- Modal -->
                <?php

                include 'includes/connect.php';
                //to add data

                if (isset ($_POST['add'])){
                
                    
                    $process_id = $_POST["process_id"];
                    $category = $_POST["category"];
                    $cust_id = $_POST["cust_id"];
                    $pack_id = $_POST["pack_id"];
                    $pn_no = $_POST["pn_no"];
                    $material_id = $_POST["material_id"];

                      $query = "INSERT INTO partnumber (category,pack_id,cust_id,process_id,pn_no,material_id) VALUES('$category','$pack_id','$cust_id','$process_id','$pn_no','$material_id')";
                      $result = sqlsrv_query($con,$query);
                      if($result > 0){
                       // Use Sweetalert to show a success message
                            echo "
                              <script src='sweetalert2.all.min.js'></script>
                                <script>
                                  Swal.fire({
                                    icon: 'success',
                                    title: 'Your work has been saved',
                                    showConfirmButton: 'false',
                                    timer: '1500'
                                  });
                              </script>";
                            } else {
                              // Use Sweetalert to show an error message
                              echo "
                              <script src='sweetalert2.all.min.js'></script>
                                <script>
                                  Swal.fire({
                                      title: 'Failed!',
                                      text: 'The operation failed.',
                                      icon: 'error',
                                      confirmButtonText: 'OK'
                                  });
                              </script>";
                                  }
                    }
                
                
                ?>
                <div class="modal fade" id="Addpartnumber" tabindex="-1" aria-labelledby="AddpartnumberLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Part No</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" action="" method="post">
                            <div class="form-group">
                              <label>Select Process</label>
                              <?php
                                    include 'includes/connect.php';
                                    $process = sqlsrv_query($con,"SELECT * FROM process ");
                              ?>
                              <input type="hidden" name="process_id" value="<?php if(isset($_POST['process_id'])){echo $_POST['process_id'];} ?>" class="form-control" />
                                  <select data-live-search="true" name="process_id" class="form-control selectpicker">
                                    <option> - Please Select - </option>
                                    <?php 
                                    if($process > 0) {
                                     while($p = sqlsrv_fetch_array($process,SQLSRV_FETCH_ASSOC)){
                                    
                                    ?>
                                      <option name="process_id" value="<?php echo $p['process_id']?> "><?php echo $p['process_name']; ?>
                                        <?php } } ?></option>
                                  </select>
                            </div>
                            <div class="form-group">
                              <label>Part No</label>
                              <input type="text" name="pn_no" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Category</label>
                                <select data-live-search="true" name="category" class="form-control selectpicker">
                                  <option> - Please Select - </option>
                                  <option value="General">General</option>
                                  <option value="Automotive">Automotive</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Select Customer</label>
                              <?php
                                    include 'includes/connect.php';
                                    $cust = sqlsrv_query($con,"SELECT * FROM customer ");
                              ?>
                              <input type="hidden" id="cust_id" name="cust_id" value="<?php if(isset($_POST['cust_id'])){echo $_POST['cust_id'];} ?>" class="form-control" />
                                  <select data-live-search="true" name="cust_id" class="form-control selectpicker">
                                    <option> - Please Select - </option>
                                    <?php 
                                    if($cust > 0) {
                                     while($c = sqlsrv_fetch_array($cust,SQLSRV_FETCH_ASSOC)){
                                    
                                    ?>
                                      <option name="cust_id" value="<?php echo $c['cust_id']?> "><?php echo $c['cust_name']; ?>
                                        <?php } } ?></option>
                                  </select>
                            </div>
                            <div class="form-group">
                              <label>Select Package</label>
                              <?php
                                    include 'includes/connect.php';
                                    $pack = sqlsrv_query($con,"SELECT * FROM package ");
                              ?>
                              <input type="hidden" id="pack_id" name="pack_id" value="<?php if(isset($_POST['pack_id'])){echo $_POST['pack_id'];} ?>" class="form-control" />
                                  <select data-live-search="true" name="pack_id" class="form-control selectpicker">
                                    <option> - Please Select - </option>
                                    <?php 
                                    if($pack > 0) {
                                     while($pk = sqlsrv_fetch_array($pack,SQLSRV_FETCH_ASSOC)){
                                    
                                    ?>
                                      <option name="pack_id" value="<?php echo $pk['pack_id']?> "><?php echo $pk['pack_name']; ?>
                                        <?php } } ?></option>
                                  </select>
                            </div>
                            <div class="form-group">
                              <label>Select Material</label>
                              <?php
                                    include 'includes/connect.php';
                                    $mate = sqlsrv_query($con,"SELECT * FROM material ");
                              ?>
                              <input type="hidden" id="material_id" name="material_id" value="<?php if(isset($_POST['material_id'])){echo $_POST['material_id'];} ?>" class="form-control" />
                                  <select data-live-search="true" name="material_id" class="form-control selectpicker">
                                    <option> - Please Select - </option>
                                    <?php 
                                    if($mate > 0) {
                                     while($pr = sqlsrv_fetch_array($mate,SQLSRV_FETCH_ASSOC)){
                                    
                                    ?>
                                      <option name="material_id" value="<?php echo $pr['material_id']?> "><?php echo $pr['material_part']; ?>
                                        <?php } } ?></option>
                                  </select>
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
                  <div class="table-responsive">
                  <?php
                  include 'includes/connect.php';

                  // Fetch records from the database with pagination
                  $sql = "SELECT * FROM partnumber inner join process ON partnumber.process_id=process.process_id  inner join customer ON partnumber.cust_id=customer.cust_id inner join package ON partnumber.pack_id=package.pack_id inner join material ON partnumber.material_id=material.material_id ORDER BY process_name ASC";
                  $result = sqlsrv_query($con, $sql) or die('Database connection error');

                  // Display the table header
                  echo "<table id='datatableid' class='table table-sm table-bordered'>";
                  echo "<thead>";
                  echo "<tr class='table-light'>";
                  echo "<th class='text-center mt-3'>Process</th>";
                  echo "<th class='text-center mt-3'>Part No</th>";
                  echo "<th class='text-center mt-3'>Category</th>";
                  echo "<th class='text-center mt-3'>Customer</th>";
                  echo "<th class='text-center mt-3'>Package</th>";
                  echo "<th class='text-center mt-3'>Material</th>";
                  echo "<th class='text-center mt-3'>Edit</th>";
                  echo "<th class='text-center mt-3'>Delete</th>";
                  echo "</tr>";
                  echo "</thead>";

                  echo "<tbody>";
                  if (sqlsrv_has_rows($result) == 0) {
                      echo "<tr>";
                      echo "<td class='text-center mt-3 text-danger' colspan='8'>No Records Found...</td>";
                      echo "</tr>";
                  } else {
                      while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                          echo "<tr>";
                          echo "<td class='text-center mt-3'>".$row['process_name']."</td>";
                          echo "<td class='text-center mt-3'>".$row['pn_no']."</td>";
                          echo "<td class='text-center mt-3'>".$row['category']."</td>";
                          echo "<td class='text-center mt-3'>".$row['cust_name']."</td>";
                          echo "<td class='text-center mt-3'>".$row['pack_name']."</td>";
                          echo "<td class='text-center mt-3'>".$row['material_part']."</td>";
                          echo "<td class='text-center mt-3'><a class=btn btn-primary href=partno_edit.php?id=".$row['id']."><i class=ti-eraser></i></a></td>";
                          echo "<td class='text-center mt-3'><a class='btn btn-delete btn_del' href=partno_del.php?id=".$row['id']."><i class=ti-trash></i></a></td>";
                          echo "</tr>";      
                    }
                  }
                  echo "</tbody>";
                  echo "</table><br>";
                  // Close the database connection
                  sqlsrv_close($con);
                  ?>
                    <div class="modal-footer">
                    <a href="spec.php" class="btn btn-primary">Next</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
  </div>
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


