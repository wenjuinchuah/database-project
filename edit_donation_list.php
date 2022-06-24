<?php
    if (isset($_POST['editDontionList'])){
        $id = $_POST['editID'];
        $hemoglobinLevel = $_POST['hemoglobinLevel'];
        $donorDonationType = $_POST['donorDonationType'];
        $fluidVolume = $_POST['fluidVolume'];
        $donationLocation = $_POST['donationLocation'];
        $donorIDName = $_POST['donorIDName'];
        $date = $_POST['donationDate'];

        $sql = "UPDATE donation_list
        SET Hemoglobinlevel = '$hemoglobinLevel', BloodDonationType = '$donorDonationType', FluidVolume = '$fluidVolume', DonationLocation = '$donationLocation', DonorID = '$donorID', 
        DonationDate = '$date' 
        WHERE DonationListID = '$id'";

        if(!mysqli_query($conn, $sql)){
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $action = "Edit";
    }
?>