<?php
    if(isset($_POST['delete'])){
        $id = $_POST['deleteID'];

        $sql = "DELETE FROM donor where DonorID = '$id'";
        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

?>