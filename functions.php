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
                return true;
            } else {
                phpAlert("Your account is inactive at the moment.");
                //header("location: registo.php");
            }
        } else {
            header("location: validateAccount?val_err=1"); // erro de validação 1 = conta não é válida
        }
    } else {
        header("location: login.php");
        exit;
    }
}
