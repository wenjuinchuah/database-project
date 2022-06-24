<?php
    include 'connect.php';

    $empID = $_GET['empID'];

    // Get Donation List Sum
    $donationSum = 0;
    $sql = "SELECT * FROM donation_list";
    if ($result = mysqli_query($conn,$sql))
        $donationSum = mysqli_num_rows($result);
     
    //insert data to donation list
    if(isset($_POST['addDonation']))
    {
        $donationid=1001+$donationSum;
        $donorid=$_POST['donorid'];
        $date=$_POST['date'];
        $donationtype=$_POST['donationtype'];
        $locationtype=$_POST['locationtype'];
        $locationid=$_POST['locationid'];
        $hemoglobinlevel=$_POST['hemoglobinlevel'];
        $fluidvolume=$_POST['fluidvolume'];
        $plateletvolume=$_POST['plateletvolume'];
        $plasmavolume=$_POST['plasmavolume'];
        if ($donationtype == "W")
            $packedredcellvolume=$_POST['packedredcellvolume'];

        $sql="INSERT INTO donation_list(DonationListID,DonorID, DonationDate, BloodDonationType, 
        DonationLocation,HemoglobinLevel,FluidVolume) VALUES('$donationid','$donorid', '$date', '$donationtype', '$locationtype',
        '$hemoglobinlevel','$fluidvolume') ";
        mysqli_query($conn,$sql);

        //Insert data to donation location
        switch($locationtype)
        {
            //Blood Bank
            case "B":
                $sql="SELECT * FROM `blood_bank` WHERE BankID ='$locationid' LIMIT 1";
                $result=mysqli_query($conn,$sql);
                while($row=mysqli_fetch_assoc($result))
                {
                    $bankname=$row['BankName'];
                    $bankaddress=$row['BankAddress'];
                    $bankphone=$row['BankTelNumber'];
                    $sql="INSERT INTO `blood_bank`(DonationListID,BankID,BankName,BankAddress,BankTelNumber) 
                    VALUES('$donationid','$locationid','$bankname','$bankaddress','$bankphone')";
                    mysqli_query($conn,$sql);
                }
                break;
            //Local Health Centre
            case "L":
                $sql="SELECT * FROM `local_health_centre` WHERE CentreID ='$locationid' LIMIT 1";
                $result=mysqli_query($conn,$sql);
                while($row=mysqli_fetch_assoc($result))
                {
                    $centrename=$row['CentreName'];
                    $centreaddress=$row['CentreAddress'];
                    $centrephone=$row['CentreTelNumber'];
                    $sql="INSERT INTO `local_health_centre`(DonationListID,CentreID,CentreName,CentreAddress,CentreTelNumber) 
                    VALUES('$donationid','$locationid','$centrename','$centreaddress','$centrephone')";
                    mysqli_query($conn,$sql);
                }
                break;
            
            //Mobility Programme
            case "M":
                $sql="SELECT * FROM `mobile_blood_donation_program` WHERE ProgramID ='$locationid' LIMIT 1";
                $result=mysqli_query($conn,$sql);
                while($row=mysqli_fetch_assoc($result))
                {
                    $programname=$row['ProgramName'];
                    $programaddress=$row['ProgramAddress'];
                    $programdate=$row['ProgramDate'];
                    $programtime=$row['ProgramTime'];
                    $sql="INSERT INTO `mobile_blood_donation_program`(DonationListID,ProgramID,ProgramName,ProgramAddress,ProgramDate,ProgramTime) 
                    VALUES('$donationid','$locationid','$programname','$programaddress','$programdate','$programtime')";
                    mysqli_query($conn,$sql);
                }
                break;
        }

        //insert data to Aphresis or Whole donation
        switch($donationtype)
        {
            case "A":
                    $sql="INSERT INTO `aphresis_donation`(DonationListID,PlateletVolume,PlasmaVolume) VALUE('$donationid','$plateletvolume','$plasmavolume')";
                    mysqli_query($conn,$sql);
                    break;

            case "W":
                    $sql="INSERT INTO `whole_blood_donation`(DonationListID,PackedRedCellsVolume,PlateletVolume,
                        PlasmaVolume) VALUE('$donationid','$packedredcellvolume','$plateletvolume','$plasmavolume')";
                    mysqli_query($conn,$sql);
                    break;
        }

        // inset data into donor, donation frequency and last donation date
        $sql = "SELECT COUNT(*) FROM donation_list WHERE DonorID = $donorid";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);
        $sql = "UPDATE donor SET LastDonation = '$date', DonationFrequency = $row[0] WHERE DonorID = $donorid";
        mysqli_query($conn, $sql);

    }   
    mysqli_close($conn);
?>

<script>
    window.location.href="./donation_list.php?empID=<?php echo $empID?>";
</script>