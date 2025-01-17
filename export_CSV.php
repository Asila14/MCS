<?php
include 'includes/connect.php';

$query = "SELECT * FROM spec_result INNER JOIN measurement ON spec_result.measure_id=measurement.measure_id INNER JOIN process ON process.process_id=measurement.process_id INNER JOIN partnumber ON partnumber.id=spec_result.id INNER JOIN specification ON specification.spec_id=spec_result.spec_id INNER JOIN item ON specification.item_id=item.item_id INNER JOIN machine ON measurement.mc_id=machine.mc_id INNER JOIN material ON measurement.material_id=material.material_id ORDER BY measure_datetime DESC";
$result = sqlsrv_query($con, $query) or die('SQL error');

date_default_timezone_set('Asia/Kuala_Lumpur');
// Generate a filename based on the current date and time
$filename = 'AnalysisData_' . date('Ymd_His') . '.csv';

// CSV header
$csvContent = "Process,Insp. Date,PN,LN,Item,Avg,Max,Min,Range,Std.,CPK,Emp#,MC#,Material,M.LN,LSL,CSL,USL,XCL,XUCL,XLCL,RUCL\r\n";

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $csvContent .=
        $row['process_name'] . ',' .
        $row['measure_datetime']->format('d/m/Y') . ',' .
        $row['pn_no'] . ',' .
        $row['measure_lot'] . ',' .
        $row['item_name'] . ',' .
        number_format($row['result_avg'], 3) . ',' .
        number_format($row['result_max'], 3) . ',' .
        number_format($row['result_min'], 3) . ',' .
        number_format($row['result_range'], 3) . ',' .
        number_format($row['result_std'], 3) . ',' .
        number_format($row['result_cpk'], 2) . ',' .
        $row['measure_emp'] . ',' .
        $row['mc_name'] . ',' .
        $row['material_part'] . ',' .
        $row['measure_mate_lot'] . ',' .
        $row['spec_lsl'] . ',' .
        $row['spec_csl'] . ',' .
        $row['spec_usl'] . ',' .
        $row['spec_xcl'] . ',' .
        $row['spec_xucl'] . ',' .
        $row['spec_xlcl'] . ',' .
        $row['spec_rucl'] . "\r\n";
}

// Set the content type and headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=' . $filename);

// Output the CSV content
echo $csvContent;
?>
