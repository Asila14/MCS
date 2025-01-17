<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>
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
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>
<?php
include 'includes/connect.php';

$output = "";

if (isset($_POST['login'])) {
    // Get the user_emp and user_password from the form
    $user_emp = $_POST['user_emp'];
    $user_password = $_POST['user_password'];

    // Check if the user_emp and user_password are valid
    $sql = "SELECT * FROM users INNER JOIN process ON users.process_id = process.process_id WHERE user_emp = ? AND user_password = ?";
    $params = array($user_emp, $user_password);
    $result = sqlsrv_query($con, $sql, $params);

    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

    if (isset($row['user_level'])) {
        // The user_level key exists in the $row array, so we can safely access it
        $_SESSION['user_emp'] = $user_emp;

        // Redirect based on user level using PHP header
        if ($row['user_level'] == 'SuperAdmin') {
            header('Location: measurement_list.php');
            exit;
        } elseif ($row['user_level'] == 'Admin') {
            header('Location: admin_measurement_list.php');
            exit;
        } elseif ($row['user_level'] == 'User') {
            header('Location: user_measurement_list.php');
            exit;
        }
    } else {
        // The user_level key does not exist in the $row array, so the user_emp and user_password are not valid
        $output = "<p class='alert alert-danger'>Wrong username OR password!</p>";
    }
}
?>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <?php echo $output; ?>
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <h4>Measurement Control System - MCS</h4>
              <h6 class="fw-light">Sign in to continue</h6>
              <form action="" method="POST" class="pt-3">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" placeholder="Employee Number" name="user_emp" autocomplete="off">
                </div>
                <div class="form-group password-toggle">
                    <input type="password" class="form-control form-control-lg password-input" placeholder="Password" name="user_password" autocomplete="off">
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
                <div class="mt-3">
                  <button type="submit" name="login" class="btn btn-primary">Submit</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                  </div>
                </div>
                <div class="mb-2">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
