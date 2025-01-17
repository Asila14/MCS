<?php

  include 'includes/connect.php';

  $sql_chart = "SELECT * FROM spec_result";
  $result_chart = sqlsrv_query($con,$sql_chart);
  if(sqlsrv_num_rows($result_chart) > 0){
    $result_range = array();
    while($row_chart = sqlsrv_fetch_array($result_chart,SQLSRV_FETCH_ASSOC)){
      $result_range[] = $row_chart["result_range"];
    }
  }else{
    echo "No records match...";
  }

?>
<div class="col-lg-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">R Trend Chart</h4>
      <p style="align:center;"><canvas id="myChartR"></canvas></canvas></p>
      <script src="garf.js"></script>
      <script>
        // Setup block

        const dataValueR = [65, 59, 80, 81, 56, 55, 40];
        const labelsR = ['January','February','March','April','May','June'];
        const dataR = {
          labels: labelsR,
          datasets: [{
             label: 'Average',
            backgroundColor: 'rgb(255,99,132)',
            borderColor: 'rgb(75, 192, 192)',
            data: dataValueR,
            fill:false,
          },{
            label: 'My Second Dataset',
            backgroundColor: 'rgb(255,255,0)',
            borderColor: 'rgb(75, 255, 0)',
            data: [80, 45, 67, 88, 45, 76, 70],
            fill:false,
          }]
        };
        //configR block
        const configR = {
          type: 'line',
          data: dataR,
          options: {
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
