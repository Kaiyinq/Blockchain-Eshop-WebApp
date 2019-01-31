<?php
session_start();
if(isset($_POST['submitBtn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) || !empty($password)) {
        $host="127.0.0.1";  // Host name.
        $db_user="root";    // MySQL username.
        $db_password="";    // MySQL password.
        $db_name="eshop";  // Database name.
        $conn = new mysqli($host, $db_user, $db_password, $db_name);

        if (mysqli_connect_error()) {
            die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
        } else {
            $QUERY = "SELECT userid, username, userpass FROM eshop.users WHERE username = ?";
            
            if ($stmt = $conn->prepare($QUERY)) {
                //prepared statement
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        //echo "id: " . $row["userid"]. " - Name: " . $row["username"]. " Password:" . $row["userpass"]. "<br>";
                        json_encode($row["userid"]);

                        if ($username == $row["username"] && $password == $row["userpass"]) {
                            echo "<script type='text/javascript'>
                                alert('Welcome ' + '$username' + '!');
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