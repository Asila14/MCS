<?php
include 'includes/connect.php';

$measureId = $_GET["measure_id"]; // Get the ID from the URL

// Delete the record from the measurement table
$sqlMeasurement = "DELETE FROM measurement WHERE measure_id='" . $measureId . "'";
if (sqlsrv_query($con, $sqlMeasurement)) {

    // Delete corresponding records from complete_lot
    $sqlCompleteLot = "DELETE FROM complete_lot WHERE measure_id='" . $measureId . "'";
    sqlsrv_query($con, $sqlCompleteLot);

    // Delete corresponding records from average_values
    $sqlAverageValues = "DELETE FROM average_values WHERE measure_id='" . $measureId . "'";
    sqlsrv_query($con, $sqlAverageValues);

    // Delete corresponding records from spec_data
    $sqlSpecData = "DELETE FROM spec_data WHERE measure_id='" . $measureId . "'";
    sqlsrv_query($con, $sqlSpecData);

    // Delete corresponding records from spec_result
    $sqlSpecResult = "DELETE FROM spec_result WHERE measure_id='" . $measureId . "'";
    sqlsrv_query($con, $sqlSpecResult);

    echo "Record deleted successfully";
    header ("refresh:0; url=user_measurement_list.php");
} else {
    echo "Error deleting record";
}

sqlsrv_close($con);
?>
