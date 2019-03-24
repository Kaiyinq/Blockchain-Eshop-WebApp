<?php 

    $str = file_get_contents('https://api.coinmarketcap.com/v1/ticker/ethereum/?convert=SGD');
    $data = json_decode($str);
    $oneETHSGD = $data[0]->price_sgd;
    echo $oneETHSGD;

?>