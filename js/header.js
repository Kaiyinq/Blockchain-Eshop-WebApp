// FOR HEADER.PHP AND HEADER-ACCCART.PHP - ACCOUNT AND CART

$(document).ready(function(){  
    $.ajax({  
        url:"header-acccart.php",  
        method:"GET",   
        dataType: "html",
        success: function(data) {
            $("#accAndCart").html(data); 

            $('#checkout').click(function(){ 
                window.location="checkout.php"; 
            });
        }
    });    
}); 
