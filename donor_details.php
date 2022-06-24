<?php
    include 'connect.php';
    // For the use of Success Modal
    $action = "";

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

    include 'delete_donor.php';
    include 'edit_donor.php';

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.5.1/css/flag-icons.min.css"
        integrity="sha512-uvXdJud8WaOlQFjlz9B15Yy2Au/bMAvz79F7Xa6OakCl2jvQPdHD0hb3dEqZRdSwG4/sknePXlE7GiarwA/9Wg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            padding: 0;
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
            <a href="./donor_details.php?empID=<?php echo $empID ?>" class="w3-bar-item w3-button w3-padding w3-teal"><i
                    class="fa fa-eye fa-fw"></i>  Donor Details</a>
            <a href="./donation_list.php?empID=<?php echo $empID ?>" class="w3-bar-item w3-button w3-padding"><i
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
            <h5><b><i class="fa fa-file-text-o"></i> All Donor Details</b></h5>

            <div class="w3-panel w3-padding-0 w3-row">
                <select class="w3-select w3-border w3-quarter w3-row-padding" style="margin-right:16px; height:40.5px"
                    id="sort" name="filter" onchange="clearInput()">
                    <option value="" disabled selected>Sort by</option>
                </select>
                <div class="w3-rest">
                    <input class="w3-input w3-border" type="text" placeholder="Search" id="myInput" onkeyup="filter()">
                </div>
            </div>

            <br>
            <div class="w3-card-4 w3-white">
                <div class="w3-responsive">
                    <table class="w3-table-all" id="myTable">
                        <tr class="w3-dark-grey">
                            <th>Name</th>
                            <th>IC/Passport No</th>
                            <th>Weight</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>Phone No</th>
                            <th>Nationality</th>
                            <th>Last Donation</th>
                            <th>Frequency</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php
                            include 'connect.php';
                            $counter = 0;
                            $sql = "SELECT * FROM donor";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>$row[1]</td>";
                                echo "<td>$row[2]</td>";
                                echo "<td>$row[3]</td>";
                                echo "<td>$row[4]</td>";
                                echo "<td>$row[5]</td>";
                                echo "<td>+60$row[6]</td>";
                                echo "<td>$row[9]</td>";
                                echo "<td>$row[10]</td>";
                                echo "<td>$row[11]</td>";
                                echo "<td><button onclick=onEdit($row[0]) class=\"w3-btn w3-round w3-teal\">Edit</button></td>";
                                echo "<td><button onclick=onDelete($row[0]) class=\"w3-btn w3-round w3-teal\">Delete</button></td>";
                                echo "</tr>";
                            }
                            mysqli_close($conn);
                        ?>
                    </table>
                </div>

                <!-- Edit Modal -->
                <div id="editDonorModal" class="w3-modal">
                    <div class="w3-modal-content w3-card-4 w3-animate-top">
                        <header class="w3-container w3-dark-gray">
                            <span onclick="document.getElementById('editDonorModal').style.display='none'"
                                class="w3-button w3-display-topright"><i class="fa fa-times"></i></span>
                            <h2>Edit Donor Details</h2>
                        </header>
                        <div class="w3-container" id="editform">
                            <form class='w3-row-padding' action="" method='POST'>
                                <input type="hidden" id="editID" name="editID">
                                <div class='w3-half w3-padding-16'>
                                    <label>First Name</label>
                                    <input class='w3-input' name='donorFN' type='text' required>
                                </div>
                                <div class='w3-half w3-padding-16'>
                                    <label>Last Name</label>
                                    <input class='w3-input' name='donorLN' type='text' required>
                                </div>
                                <div class='w3-quarter w3-padding-16'>
                                    <label>Weight</label>
                                    <input class='w3-input' name='donorWeight' type='text' required>
                                </div>
                                <div class='w3-quarter w3-padding-16'>
                                    <label>Age</label>
                                    <input class='w3-input' name='donorAge' type='text' required>
                                </div>
                                <div class='w3-quarter w3-padding-16'>
                                    <label>Sex</label>
                                    <select class='w3-select' name='donorSex' required>
                                        <option value='M' selected>Male</option>
                                        <option value='F'>Female</option>
                                    </select>
                                </div>
                                <div class='w3-quarter w3-padding-16'>
                                    <label>Blood Type</label>
                                    <select class='w3-select' name='donorbloodtype' required>
                                        <option value='A+' selected>A+</option>
                                        <option value='A-'>A-</option>
                                        <option value='B+'>B+</option>
                                        <option value='B-'>B-</option>
                                        <option value='AB+'>AB+</option>
                                        <option value='AB-'>AB-</option>
                                        <option value='O+'>O+</option>
                                        <option value='O-'>O-</option>
                                    </select>
                                </div>
                                <div class='w3-row-padding w3-padding-16'>
                                    <label>Home Address</label>
                                    <input class='w3-input' name='donorAddress' type='text' required>
                                </div>
                                <div class='w3-twothird w3-padding-16'>
                                    <label>Identity Card No / Passport No</label>
                                    <input class='w3-input' name='donorIC' type='text' required>
                                </div>
                                <div class='w3-third w3-padding-16'>
                                    <div><label>Phone No</label></div>
                                    <div class='w3-cell w3-quarter w3-input'>
                                        <span class="fi fi-my"></span> +60
                                    </div>
                                    <div class='w3-cell w3-threequarter'>
                                        <input class='w3-input' name='donorPhone' type='text' required>
                                    </div>
                                </div>
                                <div class='w3-half w3-padding-16'>
                                    <label>Email</label>
                                    <input class='w3-input' name='donorEmail' type='text' required>
                                </div>
                                <div class='w3-half w3-padding-16'>
                                    <label>Nationality</label>
                                    <select class='w3-select' name='nationality' required>
                                        <option value='Malaysian' selected>Malaysian</option>
                                        <option value='Others'>Others</option>
                                    </select>
                                </div>
                                <div class='w3-row-padding'>
                                    <b><input type='submit' class='w3-btn w3-block w3-round w3-green' id="editDonor" name='editDonor'
                                            value='Edit Donor'></input></b>
                                </div>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal-->
                <div id="deleteDonorModal" class="w3-modal">
                    <div class="w3-modal-content w3-card-4 w3-animate-top">
                        <header class="w3-container w3-dark-gray">
                            <span onclick="document.getElementById('deleteDonorModal').style.display='none'"
                                class="w3-button w3-display-topright"><i class="fa fa-times"></i></span>
                            <h2>Delete Donor</h2>
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
                            <h5><?php if ($action == "Edit") { echo "Donor details is updated"; } else { echo 'This donor is deleted'; }; ?>!</h5>
                        </div>
                    </div>
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

        // Filter
        function filter() {
            var input, filter, table, tr, td, i, sort;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            sort = document.getElementById("sort");

            for (i = 0; i < tr.length; i++) {
                // To filter different category ("td")[change me]
                td = tr[i].getElementsByTagName("td")[sort.selectedIndex - 1];
                console.log(td);
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

        //delete button (need this to pass the id, cuz we not displaying id in the table right now)
        function onDelete(id) {
            document.getElementById("deleteDonorModal").style.display = "block";
            $('#deleteID').val(id);
        }

        // edit button
        function onEdit(id) {
            document.getElementById("editDonorModal").style.display = "block";
            $.get("fetch_donor.php", {
                donorID: id
            }, function (data) {
                $("[name = 'donorFN']").val(data.fname);
                $("[name = 'donorLN']").val(data.lname);
                $("[name = 'donorWeight']").val(data.weight);
                $("[name = 'donorAge']").val(data.age);
                $("[name = 'donorSex']").val(data.sex);
                $("[name = 'donorbloodtype']").val(data.bloodtype);
                $("[name = 'donorAddress']").val(data.address);
                $("[name = 'donorIC']").val(data.ic);
                $("[name = 'donorPhone']").val(data.phone);
                $("[name = 'donorEmail']").val(data.email);
                $("[name = 'nationality']").val(data.nationality);
                $('#editID').val(id);
            }, "json").fail(function () {
                alert("error");
            });
        }

        // Sort by
        window.onload = function () {
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

        // Show Action Modal
        function showActionModal() {
            var input = document.getElementById("successModal");
            input.style.display = "block";
            setTimeout(() => {
                input.style.display = "none";
            }, 3000)
            <?php $action = ""; ?>
        }
    </script>

</body>

</html>