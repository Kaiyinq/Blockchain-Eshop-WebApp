<?php
require('config.php');
session_start(); //start session

if(isset($_SESSION["buyerid"])) {
    $userid = $_SESSION["buyerid"];

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT user_fullname, user_email, user_address FROM eshop.users WHERE userid = ?";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {                 
                $fullname = $row["user_fullname"];   
                $email = $row["user_email"]; 
                $address = $row["user_address"];   
            }
        }else {
            die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
        }

        $stmt->close();
        $conn->close();        
    }
} else {
    die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
}
?>