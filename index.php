<?php
// Initialize the session
session_start();

require 'functions.php';
isAccountReady();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="modal.scss">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["user_name"] ?? "demo"); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <button class="button open-button">open modal</button>
        <?php isAdmin();?>
        <dialog class="modal" id="modal">
            <div class=modal-header>
                <h1>Insert a term</h1>
            </div>
            <form class="form" method="dialog">
                <label>Title</label>
                <input type="text" id="title">
                <label>Description</label>
                <input type="text" id="description" placeholder="(Max 140 characters)" maxlength="140">
                <input type="hidden" id="user-id" name="userId" value="<?php echo $_SESSION["id"]?>">
                <div class="btn2-group">
                    <button class="button" id="submitForm" type="submit">submit form</button>
                    <button class="close button"><b>Close</b></button>
                </div>
            </form>
        </dialog>
    </p>
</body>
<script src="modal.js"></script>
</html>