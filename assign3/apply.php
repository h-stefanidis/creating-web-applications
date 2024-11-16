<!DOCTYPE html>
<html lang="en">
        <meta charset="utf-8" />
        <meta name="description" content="apply" />
        <meta name="keywords" content="apply" />
        <meta name="author" content="Harrison Stefanidis" />
        <title>Apply</title>

        <!-- Tab Icon -->
        <link rel="icon" type="image/x-icon" href="images/apply.png">

        <!-- CSS For HTML -->
        <link href="styles/style.css" rel="stylesheet" />
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>

        <!-- JavaScript for HTML -->
        <script src="scripts/enhancements.js"></script>
        <script src="scripts/apply.js"></script>

    </head>
    <body>
        <!-- Title -->
        <?php include 'headerapply.inc'; ?>

        <!-- Navigation -->
        <?php include 'menu.inc'; ?>

        <!-- Job Reference Number, First/Last Name -->
        <form method="POST" id ="regform" action="processEOI.php">
        <div id="sect1">
            <fieldset id="names">
                <legend>Job and Name</legend>
                   <label for="refnum">Job Reference Number</label>
                        <input type="text" name="refnum" id="refnum"
                        minlength="5" maxlength="5"
                        pattern="^[a-zA-Z0-9]+$"
                        required="required" />

                    <p><label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname"
                        maxlength="20"
                        pattern="^[a-zA-Z]+$"
                        required="required" /></p>
                    
                    <p><label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname"
                        maxlength="20"
                        pattern="^[a-zA-Z]+$"
                        required="required" /></p>
            </fieldset>
        
        <!-- Date of Birth -->
            <fieldset id="birth">
                <legend>Date of Birth</legend>
                    <label for="dob">Date of Birth</label>
                        <input type="text" name="dob" id="dob" placeholder="dd/mm/yyyy" required="required"/>
            </fieldset>

        <!-- Gender -->
            <fieldset id="gen">
                <legend>Gender</legend>
                    <label><input type="radio" name="Gender" id="male" value="Male" checked="checked" />Male</label>
                    <label><input type="radio" name="Gender" id="female" value="Female" />Female</label>
                    <label><input type="radio" name="Gender" id="other" value="Other" />Other</label>
            </fieldset>
        </div>

        <!-- Address -->
        <div id="sect2">
            <fieldset id="addy">
                <legend>Address</legend>
                    <label for="street">Street Address</label>
                        <input type="text" name="street" id="street"
                        maxlength="40"
                        required="required" />

                    <p><label for="subtown">Suburb/Town</label>
                        <input type="text" name="subtown" id="subtown"
                        maxlength="40"
                        required="required" /></p>

                    <p><label for="state">State</label>
                        <select name="state" id="state">
                            <option value="VIC" selected="selected">VIC</option>
                            <option value="NSW">NSW</option>
                            <option value="QLD">QLD</option>
                            <option value="NT">NT</option>
                            <option value="WA">WA</option>
                            <option value="SA">SA</option>
                            <option value="TAS">TAS</option>
                            <option value="ACT">ACT</option>
                        </select></p>

                    <p><label for="postcode">Postcode</label>
                        <input type="text" name="postcode" id="postcode"
                        minlength="4" maxlength="4"
                        pattern="^[0-9]+$" 
                        required="required"/></p>
            </fieldset>

        <!-- Contact Details -->
            <fieldset id="contacts">
                <legend>Contact Details</legend>
                    <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" required="required" />

                    <p><label for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone"
                        minlength="8" maxlength="12"
                        pattern="^[0-9]{8,12}+$"
                        required="required" /></p>
            </fieldset>
        </div>

        <!-- Skill List -->
        <fieldset id="skillset">
            <legend>Skills</legend>
                <label><input type="checkbox" name="Skills[]" value="IT Management" checked="checked" />IT Management</label>
                <p><label><input type="checkbox" name="Skills[]" value="Interpersonal"/>Interpersonal Skills</label></p>
                <p><label><input type="checkbox" name="Skills[]" value="OS Proficiency"/>Operating System Proficiency</label></p>
                <p><label><input type="checkbox" name="Skills[]" value="Troubleshooter"/>Troubleshooter</label></p>
                <p><label><input type="checkbox" name="Skills[]" id="othersk" value="Other Skills" />Other Skills</label></p>

                <p><label id="skillsets">Other Skills<br>
                <textarea name="OtherSkills" id="otherskills" rows="8" cols="45" placeholder="Enter other skills here..."></textarea></label></p>
        </fieldset>

        <!-- Submit/Reset Option -->
        <div class="subres">
            <input type="submit" value="Submit Application"/>
            <input type="reset" value="Reset Form" />
        </div>

        <!-- Footer -->
        <?php include 'footer.inc'; ?>
        </form>
    </body>
</html>