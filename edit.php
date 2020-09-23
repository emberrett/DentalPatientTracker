<?php
include 'config.php';
include 'Classes/buttonChecker.php';
include 'Classes/sqlBot.php';


// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: Accounts/login.php");
    exit;
}


if ($_SESSION['username'] !== 'IKAdmin' && $_SESSION['username'] == 'IKUser') {
    header("location: user.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bullseye Patient Tracker</title>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="dental.png">
</head>

<body>
    <div class="navbar">
        <div class="navbarTitle">
            <div>
                <a href="index.php"><img src="dental.png" height="50" width="50" hspace="5"></a>
            </div>
            <div>
                <a href="index.php">Bullseye Patient Tracker</a>
            </div>
        </div>
        <div></div>
        <div class="navbarRight">
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            <a href="Accounts/reset-password.php">Reset Password</a>
            <a href="Accounts/logout.php">Sign Out</a>
        </div>

    </div>
    <br><br><br>
    <!-- Page content -->
    <?php

    $sql    = "SELECT * FROM Main ORDER BY Room";

    $sqlBot = new sqlBot($conn, $sql);
    $sqlBot->tryConnection();

    //checking what buttons have been pushed
    $buttonChecker = new buttonChecker($conn, $text, $sql);
    $buttonChecker->getRoomList();
    $buttonChecker->checkDelete();
    $buttonChecker->checkAdd();


    //get admin results for rooms
    $sqlBot->adminView();

    ?>
    <br>
    <form method="post">
        <input type="text" class="addInput" name="roomName"> <input OnClick="return confirm('Are you sure you want to add this room?');" type="submit" class="add" value="Add Room">
    </form>
    <br><br>
    <form action="admin.php">
        <input class="edit" type="submit" value="Back" />
    </form>
    <?php
    if (isset($messageStatus)) {
        alert($messageStatus);
    }

    function alert($msg)
    {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
    ?>

    <script src="Scripts/time.js">
    </script>
    <div class="disclaimer">
        <p> This project has been developed as part of a classroom learning experience by students at Utah State University.
            While efforts are made to ensure copyrights and intellectual property rights have not been violated,
            it is the responsibility of the organization using any classroom projects created by USU and
            its students to make sure the materials contained therein do not infringe the property rights
            (including without limitation rights of privacy and publicity, trademark rights, copyrights, patents,
            trade secrets, and licenses) of third parties.
        </p>
    </div>
</body>

</html>