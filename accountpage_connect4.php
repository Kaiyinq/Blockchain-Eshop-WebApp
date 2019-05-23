<?php
require('config.php');
session_start(); //start session

if(isset($_SESSION["buyerid"])) {
    $userid = $_SESSION["buyerid"];

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT order_id, order_status, order_shipok, order_date, order_quantity, prod_name, prod_price, prod_pic
                    FROM eshop.orders o 
                    LEFT JOIN eshop.products p ON o.prod_id = p.prod_id 
                    WHERE o.userid = ?";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { 
                $orderId = $row["order_id"];                
                $orderStatus = $row["order_status"];  
                $orderShipOk = $row["order_shipok"]; 
                $orderDate = $row["order_date"]; 
                $orderQuantity = $row["order_quantity"];  
                
                $prodName = $row["prod_name"];   
                $prodPrice = $row["prod_price"]; 

                $totalPrice = $prodPrice * $orderQuantity;

                // <!-- ORDER STATUS - SHIPPING -->
                if ($orderStatus == "Shipping") {
                    echo "<tr>";
                    echo "<td class='thumb'>";
                    echo '<img src="data:image/jpeg;base64,'.base64_encode($row['prod_pic']).'"/>';
                    echo "</td>";
                    echo "<td class='details'>";
                    echo "<a href='#'>$prodName</a>";
                    echo "<ul>";
                    echo "<li><span>Order Date: $orderDate</span></li>";
                    echo "<li><span>Order Status: $orderStatus</span></li>";
                    echo "</ul>";
                    echo "</td>";
                    echo "<td class='price text-center'><strong>$$prodPrice</strong></td>";
                    echo "<td class='qty text-center'><span>$orderQuantity</span></td>";
                    echo "<td class='total text-center'><strong class='primary-color'>$$totalPrice</strong></td>";
                    
                    if ($orderShipOk == 1) {
                        $url2 = "confirmDelivery.php?order=$orderId";
                        echo "<td class='text-center'><a href=$url2>Confirm Delivery</a></td>";
                    } else {
                        $url = "confirmShipping.php?order=$orderId";
                        echo "<td class='text-center'><a href=$url>Confirm Shipping</a></td>";
                    }
                    //echo "<td class='text-center'><a href='javascript:myFunction()'>Confirm Delivery</a></td>";
                    echo "</tr>";
                }
               
            }
        }

        $stmt->close();
        $conn->close();        
    }
}
?>