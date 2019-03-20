<?php
require('config.php');
session_start(); //start session

if(isset($_SESSION["buyerid"])) {
    $userid = $_SESSION["buyerid"];

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT order_id, order_status, order_date, order_quantity, prod_name, prod_price, prod_pic
                    FROM eshop.orders o 
                    LEFT JOIN eshop.products p ON o.prod_id = p.prod_id 
                    WHERE o.userid = ?";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {                 
                $orderStatus = $row["order_status"];   
                $orderDate = $row["order_date"]; 
                $orderQuantity = $row["order_quantity"];  
                
                $prodName = $row["prod_name"];   
                $prodPrice = $row["prod_price"]; 

                $totalPrice = $prodPrice * $orderQuantity;
                if ($orderStatus == "Processing") {
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
                    echo "</tr>";
                }
               
            }
        }else {
            die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
        }

        $stmt->close();
        $conn->close();        
    }
} else {
    die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
}
?>