<?php
include 'includes/connect.php';

if (isset($_GET['measure_id']) && isset($_GET['id'])) {

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

    // Check if the CSV file exists.
    if (!file_exists('Analysis Data.csv')) {
        // Create the CSV file.
        fopen('Analysis Data.csv', 'w');
    }

    // Open the CSV file for writing.
    $csv = fopen('Analysis Data.csv', 'a');

    // Execute the SQL query.
    $result = sqlsrv_query($con, $query);

    // Fetch the rows from the SQL query and write them to the CSV file.
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $data = array(
            $row['pn_no'],
            $row['process_code'],
            $row['measure_lot'],
            $row['item_code'],
            0,
            '',
            '',
            $row['data'],
            'NG020402',
            // Add 00 in between the alphabet and the employee number if the employee number is less than 6.
            strlen($row['measure_emp']) < 6 ? substr($row['measure_emp'], 0, 1) . '00' . substr($row['measure_emp'], 1) : $row['measure_emp'],
        );

        fputcsv($csv, $data);
    }

    // Close the CSV file.
    fclose($csv);

    // Output the CSV file to the browser.
    header('Content-Type:application/xsl');
    header('Content-Disposition:attachment;filename=Analysis Data.xsl');
    readfile('Analysis Data.csv');
}
?>
