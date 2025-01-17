<?php

include 'includes/connect.php';

if (isset($_GET['spec_id']) && isset($_GET['measure_id']) && isset($_GET['item_id']) && isset($_GET['id'])){
      $measure_id = $_GET['measure_id'];
      $spec_id = $_GET['spec_id'];
      $item_id = $_GET['item_id'];
      $id = $_GET['id'];
  
$query = "SELECT * FROM measurement 
            INNER JOIN specification ON measurement.id = specification.id
            INNER JOIN process ON measurement.process_id = process.process_id
            INNER JOIN package ON measurement.pack_id = package.pack_id
            INNER JOIN machine ON measurement.mc_id = machine.mc_id
            INNER JOIN material ON measurement.material_id = material.material_id
            INNER JOIN customer ON measurement.cust_id = customer.cust_id
            INNER JOIN partnumber ON measurement.id = partnumber.id
            INNER JOIN item ON specification.item_id = item.item_id WHERE spec_id = '$spec_id' ";
$result = sqlsrv_query($con,$query) or die('Database connection eror');
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

$sql_chart = "SELECT * FROM spec_result INNER JOIN measurement ON spec_result.measure_id=measurement.measure_id INNER JOIN partnumber ON spec_result.id=partnumber.id WHERE item_id='$item_id' AND partnumber.id='$id' AND measurement.measure_datetime >= datefromparts(year(getdate()), month(getdate()), 1) ORDER BY measurement.measure_datetime ASC";
$result_chart = sqlsrv_query($con,$sql_chart);

if($result_chart > 0){
 $result_avg = array();
 $result_range = array();
 $measure_lot = array();
 $spec_lsl = array();
 $spec_usl = array();
 $spec_rucl = array();
 $spec_csl = array();

  while($row_chart = sqlsrv_fetch_array($result_chart,SQLSRV_FETCH_ASSOC)){
      $result_avg[] = $row_chart["result_avg"];
      $result_range[] = $row_chart["result_range"];
      $measure_lot[] = $row_chart["measure_lot"];
      $spec_lsl[] = $row["spec_lsl"];
      $spec_usl[] = $row["spec_usl"];
      $spec_csl[] = $row["spec_csl"];
      $spec_rucl[] = $row["spec_rucl"];
    }
  }
}
?>

<div class="col-lg-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">X Trend Chart</h4>
      <p style="align:center;"><canvas id="myChartX"></canvas></p>
      
      <script src="graf.js"></script>
      <script>
        // Setup block
        const dataValue = <?php echo json_encode($result_avg); ?>;
        const dataLSL = <?php echo json_encode($spec_lsl); ?>;
        const dataUSL = <?php echo json_encode($spec_usl); ?>;
        const dataCSL = <?php echo json_encode($spec_csl); ?>;
        const labels = <?php echo json_encode($measure_lot); ?>;
        const data = {
          labels: labels,
          datasets: [{
             label: 'Average',
             backgroundColor: 'rgb(135, 206, 250)',
             borderColor: 'rgb(135, 206, 250)',
             data: dataValue,
             fill:false,
          },{
            label: 'USL',
            backgroundColor: 'rgb(239, 95, 67)',
            borderColor: 'rgb(239, 95, 67)',
            pointStyle: false,
            borderDash: [5, 5],
            data: dataUSL,
            fill:false,
          },
          {
            label: 'CSL',
            backgroundColor: 'rgb(239, 95, 67)',
            borderColor: 'rgb(239, 95, 67)',
            pointStyle: false,
            data: dataCSL,
            fill:false,
          },
          {
            label: 'LSL',
            backgroundColor: 'rgb(239, 95, 67)',
            borderColor: 'rgb(239, 95, 67)',
            pointStyle: false,
            borderDash: [5, 5],
            data: dataLSL,
            fill:false,
          }]
        };
        //config block
        const config = {
          type: 'line',
          data: data,
          options: {
          plugins:{
            legend: {
              display: false
            }
          }
        }
      };
        //render block
        var myChartX = new Chart (
          document.getElementById('myChartX'),
          config
          );
      </script>
    </div>
  </div>
</div>
<div class="col-lg-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">R Trend Chart</h4>
      <p style="align:center;"><canvas id="myChartR"></canvas></canvas></p>
      <script src="graf.js"></script>
      <script>
        // Setup block
        const dataValueR =<?php echo json_encode($result_range);?>;
        const labelsR = <?php echo json_encode($measure_lot); ?>;
        const dataRUSL = <?php echo json_encode($spec_rucl); ?>;
        const dataR = {
          labels: labelsR,
          datasets: [{
             label: 'Range',
            backgroundColor: 'rgb(178, 37, 150)',
            borderColor: 'rgb(178, 37, 150)',
            data: dataValueR,
            fill:false,
          },{
            label: 'USL',
            backgroundColor: 'rgb(239, 95, 67)',
            borderColor: 'rgb(239, 95, 67)',
            pointStyle: false,
            borderDash: [5, 5],
            data: dataRUSL,
            fill:false,
          }]
        };
        //configR block
        const configR = {
          type: 'line',
          data: dataR,
          options: {
          plugins:{
            legend: {
              display: false
            }
          }
        }
      };

        //render block
        var myChartR = new Chart (
          document.getElementById('myChartR'),
          configR
          );

      </script>
    </div>
  </div>
</div>