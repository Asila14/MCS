<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Register Package
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddPackage">
                    <i class="ti-plus"></i>
                  </button></h4>
                  <!-- Modal -->
                <?php

                include 'includes/connect.php';
                //to add data
                if (isset ($_POST['add'])){
                
                    $pack_name = $_POST["pack_name"];

                    // Check if the pack_name already exists in the database
                      $sql = "SELECT * FROM package WHERE pack_name = '$pack_name'";
                      $result = sqlsrv_query($con,$sql);

                      // If the pack_name already exists in the database, show an error message
                      if (sqlsrv_has_rows($result) > 0) {
                          echo '
                              <script>
                                  swal({
                                      title: "Failed!",
                                      text: "Data already exists!",
                                      icon: "error",
                                      button: "OK",
                                  });
                              </script>
                          ';
                      } else {

                    $sql = "INSERT INTO package (pack_name) VALUES ('$pack_name')";
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
              }
                ?>
                <div class="modal fade" id="AddPackage" tabindex="-1" aria-labelledby="AddPackageLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Package</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" action="" method="post">
                            <div class="form-group">
                              <label >Package</label>
                              <input type="text" name="pack_name" class="form-control">
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="add" class="btn btn-primary">Submit</button>
                          </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>

                <form action="" method="POST">
                    <h6 class="text-warning">If Package is not listed, please REGISTER. </h6>
                    <div class="row">
                      <div class="form-group row">
                        <div class="col-md-12">
                          <input type="text" class="form-control" id="searchPack" name="" autocomplete="off" placeholder="Search...">
                          <div id="no-results-messagePack" style="display: none; color: red;">Record not found...</div>
                          <br>
                        </div>
                      </div>
                </div>
              </form>

                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr class="table-light">
                          <th class='text-center mt-3'>Package</th>
                          <th class='text-center mt-3'>Edit</th>
                          <th class='text-center mt-3'>Delete</th>
                        </tr>
                      </thead>
                      <tbody class="table table-sm">
                        <?php
                        include 'includes/connect.php';
                        $sql = "SELECT * FROM package ";
                        $result = sqlsrv_query($con,$sql) or die('Database connection error');
                        while ($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td class='text-center mt-3'>".$row['pack_name']."</td>";
                                echo "<td class='text-center mt-3'><a class=btn btn-primary href=package_edit.php?pack_id=".$row['pack_id']."><i class=ti-eraser></i></a></td>";
                                echo "<td class='text-center mt-3'><a class=btn btn-primary href=package_del.php?pack_id=".$row['pack_id']."><i class=ti-trash></i></a></td>";
                                echo "</tr>";
                            }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
</div>
<script>
  // Add an event listener to the search input to listen for changes
      document.getElementById("searchPack").addEventListener("input", function() {
    // Get the value of the search input
        const query = this.value.toLowerCase();

    // Loop through each table row and check if it matches the search query
        let visibleRows = false;
        document.querySelectorAll("tbody tr").forEach(row => {
      // Get the columns in the row
          const columns = row.querySelectorAll("td");

      // Loop through each column and check if it contains the search query
          let match = false;
          columns.forEach(col => {
            if (col.textContent.toLowerCase().includes(query)) {
              match = true;
            }
          });

      // If the row matches the search query, show it. Otherwise, hide it.
          if (match) {
            row.style.display = "";
            visibleRows = true;
          } else {
            row.style.display = "none";
          }
        });

    // If no rows match the search query, display a message
        const message = document.getElementById("no-results-messagePack");
        if (!visibleRows) {
          message.style.display = "";
        } else {
          message.style.display = "none";
        }
      });
    </script>
         