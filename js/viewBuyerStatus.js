$(document).ready(function(){ 

    var url = new URL(window.location.href);
    orderId = url.searchParams.get("order");
    console.log(orderId);

    var shipOk;
    var shipComment;
    var deliveryOk;
    var deliveryComment;
    var orderContractAdd;

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
            orderContractAdd = data.orderContractAdd;

            if (shipOk == 1) {
                $('#ordershipping').text("Accepted"); 
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

        var confirmation = $('#buyerReject').val();

        const Web3 = require('web3');
        const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");

        $.getJSON('build/contracts/EscrowCon.json', function(jsondata) {
            (async () => {
                const Escrow = TruffleContract(jsondata);
                Escrow.setProvider(web3Provider);
                account = web3.eth.accounts[0]; 
                instance = await Escrow.at(orderContractAdd);
                
                // buyer rejects shipping slip 
                // seller rejects shipping slip rejection
                if (shipOk == 0 && confirmation == 0) {
                    instance.cancelRejectSlip.call().then(function(data) {
                        console.log("rejects slip" + data);

                        alert("Both sides cannot settle. Please wait patiently for the management to verify.");
                        
                    });
                } else {
                    instance.acceptRejectSlip.call().then(function(data) {
                        console.log("accepts slip" + data);

                        alert("Funds is returned to the buyer.");
                    });
                }            

                window.location="accountpage.php";
                
                
            })();
        });     
        
    });

});