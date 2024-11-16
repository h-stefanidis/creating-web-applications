<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Manager Registration Information">
    <meta name="keywords" content="PHP, SQL, Manager">
    <meta name="author" content="Harrison Stefanidis">
    <title>Manager Registration Information</title>
</head>
<body>
<?php
/* manager.php
   Retrieves and displays manager registration information from the 'managers' table in the database.
   Author: Harrison Stefanidis
*/

// Include connection settings
require_once("settings.php");

// Establish database connection
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

// Check if the connection is successful
if (!$conn) {
    die("Database connection failure");
}

// Check if the managers table exists
$table_check = mysqli_query($conn, "SHOW TABLES LIKE 'managers'");
if (mysqli_num_rows($table_check) == 0) {
    // If the 'managers' table does not exist
    echo "Table 'managers' does not exist in the database.";
} else {
    // If the 'managers' table exists
    // Retrieve data from the table
    $result = mysqli_query($conn, "SELECT * FROM managers");

    // Check if there are records in the table
    if ($result && mysqli_num_rows($result) > 0) {
        // If records are found, display them in a table format
        echo "<h2>Manager Registration Information</h2>";
        echo "<table border='1'><tr><th>ID</th><th>Username</th><th>Password</th><th>Failed Attempts</th><th>Lock Until</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            // Output each row of data as a table row
            echo "<tr><td>{$row['id']}</td><td>{$row['username']}</td><td>{$row['password']}</td><td>{$row['failed_attempts']}</td><td>{$row['lock_until']}</td></tr>";
        }
        echo "</table>";
    } else {
        // If no records are found in the table
        echo "No records found in the 'managers' table.";
    }
}

// Close the database connection
mysqli_close($conn);
?>
</body>
</html>