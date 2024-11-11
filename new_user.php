<?php

// session start here...
session_start();
include_once 'validate.php';

// get all 3 strings from the form (and scrub w/ validation function)
$username = test_input($_POST['user']);
$password = test_input($_POST['pwd']);
$repeat = test_input($_POST['repeat']);

// make sure that the two password values match!
if ($password !== $repeat) {
    header("Location: register.php");
    exit();
}


// create the password_hash using the PASSWORD_DEFAULT argument
$pw_hash = password_hash($password, PASSWORD_DEFAULT);

// login to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "softball";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// make sure that the new user is not already in the database
$sql = "SELECT id FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    header("Location: register.php");
    exit();
}
// insert username and password hash into db (put the username in the session
// or make them login)
$insert_sql = "INSERT INTO users (username, password) VALUES ('$username', '$pw_hash')";

if ($conn->query($insert_sql) === TRUE) {
    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit();
} else {
    header("Location: register.php");
    exit();
}
$conn->close();
?>