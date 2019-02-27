<?php
require('config.php');
session_start(); //start session

if(isset($_SESSION["buyerid"])) {
    $userid = $_SESSION["buyerid"];
    $account = mysqli_real_escape_string($conn, $_POST['accountType']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $emailAdd = mysqli_real_escape_string($conn, $_POST['emailAdd']);

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $INSERT = "INSERT INTO eshop.seller (seller_shoptype, seller_shopname, seller_shopphone, seller_shopemail, userid) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($INSERT)) {
            //prepared statement
            $stmt->bind_param('ssisi', $account, $name, $phone, $emailAdd, $userid);
            $stmt->execute();
            
            echo "Seller account created!";

            $stmt->close();
        }

        $conn->close();        
    }
} else {
    die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
}
?>