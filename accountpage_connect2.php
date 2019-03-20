<?php
require('config.php');
session_start(); //start session

if(isset($_SESSION["buyerid"])) {
    $userid = $_SESSION["buyerid"];
    $count = 0;

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        // SELLER ACCOUNT
        $SELECT = "SELECT seller_id, seller_shopname, seller_shopemail FROM eshop.seller WHERE userid = ?";
        if ($stmt = $conn->prepare($SELECT)) {
            $stmt->bind_param('i', $userid);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {                 
                    $sellerid = $row["seller_id"]; 
                    $shopName = $row["seller_shopname"];  
                    $shopEmail = $row["seller_shopemail"];      
                    
                    if ($sellerid != null) {
                        echo "<div class='section-title'>";
					    echo "<h4 class='title'>Seller account</h4>";
                        echo "</div>";
                        echo "<div class='personal-info'>";
                        echo "<div class='row'>";
                        echo "<div class='col-md-3'>";
                        echo "<h5 class='title'>Shop Info</h5>";
                        echo "</div>";
                        echo "<div class='col-md-3'>";
                        echo "<p>";
                        echo $shopName; 
                        echo "<br>";
                        echo $shopEmail;
                        echo "<br>";
                        echo "<a href='sellItem.php'><i class='fa fa-plus-circle'></i> Sell Item</a>";
                        echo "</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='row'>";
                        echo "<div class='col-md-8'>";
                        echo "<div class='myorders-tab'>";
                        echo "<ul class='tab-nav'>";
                        echo "<li class='active'><a data-toggle='tab' href='#tab4'>Orders Received</a></li>";
                        echo "<li><a data-toggle='tab' href='#tab5'>All Products</a></li>";
                        echo "</ul>";
                        echo "<div class='tab-content'>";
                        echo "<div id='tab4' class='tab-pane fade in active'>";
                        echo "<table class='shopping-cart-table table'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Order</th>";
                        echo "<th></th>";
                        echo "<th class='text-center'>Quantity</th>";
                        echo "<th class='text-right'></th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        // <!-- ALL ORDERS LIST -->
                        $SELECT3 = "SELECT prod_name, prod_pic, user_fullname, user_address, order_quantity, order_date, order_status 
                                    FROM eshop.products p
                                    JOIN eshop.orders o 
                                    ON o.prod_id = p.prod_id 
                                    JOIN eshop.users u
                                    ON o.userid = u.userid
                                    WHERE seller_id = ?";
                        $stmt3 = $conn->prepare($SELECT3);
                        $stmt3->bind_param('i', $sellerid);
                        $stmt3->execute();
                        $result3 = $stmt3->get_result();
                        if ($result3->num_rows > 0) {
                            while ($row3 = $result3->fetch_assoc()) {
                                $prodName = $row3["prod_name"];
                                $orderQuantity = $row3["order_quantity"];
                                $orderDate = $row3["order_date"];;
                                $orderStatus = $row3["order_status"];
                                $orderUsername  = $row3["user_fullname"];
                                $orderUserAdd  = $row3["user_address"];

                                echo "<tr>";
                                echo "<td class='thumb'>";
                                echo '<img src="data:image/jpeg;base64,'.base64_encode($row3['prod_pic']).'"/>';
                                echo "</td>";
                                echo "<td class='details'>";
                                echo "<a href='#'>$prodName</a>";
                                echo "<ul>";
                                echo "<li><span>Order By: $orderUsername</span></li>";
                                echo "<li><span>Ship To: $orderUserAdd</span></li>";
                                echo "<li><span>Order Date: $orderDate</span></li>";
                                echo "<li><span>Order Status: $orderStatus</span></li>";
                                echo "</ul>";
                                echo "</td>";
                                echo "<td class='qty text-center'><strong>$orderQuantity</strong></td>";
                                echo "</tr>";
                            }
                        }
                        //<!-- /ALL ORDERS LIST --> 
                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                        echo "<div id='tab5' class='tab-pane fade in'>";
                        echo "<table class='shopping-cart-table table'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Product</th>";
                        echo "<th></th>";
                        echo "<th class='text-center'>Quantity</th>";
                        echo "<th class='text-center'>Price</th>";
                        echo "<th class='text-right'></th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        // <!-- ALL SELLING PRODUCTS LIST -->
                        $SELECT2 = "SELECT prod_name, prod_price, prod_quantity, prod_pic FROM eshop.products WHERE seller_id = ?";
                        $stmt2 = $conn->prepare($SELECT2);
                        $stmt2->bind_param('i', $sellerid);
                        $stmt2->execute();
                        $result2 = $stmt2->get_result();
                        if ($result2->num_rows > 0) {
                            while ($row2 = $result2->fetch_assoc()) {
                                $prodName = $row2["prod_name"];
                                $prodPrice = $row2["prod_price"];
                                $prodQuantity = $row2["prod_quantity"];

                                echo "<tr>";
                                echo "<td class='thumb'>";
                                echo '<img src="data:image/jpeg;base64,'.base64_encode($row2['prod_pic']).'"/>';
                                echo "</td>";
                                echo "<td class='details'>";
                                echo "<a href='#'>$prodName</a>";
                                echo "</td>";
                                echo "<td class='qty text-center'><strong>$prodQuantity</strong></td>";
                                echo "<td class='price text-center'><strong>$$prodPrice</strong></td>";
                                echo "</tr>";
                            }
                        }
                        //<!-- /ALL SELLING PRODUCTS LIST -->
                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    } 
                }
            }else {
                die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
            }

            $stmt->close();
            $stmt2->close();
        }

        $conn->close();        
    }
} else {
    die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
}
?>