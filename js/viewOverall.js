var orderContractAdd;
var orderId;

// PROMPT THAT METAMASK/MIST ETC IS RUNNING
window.addEventListener('load', async () => {
    // Modern dapp browsers...
    if (window.ethereum) {
        window.web3 = new Web3(ethereum);
        try {
            // Request account access if needed
            await ethereum.enable();
            // Acccounts now exposed
            // web3.eth.sendTransaction({...});
        } catch (error) {
            // User denied account access...
            console.log(error);
        }
    }
    // Legacy dapp browsers...
    else if (window.web3) {
        window.web3 = new Web3(web3.currentProvider);
        // Acccounts always exposed
        // web3.eth.sendTransaction({...});
    }
    // Non-dapp browsers...
    else {
        console.log('Non-Ethereum browser detected. You should consider trying MetaMask!');
    }
    
    var url = new URL(window.location.href);
    orderId = url.searchParams.get("order");
    console.log(orderId);

    var shipOk;
    var shipComment;
    var deliveryOk;
    var deliveryComment;

    $.ajax({
        method: 'POST',
        url: 'viewOverall_connect.php',
        data: {orderId: orderId},
        dataType: 'json',
        success: function(data) { 
            //console.log(data);

            buyerName = data.buyerName;
            buyerAdd = data.buyerAdd;
            buyerNum = data.buyerNum;

            prodName = data.prodName;

            orderQuantity = data.orderQuantity;
            orderDate = data.orderDate;
            orderStatus = data.orderStatus;
            orderRefPic = data.orderRefPic;
            orderShippingDate = data.orderShippingDate;
            orderContractAdd = data.orderContractAdd;
            orderDefectRefPic = data.orderDefectRefPic;
            orderAcceptRejectSlip = data.orderAcceptRejectSlip;

            shipOk = data.orderShipOk;
            shipComment = data.orderShipComment;
            deliveryOk = data.orderDeliveryOk;
            deliveryComment = data.orderDeliveryComment;

            // Buyer's reputation
            $.getJSON('build/contracts/EscrowCon.json', function(jsondata) {
                (async () => {
                    const Escrow = TruffleContract(jsondata);
                    Escrow.setProvider(window.web3.currentProvider);
                    instance = await Escrow.at(orderContractAdd);
        
                    instance.getBuyerReputation().then(function(data) {
                        if(data) {
                            $('#warning').html("This is a <strong style='color:#F8694A'>LOW REPUTATION</strong> buyer. Any goods sold is at your own risk.");
                            document.getElementById('warning').style.display = "block";
                        } 
                    });       
        
                })();
            });

            // buyer cancellation
            if (orderStatus == "Cancelling") {
                $('#danger').html("The buyer has made a cancellation. If item has been shipped out, please upload the shipping slip by today.");
                document.getElementById('danger').style.display = "block";
            }

            // buyer details
            $("#orderBy").text(buyerName);
            $("#contactNo").text(buyerNum);
            $("#shipTo").text(buyerAdd);

            // order details
            $("#prodName").text(prodName);
            $("#orderDate").text(orderDate);
            $("#orderQuantity").text(orderQuantity);
            $("#orderStatus").text(orderStatus);     

            document.getElementById('rejectOrder').href = "javascript:rejectOrder()";

            // Shipping slip details
            document.getElementById('orderShippingSlip').setAttribute(
                'src', 'data:image/jpeg;base64,' + orderRefPic);

            $("#shippingDate").text(orderShippingDate);
            
            if (orderStatus == "Processing" || orderStatus == "Cancelling")
                document.getElementById('updateSlip').href = "sellUpdateStatus.php?order=" + orderId;
            else {
                document.getElementById('updateSlip').href = "#";
                document.getElementById('updateSlip').style.display = "none";
            }

            // Buyer's Acceptance Details on Shipping
            if (shipOk == 1) {
                $('#ordershipping').text("Accepted"); 
                $('#delivery').show();
            } else if (shipOk == 0) {
                $('#ordershipping').text("Declined"); 
                $('#rejection').show();
                if (orderAcceptRejectSlip == 1) {
                    $('#slipYesNo').text("You have accepted buyer's proposition. Funds will be refunded to buyer.");
                } else if (orderAcceptRejectSlip == 0) {
                    $('#slipYesNo').html("You have rejected buyer's proposition. Funds are transferred to you.");
                } else {
                    $('#slipYesNo').html("<a href='javascript:acceptRejectSlip()'>Yes</a> / <a href='javascript:cancelRejectSlip()'>No</a>");
                }
            } else {
                $('#ordershipping').text("Waiting for buyer's reply"); 
            }

            if (shipComment == "")
                $('#orderShipConfirm').text("NIL"); 
            else 
                $('#orderShipConfirm').text(shipComment); 

            // Buyer's Acceptance Details on Delivery
            if (deliveryOk == 1) {
                $('#orderdelivery').text("Accepted"); 
            } else if (deliveryOk == 0) {
                $('#orderdelivery').text("Declined"); 
                $('#rejection2').show();
            } else {
                $('#orderdelivery').text("Waiting for buyer's reply"); 
            }

            if (deliveryComment == "")
                $('#orderDeliveryConfirm').text("NIL"); 
            else 
                $('#orderDeliveryConfirm').text(deliveryComment);

            document.getElementById('orderDefect').setAttribute(
                'src', 'data:image/jpeg;base64,' + orderDefectRefPic);
             
        },
        error: function(data) {
            console.log(data);
        }
    });
    
});

function rejectOrder() {
    const Web3 = require('web3');
    const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");

    $.getJSON('build/contracts/EscrowCon.json', function(jsondata) {
        (async () => {
            const Escrow = TruffleContract(jsondata);
            Escrow.setProvider(web3Provider);
            account = web3.eth.accounts[0]; 
            instance = await Escrow.at(orderContractAdd);

            // seller reject order 
            instance.rejectOrder.sendTransaction().then(function(data) {
                console.log("Seller reject order. Transaction Hash: " + data);
                alert("Funds is returned to the buyer.");
                updateDB(orderId, 2, "Cancelled");
            }).catch(function (e) {
                console.log("Wrong ethereum account.");
                alert("Please check that you are using the correct ethereum account.");
            });   

        })();
    });
}

function acceptRejectSlip() {
    const Web3 = require('web3');
    const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");

    $.getJSON('build/contracts/EscrowCon.json', function(jsondata) {
        (async () => {
            const Escrow = TruffleContract(jsondata);
            Escrow.setProvider(web3Provider);
            account = web3.eth.accounts[0]; 
            instance = await Escrow.at(orderContractAdd);
            
            // buyer rejects shipping slip 
            // seller accepts shipping slip rejection
            instance.acceptRejectSlip.sendTransaction().then(function(data) { 
                console.log("Seller accepts cancellation of slip." + data);
                alert("Funds is returned to the buyer.");
                updateDB(orderId, 1, "Refunded"); //orderAcceptRejectSlip is true (1)
            }).catch(function (e) {
                console.log("Wrong ethereum account.");
                alert("Please check that you are using the correct ethereum account.");
            });            

        })();
    });
}

function cancelRejectSlip() {
    var sellerRep;
    var buyerRep;
    const Web3 = require('web3');
    const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");

    $.getJSON('build/contracts/EscrowCon.json', function(jsondata) {
        (async () => {
            const Escrow = TruffleContract(jsondata);
            Escrow.setProvider(web3Provider);
            account = web3.eth.accounts[0]; 
            instance = await Escrow.at(orderContractAdd);
            owner = '0xB06e80E36e62F3F620771E03F8BDB0DC8BD03B50';

            // buyer rejects shipping slip 
            // seller rejects shipping slip rejection
            instance.cancelRejectSlip.sendTransaction().then(function(data) { // *******************
                console.log("Seller reject cancellation of slip." + data);
                alert("Payment is transfered to you.");
                updateDB(orderId, 0, "Cancelled"); 
                instance.getSellerReputation.call().then(function(data) {
                    console.log("seller reputation: " + data);
                    sellerRep = data;
                    if (!sellerRep) {
                        instance.getBuyerReputation.call().then(function(data) {
                            console.log("buyer reputation: " + data);
                            buyerRep = data;
                        });
                    }
                });
            }).catch(function (e) {
                console.log("Wrong ethereum account.");
                alert("Please check that you are using the correct ethereum account.");
            });   

            if (!sellerRep && !buyerRep) {
                instance.getItemAmt.call().then(function(data) {
                    weiprice = data.c[0] + "" + data.c[1];
                    instance.ownerToBuyer.sendTransaction({from: owner, value: weiprice}).then(function(data) {
                        console.log("Transaction Hash: " + data);
                    });
                });
            }

        })();
    });
}

function updateDB(orderId, rejectSlip, orderStatus) {
    $.ajax({
        method: 'POST',
        url: 'viewOverall_connect2.php',
        data: {orderId:orderId, rejectSlip:rejectSlip, orderStatus:orderStatus},
        success: function(data) { 
            //console.log(data);
            //alert('Shipping confirmation made!'); 
            location.reload();
        }
    });
}