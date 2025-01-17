<?php
session_start();
?>
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
            <span class="icon-menu"></span>
          </button>
        </div>
        <div>
          <a class="navbar-brand brand-logo-mini">
            <img src="images/logo.png" alt="logo" />
          </a>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-top"> 
        <ul class="navbar-nav">
          <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
            <h2 class="text-black fw-bold">Measurement Control System - MCS</h2>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown d-none d-lg-block user-dropdown">
            <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              Hi , <?php echo $_SESSION['user_emp']; ?> </a>
              <style>
                a.nav-link {
                  font-weight: bold;
                  color: red;
                  font-size: 1.2rem;
                }
              </style>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <?php
              include 'includes/connect.php';

              $user_emp = $_SESSION['user_emp'];

              $sql = "SELECT * FROM users WHERE user_emp = '$user_emp'";
              $result = sqlsrv_query($con, $sql) or die('Database connection error');
              $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

              if ($row) {
                echo "<a class='dropdown-item' href=user_profile.php?user_emp=".$row['user_emp']."><i class='dropdown-item-icon mdi mdi-account-outline text-primary me-2'></i> My Profile</a>";
              } else {
                echo "You are not logged in.";
              }
              ?>

              <a class="dropdown-item" href="logout.php" ><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>