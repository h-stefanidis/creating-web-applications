<?php
/* register.php
   Manager registration with unique username and password. Upon successful registration, user is
   redirected to login.html.
   Author: Harrison Stefanidis
*/

require_once("settings.php"); // Include connection settings

$conn = @mysqli_connect($host, $user, $pwd, $sql_db); // Establish database connection

if (!$conn) {
    die("Database connection failure"); // Terminate script if database connection fails
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match."; // Error message if passwords don't match
        exit();
    }

    // Check if username already exists
    // https://www.w3schools.com/php/php_mysql_prepared_statements.asp
    $stmt = $conn->prepare("SELECT COUNT(*) FROM managers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "Username already exists."; // Error message if username already exists
        exit();
    }

    // Check if password already exists (not recommended for security reasons)
    $stmt = $conn->prepare("SELECT COUNT(*) FROM managers WHERE password = ?");
    $stmt->bind_param("s", $password);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "Password already exists."; // Error message if password already exists (not recommended)
        exit();
    }

    // Insert new manager
    $stmt = $conn->prepare("INSERT INTO managers (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    if ($stmt->execute()) {
        // Registration successful, redirect to login page
        header("Location: login.html");
        exit; // Stop further execution
    } else {
        echo "Registration failed."; // Error message if registration fails
    }
    $stmt->close();
}

mysqli_close($conn); // Close database connection
?>

