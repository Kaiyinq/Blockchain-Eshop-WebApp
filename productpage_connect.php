<?php
// THE PRODUCT RATING HERE IS THE OVERALL POINTS THAT GOT ADD UP AT PRODREVIEW TABLE 
require('config.php');
session_start(); //start session

$prodId = isset($_GET['prod']) ? $_GET['prod'] : '';

if (mysqli_connect_error()) {
    die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
} else {
    $SELECT1 = "SELECT prod_name, prod_price, prod_quantity, prod_pic, prod_shipmethod, prod_desc, seller_id, count(review_id) AS numReview, SUM(review_stars) AS total, prod_contractAdd
                FROM eshop.products prod
                LEFT JOIN eshop.prodreview prodr ON prod.prod_id = prodr.prod_id
                WHERE prod.prod_id = ?";

    if ($stmt = $conn->prepare($SELECT1)) {
        //prepared statement
        $stmt->bind_param('i', $prodId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                
                $prodName = $row["prod_name"];
                $prodPrice = $row["prod_price"];
                $prodQuantity = $row["prod_quantity"];
                $prodShipMethod = $row["prod_shipmethod"];
                $prodDesc = $row["prod_desc"];
                $prodPic = $row["prod_pic"];
                $prodContractAdd = $row["prod_contractAdd"];

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

                //$prodDetails = array('prodID'=>2, 'prodName'=>$prodName, 'prodPrice'=>$prodPrice);
                //echo json_encode($prodDetails);

                $_SESSION["prodContractAdd"] = $prodContractAdd;
                $_SESSION["prodPrice"] = $prodPrice;
            }
        }
       
        $stmt->close();

        // FOR REVIEW SECTION
        // $SELECT2 = "SELECT prod_name, prod_price, prod_quantity, prod_pic, prod_shipmethod, prod_desc, seller_id, count(review_id) AS numReview, SUM(review_stars) AS total
        // FROM eshop.products prod
        // LEFT JOIN eshop.prodreview prodr ON prod.prod_id = prodr.prod_id
        // WHERE prod.prod_id = ?";

        // $stmt2 = $conn->prepare($SELECT2);
        // $stmt2->bind_param('i', $prodId);
        // $stmt2->execute();
        // $result2 = $stmt2->get_result();
        // if ($result2->num_rows > 0) {
        //     while ($row2 = $result2->fetch_assoc()) {
        //         // UNDONE DISPLAY REVIEW PORTION
        //     }
        // }
        
        // $stmt2->close();

    }
    $conn->close();
}

?>