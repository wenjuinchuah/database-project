<?php
    require './pdf/fpdf.php';
    include 'connect.php';
    date_default_timezone_set("Asia/Kuala_Lumpur"); //set time zone

    class PDF extends FPDF {
        // Page header
        function Header() {
            // Arial bold 15
            $this->SetFont('Arial', 'B', 15);
            // Move to the right
            $this->Cell(80);
            // Title
            $this->Cell(115, 15, 'Donation Summary', 0, 0, 'C');
            // Line break
            $this->Ln(20);
        }

        // Page footer
        function Footer() {
            $currentdatetime = date("Y/m/d H:i:s");
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Page number
            $this->Cell(0, 10, 'Generated on '. $currentdatetime, 0, 0, 'L');
            $this->Cell(0, 10, 'Page '. $this->PageNo(), 0, 0, 'R');
        }
    }

    $pdf = new PDF('L');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 10, 'Testing', 0, 0, 'L');
    $pdf->Output();

    mysqli_close($conn);
?>