<?php
    $host = "localhost";
    $bd   = "to-do-list";
    $usuario = "root";
    $senha = "123456";

    $mysqli = new mysqli($host, $usuario, $senha, $bd);

    if($mysqli-> connect_errno)
        echo "Falha na conexão: (". $mysqli->connect_errno .") " . $mysqli->connect_error;  

?>