// FOR SELLITEM.PHP AND SELLITEM_CONNECT.PHP

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

    $('#submitBtn').click(function(){  
        var item = $('#itemname').val(); 
        var quantity = $('#quantity').val();
        var price = $('#price').val();  
        var delivery = $('#shipmethod').val();
        var categoryid = $('#category').val();
        var desc = $('#desc').val();
        var prodid;
        // First of all, we are creating a new date object with "new Date()" containing the current time.
        // After that, we are converting the time with .toISOString() into the format YYYY-MM-DDTHH:mm:ss.sssZ. 
        // And because we only need the first part of this string, we are last using .slice(0,10) to get the first 10 characters of the string.
        var date = new Date().toISOString().slice(0,10); 

        if(item == "" || price == "" || delivery == "" || categoryid == "") {  
            alert("All fields required!");
        } else if (!regex.test(price)) {
            alert("Input a valid amount!");
        } else if (!file) {
            alert("Only jpg/jpeg and png files are allowed!");
        } else {  
            var formdata = new FormData();
            formdata.append('file', $('input[type=file]')[0].files[0]);
            formdata.append('item', item);
            formdata.append('quantity', quantity);
            formdata.append('date', date);
            formdata.append('price', price);
            formdata.append('delivery', delivery);
            formdata.append('categoryid', categoryid);
            formdata.append('desc', desc);
            // Display the key/value pairs
            for(var pair of formdata.entries()) {
                console.log(pair[0]+ ', '+ pair[1]); 
            }
            $.ajax({  
                url:"sellItem_connect2.php",  
                method:"POST",  
                data: formdata, 
                contentType:false,
                processData:false,
                cache:false, 
                dataType: "json",
                // success message
                success:function(data){ 
                    prodid = data.prodid;
                    username = data.username; 

                    // uses web3@0.20.6 and truffle-contract@3.0.6
                    const Web3 = require('web3');
                    const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");
                    $.getJSON('build/contracts/ItemListing.json', function(jsondata) {
                        (async () => {
                            const ItemListing = TruffleContract(jsondata);
                            ItemListing.setProvider(web3Provider);
                            var account = web3.eth.accounts[0];
                            instance = await ItemListing.at("0x3338AA63dDdAA61cC98876fD3b94CcFeE6fFD1A5");
                            
                            instance.ItemList(prodid, username).then(function(data) {
                                alert("Product added!");
                                window.location="accountpage.php";
                            }).catch(function (e) {
                                updateDB(prodid);
                                console.log("Wrong ethereum account.");
                                alert("Please check that you are using the correct ethereum account.");
                                location.reload();
                            });
                            
                        })();
                    });

                }, 
                error: function(data) {
                    console.log(data);
                }
            });  
                       
        }  
        
    });
});

function updateDB(prodid) {
    // store details into json format
    $.ajax({
        method: 'POST',
        url: 'sellItem_connect3.php',
        data: {prodid: prodid},
        success: function(data) { 
            // alert('Item Added!'); 
            // window.location="accountpage.php";
        }
    });
}

// function WriteJSON(prodid, contractAdd, sellerAdd, price, item) {
//     // store details into json format
//     $.ajax({
//         method: 'POST',
//         url: 'sellItem_connect3.php',
//         data: {prodid: prodid, contractAdd: contractAdd, sellerAdd: sellerAdd, prodprice: price, prodname: item},
//         success: function(data) { 
//             alert('Item Added!'); 
//             window.location="accountpage.php";
//         }
//     });
// }



