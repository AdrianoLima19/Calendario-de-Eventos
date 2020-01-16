<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../");
}

if(isset($_POST['id'])) {
    $id = $_POST['id'];
}

include "../../connection.php";

$sql = "SELECT * FROM tb_events WHERE event_id = $id";
$query = $connect -> query($sql);
$tbEvent = $query->fetch();

$fmtStart = $tbEvent['start'];
$fmtEnd = $tbEvent['end'];
$today = date('Y-m-d');

if ( strtotime($fmtEnd) < strtotime($today) ) {
    $isRunning = 'true';
} else if( strtotime($fmtStart) < strtotime($today) ) {
    $isRunning = 'true';
} else {
    $isRunning = 'false';
}

$Start = explode(' ', $tbEvent['start']);
$End = explode(' ', $tbEvent['end']);
$dateStart = $Start[0];
$dateEnd = $End[0];
$timeStart = $Start[1];
$timeEnd = $End[1];

$id = $tbEvent['event_id'];
$title = utf8_encode($tbEvent['title']);
$colab = $tbEvent['colaborator'];
$place = $tbEvent['place'];
$commentEvent = utf8_encode($tbEvent['event_comment']);
$company = utf8_encode($tbEvent['company']);
$responsible = utf8_encode($tbEvent['responsible']);
$phone = $tbEvent['phone'];
$email = $tbEvent['email'];
$commentClient = utf8_encode($tbEvent['client_comment']);
$type = $tbEvent['type'];

echo "data = ['$isRunning', '$id', '$title', '$colab', '$place', '$commentEvent', '$company', '$responsible', '$phone', '$email', '$commentClient', '$type', '$dateStart', '$dateEnd', '$timeStart', '$timeEnd']";
