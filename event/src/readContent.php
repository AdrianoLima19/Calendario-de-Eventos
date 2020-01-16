<?php

include "../../connection.php";

$sql = "SELECT e.*, u.id, u.name, p.id, p.place FROM tb_events e
JOIN tb_users u on e.colaborator = u.id
JOIN tb_places p on e.place = p.id";

$query = $connect -> query($sql);
$connect = NULL;

if($query->rowCount() == 0) {
    $trNull = '<tr class="contentList" style="text-align:center;"> <td colspan="12"> Nenhum evento registrado </td> </tr>';
    echo "data = ['$trNull']";
    return;
}
$list = "data = [ '";
foreach ($query as $event) {
    $list .= '<tr class="contentList">';
    
    $list .= "<td> <span> ".utf8_encode($event['title'])." </span> </td>";
    $list .= "<td> <span> ".utf8_encode($event['name'])." </span> </td>";
    $list .= "<td> <span> ".date('d/m/y', strtotime($event['start']))." </span> ";
    $list .= "<span> ".date('H:i', strtotime($event['start']))." </span> </td>";
    $list .= "<td> <span> ".date('d/m/y', strtotime($event['end']))." </span> ";
    $list .= "<span> ".date('H:i', strtotime($event['end']))." </span> </td>";
    $list .= "<td> <span> ".utf8_encode($event['place'])." </span> </td>";
    $list .= "<td> <span> ".utf8_encode($event['company'])." </span> </td>";
    $list .= "<td> <span> ".utf8_encode($event['responsible'])." </span> </td>";
    $list .= "<td> <span> ".$event['phone']." </span> </td>";
    $list .= "<td> <span> ".$event['email']." </span> </td>";

    if ($event['type'] == 'tv') {
        $list .= "<td> <span> Não Definido </span> </td>";
    } else if ($event['type'] == 'tc') {
        $list .= "<td> <span> Confirmado </span> </td>";
    } else if ($event['type'] == 'ti') {
        $list .= "<td> <span> Interno </span> </td>";
    } else if ($event['type'] == 'te') {
        $list .= "<td> <span> Externo </span> </td>";
    } else if ($event['type'] == 'tp') {
        $list .= "<td> <span> Parcerias </span> </td>";
    } else {
        $list .= "<td> <span> Não Definido </span> </td>";
    }
    
    
    $list .= '<td> <div><img src="../images/editar-calendario.svg" alt="editar" id="edit"   data-content="'.utf8_encode($event['title']).'" data-id="'.$event['event_id'].'" title="editar '.$event['title'].'"></div></td>';
    $list .= '<td> <div><img src="../images/garbage.svg" alt="deletar"     id="delete" data-content="'.utf8_encode($event['title']).'" data-id="'.$event['event_id'].'" title="deletar '.$event['title'].'"></div></td>';
    $list .= '</tr>';
}
$list .= "']";

echo $list;