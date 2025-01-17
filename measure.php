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
                  <h4 class="card-title">Daily Registered Measurement</button></h4>
                  <form action="" method="POST">
                    <h6 class="text-warning">If MEASUREMENTS DATA is not listed, please REGISTER. </h6>
                    <div class="row">
                      <div class="form-group row">
                        <div class="col-md-12">
                          <input type="text" class="form-control" id="search" name="" autocomplete="off" placeholder="Search...">
                          <div id="no-results-message" style="display: none; color: red;">Record not found...</div>
                          <br>
                        </div>
                      </div>
                </div>
              </form>

                <?php

                include 'includes/connect.php';
                //to add data
                if (isset ($_POST['add'])){
                
                    $item_name = $_POST["item_name"];

                    $sql = "INSERT INTO item (item_name,process_id) VALUES ('$item_name','$process_id')";
                    $result = sqlsrv_query($con,$sql) or die('Database connection error');
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr class="table-light">
                          <th>Process</th>
                          <th>#Emp</th>  
                          <th>Part No</th>
                          <th>Lot No</th>
                          <th>Customer</th>
                          <th>Package</th>
                          <th>Machine</th>
                          <th>Material Part</th>
                          <th>Material Lot</th>
                          <th>Date & Time Submitted</th>
                          <th>Manage</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tbody>
                          <?php 

                              date_default_timezone_set('Asia/Kuala_Lumpur');
                              $datetime = date('m/d/Y h:i:s a', time());

                              /*echo "The current server timezone is: " . $datetime;*/
                              ?>
                        <?php
                        include 'includes/connect.php';
                        $sql = "SELECT * FROM measure ORDER BY datetime DESC";
                        $result = sqlsrv_query($con,$sql) or die('Database connection error');
                        while ($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td class='text-danger'>".$row['process_name']."</td>";
                                echo "<td>".$row['empno']."</td>";
                                echo "<td>".$row['partno']."</td>";
                                echo "<td>".$row['lotno']."</td>";
                                echo "<td>".$row['cust_name']."</td>";
                                echo "<td>".$row['pack_name']."</td>";
                                echo "<td>".$row['mc_name']."</td>";
                                echo "<td>".$row['material_part']."</td>";
                                echo "<td>".$row['material_lot']."</td>";
                                echo "<td class='text-primary'>".$row['datetime']->format('d/m/Y h:i:s a')."</td>";
                                echo "<td><a class=btn btn-primary href=measure_manage.php?measure_id=".$row['measure_id']."><i class=ti-pencil></i></a></td>";
                                echo "<td><a class=btn btn-primary href=measure_del.php?measure_id=".$row['measure_id']."><i class=ti-trash></i></a></td>";
                                echo "</tr>";
                            }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script>
          // Add an event listener to the search input to listen for changes
              document.getElementById("search").addEventListener("input", function() {
            // Get the value of the search input
                const query = this.value.toLowerCase();

            // Loop through each table row and check if it matches the search query
                let visibleRows = false;
                document.querySelectorAll("tbody tr").forEach(row => {
              // Get the columns in the row
                  const columns = row.querySelectorAll("td");

              // Loop through each column and check if it contains the search query
                  let match = false;
                  columns.forEach(col => {
                    if (col.textContent.toLowerCase().includes(query)) {
                      match = true;
                    }
                  });

              // If the row matches the search query, show it. Otherwise, hide it.
                  if (match) {
                    row.style.display = "";
                    visibleRows = true;
                  } else {
                    row.style.display = "none";
                  }
                });

            // If no rows match the search query, display a message
                const message = document.getElementById("no-results-message");
                if (!visibleRows) {
                  message.style.display = "";
                } else {
                  message.style.display = "none";
                }
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

