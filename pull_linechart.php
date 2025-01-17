<?php
include 'includes/connect.php';

if (isset($_GET['spec_id']) && isset($_GET['measure_id']) && isset($_GET['item_id']) && isset($_GET['id'])) {
    $measure_id = $_GET['measure_id'];
    $spec_id = $_GET['spec_id'];
    $item_id = $_GET['item_id'];
    $id = $_GET['id'];

    // Query to fetch measurement data for the given spec_id
    $query = "SELECT * FROM measurement 
            INNER JOIN specification ON measurement.id = specification.id
            INNER JOIN process ON measurement.process_id = process.process_id
            INNER JOIN package ON measurement.pack_id = package.pack_id
            INNER JOIN machine ON measurement.mc_id = machine.mc_id
            INNER JOIN material ON measurement.material_id = material.material_id
            INNER JOIN customer ON measurement.cust_id = customer.cust_id
            INNER JOIN partnumber ON measurement.id = partnumber.id
            INNER JOIN item ON specification.item_id = item.item_id 
            WHERE spec_id = '$spec_id'";
    $result = sqlsrv_query($con, $query) or die('Database connection error');
    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

    // Filter by measure_id
    $sql_mc = "SELECT TOP 24 * FROM measurement WHERE measure_id = $measure_id ORDER BY measure_datetime DESC";
    $run_sql = sqlsrv_query($con, $sql_mc);
    $row_mc = sqlsrv_fetch_array($run_sql, SQLSRV_FETCH_ASSOC);
    $mc_id = $row_mc['mc_id'];

    // Query to fetch chart data based on measure_id and item_id
    $sql_chart = "SELECT TOP 24 * FROM spec_result 
                    INNER JOIN measurement ON spec_result.measure_id = measurement.measure_id 
                    INNER JOIN partnumber ON spec_result.id = partnumber.id 
                    INNER JOIN machine ON measurement.mc_id = machine.mc_id 
                    WHERE measurement.mc_id = '$mc_id' 
                        AND item_id = '$item_id'
                        AND measurement.id = '$id'
                        AND measure_lot <= (SELECT TOP 1 measure_lot FROM measurement WHERE measure_id = '$measure_id' ORDER BY measure_lot DESC) -- Filter by measure_lot <= current lot
                    ORDER BY spec_result.result_datetime DESC";

    $result_chart = sqlsrv_query($con, $sql_chart);

    if ($result_chart > 0) {
        $result_max = array();
        $result_range = array();
        $measure_lot = array();
        $spec_xlcl = array();
        $spec_xucl = array();
        $spec_rucl = array();
        $spec_xcl = array();

        // Fetch chart data
        while ($row_chart = sqlsrv_fetch_array($result_chart, SQLSRV_FETCH_ASSOC)) {
            $result_max[] = $row_chart["result_max"];
            $result_range[] = $row_chart["result_range"];
            $measure_lot[] = $row_chart["measure_lot"]; // Add measure_lot to array
            $spec_xlcl[] = $row_chart["spec_xlcl"];
            $spec_xucl[] = $row_chart["spec_xucl"];
            $spec_xcl[] = $row_chart["spec_xcl"];
            $spec_rucl[] = $row_chart["spec_rucl"];
        }

        // Reverse the arrays to maintain chronological order
        $result_max = array_reverse($result_max);
        $result_range = array_reverse($result_range);
        $measure_lot = array_reverse($measure_lot);
        $spec_xlcl = array_reverse($spec_xlcl);
        $spec_xucl = array_reverse($spec_xucl);
        $spec_xcl = array_reverse($spec_xcl);
        $spec_rucl = array_reverse($spec_rucl);
    }
}
?>
<div class="col-md-8 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
            <div class="form-group row">
              <!-- chart untuk X Trend Chart -->
              <h4 class="card-title">Pullback Chart</h4>
              <p style="align:center;"><canvas id="myChartX"></canvas></p>
              
              <script src="graf.js"></script>
              <script>
                // Setup block
                const dataValue = <?php echo json_encode($result_max); ?>;
                const dataLSL = <?php echo json_encode($spec_xlcl); ?>;
                const dataUSL = <?php echo json_encode($spec_xucl); ?>;
                const dataCSL = <?php echo json_encode($spec_xcl); ?>;
                const labels = <?php echo json_encode($measure_lot); ?>;
                const data = {
                  labels: labels,
                  datasets: [{
                     label: 'Max',
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
        </div>



