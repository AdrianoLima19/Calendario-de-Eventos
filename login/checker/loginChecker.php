<?php

$verify = false;
$isCookie = false;
if(isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];
    $keepOn = 'true';
    $verify = true;
    $isCookie = true;
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if( isset($_POST['email']) && isset($_POST['password']) ) {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $keepOn = $_POST['keepOn'];
        $verify = true;
    }
}

if (!$verify) {
    header("Location: ../index.php");
}

include "../../connection.php";

$sql = "SELECT * FROM tb_users";
$query = $connect -> query($sql);
$connect = NULL;

$login = false;

foreach ($query as $users ) {
    if ( $users['email'] == $email && password_verify( $password, $users['password'] ) ) {
        echo 'login';
        $login = true;
        
        session_start();
        $_SESSION['id'] = $users['id'];
        $_SESSION['isLog'] = true;
        $_SESSION['profile'] = $users['profile'];

        if($keepOn == 'true') {
            setcookie("email", $email, time() + (86400 * 15), "/");
            setcookie("password", $password, time() + (86400 * 15), "/");
            setcookie("profile", $users['profile'], time() + (86400 * 15), "/");
        }

        break;
    }
}

if ($isCookie) {
    if ($login) {
        header("Location: ../../calendar/index.php");
    } else {
        header("Location: ../index.php");
    }
}

if ($login) {
    echo "data = ['login']";
    return;
} else {
    echo "data = ['error']";
    return;
}