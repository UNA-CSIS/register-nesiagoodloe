<?php

// start session
session_start();

include 'validate.php';

$username = test_input($_POST['username']);
$password = test_input($_POST['password']);

// login to the softball database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "softball";

// Create database connection
$con = mysqli_connect($servername, $username, $password, $dbname);
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}

$query = "SELECT password FROM users WHERE username = '$username'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Verify password from form against hashed password in database
    if (password_verify($password, $row['password'])) {
        $_SESSION['username'] = $username;  // Store username in session
        header("Location: index.php");      // Redirect to a secure page
        exit();
    }
}

// Redirect to login page on failure
header("Location: register.php");
$conn->close();

// select password from users where username = <what the user typed in>
// Redirect to a secure page
// if no rows, then username is not valid (but don't tell Mallory) just send
// her back to the login
// otherwise, password_verify(password from form, password from db)
// if good, put username in session, otherwise send back to login
?>