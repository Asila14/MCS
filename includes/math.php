<?php

function sum($array) {
  $total = 0;
  foreach ($array as $value) {
    $total += $value;
  }
  return $total;
}

function variance($array) {
  $mean = array_sum($array) / count($array);
  $squared_deviations = [];
  foreach ($array as $value) {
    $squared_deviation = ($value - $mean)**2;
    $squared_deviations[] = $squared_deviation;
  }
  $variance = sum($squared_deviations) / count($array);
  return $variance;
}

function standard_deviation($array) {
  $variance = variance($array);
  return sqrt($variance);
}

?>
