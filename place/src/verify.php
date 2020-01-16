<?php

include "../../connection.php";

if ($_POST['method'] == 'create') {
    
    if ($_POST['type'] == 'place') {

        $sql = "SELECT * FROM tb_places";
        $query = $connect -> query($sql);
        $exist = false;

        foreach ($query as $tbPlace) {
            if ( $tbPlace['place'] == utf8_decode($_POST['place']) ) {
                $exist = true;
            }
        }

        if ($exist) {
            echo "data = ['true']";
        } else { echo "data = ['false']"; }
        
    }

} else if ($_POST['method'] == 'update') {

    if ($_POST['type'] == 'place') {

        $id = $_POST['id'];
        $sql = "SELECT * FROM `tb_places` WHERE id != $id";
        $query = $connect -> query($sql);
        $exist = false;

        foreach ($query as $tbPlace) {
            if ( $tbPlace['place'] == utf8_decode($_POST['place']) ) {
                $exist = true;
            }
        }

        if ($exist) {
            echo "data = ['true']";
        } else { echo "data = ['false']"; }

    } else if ($_POST['type'] == 'active') {

        $id = $_POST['id'];
        $sql = "SELECT place FROM `tb_events`";
        $query = $connect -> query($sql);
        $exist = false;

        foreach ($query as $tbPlace) {
            if ( $tbPlace['place'] == $id ) {
                $exist = true;
            }
        }

        if ($exist) {
            echo "data = ['true']";
        } else { 
            echo "data = ['false']"; 
        }


    }

}