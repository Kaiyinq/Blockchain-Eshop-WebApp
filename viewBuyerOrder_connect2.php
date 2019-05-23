<?php 
// FOR CONFIRMSHIPPING.PHP AND CONFIRMDELIVERY.PHP

require('config.php');
session_start(); //start session

if(isset($_SESSION["buyerid"])) {
    $buyerid = $_SESSION["buyerid"];
    $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);
    $status = "Cancelling";

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $UPDATE = "UPDATE eshop.orders SET order_status = ? WHERE order_id = ?";
        $stmt = $conn->prepare($UPDATE);
        $stmt->bind_param('si', $status, $orderId);
        $stmt->execute();

        $stmt->close();
        $conn->close(); 
    }
}

?>