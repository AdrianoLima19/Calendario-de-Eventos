<?php

include "../../connection.php";

if (isset($_POST['id'])) {

    $id = $_POST['id'];

} else {

    return;

}

$sql = "SELECT * FROM `tb_events` WHERE event_id =  $id";

$query = $connect -> query($sql);
$event = $query->fetch();
$connect = NULL;

$eventId = $event['event_id'];
$title = $event['title'];
$colaborator = $event['colaborator'];
$startDay = date('Y-m-d', strtotime($event['start']));
$startTime = date('H:i', strtotime($event['start']));
$endDay = date('Y-m-d', strtotime($event['end']));
$endTime = date('H:i', strtotime($event['end']));
$place = $event['place'];
$eventComment = $event['event_comment'];
$company = $event['company'];
$responsible = $event['responsible'];
$phone = $event['phone'];
$email = $event['email'];
$clientComment = $event['client_comment'];
$type = $event['type'];

$title = utf8_encode($title);
$eventComment = utf8_encode($eventComment);
$company = utf8_encode($company);
$responsible = utf8_encode($responsible);
$clientComment = utf8_encode($clientComment);

$today = date('Y-m-d');

if( strtotime($event['end']) < strtotime($today) || strtotime($event['start']) < strtotime($today)) {
    $block = true;
} else {
    $block = false;
}

$data = 
" data = [
    '$eventId', 
    '$title', 
    '$colaborator', 
    '$startDay', 
    '$startTime', 
    '$endDay', 
    '$endTime', 
    '$place', 
    '$eventComment', 
    '$company', 
    '$responsible', 
    '$phone', 
    '$email', 
    '$clientComment', 
    '$type',
    '$block'
]";

echo $data;

return;
