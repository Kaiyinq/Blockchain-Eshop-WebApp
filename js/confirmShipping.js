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

            document.getElementById('orderShippingSlip').setAttribute(
            'src', 'data:image/jpeg;base64,' + data.orderRefPic);

            $("#shippingDate").text(data.orderShippingDate);

        },
        // error message
        error:function(data){
            console.log("Error");
            console.log(data);
        }
    });

    $("#confirmShipping").change(function () {
        confirm = $('#confirmShipping').val();

        if (confirm == 0) {
            // buyer choose No
            $('#commentgroup').show();
        } else if (confirm == 1) {
            //buyer choose Yes
            $('#commentgroup').hide();
        }
    });

    $('#submitBtn').click(function(){  
        confirm = $('#confirmShipping').val();
        comment = $('#comment').val();

        const Web3 = require('web3');
        const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");

        $.getJSON('build/contracts/EscrowCon.json', function(jsondata) {
            (async () => {
                const Escrow = TruffleContract(jsondata);
                Escrow.setProvider(web3Provider);
                account = web3.eth.accounts[0]; 
                instance = await Escrow.at(orderContractAdd);
                
                if (confirm == 0) {
                    if (comment != null) {
                        // buyer reject shipping slip
                        instance.cancelSlip.sendTransaction().then(function(data) {
                            updateDB(orderId, confirm, comment);
                            console.log("Buyer rejects shipping slip." + data);
                            alert("You have rejected the shipping slip. The seller will get back to you.");
                        }).catch(function (e) {
                            console.log("Wrong ethereum account.");
                            alert("Please check that you are using the correct ethereum account.");
                        });
                    } else {
                        alert("Please include your reasons.");
                    }
                } else if (confirm == 1) {   
                    comment = ""; 
                     // buyer confirm shipping slip
                    instance.acceptSlip.sendTransaction().then(function(data) {
                        updateDB(orderId, confirm, comment);
                        console.log("Buyer accept shipping slip." + data);
                        alert("You have confirmed the shipping slip. Please patiently wait for your product.");
                    }).catch(function (e) {
                        console.log("Wrong ethereum account.");
                        alert("Please check that you are using the correct ethereum account.");
                    });   

                }

                
                
            })();
        });

        
        
    });

});

    
function updateDB(orderId, confirm, comment) {
    $.ajax({
        method: 'POST',
        url: 'confirmShipping_connect.php',
        data: {orderId: orderId, confirm: confirm, comment: comment},
        success: function(data) { 
            //console.log(data);
            //alert('Shipping confirmation made!'); 
           window.location="accountpage.php";
        }
    });
}
