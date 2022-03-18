<?php
session_start();

// Include config file
require_once "db.connection.php";
require "functions.php";

$token = $token_err = $resToken = "";
$param_email = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email is empty
    if (empty(trim($_POST["token"]))) {
        $token_err = "Please enter a token.";
    } else {
        $token = trim($_POST["token"]);
    }

    // Validate token
    if (empty($token_err)) {

        // Prepare a select statement
        $sql = "SELECT id,nome, email, token FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            // Set parameters
            $param_email = $_SESSION["email"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify token
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $nome, $email, $resToken);
                    if (mysqli_stmt_fetch($stmt)) {
                        if ($token == $resToken) {
                            session_destroy(); //destroy last session to start a new one
                            // token is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["user_name"] = $nome;
                            $_SESSION["status"] = 1;
                            $_SESSION["validated"] = 1;
                            $_SESSION["type"] = 1;

                            $updateQuery = "UPDATE users SET estado=1,validado=1 WHERE id=?";
                            if ($stm = mysqli_prepare($link, $updateQuery)) {
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stm, "i", $id);
                                if (mysqli_stmt_execute($stm)) {
                                    // Redirect user to welcome page
                                    header("location: index.php");
                                } else {
                                    echo "QUERY(UPDATE):::::::Oops! Something went wrong. Please try again later.";
                                }
                            } else {
                                echo mysqli_error($link);
                            }
                        } else {
                            // Token is not valid, display a generic error message
                            $token_err = "Invalid token.";
                        }
                    }
                }
            }
        } else {
            echo "QUERY(SELECT):::::::Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo mysqli_error($link);
    } //echo "PREPARE STATEMENT::::::::::Oops! Something went wrong. Please try again later.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper{ width: 360px; padding: 20px;margin:auto; }
    </style>
</head>
<body>
    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <p>
            <h3>In order to continue using our website you need to <b>verify</b> your email:</h3><h5> <?php echo $_SESSION["email"] ?? "testing" ?></h5>
            <label for="vToken">Validation token:</label><br>
            <input type="text" id="token" name="token" placeholder="XXXXXXX" <?php echo (!empty($token_err)) ? 'is-invalid' : ''; ?>><br>
            <?php
if (!empty($token_err)) {
    echo '<div class="alert alert-danger">' . $token_err . '</div>';
}
?>
<?php
if (isset($_POST['button2'])) {
    if (resendEmal($_SESSION["email"])) {
        echo '<div class="alert alert-sucess">Email was sent sucessfuly!</div>';
    } else {
        echo '<div class="alert alert-danger">We failed to send the email!</div>';
    }
}

?>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Verify">
                <input type="button" class="btn btn-secondary ml-2" value="Resend Email">
            </div>
        </p>
        </form>
    </div>
</body>
</html>