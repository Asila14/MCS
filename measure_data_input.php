<?php
if (isset($_GET['spec_id']))
      $spec_id = $_GET['spec_id'];
  else
      $spec_id = 0;
  
  include 'includes/connect.php';
  
  $query = "SELECT * FROM measurement 
            INNER JOIN specification ON measurement.id = specification.id
            INNER JOIN process ON measurement.process_id = process.process_id
            INNER JOIN package ON measurement.pack_id = package.pack_id
            INNER JOIN machine ON measurement.mc_id = machine.mc_id
            INNER JOIN material ON measurement.material_id = material.material_id
            INNER JOIN customer ON measurement.cust_id = customer.cust_id
            INNER JOIN partnumber ON measurement.id = partnumber.id
            INNER JOIN item ON specification.item_id = item.item_id
            WHERE specification.spec_id = $spec_id";

  $query1 = "SELECT * FROM measurement ";
  $result1 = sqlsrv_query($con,$query1);
  $row1_ = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC);

  $result = sqlsrv_query($con,$query) or die('Database connection eror');
  $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

include 'includes/connect.php';
if (isset($_POST['ins']) && isset($_POST['measure_id'])) {
$measure_id = $row1_["measure_id"];
$spec_id = $row["spec_id"];
$item_id = $row["item_id"];
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

$sql_data = "INSERT INTO spec_data (data,spec_id,measure_id,status_judge,data_result,item_id) VALUES ('$data','$spec_id','$measure_id','$status_judge','$data_result','$item_id')";
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
<div class="col-md-4 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Measurement Item: <?php echo $row['item_name'] ?></h4>
      <!-- <p class="card-description">
        Please input your data correctly.
      </p> -->
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
                    <input type='number' name=".$i.$d.'data'." step='0.001' class='form-control' autocomplete='off' placeholder='Input data' required>
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
      <input type="hidden" name="spec_id" value="<?php echo $row['spec_id']; ?>" />
      <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>" />
      <a href="measure_add.php?measure_id=<?php echo $row['measure_id']; ?>" class="btn btn-secondary">Back</a>
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