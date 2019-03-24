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

// window.addEventListener('load', async () => {
//     // Modern dapp browsers...
//     if (window.ethereum) {
//         window.web3 = new Web3(ethereum);
//         try {
//             // Request account access if needed
//             await ethereum.enable();
//             // Acccounts now exposed
//             web3.eth.sendTransaction({ 
//                 from: "0xB06e80E36e62F3F620771E03F8BDB0DC8BD03B50",
//                 to: "0x1879B9D8B2C03180De9aD982b3C0C167419620aa",
//                 value: web3.toWei(1, "ether"),
//             }, function(err, transactionHash) {
//                 if (!err)
//                   console.log(transactionHash + " success"); 
//             });
//             // web3.eth.sendTransaction({ 
//             //     from: "0x1879B9D8B2C03180De9aD982b3C0C167419620aa",
//             //     to: "0xfDF1506DC6Fff56a4aF6e316B0349CF2816D1B5C",
//             //     value: 1*1e18,
//             // }, function(err, transactionHash) {
//             //     if (!err)
//             //         console.log(transactionHash + " success"); 
//             // });
//         } catch (error) {
//             // User denied account access...
//             console.log(error);
//         }
//     }
//     // Legacy dapp browsers...
//     else if (window.web3) {
//         window.web3 = new Web3(web3.currentProvider);
//         // Acccounts always exposed
//         // web3.eth.sendTransaction({ 
//         //     from: web3.eth.accounts[0],
//         //     to: "0x1879B9D8B2C03180De9aD982b3C0C167419620aa",
//         //     value: web3.toWei(1, "ether")
//         // });
//     }
//     // Non-dapp browsers...
//     else {
//         console.log('Non-Ethereum browser detected. You should consider trying MetaMask!');
//     }
// });

$(document).ready(function(){ 
    var oneETHSGD; 
    var ethprice;   
    $('.btn-buynow').click(function(){ 
        $.ajax({  
            url:'productpage_connect2.php',  
            method:'GET',  
            dataType:'json',
            // success message
            success:function(data){ 
                console.log(data);
                console.log(data.prodContractAdd); // for php json_encode()
                console.log(data.prodPrice); // for php json_encode()

                var price = data.prodPrice;
                var prodContractAdd = data.prodContractAdd;
                
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
                        var weiprice = ethprice*1e18;
                        console.log(weiprice);
                        // diplay ETH price and SGD price
                        $('#ethamt').prepend(ethprice + " ETH ");
                
                        // uses web3@0.20.6 and truffle-contract@3.0.6
                        const Web3 = require('web3');
                        const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");
                        $.getJSON('build/contracts/EscrowCon.json', function(jsondata) {
                            (async () => {
                                const Escrow = TruffleContract(jsondata);
                                Escrow.setProvider(web3Provider);
                                var account = web3.eth.accounts[0]; 
                                // passing ItemListing contract address based on the prodid
                                const instance = await Escrow.new(prodContractAdd, {from: account, gas: 3000000});
                                escrowContractAdd = instance.address; 
                                console.log(escrowContractAdd);
                
                                $('#contractAddress').text(escrowContractAdd);

                                $('.modal-style').css('visibility', 'visible');

                                instance.buyerToEscrow.sendTransaction(escrowContractAdd, {from: "0x1879B9D8B2C03180De9aD982b3C0C167419620aa", value: web3.toWei(1, "ether")}).then(function(value) {
                                    console.log(value);
                                    instance.getContractBal.call().then(function(data) {
                                        console.log(data.c);
                                    });
                                });

                                
                            })();
                        });
                
                
                    }
                });
            },
            // error message
            error:function(data){
                console.log(data);
            }
        });  

    
    });
});