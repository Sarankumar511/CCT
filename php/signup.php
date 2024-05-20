<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sarandb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);
    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        header("Location: course.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
}
$conn->close();
?>
