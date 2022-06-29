<?php
    require './pdf/diag.php';

    include 'connect.php';
    date_default_timezone_set("Asia/Kuala_Lumpur"); //set time zone

    // Main PDF
    class PDF extends PDF_Diag {
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

    $pdf = new PDF('L');
    $pdf->AddPage();

    

    //donor
    $columnWidth = array(30, 60, 35, 17, 10, 10, 30, 30, 23, 25);
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
                case "DonorNationality":
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
    $pdf->Ln();
    $columnWidth = array(30, 140, 70, 30);
    $pdf->Cell($columnWidth[0], 10, 'ID', 1, 0,'L', 1);
    $pdf->Cell($columnWidth[1], 10, 'Address', 1, 0,'L', 1);
    $pdf->Cell($columnWidth[2], 10, 'Email', 1, 0,'L', 1);
    $pdf->Cell($columnWidth[3], 10, 'Nationality', 1, 0,'L', 1);
    $pdf->Ln();

    $sql = "SELECT DonorID, DonorAddress, DonorEmail, DonorNationality FROM donor";
    if($result = mysqli_query($conn, $sql)){
        while($row = mysqli_fetch_array($result)){
            if($pdf->GetStringWidth($row[1])+5 > 140){ // use multicell if the address is too long
                $numrow = (int) (($pdf->GetStringWidth($row[1])) / 140) + 1;
                for($i = 0; $i< 4; $i++){
                    if($i == 1){ // use multicell for address
                        $y = $pdf->GetY();
                        $pdf->MultiCell($columnWidth[$i], 10, $row[$i], 1, 'L');
                        $pdf->SetXY(180, $y);
                    }else{
                        $pdf->Cell($columnWidth[$i], 10*$numrow, $row[$i], 1, 0,'L');
                    }
                }
            }else{
                for($i = 0; $i< 4; $i++){
                        $pdf->Cell($columnWidth[$i], 10, $row[$i], 1, 0,'L');
                }
            }
            $pdf->Ln();
        }
    }
    $pdf->Ln(30);

    // donation
    $columnWidth = array(30, 50, 35, 30, 20, 50, 30, 30);
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
            for($i = 0; $i< 8; $i++){
                $pdf->Cell($columnWidth[$i], 10, $row[$i], 1, 0,'L');
            }
            $pdf->Ln();
        }
    }
    $pdf->Cell(0, 10, "Type Indicator: W = Whole Blood, A = Apheresis", 0, 1,'L');
    $pdf->Cell(0, 10, "Location Indicator: M = Mobile, L = Local, B = Blood Bank", 0, 0,'L');
    $pdf->Ln(30);

    // Mobile donation
    $columnWidth = array(35, 25, 45, 110, 30, 30);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Mobile Program Donation', 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'mobile_blood_donation_program'";
    if ($result = mysqli_query($conn,$sql)){
        $i = 0;
        while($row = mysqli_fetch_array($result)){
            $pdf->Cell($columnWidth[$i], 10, $row[0], 1, 0,'L', 1);
            $i++;
        }
    }
    $pdf->Ln();
    $sql = "SELECT * FROM mobile_blood_donation_program";
    if($result = mysqli_query($conn, $sql)){
        while($row = mysqli_fetch_array($result)){
            $numrow = (((($pdf->GetStringWidth($row[2])) / $columnWidth[2])) > (($pdf->GetStringWidth($row[3])) / $columnWidth[3])) ? ((($pdf->GetStringWidth($row[2])) / $columnWidth[2])) : ((($pdf->GetStringWidth($row[3])) / $columnWidth[3]));
            $numrow = ceil($numrow);
            for($i = 0; $i< 6; $i++){
                if($i == 2 || $i == 3){
                    if($numrow > 1){
                        $y = $pdf->GetY();
                        $x = $pdf->GetX();
                        $pdf->Rect($x, $y, $columnWidth[$i], 10*$numrow);
                        $pdf->MultiCell($columnWidth[$i], 10, $row[$i], 0, 'L');
                        $pdf->SetXY($x + $columnWidth[$i], $y);
                    }else{
                        $pdf->Cell($columnWidth[$i], 10*$numrow, $row[$i], 1, 0,'L');
                    }
                }else{
                    $pdf->Cell($columnWidth[$i], 10*$numrow, $row[$i], 1, 0,'L');
                }
                
            }
            $pdf->Ln();
        }
    }
    $pdf->Ln(20);

    // Local donation
    $columnWidth = array(35, 25, 65, 110, 40);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Local Donation', 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'local_health_centre'";
    if ($result = mysqli_query($conn,$sql)){
        $i = 0;
        while($row = mysqli_fetch_array($result)){
            $pdf->Cell($columnWidth[$i], 10, $row[0], 1, 0,'L', 1);
            $i++;
        }
    }
    $pdf->Ln();
    $sql = "SELECT * FROM local_health_centre";
    if($result = mysqli_query($conn, $sql)){
        while($row = mysqli_fetch_array($result)){
            $numrow = (((($pdf->GetStringWidth($row[2])) / $columnWidth[2])) > (($pdf->GetStringWidth($row[3])) / $columnWidth[3])) ? ((($pdf->GetStringWidth($row[2])) / $columnWidth[2])) : ((($pdf->GetStringWidth($row[3])) / $columnWidth[3]));
            $numrow = ceil($numrow);
            for($i = 0; $i< 5; $i++){
                if($i == 2 || $i == 3){
                    if($numrow > 1){
                        $y = $pdf->GetY();
                        $x = $pdf->GetX();
                        $pdf->Rect($x, $y, $columnWidth[$i], 10*$numrow);
                        $pdf->MultiCell($columnWidth[$i], 10, $row[$i], 0, 'L');
                        $pdf->SetXY($x + $columnWidth[$i], $y);
                    }else{
                        $pdf->Cell($columnWidth[$i], 10*$numrow, $row[$i], 1, 0,'L');
                    }
                }else{
                    $pdf->Cell($columnWidth[$i], 10*$numrow, $row[$i], 1, 0,'L');
                }
                
            }
            $pdf->Ln();
        }
    }
    $pdf->Ln(20);

    // Blood bank donation
    $columnWidth = array(35, 25, 65, 110, 40);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Blood Bank Donation', 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'blood_bank'";
    if ($result = mysqli_query($conn,$sql)){
        $i = 0;
        while($row = mysqli_fetch_array($result)){
            $pdf->Cell($columnWidth[$i], 10, $row[0], 1, 0,'L', 1);
            $i++;
        }
    }
    $pdf->Ln();
    $sql = "SELECT * FROM blood_bank";
    if($result = mysqli_query($conn, $sql)){
        while($row = mysqli_fetch_array($result)){
            $numrow = (((($pdf->GetStringWidth($row[2])) / $columnWidth[2])) > (($pdf->GetStringWidth($row[3])) / $columnWidth[3])) ? ((($pdf->GetStringWidth($row[2])) / $columnWidth[2])) : ((($pdf->GetStringWidth($row[3])) / $columnWidth[3]));
            $numrow = ceil($numrow + 1);
            for($i = 0; $i< 5; $i++){
                if($i == 2 || $i == 3){
                    if($numrow > 1){
                        $y = $pdf->GetY();
                        $x = $pdf->GetX();
                        $pdf->Rect($x, $y, $columnWidth[$i], 10*$numrow);
                        $pdf->MultiCell($columnWidth[$i], 10, $row[$i], 0, 'L');
                        $pdf->SetXY($x + $columnWidth[$i], $y);
                    }else{
                        $pdf->Cell($columnWidth[$i], 10*$numrow, $row[$i], 1, 0,'L');
                    }
                }else{
                    $pdf->Cell($columnWidth[$i], 10*$numrow, $row[$i], 1, 0,'L');
                }
                
            }
            $pdf->Ln();
        }
    }
    $pdf->Ln();
    $pdf->AddPage();

    // blood
    $data = array();
    $bloodtype = array('A+ ', 'A- ', 'B+ ', 'B- ', 'AB+', 'AB-', 'O+ ', 'O- ');
    $pdf->SetFillColor(173,216,230);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Blood Availability', 0, 1);
    $pdf->SetFont('Arial', 'BIU', 12);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10, 'Blood Type', 1, 0, 'L', 1);
    
    foreach($bloodtype as $blood) {
        $pdf->Cell(30, 10, $blood, 1, 0, 'L');  
    }

    $pdf->Ln();
    $pdf->Cell(30, 10, 'Amount', 1, 0, 'L', 1);

    foreach($bloodtype as $blood) {
        $pdf->SetFillColor(255,204,203);
        $sql = "SELECT donor.BloodType FROM donor INNER JOIN donation_list ON donor.DonorID = donation_list.DonorID WHERE donor.BloodType = '$blood' ORDER BY donor.BloodType";
        if ($result = mysqli_query($conn,$sql)) {
            $row = mysqli_num_rows($result);
            if ($row == 0) {
                $pdf->Cell(30, 10, $row, 1, 0, 'L', 1);
            } else {
                $pdf->Cell(30, 10, $row, 1, 0, 'L');
            }
            $data[$blood] = $row;
        } 
    }

    $showBarDiagram = false;
    $pdf->Ln(20);
    $pdf->SetFont('Arial', 'BIU', 14);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();

    if ($showBarDiagram) {
        //Bar diagram
        $pdf->Cell(0, 5, 'Bar diagram (Blood Availability)', 0, 1);
        $pdf->Ln(8);
        $pdf->BarDiagram(275, 100, $data, '%l : %v (%p)', array(255,175,100));
        $pdf->SetXY($valX, $valY + 80);
    } else {
        // Pie chart
        $pdf->Cell(0, 5, 'Pie chart (Blood Availability)', 0, 1);
        $pdf->Ln(15);

        $pdf->SetFont('Arial', '', 14);
        foreach ($data as $i=>$value) {
            $pdf->Cell(35, 10, '');
            $pdf->Cell(5, 10, $i.':');
            $pdf->Cell(15, 10, $data[$i], 0, 0, 'R');
            $pdf->Ln();
        }
        $pdf->Ln(8);

        $pdf->SetXY(90, $valY + 10);
        $col1=array(117,155,249);
        $col2=array(102,215,65);
        $col3=array(30,139,86);
        $col4=array(212,227,82);
        $col5=array(198,163,12);
        $col6=array(220,161,223);
        $col7=array(222,3,139);
        $col8=array(25,99,164);

        $pdf->PieChart(140, 100, $data, '%l (%p)', array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8));
    }
    $pdf->Ln(40);

    $sql = "SELECT DonationDate FROM donation_list ORDER BY DonationDate";
    if($result = mysqli_query($conn, $sql)){
        $row = mysqli_fetch_array($result);
        $date = date("Y-m", strtotime($row[0]));
        $data2[$date] = 1;
        while($row = mysqli_fetch_array($result)){
            if(date("Y-m", strtotime($row[0])) != $date){
                $date = date("Y-m", strtotime($row[0]));
                $data2[$date] = 1;
            }else{
                $data2[$date]++;
            }
        }
    }

    //Bar diagram
    $pdf->SetFont('Arial', 'BIU', 14);
    $pdf->Cell(0, 5, 'Bar diagram (Donation Date)', 0, 1);
    $pdf->Ln(8);
    $pdf->BarDiagram(275, 100, $data2, '%l : %v (%p)', array(255,175,100));
    $pdf->SetXY($valX, $valY + 80);

    $pdf->Ln(40);

    $pdf->Output();

    mysqli_close($conn);
?>