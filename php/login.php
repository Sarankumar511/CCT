<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: ../course.html");
    exit;
}
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
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT username, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($username, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['username'] = $username;
        header("Location: ../course.php");
    } else {
        echo "Invalid email or password";
    }

    $stmt->close();
}

$conn->close();
?>
