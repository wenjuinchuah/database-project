<?php
    // disable foreign key checks to ease the process of delete tables
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

    if(isset($_POST['delete'])) {
        $id = $_POST['deleteID'];
        $isDonor = false;
        $donorDetails = "";

        // Before delete a donor, need to delete all its donation list and relevant connected tables
        if (strlen(strval($id)) == 4) {
            $sql = "SELECT * FROM donation_list WHERE DonationListID = $id";
            $isDonor = false;
        } else {
            $sql = "SELECT * FROM donation_list WHERE DonorID = $id";
            $isDonor = true;
        }
        $result = mysqli_query($conn, $sql);

        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                // check for donation type (Whole / Aphresis)
                switch ($row[2]) {
                    case 'W':
                        $sql = "DELETE FROM whole_blood_donation WHERE DonationListID = $row[0]";
                        break;
                    case 'A':
                        $sql = "DELETE FROM aphresis_donation WHERE DonationListID = $row[0]";
                        break;
                }
                if (!mysqli_query($conn, $sql))
                    echo "Error: " . $sql . "<br>" . $conn->error;

                // check for donation loction (Bank / Local / Mobile)
                switch ($row[4]) {
                    case 'M':
                        $sql = "DELETE FROM mobile_blood_donation_program WHERE DonationListID = $row[0]";
                        break;
                    case 'L':
                        $sql = "DELETE FROM local_health_centre WHERE DonationListID = $row[0]";
                        break;
                    case 'B':
                        $sql = "DELETE FROM blood_bank WHERE DonationListID = $row[0]";
                        break;
                }
                if (!mysqli_query($conn, $sql))
                    echo "Error: " . $sql . "<br>" . $conn->error;
                
                // Minus donation frequency
                if (!$isDonor) {
                    $sql = "SELECT * FROM donor WHERE DonorID = $row[5]";
                    $reuslt1 = mysqli_query($conn, $sql);
                    if (!$reuslt1)
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    else
                    {
                        $donorDetails = mysqli_fetch_array($reuslt1);
                        $sql = "UPDATE donor SET DonationFrequency = $donorDetails[11]-1 WHERE DonorID = $donorDetails[0]";
                        if (!mysqli_query($conn, $sql))
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
                

                // Delete donationList
                $sql = "DELETE FROM donation_list WHERE DonationListID = $row[0]";
                if (!mysqli_query($conn, $sql)) {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                // Update donor latest donation date 
                $sql = "SELECT * FROM donation_list WHERE DonorID = $id ORDER BY DonationDate DESC";
                $result2 = mysqli_query($conn, $sql);
                if (!$result2)
                    echo "Error: " . $sql . "<br>" . $conn->error;
                else {
                    if ($donationList = mysqli_fetch_array($result2))
                        $row[10] = $donationList[6];
                    else 
                        $row[10] = "0000-00-00";

                    $sql = "UPDATE donor SET LastDonation = '$row[10]' WHERE DonorID = '$donorDetails[0]'";
                    if (!mysqli_query($conn, $sql))
                        echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        // use for success modal
        $action = "Delete";
    }

    // enable foreign key checks back
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
?>