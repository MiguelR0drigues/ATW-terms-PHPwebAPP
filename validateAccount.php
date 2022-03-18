<?php
function generateRandomString($length = 25) { // function to generate random string
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //usage 
    $token = generateRandomString(6);
    //email
    //email function 
    ini_set("SMTP", "smtp.server.com");//confirm smtp
    $to = "dajihip331@tonaeto.com"; //$_SESSION["email"];
    $subject = "Validation Token";
    $message = "" . $token;
    $from = "didjeycs@gmail.com";
    $headers = "From: $from";
    mail($to,$subject,$message,$headers);
    echo "Mail Sent.";
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
        <button type="submit"> SUBMIT </button>
    </p>
    </form>
</body>
</html>