<?php
session_start();
// store the user info before destroying session
$current_user = $_SESSION['valid_user'];
// close the session when user logs out
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="Shortcut Icon" href="logo.jpg">
    <link rel="stylesheet" href="style.css">
    <title>Logout</title>
</head>
<body>
<div class="home">
    <div class="logout">
        <img class="rounded-circle" src="logo.jpg" alt="OV Logo">
        <h1>Logout</h1>
        <?php
        if (!empty($current_user)) {
            // if the user just logged out from results.php
            echo "You are now logged out. <br>";
        } else {
            // if refreshing after log out or directly use logout url, direct to login page
            header('Location: https://opal.ils.unc.edu/~yaxue/yaxue_p2/login.php');
            exit;
        }
        ?>
        <h4>Return to <a href='login.php'>Login</a></h4>
    </div>
</div>
</body>
</html>