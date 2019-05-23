// FOR SELLUPDATESTATUS.PHP AND SELLUPDATESTATUS_CONNECT.PHP

var file = false;
var regex  = /^\d+(?:\.\d{0,2})$/;
var formdata;
var orderId;

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
    var url = new URL(window.location.href);
    orderId = url.searchParams.get("order");
    console.log(orderId);
    
    $('#submitBtn').click(function(){  

        var dateTime = new Date().toISOString().slice(0, 19).replace('T', ' '); 
        
        if (!file) {
            alert("Only jpg/jpeg and png files are allowed!");
        } else {  
            formdata = new FormData();
            formdata.append('file', $('input[type=file]')[0].files[0]);
            formdata.append('dateTime', dateTime);
            formdata.append('orderId', orderId);
            // Display the key/value pairs
            // for(var pair of formdata.entries()) {
            //     console.log(pair[0]+ ', '+ pair[1]); 
            // }
            $.ajax({  
                url:"retrieveAdd_connect.php",  
                method:"POST",  
                data: {orderId:orderId},
                // success message
                success:function(data){  
                    console.log("Order contract address: " + data);

                    const Web3 = require('web3');
                    const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");
                    $.getJSON('build/contracts/EscrowCon.json', function(jsondata) {
                        (async () => {
                            const Escrow = TruffleContract(jsondata);
                            Escrow.setProvider(web3Provider);
                            account = web3.eth.accounts[0]; 
                            instance = await Escrow.at(data);
                            
                            // seller update order status
                            instance.uploadSlip.sendTransaction().then(function(data) {
                                console.log("Transaction Hash: " + data);
                               updateDB();
                            }).catch(function (e) {
                                console.log("Wrong account.");
                                alert("Please check if you are using the correct account.");
                                // $('#danger').html("Please check if you are using the correct ethereum account.");
                                // document.getElementById('danger').style.display = "block";
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


function updateDB() {
    $.ajax({  
        url:"sellUpdateStatus_connect.php",  
        method:"POST",  
        data: formdata, 
        contentType:false,
        processData:false,
        cache:false, 
        // success message
        success:function(data){  
            console.log("Seller update the shipping slip." + data);
            alert("Order Status update. Send to buyer for confirmation.");
            window.location = "viewOverall.php?order=" + orderId;
        }
    });
}