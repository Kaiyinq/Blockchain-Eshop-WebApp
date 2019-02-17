<?php
require('config.php');
session_start();
if(isset($_POST['submitBtn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) || !empty($password)) {
        if (mysqli_connect_error()) {
            die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
        } else {
            $QUERY = "SELECT user_id, username, userpass, user_fullname FROM eshop.users WHERE username = ?";
            
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
                            echo "<script type='text/javascript'>
                                alert('Welcome ' + '$fullname' + '!');
                                window.location = 'home.html';
                                </script>"; 
                        } else {
                            echo "<script type='text/javascript'>
                                alert('Wrong username or password!');
                                window.location = 'login.php';
                                </script>"; 
                        }
                    }
                }else {
                    echo "No results";
                }
            
                $stmt->close();
            }
            
            $conn->close();
        }

    } else {
        echo "All fields required!";
        die(); 
    }
} 

?>