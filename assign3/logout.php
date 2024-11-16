<?php
/* logout.php
   General logout function that destroys session and redirects to login.html
   Author: Harrison Stefanidis
*/

session_start();
session_unset();
session_destroy();
header("Location: login.html");
exit();
?>
