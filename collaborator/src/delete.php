<?php

include "../../connection.php";

if (isset($_POST['id'])) {

    $id = $_POST['id'];

} else {

    echo 'var reload = false';
    return;

}

$sql = "DELETE FROM `tb_users` WHERE id = $id";

$query = $connect -> query($sql);

$connect = NULL;

echo 'var reload = true';
return;