<?php
    include('../../config/conexao.php');

    $params = json_decode($_POST['params'], true);

    $virgula = '';

    $consulta = ' INSERT INTO tasks (task, description, status, user, email, createAt, updatedAt)';
    $consulta .= ' VALUES ';

    for($i = 0; $i < count($params); $i++) {
        $consulta .=  $virgula .' (';
        $consulta .=     '"'. $params[$i]['task'] .'", ';
        $consulta .=     '"'. $params[$i]['description'] .'", ';
        $consulta .=     '"'. $params[$i]['status'] .'", ';
        $consulta .=     '"'. $params[$i]['user'] .'", ';
        $consulta .=     '"'. $params[$i]['email'] .'", ';
        $consulta .=     'NOW(), ';
        $consulta .=     'NOW()';
        $consulta .= ' )';
        $virgula = ', ';
    }

    $con = $mysqli->query($consulta) or die('{"success":false, "message": "Ocorreu um arro ao selecionar os dados!", "erro": "' . $mysqli->error . '"}');

    echo '{"success":true, "message": "Tarefa criada com sucesso!"}';
    exit;
?>