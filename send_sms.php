<?php 

// Include the bundled autoload from the Twilio PHP Helper Library
require __DIR__ . '/twilio-php-master/Twilio/autoload.php';
use Twilio\Rest\Client;

if(isset($_POST['username'])) {
    $username = $_POST['username'];
    $phone_no = "+65" . $username;
    $OTP = generateNumericOTP(6);

    // Your Account SID and Auth Token from twilio.com/console
    $account_sid = 'AC49f83d7f49c7835f06888336220f9cf8';
    $auth_token = '39686fa92bd77443b733b35b94366eb2';
    $twilio_number = "+14012340861";
    $client = new Client($account_sid, $auth_token);
    $msg = 'Your Eshop verification code is: ' . $OTP;
    $client->messages->create(
        // Where to send a text message (your cell phone?)
        $phone_no,
        array(
            'from' => $twilio_number,
            'body' => $msg
        )
    );

    echo $OTP;
    
}
 
// Function to generate OTP 
function generateNumericOTP($n) { 
    
    // Take a generator string which consist of 
    // all numeric digits 
    $generator = "1357902468"; 

    // Iterate for n-times and pick a single character 
    // from generator and append it to $result 

    // Login for generating a random character from generator 
    //     ---generate a random number 
    //     ---take modulus of same with length of generator (say i) 
    //     ---append the character at place (i) from generator to result 

    $result = ""; 

    for ($i = 0; $i < $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    } 

    // Return result 
    return $result; 
} 


?>