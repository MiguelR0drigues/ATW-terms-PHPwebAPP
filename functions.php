<?php
function isLoggedin($page)
{
    // Check if the user is logged in, if not then redirect him to login page
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: "+$page);
        exit;
    }
}

function isAccountReady()
{
    // Check if the user account is valited, if not send to validate account page
    // else verify status
    if (!isset($_SESSION["validated"]) || $_SESSION["validated"] !== 1) {
        header("location: validateAccount.php");
        exit;
    } else {
        if (!isset($_SESSION["status"]) || $_SESSION["status"] !== 1) {
            header("location: validateAccount.php");
            exit;
        }
    }
}
