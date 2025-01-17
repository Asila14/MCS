<?php
ob_start();

if (isset($_GET['measure_id']) && isset($_GET['id'])) { 
    $measure_id = $_GET['measure_id'];
    $id = $_GET['id'];
}

include 'includes/connect.php';

$query = "SELECT * FROM spec_result
        INNER JOIN spec_data ON spec_result.measure_id = spec_data.measure_id
        INNER JOIN measurement ON spec_result.measure_id = measurement.measure_id
        INNER JOIN process ON process.process_id = measurement.process_id
        INNER JOIN partnumber ON partnumber.id = spec_result.id
        INNER JOIN specification ON specification.spec_id = spec_result.spec_id
        INNER JOIN item ON specification.item_id = item.item_id
        INNER JOIN machine ON measurement.mc_id = machine.mc_id
        INNER JOIN material ON measurement.material_id = material.material_id
        WHERE spec_result.result_judgement = 'pass'AND spec_result.measure_id='$measure_id' AND spec_result.id='$id' ";

$result = sqlsrv_query($con, $query) or die('SQL error');

// Initialize variables for file name components
$pn_no = '';
$measure_lot = '';

// Retrieve data for file name components
if ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $pn_no = $row['pn_no'];
    $measure_lot = $row['measure_lot'];
}

// Generate the file name based on $pn_no and $measure_lot
$fileName = "$pn_no - $measure_lot.csv";

// Create a CSV file with the generated file name in the web server's document root
$filePath = __DIR__ . "/Downloads/$fileName";

// Check if fopen is successful
$csv = fopen($filePath, 'w');
if (!$csv) {
    die('Failed to open the CSV file');
}

// Check if there are rows to process
if ($row) {
    // Write the data rows
    do {
        $data = array(
            $row['pn_no'],
            $row['process_code'],
            $row['measure_lot'],
            $row['item_code'],
            '0',
            '',
            '',
            $row['data'],
            'NG020402',
            (strlen($row['measure_emp']) < 6 ? substr($row['measure_emp'], 0, 1) . '00' . substr($row['measure_emp'], 1) : $row['measure_emp']),
        );

        fputcsv($csv, $data);

        // Get the next row
        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    } while ($row);
}

// Check if fclose is successful
if (!fclose($csv)) {
    die('Failed to close the CSV file');
}

// Output the CSV file to the client
header('Content-Type: application/csv');
header("Content-Disposition: attachment; filename=$fileName");
readfile($filePath);
?>
