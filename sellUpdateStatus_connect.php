<?php
// THE PRODUCT RATING HERE IS THE OVERALL POINTS THAT GOT ADD UP AT PRODREVIEW TABLE 
require('config.php');
session_start(); //start session

if(isset($_SESSION["sellerid"])) {
    $sellerid = $_SESSION["sellerid"];
    $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);
    $orderstatus = "Shipping";
    $dateTime = mysqli_real_escape_string($conn, $_POST['dateTime']);
    $img = file_get_contents($_FILES['file']['tmp_name']);

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $UPDATE = "UPDATE eshop.orders SET order_status = ?, order_shippingDate = ?, order_refpic = ? WHERE order_id = ?";
        $stmt = $conn->prepare($UPDATE);
        $stmt->bind_param('sssi', $orderstatus, $dateTime, $img, $orderId);
        $stmt->execute();

        $stmt->close();
        $conn->close(); 
    }
}

?>