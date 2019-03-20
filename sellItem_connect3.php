<?php 

$prodid = $_POST['prodid'];
$prodname = $_POST['prodname'];
$prodprice = $_POST['prodprice'];
$contractAdd = $_POST['contractAdd'];
$sellerAdd = $_POST['sellerAdd'];

$str = file_get_contents('sellerItem.json');//get contents of your json file and store it in a string
$arr = json_decode($str, true);//decode it
$arrne['prodid'] = $prodid;
$arrne['prodname'] = $prodname;
$arrne['prodprice'] = $prodprice;
$arrne['contractAdd'] = $contractAdd;
$arrne['sellerAdd'] = $sellerAdd;
array_push($arr['itemList'], $arrne);//push contents to ur decoded array i.e $arr
$str = json_encode($arr);
//now send evrything to ur data.json file using folowing code
if (json_decode($str) != null)
{
    $file = fopen('sellerItem.json','w');
    fwrite($file, $str);
    fclose($file);
}
else
{
    //  invalid JSON, handle the error 
}

?>

