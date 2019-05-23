<?php
require('config.php');

if(isset($_POST['username'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $emailAdd = mysqli_real_escape_string($conn, $_POST['emailAdd']);
    $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    // $dob = str_replace('/', '-', $birthdate);
    // $date = date('Y-m-d', strtotime($dob));

    if (mysqli_connect_error()) {
        die('Connection Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT username, user_email FROM eshop.users WHERE username = ?";
        $INSERT = "INSERT INTO eshop.users (username, userpass, user_fullname, user_address, user_gender, user_dob, user_email) VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($SELECT)) {
            //prepared statement
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) { 
                // Existing an account with same username
                while ($row = $result->fetch_assoc()) {                
                    if ($username == $row["username"]) {
                        die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
                    }
                }
            }else {
                // No existing account
                $stmt->close();
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param('issssss', $username, $password, $fullname, $address, $gender, $birthdate, $emailAdd);
                $stmt->execute();
                echo "Account is successfully created!";
            }
            $stmt->close();
        }
        $conn->close();
    }
} 
?>