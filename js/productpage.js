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

var oneETHSGD; 
var ethprice; 
var weiprice; 
var account;
var instance;
var escrowContractAdd;
var prodId;

// PROMPT THAT METAMASK/MIST ETC IS RUNNING
window.addEventListener('load', async () => {
    // Modern dapp browsers...
    if (window.ethereum) {
        window.web3 = new Web3(ethereum);
        try {
            // Request account access if needed
            await ethereum.enable();
            // Acccounts now exposed
            // web3.eth.sendTransaction({ 
            //     from: "0xB06e80E36e62F3F620771E03F8BDB0DC8BD03B50",
            //     to: "0x1879B9D8B2C03180De9aD982b3C0C167419620aa",
            //     value: web3.toWei(1, "ether"),
            // }, function(err, transactionHash) {
            //     if (!err)
            //       console.log(transactionHash + " success"); 
            // });
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
    prodId = url.searchParams.get("prod");
    console.log(prodId);

    $.getJSON('build/contracts/ItemListing.json', function(jsondata) {
        (async () => {
            const ItemListing = TruffleContract(jsondata);
            ItemListing.setProvider(window.web3.currentProvider);
            var account = web3.eth.accounts[0];
            iteminstance = await ItemListing.at("0x3338AA63dDdAA61cC98876fD3b94CcFeE6fFD1A5");

            iteminstance.getSellerRep(prodId).then(function(data) {
                if(data) {
                    $('#warning').html("Item is from a <strong style='color:#F8694A'>LOW REPUTATION</strong> seller. Any purchases made is at your own risk.");
                    document.getElementById('warning').style.display = "block";
                } 
            });       

        })();
    });

    $.ajax({  
        url:'productpage_connect3.php',  
        method:'POST',  
        dataType: "html",
        data: {prodId: prodId},
        // success message
        success:function(data){ 
            $("#reviewinfo").html(data); 
        },
        // error message
        error:function(data){
            console.log(data);
        }
    });
    
    $('.btn-confirm').click(function(){ 

        // EXAMPLE
        // $.getJSON('build/contracts/ItemListing.json', function(jsondata) {
        //     (async () => {
        //         const ItemListing = TruffleContract(jsondata);
        //         ItemListing.setProvider(window.web3.currentProvider);
        //         var account = web3.eth.accounts[0];
        //         const instance = await ItemListing.new({from: account, gas: 3000000});
        //         itemListContractAdd = instance.address; 
        //         console.log(itemListContractAdd);
        //     })();
        // });

        instance.buyerToEscrow.sendTransaction({from: account, value: weiprice}).then(function(value) {
            console.log("Transaction Hash: " + value);

            var dateTime = new Date().toISOString().slice(0, 19).replace('T', ' '); 
            var quantity = $('#quantity').val();
             
            // update DB order table
            $.ajax({  
                url:'productpage_connect2.php',  
                method:'POST',  
                data: {checker: 1, prodId: prodId, escrowContractAdd: escrowContractAdd, dateTime: dateTime, quantity: quantity},
                // success message
                success:function(data){ 
                    alert("Order sent to seller.");
                    window.location="accountpage.php";
                },
                // error message
                error:function(data){
                    console.log(data);
                }
            });

            $(".btn-confirm").attr("disabled", true);

            // send notification to seller that buyer has ordered this item ***** UNDONE *********


        }).catch(function (e) {
            //console.log(e);
            if (e.message.search('out of gas') >= 0)
                alert("You're out of gas!");
            else 
                alert("If this is your product, purchase is denied. Otherwise, please check if there is sufficient funds in your account.");
        });

    });

    $('.btn-buynow').click(function(){ 
        $.ajax({  
            url:'productpage_connect2.php',  
            method:'POST',  
            data: {checker: 0},
            dataType:'json',
            // success message
            success:function(data){ 
                if (data.error == 2) {
                    alert("You're not allowed to buy your own product!");
                } else if (data.error == 1) {
                    alert("Please check if you are login.");
                } else {
                    var price = data.prodPrice;
                    var username = data.username;
                    var prodContractAdd = "0x3338AA63dDdAA61cC98876fD3b94CcFeE6fFD1A5";
                    var userContractAdd = "0xEEa1012e5eF6C0B44bDAB51b3FE07aF3C6d71181";
                    
                    $.ajax({
                        method: 'GET',
                        url: 'oneETHSGD.php',
                        success: function(data) { 
                            // Get life conversion data (1ETH = ? SGD)
                            oneETHSGD = data;
                            console.log(oneETHSGD);
                    
                            // SGD convert to ETH 
                            ethprice = (1/(oneETHSGD/price)).toFixed(6);
                            // ETH convert to WEI
                            weiprice = ethprice*1e18;
                            console.log(weiprice);
                    
                            // uses web3@0.20.6 and truffle-contract@3.0.6
                            const Web3 = require('web3');
                            const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");
                            $.getJSON('build/contracts/EscrowCon.json', function(jsondata) {
                                (async () => {
                                    const Escrow = TruffleContract(jsondata);
                                    Escrow.setProvider(web3Provider);
                                    account = web3.eth.accounts[0]; 
                                    try {
                                        // passing ItemListing contract address based on the prodid
                                        instance = await Escrow.new(prodContractAdd, userContractAdd, weiprice, username, prodId, {from: account, gas: 3000000});
                                        escrowContractAdd = instance.address; 
                                        console.log(escrowContractAdd);
                        
                                        // diplay ETH price and SGD price
                                        $('#ethamt').text(ethprice + " ETH (" + price + " SGD)");
                                        $('#contractAddress').text(escrowContractAdd);
                                        $('.modal-style').css('visibility', 'visible');
                                        $(".btn-confirm").attr("disabled", false);
                                    }catch (e) {
                                        $('#ethamt').text("");
                                        $('#contractAddress').text("");
                                        $('.modal-style').css('visibility', 'hidden');
                                        $(".btn-confirm").attr("disabled", false);
                                        console.log(e);
                                        alert("Please check that you are using the correct ethereum account.");
                                        //location.reload();
                                    }
                                })();
                            });
                        }
                    });
                }
                
            }
        });  
    });

});
