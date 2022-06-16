<?php
    if (isset($_POST['addDonor'])){
        $fname = $_POST['donorFN'];
        $lname = $_POST['donorLN'];
        $name = $fname.$lname;
        $weight = $_POST['donorWeight'];
        $age = $_POST['donorAge'];
        $sex = $_POST['donorSex'];
        $bloodtype = $_POST['donorbloodtype'];
        $address = $_POST['donorAddress'];
        $ic = $_POST['donorIC'];
        $phone = $_POST['donorPhone'];
        $email = $_POST['donorEmail'];
        $nationality = $_POST['nationality'];

        $sql = "SELECT MAX(DonorID) FROM donor"; //the new donor id will be the highest + 1
        if ($result = mysqli_query($conn, $sql)) {

            $row = mysqli_fetch_array($result);
            $id = $row[0] + 1;

            $sql = "INSERT INTO donor(DonorID, DonorName, `DonorIC/Passport_No`, DonorWeight, DonorAge, 
            DonorSex, DonorPhoneNo, DonorAddress, DonorEmail, DonorNationality) 
            VALUES('$id', '$fname.$lname', '$ic', '$weight', '$age', '$sex', '$phone', '$address', '$email', '$nationality')";
            if(!mysqli_query($conn, $sql)){
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>