            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
      <?php
      include 'includes/connect.php';

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chart'])) {
          // Retrieve user inputs
          $part_id = $_POST['part_id'];
          $item_id = $_POST['item_id'];
          $date_from = $_POST['x'];
          $date_to = $_POST['y'];
          $measure_id_from = $_POST['measure_id_from'];
          $measure_id_to = $_POST['measure_id_to'];
          $mc_id = $_POST['mc_id'];

          // Define the base query
          $query = "SELECT * FROM spec_result
          INNER JOIN measurement ON spec_result.measure_id = measurement.measure_id
          INNER JOIN process ON process.process_id = measurement.process_id
          INNER JOIN partnumber ON partnumber.id = spec_result.id
          INNER JOIN item ON spec_result.item_id = item.item_id  -- Corrected join condition here
          INNER JOIN machine ON measurement.mc_id = machine.mc_id
          INNER JOIN material ON measurement.material_id = material.material_id WHERE 1=1";

          // Add conditions based on user inputs
          if ($part_id !== '') {
              $query .= " AND partnumber.id = '$part_id'";
          }

          if ($item_id !== '') {
              $query .= " AND item.item_id = '$item_id'";
          }

          if ($measure_id_from !== '' && $measure_id_to !== '') {
              $query .= " AND measurement.measure_id BETWEEN '$measure_id_from' AND '$measure_id_to'";
          }

          if ($mc_id !== '') {
              $query .= " AND machine.mc_id = '$mc_id'";
          }

          if ($date_from !== '') {
              $query .= " AND measurement.measure_datetime >= '$date_from'";
          }

          if ($date_to !== '') {
              $query .= " AND measurement.measure_datetime <= '$date_to'";
          }

          // Add ORDER BY clause to sort by pn_no and measure_lot
          $query .= " ORDER BY measurement.measure_lot ASC";

          // Execute the query
      $result = sqlsrv_query($con, $query);

      // Check for query execution success
      if ($result === false) {
          die(print_r(sqlsrv_errors(), true));
      }

      // Initialize arrays
      $result_avg = [];
      $result_range = [];
      $measure_lot = [];
      $spec_xlcl = [];
      $spec_xucl = [];
      $spec_xcl = [];
      $spec_rucl = [];
      $result_max = [];
      $result_min = [];

      // Check if there are rows in the result set
      if (sqlsrv_has_rows($result) === false) {
          echo "<tr>";
          echo "<th class='text-center mt-3 text-danger' colspan='24'>No Records Found...</th>";
          echo "</tr>";
      } else {
          // Iterate through the results and store data in arrays
          while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
              $result_max[] = $row["result_max"];
              $result_min[] = $row["result_min"];
              $result_avg[] = $row["result_avg"];
              $result_range[] = $row["result_range"];
              $measure_lot[] = $row["measure_lot"];
              $spec_xlcl[] = $row["spec_xlcl"];
              $spec_xucl[] = $row["spec_xucl"];
              $spec_xcl[] = $row["spec_xcl"];
              $spec_rucl[] = $row["spec_rucl"];
          }
      }
      }


      ?>
          
          <div class="col-12 grid-margin stretch-card">
        <div class="card card-rounded">
          <div class="card-body">
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
          <div class="alert alert-warning d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
              <b>Note:</b> This graph function only allows users to view <b>(1) one</b> item at a time.
              <br><b>Nota:</b> Fungsi graf ini hanya membenarkan pengguna untuk melihat <b>(1) satu</b> item pada satu masa.
            </div>
          </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="mt-3">
                  <div class="row">

<div class="row flex-grow">
  <div class="col-12 grid-margin stretch-card">
    <div class="card card-rounded">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div>
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Chart Type </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                    <h6 class="dropdown-header">Select Chart Type</h6>
                    <a class="dropdown-item" href="#" onclick="showBarChart()">X-Bar & R Chart</a>
                    <a class="dropdown-item" href="#" onclick="showHiLoChart()">Hi-Lo Chart</a>
                  </div>
                </div>
              </div>
            </div>
            <div id="barchart" class="mt-3" style="display: none;">
              <div class="row">
                <div class="col-md-6">
                  <h4 class="card-title card-title-dash">X-bar Chart</h4>
                  <p style="align:center;"><canvas id="myChartX"></canvas></p>
                </div>
                <div class="col-md-6">
                  <h4 class="card-title card-title-dash">R Trend Chart</h4>
                  <p style="align:center;"><canvas id="myChartR"></canvas></p>
                </div>
              </div>
            </div>
            <div id="hilo" class="mt-3" style="display: none;">
              <div class="row">
                <div class="col-md-6">
                  <h4 class="card-title card-title-dash">Hi-Lo Chart</h4>
                  <p style="align:center;"><canvas id="hiLoChart"></canvas></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group row">
    <p style="align:center;"></p>
    <script src="graf.js"></script>
    <script>
      // Setup block
      const dataValue = <?php echo json_encode($result_avg); ?>;
      const dataLSL = <?php echo json_encode($spec_xlcl); ?>;
      const dataUSL = <?php echo json_encode($spec_xucl); ?>;
      const dataCSL = <?php echo json_encode($spec_xcl); ?>;
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
<div class="col-md-6">
<div class="form-group row">
    <p style="align:center;"></p>
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
<div class="col-md-12">
    <div class="form-group row">
        <p style="text-align: center;"></p>
        <script src="graf.js"></script>
        <script>
            // Retrieve data from your PHP code
            const dataHigh = <?php echo json_encode($result_max); ?>;
            const dataLow = <?php echo json_encode($result_min); ?>;
            const dataAvg = <?php echo json_encode($result_avg); ?>;
            const LSLH = <?php echo json_encode($spec_xlcl); ?>;
            const USLH = <?php echo json_encode($spec_xucl); ?>;
            const CSLH = <?php echo json_encode($spec_xcl); ?>;
            const labelsH = <?php echo json_encode($measure_lot); ?>;
            
            // Create your chart using the retrieved data
            const dataH = labelsH.map((labelH, index) => ({
                x: labelH,
                y: {
                    high: dataHigh[index],
                    average: dataAvg[index],
                    low: dataLow[index],
                },
            }));
            
            const ctx = document.getElementById('hiLoChart').getContext('2d');
            
            new Chart(ctx, {
    type: 'scatter',
    data: {
        datasets: [
            {
                label: 'High',
                data: dataH.map(item => ({ x: item.x, y: item.y.high })),
                borderColor: 'rgba(255, 123, 27, 1)',
                backgroundColor: 'rgba(255, 123, 27, 1)',
                pointRadius: 4,
                pointStyle: 'rectRounded',
            },
            {
                label: 'Average',
                data: dataH.map(item => ({ x: item.x, y: item.y.average })),
                borderColor: 'rgba(0, 123, 255, 1)',
                backgroundColor: 'rgba(0, 123, 255, 1)',
                pointRadius: 4,
                pointStyle: 'triangle',
            },
            {
                label: 'Low',
                data: dataH.map(item => ({ x: item.x, y: item.y.low })),
                borderColor: 'rgba(169, 169, 169, 1)', // Grey border color
                backgroundColor: 'rgba(192, 192, 192, 1)', // Grey background color
                pointRadius: 4,
                pointStyle: 'rectRounded', // You can change the point style to 'circle' or any other supported shape
            },
            {
                label: 'USLH',
                data: USLH,
                borderColor: 'rgb(239, 95, 67)',
                borderWidth: 2,
                fill: false, // Use '-1' to fill the area under the line
                pointRadius: 0, // Set pointRadius to 0 to hide data points
                borderDash: [5, 5], // Add a dashed line for USL
                type: 'line', // Set the type to 'line'
            },
            {
                label: 'CSLH',
                data: CSLH,
                borderColor: 'rgb(239, 95, 67)',
                borderWidth: 2,
                fill: false, // Use '-1' to fill the area under the line
                pointRadius: 0, // Set pointRadius to 0 to hide data points
                type: 'line', // Set the type to 'line'
            },
            {
                label: 'LSLH',
                data: LSLH,
                borderColor: 'rgb(239, 95, 67)',
                borderWidth: 2,
                fill: false, // Use '-1' to fill the area under the line
                pointRadius: 0, // Set pointRadius to 0 to hide data points
                borderDash: [5, 5], // Add a dashed line for LSL
                type: 'line', // Set the type to 'line'
            },
        ],
    },
    options: {
        scales: {
            x: {
                position: 'bottom',
                beginAtZero: false,
                type: 'category',
            },
            y: {
                beginAtZero: false,
            },
        },
        plugins: {
            legend: {
                display: false, // Hide the legend
            },
        },
    },
});
        </script>
    </div>
</div>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

</div>
</div>
</div>
</div>
<script>
function showBarChart() {
    document.getElementById('barchart').style.display = 'block';
    document.getElementById('hilo').style.display = 'none';
}

function showHiLoChart() {
    document.getElementById('barchart').style.display = 'none';
    document.getElementById('hilo').style.display = 'block';
}
</script>

