<?php 
// FOR CONFIRMSHIPPING.PHP AND CONFIRMDELIVERY.PHP

require('config.php');
session_start(); //start session

if(isset($_SESSION["sellerid"])) {
    $sellerid = $_SESSION["sellerid"];
    $orderid = mysqli_real_escape_string($conn, $_POST['orderId']);

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT order_status, order_shipok, order_shipcomment, order_deliveryok, order_deliverycomment, 
                    order_acceptRejectSlip, order_date, order_quantity, order_contractAdd, 
                    order_refpic, order_shippingDate, order_defectrefpic, prod_name, prod_price, user_fullname, user_address, username
                    FROM eshop.orders o
                    LEFT JOIN eshop.products p
                    ON o.prod_id = p.prod_id
                    LEFT JOIN eshop.users u
                    ON o.userid = u.userid
                    WHERE order_id = ?";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param('i', $orderid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // orders
            $orderStatus = $row["order_status"];
            $orderShipOk = $row["order_shipok"];
            $orderShipComment = $row["order_shipcomment"];
            $orderDeliveryOk = $row["order_deliveryok"];
            $orderDeliveryComment = $row["order_deliverycomment"];
            $orderDate = $row["order_date"];
            $orderQuantity = $row["order_quantity"];
            $orderContractAdd = $row["order_contractAdd"];
            $orderRefPic = $row["order_refpic"];
            $orderShippingDate = $row["order_shippingDate"];
            $orderDefectRefPic = $row["order_defectrefpic"];
            $orderAcceptRejectSlip = $row["order_acceptRejectSlip"];

            // users
            $buyerName = $row["user_fullname"];
            $buyerAdd = $row["user_address"];
            $username = $row["username"];

            // product
            $prodName = $row["prod_name"];
            $prodPrice = $row["prod_price"];

            $details = array('orderStatus'=>$orderStatus,'orderShipOk'=>$orderShipOk, 'orderShipComment'=>$orderShipComment, 
                        'orderDeliveryOk'=>$orderDeliveryOk, 'orderDeliveryComment'=>$orderDeliveryComment, 'orderDate'=>$orderDate, 
                        'orderQuantity'=>$orderQuantity, 'orderContractAdd'=>$orderContractAdd, 'orderShippingDate'=>$orderShippingDate, 
                        'orderRefPic'=>base64_encode($orderRefPic), 'orderDefectRefPic'=>base64_encode($orderDefectRefPic),
                        'buyerName'=>$buyerName, 'buyerAdd'=>$buyerAdd, 'buyerNum'=>$username, 'prodName'=>$prodName,
                        'orderAcceptRejectSlip'=>$orderAcceptRejectSlip);
            echo json_encode($details);
            
        }

        $stmt->close();

        $conn->close(); 
    }
}

?>