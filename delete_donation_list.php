<?php
    // disable foreign key checks to ease the process of delete tables
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

    if(isset($_POST['delete'])) {
        $id = $_POST['deleteID'];

        // Before delete a donor, need to delete all its donation list and relevant connected tables
        if (strlen(strval($id)) == 4) {
            $sql = "SELECT * FROM donation_list WHERE DonationListID = $id";
        } else {
            $sql = "SELECT * FROM donation_list WHERE DonorID = $id";
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
                
                // delete donationList
                $sql = "DELETE FROM donation_list WHERE DonationListID = $row[0]";
                if (!mysqli_query($conn, $sql)) {
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