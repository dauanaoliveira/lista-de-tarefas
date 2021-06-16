<?php
   include('../../config/conexao.php');

   $params = json_decode($_POST['params'], true);

   $consulta = 'UPDATE tasks SET ';
   $consulta .=     ' task = "'. $params['task'] .'", ';
   $consulta .=     ' description = "'. $params['description'] .'", ';
   $consulta .=     ' user = "'. $params['user'] .'", ';
   $consulta .=     ' email = "'. $params['email'] .'", ';
   $consulta .=     ' updatedAt = NOW()';
   $consulta .=     ' WHERE id = '. $params['id'] .' ';
   $consulta .= ';';

   $con = $mysqli->query($consulta) or die('{"success":false, "message": "Ocorreu um arro ao selecionar os dados!", "erro": "' . $mysqli->error . '"}');

    echo '{"success":true, "message": "Tarefa alterada com sucesso!"}';
    exit;
?>