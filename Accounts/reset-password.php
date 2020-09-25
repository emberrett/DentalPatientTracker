<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
   header("location: login.php");
   exit;
}

// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   // Validate new password
   if (empty(trim($_POST["new_password"]))) {
      $new_password_err = "Please enter the new password.";
   } elseif (strlen(trim($_POST["new_password"])) < 6) {
      $new_password_err = "Password must have atleast 6 characters.";
   } else {
      $new_password = trim($_POST["new_password"]);
   }

   // Validate confirm password
   if (empty(trim($_POST["confirm_password"]))) {
      $confirm_password_err = "Please confirm the password.";
   } else {
      $confirm_password = trim($_POST["confirm_password"]);
      if (empty($new_password_err) && ($new_password != $confirm_password)) {
         $confirm_password_err = "Password did not match.";
      }
   }
   // Check input errors before updating the database
   if (empty($new_password_err) && empty($confirm_password_err)) {
      if (isset($_POST["admin"])) {
         // Prepare an update statement
         $sql = "UPDATE users SET password = ? WHERE id = 1";
         $user = 1;
      } elseif (isset($_POST["user"])) {
         $sql = "UPDATE users SET password = ? WHERE id = 2";
         $user = 2;
      }

      if ($stmt = mysqli_prepare($link, $sql)) {
         // Bind variables to the prepared statement as parameters
         mysqli_stmt_bind_param($stmt, "s", $param_password);

         // Set parameters
         $param_password = password_hash($new_password, PASSWORD_DEFAULT);


         // Attempt to execute the prepared statement
         if (mysqli_stmt_execute($stmt)) {
            // Password updated successfully. Destroy the session, and redirect to login page
            session_destroy();
            header("location: ../index.php");
            exit();
         } else {
            echo "Oops! Something went wrong. Please try again later.";
         }
      }

      // Close statement
      mysqli_stmt_close($stmt);
   }
   // Close connection
   mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reset Password</title>
   <link rel="stylesheet" href="../index.css">
   <link rel="icon" href="../dental.png">
</head>

<body>
   <div class="center">
      <div class="navbar">
         <div class="navbarTitle">
            <div>
               <a href="../index.php"><img src="../dental.png" height="50" width="50" hspace="5"></a>
            </div>
            <div>
               <a href="../index.php">Bullseye Patient Tracker</a>
            </div>
         </div>
         <div></div>
         <div class="navbarRight">
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            <a href="logout.php">Sign Out</a>
         </div>

      </div>
      <br><br>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
         <div class="table">
            <div class="row">
               <div class="cell">
                  <label class="accountLabel">New Password:</label>
               </div>
               <div class="cell">
                  <input type="password" name="new_password" class="accountInput" value="<?php echo $new_password; ?>">
               </div>
            </div>
            <div class="row">
               <div class="cell">
                  <label class="accountLabel">Confirm Password: </label>
               </div>
               <div class="cell">
                  <input type="password" name="confirm_password" class="accountInput">
               </div>
            </div>
            <br>
            <div class="row">
               <div class="cell">
                  <input type="submit" class="setPassword" value="Set as Admin Password" name="admin" style="width:175px; margin:3px ">
               </div>
               <div class="cell" style="text-align: center">
                  <input type="submit" class="setPassword" value="Set as User Password" name="user" style="width:175px; margin:3px">
               </div>
            </div>
         </div>
      </form>
      <!--<a class="btn btn-link" href="../index.php" style="margin:5px">Cancel</a> -->
      <p class="alert"><?php echo $new_password_err ?></p>
   </div>

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