<?php
   include('../../config/conexao.php');

   $senha = 'TrabalheNaSaipos';
   $params = json_decode($_POST['params'], true);

   if($params['status'] == 'pendente' && $params['status_antigo'] == 'concluida') {
        if(!$params['senha'] || $params['senha'] != $senha) {
           echo '{"success":false, "message": "Digite uma senha válida para voltar a tarefa para pendente"}';
           exit;
        }

        $params['numberOfChanges']++;
        if($params['numberOfChanges'] > 2) {
            echo '{"success":false, "message": "Uma tarefa só pode ser alterada de concluída para pendente apenas duas vezes!"}';
            exit;
        }
   }

   $consulta = 'UPDATE tasks SET ';
   $consulta .=     ' status = "'. $params['status'] .'", ';
   $consulta .=     ' numberOfChanges = "'. $params['numberOfChanges'] .'", ';
   $consulta .=     ' updatedAt = NOW()';
   $consulta .=     ' WHERE id = '. $params['id'] .' ';
   $consulta .= ';';

   $con = $mysqli->query($consulta) or die('{"success":false, "message": "Ocorreu um arro ao selecionar os dados!", "erro": "' . $mysqli->error . '"}');

    echo '{"success":true, "message": "Status da tarefa alterado com sucesso!"}';
    exit;
?>