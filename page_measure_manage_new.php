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
  <script src="jquery-3.6.0.min.js"></script>
  <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
  <script src="sweetalert.js"></script>
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
       <?php

                //to retrived data
                        if (isset($_GET['measure_id']))
                            $measure_id = $_GET['measure_id'];
                        else
                            $measure_id = 0;
                        
                        include 'includes/connect.php';
                        
                        $query = "SELECT * FROM measurement inner join process ON measurement.process_id=process.process_id inner join package ON measurement.pack_id=package.pack_id inner join machine ON measurement.mc_id=machine.mc_id inner join material ON measurement.material_id=material.material_id inner join customer ON measurement.cust_id=customer.cust_id  inner join partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id = $measure_id";
                        $result = sqlsrv_query($con,$query) or die('Database connection eror');
                        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

        ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Measurement Item</h4>
                    <form action="" method="POST"> 
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr class="table-light">
                            <th class='text-center mt-3'>Action</th>
                            <th class='text-center mt-3'>Item</th>
                            <th class='text-center mt-3'>Judgement</th>
                          </tr>
                        </thead>
                        <tbody class="table table-sm">
                          <?php
                          $sqls = "SELECT * FROM measurement INNER JOIN partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id = '$measure_id' ";
                          $results = sqlsrv_query($con,$sqls) or die('Database connection error');
                          while ($rows = sqlsrv_fetch_array($results,SQLSRV_FETCH_ASSOC)) {
                                  echo "<tr style=height:40px>";
                                  echo "<td class='text-center mt-3'><a class=btn btn-primary  data-bs-toggle=modal data-bs-target=#AddData href=measure_manage.php?spec_id=".$rows['spec_id']."><i class=ti-pencil></i></a></td>";
                                  echo "<td class='text-center mt-3'>".$rows['item_name']."</td>";
                                  if($rows['measure_judge'] =='in')
                                  {
                                    
                                    echo "<td class='text-center mt-3'><label class='badge badge-success'>Pass</label></td>";
                                  }
                                  else{
                                    
                                    echo "<td class='text-center mt-3'><label class='badge badge-danger'>No Data</label></td>";
                                  }
                              }
                          ?>
                        </tbody>
                      </table>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
                <?php
                 if (isset($_GET['spec_id']))
                    $spec_id = $_GET['spec_id'];
                else
                    $spec_id = 0;
                
                include 'includes/connect.php';
                
                $query = "SELECT * FROM measurement inner join specification on measurement.id=specification.id inner join process ON measurement.process_id=process.process_id inner join package ON measurement.pack_id=package.pack_id inner join machine ON measurement.mc_id=machine.mc_id inner join material ON measurement.material_id=material.material_id inner join customer ON measurement.cust_id=customer.cust_id  inner join partnumber ON measurement.id=partnumber.id inner join item ON specification.item_id=item.item_id WHERE spec_id = $spec_id";
                $result = sqlsrv_query($con,$query) or die('Database connection eror');

                if($result > 0){ ?>
                  <div class="modal fade" id="AddData" tabindex="-1" aria-labelledby="AddDataLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Measurement Item: <?php echo $row['item_name'] ?></h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                      <div class="modal-body">
                        <form action="" method="POST" onsubmit="numberValidation()"> 
                    <div class="table-responsive">
                      <p class="text-success">
                        <b>LSL:</b> <?php echo $row['spec_lsl'] ?>
                        <br>
                        <b>USL:</b> <?php echo $row['spec_usl'] ?>
                      </p>
                      <table class="table table-bordered">
                        <thead>
                          <tr class="table-light">
                            <th class='text-center mt-3'>Spl#</th>
                            <?php
                            for ($e=1; $e<=$row['spec_data_spl']; $e++){
                                echo "<th>Point ".$e."</th>";
                              }
                              ?>
                          </tr>
                        </thead>
                        <tbody class="table table-sm">
                          <?php

                          $count = 1;

                          for( $i=1; $i<=$row['spec_spl_point']; $i++ )
                            {
                              echo "<tr>";
                              echo "<td  class='text-center mt-3'>".$count."</td>";
                              if ($row['spec_data_spl'] > 0) {
                                for ($d=1; $d<=$row['spec_data_spl']; $d++){
                                  echo "<td  class='text-center mt-3'>
                                      <input type='number' name=".$i.$d.'data'." step='0.01' min=".$row['spec_lsl']." max=".$row['spec_usl']." class='form-control' autocomplete='off' placeholder='Input data' required>
                                  </td>";
                                }
                              }
                              ?>
                                <?php
                              $count++;
                            }
                          ?>
                        </tbody>
                      </table>
                      <br>
                      <div class="form-group">
                        <input type="hidden" name="status_judge" value="in" />
                        <input type="hidden" name="measure_id" value="<?php echo $row['measure_id']; ?>" />
                        <button type="submit" name="ins" class="btn btn-primary">Statistic</button>
                      </div>
                      
                      <script>
                        document.querySelector('input').addEventListener('input', e=>{
                          const el = e.target || e
                          if(el.type == "number" && el.max && el.min ){
                            let value = parseInt(el.value)
                            el.value = value // for 000 like input cleanup to 0
                            let max = parseInt(el.max)
                            let min = parseInt(el.min)
                            if ( value >= max ) el.value = el.max
                              if ( value <= min ) el.value = el.min
                            }
                        });
                      </script>
                      </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                <?php
                }
              ?>
              </div>
            </div>
          </div>
          <?php
      include 'includes/connect.php';

      if (isset($_POST['ins']) && isset($_POST['measure_id'])) {
        $measure_id = $_POST["measure_id"];
        $spec_id = $_POST["spec_id"];
        $status_judge = $_POST['status_judge'];

        $count = 1;

        for ($i=1; $i <= $row['spec_spl_point']; $i++) { 
          for ($d=1; $d<=$row['spec_data_spl']; $d++){
            $data = $_POST[$i.$d."data"];
            if($data <=$row['spec_usl'] && $data >=$row['spec_lsl'])
            {
              $data_result = 'O';
            }
            else
            {
              $data_result = 'X';
            }

            $sql_data = "INSERT INTO spec_data (data,spec_id,measure_id,status_judge,data_result) VALUES ('$data','$spec_id','$measure_id','$status_judge','$data_result')";
            $result_sql_data = sqlsrv_query ($con,$sql_data);
            if($result_sql_data > 0){
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
          }
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
