<!DOCTYPE html>
<html lang="en">
<?php
include 'includes/head.php';
?>
<body>
    <!-- partial:partials/_navbar.html -->
    <?php
    include 'includes/user_navbar.php';
    ?>
    
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php
include 'includes/sidebar.php';
include 'includes/connect.php';

if (isset($_GET['user_emp']))
    $user_emp = $_GET['user_emp'];
else
    $user_emp = 0;

$query = "SELECT * FROM users INNER JOIN process ON users.process_id = process.process_id WHERE user_emp = ?";
$params = array($user_emp);
$result = sqlsrv_query($con, $query, $params) or die('Database connection error');
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

if (isset($_POST['edit']) && isset($_POST['user_emp'])) {
  $process_id = $_POST['process_id'];

  $updateQuery = "UPDATE users SET 
                  process_id = ?
                  WHERE user_emp = ?";

  $updateParams = array($process_id,$user_emp);

  $updateResult = sqlsrv_query($con, $updateQuery, $updateParams);

  if ($updateResult) {
      // Success message with SweetAlert
      echo "<script src='cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1000,
                    didClose: () => {
                        window.location.href = 'user.php';
                    }
                });
            </script>";
  } else {
      // Error message with SweetAlert
      echo "<script src='cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Failed!',
                    text: 'The operation failed.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
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
                      <h4 class="card-title">User Profile</h4>
                      <form class="forms-sample" action="" method="post">
                        <div class="form-group">
                          <label>Emp#</label>
                          <input type="text" class="form-control" name="user_emp" value="<?php echo $row['user_emp']; ?>" readonly>
                        </div>
                        <div class="form-group">
                          <label>Name</label>
                          <input type="text" class="form-control" name="user_name" value="<?php echo $row['user_name']; ?>" readonly>
                        </div>
                        <div class="form-group">
                          <label>Level</label>
                          <select data-live-search="true" name="user_level" class="form-control selectpicker" disabled>
                            <option name="user_level" value="<?php echo $row['user_level']; ?> " selected><?php echo $row['user_level']; ?></option>
                            <option value="SuperAdmin">SuperAdmin</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Select Process</label>
                          <?php
                          include 'includes/connect.php';
                          $process = sqlsrv_query($con, "SELECT * FROM process ");
                          ?>
                          <input type="hidden" id="process_id" name="process_id"
                                value="<?php if (isset($_POST['process_id'])) {
                                    echo $_POST['process_id'];
                                } ?>"
                                class="form-control" />
                          <select name="process_id" data-live-search="true" class="form-control selectpicker" disabled>
                              <?php
                              while ($p = sqlsrv_fetch_array($process, SQLSRV_FETCH_ASSOC)) {
                                  ?>
                                  <option value="<?php echo $p['process_id'] ?> "
                                      <?php echo ($row['process_id'] == $p['process_id']) ? 'selected' : ''; ?>>
                                      <?php echo $p['process_name']; ?>
                                  </option>
                              <?php } ?>
                          </select>
                      </div>
                        <div class="form-group">
                            <label>Position</label>
                            <select data-live-search="true" name="user_position" class="form-control selectpicker" disabled>
                                <option value="<?php echo $row['user_position']; ?>" selected><?php echo $row['user_position']; ?></option>
                                <option value="Manager">Manager</option>
                                <option value="Engineer">Engineer</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Group Leader">Group Leader</option>
                                <option value="Operator">Operator</option>
                            </select>
                        </div>
                        <div class="form-group">
                          <label>Password</label>
                          <input type="password" class="form-control form-control-lg password-input" name="user_password" value="<?php echo $row['user_password']; ?>" readonly>
                          <span class="toggle-icon" onclick="togglePassword()">👁️‍🗨️</span>
                        </div>
                        <script>
                            function togglePassword() {
                                const passwordInput = document.querySelector('.password-input');
                                const toggleIcon = document.querySelector('.toggle-icon');

                                if (passwordInput.type === 'password') {
                                    passwordInput.type = 'text';
                                    toggleIcon.textContent = '👁️‍🗨️'; // Change this line to set the icon when the password is visible
                                } else {
                                    passwordInput.type = 'password';
                                    toggleIcon.textContent = '👁️‍🗨️'; // Change this line to set the icon when the password is hidden
                                }
                            }
                        </script>
                        <div class="modal-footer">
                          <!-- <input type="hidden" name="user_emp" value="<?php echo $row['user_emp']; ?>">
                          <input type="submit" name="edit" class="btn btn-danger" value=" Edit "> -->
                          <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
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

