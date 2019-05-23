<?php 
// FOR CONFIRMSHIPPING.PHP AND CONFIRMDELIVERY.PHP

require('config.php');
session_start(); //start session

if(isset($_SESSION["buyerid"])) {
    $buyerid = $_SESSION["buyerid"];
    $username = $_SESSION["username"];
    $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT order_status, order_date, order_quantity, order_contractAdd, o.prod_id, 
                    prod_name, prod_price, prod_desc, buyerUser.user_address, buyerUser.username AS buyerName, 
                    sellerUser.username AS sellerName, seller_shopname, seller_shopphone 
                    FROM eshop.orders o
                    LEFT JOIN eshop.products p
                    ON o.prod_id = p.prod_id
                    LEFT JOIN eshop.users buyerUser
                    ON o.userid = buyerUser.userid
                    LEFT JOIN eshop.seller s
                    ON p.seller_id = s.seller_id
                    LEFT JOIN eshop.users sellerUser
                    on s.userid = sellerUser.userid
                    WHERE order_id = ?";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // seller
            $shopName = $row["seller_shopname"];
            $shopNum = $row["seller_shopphone"];
            $sellerUsername = $row["sellerName"];

            // orders
            $orderStatus = $row["order_status"];
            $orderDate = $row["order_date"];
            $orderQuantity = $row["order_quantity"];
            $orderContractAdd = $row["order_contractAdd"];

            // users
            $buyerAdd = $row["user_address"];

            // product
            $prodId = $row["prod_id"];
            $prodName = $row["prod_name"];
            $prodPrice = $row["prod_price"];
            $prodDesc = $row["prod_desc"];

            $details = array('orderStatus'=>$orderStatus, 'orderDate'=>$orderDate, 
                        'orderQuantity'=>$orderQuantity, 'orderContractAdd'=>$orderContractAdd, 
                        'shopName'=>$shopName, 'shopNum'=>$shopNum, 'buyerAdd'=>$buyerAdd, 'prodName'=>$prodName, 
                        'prodDesc'=>$prodDesc, 'prodId'=>$prodId, 'username'=>$username, 'sellerUsername' => $sellerUsername);
            echo json_encode($details);
            
        }

        $stmt->close();

        $conn->close(); 
    }
}

?>