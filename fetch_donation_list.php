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

    $sql = "SELECT * FROM donor WHERE DonorID = $donorID";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $donorName = $row[1];
    
    echo json_encode( array( "hemoglobinLevel"=>$hemoglobinLevel, "bloodDonationType"=>$bloodDonationType, "fluidVolume"=>$fluidVolume, "donationLocation"=>$donationLocation, "donorID"=>$donorID, "donationDate"=>$donationDate, "donorName"=>$donorName ));

    mysqli_close($conn);
?>