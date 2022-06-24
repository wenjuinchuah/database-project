<?php
    if (isset($_POST['editDonor'])){
        $id = $_POST['editID'];
        $fname = $_POST['donorFN'];
        $lname = $_POST['donorLN'];
        $name = $fname." ".$lname;
        $weight = $_POST['donorWeight'];
        $age = $_POST['donorAge'];
        $sex = $_POST['donorSex'];
        $bloodtype = $_POST['donorbloodtype'];
        $address = $_POST['donorAddress'];
        $ic = $_POST['donorIC'];
        $phone = $_POST['donorPhone'];
        $email = $_POST['donorEmail'];
        $nationality = $_POST['nationality'];

        $sql = "UPDATE donor
        SET DonorName = '$name', `DonorIC/Passport_No` = '$ic', DonorWeight = '$weight', DonorAge = '$age', DonorSex = '$sex', 
        DonorPhoneNo = '$phone', DonorAddress = '$address', DonorEmail = '$email', DonorNationality = '$nationality', BloodType = '$bloodtype' 
        WHERE DonorID = '$id'";

        if(!mysqli_query($conn, $sql)){
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $action = "Edit";
    }
?>