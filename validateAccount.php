<?php
session_start();

// Include config file
require_once "db.connection.php";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if email is empty
    if(empty(trim($_POST["token"]))){
        $token_err = "Please enter email.";
    } else{
        $token = trim($_POST["token"]);
    }

    // Validate token
    if(empty($token_err)){

        // Prepare a select statement
        $sql = "SELECT id,nome, email, token FROM users WHERE email = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            // Set parameters
            $param_email = $_SESSION["email"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                session_destroy();
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify token
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id,$nome, $email, $resToken);
                    if(mysqli_stmt_fetch($stmt)){
                        if($token==$resToken){
                            // token is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;  
                            $_SESSION["user_name"]= $nome;                          

                            $updateQuery = "UPDATE users SET estado=1, validado=1 WHERE id=?";
                            if($stm = mysqli_prepare($link, $updateQuery)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stm, "i", $id);
                                if(mysqli_stmt_execute($stm)){
                                    // Redirect user to welcome page
                                    header("location: index.php");
                                }else{
                                    echo "QUERY:::::::Oops! Something went wrong. Please try again later.";
                                }
                            }else{
                                echo mysqli_error ($link);
                            }
                        } else{
                            // Token is not valid, display a generic error message
                            $token_err = "Invalid token.";
                        }
                    }
                } else{
                    // email doesn't exist, display a generic error message
                    $login_err = "Invalid email (already exists).";
                }
            } else{
                echo "QUERY(SELECT):::::::Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }else{
            echo mysqli_error ($link);
        }//echo "PREPARE STATEMENT::::::::::Oops! Something went wrong. Please try again later.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <p>
        <h1>In order to continue using our website you need to <b>verify</b> your email:</h1><h3> <?php echo $_SESSION["email"]?></h3>
        <label for="vToken">Validation token:</label><br>
        <input type="text" id="token" name="token" placeholder="XXXXXXX" <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>><br>
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $token_err . '</div>';
        }        
        ?>
        <button type="submit"> SUBMIT </button>
    </p>
    </form>
</body>
</html>