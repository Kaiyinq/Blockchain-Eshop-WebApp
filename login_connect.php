<?php  
require('config.php'); 
if(isset($_POST["username"])) {  
    $username = mysqli_real_escape_string($conn, $_POST["username"]);  
    $password = mysqli_real_escape_string($conn, $_POST["password"]);  

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $QUERY = "SELECT username, userpass, user_fullname FROM eshop.users WHERE username = ?";
    
        if ($stmt = $conn->prepare($QUERY)) {
            //prepared statement
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    //echo "id: " . $row["userid"]. " - Name: " . $row["username"]. " Password:" . $row["userpass"]. "<br>";
                    //json_encode($row["user_id"]);
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