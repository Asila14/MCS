<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Measurement Control System</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/typicons/typicons.css">
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  <link rel="stylesheet" href="deliver.css">
  <script src="./filter.js"></script>
</head>
<body>
    <!-- partial:partials/_navbar.html -->
    <?php
    include 'includes/user_navbar.php';
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php
      include 'includes/user_sidebar.php';
      ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">System Enhancement</h4>
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
                      <div class="alert text-success d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                          <b>Note:</b> Enhancements are often made to add new features or improve existing ones, making the software more functional and capable of addressing users' needs more effectively.
                          <br><b>Nota:</b> Penambahbaikan selalunya dibuat untuk menambah baik ciri sedia ada, menjadikan perisian lebih berfungsi dan mampu menangani keperluan pengguna dengan lebih berkesan.
                        </div>
                      </div>
                  <div class="table-responsive">
                    <table id="emp-table" class="table table-bordered">
                        <thead>
                            <tr class="table-success">
                                <th class="text-center mt-3">#</th>
                                <th class="text-center mt-3">Description</th>
                                <th class="text-center mt-3">Category</th>
                            </tr>
                        </thead>
                        <tbody>
                      <?php
                          include 'includes/connect.php';

                          // Fetch records from the database
                          $sql = "SELECT * FROM system_enhancement";
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
                                  echo '<td class="text-center mt-3" style="white-space: pre-wrap;"><b>' . $row['improve_desciption'] . '</b></td>';
                                  echo '<td class="text-center mt-3">' . $row['improve_category'] . '</td>';
                                  echo '</tr>';
                                  $rowNumber++; // Increment the row number for the next row
                              }
                          }
                          ?>

                        </tbody>
                    </table>
                    <p class="card-body" style="text-align: right;"><i>This enhancement will only be added when it is necessary.<code>NOT DURING TESTING PHASE*</code></i></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php

                include 'includes/connect.php';
                //to add data
                if (isset ($_POST['AddIdeas'])){

                  $improve_category = $_POST["improve_category"];
                  $improve_desciption = $_POST["improve_desciption"];
                  

                    $sql = "INSERT INTO system_enhancement (improve_category,improve_desciption) VALUES ('$improve_category','$improve_desciption')";
                    $result = sqlsrv_query($con,$sql) or die('Database connection error');

                    if($result > 0){
                       // Use Sweetalert to show a success message
                            echo '
                              <script>
                                swal({
                                  title: "Done!",
                                  text: "Data has been succesfully registered.",
                                  icon: "success",
                                  button: "OK",
                                });
                              </script>
                            ';
                          } else {
                            // Use Sweetalert to show an error message
                            echo '
                              <script>
                                swal({
                                  title: "Failed!",
                                  text: "The operation failed.",
                                  icon: "error",
                                  button: "OK",
                                });
                              </script>
                            ';
                    }
                }
              

                ?>
          <div class="modal fade" id="AddIdeas" tabindex="-1" aria-labelledby="AddIdeasLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Ideas</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" action="" method="post">
                            <div class="form-group">
                              <label>Category</label>
                              <select data-live-search="true" name="improve_category" class="form-control selectpicker">
                                <option value="Chart">Chart</option>
                                <option value="Data report">Data report</option>
                                <option value="Form">Form</option>
                                <option value="Input">Input</option>
                                <option value="Functionality">Functionality</option>
                            </select>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="improve_description" autocomplete="off" class="form-control" oninput="checkDescriptionLength(this)">
                            </div>
                            <p id="description-length-warning" style="color: red;"></p>

                            <script>
                            function checkDescriptionLength(inputElement) {
                                var maxLength = 300; // Maximum allowed characters
                                var description = inputElement.value;

                                if (description.length > maxLength) {
                                    // If the input exceeds the limit, truncate it and show a warning
                                    inputElement.value = description.slice(0, maxLength);
                                    document.getElementById("description-length-warning").textContent = "Description is limited to 300 characters.";
                                } else {
                                    // Clear the warning if within the limit
                                    document.getElementById("description-length-warning").textContent = "";
                                }
                            }
                            </script>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="AddIdeas" class="btn btn-primary">Submit</button>
                          </div>
                          </form>
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

