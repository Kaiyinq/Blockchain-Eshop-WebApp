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

$(document).ready(function(){ 
    $('#submitBtn').click(function(){  
        var item = $('#itemname').val(); 
        var quantity = $('#quantity').val();
        var price = $('#price').val();  
        var delivery = $('#shipmethod').val();
        var categoryid = $('#category').val();
        var desc = $('#desc').val();
        var prodid;
        var contractAdd;
        var sellerAdd;
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
                // success message
                success:function(data){  
                    prodid = data;
                    
                    // uses web3@0.20.6 and truffle-contract@3.0.6
                    const Web3 = require('web3');
                    const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");
                    $.getJSON('build/contracts/ItemListing.json', function(jsondata) {
                        (async () => {
                            const MetaCoin = TruffleContract(jsondata);
                            MetaCoin.setProvider(web3Provider);
                            var account = web3.eth.accounts[0];
                            const instance = await MetaCoin.new({from: account, gas: 3000000});
                            contractAdd = instance.address; 
                            console.log(contractAdd);
                            instance.ItemList("shoes", 3);
                            instance.getSellerAdd.call().then(function(add) {
                                sellerAdd = add;
                                console.log(add);
                                // store details into json format
                                WriteJSON(prodid, contractAdd, sellerAdd, price, item);
                            });
                        })();
                    });

                },
                // error message
                error:function(data){
                    console.log("Error");
                }
            });  
                       
        }  
        
    });
});  

function WriteJSON(prodid, contractAdd, sellerAdd, price, item) {
    // store details into json format
    $.ajax({
        method: 'POST',
        url: 'sellItem_connect3.php',
        data: {prodid: prodid, contractAdd: contractAdd, sellerAdd: sellerAdd, prodprice: price, prodname: item},
        success: function(data) { 
            console.log(data);
            alert('write succesful!'); 
            //window.location="accountpage.php";
        }
    });
}



