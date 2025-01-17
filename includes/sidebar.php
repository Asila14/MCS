
<?php
header("Content-Type: text/html; charset=utf-8");
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-category">Measurement</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#measurement" aria-expanded="false" aria-controls="measurement">
              <i class="menu-icon mdi mdi-deskphone"></i>
              <span class="menu-title">Measurement</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="measurement">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="measurement_register.php">Register Measurement</a></li>
                <li class="nav-item"><a class="nav-link" href="measurement_list.php">List Of Measurement</a></li>
              </ul>
            </div>
          </li>
           

          <li class="nav-item nav-category">Master Data</li>

          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#mastersub" aria-expanded="false" aria-controls="mastersub">
              <i class="menu-icon mdi mdi-database-plus"></i>
              <span class="menu-title">Master Data</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="mastersub">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="process.php">Manage Data</a></li>
                <li class="nav-item"><a class="nav-link" href="spec-edit-history.php">Edit History</a></li>
                <li class="nav-item"><a class="nav-link" href="spec-del-history.php">Delete History</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item nav-category">Analysis</li>
          <li class="nav-item">
            <a class="nav-link" href="search_menu.php">
              <i class="menu-icon mdi mdi-chart-areaspline"></i>
              <span class="menu-title">Analysis</span>
            </a>
          </li>

          <!-- <li class="nav-item nav-category">Analysis</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#analysis" aria-expanded="false" aria-controls="analysis">
              <i class="menu-icon mdi mdi-chart-areaspline"></i>
              <span class="menu-title">Analysis</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="analysis">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="chart_menu.php">Chart</a></li>
                <li class="nav-item"><a class="nav-link" href="export_data.php">Data</a></li>
              </ul>
            </div>
          </li> -->

<!-- <li class="nav-item nav-category">Feedback</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#Feedback" aria-expanded="false" aria-controls="Feedback">
              <i class="menu-icon mdi mdi-comment-text"></i>
              <span class="menu-title">Feedback</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="Feedback">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="system_error.php">System Error History</a></li>
                <li class="nav-item"><a class="nav-link" href="system_enhancement.php">System Enhancement</a></li>
              </ul>
            </div>
          </li> -->
        </ul>
      </nav>