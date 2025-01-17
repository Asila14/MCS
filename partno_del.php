<?php
// Start the session at the beginning of the script
session_start();

include 'includes/connect.php';

// Check if the id and user_emp are set in the session
if (!isset($_GET["id"])) {
    die("id is required");
}

if (!isset($_SESSION["user_emp"])) {
    die("User not logged in");
}

// Retrieve the id from the GET request
$id = $_GET["id"];

// Retrieve the user_emp from the session
$user_emp = $_SESSION["user_emp"];

// Get the current date and time in Kuala Lumpur timezone
date_default_timezone_set('Asia/Kuala_Lumpur');
$deleted_at = date('Y-m-d H:i:s');

// Fetch the partnumber data based on id
$sql_fetch = "SELECT * FROM partnumber WHERE id = ?";
$params_fetch = array($id);
$stmt_fetch = sqlsrv_query($con, $sql_fetch, $params_fetch);

if ($stmt_fetch && sqlsrv_has_rows($stmt_fetch)) {
    $spec_data = sqlsrv_fetch_array($stmt_fetch, SQLSRV_FETCH_ASSOC);
    
    // Prepare the insert query for the deleted_partnumber table
    $sql_insert = "INSERT INTO deleted_partnumber (
                       id, category, pack_id, cust_id, process_id,
                            pn_no, material_id, user_emp, deleted_at
                        ) VALUES (
                            ?, ?, ?, ?, ?, ?, ?, ?, ?
                   )";
    
    // Add the partnumber data and additional fields into the params array
    $paramsInsertDeletedPartnumber = array(
        $spec_data['id'], $spec_data['category'], $spec_data['pack_id'], $spec_data['cust_id'], 
        $spec_data['process_id'], $spec_data['pn_no'], $spec_data['material_id'], $user_emp, $deleted_at
    );

    // Insert the data into deleted_partnumber
    $stmt_insert = sqlsrv_query($con, $sql_insert, $paramsInsertDeletedPartnumber);
    
    // Check for errors
    if ($stmt_insert === false) {
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                echo "code: " . $error['code'] . "<br />";
                echo "message: " . $error['message'] . "<br />";
            }
        }
        echo "Error inserting record into deleted_partnumber";
    } else {
        // If the insert is successful, delete the record from the partnumber table
        $sql_delete = "DELETE FROM partnumber WHERE id = ?";
        $params_delete = array($id);

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
            echo "<script>window.location.href='partno.php';</script>";
        }
    }
} else {
    echo "Part Number not found";
}

sqlsrv_close($con);
?>
