<?php
session_start();
require_once __DIR__ . "/fpdf.php";
require_once __DIR__ . "/repositories/AdminRepository.php";
if (isset($_GET['reservation_pdf'])) {
    $fullname = $_GET['fullname'] ?? null; 
    $title = $_GET['title'] ?? null; 
    $prix = $_GET['prix'] ?? null;
    $description = $_GET['description'] ?? null;
    $date_start = $_GET['date_start'] ?? null;
    $date_end = $_GET['date_end'] ?? null;
    $ville = $_GET['ville'] ?? null;

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont("Arial", "B", 16);
    $pdf->Cell(0, 10, "Reservation", 0, 1, "C");
    $pdf->Ln(10);
    
    $pdf->SetFont("Arial", "", 12);
    $pdf->Cell(0, 8, 'Nom de Hote : '.utf8_decode($fullname), 1 , 1);
    $pdf->Cell(0, 8, 'Non de logement : '.utf8_decode($title), 1 , 1);
    $pdf->Cell(0, 8, 'Description : '.utf8_decode($description), 1 , 1);
    $pdf->Cell(0, 8, 'Date de debut : '.$date_start, 1 , 1);
    $pdf->Cell(0, 8, 'Date de fin : '.$date_end, 1 , 1);
    $pdf->Cell(0, 8, 'Localisation : '.utf8_decode($ville), 1 , 1);
    $pdf->Cell(0, 8, 'Prix : '.$prix, 1 , 1);
    
    // $pdf->Output();
    $pdf->Output('D', 'incomes_list.pdf');
    exit;  
}