<?php 
// FOR CONFIRMSHIPPING.PHP AND CONFIRMDELIVERY.PHP

require('config.php');
session_start(); //start session

if(isset($_SESSION["buyerid"])) {
    $buyerid = $_SESSION["buyerid"];
    $orderid = mysqli_real_escape_string($conn, $_POST['orderId']);

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT order_contractAdd, order_refpic, order_shippingDate FROM eshop.orders WHERE order_id = ?";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param('i', $orderid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $orderContractAdd = $row["order_contractAdd"];
            $orderRefPic = $row["order_refpic"];
            $orderShippingDate = $row["order_shippingDate"];

            $details = array('orderContractAdd'=>$orderContractAdd, 'orderShippingDate'=>$orderShippingDate, 'orderRefPic'=>base64_encode($orderRefPic));
            echo json_encode($details);
            
        }

        $stmt->close();

        $conn->close(); 
    }
}

?>