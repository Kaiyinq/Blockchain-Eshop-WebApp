<?php
 
require('config.php');
session_start(); //start session

if(isset($_SESSION["sellerid"])) {
    $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT order_contractAdd FROM eshop.orders WHERE order_id = ?";
        $stmt2 = $conn->prepare($SELECT);
        $stmt2->bind_param('i', $orderId);
        $stmt2->execute();
        $result = $stmt2->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $orderContractAdd = $row["order_contractAdd"];
            echo $orderContractAdd;
        }

        $stmt2->close();

        $conn->close(); 
    }
}

?>