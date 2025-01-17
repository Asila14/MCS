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
      <?php
        //to retrived data
        if (isset($_GET['spec_id']) && isset($_GET['measure_id']) && isset($_GET['item_id']) && isset($_GET['id'])){
            $measure_id = $_GET['measure_id'];
            $spec_id = $_GET['spec_id'];
            $item_id = $_GET['item_id'];
            $id = $_GET['id'];
        }
        
        include 'includes/connect.php';
        
        $query = "SELECT * FROM measurement inner join process ON measurement.process_id=process.process_id inner join package ON measurement.pack_id=package.pack_id inner join machine ON measurement.mc_id=machine.mc_id inner join material ON measurement.material_id=material.material_id inner join customer ON measurement.cust_id=customer.cust_id  inner join partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id = $measure_id AND partnumber.id= $id AND item.item_id=$item_id";
      $result = sqlsrv_query($con,$query) or die('Database connection eror');
      $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
      ?>
      <div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Please Select to Input Data</h4>
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
                    <b>Notes:</b> You only have <b><?php echo $row['spec_correction']; ?> </b>attempts to complete this task.
                    <br><b>Nota:</b> Anda hanya mempunyai <b><?php echo $row['spec_correction']; ?> </b> percubaan untuk menyelesaikan tugas ini.
                  </div>
                </div>
                  <div class="table-responsive">
                    <table class="table align-middle">
                      <thead>
                      <tr>
                        <th class='text-center mt-3'>#</th>
                        <th class='text-center mt-3'>Status</th>
                        <th class='text-center mt-3'>Attempt</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $spec_correction = $row['spec_correction'];

                      for ($b = 1; $b <= $spec_correction; $b++) {
                        ?>
                        <tr>
                          <td class='text-center mt-3'><?php echo $b; ?></td>
                        <?php

                        $sql_cekD = "SELECT * FROM spec_data WHERE measure_id = $measure_id AND id = $id AND item_id=$item_id AND attempt= $b";
                        $result_cekD = sqlsrv_query($con, $sql_cekD) or die('Database connection error');
                        $row_checkD = sqlsrv_fetch_array($result_cekD, SQLSRV_FETCH_ASSOC);

                        if ($row_checkD == null) {
                          echo "<td class='text-center mt-3'><label class='badge bg-secondary'>No Data</label></td>";
                        } else {
                          echo "<td class='text-center mt-3'><label class='badge bg-primary'> Data In</label></td>";
                        }
                        ?>

                        <td class='text-center mt-3'>
                          <button href="measure_form.php" class="btn btn-outline-primary btn-icon-text" type="button" name="attempt<?php echo $b; ?>" onclick="window.location.href = 'measure_form.php?attempt=<?php echo $b; ?>&measure_id=<?php echo $row['measure_id']; ?>&spec_id=<?php echo $row['spec_id']; ?>&item_id=<?php echo $row['item_id']; ?>&id=<?php echo $row['id']; ?>';"><i class="ti-file btn-icon-prepend"> Attempt <?php echo $b; ?> </i>
                          </button>
                        </td>
                      </tr>
                        <?php
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

