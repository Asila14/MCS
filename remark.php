<?php
include 'includes/connect.php'; // Ensure this file contains your database connection

// Initialize $remark to an empty string to prevent undefined variable warning
$remark = '';
$remarkSubmitted = false; // Initialize flag

// Check if the form to update the remark is submitted
if (isset($_POST['update_remark'])) {
    // Ensure all POST variables are set
    $remark = isset($_POST['remark']) ? $_POST['remark'] : '';
    $attempt = $_POST['attempt'] ?? '';
    $spec_id = $_POST['spec_id'] ?? '';
    $measure_id = $_POST['measure_id'] ?? '';
    $item_id = $_POST['item_id'] ?? '';
    $id = $_POST['id'] ?? '';

    // Update the remark in the database
    $sql_update = "UPDATE spec_result 
                   SET remark = ? 
                   WHERE measure_id = ? 
                   AND item_id = ? 
                   AND attempt = ?";
    $params = array($remark, $measure_id, $item_id, $attempt);
    $stmt_update = sqlsrv_query($con, $sql_update, $params);

    if ($stmt_update === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo '
        <script>
            swal({
                title: "Updated!",
                text: "Remark has been successfully updated.",
                icon: "success",
                button: "OK",
            });
        </script>
    ';
        $remarkSubmitted = true; // Set flag to true if remark is successfully updated
    }

    // Close the statement
    sqlsrv_free_stmt($stmt_update);
}

// Existing code to handle other operations, like fetching initial data
$measure_id = $_GET['measure_id'] ?? '';
$item_id = $_GET['item_id'] ?? '';
$attempt = $_GET['attempt'] ?? '';

// Check if remark exists in spec_result table
$sql_check_remark = "SELECT remark FROM spec_result WHERE measure_id = ? AND item_id = ? AND attempt = ?";
$params = array($measure_id, $item_id, $attempt);
$stmt = sqlsrv_query($con, $sql_check_remark, $params);


if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $remark = $row['remark'] ?? ''; // Default to empty string if null
    $remarkSubmitted = true; // Set flag to true if a remark already exists
}

// Close the statement
sqlsrv_free_stmt($stmt);
?>

<!-- HTML Form -->
<div class="col-md-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
        <div class="row">
          <form method="POST" action="">
            <div class="form-group">
              <label for="remark">Remark:</label>
              <input type="text" class="form-control" id="remark" name="remark" value="<?php echo htmlspecialchars($remark, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $remarkSubmitted ? 'readonly' : ''; ?>>
            </div>
            <!-- Hidden fields for form submission -->
            <input type="hidden" name="attempt" value="<?php echo htmlspecialchars($attempt, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="spec_id" value="<?php echo htmlspecialchars($spec_id, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="measure_id" value="<?php echo htmlspecialchars($measure_id, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item_id, ENT_QUOTES, 'UTF-8'); ?>">
            <button type="submit" name="update_remark" class="btn btn-primary" <?php echo $remarkSubmitted ? 'disabled' : ''; ?>>Submit</button>
          </form>
        </div>
    </div>
  </div>
</div>

