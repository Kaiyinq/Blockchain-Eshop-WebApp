// // FOR PRODUCTPAGE.PHP AND PRODUCTPAGE_CONNECT.PHP

// App = {
//     web3Provider: null,
//     contracts: {},
//     // instantiate web3
//     initWeb3: async function() {
//         // Is there an injected web3 instance?
//         if (typeof web3 !== 'undefined') {
//             App.web3Provider = web3.currentProvider;
//         } else {
//             // If no injected web3 instance is detected, fallback to the TestRPC(8545)/Ganache(8545)
//             App.web3Provider = new Web3.providers.HttpProvider("http://localhost:8545");
//         }
    
//         web3 = new Web3(App.web3Provider);
    
//         return App.initContract();
//     },
  
//     initContract: function() {
//         $.getJSON('build/contracts/EscrowCon.json', function(data) {
//             // Get the necessary contract artifact file and instantiate it with truffle-contract
//             var EscrowArtifact = data;
//             App.contracts.EscrowCon = TruffleContract(EscrowArtifact);
        
//             // Set the provider for our contract
//             App.contracts.EscrowCon.setProvider(App.web3Provider);

//             return App.handleBuy();
//         });
//     },

//     bindEvents: function() {
//         $(document).on('click', '.btn-buynow', App.handleBuy);
//     },

//     handleBuy: function(event) {
//         //event.preventDefault();
  
//         var EscrowConInstance;
    
//         web3.eth.getAccounts(function(error, accounts) {
//             if (error) {
//             console.log(error);
//             }
//             // account 0 => seller account
//             var account = accounts[0]; 

//             App.contracts.EscrowCon.new({from: account, gas: 3000000}).then(function(instance) {
//                 EscrowConInstance = instance;
//                 //console.log(EscrowConInstance.address);
//                 contractAdd = EscrowConInstance.address;
//                 console.log(contractAdd);
//                 $('.modal-style').css("visibility", "visible");
//                 $('#contractAddress').text(contractAdd);
                
//             }).catch(function(err) {
//                 console.log(err.message);
//             });
//       });
//     }
// };

// $(function() {
//     $(window).load(function() {
//         $('.modal-style').css("visibility", "hidden");
//         App.initWeb3();
//     });
// });
