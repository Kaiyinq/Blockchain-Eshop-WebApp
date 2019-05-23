<?php 
require('config.php');
session_start(); //start session

if(isset($_SESSION["buyerid"])) {

    // CHECK THAT SELLER IS NOT THE SELLER OF THE PRODUCT
    if (!isset($_SESSION["sellerid"]) || $_SESSION["sellerid"] != $_SESSION["prodSellerId"]) {

        // WHEN BTN-BUYNOW BUTTON IS CLICKED
        if($_POST['checker'] == 0 && isset($_SESSION["username"]) && isset($_SESSION["prodPrice"])) {
            $prodPrice = $_SESSION["prodPrice"];
            $username = $_SESSION["username"];
            $prodDetails = array('prodPrice'=>$prodPrice, 'username'=>$username);
            echo json_encode($prodDetails);
        }

        // WHEN BTN-CONFIRM BUTTON IS CLICKED
        if ($_POST['checker'] == 1 && isset($_SESSION["buyerid"]) ) {
            $userid = $_SESSION["buyerid"];
            $prodId = $_POST["prodId"];
            $escrowContractAdd = $_POST['escrowContractAdd'];
            $orderDate = $_POST['dateTime'];
            $orderQuantity = $_POST['quantity'];
            $orderStatus = "Processing";

            if (mysqli_connect_error()) {
                die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
            } else {
                $INSERT = "INSERT INTO eshop.orders (order_status, order_date, order_quantity, prod_id, userid, order_contractAdd) 
                            VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param('ssiiis', $orderStatus, $orderDate, $orderQuantity, $prodId, $userid, $escrowContractAdd);
                $stmt->execute();
                $stmt->close();
                $conn->close();
            }
        }
    } else {
        die(); //Throw an error on failure
        $error = array('error'=>"2");
        echo json_encode($error);
    }
    
} else {
    //die(); //Throw an error on failure
    $error = array('error'=>"1");
    echo json_encode($error);
}

?>