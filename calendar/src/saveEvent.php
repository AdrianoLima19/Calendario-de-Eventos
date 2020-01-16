<?php

if ( !isset($_POST['action']) ) {
    return;
}


$StartDay = $_POST['StartDay'];
$StartTime = $_POST['StartTime'];
$EndDay = $_POST['EndDay'];
$EndTime = $_POST['EndTime'];

$ID = $_POST['ID'];
$Title = utf8_decode($_POST['Title']);
$Colab = $_POST['Colab'];
$Start = date('Y-m-d', strtotime($StartDay)).' '.date('H:i:s', strtotime($StartTime));
$End = date('Y-m-d', strtotime($EndDay)).' '.date('H:i:s', strtotime($EndTime));
$Place = $_POST['Place'];
$txtEvent = utf8_decode($_POST['txtEvent']);
$Company = utf8_decode($_POST['Company']);
$Client = utf8_decode($_POST['Client']);
$Phone = $_POST['Phone'];
$Email = $_POST['Email'];
$txtClient = utf8_decode($_POST['txtClient']);
$Type = $_POST['Type'];

include "../../connection.php";

if ($_POST['action'] == 'create') {
    
    $sql = "INSERT INTO `tb_events`(`event_id`, `title`, `colaborator`, `start`, `end`, `place`, `event_comment`, `company`, `responsible`, `phone`, `email`, `client_comment`, `type`) 
    VALUES (NULL, '$Title', '$Colab', '$Start', '$End', '$Place', '$txtEvent', '$Company', '$Client', '$Phone', '$Email', '$txtClient', '$Type' )";
    $query = $connect -> query($sql);
    unset($connect);
    unset($query);
    return;

} else if ($_POST['action'] == 'update') {

    $sql = "UPDATE `tb_events` SET `event_id`=$ID,`title`='$Title',`colaborator`='$Colab',`start`='$Start',`end`='$End',`place`='$Place',`event_comment`='$txtEvent',
    `company`='$Company',`responsible`='$Client',`phone`='$Phone',`email`='$Email',`client_comment`='$txtClient',`type`='$Type' WHERE `event_id` = $ID";
    $query = $connect -> query($sql);
    unset($connect);
    unset($query);
    return;

}