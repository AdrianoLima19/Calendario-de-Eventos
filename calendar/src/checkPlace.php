<?php

include "../../connection.php";

if (isset($_POST['place']) && isset($_POST['start']) && isset($_POST['end']) ) {

    $id = (isset($_POST['id'])) ? $_POST['id'] : 0 ;
    $place = $_POST['place'];
    $start = $_POST['start'];
    $end = $_POST['end'];

} else {

    echo "data = ['0']";
    return;

}

$sql = "SELECT event_id, `start`, `end`, place FROM `tb_events`";

$query = $connect -> query($sql);
$connect = NULL;
$isValid = true;
$dayStart = array();
$dayEnd = array();
$eventStart = array();
$eventEnd = array();

$date1 = new DateTime($start);
$date2 = new DateTime($end);
$interval = date_diff($date1, $date2);
$interval = intval($interval->format('%a')) + 1;

if ($interval == 1) {

    $dayStart[] = $start;
    $dayEnd[] = $end;

} else {
    
    for ($i=0; $i < $interval; $i++) {

        $dayStart[] = date('Y-m-d 08:00:00', strtotime("+ $i day", strtotime($start)));

    }
    for ($i=($interval - 1); $i > -1 ; $i--) {

        $dayEnd[] = date('Y-m-d 22:00:00', strtotime("- $i day", strtotime($end)));

    }
}

foreach ($query as $check) {

    if( $check['place'] == $place && $check['event_id'] != $id) {

        $date1 = new DateTime($check['start']);
        $date2 = new DateTime($check['end']);
        $interval = date_diff($date1, $date2);
        $interval = intval($interval->format('%a')) + 1;

        if ($interval == 1) {

            $eventStart[] = $check['start'];
            $eventEnd[] = $check['end'];

        } else {

            for ($i=0; $i < $interval; $i++) {

                $eventStart[] = date('Y-m-d 08:00:00', strtotime("+ $i day", strtotime($check['start'])));

            }
            for ($i=($interval - 1); $i > -1 ; $i--) {

                $eventEnd[] = date('Y-m-d 22:00:00', strtotime("- $i day", strtotime($check['end'])));

            }      
        }
    }
}

for ($i=0; $i < count($dayStart); $i++) {
    
    for ($j=0; $j < count($eventStart); $j++) {

        if ( strtotime($dayStart[$i]) <= strtotime($eventEnd[$j]) && strtotime($dayStart[$i]) >= strtotime($eventStart[$j]) ) {

            $isValid = false;
        }
        if ( strtotime($dayEnd[$i]) <= strtotime($eventEnd[$j]) && strtotime($dayEnd[$i]) >= strtotime($eventStart[$j]) ) {

            $isValid = false;
        }

        if ( strtotime($dayStart[$i]) <= strtotime($eventStart[$j]) && strtotime($dayEnd[$i]) >= strtotime($eventEnd[$j]) ) {

            $isValid = false;
        }
    }
}

if ($isValid) {
    echo "data = ['1']";
} else {
    echo "data = ['0']";
}
