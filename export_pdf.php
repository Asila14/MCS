<?php

// Include the FPDF library
require('fpdf.php');

// Connect to the database
include 'includes/connect.php';

// Get the data from the database
$sql = "SELECT * FROM spec_result INNER JOIN measurement ON spec_result.measure_id=measurement.measure_id INNER JOIN process ON process.process_id=measurement.process_id INNER JOIN partnumber ON partnumber.id=spec_result.id INNER JOIN specification ON specification.spec_id=spec_result.spec_id INNER JOIN item ON specification.item_id=item.item_id INNER JOIN machine ON measurement.mc_id=machine.mc_id INNER JOIN material ON measurement.material_id=material.material_id ORDER BY measure_datetime DESC";
$result = sqlsrv_query($con,$sql) or die('Database connection eror');

// Create a new PDF document
$pdf = new FPDF();

// Add a page
$pdf->AddPage();

// Set the font
$pdf->SetFont('Arial', 'B', 12);

// Write the header
$pdf->Cell(200, 10, 'Analysis Data', 0, 1, 'C');

// Write the data
foreach ($result as $row) {
    $pdf->Cell(20, 10, $row['process_name'], 1);
    $pdf->Cell(20, 10, $row['measure_datetime']->format('d-m-y'), 1);
    $pdf->Cell(20, 10, $row['pn_no'], 1);
    $pdf->Cell(20, 10, $row['measure_lot'], 1);
    $pdf->Cell(20, 10, $row['item_name'], 1);
    $pdf->Cell(20, 10, $row['result_avg'], 1);
    $pdf->Cell(20, 10, $row['result_max'], 1);
    $pdf->Cell(20, 10, $row['result_min'], 1);
    $pdf->Cell(20, 10, $row['result_range'], 1);
    $pdf->Cell(20, 10, $row['result_std'], 1);
    $pdf->Cell(20, 10, $row['result_cpk'], 1);
    $pdf->Cell(20, 10, $row['measure_emp'], 1);
    $pdf->Cell(20, 10, $row['mc_name'], 1);
    $pdf->Cell(20, 10, $row['material_part'], 1);
    $pdf->Cell(20, 10, $row['measure_mate_lot'], 1);
    $pdf->Cell(20, 10, $row['spec_lsl'], 1);
    $pdf->Cell(20, 10, $row['spec_csl'], 1);
    $pdf->Cell(20, 10, $row['spec_usl'], 1);
    $pdf->Cell(20, 10, $row['spec_xcl'], 1);
    $pdf->Cell(20, 10, $row['spec_xucl'], 1);
    $pdf->Cell(20, 10, $row['spec_xlcl'], 1);
    $pdf->Cell(20, 10, $row['spec_rucl'], 1);
    $pdf->Ln();
}

// Output the PDF file
$pdf->Output('measurement.pdf');

?>
