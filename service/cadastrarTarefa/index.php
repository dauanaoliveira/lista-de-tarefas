<?php
   include('../../config/conexao.php');

   $params = json_decode($_POST['params'], true);

   $consulta = 'INSERT INTO tasks (task, description, status, user, email, createAt, updatedAt)';
   $consulta .= 'VALUES (';
   $consulta .=     '"'. $params['task'] .'", ';
   $consulta .=     '"'. $params['description'] .'", ';
   $consulta .=     '"'. $params['status'] .'", ';
   $consulta .=     '"'. $params['user'] .'", ';
   $consulta .=     '"'. $params['email'] .'", ';
   $consulta .=     'NOW(), ';
   $consulta .=     'NOW()';
   $consulta .= ');';

   $con = $mysqli->query($consulta) or die('{"success":false, "message": "Ocorreu um arro ao selecionar os dados!", "erro": "' . $mysqli->error . '"}');

    echo '{"success":true, "message": "Tarefa criada com sucesso!"}';
    exit;
?>