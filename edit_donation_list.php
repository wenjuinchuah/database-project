<?php
    // disable foreign key checks to ease the process of delete tables
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

    if (isset($_POST['editDonationList'])){
        $id = $_POST['editID'];
        $date = $_POST['donationDate'];
        $donationLocation = $_POST['donationLocation'];
        $locationID = $_POST['locationid'];
        $bloodDonationType = $_POST['bloodDonationType'];
        $hemoglobinLevel = $_POST['hemoglobinLevel'];
        $fluidVolume = $_POST['fluidVolume'];
        $plateletVolume = $_POST['plateletVolume'];
        $plasmaVolume = $_POST['plasmaVolume'];
        $packedRedCellVolume = 0;
        if ($bloodDonationType == "W")
            $packedRedCellVolume = $_POST['packedredcellvolume'];

        // Check conditions
        $sql = "SELECT * FROM donation_list WHERE DonationListID = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        // Check blood donation type
        if ($bloodDonationType != $row[2]) {
            switch ($bloodDonationType) {
                case 'A': // Change from Whole to Aphresis
                    $sql = "DELETE FROM whole_blood_donation WHERE DonationListID = $id";
                    $sql1 = "UPDATE donation_list SET BloodDonationtype = 'A' WHERE DonationListID = $id";
                    $sql2 = "INSERT INTO aphresis_donation (DonationListID, PlateletVolume, PlasmaVolume) VALUES ($id, $plateletVolume, $plasmaVolume)";
                    break;
                case 'W': // Change from Aphresis to Whole
                    $sql = "DELETE FROM aphresis_donation WHERE DonationListID = $id";
                    $sql1 = "UPDATE donation_list SET BloodDonationtype = 'W' WHERE DonationListID = $id";
                    $sql2 = "INSERT INTO whole_blood_donation (DonationListID, PackedRedCellsVolume, PlateletVolume, PlasmaVolume) VALUES ($id, $packedRedCellVolume, $plateletVolume, $plasmaVolume)";
                    break;
            }
            if (!mysqli_query($conn, $sql)) 
                echo "Error: " . $sql . "<br>" . $conn->error;
            else {
                if (!mysqli_query($conn, $sql1))
                    echo "Error: " . $sql . "<br>" . $conn->error;
                else {
                    if (!mysqli_query($conn, $sql2))
                        echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        } else {
            // same blood donation type, update changes
            switch ($bloodDonationType) {
                case 'W':
                    $sql = "UPDATE whole_blood_donation SET PackedRedCellsVolume=$packedRedCellVolume, PlateletVolume=$plateletVolume, PlasmaVolume=$plasmaVolume WHERE DonationListID = $id";
                    break;
                case 'A':
                    $sql = "UPDATE aphresis_donation SET PlateletVolume=$plateletVolume, PlasmaVolume=$plasmaVolume WHERE DonationListID = $id";
                    break;
            }
            if (!mysqli_query($conn, $sql))
                echo "Error: " . $sql . "<br>" . $conn->error;
        } // done

        // Check location type
        if ($donationLocation != $row[4]) {
            switch ($donationLocation) {
                case 'M': // Change to Mobile Program
                    // Get Data
                    $getData = "SELECT * FROM mobile_blood_donation_program WHERE ProgramID = $locationID";
                    $result = mysqli_query($conn, $getData);
                    if ($result) {
                        // Reuse $getData so dont have to declare another variable
                        $getData = mysqli_fetch_array($result);
                    }

                    $location = ($row[4] == 'L') ? "local_health_centre" : "blood_bank";
                    $sql = "DELETE FROM $location WHERE DonationListID = $id";
                    $sql1 = "UPDATE donation_list SET DonationLocation = 'M' WHERE DonationListID = $id";
                    $sql2 = "INSERT INTO mobile_blood_donation_program (DonationListID, ProgramID, ProgramName, ProgramAddress, ProgramDate, ProgramTime) VALUES ($id, '$getData[1]', '$getData[2]', '$getData[3]', '$getData[4]', '$getData[5]')";
                    break;
                case 'L': // Change to Local Centre
                    // Get Data
                    $getData = "SELECT * FROM local_health_centre WHERE CentreID = $locationID";
                    $result = mysqli_query($conn, $getData);
                    if ($result) {
                        // Reuse $getData so dont have to declare another variable
                        $getData = mysqli_fetch_array($result);
                    }

                    $location = ($row[4] == 'M') ? "mobile_blood_donation_program" : "blood_bank";
                    $sql = "DELETE FROM $location WHERE DonationListID = $id";
                    $sql1 = "UPDATE donation_list SET DonationLocation = 'L' WHERE DonationListID = $id";
                    $sql2 = "INSERT INTO local_health_centre (DonationListID, CentreID, CentreName, CentreAddress, CentreTelNumber) VALUES ($id, '$getData[1]', '$getData[2]', '$getData[3]', '$getData[4]')";
                    break;
                case 'B': // Change to Blood Bank
                    // Get Data
                    $getData = "SELECT * FROM blood_bank WHERE BankID = $locationID";
                    $result = mysqli_query($conn, $getData);
                    if ($result) {
                        // Reuse $getData so dont have to declare another variable
                        $getData = mysqli_fetch_array($result);
                    }

                    $location = ($row[4] == 'M') ? "mobile_blood_donation_program" : "local_health_centre";
                    $sql = "DELETE FROM $location WHERE DonationListID = $id";
                    $sql1 = "UPDATE donation_list SET DonationLocation = 'B' WHERE DonationListID = $id";
                    $sql2 = "INSERT INTO blood_bank (DonationListID, BankID, BankName, BankAddress, BankTelNumber) VALUES ($id, '$getData[1]', '$getData[2]', '$getData[3]', '$getData[4]')";
                    break;
            }
            if (!mysqli_query($conn, $sql)) 
                echo "Error: " . $sql . "<br>" . $conn->error;
            else {
                if (!mysqli_query($conn, $sql1))
                    echo "Error: " . $sql . "<br>" . $conn->error;
                else {
                    if (!mysqli_query($conn, $sql2))
                        echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        } else {
            // same location type, update changes
            switch ($donationLocation) {
                case 'M':
                    // Get Data
                    $getData = "SELECT * FROM mobile_blood_donation_program WHERE ProgramID = $locationID";
                    $result = mysqli_query($conn, $getData);
                    if ($result) {
                        // Reuse $getData so dont have to declare another variable
                        $getData = mysqli_fetch_array($result);
                    }

                    $sql = "UPDATE mobile_blood_donation_program SET ProgramID='$getData[1]', ProgramName='$getData[2]', ProgramAddress='$getData[3]', ProgramDate='$getData[4]', ProgramTime='$getData[5]' WHERE DonationListID = $id";
                    break;
                case 'L':
                    // Get Data
                    $getData = "SELECT * FROM local_health_centre WHERE CentreID = $locationID";
                    $result = mysqli_query($conn, $getData);
                    if ($result) {
                        // Reuse $getData so dont have to declare another variable
                        $getData = mysqli_fetch_array($result);
                    }

                    $sql = "UPDATE local_health_centre SET CentreID='$getData[1]', CentreName='$getData[2]', CentreAddress='$getData[3]', CentreTelNumber='$getData[4]' WHERE DonationListID = $id";
                    break;
                case 'B':
                    // Get Data
                    $getData = "SELECT * FROM blood_bank WHERE BankID = $locationID";
                    $result = mysqli_query($conn, $getData);
                    if ($result) {
                        // Reuse $getData so dont have to declare another variable
                        $getData = mysqli_fetch_array($result);
                    }

                    $sql = "UPDATE blood_bank SET BankID='$getData[1]', BankName='$getData[2]', BankAddress='$getData[3]', BankTelNumber='$getData[4]' WHERE DonationListID = $id";
                    break;
            }
            if (!mysqli_query($conn, $sql))
                echo "Error: " . $sql . "<br>" . $conn->error;
        } // done
                                                                                       
        // need to ensure each locationID have at least 2 donors, so deleting 1 entry will not delete entire detail of that locationID
        // hmm 

        // Update the rest
        $sql = "UPDATE donation_list SET HemoglobinLevel=$hemoglobinLevel, FluidVolume=$fluidVolume, DonationDate='$date' WHERE DonationListID = $id";
        if (!mysqli_query($conn, $sql))
                echo "Error: " . $sql . "<br>" . $conn->error;


        // use for success modal
        $action = "Edit";
    }

    // enable foreign key checks back
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
?>