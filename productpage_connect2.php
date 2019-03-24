<?php 
session_start(); //start session
if(isset($_SESSION["prodContractAdd"]) && isset($_SESSION["prodPrice"])) {
    $prodContractAdd = $_SESSION["prodContractAdd"];
    $prodPrice = $_SESSION["prodPrice"];
    $prodDetails = array('prodContractAdd'=>$prodContractAdd, 'prodPrice'=>$prodPrice);
    echo json_encode($prodDetails);
}

?>