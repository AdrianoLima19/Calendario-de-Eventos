<?php

include "../../connection.php";

if ($_POST['method'] == 'create') {
    
    $sql = "SELECT email FROM tb_users";
    $query = $connect -> query($sql);
    $connect = NULL;
    $valid = true;

    foreach ($query as $emails) {
        if ($emails['email'] == $_POST['email']) {
            $valid = false;
        }
    }
    
    if ($valid) {
        echo "data = ['false']"; // remove error
        return;
    } else {
        echo "data = ['true']"; // add error
        return;
    }

} else if ($_POST['method'] == 'update'){

    $id = $_POST['id'];
    $sql = "SELECT email FROM tb_users WHERE id != $id";
    $query = $connect -> query($sql);
    $connect = NULL;
    $valid = true;

    foreach ($query as $emails) {
        if ($emails['email'] == $_POST['email']) {
            $valid = false;
        }
    }
    
    if ($valid) {
        echo "data = ['false']"; // remove error
        return;
    } else {
        echo "data = ['true']"; // add error
        return;
    }
}