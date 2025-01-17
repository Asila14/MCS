<?php
include 'includes/connect.php';

// Define the number of records per page
$recordsPerPage = 5;

// Get the current page number from the query string, default to 1 if not set
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $recordsPerPage;

// Fetch records from the database with pagination
$sql = "SELECT * FROM process ORDER BY process_name ASC OFFSET $offset ROWS FETCH NEXT $recordsPerPage ROWS ONLY";
$result = sqlsrv_query($con, $sql) or die('Database connection error');

// Display the table header
echo "<table id='datatableid' class='table table-sm table-bordered'>";
echo "<thead>";
echo "<tr class='table-light'>";
echo "<th class='text-center mt-3'>Process</th>";
echo "<th class='text-center mt-3'>Code</th>";
echo "<th class='text-center mt-3'>Edit</th>";
echo "<th class='text-center mt-3'>Delete</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
if (sqlsrv_has_rows($result) == 0) {
    echo "<tr>";
    echo "<td class='text-center mt-3 text-danger' colspan='8'>No Records Found...</td>";
    echo "</tr>";
} else {
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        echo "<tr style=height:40px>";
                            echo "<td class='text-center mt-3'>".$row['process_name']."</td>";
                            echo "<td class='text-center mt-3'>".$row['process_code']."</td>";
                            echo "<td class='text-center mt-3'><a class=btn btn-primary href=process_edit.php?process_id=".$row['process_id']."><i class=ti-eraser></i></a></td>";
                            echo "<td class='text-center mt-3'><a class=btn btn-primary href=process_del.php?process_id=".$row['process_id']."><i class=ti-trash></i></a></td>";
                            echo "</tr>";             
    }
}
echo "</tbody>";
echo "</table><br>";

// Pagination links
$total_records_sql = "SELECT COUNT(*) AS total FROM process";
$total_records_result = sqlsrv_query($con, $total_records_sql);
$total_records = sqlsrv_fetch_array($total_records_result, SQLSRV_FETCH_ASSOC)['total'];
$total_pages = ceil($total_records / $recordsPerPage);

echo "<ul class='pagination'>";
                        if ($current_page > 1) {
                            echo "<li class='page-item'><a class='page-link' href='measurement_list.php?page=" . ($current_page - 1) . "'>Previous</a></li>";
                        }

                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo "<li class='page-item " . ($i == $current_page ? 'active' : '') . "'><a class='page-link' href='measurement_list.php?page=" . $i . "'>" . $i . "</a></li>";
                        }

                        if ($current_page < $total_pages) {
                            echo "<li class='page-item'><a class='page-link' href='measurement_list.php?page=" . ($current_page + 1) . "'>Next</a></li>";
                        }

                        echo "</ul>";

// Close the database connection
sqlsrv_close($con);
?>
