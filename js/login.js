// FOR LOGIN.PHP AND LOGIN_CONNECT.PHP

//regular expression
//var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
var passwordRegEx = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})");

$(document).ready(function(){  
  $('#submitBtn').click(function(){  
    var username = $('#username').val();  
    var password = $('#password').val();  
    if(username == '' || password == '') {  
      alert("All fields required");
    } else if (!password.match(passwordRegEx)) {
      alert("Wrong password format.");
    } else {  
      $.ajax({  
        url:"login_connect.php",  
        method:"POST",  
        data:{username:username, password:password},  
        // success message
        success:function(data){  
          alert(data); 
          window.location="accountpage.php";
        },
        // error message
        error:function(data){
          alert("Your username and password didn't match. Please try again!");
        }
      });  
    }  
  });  
});  
