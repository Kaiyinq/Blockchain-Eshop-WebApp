//regular expression
var phoneRegEx = new RegExp("^(8|9)[0-9]{7}");
var emailRegEx = new RegExp("^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$");

$(document).ready(function(){  
  $('#submitBtn').click(function(){  
    var accountType = $("input[name='account']:checked").val();; 
    var phone = $('#phone').val();  
    var name = $('#name').val();
    var emailAdd = $('#emailAdd').val();
    if(phone == '' || name == '' || emailAdd == '') {  
      alert("All fields required!");
    } else if (!phone.match(phoneRegEx)) {
      alert("Please enter a valid phone number!");
    } else if (!emailAdd.match(emailRegEx)) {
      alert("Invalid Email!");
    } else {  
      $.ajax({  
        url:"registerSeller_connect.php",  
        method:"POST",  
        data:{name:name, phone:phone, accountType:accountType, emailAdd:emailAdd,},  
        // success message
        success:function(data){  
          alert(data); 
          window.location="home.php";
        },
        // error message
        error:function(data){
            alert("Please sign in!");
          }
      });  
    }  
  });  
});  

