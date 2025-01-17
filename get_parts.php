<?php
include 'includes/connect.php';

if (isset($_POST['process_id'])) {
    $process_id = $_POST['process_id'];

    // Fetch parts based on the selected process
    $sql_parts = "SELECT * FROM partnumber WHERE process_id = ?";
    $params_parts = array($process_id);
    $stmt_parts = sqlsrv_query($con, $sql_parts, $params_parts);

    $parts_options = '<option value=""> - Please select - </option>';
    if ($stmt_parts) {
        while ($row = sqlsrv_fetch_array($stmt_parts, SQLSRV_FETCH_ASSOC)) {
            $parts_options .= '<option value="' . $row['id'] . '">' . $row['pn_no'] . '</option>';
        }
    }

    // Fetch items based on the selected process
    $sql_items = "SELECT * FROM item WHERE process_id = ?";
    $params_items = array($process_id);
    $stmt_items = sqlsrv_query($con, $sql_items, $params_items);

    $items_options = '<option value=""> - Please select - </option>';
    if ($stmt_items) {
        while ($row = sqlsrv_fetch_array($stmt_items, SQLSRV_FETCH_ASSOC)) {
            $items_options .= '<option value="' . $row['item_id'] . '">' . $row['item_name'] . '</option>';
        }
    }

    $response = array(
        'parts' => $parts_options,
        'items' => $items_options
    );

    echo json_encode($response);
    sqlsrv_close($con);
}
?>
