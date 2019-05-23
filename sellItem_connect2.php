<?php
require('config.php');
session_start(); //start session

if(isset($_SESSION["sellerid"])) {
    $sellerid = $_SESSION["sellerid"];
    $item =  mysqli_real_escape_string($conn, $_POST['item']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $delivery = mysqli_real_escape_string($conn, $_POST['delivery']);
    $categoryid = mysqli_real_escape_string($conn, $_POST['categoryid']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    $img = file_get_contents($_FILES['file']['tmp_name']);

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $INSERT = "INSERT INTO eshop.products (prod_name, prod_date, prod_price, prod_quantity, prod_shipmethod, prod_pic, prod_desc, category_id, seller_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($INSERT);
        $stmt->bind_param('ssdisssii', $item, $date, $price, $quantity, $delivery, $img, $desc, $categoryid, $sellerid);
        $stmt->execute();
        $stmt->close();
 
        $SELECT = "SELECT prod_id FROM eshop.products WHERE seller_id = ? ORDER BY prod_id DESC LIMIT 1";
        $stmt2 = $conn->prepare($SELECT);
        $stmt2->bind_param('i', $sellerid);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
            $prodid = $row2["prod_id"];     
        }else {
            die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
        }

        $username = $_SESSION["username"];

        $details = array('prodid'=>$prodid, 'username'=>$username);
        echo json_encode($details);

        $stmt2->close();
        $conn->close();        
    }
} else {
    die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
}
?>