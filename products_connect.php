<!-- THE PRODUCT RATING HERE IS THE OVERALL POINTS THAT GOT ADD UP AT PRODREVIEW TABLE -->

<?php
require('config.php');

$category = 6; //UNDONE (HOME PAGE LINK TO THIS)
$rating = 0;

if (mysqli_connect_error()) {
    die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
} else {
    $QUERY = "SELECT prod_id, prod_name, prod_price, prod_color, prod_size, prod_brand, prod_pic, prod_rating 
                FROM eshop.products WHERE category_id = ?";

    if ($stmt = $conn->prepare($QUERY)) {
        //prepared statement
        $stmt->bind_param('i', $category);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
                $prodID = $row["prod_id"];
                $QUERY2 = "SELECT count(review_id) AS numReview, SUM(review_stars) AS total
                            FROM eshop.prodreview WHERE prod_id = ?";

                if ($stmt2 = $conn->prepare($QUERY2)) {
                    //prepared statement
                    $stmt2->bind_param('i', $prodID);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                            $numReview = $row2["numReview"];
                            $totalRating = $row2["total"];
                            if ($numReview > 0) {
                                $GLOBALS['overallRating'] = $totalRating/$numReview;
                            } else {
                                $GLOBALS['overallRating'] = 0;
                            }
                        }
                        $rating = 0;
                    }
                    if (($GLOBALS['overallRating']%1) <= 0.5) {
                        $GLOBALS['overallRating'] = floor($GLOBALS['overallRating']);
                    }else {
                        $GLOBALS['overallRating'] = ceil($GLOBALS['overallRating']);
                    }
                    echo $GLOBALS['overallRating'];
                    $prodrating = $GLOBALS['overallRating'];
                    $productName = $row["prod_name"];
                    $productPrice = $row["prod_price"];
                    echo "<div class='col-md-4 col-sm-6 col-xs-6'>";
                    echo "<div class='product product-single'>";
                    echo "<div class='product-thumb'>";
                    echo "<button class='main-btn quick-view' id='viewprod'><i class='fa fa-search-plus'></i> Quick view</button>";
                    echo '<img src="data:image/jpeg;base64,'.base64_encode($row['prod_pic']).'"/>';
                    echo "</div>";
                    echo "<div class='product-body'>";
                    echo "<h3 class='product-price'>$$prodrating</h3>";
                    echo "<div class='product-rating'>";
                    for ($i = 0; $i < $prodrating; $i++) {
                        echo "<i class='fa fa-star'></i> ";
                    }
                    for ($i = 0; $i < (5 - $prodrating); $i++) {
                        echo "<i class='fa fa-star-o empty'></i> ";
                    }                    
                    echo "</div>";
                    echo "<h2 class='product-name'><a href='#'>$productName</a></h2>";
                    echo "<div class='product-btns'>
                            <button class='main-btn icon-btn'><i class='fa fa-heart'></i></button>
                            <button class='main-btn icon-btn'><i class='fa fa-exchange'></i></button>
                            <button class='primary-btn add-to-cart'><i class='fa fa-shopping-cart'></i> Add to Cart</button>
                        </div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                
            }
        }else {
            die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
        }
        $stmt2->close();
        $stmt->close();
    }
    $conn->close();
}

?>




