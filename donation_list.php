<?php
    include 'connect.php';

    $empID = $_GET['empID'];
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

    // Get Donor Sum
    $donorSum = 0;
    $sql = "SELECT * FROM donor";

    if ($result = mysqli_query($conn,$sql))
        $donorSum = mysqli_num_rows($result);

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
            <a href="./donation_list.php?empID=<?php echo $empID ?>" class="w3-bar-item w3-button w3-padding w3-teal"><i class="fa fa-users fa-fw"></i>  Donation
                List</a><br><br>
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
                <select class="w3-select w3-border w3-quarter w3-row-padding" style="margin-right:16px; height:40.5px" id="sort" name="filter" onchange="clearInput()">
                    <option value="" disabled selected>Sort by</option>
                </select>
                <div class="w3-rest">
                    <input class="w3-input w3-border w3-rest" type="text"
                    placeholder="Search" id="myInput" onkeyup="filter()">
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
        </div>

        <!-- End page content -->
    </div>

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

        // idk how to name this XD
        function month() {
            $( "#donation_list_table" ).load("donation_list_table.php", {type: "month"});
        }

        function allData() {
            $( "#donation_list_table" ).load("donation_list_table.php");
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

        // Sort by
        window.onload = function sortBy() {
            var input, table, tr, th, i;
            input = document.getElementById("sort");
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            th = tr[0].getElementsByTagName("th");
            for (i = 0; i < th.length; i++) {
                const option = document.createElement("option");
                option.value = th[i].textContent;
                option.innerHTML = th[i].textContent;
                document.getElementById("sort").appendChild(option);
            }
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
    </script>

</body>

</html>