<?php 

    include 'connect.php';

    $id = $_REQUEST["donationListID"];
    $sql = "SELECT * FROM donation_list WHERE DonationListID = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $hemoglobinLevel = $row[1];
    $bloodDonationType = $row[2];
    $fluidVolume = $row[3];
    $donationLocation = $row[4];
    $donorID = $row[5];
    $donationDate = $row[6];
    $packedredcell = 0;
    $plateletVolume = 0;
    $plasmaVolume = 0;

    switch($donationLocation) {
        case 'M':
            $sql = "SELECT * FROM mobile_blood_donation_program WHERE DonationListID = $id";
            break;
        case 'L':
            $sql = "SELECT * FROM local_health_centre WHERE DonationListID = $id";
            break;
        case 'B':
            $sql = "SELECT * FROM blood_bank WHERE DonationListID = $id";
            break;
    }
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $location = $row[1];
    $locationName = $row[2];

    $sql = "SELECT * FROM donor WHERE DonorID = $donorID";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $donorName = $row[1];

    switch($bloodDonationType) {
        case 'W':
            $sql = "SELECT * FROM whole_blood_donation WHERE DonationListID = $id";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $row = mysqli_fetch_array($result);
                $packedredcell = $row[1];  // need to declare outside if statement (eg. line15), else it only accesible inside the if statement only
                $plateletVolume = $row[2];
                $plasmaVolume = $row[3];
            }
            break;
        case 'A':
            $sql = "SELECT * FROM aphresis_donation WHERE DonationListID = $id";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $row = mysqli_fetch_array($result);
                $plateletVolume = $row[1];
                $plasmaVolume = $row[2];
            }
            break;
    }

    echo json_encode( array( "hemoglobinLevel"=>$hemoglobinLevel, "bloodDonationType"=>$bloodDonationType, "fluidVolume"=>$fluidVolume, "donationLocation"=>$donationLocation, "donorID"=>$donorID, "donationDate"=>$donationDate, "location"=>$location, "locationName"=>$locationName, "donorName"=>$donorName, "packedredcell"=>$packedredcell, "plateletVolume"=>$plateletVolume, "plasmaVolume"=>$plasmaVolume ));

    mysqli_close($conn);
?>