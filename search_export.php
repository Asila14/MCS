<?php
ob_start();

// Check if the form is submitted
if (isset($_POST['export'])) {
    // Retrieve user inputs
    $part_id = $_POST['part_id'];
    $item_id = $_POST['item_id'];
    $date_from = $_POST['x'];
    $date_to = $_POST['y'];
    $measure_id_from = $_POST['measure_id_from'];
    $measure_id_to = $_POST['measure_id_to'];
    $mc_id = $_POST['mc_id'];

    include 'includes/connect.php';

    // Define the base query
    $query = "SELECT * FROM spec_result
        INNER JOIN measurement ON spec_result.measure_id = measurement.measure_id
        INNER JOIN process ON process.process_id = measurement.process_id
        INNER JOIN partnumber ON partnumber.id = spec_result.id
        INNER JOIN specification ON specification.spec_id = spec_result.spec_id
        INNER JOIN item ON specification.item_id = item.item_id
        INNER JOIN machine ON measurement.mc_id = machine.mc_id
        INNER JOIN material ON measurement.material_id = material.material_id WHERE 1=1"; // Always true condition to start the WHERE clause

    // Add conditions based on user inputs
    if ($part_id !== '') {
        $query .= " AND partnumber.id = '$part_id'";
    }

    if ($item_id !== '') {
        $query .= " AND item.item_id = '$item_id'";
    }

    // Use the IN clause for measure_id_from and measure_id_to
    if ($measure_id_from !== '') {
        $query .= " AND measurement.measure_id >= '$measure_id_from'";
    }

    if ($measure_id_to !== '') {
        $query .= " AND measurement.measure_id <= '$measure_id_to'";
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

    // Execute the query
    $result = sqlsrv_query($con, $query);

    // Generate a unique filename (e.g., timestamp-based)
    $fileName = 'export_' . date('YmdHis') . '.csv';

    // Create a CSV file with the generated file name in the web server's document root
    $filePath = __DIR__ . "/Downloads/$fileName";

    // Check if fopen is successful
    $csv = fopen($filePath, 'w');
    if (!$csv) {
        die('Failed to open the CSV file');
    }

    // Output CSV column headers
    fputcsv($csv, array('Process', 'Inspection Date', 'PN', 'LN', 'Item', 'Avg', 'Max', 'Min', 'Range', 'Std.', 'CPK', 'Result', 'Emp#', 'MC#', 'Material', 'Material Lot', 'LSL', 'CSL', 'USL', 'XCL', 'XUCL', 'XLCL', 'RUCL'));

    // Check if there are rows to process
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        // Adjust the fields based on your actual database structure
        $data = array(
            $row['process_name'],
            $row['measure_datetime']->format('d-m-y'),
            $row['pn_no'],
            $row['measure_lot'],
            $row['item_name'],
            $row['result_avg'],
            $row['result_max'],
            $row['result_min'],
            $row['result_range'],
            $row['result_std'],
            $row['result_cpk'],
            $row['result_judgement'],
            $row['measure_emp'],
            $row['mc_name'],
            $row['material_part'],
            $row['measure_mate_lot'],
            $row['spec_lsl'],
            $row['spec_csl'],
            $row['spec_usl'],
            $row['spec_xcl'],
            $row['spec_xucl'],
            $row['spec_xlcl'],
            $row['spec_rucl']
        );

        fputcsv($csv, $data);
    }

    // Check if fclose is successful
    if (!fclose($csv)) {
        die('Failed to close the CSV file');
    }

    // Output the CSV file to the client
    header('Content-Type: application/csv');
    header("Content-Disposition: attachment; filename=$fileName");
    readfile($filePath);

    // End the script
    ob_end_flush();
    exit;
}
?>
