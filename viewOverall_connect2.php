<?php 
// FOR CONFIRMSHIPPING.PHP AND CONFIRMDELIVERY.PHP

require('config.php');
session_start(); //start session

if(isset($_SESSION["sellerid"])) {
    $sellerid = $_SESSION["sellerid"];
    $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);
    $rejectSlip = mysqli_real_escape_string($conn, $_POST['rejectSlip']);
    $orderStatus = mysqli_real_escape_string($conn, $_POST['orderStatus']);

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $UPDATE = "UPDATE eshop.orders SET order_status = ?, order_acceptRejectSlip = ? WHERE order_id = ?";
        $stmt = $conn->prepare($UPDATE);
        $stmt->bind_param('sii', $orderStatus, $rejectSlip, $orderId);
        $stmt->execute();

        $stmt->close();
        $conn->close(); 
    }
}

?>