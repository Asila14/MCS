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
      include 'includes/admin_sidebar.php';
      ?>
      <!-- partial -->
      <?php
       //to retrived data
          if (isset($_GET['measure_id']) && isset($_GET['id'])){ 
            $measure_id = $_GET['measure_id'];
           $id = $_GET['id'];
         }
          else{
            $measure_id = 0;
           $id = 0;
          }
          include 'includes/connect.php';
          $query = "SELECT * FROM measurement inner join process ON measurement.process_id=process.process_id inner join package ON measurement.pack_id=package.pack_id inner join machine ON measurement.mc_id=machine.mc_id inner join material ON measurement.material_id=material.material_id inner join customer ON measurement.cust_id=customer.cust_id  inner join partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id = $measure_id AND partnumber.id=$id";
          $result = sqlsrv_query($con,$query) or die('Database connection eror');
          $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        ?>
        <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Lot Information</h4>
                  <form class="forms-sample" action="" method="post">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Part No</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="pn_no" value="<?php echo $row['pn_no'] ?>" readonly/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Package Size</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="pack_name" value="<?php echo $row['pack_name'] ?>" readonly/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Lot No</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="measure_lot" value="<?php echo $row['measure_lot'] ?>" readonly/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Customer</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="cust_name" value="<?php echo $row['cust_name'] ?>" readonly/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Emp#</label>
                          <div class="col-sm-9">
                            <input class="form-control" name="measure_emp" value="<?php if (!empty($row)) { echo $row['measure_emp']; } else { echo "Data is empty."; } ?>" readonly/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Machine#</label>
                          <div class="col-sm-9">
                            <input class="form-control" name="mc_name" value="<?php if (!empty($row)) { echo $row['mc_name']; } else { echo "The value of row is empty."; } ?>" readonly/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Material</label>
                          <div class="col-sm-9">
                            <input class="form-control" name="material_part" value="<?php if (!empty($row)) { echo $row['material_part']; } else { echo "The value of row is empty."; } ?>" readonly/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Material Lot</label>
                          <div class="col-sm-9">
                            <input class="form-control" name="measure_mate_lot" value="<?php if (!empty($row)) { echo $row['measure_mate_lot']; } else { echo "The value of row is empty."; } ?>" readonly/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <form action="" method="POST">
                  <div class="card-body">
                  <h4 class="card-title">List Of Measurement Item</h4>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                          <tr class="table-light">
                            <!-- <th class='text-center mt-3'>View</th> -->
                            <th class='text-center mt-3'>Action</th>
                            <th class='text-center mt-3'>Item</th>
                            <th class='text-center mt-3'>Judgement</th>
                          </tr>
                        </thead>
                        <tbody class="table table-sm">
                        <?php
                        include 'includes/connect.php';

                        $sqls = "SELECT * FROM measurement inner join process ON measurement.process_id=process.process_id inner join package ON measurement.pack_id=package.pack_id inner join machine ON measurement.mc_id=machine.mc_id inner join material ON measurement.material_id=material.material_id inner join customer ON measurement.cust_id=customer.cust_id  inner join partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id = $measure_id AND partnumber.id= $id ";
                        $results = sqlsrv_query($con,$sqls) or die('Database connection error');
                        while ($rows = sqlsrv_fetch_array($results,SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td class='text-center mt-3'><a class=btn btn-primary href=admin_measure_manage1.php?id=".$rows['id']."&item_id=".$rows['item_id']."&spec_id=".$row['spec_id']."&measure_id=".$rows['measure_id']."><i class=ti-pencil></i></a></td>";
                        echo "<td class='text-center mt-3'>".$rows['item_name']."</td>";

                        $item_id = $rows['item_id'];
                        $sqlcek="SELECT * FROM spec_result WHERE measure_id = '$measure_id' AND item_id = '$item_id' AND result_datetime = (SELECT MAX(result_datetime)FROM spec_result WHERE measure_id = '$measure_id' AND item_id = '$item_id')";
                        $result_cek = sqlsrv_query($con,$sqlcek) or die('Database connection error');
                        $row_check = sqlsrv_fetch_array($result_cek,SQLSRV_FETCH_ASSOC);

                        if ($row_check == null) {
                          echo "<td class='text-center mt-3'><label class='badge bg-warning'>No Data</label></td>";
                        } else if ($row_check['result_judgement'] == 'pass') {
                          echo "<td class='text-center mt-3'><label class='badge bg-success'>Pass</label></td>";
                        } else {
                          echo "<td class='text-center mt-3'><label class='badge bg-danger'>Failed</label></td>";
                        }
                        echo "</tr>";

                        }?>
                        </tbody>
                      </head>
                    </table>
                    <div class="form-group" >
                      <input type="hidden" name="cl_status" value="complete" />
                      <?php
                      date_default_timezone_set('Asia/Kuala_Lumpur');
                      $cl_date = date("Y-m-d H:i:s");
                      ?>
                      <?php

                         $sqls3 = "SELECT * FROM measurement INNER JOIN process ON measurement.process_id = process.process_id INNER JOIN package ON measurement.pack_id = package.pack_id INNER JOIN machine ON measurement.mc_id = machine.mc_id INNER JOIN material ON measurement.material_id = material.material_id INNER JOIN customer ON measurement.cust_id = customer.cust_id INNER JOIN partnumber ON measurement.id = partnumber.id INNER JOIN specification ON partnumber.id = specification.id INNER JOIN item ON specification.item_id = item.item_id WHERE measure_id = $measure_id AND partnumber.id = $id";
                        $results3 = sqlsrv_query($con, $sqls3) or die('Database connection error');
                        $rows3 = sqlsrv_fetch_array($results3, SQLSRV_FETCH_ASSOC);

                        // untuk baca semua item_id untuk setiap measure_id sama ada dah complete ada dalam spec_result ka belum
                        if ($rows3) {
                            $item_ids = array(); // Create an array to store item IDs

                            do {
                                $item_id = $rows3['item_id'];
                                $item_ids[] = $item_id; // Add the item ID to the array
                            } while ($rows3 = sqlsrv_fetch_array($results3, SQLSRV_FETCH_ASSOC));

                            $allItemIDsExist = true;

                            // Check if all item IDs exist in spec_result
                            foreach ($item_ids as $item_id) {
                                $sqlcek3 = "SELECT * FROM spec_result WHERE measure_id = '$measure_id' AND id = '$id' AND item_id = '$item_id'";
                                $result_cek3 = sqlsrv_query($con, $sqlcek3) or die('Database connection error');
                                $row_check3 = sqlsrv_fetch_array($result_cek3, SQLSRV_FETCH_ASSOC);

                                if ($row_check3 == null) {
                                    $allItemIDsExist = false;
                                    break; // If any item ID is missing, break the loop
                                }
                            }

                            if ($allItemIDsExist) {
                                ?><br>
                                          <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                          <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                          </symbol>
                                          <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                          </symbol>
                                          <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                          </symbol>
                                        </svg>
                                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                                          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                          <div>
                                            <b>Notes:</b> Please click "Confirm" if all judgments have been completed.
                                            <br><b>Nota:</b> Sila Klik "Confirm" jika semua telah selesai diisi.
                                          </div>
                                        </div>
                                    <?php

                              // Check data 
                              $sqlcek1 = "SELECT * FROM complete_lot WHERE measure_id = '$measure_id' AND id = '$id'";
                              $result_cek1 = sqlsrv_query($con, $sqlcek1) or die('Database connection error');
                              $row_check1 = sqlsrv_fetch_array($result_cek1, SQLSRV_FETCH_ASSOC);

                              if ($row_check1 == null) {
                                  echo "<input type='submit' name='confirm' class='btn btn-primary' value='Confirm' onclick='refreshPage()'>";
                              } else {
                                  include 'includes/connect.php';

                                  $sqls = "SELECT * FROM measurement inner join process ON measurement.process_id=process.process_id inner join package ON measurement.pack_id=package.pack_id inner join machine ON measurement.mc_id=machine.mc_id inner join material ON measurement.material_id=material.material_id inner join customer ON measurement.cust_id=customer.cust_id  inner join partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id = $measure_id AND partnumber.id= $id ";
                                  $results = sqlsrv_query($con, $sqls) or die('Database connection error');
                                  $rows = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);

                                  echo "<td class='text-center mt-3'><a class='btn btn-warning' href=CSV_TEST.php?id=" . $rows['id'] . "&measure_id=" . $rows['measure_id'] . ">Export <i class=ti-export></i></a></td>";
                                  echo "&nbsp;";
                                  echo "<button type='submit' name='confirm' class='btn btn-primary' disabled>Confirm</button>";
                              }
                            }
                          }
                          ?>
                    </form>
                    </div>
                  </div>
                </div>
                </form>
                <?php
                    if (isset ($_POST['confirm']) && isset($_GET['measure_id']) && isset($_GET['id'])){

                      $measure_id = $_GET['measure_id'];
                      $id = $_GET['id'];
                      date_default_timezone_set('Asia/Kuala_Lumpur');
                      $cl_date = date("Y-m-d H:i:s");
                      $cl_status = $_POST['cl_status'];
                      // The cust_name does not exist in the database, so insert the new data
                      $sql = "INSERT INTO complete_lot (cl_date , cl_status, measure_id, id) VALUES('$cl_date' , '$cl_status', '$measure_id', '$id')";
                      $result = sqlsrv_query($con,$sql);
                      if($result > 0){
                   // Use Sweetalert to show a success message
                        echo '
                          <script>
                            swal({
                              title: "Done!",
                              text: "Data has been succesfully registered.",
                              icon: "success",
                              button: "OK",
                            });
                          </script>
                        ';
                        echo "<meta http-equiv='refresh' content='0'>";
                      } else {
                        // Use Sweetalert to show an error message
                        echo '
                          <script>
                            swal({
                              title: "Failed!",
                              text: "The operation failed.",
                              icon: "error",
                              button: "OK",
                            });
                          </script>
                        ';
                }
                  }
                    ?>
              </div>
            </div>
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
