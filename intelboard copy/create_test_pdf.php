<?php
// Create a simple test PDF with TCPDF

require_once __DIR__ . '/vendor/autoload.php';

// Create PDF object
$pdf = new \TCPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', 'B', 16);

// Add test content matching the regex patterns in PaymentController
$pdf->Cell(0, 10, 'Weekly Payment Report', 0, 1, 'C');
$pdf->SetFont('Helvetica', '', 12);
$pdf->Ln(5);

$pdf->Cell(0, 10, 'Driver: C0U9622 John Smith', 0, 1);
$pdf->Cell(0, 10, 'Date: 2025-10-17', 0, 1);
$pdf->Cell(0, 10, 'Week reference: 2025-32', 0, 1);
$pdf->Ln(5);

$pdf->Cell(0, 10, 'Description                                Amount', 0, 1);
$pdf->Cell(0, 10, str_repeat('-', 50), 0, 1);
$pdf->Cell(0, 10, 'Weekly Earnings                        $2,500.00', 0, 1);
$pdf->Cell(0, 10, 'Bonuses                                  $250.00', 0, 1);
$pdf->Cell(0, 10, 'Deductions                               -$100.00', 0, 1);
$pdf->Ln(3);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Total Invoice: $2,650.00', 0, 1);

$outputPath = __DIR__ . '/storage/app/public/test_payment.pdf';
$pdf->Output($outputPath, 'F');
echo "Test PDF created at: storage/app/public/test_payment.pdf\n";
?>
