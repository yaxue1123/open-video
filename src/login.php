<?php 
    session_start();
    require "dbconnect.php";
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Video</title>
    <link rel="Shortcut Icon" href="logo.jpg">
    <link rel='stylesheet' href='style.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="home">
    <form method="post" action="login.php" class="form-signin">
        <img class="rounded-circle" src="logo.jpg" alt="OV Logo">
        <h1>Please sign in</h1>
        <input type="text" name="uname" placeholder="username">
        <input type="password" name="upass" placeholder="password">
        <button type="submit" value="Log in">Log in</button>
        <p>© 2018 Yaxue Guo</p>
        <p class="warning">
            <?php
            if (isset($_POST['uname']) && isset($_POST['upass'])) {
                // if username and password are both input
                // sanitize user input to prevent MySQL injection
                $uname = addslashes($_POST['uname']);
                $upass = sha1(addslashes($_POST['upass']));
                $sql = "SELECT username FROM p2users WHERE username='" . $uname . "' AND password= '" . $upass . "'";

                if ($result = $mysqli->query($sql)) {
                    while ($row = $result->fetch_assoc()) {
                        // use super global variable to store user name
                        $_SESSION['valid_user'] = $uname;
                    }
                }

                if (isset($_SESSION['valid_user'])) {
                    // direct to result page if the user is valid}?>
                    <script> window.location.href="http://photochemcad.com/openvideo/results.php";</script>
                    <?php
                } else {
                    // failed to login, show warning message and prompt user to input right uname and pwd again
                    echo "Please enter right username and password";
                    exit;
                }
            }
            ?>
        </p>
    </form>
</div>
</body>
</html>