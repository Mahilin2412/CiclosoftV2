<?php
    include '../Conexion.php';
    include '../config.php';
    include '../jugador.php';
    $conn = concetar($bd);

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $sentencia = $conn->prepare("SELECT * FROM typedocument;");
        $sentencia->execute();
        header("http/1.1 200 ok");
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        $sentencia = $sentencia->fetchAll();
        //echo json_encode($sentencia->fetch(PDO::FETCH_ASSOC)); solo un registro
        echo json_encode($sentencia);
        exit();
    }
?>