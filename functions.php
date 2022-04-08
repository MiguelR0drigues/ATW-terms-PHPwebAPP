<?php

function isLoggedin()
{
    // Check if the user is logged in, if not then redirect him to login page
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        return false;
        exit;
    } else {
        return true;
        exit;
    }
}

function isAccountValid()
{
    // Check if the user account is valited, if not send to validate account page
    if (!isset($_SESSION["validated"]) || $_SESSION["validated"] !== 1) {
        return false;
        exit;
    } else {
        return true;
    }
}

function isAccountActive()
{
    // Check if the user account is valited, if not send to validate account page
    if (!isset($_SESSION["status"]) || $_SESSION["status"] !== 1) {
        return false;
        exit;
    } else {
        return true;
    }
}

function phpAlert($msg)
{
    echo '<script type="text/javascript">';
    echo 'alert("' . $msg . '");';
    echo 'window.location.href = "registo.php";';
    echo '</script>';
}

function isAccountReady()
{
    if (isLoggedin()) {
        if (isAccountValid()) {
            if (isAccountActive()) {
                //Account is logged in , correctly validated and also active!
            } else {
                phpAlert("Your account is inactive at the moment.");
                //header("location: registo.php");
            }
        } else {
            header("location: validateAccount.php?val_err=1"); // erro de validação 1 = conta não é válida
        }
    } else {
        header("location: login.php");
        exit;
    }
}

function generateRandomString($length = 25)
{ // function to generate random string
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function sendEmail($token, $email)
{ // function to send email
    //email function
    ini_set("SMTP", "smtp.server.com"); //confirm smtp
    $to = $email;
    $subject = "Validation Token";
    $message = "" . $token;
    $from = "miguel.telmo.atw@gmail.com"; //sender
    $headers = "From: $from";
    if (mail($to, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }

}

function resendEmail($email, $link)
{
    $token = generateRandomString(6);
    $updateQuery = "UPDATE users SET token=? WHERE email=?";
    if ($stmt = mysqli_prepare($link, $updateQuery)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $token, $email);
        if (mysqli_stmt_execute($stmt)) {
            if (sendEmail($token, $email)) {
                return true;
            } else {
                return false;
            }
        } else {
            echo mysqli_error($link);
        }
    } else {
        echo mysqli_error($link);
    }
}

function isAdmin(){
    if($_SESSION["type"]==2){
        echo '<a href="test.php" class="btn btn-primary ml-3">ADMIN</a>';
    }
}
