<?php

include "../../connection.php";

$id = $_POST['id'];
$sql = "SELECT * FROM tb_users WHERE id = $id";
$query = $connect -> query($sql);
$user = $query->fetch();
$name = utf8_encode($user['name']);
$email = $user['email'];
$profile = $user['profile'];

echo "data = ['$name', '$email', '$profile']";
return;