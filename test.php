<?php
// Validate name
function validarNome()
{
    $_POST["Uname"] = "COISAS SEPARADAS";
    if (empty(trim($_POST["Uname"]))) {
        return $name_err = "Please insert a name.";
    } elseif (!preg_match('/\w+( +\w+)*$/', trim($_POST["Uname"]))) {
        return $name_err = "Name invalid." . " // Nome: " . $_POST["Uname"];
    } else {
        return $Uname = trim($_POST["Uname"]);
    }
}

echo validarNome();
