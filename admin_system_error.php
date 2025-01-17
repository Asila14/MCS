<!DOCTYPE html>
<html lang="en">
<?php
include 'includes/head.php';
?>
<body>
    <!-- partial:partials/_navbar.html -->
    <?php
    include 'includes/admin_navbar.php';
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php
      include 'includes/admin_sidebar.php';
      ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">History of System Errors</h4>
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </symbol>
                        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </symbol>
                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </symbol>
                      </svg>
                      <div class="alert text-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                          <b>Note:</b>Below are all the issue details that were stated by the user during testing, together with MIS fix issue details.
                          <br><b>Nota:</b> Di bawah ialah semua butiran isu yang dinyatakan oleh pengguna semasa menggunakan sistem, bersama-sama dengan butiran isu pembetulan dari MIS.
                        </div>
                      </div>
                  <div class="table-responsive">
                    <table id="emp-table" class="table table-bordered">
                        <thead>
                            <tr class="table-secondary">
                                <th class="text-center mt-3">#</th>
                                <th class="text-center mt-3">Error/Issue</th>
                                <th class="text-center mt-3">Category</th>
                                <th class="text-center mt-3">User Level</th>
                                <th class="text-center mt-3">Date Issue</th>
                                <th class="text-center bg-warning mt-3">Date Fix Issue</th>
                                <th class="text-center bg-warning mt-3">Status</th>
                                <th class="text-center bg-warning mt-3">Solution</th>
                                <th class="text-center bg-warning mt-3">Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                      <?php
                          include 'includes/connect.php';

                          // Fetch records from the database
                          $sql = "SELECT * FROM system_error_record ORDER BY system_date_issue ASC";
                          $result = sqlsrv_query($con, $sql) or die('Database connection error');
                          $rowNumber = 1; // Initialize the row number

                          if (sqlsrv_has_rows($result) == 0) {
                              echo "<tr>";
                              echo "<th class='text-center mt-3 text-danger' colspan='24'>No Records Found...</th>";
                              echo "</tr>";
                          } else {
                              // Iterate through the results and display them in the table
                              while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                  echo '<tr>';
                                  echo '<td class="text-center mt-3">' . $rowNumber . '</td>'; // Display the row number
                                  echo '<td class="text-center mt-3">' . $row['system_issue'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['system_category'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['system_user_level'] . '</td>';
                                  echo '<td class="text-center mt-3">' . $row['system_date_issue']->format('d-m-y') . '</td>';
                                  echo '<td class="text-center text-success mt-3"><b>' . $row['system_date_fix']->format('d-m-y') . '</b></td>';
                                  if ($row['system_fix_status'] == 'complete') {
                                      echo '<td class="text-center mt-3"><label class="badge bg-danger"><b>' . $row['system_fix_status'] . '</b></label></td>';
                                  } else {
                                      echo '<td class="text-center mt-3"><label class="badge bg-success"><b>' . $row['system_fix_status'] . '</b></label></td>';
                                  }
                                  echo '<td class="text-center mt-3" style="white-space: pre-wrap;">' . $row['system_solution'] . '</td>';
                                  echo '<td class="text-center mt-3" style="white-space: pre-wrap;">' . $row['system_comment'] . '</td>';
                                  echo '</tr>';
                                  $rowNumber++; // Increment the row number for the next row
                              }
                          }
                          ?>

                        </tbody>
                    </table>
                    <p class="card-body" style="text-align: right;"><b><i>Last Update: 07 November 2023</i></b></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- partial -->
      </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <?php
        include 'includes/footer.php';
        ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <?php
  include 'script.php';
  ?>
</body>

</html>

