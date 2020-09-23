<?php
include 'config.php';
include 'Classes/buttonChecker.php';
include 'Classes/sqlBot.php';

session_start();
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

        </div>
    </div>
    <br><br><br>

    <form name="contactform" method="post">
        <table class="contact">
            <tr>
                <td valign="top">
                    <label for="email">Email Address</label>
                </td>
                <td valign="top">
                    <input type="text" class="addInput emailInput" name="email" maxlength="80" size="30">
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <label for="comments">Comments</label>
                </td>
                <td valign="top">
                    <textarea name="comments" class="addInput commentInput" maxlength="1000" cols="25" rows="6"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center">
                    <input type="submit" class="add" value="Submit"></a>
                </td>
            </tr>
        </table>
    </form>
    <br><br><br>
    <?php
    if (isset($_POST['email'])) {

        // EDIT THE 2 LINES BELOW AS REQUIRED
        $email_to = "berrettethan@gmail.com";
        $email_subject = "Bullseye Support Request";

        function died($error)
        {
            // your error code can go here
            echo $error . "<br /><br />";
            echo "Please go back and fix these errors.<br /><br />";
            die();
        }






        $email_from = $_POST['email']; // required
        $comments = $_POST['comments']; // required

        $error_message = "";
        $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

        if (!preg_match($email_exp, $email_from)) {
            $error_message1 = 'Email address is invalid.<br />';
        } else {
            $error_message1 = '';
        }

        $string_exp = "/^[A-Za-z .'-]+$/";


        if (strlen($comments) < 2) {
            $error_message2 = 'Comments cannot be blank.<br />';
        } else {
            $error_message2 = '';
        }

        if (strlen($error_message1) > 0) {
            echo "<script type='text/javascript'>alert('Email address is invalid, please try again.');</script>";
        } elseif (strlen($error_message2) > 0) {
            echo "<script type='text/javascript'>alert('Comment cannot be blank, please try again.');</script>";
        } else {

            echo '<script language="javascript">';
            echo 'alert("Thank you for contacting Bullseye support. We will get back to you as soon as possible.")';
            echo '</script>';
        }
        $email_message = "Form details below.\n\n";


        function clean_string($string)
        {
            $bad = array("content-type", "bcc:", "to:", "cc:", "href");
            return str_replace($bad, "", $string);
        }



        $email_message .= "Email: " . clean_string($email_from) . "\n";
        $email_message .= "Comments: " . clean_string($comments) . "\n";

        // create email headers
        $headers = "From: Contact Form <" . $awardspaceEmail . ">" . "\r\n";
        mail($email_to, $email_subject, $email_message, $headers);
    }
    ?>

    <div class="disclaimer">
        <p> This project has been developed as part of a classroom learning experience by students at Utah State University.
            While efforts are made to ensure copyrights and intellectual property rights have not been violated,
            it is the responsibility of the organization using any classroom projects created by USU and
            its students to make sure the materials contained therein do not infringe the property rights
            (including without limitation rights of privacy and publicity, trademark rights, copyrights, patents,
            trade secrets, and licenses) of third parties.
        </p>
    </div>



</html>