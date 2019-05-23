// FOR ACCOUNTPAGE.PHP AND ACCOUNTPAGE_CONNECT.PHP

function toReview() {
    $.ajax({  
        url:"accountpage_connect5.php",  
        method:"GET",   
        dataType: "html",
        success: function(data) {
            $("#toReview").html(data); 
        }
    }); 
}

function toReceiveList() {
    $.ajax({  
        url:"accountpage_connect4.php",  
        method:"GET",   
        dataType: "html",
        success: function(data) {
            $("#toReceive").html(data); 
        }
    });
}

function toShipList() {
    $.ajax({  
        url:"accountpage_connect3.php",  
        method:"GET",   
        dataType: "html",
        success: function(data) {
            $("#toShip").html(data); 
        }
    }); 
}

$(document).ready(function(){  
    
    $.ajax({  
        url:"accountpage_connect2.php",  
        method:"GET",   
        dataType: "html",
        success: function(data) {
            $("#sellerinfo").html(data); 
            toShipList();
            toReceiveList();
            toReview();
        }
    });      
    
    // function confirmDelivery() {
    //     alert("haha");
    // }
    
});  



// for accountpage.js solidity checking -//updateDB(orderId, 2, "Cancelled");
// function updateDB(orderId, rejectSlip, orderStatus) {
//     $.ajax({
//         method: 'POST',
//         url: 'viewBuyerOrder_connect2.php',
//         data: {orderId:orderId, rejectSlip:rejectSlip, orderStatus:orderStatus},
//         success: function(data) { 
//             //console.log(data);
//             //alert('Shipping confirmation made!'); 
//             location.reload();
//         }
//     });
// }