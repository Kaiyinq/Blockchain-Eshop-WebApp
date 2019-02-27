$('.size').click(function(){ 
    var size = $(this).attr('id'); 
    $('#' + size).addClass('active');
    return false; 
});

$('#brandlist').append(
    $('<li>').append(
        $('<a>').attr('href','#').append("Channel")
));  

$(document).ready(function(){  
    $.ajax({  
        url:"products_connect.php",  
        method:"GET",   
        dataType: "html",
        success: function(data) {
            $("#productlist").html(data); 

            $('#viewprod').click(function(){ 
                window.location="productpage.php"; //UNDONE (SHOULD LINK TO SPECFIC PRODUCT)
            });
        }
    });    
});  

