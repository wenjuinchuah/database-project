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
            $this->Cell(115, 15, 'Donation Management Summary Report', 0, 0, 'C');
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

    $bloodtype = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');

    $pdf = new PDF('L');
    $pdf->AddPage();

    // blood
    $pdf->SetFillColor(173,216,230);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Blood Availability', 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10, 'Blood Type', 1, 0, 'L');
    foreach($bloodtype as $blood){
        $pdf->Cell(30, 10, $blood, 1, 0, 'L', 1);
    }
    $pdf->Ln();
    $pdf->Cell(30, 10, 'Amount', 1, 0, 'L');

    $pdf->SetFillColor(255,204,203);
    foreach($bloodtype as $blood){
        $sql = "SELECT donor.BloodType FROM donor INNER JOIN donation_list ON donor.DonorID = donation_list.DonorID WHERE donor.BloodType = '$blood' ORDER BY donor.BloodType";
        if ($result = mysqli_query($conn,$sql))
        if(mysqli_num_rows($result) == 0){
            $pdf->Cell(30, 10, mysqli_num_rows($result), 1, 0, 'L', 1);
        }else{
            $pdf->Cell(30, 10, mysqli_num_rows($result), 1, 0, 'L');
        }
        
    }
    $pdf->Ln(30);

    // donor
    $columnWidth = array(30, 60, 35, 17, 10, 10, 30, 30, 23, 23);
    $pdf->SetFillColor(173,216,230);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Donor Details', 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'donor'";
    if ($result = mysqli_query($conn,$sql)){
        $i = 0;

        while($row = mysqli_fetch_array($result)){
            $shortName = str_contains($row[0], "Donor") ? explode("Donor", $row[0])[1] : (str_contains($row[0], "DonationFrequency") ? explode("Donation", $row[0])[1] : $row[0]);
            switch ($row[0]) {
                case "DonorAddress":
                    break;
                case "DonorEmail":
                    break;
                case "DonorNationality": // you wan to skip these 3? and do we need to be able to edit the donation list? 
                                         // just because too long       // WIP edit donation list
                    break;
                default:
                    //$pdf->Cell((strlen($row[0]) < 8) ? strlen($row[0])+10 : strlen($row[0])+17, 10, $shortName, 1, 0,'L');
                    $pdf->Cell($columnWidth[$i], 10, $shortName, 1, 0,'L', 1);
                    $i++;
                    break;
            }
        }
    }
    $pdf->Ln();
    $sql = "SELECT DonorID, DonorName, `DonorIC/Passport_No`, DonorWeight, DonorAge, DonorSex, DonorPhoneNo, LastDonation, DonationFrequency, BloodType FROM donor";
    if($result = mysqli_query($conn, $sql)){
        while($row = mysqli_fetch_array($result)){
            for($i = 0; $i< 10; $i++){
                $pdf->Cell($columnWidth[$i], 10, $row[$i], 1, 0,'L');
            }
            $pdf->Ln();
        }
    }
    $pdf->Ln(30);

    // donation
    $columnWidth = array(30, 60, 35, 30, 20, 60, 30);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Donation List', 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'donation_list'";
    if ($result = mysqli_query($conn,$sql)){
        $i = 0;
        while($row = mysqli_fetch_array($result)){
            $shortName = str_contains($row[0], "Donation") ? explode("Donation", $row[0])[1] : (str_contains($row[0], "DonationList") ? explode("DonationList", $row[0])[1] : $row[0]);
            $pdf->Cell($columnWidth[$i], 10, $shortName, 1, 0,'L', 1);
            $i++;
        }
    }
    $pdf->Ln();
    $sql = "SELECT * FROM donation_list";
    if($result = mysqli_query($conn, $sql)){
        while($row = mysqli_fetch_array($result)){
            for($i = 0; $i< 7; $i++){
                $pdf->Cell($columnWidth[$i], 10, $row[$i], 1, 0,'L');
            }
            $pdf->Ln();
        }
    }
    $pdf->Cell(0, 10, "Type Indicator: W = 'Whole Blood', A = 'Apheresis'", 0, 1,'L');
    $pdf->Cell(0, 10, "Location Indicator: M = 'Mobile', L = 'Local', B = 'Blood Bank'", 0, 0,'L');

    $pdf->Output();

    mysqli_close($conn);
?>