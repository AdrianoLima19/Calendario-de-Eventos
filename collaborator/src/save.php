<?php

include "../../connection.php";
$id = $_POST['id'];
$name = utf8_decode($_POST['name']);
$profile = $_POST['profile'];
$email = $_POST['email'];
$password = password_hash(md5($_POST['password']), PASSWORD_DEFAULT);

if ($_POST['method'] == 'create') {
    
    $sql = "INSERT INTO `tb_users`(`id`, `name`, `profile`, `email`, `password`) VALUES 
    (NULL,'$name','$profile','$email','$password')";
    $query = $connect -> query($sql);
    unset($connect);
    unset($query);
    return;

} else if ($_POST['method'] == 'update') {

    $sql = "UPDATE `tb_users` SET `id`='$id',`name`='$name',
    `profile`='$profile',`email`='$email' WHERE `id` = $id";
    
    $query = $connect -> query($sql);
    unset($connect);
    unset($query);
    return;

}