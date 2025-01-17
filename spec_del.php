<?php
// Start the session at the beginning of the script
session_start();

include 'includes/connect.php';

// Check if the spec_id and user_emp are set in the session
if (!isset($_GET["spec_id"])) {
    die("spec_id is required");
}

if (!isset($_SESSION["user_emp"])) {
    die("User not logged in");
}

// Retrieve the spec_id from the GET request
$spec_id = $_GET["spec_id"];

// Retrieve the user_emp from the session
$user_emp = $_SESSION["user_emp"];

// Get the current date and time in Kuala Lumpur timezone
date_default_timezone_set('Asia/Kuala_Lumpur');
$deleted_at = date('Y-m-d H:i:s');

// Fetch the specification data based on spec_id
$sql_fetch = "SELECT * FROM specification WHERE spec_id = ?";
$params_fetch = array($spec_id);
$stmt_fetch = sqlsrv_query($con, $sql_fetch, $params_fetch);

if ($stmt_fetch && sqlsrv_has_rows($stmt_fetch)) {
    $spec_data = sqlsrv_fetch_array($stmt_fetch, SQLSRV_FETCH_ASSOC);
    
    // Prepare the insert query for the deleted_specification table
    $sql_insert = "INSERT INTO deleted_specification (
                       spec_id, spec_sc, spec_csl, spec_usl, spec_lsl, spec_cpk,
                       spec_spl_point, spec_data_spl, spec_xcl, spec_xucl,
                       spec_xlcl, spec_rucl, item_id, id, spec_correction,
                       user_emp, deleted_at
                   ) VALUES (
                       ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                   )";
    
    // Add the specification data and additional fields into the params array
    $params_insert = array(
        $spec_data['spec_id'], $spec_data['spec_sc'], $spec_data['spec_csl'], $spec_data['spec_usl'], $spec_data['spec_lsl'],
        $spec_data['spec_cpk'], $spec_data['spec_spl_point'], $spec_data['spec_data_spl'], $spec_data['spec_xcl'], $spec_data['spec_xucl'],
        $spec_data['spec_xlcl'], $spec_data['spec_rucl'], $spec_data['item_id'], $spec_data['id'], $spec_data['spec_correction'],
        $user_emp, $deleted_at
    );

    // Insert the data into deleted_specification
    $stmt_insert = sqlsrv_query($con, $sql_insert, $params_insert);
    
    // Check for errors
    if ($stmt_insert === false) {
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                echo "code: " . $error['code'] . "<br />";
                echo "message: " . $error['message'] . "<br />";
            }
        }
        echo "Error inserting record into deleted_specification";
    } else {
        // If the insert is successful, delete the record from the specification table
        $sql_delete = "DELETE FROM specification WHERE spec_id = ?";
        $params_delete = array($spec_id);

        $stmt_delete = sqlsrv_query($con, $sql_delete, $params_delete);
        
        if ($stmt_delete === false) {
            if (($errors = sqlsrv_errors()) != null) {
                foreach ($errors as $error) {
                    echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                    echo "code: " . $error['code'] . "<br />";
                    echo "message: " . $error['message'] . "<br />";
                }
            }
            echo "Error deleting record";
        } else {
            echo "<script>window.location.href='spec.php';</script>";
        }
    }
} else {
    echo "Specification not found";
}

sqlsrv_close($con);
?>
