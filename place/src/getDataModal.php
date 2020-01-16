<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../");
}

if(isset($_POST['id'])) {
    $id = $_POST['id'];
}
if(isset($_POST['place']) && isset($_POST['isActive'])) {

    $place = utf8_decode($_POST['place']);
    
    if ($_POST['isActive'] == 'active') {
        $isActive = 1;
    } else {
        $isActive = 0;
    }
    
}

include "../../connection.php";

if($_POST['type'] == 'read') {

    $sql = "SELECT * FROM tb_places WHERE id = $id";
    $query = $connect -> query($sql);
    $tbPlace = $query->fetch();
    $place = utf8_encode($tbPlace['place']);
    if ($tbPlace['active']) {
        $isActive = true;
    } else {
        $isActive = false;
    }
    echo "data = ['$id', '$place', '$isActive']";

} else if($_POST['type'] == 'create') {

    $sql = "INSERT INTO `tb_places`(`id`, `place`, `active`)
    VALUES (NULL,'$place','$isActive')";
    $query = $connect -> query($sql);

} else if($_POST['type'] == 'update') {

    $sql = "UPDATE `tb_places` SET 
    `id`=$id,`place`='$place',`active`='$isActive' WHERE `id` = $id";
    $query = $connect -> query($sql);

}