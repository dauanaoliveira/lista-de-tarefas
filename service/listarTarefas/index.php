<?php
   include('../../config/conexao.php');

   $params = json_decode($_POST['params'], true);

   $consulta = 'SELECT * FROM tasks ';
   if($params && $params['status'] != '') {
       $consulta .= ' WHERE status = "' . $params['status']. '"; ';
   }

   $con = $mysqli->query($consulta) or die('{"success":false, "message": "Ocorreu um arro ao selecionar os dados!", "erro": "' . $mysqli->error . '"}');

    $rows;
    while ($row = $con->fetch_array( MYSQLI_ASSOC )){
        foreach ( $row as $name => $value ) {
            if (!preg_match('!!u', $value)) {
                $value = utf8_encode( $value );
            }
            $row[$name] = $value;
        }
        $rows[] = $row;
    }

    $rows = isset($rows) ? $rows :  [];

    echo '{"success":true, "message": "Dados listado com sucesso!", "elements": ' . json_encode($rows) . '}';
    exit;
?>