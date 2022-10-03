<?php
    include 'connect.php';

    // For the use of Success Modal
    $action = "";

    $empID = $_GET['empID'];
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    }
    if (!isset($empID)) {
        echo 'ERROR';
    } else {
        $sql = "SELECT * FROM medical_officer WHERE EmpID = '$empID'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_array($result);
            if ($row != NULL) {
                $empName = $row[1];
            } else {
                echo 'Invalid Employee ID';
            }
        } else {
            echo 'Error: ' . $sql . '<br/>' . mysqli_error($conn);
        }
    }

    include 'delete_donation_list.php';
    include 'edit_donation_list.php';

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>BDMS Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        html,
        body,
        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: Arial, Helvetica, sans-serif
        }

        .w3-padding-0 {
            padding: 0
        }
    </style>
</head>

<body class="w3-light-grey">

    <!-- Top container -->
    <div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
        <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey"
            onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
        <button class="w3-bar-item w3-right w3-button" onclick="window.location.href='./index.php';"><i
                class="fa fa-sign-out"></i></button>
        <span class="w3-bar-item w3-hide-small">Blood Donation Management System</span>
    </div>

    <!-- Sidebar/menu -->
    <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
        <div class="w3-container w3-row">
            <div class="w3-col s4">
                <img src="./src/avatar2.png" class="w3-circle w3-margin-right" style="width:60px">
            </div>
            <div class="w3-col s8 w3-bar w3-padding-16">
                <span style="font-size: 16px">Welcome,
                    <strong><?php echo strstr($empName, ' ', true) ?></strong></span><br>
            </div>
        </div>
        <hr>
        <div class="w3-container">
            <h5>Dashboard</h5>
        </div>
        <div class="w3-bar-block">
            <a href="./dashboard.php?empID=<?php echo $empID ?>" class="w3-bar-item w3-button w3-padding"><i
                    class="fa fa-file-text-o fa-fw"></i>  Donor Registration</a>
            <a href="./donor_details.php?empID=<?php echo $empID ?>" class="w3-bar-item w3-button w3-padding"><i
                    class="fa fa-eye fa-fw"></i>  Donor Details</a>
            <a href="./donation_list.php?empID=<?php echo $empID ?>" class="w3-bar-item w3-button w3-padding w3-teal"><i
                    class="fa fa-users fa-fw"></i>  Donation
                List</a>
            <a href="./report.php" target="_blank" class="w3-bar-item w3-button w3-padding"><i
                    class="	fa fa-archive fa-fw"></i>  Generate Report</a><br><br>
        </div>
    </nav>


    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer"
        title="close side menu" id="myOverlay"></div>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
        <?php include "header.php" ?>

        <div class="w3-container">
            <h5><b><i class="fa fa-file-text-o"></i> Donation List</b></h5>

            <div class="w3-panel w3-padding-0 w3-row">
                <select class="w3-select w3-border w3-quarter w3-row-padding" style="margin-right:16px; height:40.5px"
                    id="sort" name="filter" onchange="clearInput()">
                    <option value="" disabled selected>Sort by</option>
                </select>
                <div class="w3-rest">
                    <input class="w3-input w3-border w3-rest" type="text" placeholder="Search" id="myInput"
                        onkeyup="filter()">
                </div>
            </div>

            <div class="w3-container">
                <div class="w3-right">
                    <button onclick=month() class="w3-btn w3-round w3-teal">Monthly</button>
                    <button onclick=allData() class="w3-btn w3-round w3-teal">All Data</button>
                </div>
            </div>

            <br>
            <div class="w3-card-4 w3-white">
                <div class="w3-responsive" id="donation_list_table">
                    <?php include 'donation_list_table.php' ?>
                </div>
            </div>
            <br>

            <!-- Edit Modal -->
            <div id="editDonationModal" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-top">
                    <header class="w3-container w3-dark-gray">
                        <span onclick="document.getElementById('editDonationModal').style.display='none'"
                            class="w3-button w3-display-topright"><i class="fa fa-times"></i></span>
                        <!-- !TODO -->
                        <h2>Edit Donation List</h2>
                    </header>
                    <div class="w3-container" id="editform">
                        <form class='w3-row-padding' action="" method='POST'>
                            <input type="hidden" id="editID" name="editID">
                            <div class='w3-twothird w3-padding-16'>
                                <label>Donor Name</label>
                                <input class='w3-input' name='donorID' type='text' disabled>
                            </div>
                            <div class='w3-third w3-padding-16'>
                                <label>Date</label>
                                <input class="w3-input" type="date" name="donationDate" required>
                            </div>
                            <div class='w3-third w3-padding-16'>
                                <label>Donation Location</label>
                                <select class='w3-select' name='donationLocation' id="locationType" onchange="showLocation(document.getElementById('locationType').value)" required>
                                    <option value="B">Blood Bank</option>
                                    <option value="L">Local Health Centre</option>
                                    <option value="M">Mobility Programme</option>
                                </select>
                            </div>
                            <div class="w3-twothird w3-padding-16">
                                <label>Location ID</label>
                                <select class="w3-select" type="text" name="locationid" id="location" required>
                                </select>
                            </div> 
                            <div class='w3-third w3-padding-16'>
                                <label>Donation Type</label>
                                <select class='w3-select' name='bloodDonationType' id="bloodDonationType" onchange="updateDonationType()"required>
                                    <option value='W'>Whole</option>
                                    <option value='A'>Aphresis</option>
                                </select>
                            </div>
                            <div class='w3-third w3-padding-16'>
                                <label>Hemoglobin Level</label>
                                <input class='w3-input' name='hemoglobinLevel' type='text' required>
                            </div>
                            <div class='w3-third w3-padding-16'>
                                <label>Fluid Volume</label>
                                <input class='w3-input' name='fluidVolume' type='text' value="0" required readonly>
                            </div>
                            <div class='w3-half w3-padding-16'>
                                <label>Platelet Volume Level</label>
                                <input class='w3-input' name='plateletVolume' oninput='calculateVolume()' value="0" type='number' required>
                            </div>
                            <div class='w3-half w3-padding-16'>
                                <label>Plasma Volume</label>
                                <input class='w3-input' name='plasmaVolume' oninput='calculateVolume()' value="0" type='number' required>
                            </div>
                            <!--show packed red cell if selected whole blood-->
                            <div class="w3-row-padding w3-padding-16">
                                <label>Packed Red Cell Volume (ml)</label>
                                <input class="w3-input" type="number" oninput='calculateVolume()' name="packedredcellvolume" id="packedRedCell" placeholder="For Whole Blood Donation only" required>
                            </div>
                            <div class='w3-row-padding'>
                                <b><input type='submit' class='w3-btn w3-block w3-round w3-green' id="editDonationList"
                                        name='editDonationList' value='Edit Donation List'></input></b>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Modal-->
            <div id="deleteDonationModal" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-top">
                    <header class="w3-container w3-dark-gray">
                        <span onclick="document.getElementById('deleteDonationModal').style.display='none'"
                            class="w3-button w3-display-topright"><i class="fa fa-times"></i></span>
                        <h2>Delete Current Donation List</h2>
                    </header>
                    <div class="w3-container" style="text-align:center;">
                        <form class='w3-padding-24 w3-panel' action="" method="POST">
                            <i class="fa fa-exclamation-triangle w3-xxxlarge" style="color: rgb(230, 89, 84)"></i>
                            <input type="hidden" id="deleteID" name="deleteID">
                            <div class="w3-panel">
                                <h4>Data can't be restored once deleted. </h4>
                                <h4>Are you sure?</h4>
                            </div>
                            <div class="w3-row-padding" style="margin: auto; width: 50%">
                                <b><input type="submit" class="w3-btn w3-block w3-round w3-red" name="delete"
                                        value="Confirm"></input></b>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Success Modal-->
            <div id="successModal" class="w3-modal" style="padding-top: 40px; display: none">
                <div class="w3-modal-content w3-card-4 w3-animate-top">
                    <header class="w3-container w3-green">
                        <span onclick="document.getElementById('successModal').style.display='none'"
                            class="w3-button w3-display-topright"><i class="fa fa-times"></i></span>
                        <h4><?php echo $action ?> Successful</h4>
                    </header>
                    <div class="w3-container" style="text-align:center;">
                        <h5>Donation list is
                            <?php if ($action == "Edit") { echo "updated"; } else if ($action == "Add") { echo "added"; } else { echo 'deleted'; }; ?>!</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- End page content -->
    </div>

    <!-- Table for each location -->
    <?php
        include 'connect.php';
        $counter = 0;
        $list = array();
        $tableList = ['B', 'L', 'M'];

        foreach ($tableList as $i) {
            $isFound = false;
            echo '<table class="w3-table-all" id="'.$i.'" style="display: none">';
            switch ($i) {
                case 'B':
                    $sql = "SELECT * FROM blood_bank";
                    break;
                case 'L':
                    $sql = "SELECT * FROM local_health_centre";
                    break;
                case 'M':
                    $sql = "SELECT * FROM mobile_blood_donation_program";
                    break;
            }
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_array($result)) {
                foreach ($list as $j) {
                    if ($j == $row[1]) {
                        $isFound = true;
                        break;
                    }
                    else
                        $isFound = false;
                }
                if ($isFound == false) {
                    array_push($list, $row[1]);
                    echo "<tr>";
                    echo "<td>$row[1]</td>";
                    echo "<td>$row[2]</td>";
                    echo "</tr>";
                }
            }

            echo '</table>';
        }
        mysqli_close($conn);
    ?>

    <!-- import jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        // Get the Sidebar
        var mySidebar = document.getElementById("mySidebar");

        // Get the DIV with overlay effect
        var overlayBg = document.getElementById("myOverlay");

        // Toggle between showing and hiding the sidebar, and add overlay effect
        function w3_open() {
            if (mySidebar.style.display === 'block') {
                mySidebar.style.display = 'none';
                overlayBg.style.display = "none";
            } else {
                mySidebar.style.display = 'block';
                overlayBg.style.display = "block";
            }
        }

        // Close the sidebar with the close button
        function w3_close() {
            mySidebar.style.display = "none";
            overlayBg.style.display = "none";
        }

        // Table filter by month
        function month() {
            $("#donation_list_table").load("donation_list_table.php", {
                type: "month"
            });
            clearInput();
        }

        function allData() {
            $("#donation_list_table").load("donation_list_table.php");
            clearInput();
        }


        // Filter
        function filter() {
            var input, filter, table, tr, td, i, sort;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            sort = document.getElementById("sort");
            console.log(sort.selectedIndex);

            for (i = 0; i < tr.length; i++) {
                // To filter different category ("td")[change me]
                td = tr[i].getElementsByTagName("td")[sort.selectedIndex - 1];

                if (td) {
                    txtValue = td.textContent || td.innerText;

                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Check DonationType and Sort
        window.onload = function () {
            sorting();
            updateDonationType();
        }

        // Sorting
        function sorting() {
            var input, table, tr, th, i;
            input = document.getElementById("sort");
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            th = tr[0].getElementsByTagName("th");
            for (i = 0; i < th.length - 2; i++) {
                const option = document.createElement("option");
                option.value = th[i].textContent;
                option.innerHTML = th[i].textContent;
                document.getElementById("sort").appendChild(option);
            }

            var action = "<?php echo $action?>";
            if (action != "") showActionModal();
        }

        // Clear Input
        function clearInput() {
            var input, sort;
            input = document.getElementById("myInput");
            sort = document.getElementById("sort");

            if (sort.selectedIndex) {
                input.value = "";
                filter();
            }
        }

        // Delete Button
        function onDelete(id) {
            document.getElementById("deleteDonationModal").style.display = "block";
            $('#deleteID').val(id);
        }

        // Edit button
        function onEdit(id) {
            document.getElementById("editDonationModal").style.display = "block";
            $.get("fetch_donation_list.php", { donationListID: id }, function (data) {
                console.log(data);
                $('#editID').val(id);
                $("[name = 'donorID']").val(data.donorID + " - " + data.donorName);
                $("[name = 'donationDate']").val(data.donationDate);
                $("[name = 'hemoglobinLevel']").val(data.hemoglobinLevel);
                $("[name = 'bloodDonationType']").val(data.bloodDonationType);
                $("[name = 'fluidVolume']").val(data.fluidVolume);
                $("[name = 'plateletVolume']").val(data.plateletVolume);
                $("[name = 'plasmaVolume']").val(data.plasmaVolume);
                $("[name = 'donationLocation']").val(data.donationLocation);
                // $("[name = 'locationid']").val(data.location + " - " + data.locationName);         //---    
                                                                                                      //  |
                // Perform remove current location option list, and update new location option list   //  |
                showLocation(data.donationLocation);                                                  //  |
                document.getElementById("location").value = data.location; 

                if (data.packedredcell != 0) {
                    $("[name = 'packedredcellvolume']").val(data.packedredcell); // fixed aphresis's problem
                }
                updateDonationType();

            }, "json").fail(() => alert("error"));
        }

        // Show Action Modal
        function showActionModal() {
            var input = document.getElementById("successModal");
            input.style.display = "block";
            setTimeout(() => {
                    input.style.display = "none";
                }, 3000)
            <?php $action = ""; ?>
        }

        // Auto calculate fluid volume
        function calculateVolume() {
            var volume = document.getElementsByName("fluidVolume")[0];
            var type = document.getElementById("bloodDonationType").value;
            var plasma = document.getElementsByName("plasmaVolume")[0].value;
            var platelet = document.getElementsByName("plateletVolume")[0].value;

            if(type === "W") { // if whole blood
                var redblood = document.getElementById("packedRedCell").value;
                volume.value = parseFloat(plasma) + parseFloat(platelet) + parseFloat(redblood);
            }else{ // else
                volume.value = parseFloat(plasma) + parseFloat(platelet);
            }  
        }

        // Update Location
        function updateLocation(donationLocation) {
            var input, location, table, tr, td, i;
            input = document.getElementById("locationType");
            location = document.getElementById("location");
            table = document.getElementById(donationLocation);
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                const option = document.createElement("option");
                option.value = td[0].textContent;
                option.innerHTML = td[0].textContent + " - " + td[1].textContent;
                document.getElementById("location").appendChild(option);
            }
        }

        // Show Location
        function showLocation(donationLocation) {
            var i, input;
            input = document.getElementById("location");
            for(i = input.options.length; i >= 0; i--) {
                input.remove(i);
            }
            updateLocation(donationLocation);
        }

        // Update Donation Type
        function updateDonationType() {
            var input, output;
            input = document.getElementById("bloodDonationType");
            output = document.getElementById("packedRedCell");
            // set default
            output.disabled = false;
            // index = 0 means Whole Blood Donation
            if (input.selectedIndex == 0) {
                output.disabled = false;
                // output.value = 0;
            } else {
                output.value = "";
                output.disabled = true;
                output.value = NaN;
            }
            calculateVolume();
        }
    </script>

</body>

</html>
