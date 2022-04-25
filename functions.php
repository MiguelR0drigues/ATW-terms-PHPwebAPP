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

function isAdmin($type){
    if($type==2){
        return true;
    }
}

function  ownerNameByID($id,$link){
    $selectQuery = "SELECT nome FROM users WHERE id=?";
    if ($stmt = mysqli_prepare($link, $selectQuery)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $nome);
            if (mysqli_stmt_fetch($stmt))
                return $nome;
        } else {
            echo mysqli_error($link);
        }
    } else {
        echo mysqli_error($link);
    }// Close statement
    mysqli_stmt_close($stmt);
}


function isOwner($ownerID , $termID,$link){
    // Prepare a select statement
    $sql = "SELECT * FROM termos WHERE `owner` = ? AND `id`=?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $param_owner, $param_id);

        // Set parameters
        $param_id=$termID;
        $param_owner=$ownerID;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            /* store result */
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                return true;
            }

        // Close statement
        mysqli_stmt_close($stmt);
        }
    }
}

function areTermsRelated($father,$son,$link){
    function isRelationDuplicate($father,$son,$link){
        // Prepare a select statement
        $sql = "SELECT * FROM relacao WHERE `pai` = ? AND `filho`=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ii", $param_father, $param_son);

            // Set parameters
            $param_father=$father;
            $param_son=$son;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    return true;
                }

            // Close statement
            mysqli_stmt_close($stmt);
            }
        }
    }
    function isFather($father,$son,$link){
        // Prepare a select statement
        $sql = "SELECT * FROM relacao WHERE `pai` = ? AND `filho`=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ii", $param_father, $param_son);

            // Set parameters
            $param_father=$son;
            $param_son=$father;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    return true;
                }

            // Close statement
            mysqli_stmt_close($stmt);
            }
        }
    }
    if(isFather($father,$son,$link) || isRelationDuplicate($father,$son,$link)){
        return true;
    }else{
        return false;
    }
}

function isTermRevised($id,$link){
    // Prepare a select statement
    $sql = "SELECT revisto FROM termos WHERE id =?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            /* store result */
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $revised);
            if (mysqli_stmt_fetch($stmt)){
                if ($revised == 1){
                    return true;
                }else{
                    return false;
                }
            }
        // Close statement
        mysqli_stmt_close($stmt);
        }
    }
}