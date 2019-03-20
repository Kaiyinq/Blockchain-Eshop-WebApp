// FOR REGISTER.PHP AND REGISTER_CONNECT.PHP

//regular expression
//var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
var passwordRegEx = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})");
var phoneRegEx = new RegExp("^(8|9)[0-9]{7}");
var emailRegEx = new RegExp("^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$");

$(document).ready(function(){  
  $('#submitBtn').click(function(){  
    var fullname = $('#fullname').val(); 
    var username = $('#phone').val();  
    var password = $('#password').val();
    var address = $('#address').val();
    var emailAdd = $('#emailAdd').val();
    var birthdate = $('#birthdate').val();
    var gender = $('#gender').val();
    if(username == "" || password == "" || fullname == "" || address == "" || emailAdd == "" || birthdate == "" || gender == '') {  
      alert("All fields required!");
    } else if (!username.match(phoneRegEx)) {
      alert("Please enter a valid phone number!");
    } else if (!password.match(passwordRegEx)) {
      alert("Wrong Password Format!");
    } else if (!emailAdd.match(emailRegEx)) {
      alert("Invalid Email!");
    } else {  
      $.ajax({  
        url:"register_connect.php",  
        method:"POST",  
        data:{username:username, password:password, fullname:fullname, address:address, emailAdd:emailAdd, birthdate:birthdate, gender:gender},  
        // success message
        success:function(data){  
          alert(data); 
          window.location="home.php";
        },
        // error message
        error:function(data){
          alert("Existing account! Please re-enter a valid phone number!");
        }
      });  
    }  
  });
});  

