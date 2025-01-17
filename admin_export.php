<?php
// Set the timezone to Asia/Kuala_Lumpur
date_default_timezone_set('Asia/Kuala_Lumpur');

include 'includes/connect.php';

 // Get the user's employee number from the session variable.
      $user_emp = $_SESSION['user_emp'];

      // Query the database to get the user's process ID.
      $sql = "SELECT process_id FROM users WHERE user_emp = '$user_emp'";
      $result = sqlsrv_query($con, $sql);
      $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

      // Set the user's process ID in the session variable.
      $_SESSION['process_id'] = $row['process_id'];

      // Get the process ID from the session variable.
      $process_id = $_SESSION['process_id'];

        $query = "SELECT * FROM spec_result INNER JOIN measurement ON spec_result.measure_id=measurement.measure_id INNER JOIN process ON process.process_id=measurement.process_id INNER JOIN partnumber ON partnumber.id=spec_result.id INNER JOIN specification ON specification.spec_id=spec_result.spec_id INNER JOIN item ON specification.item_id=item.item_id INNER JOIN machine ON measurement.mc_id=machine.mc_id INNER JOIN material ON measurement.material_id=material.material_id WHERE process.process_id='$process_id' ORDER BY measure_datetime DESC";
        $result = sqlsrv_query($con,$query) or die('SQL error');

        // Generate a filename based on the current date and time in Malaysia
        $filename = 'AnalysisData_' . date('Ymd_His') . '.xls';

        $html='<table>
        <h4>Analysis Data</h4>
        <tr>
        <th class="text-center mt-3">Process</th>
        <th class="text-center mt-3">Insp. Date</th>
        <th class="text-center mt-3">PN</th>
        <th class="text-center mt-3">LN</th>
        <th class="text-center mt-3">Item</th>
        <th class="text-center mt-3">Avg</th>
        <th class="text-center mt-3">Max</th>
        <th class="text-center mt-3">Min</th>
        <th class="text-center mt-3">Range</th>
        <th class="text-center mt-3">Std.</th>
        <th class="text-center mt-3">CPK</th>
        <th class="text-center mt-3">Emp#</th>
        <th class="text-center mt-3">MC#</th>
        <th class="text-center mt-3">Material</th>
        <th class="text-center mt-3">M.LN</th>
        <th class="text-center mt-3">LSL</th>
        <th class="text-center mt-3">CSL</th>
        <th class="text-center mt-3">USL</th>
        <th class="text-center mt-3">XCL</th>
        <th class="text-center mt-3">XUCL</th>
        <th class="text-center mt-3">XLCL</th>
        <th class="text-center mt-3">RUCL</th>';
        
        while ($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
            $html.='<tr>
            <td>'.$row['process_name'].'</td>
            <td>'.$row['measure_datetime']->format('d/m/Y').'</td>
            <td>'.$row['pn_no'].'</td>
            <td>'.$row['measure_lot'].'</td>
            <td>'.$row['item_name'].'</td>
            <td style="mso-number-format:\'0.000\'">' . number_format($row['result_avg'], 3) . '</td>
            <td style="mso-number-format:\'0.000\'">' . number_format($row['result_max'], 3) . '</td>
            <td style="mso-number-format:\'0.000\'">' . number_format($row['result_min'], 3). '</td>
            <td style="mso-number-format:\'0.000\'">' . number_format($row['result_range'], 3) . '</td>
            <td style="mso-number-format:\'0.000\'">' . number_format($row['result_std'], 3) . '</td>
            <td style="mso-number-format:\'0.00\'">' . number_format($row['result_cpk'], 2) . '</td>
            <td>'.$row['measure_emp'].'</td>
            <td>'.$row['mc_name'].'</td>
            <td>'.$row['material_part'].'</td>
            <td>'.$row['measure_mate_lot'].'</td>
            <td>'.$row['spec_lsl'].'</td>
            <td>'.$row['spec_csl'].'</td>
            <td>'.$row['spec_usl'].'</td>
            <td>'.$row['spec_xcl'].'</td>
            <td>'.$row['spec_xucl'].'</td>
            <td>'.$row['spec_xlcl'].'</td>
            <td>'.$row['spec_rucl'].'</td>';
        }
        $html.='</table>';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename);
        echo $html;
?>