<?php
/* manage.php
   Displays relevant table information about job applicants and provides options to adjust table information
   as well as a logout option at the bottom.
   Author: Harrison Stefanidis
*/

session_start(); // Start or resume a session

// Check if the user is not logged in; if not, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit; // Terminate script execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Manage EOIs" />
    <meta name="keywords" content="PHP, SQL, Management" />
    <meta name="author" content="Harrison Stefanidis" />
    <title>Manage EOIs</title>
</head>
<body>
    <h1>Manage EOIs</h1>

    <?php
    require_once("settings.php"); // Include connection settings

    $conn = @mysqli_connect($host, $user, $pwd, $sql_db); // Establish database connection

    if (!$conn) {
        echo "<p>Database connection failure</p>"; // Display error message if connection fails
    } else {
        // Define functions for handling the various operations

        // Function to list all EOIs
        function listAllEOIs($conn) {
            $sql = "SELECT * FROM eoi";
            $result = mysqli_query($conn, $sql); // Execute SQL query

            if ($result) {
                // Display table with EOIs data
                echo "<h2>All EOIs</h2><table border='1'><tr>
                    <th>EOI ID</th><th>Job Reference</th><th>First Name</th><th>Last Name</th>
                    <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th>
                    <th>Email Address</th><th>Phone Number</th><th>Skills</th><th>Other Skills</th><th>Status</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    // Output each row of data as a table row
                    echo "<tr><td>{$row['EOInumber']}</td><td>{$row['Job_Reference_Number']}</td>
                        <td>{$row['First_Name']}</td><td>{$row['Last_Name']}</td>
                        <td>{$row['Street_Address']}</td><td>{$row['Suburb']}</td><td>{$row['State']}</td>
                        <td>{$row['Postcode']}</td><td>{$row['Email_Address']}</td><td>{$row['Phone_Number']}</td>
                        <td>{$row['Skills']}</td><td>{$row['Other_Skills']}</td><td>{$row['Status']}</td></tr>";
                }
                echo "</table>";
                mysqli_free_result($result); // Free result memory
            } else {
                echo "<p>Something is wrong with the query: $sql</p>"; // Display error message if query fails
            }
        }

        // Function to list EOIs by job reference
        // https://www.w3schools.com/php/php_mysql_prepared_statements.asp
        function listEOIsByJobRef($conn, $jobRef) {
            $stmt = $conn->prepare("SELECT * FROM eoi WHERE Job_Reference_Number = ?");
            $stmt->bind_param("s", $jobRef);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Display table with EOIs filtered by job reference
                echo "<h2>EOIs for Job Reference: $jobRef</h2><table border='1'><tr>
                    <th>EOI ID</th><th>Job Reference</th><th>First Name</th><th>Last Name</th>
                    <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th>
                    <th>Email Address</th><th>Phone Number</th><th>Skills</th><th>Other Skills</th><th>Status</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    // Output each row of data as a table row
                    echo "<tr><td>{$row['EOInumber']}</td><td>{$row['Job_Reference_Number']}</td>
                        <td>{$row['First_Name']}</td><td>{$row['Last_Name']}</td>
                        <td>{$row['Street_Address']}</td><td>{$row['Suburb']}</td><td>{$row['State']}</td>
                        <td>{$row['Postcode']}</td><td>{$row['Email_Address']}</td><td>{$row['Phone_Number']}</td>
                        <td>{$row['Skills']}</td><td>{$row['Other_Skills']}</td><td>{$row['Status']}</td></tr>";
                }
                echo "</table>";
                mysqli_free_result($result); // Free result memory
            } else {
                echo "<p>No EOIs found for job reference: $jobRef.</p>"; // Display message if no matching EOIs found
            }
        }

        // Function to list EOIs by applicant
        function listEOIsByApplicant($conn, $firstName, $lastName) {
            // Add wildcard characters for SQL query
            $firstNamePattern = "%$firstName%";
            $lastNamePattern = "%$lastName%";
            $sql = "SELECT * FROM eoi WHERE First_Name LIKE ? AND Last_Name LIKE ?";
            
            // Prepare and execute the SQL query
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $firstNamePattern, $lastNamePattern);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if there are any results
            if ($result->num_rows > 0) {
                // Display table with EOIs filtered by applicant's name
                echo "<h2>EOIs for Applicant: $firstName $lastName</h2><table border='1'><tr>
                    <th>EOI ID</th><th>Job Reference</th><th>First Name</th><th>Last Name</th>
                    <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th>
                    <th>Email Address</th><th>Phone Number</th><th>Skills</th><th>Other Skills</th><th>Status</th></tr>";
                
                // Loop through each row in the result set
                while ($row = mysqli_fetch_assoc($result)) {
                    // Display each EOI record in a table row
                    echo "<tr><td>{$row['EOInumber']}</td><td>{$row['Job_Reference_Number']}</td>
                        <td>{$row['First_Name']}</td><td>{$row['Last_Name']}</td>
                        <td>{$row['Street_Address']}</td><td>{$row['Suburb']}</td><td>{$row['State']}</td>
                        <td>{$row['Postcode']}</td><td>{$row['Email_Address']}</td><td>{$row['Phone_Number']}</td>
                        <td>{$row['Skills']}</td><td>{$row['Other_Skills']}</td><td>{$row['Status']}</td></tr>";
                }
                
                // Close the table
                echo "</table>";
                
                // Free the result set
                mysqli_free_result($result);
            } else {
                // No EOIs found for the applicant
                echo "<p>No EOIs found for applicant: $firstName $lastName.</p>";
            }
        }

        // Function to delete EOIs by job reference
        function deleteEOIsByJobRef($conn, $jobRef) {
            $stmt = $conn->prepare("DELETE FROM eoi WHERE Job_Reference_Number = ?");
            $stmt->bind_param("s", $jobRef);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "<p>Deleted all EOIs with job reference: $jobRef.</p>";
            } else {
                echo "<p>No EOIs found for job reference: $jobRef.</p>";
            }
        }

        // Function to update EOI status
        function updateEOIStatus($conn, $eoiId, $status) {
            $valid_statuses = array('new', 'current', 'final');
            if (!in_array($status, $valid_statuses)) {
                die("Invalid status value.");
            }

            $stmt = $conn->prepare("UPDATE eoi SET Status = ? WHERE EOInumber = ?");
            $stmt->bind_param("si", $status, $eoiId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "<p>Updated Status for EOI ID: $eoiId to $status.</p>";
            } else {
                echo "<p>No EOI found with ID: $eoiId.</p>";
            }
        }

        // Process form submissions
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['list_all'])) {
                listAllEOIs($conn);
            } elseif (isset($_POST['list_by_jobref'])) {
                listEOIsByJobRef($conn, $_POST['job_ref']);
            } elseif (isset($_POST['list_by_applicant'])) {
                listEOIsByApplicant($conn, $_POST['First_Name'], $_POST['Last_Name']);
            } elseif (isset($_POST['delete_by_jobref'])) {
                deleteEOIsByJobRef($conn, $_POST['job_ref']);
            } elseif (isset($_POST['update_Status'])) {
                updateEOIStatus($conn, $_POST['EOInumber'], $_POST['Status']);
            }
        }

        // Close the database connection
        mysqli_close($conn);
    }
    ?>

    <!-- HTML form for user interaction -->
    <form method="post">
        <fieldset>
            <legend>List All EOIs</legend>
            <button type="submit" name="list_all">List All EOIs</button>
        </fieldset>

        <fieldset>
            <legend>List or Delete EOIs by Job Reference</legend>
            <label for="job_ref">Job Reference Number:</label>
            <input type="text" id="job_ref" name="job_ref">
            <button type="submit" name="list_by_jobref">List EOIs by Job Reference</button>
            <button type="submit" name="delete_by_jobref">Delete EOIs by Job Reference</button>
        </fieldset>

        <fieldset>
            <legend>List EOIs by Applicant</legend>
            <label for="First_Name">First Name:</label>
            <input type="text" id="First_Name" name="First_Name">
            <label for="Last_Name">Last Name:</label>
            <input type="text" id="Last_Name" name="Last_Name">
            <button type="submit" name="list_by_applicant">List EOIs by Applicant</button>
        </fieldset>

        <fieldset>
            <legend>Update EOI Status</legend>
            <label for="EOInumber">EOI ID:</label>
            <input type="text" id="EOInumber" name="EOInumber">
            <label for="Status">Status:</label>
            <select id="Status" name="Status">
                <option value="new">New</option>
                <option value="current">Current</option>
                <option value="final">Final</option>
            </select>
            <button type="submit" name="update_Status">Update EOI Status</button>
        </fieldset>
    </form>

    <!-- Logout form -->
    <form action="logout.php" method="post">
        <button type="submit" name="logout">Logout</button>
    </form>
</body>
</html>