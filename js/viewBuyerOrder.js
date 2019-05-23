var orderContractAdd;
var orderId;
var orderStatus;

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

    $.ajax({
        method: 'POST',
        url: 'viewBuyerOrder_connect.php',
        data: {orderId: orderId},
        dataType: 'json',
        success: function(data) { 
            //console.log(data);

            shopName = data.shopName;
            buyerAdd = data.buyerAdd;
            shopNum = data.shopNum;

            prodName = data.prodName;

            orderQuantity = data.orderQuantity;
            orderDate = data.orderDate;
            orderStatus = data.orderStatus;
            orderContractAdd = data.orderContractAdd;

            // buyer details
            $("#orderBy").text(shopName);
            $("#contactNo").text(shopNum);
            $("#shipTo").text(buyerAdd);

            // order details
            $("#prodName").text(prodName);
            $("#orderDate").text(orderDate);
            $("#orderQuantity").text(orderQuantity);
            $("#orderStatus").text(orderStatus);     

            document.getElementById('cancelOrder').href = "javascript:cancelOrder()";        
            
        },
        error: function(data) {
            console.log(data);
        }
    });
    
    
});

function cancelOrder() {
    if (orderStatus != "Cancelling") {
        const Web3 = require('web3');
        const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");

        $.getJSON('build/contracts/EscrowCon.json', function(jsondata) {
            (async () => {
                const Escrow = TruffleContract(jsondata);
                Escrow.setProvider(web3Provider);
                account = web3.eth.accounts[0]; 
                instance = await Escrow.at(orderContractAdd);

                // buyer cancel order 
                instance.cancelOrder.sendTransaction().then(function(data) {
                    console.log("Buyer cancel order. Transaction Hash: " + data);
                    alert("Funds will be refunded after 1 day if seller has not upload shipping slip.");
                    updateDB(orderId);
                }).catch(function (e) {
                    console.log("Wrong ethereum account.");
                    alert("Please check that you are using the correct ethereum account.");
                });   

            })();
        });
    } else {
        alert("Action in process.")
    }
    
}

function updateDB(orderId) {
    $.ajax({  
        url:"viewBuyerOrder_connect2.php",  
        method:"POST",  
        data: {orderId: orderId}, 
        // success message
        success:function(data){  
            location.reload();
        }
    });
}
