<?php
/* login.php
   General login function that has timeout function upon three incorrect entries
   Author: Harrison Stefanidis
*/

// Start a new session or resume the existing session
session_start();

// Include the file containing database connection settings
require_once("settings.php");

// Establish a connection to the MySQL database server
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

// Check if the database connection was successful
if (!$conn) {
    // Terminate script execution and display an error message if connection fails
    die("Database connection failure");
}

// Check if the HTTP request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the username and password submitted via the POST method
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare an SQL statement to select user information from the 'managers' table
    // https://www.w3schools.com/php/php_mysql_prepared_statements.asp
    $stmt = $conn->prepare("SELECT id, password, failed_attempts, lock_until FROM managers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $stored_password, $failed_attempts, $lock_until);
    $stmt->fetch();

    // Check if the user account is locked
    if ($lock_until && strtotime($lock_until) > time()) {
        // If the account is locked, terminate script execution and display a message
        die("Your account is locked. Please try again later.");
    }

    // Check if the submitted password matches the stored password
    if ($stored_password === $password) {
        // If the password is correct, set the session variable and update user data
        $_SESSION['username'] = $username;
        $stmt->close();

        // Reset failed login attempts and lock status
        $stmt = $conn->prepare("UPDATE managers SET failed_attempts = 0, lock_until = NULL WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Redirect the user to the management page
        header("Location: manage.php");
        exit(); // Stop further script execution
    } else {
        // If the password is incorrect, update failed login attempts and lock status
        $stmt->close();
        $failed_attempts++;
        $lock_until = ($failed_attempts >= 3) ? date("Y-m-d H:i:s", strtotime("+15 minutes")) : NULL;

        $stmt = $conn->prepare("UPDATE managers SET failed_attempts = ?, lock_until = ? WHERE username = ?");
        $stmt->bind_param("iss", $failed_attempts, $lock_until, $username);
        $stmt->execute();
        $stmt->close();

        // Display an error message for invalid login credentials
        die("Invalid login credentials.");
    }

    // Close the database connection
    mysqli_close($conn);
}
?>