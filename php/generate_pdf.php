<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require('../fpdf/fpdf.php');
require('../BackEnd/Database/PlantDAO.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$plantDAO = new PlantDAO();

$numberOfPlants = $plantDAO->getNumberOfPlants();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Total Number of Plants Added in the HeMa App:', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $numberOfPlants, 0, 1, 'C');
$pdf->Ln();

$plants = $plantDAO->getPlantsWithPlace();

$placeCounts = array_count_values(array_column($plants, 'place'));
$totalPlants = count($plants);

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Plant Distribution by Place', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
foreach ($placeCounts as $place => $count) {
    $percentage = ($count / $totalPlants) * 100;
    $pdf->Cell(40, 10, $place, 0);
    $pdf->Cell(40, 10, $count, 0);
    $pdf->Cell(40, 10, sprintf('%.2f%%', $percentage), 0);
    $pdf->Ln(10);
}

$topPlants = $plantDAO->getTop3Plants();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Top Plants', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
foreach ($topPlants as $index => $plant) {
    $pdf->Cell(0, 10, 'Plant ' . ($index + 1), 0, 1);
    $pdf->Cell(40, 10, 'Common Name: ' . $plant['common_name'], 0, 1);
    $pdf->Cell(40, 10, 'Scientific Name: ' . $plant['scientific_name'], 0, 1);
    $pdf->Ln(10);
}

$pdf->Output('statistics.pdf', 'I');
