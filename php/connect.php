<?php
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) || !empty($password)) {
        $host="localhost";      // Host name.
        $db_user="root";        // MySQL username.
        $db_password="1234";    // MySQL password.
        $database="eshop";      // Database name.
        $conn = new mysqli($host, $db_user, $db_password, $database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT username FROM eshop.users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<br> username: ". $row["username"]. "<br>";
            }
        } else {
            echo "0 results";
        }

        $conn->close();

    } else {
        echo "All fields required!";
        die(); // 
    }
?>