<?php
// Initialize the session
session_start();

// Include config file
require_once "db.connection.php";
require "functions.php";

isLoggedin("index.php");

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }
    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    // Validate credentials
    if (empty($email_err) && empty($password_err)) {

        // Prepare a select statement
        $sql = "SELECT id,nome, email, palavrapasse,estado,validado,tipo FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $nome, $email, $hashed_password, $estado, $validado, $tipo);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["user_name"] = $nome;
                            $_SESSION["status"] = $estado;
                            $_SESSION["validated"] = $validado;
                            $_SESSION["type"] = $tipo;

                            // Redirect user to welcome page
                            header("location: index.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid email or password.";
                        }
                    }
                } else {
                    // email doesn't exist, display a generic error message
                    $login_err = "Invalid email or password.";
                }
            } else {
                echo "QUERY:::::::Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            echo mysqli_error($link);
        } //echo "PREPARE STATEMENT::::::::::Oops! Something went wrong. Please try again later.";
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css" type = "text/css" media = "all" />
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Login</h2>
                            <p>Please fill in your credentials to login.</p>

        <?php
if (!empty($login_err)) {
    echo '<div class="alert alert-danger">' . $login_err . '</div>';
}
?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your Email" required value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>    
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder ="Enter your Password" style="margin-bottom: 2px"; required>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                <button name="submit" name="submit" class="btn" type="submit">Login</button>
        </form>
        <div class ="social-icons">
            <p>Don't have an account? <a href ="registo.php">Sign up now</a>.</p>
    </div>
    </div>
                </div>
            </div>
            </div>
    </section>
</body>
</html>