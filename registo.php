<?php
// Include config file
require_once "db.connection.php";
 
// Define variables and initialize with empty values
$email = $password = $confirm_password = $Uname = "";
$email_err = $password_err = $confirm_password_err = $Uname_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    function generateRandomString($length = 25) { // function to generate random string
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function sendEmail($token,$email){ // function to send email
        //email function 
        ini_set("SMTP", "smtp.server.com");//confirm smtp
        $to = $email;
        $subject = "Validation Token";
        $message = "" . $token;
        $from = "miguel.telmo.atw@gmail.com"; //sender
        $headers = "From: $from";
        mail($to,$subject,$message,$headers);
    
        echo "Mail sent!";
    }
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "EMAIL:::::: Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate name
    if(empty(trim($_POST["Uname"]))){
        $name_err = "Please insert a name.";     
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["Uname"]))){
        $name_err = "Name invalid.";
    }else{
        $Uname = trim($_POST["Uname"]);
    }
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($name)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (nome, email, palavrapasse,tipo,estado,validado,token) VALUES (?,?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, 'sssiiis', $param_name, $param_email, $param_password,$param_tipo,$param_estado,$param_validado,$param_token);
            
            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_name= $Uname;
            $param_estado=0;
            $param_tipo=1;
            $param_validado=0;
            $param_token=generateRandomString(6);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                sendEmail($param_token,$param_email);

                session_start(); // starting session to send email to validateAccount.php
                $_SESSION["email"]=$email;
                // Redirect to validation page
                header("location: validateAccount.php");
            } else{
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
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="Uname" class="form-control <?php echo (!empty($Uname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Uname; ?>">
                <span class="invalid-feedback"><?php echo $Uname_err; ?></span>
            </div>  
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>s