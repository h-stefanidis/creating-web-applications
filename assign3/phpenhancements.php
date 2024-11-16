<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="description" content="enhancements" />
        <meta name="keywords" content="enhancements" />
        <meta name="author" content="Harrison Stefanidis" />
        <title>Enhancements</title>

        <!-- Tab Icon -->
        <link rel="icon" type="image/x-icon" href="images/enhance.png">

        <!-- CSS For HTML -->
        <link href="styles/style.css" rel="stylesheet" />
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>

    </head>
    <body>
        <!-- Title -->
        <?php include 'headerenhancements.inc'; ?>

        <!-- Navigation -->
        <?php include 'menu.inc'; ?>

        <!-- Enhancement 1 -->
        <section id="enhancements1">
        <h2>Enhancement 1 - Manager Registration</h2>
        <p> This first enhancement involves a general manager registration where they require a unique username and password in order
            to register their account. This information is stored into a table called manager.php alongside a "failed_attempts" and "lock_until" name which
            represent the user's failed attempts for their specific username and then the time the account is locked upon entering the
            password wrong three times. Upon successful registration, you will be automatically redirected to the login page where you can
            enter your details and login to the manage.php website and access job applicant's information. However, upon three incorrect
            password entries, the specific user will be locked out of logging in to their account for 5 minutes. Another user can still login
            as long as they use a separate username compared to the already locked one.
        </p>
        <h3>Sources</h3>
        <a href="https://www.w3schools.com/php/php_form_complete.asp">https://www.w3schools.com/php/php_form_complete.asp</a>
        <a href="https://mercury.swin.edu.au/cos60004/s105260443/assign3/register.html">https://mercury.swin.edu.au/cos60004/s105260443/assign3/register.html</a>
        </section>

        <!-- Enhancement 2 -->
        <section id="enhancements2">
        <h2>Enhancement 2 - Manager Logout</h2>
        <p> The second enhancement looks into further implemented manager features, specifically the ability to log out of manage.php.
            This simply involves a log out button at the bottom of the manage.php page which involves the use of a logout.php program that
            unsets and destroys the entire session. Moreover, the user is redirected back towards the login.html page so they would have to
            login again to access manage.php. The user cannot go back to access manage.php, thereby ensuring security of that specific webpage
            with sensitive information about job applicants. Additionally, the manager's website cannot be accessed directly through a URL after
            being logged out as there is a specific form submission that needs to occur for the user to access manage.php. If a user did try to
            directly use the URL to manage.php when they are not logged in, they would be automatically redirected back to the login.html page.
        </p>
        <h3>Sources</h3>
        <a href="https://stackoverflow.com/questions/9792593/php-sessions-logging-in-and-logging-out">https://stackoverflow.com/questions/9792593/php-sessions-logging-in-and-logging-out</a>
        <a href="https://mercury.swin.edu.au/cos60004/s105260443/assign3/manage.php">https://mercury.swin.edu.au/cos60004/s105260443/assign3/manage.php</a>
        </section>

        <!-- Footer -->
        <?php include 'footer.inc'; ?>
    </body>
</html>