<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../");
}

if(isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    return;
}
if(isset($_POST['place']) && isset($_POST['isActive'])) {

    $place = utf8_decode($_POST['place']);
    
    if ($_POST['isActive'] == 'active') {
        $isActive = 1;
    } else {
        $isActive = 0;
    }
    
} else {
    return;
}

include "../../connection.php";

if($_POST['type'] == 'update') {

    $sql = "UPDATE `tb_places` SET 
    `id`=$id,`place`='$place',`active`='$isActive' WHERE `id` = $id";
    $query = $connect -> query($sql);

}