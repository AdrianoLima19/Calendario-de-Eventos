<?php

setcookie("email", '', -1, "/");
setcookie("password", '', -1,"/");
setcookie("profile", '', -1,"/");

session_start();
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

header("Location: ../index.php");
