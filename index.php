<!-- Can login using any Employee ID (No password validation) -->
<!-- phpmyadmin username: root -->
<!-- phpmyadmin password: Root@123 -->
<!-- SET GLOBAL FOREIGN_KEY_CHECKS=0 -->

<?php
    include 'connect.php';

    if (isset($_POST['Login'])) {
        $empID = $_POST['empID'];
        $sql = "SELECT * FROM medical_officer WHERE EmpID = '$empID'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_array($result);
            if ($row != NULL) {
                redirect($empID);
            } else {
                echo 'Invalid Employee ID';
            }
        } else {
            echo 'Error: ' . $sql . '<br/>' . mysqli_error($conn);
        }
    }

    mysqli_close($conn);

     // Redirect function
     function redirect($empID) {
        echo $url;
        ob_start();
        header('Location: ./dashboard.php?empID=' . $empID);
        ob_end_flush();
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>BDMS Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
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
    </style>
</head>

<body class="w3-light-grey">
    <div class="w3-container w3-display-middle" style="width: 40%; min-width: 400px; max-width: 600px">

        <div class="w3-card-4 w3-white w3-round">
            <div class="w3-container w3-dark-grey">
                <h5>Blood Donation Management System</h5>
            </div>

            <form class="w3-row-padding" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="w3-row-padding w3-padding-16">
                    <label>Employee ID</label>
                    <input class="w3-input" type="text" name="empID" required>
                </div>
                <div class="w3-row-padding w3-padding-16">
                    <label>Password</label>
                    <input class="w3-input" type="password" name="password" required>
                </div>
                <div class="w3-row-padding">
                    <b><input type="submit" class="w3-btn w3-block w3-round w3-green" value="Login" name="Login"></input></b>
                </div>
                <br>
            </form>
        </div>
    </div>
</body>

</html>