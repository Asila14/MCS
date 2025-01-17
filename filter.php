<form action="filter_data.php" method="post">
  <input type="text" name="name" placeholder="Filter by name">
  <input type="text" name="user_level" placeholder="Filter by level">
  <input type="submit" value="Filter">
</form>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Name</th>
      <th>Age</th>
    </tr>
  </thead>
  <tbody>
    <?php
      // Filter the data based on the form input.
    include 'includes/connect.php';
      $name = $_POST['name'] ?? '';
      $user_level = $_POST['user_level'] ?? '';

      $sql = "SELECT * FROM users WHERE user_emp LIKE '%$name%' AND user_level = '$user_level'";
      $result = sqlsrv_query($con, $sql) or die('Database connection error');

      // Iterate through the results and display them in the table.
      while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['user_emp'] . '</td>';
        echo '<td>' . $row['user_level'] . '</td>';
        echo '</tr>';
      }
    ?>
  </tbody>
</table>
