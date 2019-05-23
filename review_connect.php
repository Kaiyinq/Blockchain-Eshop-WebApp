<?php 
// FOR CONFIRMSHIPPING.PHP AND CONFIRMDELIVERY.PHP

require('config.php');
session_start(); //start session

if(isset($_SESSION["buyerid"])) {
    $buyerid = $_SESSION["buyerid"];
    $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);
    $review = mysqli_real_escape_string($conn, $_POST['review']);
    $value = mysqli_real_escape_string($conn, $_POST['value']);
    $dateTime = mysqli_real_escape_string($conn, $_POST['dateTime']);
    $prodId = mysqli_real_escape_string($conn, $_POST['prodId']);

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $UPDATE = "INSERT INTO eshop.prodreview (review_date, review_stars, review_comment, order_id, prod_id) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($UPDATE);
        $stmt->bind_param('sisi', $dateTime, $value, $review, $orderId, $prodId);
        $stmt->execute();

        $stmt->close();
        $conn->close(); 
    }
}

?>