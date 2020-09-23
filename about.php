<?php
include 'config.php';
include 'Classes/buttonChecker.php';
include 'Classes/sqlBot.php';

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: Accounts/login.php");
    exit;
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
            <a href="contact.php">Contact</a>
            <a href="Accounts/logout.php">Sign Out</a>
        </div>

    </div>
    <br><br><br>

    <div class="about">
        <h1 class="aboutHeader">What is Bullseye Patient Tracker?</h1>
        <p class="aboutBody"> This website is a means by which dental professionals can be notified when patients are waiting for them.
            Through this application, dentists and their assistants can avoid communication breakdown by using this quick and informative information system.
        </p>
        <br>
        <h1 class="aboutHeader">How Does Bullseye Patient Tracker Work?</h1>
        <p class="aboutBody">
            When a hygienist is done working and the patient is ready for the dentist to visit them, the hygienists can click "Notify Dentist",
            which will text the dentist with the room number, letting them know that their services are needed.
            This information is displayed in a live table, so that rooms can be prioritized based on which patient has been waiting the longest.</p>
    </div>
    <br><br><br>
    <div class="about aboutButtons">
        <h1 class="aboutHeader">Buttons and What They Do</h1>
        <br><br>
        <h2 class="aboutSubHeader notify2">Notify Dentist</h2>
        <p class="aboutBody">This button can be found on the table displayed for each hygienist.
            Clicking this button will notify (text) the dentist and begin the waiting time for that room.
            The table will sort itself based on which room has been waiting the longest.
        </p>

        <br><br>
        <h2 class="aboutSubHeader clear2">Clear</h2>
        <p class="aboutBody">This button can be found on the table displayed for each hygienist, as well the table displayed for the dentist.
            Clicking this button will reset the waiting time for the corresponding room.
            The table will sort itself based on which room has been waiting the longest.
        </p>
        <br><br>
        <h2 class="aboutSubHeader edit2">Edit</h2>
        <p class="aboutBody">This button can be found on the admin table, only accessible to the dentist.
            Clicking this button will take you to the edit page, where the dentist can add or remove rooms from the displayed table.
        </p>
        <br><br>
        <h2 class="aboutSubHeader delete2">Delete</h2>
        <p class="aboutBody">This button can be found on the edit page, only accessible to the dentist.
            Clicking this button will remove the room from the displayed table for all users of the application.
        </p>
        <br><br>
        <h2 class="aboutSubHeader add2">Add Room</h2>
        <p class="aboutBody">This button can be found on the edit page, only accessible to the dentist.
            In order to add a room, one must provide a room number. It can follow a number of formats (examples: "A-401", "203"). However, the room name cannot be blank, nor can it contain spaces.
        </p>
        <br><br>
        <div class="inline">
            <h2 class="aboutSubHeader setPassword2">Set As Admin Password</h2>
            <h2 class="aboutSubHeader setPassword2">Set As User Password</h2>
        </div>
        <p class="aboutBody">These buttons can be found on the "Reset Password" page, only accessible to the dentist.
            In order to change the password, one must provide a password and confirm it. The password cannot be blank, nor can it contain spaces.
            You can set this provided password as the password for regular users (hygienists), or as the password for the admin (dentist).
        </p>






    </div>




    <br>

    <div class="disclaimer disclaimerRel">
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