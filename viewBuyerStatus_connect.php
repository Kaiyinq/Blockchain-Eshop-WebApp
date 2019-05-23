<?php
// THE PRODUCT RATING HERE IS THE OVERALL POINTS THAT GOT ADD UP AT PRODREVIEW TABLE 
require('config.php');
session_start(); //start session

if (isset($_SESSION["sellerid"])) {
    $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT order_status, order_shipok, order_shipcomment, order_deliveryok, order_deliverycomment, order_contractAdd
                    FROM eshop.orders 
                    WHERE order_id = ?";
    
        if ($stmt = $conn->prepare($SELECT)) {
            $stmt->bind_param('i', $orderId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                if ($row = $result->fetch_assoc()) {
                    
                    $orderStatus = $row["order_status"];
                    $orderShipOk = $row["order_shipok"];
                    $orderShipComment = $row["order_shipcomment"];
                    $orderDeliveryOk = $row["order_deliveryok"];
                    $orderDeliveryComment = $row["order_deliverycomment"];
                    $orderContractAdd = $row["order_contractAdd"];

                    $details = array('orderShipOk'=>$orderShipOk, 'orderShipComment'=>$orderShipComment, 'orderDeliveryOk'=>$orderDeliveryOk, 'orderDeliveryComment'=>$orderDeliveryComment, 'orderContractAdd'=>$orderContractAdd);
                    echo json_encode($details);
                    
                }
            }
           
            $stmt->close();
    
        }
        $conn->close();
    }
}

?>