<?php
    // Initialize the session
    session_start();

    // Include config file
    require_once "db.connection.php";
    require "functions.php";

    $id = intval($_GET['id']);
    $title= ($_GET["title"]);
    $desc= ($_GET["description"]);
    // Prepare a select statement
    $sql = "SELECT title FROM termos WHERE title = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_title);

        // Set parameters
        $param_title = $title;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            /* store result */
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                header("location: index.php?term_err=1");
            } else {
                // Prepare an insert statement
                $sql = "INSERT INTO termos (`title`, `description`, `owner`) VALUES (?,?,?)";

                if ($stmt = mysqli_prepare($link, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, 'ssi', $param_title, $param_desc, $param_owner);

                    $param_title=$title;
                    $param_desc=$desc;
                    $param_owner=$id;

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        //Redirect
                        header("location: index.php");
                    } else {
                        echo "QUERY:::::Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);
                }
            }
        } else {
            echo "TITLE:::::: Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    