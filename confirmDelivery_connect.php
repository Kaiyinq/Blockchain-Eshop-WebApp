<?php 
// FOR CONFIRMSHIPPING.PHP AND CONFIRMDELIVERY.PHP

require('config.php');
session_start(); //start session

if(isset($_SESSION["buyerid"])) {
    $buyerid = $_SESSION["buyerid"];
    $orderid = mysqli_real_escape_string($conn, $_POST['orderId']);
    $confirm = mysqli_real_escape_string($conn, $_POST['confirm']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $img = file_get_contents($_FILES['file']['tmp_name']);

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $UPDATE = "UPDATE eshop.orders SET order_status = ?, order_deliveryok = ?, order_deliverycomment = ?, order_defectrefpic = ? WHERE order_id = ?";
        $stmt = $conn->prepare($UPDATE);
        $stmt->bind_param('sissi', $status, $confirm, $comment, $img, $orderid);
        $stmt->execute();

        $stmt->close();
        $conn->close(); 
    }
}

?>