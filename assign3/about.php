<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="description" content="about" />
        <meta name="keywords" content="about" />
        <meta name="author" content="Harrison Stefanidis" />
        <title>About</title>

        <!-- Tab Icon -->
        <link rel="icon" type="image/x-icon" href="images/about.png">

        <!-- CSS For HTML -->
        <link href="styles/style.css" rel="stylesheet" />
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>

    </head>
    <body>
        <!-- Title -->
        <?php include 'headerabout.inc'; ?>

        <!-- Navigation -->
        <?php include 'menu.inc'; ?>

        <!-- Definition List -->
        <div id="animation2">
                <dl class="customdl">
                    <dt>Name:</dt>
                        <dd>Harrison Stefanidis</dd>
                    <dt>Student Number:</dt>
                        <dd>105260443</dd>
                    <dt>Tutor:</dt>
                        <dd>Bo Li</dd>
                    <dt>Course:</dt>
                        <dd>Master's of Data Science</dd>
                    <dt>Email Address:</dt>
                        <dd><a href="mailto:105260443@student.swin.edu.au">105260443@student.swin.edu.au</a></dd>
                </dl>
        </div>

        <!-- Graphic -->
        <div id="animation1">
            <img id="img3" src="images/me.png" alt="me.png" />
        </div>

        <!-- Timetable -->
        <div id="animation3">
        <table>
            <caption>My Swinburne Timetable</caption>
                <tr>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday-Sunday</th>
                </tr>
                <tr>
                    <td>10:30am-12:30pm<br>COS60010 Workshop</td>
                    <td>11:30am-12:30pm<br>COS60010 Lecture</td>
                    <td>8:30am-10:30am<br>COS60008 Lecture</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>12:30pm-2:30pm<br>COS60008 Workshop</td>
                    <td>N/A</td>
                    <td>12:30pm-2:30pm<br>COS60009 Lecture</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>4:30pm-6:30pm<br>COS60004 Lecture</td>
                    <td>N/A</td>
                    <td>4:30pm-6:30pm<br>COS60004 Workshop</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>6:30pm-7:30pm<br>COS60009 Workshop</td>
                    <td>N/A</td>
                </tr>
        </table>
        </div>

        <!-- Footer -->
        <?php include 'footer.inc'; ?>
    </body>
</html>