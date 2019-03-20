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
     
});  

