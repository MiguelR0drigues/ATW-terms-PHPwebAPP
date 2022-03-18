<?php
// Include config file
require_once "db.connection.php";
require "functions.php";

// Define variables and initialize with empty values
$email = $password = $confirm_password = $Uname = "";
$email_err = $password_err = $confirm_password_err = $Uname_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter a email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "EMAIL:::::: Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate name
    if (empty(trim($_POST["Uname"]))) {
        $name_err = "Please insert a name.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["Uname"]))) {
        $name_err = "Name invalid.";
    } else {
        $Uname = trim($_POST["Uname"]);
    }

    // Check input errors before inserting in database
    if (empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($name)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (nome, email, palavrapasse,tipo,estado,validado,token) VALUES (?,?,?,?,?,?,?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, 'sssiiis', $param_name, $param_email, $param_password, $param_tipo, $param_estado, $param_validado, $param_token);

            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_name = $Uname;
            $param_estado = 0;
            $param_tipo = 1;
            $param_validado = 0;
            $param_token = generateRandomString(6);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {

                sendEmail($param_token, $param_email);

                session_start(); // starting session to send email to validateAccount.php
                $_SESSION["email"] = $email;
                // Redirect to validation page
                header("location: validateAccount.php");
            } else {
                echo "QUERY:::::Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css" type = "text/css" media = "all" />
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
</head>
<body>
<section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image2.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" name="name" placeholder ="Enter your name" class="form-control <?php echo (!empty($Uname_err)) ? 'is-invalid' : ''; ?>" required value="<?php echo $Uname; ?>">
                <span class="invalid-feedback"><?php echo $Uname_err; ?></span> 
                <input type="email" name="email" placeholder ="Enter your email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" required value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
                <input type="password" name="password" placeholder="Enter your password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                <input type="password" name="confirm_password" placeholder="Please Confirm your Password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                <div style ="width:400px;">
                    <div style ="float: left; width:180px">
                <button name ="submit" class="btn" type="submit">Register</button>
                    </div>
                    <div style="float:right; width: 180px">
                <button name="reset" class="btn" type="Reset">Reset</button>
                    </div>
                </div>
                </form>
        <div class="social-icons">
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>   
</body>
</html>