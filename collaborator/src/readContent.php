<?php

include "../../connection.php";

$sql = "SELECT * FROM tb_users";
$query = $connect -> query($sql);
$connect = NULL;

if($query->rowCount() == 0) {
    $trNull = '<tr class="contentList" style="text-align:center;"> <td colspan="12"> Nenhum colaborador registrado </td> </tr>';
    echo "data = ['$trNull']";
    return;
}

$list = "data = [ '";
foreach ($query as $user) {
    $list .= '<tr class="contentList">';
    $list .= "<td> <span> ".utf8_encode($user['name'])." </span> </td>";
    
    if ($user['profile'] == 8) {
        $list .= "<td> <span> Administrador </span> </td>";
    } else if ($user['profile'] == 5) {
        $list .= "<td> <span> Gerente </span> </td>";
    } else if ($user['profile'] == 2) {
        $list .= "<td> <span> Convidado </span> </td>";
    } else {
        $list .= "<td> <span> Convidado </span> </td>";
    }

    $list .= "<td> <span> ".utf8_encode($user['email'])." </span> </td>";
    
    $list .= '<td> <div><img src="../images/edit-colabs.svg" alt="editar" id="edit"   data-content="'.utf8_encode($user['name']).'" data-id="'.$user['id'].'" title="editar '.utf8_encode($user['name']).'"></div></td>';
    $list .= '<td> <div><img src="../images/garbage.svg" alt="deletar"     id="delete" data-content="'.utf8_encode($user['name']).'" data-id="'.$user['id'].'" title="deletar '.utf8_encode($user['name']).'"></div></td>';
    $list .= '</tr>';
}
$list .= "']";

echo $list;