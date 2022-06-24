<?php 

    include 'connect.php';

    $id = $_REQUEST["donorID"];
    $sql = "SELECT * FROM donor WHERE DonorID = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $name = $row[1];
    $name = explode(" ",$name, 2);
    $fname = $name[0];
    $lname = $name[1];
    $ic = $row[2];
    $weight = $row[3];
    $age = $row[4];
    $sex = $row[5];
    $phone = $row[6];
    $address = $row[7];
    $email = $row[8];
    $nationality = $row[9];
    $bloodtype = $row[12];

    echo json_encode( array( "fname"=>$fname, "lname"=>$lname, "ic"=>$ic, "weight"=>$weight, "age"=>$age, "sex"=>$sex,
    "bloodtype"=> $bloodtype, "phone"=>$phone, "address"=>$address, "email"=>$email, "nationality"=>$nationality ));

    mysqli_close($conn);
?>