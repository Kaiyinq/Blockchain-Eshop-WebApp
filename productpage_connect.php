<?php
// THE PRODUCT RATING HERE IS THE OVERALL POINTS THAT GOT ADD UP AT PRODREVIEW TABLE 
require('config.php');
session_start(); //start session

$prodId = isset($_GET['prod']) ? $_GET['prod'] : '';
if (mysqli_connect_error()) {
    die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
} else {
    $SELECT1 = "SELECT prod_name, prod_price, prod_quantity, prod_pic, prod_shipmethod, prod_desc, seller_id, count(review_id) AS numReview, SUM(review_stars) AS total
                FROM eshop.products prod
                LEFT JOIN eshop.prodreview prodr ON prod.prod_id = prodr.prod_id
                WHERE prod.prod_id = ?";

    if ($stmt = $conn->prepare($SELECT1)) {
        $stmt->bind_param('i', $prodId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                
                $prodsellerId = $row["seller_id"];
                $prodName = $row["prod_name"];
                $prodPrice = $row["prod_price"];
                $prodQuantity = $row["prod_quantity"];
                $prodShipMethod = $row["prod_shipmethod"];
                $prodDesc = $row["prod_desc"];
                $prodPic = $row["prod_pic"];

                $numReview = $row["numReview"];
                $totalRating = $row["total"];
                if ($numReview > 0) {
                    $overallRating = $totalRating/$numReview;
                } else {
                    $overallRating= 0;
                }

                if (($overallRating%1) <= 0.5) {
                    $overallRating = floor($overallRating);
                }else {
                    $overallRating = ceil($overallRating);
                }
                $prodrating = $overallRating;

                // $prodDetails = array('prodsellerId'=>$prodsellerId, 'prodName'=>$prodName, 'prodQuantity'=>$prodQuantity, 'prodContractAdd'=>$prodContractAdd, 'prodPrice'=>$prodPrice);
                // echo json_encode($prodDetails);

                $_SESSION["prodSellerId"] = $prodsellerId;
                $_SESSION["prodPrice"] = $prodPrice;
            }
        }
       
        $stmt->close();

    }
    $conn->close();
}

?>