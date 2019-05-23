// FOR REGISTER.PHP AND REGISTER_CONNECT.PHP

//regular expression
//var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
var passwordRegEx = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})");
var phoneRegEx = new RegExp("^(8|9)[0-9]{7}");
var emailRegEx = new RegExp("^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$");

// const Web3 = require('web3');
// const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");
// $.getJSON('build/contracts/Users.json', function(jsondata) {
//     (async () => {
//         const Users = TruffleContract(jsondata);
//         Users.setProvider(web3Provider);
//         account = web3.eth.accounts[0]; 
//         instance = await Users.at("0xEEa1012e5eF6C0B44bDAB51b3FE07aF3C6d71181");
        
//         // Buyer - 82344444
//         // Seller - 91122334
//         instance.addUser("91122334").then(function(data) { 
//             console.log("Valid account!");

//         }).catch(function (e) {
//             console.log("Duplicated phone number or Ethereum account.");
//             alert("Existing account! Please use a valid username or ethereum account.");
//             location.reload();
//         });         

//     })();
// });

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

      // SHOULD SEND OTP TO THE MOBILE NUMBER FOR VERIFICATION FIRST 
      $.ajax({  
        url:"send_sms.php",  
        method:"POST",  
        data:{username:username},  
        // success message
        success:function(data){  
          var answer = prompt('Please enter the verification code.');

          if(answer == data) {
            const Web3 = require('web3');
            const web3Provider = new Web3.providers.HttpProvider("http://127.0.0.1:8545");

            $.getJSON('build/contracts/Users.json', function(jsondata) {
                (async () => {
                    const Users = TruffleContract(jsondata);
                    Users.setProvider(web3Provider);
                    account = web3.eth.accounts[0]; 
                    instance = await Users.at("0xEEa1012e5eF6C0B44bDAB51b3FE07aF3C6d71181");
                    
                    instance.addUser(username).then(function(data) {
                      console.log("Valid account!");

                      $.ajax({  
                        url:"register_connect.php",  
                        method:"POST",  
                        data:{username:username, password:password, fullname:fullname, address:address, emailAdd:emailAdd, birthdate:birthdate, gender:gender},  
                        // success message
                        success:function(data){  
                          alert(data); 
                          window.location="login.php";
                        },
                        // error message
                        error:function(data){
                          alert("Existing account!");
                        }
                      });

                    }).catch(function (e) {
                      console.log("Duplicated phone number or Ethereum account.");
                      alert("Existing account! Please use a valid number or ethereum account.");
                      location.reload();
                    });         

                })();
            });
          } else {
            alert("Wrong verification! Please try again!");
            location.reload();
          }

        }
      });      
    }  
  });
});
