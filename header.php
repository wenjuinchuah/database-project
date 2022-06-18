<?php
    include 'connect.php';

    $bloodType = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    $color = ['red', 'pink', 'purple', 'pale-red', 'pink', 'purple', 'red', 'pale-red'];
    $urgentNeed = [];

    // stock count for blood A+
    $sql = 'SELECT donor.BloodType FROM donor INNER JOIN donation_list ON donor.DonorID = donation_list.DonorID WHERE donor.BloodType = "A+" ORDER BY donor.BloodType';
    if ($result = mysqli_query($conn,$sql))
        $blood[0] = mysqli_num_rows($result);

    // stock count for blood A-
    $sql = 'SELECT donor.BloodType FROM donor INNER JOIN donation_list ON donor.DonorID = donation_list.DonorID WHERE donor.BloodType = "A-" ORDER BY donor.BloodType';
    if ($result = mysqli_query($conn,$sql))
        $blood[1] = mysqli_num_rows($result);

    // stock count for blood B+
    $sql = 'SELECT donor.BloodType FROM donor INNER JOIN donation_list ON donor.DonorID = donation_list.DonorID WHERE donor.BloodType = "B+" ORDER BY donor.BloodType';
    if ($result = mysqli_query($conn,$sql))
        $blood[2] = mysqli_num_rows($result);

    // stock count for blood B-
    $sql = 'SELECT donor.BloodType FROM donor INNER JOIN donation_list ON donor.DonorID = donation_list.DonorID WHERE donor.BloodType = "B-" ORDER BY donor.BloodType';
    if ($result = mysqli_query($conn,$sql))
        $blood[3] = mysqli_num_rows($result);

    // stock count for blood AB+
    $sql = 'SELECT donor.BloodType FROM donor INNER JOIN donation_list ON donor.DonorID = donation_list.DonorID WHERE donor.BloodType = "AB+" ORDER BY donor.BloodType';
    if ($result = mysqli_query($conn,$sql))
        $blood[4] = mysqli_num_rows($result);

    // stock count for blood AB-
    $sql = 'SELECT donor.BloodType FROM donor INNER JOIN donation_list ON donor.DonorID = donation_list.DonorID WHERE donor.BloodType = "AB-" ORDER BY donor.BloodType';
    if ($result = mysqli_query($conn,$sql))
        $blood[5] = mysqli_num_rows($result);

    // stock count for blood O+
    $sql = 'SELECT donor.BloodType FROM donor INNER JOIN donation_list ON donor.DonorID = donation_list.DonorID WHERE donor.BloodType = "O+" ORDER BY donor.BloodType';
    if ($result = mysqli_query($conn,$sql))
        $blood[6] = mysqli_num_rows($result);

    // stock count for blood O-
    $sql = 'SELECT donor.BloodType FROM donor INNER JOIN donation_list ON donor.DonorID = donation_list.DonorID WHERE donor.BloodType = "O-" ORDER BY donor.BloodType';
    if ($result = mysqli_query($conn,$sql))
        $blood[7] = mysqli_num_rows($result);
    
    mysqli_close($conn);
?>

<!-- Header -->
<header class="w3-container w3-padding-16">
    <h5 class="w3-left"><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
    <a class="w3-btn w3-text-white w3-green w3-round w3-right"
        href="./donation_appointment.php?empID=<?php echo $empID ?>"><i class="fa fa-plus"></i><b> New
            Appointment</b></a>
</header>

<?php
    echo '<div class="w3-row-padding w3-margin-bottom w3-row">';
    for ($i = 0; $i < 8; $i++) {
        if ($blood[$i] < 3) {
            array_push($urgentNeed, $bloodType[$i]);
        }
        echo '<div class="w3-col l1" style="margin: 0 0 20px 0">
                <div class="w3-container w3-round-large w3-white w3-padding-16">
                    <div class="w3-left"><i class="material-icons w3-xxxlarge" style="color:'.$color[$i].'">bloodtype</i></div>
                    <div class="w3-right">
                        <h3>' . $blood[$i] . '</h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4 class="w3-row-padding">' . $bloodType[$i] . '</h4>
                </div>
            </div>';
    }

    echo '<div class="w3-rest w3-row-padding" style="margin: 0 0 20px 0">
            <div class="w3-container w3-round-large w3-red w3-padding-16">
                <div class="w3-left"><i class="material-icons w3-xxxlarge">warning</i></div>
                <div class="w3-right">
                    <h3>Urgent Needs</h3>
                </div>
                <div class="w3-clear"></div>
                <h4 class="w3-row-padding">Blood Type: '; foreach ($urgentNeed as $i) { echo $i . "&ensp;"; } echo '</h4>
            </div>
        </div>';
    echo '</div>';

?>
<!-- <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
        <div class="w3-container w3-round-large w3-red w3-padding-16">
            <div class="w3-left"><i class="fa fa-user w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3><?php echo $blood1 ?></h3>
            </div>
            <div class="w3-clear"></div>
            <h4>A+</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-round-large w3-blue w3-padding-16">
            <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3><?php echo $blood2 ?></h3>
            </div>
            <div class="w3-clear"></div>
            <h4>A-</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-round-large w3-teal w3-padding-16">
            <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3><?php echo $blood3 ?></h3>
            </div>
            <div class="w3-clear"></div>
            <h4>B+</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-round-large w3-orange w3-text-white w3-padding-16">
            <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3><?php echo $blood4 ?></h3>
            </div>
            <div class="w3-clear"></div>
            <h4>B-</h4>
        </div>
    </div>
</div> -->