<?php

include "../../connection.php";

if (isset($_POST['id'])) {

    $id = $_POST['id'];

} else {

    return;

}

$sql = "DELETE FROM `tb_events` WHERE event_id = $id";

$query = $connect -> query($sql);

$connect = NULL;

return;