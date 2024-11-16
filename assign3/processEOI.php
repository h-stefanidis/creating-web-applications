<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Add EOI" />
    <meta name="keywords" content="PHP, HTML" />
    <meta name="author" content="Harrison Stefanidis" />
    <title>EOI Record Table</title>
</head>
<body>
    <h1>EOI Record Table</h1>

    <?php
    /* processEOI.php
    Validation and sanitisation of job application inputs. Creates a new table if not already made, and
    displays information that the user inputted upon job application.
    Author: Harrison Stefanidis
    */

    // Function to sanitise input
    function sanitize_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Function to validate input
    function validate_input($data, $pattern) {
        return preg_match($pattern, $data);
    }

    // Redirect back to form if not submitted via POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: apply.php');
        exit();
    }

    // Validate form data
    $errors = [];

    // Job Reference Number
    if (empty($_POST['refnum']) || !validate_input($_POST['refnum'], '/^[a-zA-Z0-9]{5}$/')) {
        $errors[] = "Job reference number must be exactly 5 alphanumeric characters.";
    } else {
        $job_ref = sanitize_input($_POST['refnum']);
    }

    // First Name
    if (empty($_POST['fname']) || !validate_input($_POST['fname'], '/^[a-zA-Z]{1,20}$/')) {
        $errors[] = "First name must be a maximum of 20 alphabetic characters.";
    } else {
        $fname = sanitize_input($_POST['fname']);
    }

    // Last Name
    if (empty($_POST['lname']) || !validate_input($_POST['lname'], '/^[a-zA-Z]{1,20}$/')) {
        $errors[] = "Last name must be a maximum of 20 alphabetic characters.";
    } else {
        $lname = sanitize_input($_POST['lname']);
    }

    // Date of Birth
    if (empty($_POST['dob']) || !validate_input($_POST['dob'], '/^\d{2}\/\d{2}\/\d{4}$/')) {
        $errors[] = "Date of birth must be in the format dd/mm/yyyy.";
    } else {
        $dob = sanitize_input($_POST['dob']);
        $dob_parts = explode('/', $dob);
        if (!checkdate($dob_parts[1], $dob_parts[0], $dob_parts[2])) {
            $errors[] = "Invalid date of birth.";
        } else {
            $birthdate = DateTime::createFromFormat('d/m/Y', $dob);
            $today = new DateTime();
            $age = $today->diff($birthdate)->y;
            if ($age < 15 || $age > 80) {
                $errors[] = "Date of birth must result in an age between 15 and 80 years.";
            }
        }
    }

    // Gender
    if (empty($_POST['Gender']) || !in_array($_POST['Gender'], ['Male', 'Female', 'Other'])) {
        $errors[] = "Gender is required.";
    } else {
        $gender = sanitize_input($_POST['Gender']);
    }

    // Street Address
    if (empty($_POST['street']) || strlen($_POST['street']) > 40) {
        $errors[] = "Street address must be a maximum of 40 characters.";
    } else {
        $street = sanitize_input($_POST['street']);
    }

    // Suburb/Town
    if (empty($_POST['subtown']) || strlen($_POST['subtown']) > 40) {
        $errors[] = "Suburb/Town must be a maximum of 40 characters.";
    } else {
        $subtown = sanitize_input($_POST['subtown']);
    }

    // State
    $valid_states = ['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'];
    if (empty($_POST['state']) || !in_array($_POST['state'], $valid_states)) {
        $errors[] = "State must be one of VIC, NSW, QLD, NT, WA, SA, TAS, ACT.";
    } else {
        $state = sanitize_input($_POST['state']);
    }

    // Postcode
    if (empty($_POST['postcode']) || !validate_input($_POST['postcode'], '/^[0-9]{4}$/')) {
        $errors[] = "Postcode must be exactly 4 numeric characters.";
    } else {
        $postcode = sanitize_input($_POST['postcode']);
    }

    // Email
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } else {
        $email = sanitize_input($_POST['email']);
    }

    // Phone Number
    if (empty($_POST['phone']) || !validate_input($_POST['phone'], '/^[0-9 ]{8,12}$/')) {
        $errors[] = "Phone number must be 8 to 12 digits or spaces.";
    } else {
        $phone = sanitize_input($_POST['phone']);
    }

    // Skills
    if (empty($_POST['Skills'])) {
        $errors[] = "Skills are required.";
    } else {
        $skills = array_map('sanitize_input', $_POST['Skills']);
        $other_skills = ''; // Initialize other_skills
        if (in_array('Other Skills', $skills) && empty($_POST['OtherSkills'])) {
            $errors[] = "Other skills description is required if 'Other Skills' is selected.";
        } else {
            if (in_array('Other Skills', $skills)) {
                $other_skills = sanitize_input($_POST['OtherSkills']);
            }
        }
        $skills_string = implode(', ', $skills);
    }

    // Display errors if any
    if (!empty($errors)) {
        echo "<p>Error:<br> " . implode("<br>", $errors) . "</p>";
        exit();
    }

    // Database operations
    require_once("settings.php");

    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

    if (!$conn) {
        echo "<p>Database connection failure</p>";
    } else {
        $sql_table = "eoi";

        $create_table_query = "
        CREATE TABLE IF NOT EXISTS $sql_table (
            EOInumber INT AUTO_INCREMENT PRIMARY KEY,
            Status ENUM('new', 'current', 'final') DEFAULT 'new' NOT NULL,
            Job_Reference_Number VARCHAR(5) NOT NULL,
            First_Name VARCHAR(20) NOT NULL,
            Last_Name VARCHAR(20) NOT NULL,
            Street_Address VARCHAR(40) NOT NULL,
            Suburb VARCHAR(40) NOT NULL,
            State ENUM('VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT') NOT NULL,
            Postcode VARCHAR(4) NOT NULL,
            Email_Address VARCHAR(50) NOT NULL,
            Phone_Number VARCHAR(12) NOT NULL,
            Skills TEXT NOT NULL,
            Other_Skills TEXT
        );";

        $create_table_result = mysqli_query($conn, $create_table_query);

        if (!$create_table_result) {
            echo "<p>Error creating table: " . mysqli_error($conn) . "</p>";
        } else {
            $query = "INSERT INTO $sql_table (Job_Reference_Number, First_Name, Last_Name, Street_Address, Suburb, State, Postcode, Email_Address, Phone_Number, Skills, Other_Skills) VALUES ('$job_ref', '$fname', '$lname', '$street', '$subtown', '$state', '$postcode', '$email', '$phone', '$skills_string', '$other_skills')";

            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<p>Error: " . mysqli_error($conn) . "</p>";
            } else {
                $eoi_number = mysqli_insert_id($conn);
                echo "<p>Member added successfully. Your EOI number is: $eoi_number</p>";
                echo "<h2>Submitted Data</h2>";
                echo "<table border='1'>";
                echo "<tr><th>Field</th><th>Value</th></tr>";
                echo "<tr><td>Job Reference Number</td><td>$job_ref</td></tr>";
                echo "<tr><td>First Name</td><td>$fname</td></tr>";
                echo "<tr><td>Last Name</td><td>$lname</td></tr>";
                echo "<tr><td>Date of Birth</td><td>$dob</td></tr>";
                echo "<tr><td>Gender</td><td>$gender</td></tr>";
                echo "<tr><td>Street Address</td><td>$street</td></tr>";
                echo "<tr><td>Suburb/Town</td><td>$subtown</td></tr>";
                echo "<tr><td>State</td><td>$state</td></tr>";
                echo "<tr><td>Postcode</td><td>$postcode</td></tr>";
                echo "<tr><td>Email</td><td>$email</td></tr>";
                echo "<tr><td>Phone Number</td><td>$phone</td></tr>";
                echo "<tr><td>Skills</td><td>$skills_string</td></tr>";
                if (!empty($other_skills)) {
                    echo "<tr><td>Other Skills</td><td>$other_skills</td></tr>";
                }
                echo "</table>";
            }
        }

        mysqli_close($conn);
    }
    ?>
</body>
</html>