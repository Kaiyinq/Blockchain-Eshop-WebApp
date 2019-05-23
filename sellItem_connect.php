<?php
require('config.php');
session_start(); //start session

if(isset($_SESSION["buyerid"])) {
    $userid = $_SESSION["buyerid"];

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT category_id, category_name FROM eshop.category";
        $stmt = $conn->prepare($SELECT);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resultIn = true;
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