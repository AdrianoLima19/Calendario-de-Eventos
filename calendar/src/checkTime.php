<?php

if ($_POST['method'] == 'date') {

    if ($_POST['type'] == 'start') {
    
        if ( strtotime($_POST['dateStart']) >= strtotime(date('Y-m-d')) ) {
            $min = date('Y-m-d', strtotime($_POST['dateStart']));
            $max = date('Y-m-d', strtotime('+1 month', strtotime($_POST['dateStart'])));
            echo "data = ['true', '$min', '$max']";
            return;
        } else {
            echo "data = ['false']";
            return;
        }

    } else if($_POST['type'] == 'end') {
    
        if ( strtotime($_POST['dateEnd']) >= strtotime($_POST['dateStart']) && strtotime($_POST['dateEnd']) <= strtotime('+1 month', strtotime($_POST['dateStart'])) ) {
            echo "data = ['true']";
            return;
        } else {
            echo "data = ['false']";
            return;
        }

    }
    
}

if ($_POST['method'] == 'time') {

    if ($_POST['type'] == 'start') {

        if ($_POST['timeStart'] >= '08:00:00' && $_POST['timeStart'] <= '18:00:00') {
            $dt = $_POST['timeStart'];
            echo "data = ['true', '$dt']";
            return;
        } else {
            echo "data = ['false']";
            return;
        }
        
    } else if($_POST['type'] == 'end') {
        
        if ($_POST['timeEnd'] <= '22:00:00' && $_POST['timeEnd'] > $_POST['timeStart']) {
            echo "data = ['true']";
            return;
        } else {
            echo "data = ['false']";
            return;
        }

    }

}
