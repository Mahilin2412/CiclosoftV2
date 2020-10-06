<?php
    include '../Conexion.php';
    include '../config.php';
    include '../Data/classtydoc.php';
    $conn = conectar($bd);

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $sentencia = $conn->prepare("SELECT * FROM Gender;");
        $sentencia->execute();
        header("http/1.1 200 ok");
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        $sentencia = $sentencia->fetchAll();
        //echo json_encode($sentencia->fetch(PDO::FETCH_ASSOC)); solo un registro
        echo json_encode($sentencia);
        exit();
    }
?>