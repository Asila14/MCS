<?php
include 'includes/connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    if ($measure_id_from !== '') {
        $query .= " AND measurement.measure_id_from = '$measure_id_from'";
    }

    if ($measure_id_to !== '') {
        $query .= " AND measurement.measure_id_to = '$measure_id_to'";
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


    // Add more conditions as needed for other input fields

    // Execute the query
    $result = sqlsrv_query($con, $query);

    // Example: Displaying the retrieved data in a table
    echo '<table border="1">
            <tr>
                <th>Process</th>
                <th>Insp. Date</th>
                <th>PN</th>
                <th>LN</th>
                <th>Item</th>
                <th>Avg</th>
                <th>Max</th>
                <th>Min</th>
                <th>Range</th>
                <th>Std.</th>
                <th>CPK</th>
                <th>Result</th>
                <th>Emp#</th>
                <th>MC#</th>
                <th>Material</th>
                <th>Material Lot</th>
                <th>LSL</th>
                <th>CSL</th>
                <th>USL</th>
                <th>XCL</th>
                <th>XUCL</th>
                <th>XLCL</th>
                <th>RUCL</th>
            </tr>';

    // Loop through the retrieved data and display each row
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['process_name'] . '</td>';
        echo '<td>' . $row['measure_datetime']->format('d-m-y') . '</td>';
        echo '<td>' . $row['pn_no'] . '</td>';
        echo '<td>' . $row['measure_lot'] . '</td>';
        echo '<td>' . $row['item_name'] . '</td>';
        echo '<td>' . $row['result_avg'] . '</td>';
        echo '<td>' . $row['result_max'] . '</td>';
        echo '<td>' . $row['result_min'] . '</td>';
        echo '<td>' . $row['result_range'] . '</td>';
        echo '<td>' . $row['result_std'] . '</td>';
        echo '<td>' . $row['result_cpk'] . '</td>';
        echo '<td>' . ($row['result_judgement'] == 'pass' ? '<label class="badge bg-success"><b>' . $row['result_judgement'] . '</b></label>' : '<label class="badge bg-danger"><b>' . $row['result_judgement'] . '</b></label>') . '</td>';
        echo '<td>' . $row['measure_emp'] . '</td>';
        echo '<td>' . $row['mc_name'] . '</td>';
        echo '<td>' . $row['material_part'] . '</td>';
        echo '<td>' . $row['measure_mate_lot'] . '</td>';
        echo '<td>' . $row['spec_lsl'] . '</td>';
        echo '<td>' . $row['spec_csl'] . '</td>';
        echo '<td>' . $row['spec_usl'] . '</td>';
        echo '<td>' . $row['spec_xcl'] . '</td>';
        echo '<td>' . $row['spec_xucl'] . '</td>';
        echo '<td>' . $row['spec_xlcl'] . '</td>';
        echo '<td>' . $row['spec_rucl'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}
?>
