<?php  
// https://websitebeaver.com/prepared-statements-in-php-mysqli-to-prevent-sql-injection
require('config.php'); 
session_start(); //start session
if(isset($_POST["username"])) {  
    $username = mysqli_real_escape_string($conn, $_POST["username"]);  
    $password = mysqli_real_escape_string($conn, $_POST["password"]);  

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $QUERY = "SELECT u.userid, username, userpass, user_fullname, seller_id 
                    FROM eshop.users u
                    LEFT JOIN eshop.seller s 
                    ON u.userid = s.userid
                    WHERE username = ?";
    
        if ($stmt = $conn->prepare($QUERY)) {
            //prepared statement
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    
                    $_SESSION["username"] = $row["username"]; //set session
                    $_SESSION["buyerid"] = $row["userid"]; //set session

                    if ($row["seller_id"] != null)
                        $_SESSION["sellerid"] = $row["seller_id"]; //set session


                    $fullname = $row["user_fullname"];                    
                    if ($username == $row["username"] && $password == $row["userpass"]) {
                        echo "Welcome " . "$fullname" . "!"; //anything on success
                    } else {
                        // echo "<script type='text/javascript'>
                        //      alert('Wrong username or password!');
                        //      window.location = 'login.php';
                        //      </script>"; 
                        die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
                    }
                }
            }else {
                die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
            }
            $stmt->close();
        }
        $conn->close();
    }
}  
 ?> 