<?php
    include "connect.php";
    echo '
        <table class="w3-table-all" id="myTable">
            <tr class="w3-dark-grey">
                <th>Donation List ID</th>
                <th>Hemoglobin Level</th>
                <th>Blood Donation Type</th>
                <th>Fluid Volume</th>
                <th>Donation Date</th>
                <th>Donor Name</th>
                <th>Blood Type</th>
            </tr>
        ';
    
    

    if(isset($_REQUEST['type'])){
        $sql = "SELECT donation_list.DonationListID, donation_list.HemoglobinLevel, donation_list.BloodDonationType, donation_list.FluidVolume, donation_list.DonationDate, donor.DonorName, donor.BloodType
            FROM donation_list
            LEFT JOIN donor
            ON donation_list.DonorID=donor.DonorID
            ORDER BY donation_list.DonationDate;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $date = date("Y-m", strtotime($row[4]));
        echo "<tr style='background-color:gray; color: white'><td colspan='7'>".date_format(date_create($row[4]), "F Y")."</td></tr>";

        while ($row) {
           if(date("Y-m", strtotime($row[4])) != $date){
                $date = date("Y-m", strtotime($row[4]));
                echo "<tr style='background-color:gray; color:white'><td colspan='7'>".date_format(date_create($row[4]), "F Y")."</td></tr>";
            }
                $row[2] = ($row[2] == "W") ? "Whole" : "Apheresis";
                echo "<tr>";
                echo "<td>$row[0]</td>";
                echo "<td>$row[1]</td>";
                echo "<td>$row[2]</td>";
                echo "<td>$row[3]</td>";
                echo "<td>$row[4]</td>";
                echo "<td>$row[5]</td>";
                echo "<td>$row[6]</td>";
                echo "</tr>";

                $row = mysqli_fetch_array($result);
        }
    }else{
        $sql = "SELECT donation_list.DonationListID, donation_list.HemoglobinLevel, donation_list.BloodDonationType, donation_list.FluidVolume, donation_list.DonationDate, donor.DonorName, donor.BloodType
            FROM donation_list
            LEFT JOIN donor
            ON donation_list.DonorID=donor.DonorID
            ORDER BY donation_list.DonationListID;";
        $result = mysqli_query($conn, $sql);
        
        while ($row = mysqli_fetch_array($result)) {
            $row[2] = ($row[2] == "W") ? "Whole" : "Apheresis";
            echo "<tr>";
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "<td>$row[2]</td>";
            echo "<td>$row[3]</td>";
            echo "<td>$row[4]</td>";
            echo "<td>$row[5]</td>";
            echo "<td>$row[6]</td>";
            echo "</tr>";
        }
    }
    echo '
        </table>
        ';
    mysqli_close($conn);
?>