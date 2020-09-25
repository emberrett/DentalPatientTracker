<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION['username'] == 'IKAdmin') {
        header("location: ../admin.php");
    } else if ($_SESSION['username'] == 'IKUser') {
        header("location: ../user.php");
    }
    exit;
}

// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$username     = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"]       = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            if ($_SESSION['username'] == 'IKAdmin') {
                                header("location: ../admin.php");
                            } elseif ($_SESSION['username'] == 'IKUser') {
                                header("location: ../user.php");
                            }
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
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
    <title>Login</title>
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
                <a href="../contact.php">Contact</a>
            </div>

        </div>
        <br><br>
        <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="post">
            <div class="table">
                <div class="row">
                    <div class="cell">
                        <label class="accountLabel">Username:</label>
                    </div>
                    <div class="cell">
                        <input type="text" class="accountInput" name="username" value="<?php echo $username; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="cell">
                        <label class="accountLabel">Password: </label>
                    </div>
                    <div class="cell">
                        <input type="password" class="accountInput" name="password">
                    </div>
                </div>
                <div class="row">
                    <div class="cell">
                    </div>
                    <div class="cell" style="text-align: center">
                        <input type="submit" class="add login" value="Login">
                    </div>
                </div>
            </div>
        </form>
        <p class="alert"><?php echo $username_err ?></p>
        <p class="alert"><?php echo $password_err ?></p>
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