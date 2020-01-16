<?php

include "../../connection.php";

$sql = "SELECT * FROM `tb_places` WHERE `active` != 0";
$query = $connect -> query($sql);
$places = '';
foreach ($query as $place ) {
    $places .= '<option value="'.$place['id'].'" id="selectPlace"> '.utf8_encode($place['place']).' </option>';
}

$sql = "SELECT * FROM `tb_users`";
$query = $connect -> query($sql);
$connect = NULL;
$users = '';
foreach ($query as $user ) {
    $users .= '<option value="'.$user['id'].'" id="selectColab"> '.utf8_encode($user['name']).' </option>';
}

echo " data = ['$places', '$users']";