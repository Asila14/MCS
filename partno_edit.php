<!DOCTYPE html>
<html lang="en">
<?php
include 'includes/head.php';
?>
<body>
    <!-- partial:partials/_navbar.html -->
    <?php
    ob_start();
    include 'includes/navbar.php';
    ?>
    
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php
      include 'includes/sidebar.php';
      ?>
      <?php
// Check if ID is set in the URL
if (isset($_GET['id']))
    $id = $_GET['id'];
else
    $id = 0;

include 'includes/connect.php';

// Retrieve data for the given ID
$query = "SELECT * FROM partnumber 
inner join process ON partnumber.process_id=process.process_id  
inner join customer ON partnumber.cust_id=customer.cust_id 
inner join package ON partnumber.pack_id=package.pack_id 
inner join material ON partnumber.material_id=material.material_id 
WHERE id = $id";
$params = array($id);
$result = sqlsrv_query($con, $query, $params) or die('Database connection error');
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

// Check if form is submitted for editing
if (isset($_POST['edit']) && isset($_POST['id'])) {
    
    // Retrieve form data
    $pn_no = addslashes($_POST['pn_no']);
    $category = addslashes($_POST['category']);
    $process_id = addslashes($_POST['process_id']);
    $cust_id = addslashes($_POST['cust_id']);
    $pack_id = addslashes($_POST['pack_id']);
    $material_id = addslashes($_POST['material_id']);

    // Retrieve user_emp from session
    $user_emp = $_SESSION["user_emp"];
    
    // Get the current date and time in Kuala Lumpur timezone
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $edited_date = date('Y-m-d H:i:s');

    // Insert data into edited_partnumber table
    $insertQuery = "INSERT INTO edited_partnumber (id, category, pack_id, cust_id, process_id, pn_no, material_id, user_emp, edited_date)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insertParams = array($id, $category, $pack_id, $cust_id, $process_id, $pn_no, $material_id, $user_emp, $edited_date);
    $insertResult = sqlsrv_query($con, $insertQuery, $insertParams);

    // Perform update operation on partnumber table
    $updateQuery = "UPDATE partnumber 
                    SET pn_no = ?, process_id = ?, cust_id = ?, pack_id = ?, category = ?, material_id = ?
                    WHERE id = ?";
    $updateParams = array($pn_no, $process_id, $cust_id, $pack_id, $category, $material_id, $id);
    $updateResult = sqlsrv_query($con, $updateQuery, $updateParams);

    if ($updateResult) {
        // Success message
        echo '<script>
                swal({
                  title: "Done!",
                  text: "Data edit was successful",
                  icon: "success",
                  button: "OK",
                });
              </script>';
        header("refresh:1; url=partno.php");
    } else {
        // Error message
        echo '<script>
                swal({
                  title: "Failed!",
                  text: "The operation failed.",
                  icon: "error",
                  button: "OK",
                });
              </script>';
    }
}
?>

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Part Number</h4>
                  <form class="forms-sample" action="" method="post">
                            <div class="form-group">
                              <label>Select Process</label>
                              <?php
                                    include 'includes/connect.php';
                                    $process = sqlsrv_query($con,"SELECT * FROM process ");
                              ?>
                              <input type="hidden" name="process_id" value="<?php if(isset($_POST['process_id'])){echo $_POST['process_id'];} ?>" class="form-control" />
                                  <select name="process_id" data-live-search="true" class="form-control selectpicker">
                                    <option name="process_id" value="<?php echo $row['process_id']; ?> " selected><?php echo $row['process_name']; ?></option>
                                    <?php 
                                    if($process > 0) {
                                     while($p = sqlsrv_fetch_array($process,SQLSRV_FETCH_ASSOC)){
                                    
                                    ?>
                                      <option name="process_id" value="<?php echo $p['process_id']?> "><?php echo $p['process_name']; ?>
                                        <?php } } ?></option>
                                  </select>
                            </div>
                            <div class="form-group">
                              <label>Part No</label>
                              <input type="text" name="pn_no" class="form-control" value="<?php echo $row['pn_no']; ?>">
                            </div>
                            <div class="form-group">
                              <label>Category</label>
                                <select name="category" data-live-search="true" class="form-control selectpicker" >
                                  <option name="category" value="<?php echo $row['category']; ?> " selected><?php echo $row['category']; ?></option>
                                  <option value="General">General</option>
                                  <option value="Automotive">Automotive</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Select Customer</label>
                              <?php
                                    include 'includes/connect.php';
                                    $cust = sqlsrv_query($con,"SELECT * FROM customer ");
                              ?>
                              <input type="hidden" id="cust_id" name="cust_id" value="<?php if(isset($_POST['cust_id'])){echo $_POST['cust_id'];} ?>" class="form-control" />
                                  <select name="cust_id" data-live-search="true" class="form-control selectpicker">
                                    <option name="cust_id" value="<?php echo $row['cust_id']; ?> " selected><?php echo $row['cust_name']; ?></option>
                                    <?php 
                                    if($cust > 0) {
                                     while($c = sqlsrv_fetch_array($cust,SQLSRV_FETCH_ASSOC)){
                                    
                                    ?>
                                      <option name="cust_id" value="<?php echo $c['cust_id']?> "><?php echo $c['cust_name']; ?>
                                        <?php } } ?></option>
                                  </select>
                            </div>
                            <div class="form-group">
                              <label>Select Package</label>
                              <?php
                                    include 'includes/connect.php';
                                    $pack = sqlsrv_query($con,"SELECT * FROM package ");
                              ?>
                              <input type="hidden" id="pack_id" name="pack_id" value="<?php if(isset($_POST['pack_id'])){echo $_POST['pack_id'];} ?>" class="form-control" />
                                  <select name="pack_id" data-live-search="true" class="form-control selectpicker">
                                    <option name="pack_id" value="<?php echo $row['pack_id']; ?> " selected><?php echo $row['pack_name']; ?></option>
                                    <?php 
                                    if($pack > 0) {
                                     while($pk = sqlsrv_fetch_array($pack,SQLSRV_FETCH_ASSOC)){
                                    
                                    ?>
                                      <option name="pack_id" value="<?php echo $pk['pack_id']?> "><?php echo $pk['pack_name']; ?>
                                        <?php } } ?></option>
                                  </select>
                            </div>
                            <div class="form-group">
                              <label>Select Material</label>
                              <?php
                                    include 'includes/connect.php';
                                    $mate = sqlsrv_query($con,"SELECT * FROM material ");
                              ?>
                              <input type="hidden" id="material_id" name="material_id" value="<?php if(isset($_POST['material_id'])){echo $_POST['material_id'];} ?>" class="form-control" />
                                  <select name="material_id" data-live-search="true" class="form-control selectpicker">
                                    <option name="material_id" value="<?php echo $row['material_id']; ?> " selected><?php echo $row['material_part']; ?></option>
                                    <?php 
                                    if($mate > 0) {
                                     while($pr = sqlsrv_fetch_array($mate,SQLSRV_FETCH_ASSOC)){
                                    
                                    ?>
                                      <option name="material_id" value="<?php echo $pr['material_id']?> "><?php echo $pr['material_part']; ?>
                                        <?php } } ?></option>
                                  </select>
                            </div>
                            <div class="modal-footer">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="edit" class="btn btn-danger" value=" Edit ">
                          </div>
                          </form>
                </div>
              </div>
            </div>
          </div>
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

