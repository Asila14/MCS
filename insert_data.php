<?php

// Connect to the database
$db = new mysqli('localhost', 'root', '', 'my_database');

// Get the number of columns from the user input
$numberOfColumns = $_POST['numberOfColumns'];

// Get the data from the user for each column
$data = [];
for ($i = 1; $i <= $numberOfColumns; $i++) {
  $data[$i] = $_POST['column' . $i];
}

// Calculate the average of the values
$average = 0;
foreach ($data as $value) {
  $average += $value;
}

$average = $average / count($data);

// Insert the data and average into the database
$sql = "INSERT INTO my_table (column1, column2, column3, ..., average) VALUES (:column1, :column2, :column3, ..., :average)";

$stmt = $db->prepare($sql);

foreach ($data as $i => $value) {
  $stmt->bindParam(':column' . $i, $value);
}

$stmt->bindParam(':average', $average);

$stmt->execute();

// Close the database connection
$db->close();

// Redirect the user to the next page
header('Location: success.php');

?>
