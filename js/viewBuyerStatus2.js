$(document).ready(function(){ 

    var url = new URL(window.location.href);
    orderId = url.searchParams.get("order");
    console.log(orderId);

    var shipOk;
    var shipComment;
    var deliveryOk;
    var deliveryComment;

    $.ajax({
        method: 'POST',
        url: 'viewBuyerStatus_connect.php',
        data: {orderId: orderId},
        dataType: 'json',
        success: function(data) { 
            console.log(data);

            shipOk = data.orderShipOk;
            shipComment = data.orderShipComment;
            deliveryOk = data.orderDeliveryOk;
            deliveryComment = data.orderDeliveryComment;

            if (shipOk == 1) {
                $('#ordershipping').text("Accepted"); 
                $('#delivery').show();

                if (deliveryOk == 1) {
                    $('#orderdelivery').text("Accepted"); 
                } else if (deliveryOk == 0) {
                    $('#orderdelivery').text("Declined"); 
                    $('#rejection').show();
                } else {
                    $('#orderdelivery').text("Waiting for buyer's reply"); 
                }
    
                if (deliveryComment == "")
                    $('#orderDeliveryConfirm').text("NIL"); 
                else 
                    $('#orderDeliveryConfirm').text(deliveryComment);

            } else if (shipOk == 0) {
                $('#ordershipping').text("Declined"); 
                $('#rejection').show();
            } else {
                $('#ordershipping').text("Waiting for buyer's reply"); 
            }

            if (shipComment == "")
                $('#orderShipConfirm').text("NIL"); 
            else 
                $('#orderShipConfirm').text(shipComment); 

            
        }
    });

    $('#submitBtn').click(function(){  

        const Web3 = require('web3');
        const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");

        $.getJSON('build/contracts/EscrowCon.json', function(jsondata) {
            (async () => {
                const Escrow = TruffleContract(jsondata);
                Escrow.setProvider(web3Provider);
                account = web3.eth.accounts[0]; 
                instance = await Escrow.at(orderContractAdd);
                
                if (shipOk == 0) {
                     // buyer confirm shipping slip
                    instance.acceptSlip.call().then(function(data) {
                        console.log("update" + data);
                    });
                }

                if (deliveryOk == 0) {
                    instance.cancelDefect.call().then(function(data) {
                        console.log("Seller reject the say of defect" + data);
                    });
                } else if (deliveryOk == 1) {
                    instance.acceptDefect.call().then(function(data) {
                        console.log("Seller accept the say of defect" + data);
                    });
                }
               

                alert("You have confirmed the shipping slip. Please patiently wait for your product.");
                window.location="accountpage.php";
                
            })();
        });     
        
    });

});