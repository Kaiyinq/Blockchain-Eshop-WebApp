<?php 

$prodid = $_POST['prodid'];
// $contractAdd = $_POST['contractAdd'];

// WRITE TO JSON
// $str = file_get_contents('sellerItem.json');//get contents of your json file and store it in a string
// $arr = json_decode($str, true);//decode it
// $arrne['prodid'] = $prodid;
// $arrne['prodname'] = $prodname;
// $arrne['prodprice'] = $prodprice;
// $arrne['itemListContractAdd'] = $contractAdd;
// $arrne['sellerAdd'] = $sellerAdd;
// array_push($arr['itemList'], $arrne);//push contents to ur decoded array i.e $arr
// $str = json_encode($arr);
// //now send evrything to ur data.json file using folowing code
// if (json_decode($str) != null) {
//     $file = fopen('sellerItem.json','w');
//     fwrite($file, $str);
//     fclose($file);
// } else {
//     //  invalid JSON, handle the error 
// }


// UPDATE DB
require('config.php');

if (mysqli_connect_error()) {
    die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
} else {
    $DELETE = "DELETE FROM eshop.products WHERE prod_id = ?";
    $stmt = $conn->prepare($DELETE);
    $stmt->bind_param('i', $prodid);
    $stmt->execute();

    $stmt->close();
    $conn->close();        
}
?>

