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

    var prodId;
    var orderContractAdd;
    var username;
    var url = new URL(window.location.href);
    orderId = url.searchParams.get("order");
    console.log(orderId);

    $.ajax({
        method: 'POST',
        url: 'viewBuyerOrder_connect.php',
        data: {orderId: orderId},
        dataType: 'json',
        success: function(data) { 

            shopName = data.shopName;
            prodName = data.prodName;
            prodDesc = data.prodDesc;
            prodId = data.prodId;

            orderDate = data.orderDate;
            orderStatus = data.orderStatus;
            orderContractAdd = data.orderContractAdd;

            username = data.username;
            sellerUsername = data.sellerUsername;

            $('.product-name').text(prodName);
            $('#soldBy').html("<strong>Sold By:</strong> " + shopName);
            $('#orderDate').html("<strong>Order Date:</strong> " + orderDate);
            $('#desc').html("<strong>Description:</strong> <br>" + prodDesc);
        }
    });

    $('#submitBtn').click(function(){ 
        var review = $('#reviewbox').val();
        var value = $('input[name=rating]:checked').val();
        var dateTime = new Date().toISOString().slice(0, 19).replace('T', ' '); 
        console.log("review: " + review);
        console.log("rating: " + value);

        // SETTLE CONTRACT 
        const Web3 = require('web3');
        const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");

        $.getJSON('build/contracts/Users.json', function(jsondata) {
            (async () => {
                const Users = TruffleContract(jsondata);
                Users.setProvider(web3Provider);
                account = web3.eth.accounts[0]; 
                instance = await Users.at("0xEEa1012e5eF6C0B44bDAB51b3FE07aF3C6d71181");
                
                instance.submitFeedback(orderContractAdd, value, username, sellerUsername).then(function(data) {
                    // STORE 
                    $.ajax({
                        method: 'POST',
                        url: 'review_connect.php',
                        data: {orderId: orderId, dateTime: dateTime, review: review, value: value, prodId: prodId},
                        success: function(data) { 
                            alert("Thanks for your time. Your review has been submitted!");                
                        }
                    });
                }).catch(function (e) {
                    console.log(e);
                    alert("Please check that you are using the correct ethereum account.");
                });         
  
            })();
        });
        
    });
    
});


