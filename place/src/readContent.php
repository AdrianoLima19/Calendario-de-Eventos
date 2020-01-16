<?php

include "../../connection.php";

$sql = "SELECT * FROM tb_places";
$query = $connect -> query($sql);
$connect = NULL;

if($query->rowCount() == 0) {
    $trNull = '<tr class="contentList" style="text-align:center;"> <td colspan="12"> Nenhum lugar registrado </td> </tr>';
    echo "data = ['$trNull']";
    return;
}

$list = "data = [ '";
foreach ($query as $place) {
    $list .= '<tr class="contentList">';
    $list .= "<td> <span> ".utf8_encode($place['place'])." </span> </td>";

    if ($place['active']) {
        $list .= "<td> <span> Ativo </span> </td>";
    } else {
        $list .= "<td> <span> Inativo </span> </td>";
    }
    
    $list .= '<td> <div> <img src="../images/editar-local.svg" alt="editar" id="edit" data-content="'.utf8_encode($place['place']).'" data-id="'.$place['id'].'" title="editar '.utf8_encode($place['place']).'"></div></td>';
    $list .= '<td> <div> <img src="../images/garbage.svg" alt="deletar" id="delete"   data-content="'.utf8_encode($place['place']).'" data-id="'.$place['id'].'" title="deletar '.utf8_encode($place['place']).'"></div></td>';
    $list .= '</tr>';
}
$list .= "']";

echo $list;
