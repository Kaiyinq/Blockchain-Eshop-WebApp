// window.addEventListener('load', function() {
//     if (typeof web3 !== 'undefined') {
//       console.log('web3 is enabled');
//       if (web3.currentProvider.isMetaMask === true) {
//         console.log('MetaMask is active');
//       } else {
//         console.log('MetaMask is not available');
//       }
//     } else {
//       console.log('web3 is not found');
//     }
// });

// window.addEventListener('load', function() {

//     // Checking if Web3 has been injected by the browser (Mist/MetaMask)
//     if (typeof web3 !== 'undefined') {
//       // Use Mist/MetaMask's provider
//       web3js = new Web3(web3.currentProvider);
//     } else {
//       console.log('No web3? You should consider trying MetaMask!')
//       // fallback - use your fallback strategy (local node / hosted node + in-dapp id mgmt / fail)
//       web3js = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"));
//     }
  
//     // // Now you can start your app & access web3 freely:
//     // startApp()
  
// });

var account;
var instance;
var orderContractAdd;
var confirm;
var orderId;
var comment;

var file = false;
var regex  = /^\d+(?:\.\d{0,2})$/;

function validateFileType(){
    var fileName = document.getElementById("myfile").value;
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
        file = true;
    } else {
        file = false;
    } 
}

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
        url:"confirmStatus_connect.php",  
        method:"POST",  
        data: {orderId: orderId}, 
        dataType: "json",
        // success message
        success:function(data){ 
            //console.log(data);
            orderContractAdd = data.orderContractAdd;
        },
        // error message
        error:function(data){
            console.log("Error");
            console.log(data);
        }
    });

    $("#confirmDelivery").change(function () {
        confirm = $('#confirmDelivery').val();

        if (confirm == 0) {
            // buyer choose No
            $('#commentgroup').show();
        } else if (confirm == 1) {
            //buyer choose Yes
            $('#commentgroup').hide();
        }
    });

    $('#submitBtn').click(function(){  
        confirm = $('#confirmDelivery').val();
        comment = $('#comment').val();
        var sellerRep;
        var buyerRep;

        const Web3 = require('web3');
        const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");

        if (confirm == 0) {
            // Buyer say no
            if (comment != "") {
                if (!file) {
                    alert("Only jpg/jpeg and png files are allowed!");
                } else {  
                    $.getJSON('build/contracts/EscrowCon.json', function(jsondata) {
                        (async () => {
                            const Escrow = TruffleContract(jsondata);
                            Escrow.setProvider(web3Provider);
                            account = web3.eth.accounts[0]; // referring to current account
                            instance = await Escrow.at(orderContractAdd);
                            owner = '0xB06e80E36e62F3F620771E03F8BDB0DC8BD03B50';

                            // buyer reject delivery 
                            instance.cancelDelivery.sendTransaction().then(function(data) {
                                console.log("Buyer rejects delivery." + data);
                                alert("Funds will be returned to you. Please note that your refund count will increase by 1.");
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
                                alert("Please check that you are using the correct ethereum account.");
                                console.log(e);
                            });
                            
                            if (!sellerRep && !buyerRep) {
                                instance.getItemAmt.call().then(function(data) {
                                    weiprice = data.c[0] + "" + data.c[1];
                                    instance.ownerToSeller.sendTransaction({from: owner,value: weiprice}).then(function(data) {
                                        console.log("Transaction Hash: " + data);
                                        updateDB(orderId, confirm, comment, "Refunded"); 
                                    });
                                });
                            } else {
                                updateDB(orderId, confirm, comment, "Refunded"); 
                            }

                        })();
                    });
                }
            } else {
                alert("Please include your reasons.");
            }
        } else if (confirm == 1){  
            // buyer say yes 
            comment = ""; 
            $.getJSON('build/contracts/EscrowCon.json', function(jsondata) {
                (async () => {
                    const Escrow = TruffleContract(jsondata);
                    Escrow.setProvider(web3Provider);
                    account = web3.eth.accounts[0]; 
                    instance = await Escrow.at(orderContractAdd);
                    
                    // buyer confirm delivery
                    instance.acceptDelivery.sendTransaction().then(function(data) {
                        console.log("Buyer accepts delivery. Funds will be transfered to seller." + data);
                        alert("You have accepted the item. Remember to make a review on the product.");
                        updateDB(orderId, confirm, comment, "Delivered");
                    }).catch(function (e) {
                        // console.log("Wrong ethereum account.");
                        alert("Please check that you are using the correct ethereum account.");
                        console.log(e);
                    });
                    
                })();
            });
        }        
        
    });

});
    
function updateDB(orderId, confirm, comment, status) {

    var formdata = new FormData();
    formdata.append('file', $('input[type=file]')[0].files[0]);
    formdata.append('orderId', orderId);
    formdata.append('confirm', confirm);
    formdata.append('comment', comment);
    formdata.append('status', status);

    $.ajax({
        method: 'POST',
        data: formdata, 
        contentType:false,
        processData:false,
        cache:false,
        url: 'confirmDelivery_connect.php',
        success: function(data) { 
            //alert('Shipping confirmation made!'); 
            window.location="accountpage.php";
        }
    });
}
