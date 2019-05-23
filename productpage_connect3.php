<?php
// THE PRODUCT RATING HERE IS THE OVERALL POINTS THAT GOT ADD UP AT PRODREVIEW TABLE 
require('config.php');
session_start(); //start session

$prodId = mysqli_real_escape_string($conn, $_POST['prodId']);

if (mysqli_connect_error()) {
    die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
} else {
    // FOR REVIEW SECTION
    $SELECT = "SELECT review_date, review_stars, review_comment, user_fullname
                FROM eshop.prodreview r
                LEFT JOIN eshop.orders o
                ON r.order_id = o.order_id
                LEFT JOIN eshop.users u
                ON o.userid = u.userid
                WHERE r.prod_id = ?";

    $stmt = $conn->prepare($SELECT);
    $stmt->bind_param('i', $prodId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // UNDONE DISPLAY REVIEW PORTION
            $fullname = $row["user_fullname"];
            $reviewDate = $row["review_date"];
            $reviewStars = $row["review_stars"];
            $reviewComment = $row["review_comment"];
            echo "<div class='single-review'>";
            echo "<div class='review-heading'>";
            echo "<div><i class='fa fa-user-o'></i> $fullname</div>";
            echo "<div><i class='fa fa-clock-o'></i> $reviewDate</div>";
            echo "<div class='review-rating pull-right'>";
            for ($i = 0; $i < $reviewStars; $i++) {
                echo "<i class='fa fa-star'></i> ";
            }
            for ($i = 0; $i < (5 - $reviewStars); $i++) {
                echo "<i class='fa fa-star-o empty'></i> ";
            }   
            echo "</div>";
            echo "</div>";
            echo "<div class='review-body'>";
            echo "<p>$reviewComment</p>";
            echo "</div>";
            echo "</div>";
        }
    }

    $stmt->close();
    $conn->close();
}

?>