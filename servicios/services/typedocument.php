<?php
    include '../Conexion.php';
    include '../config.php';
    include '../Data/classtydoc.php';
    $conn = conectar($bd);

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $sentencia = $conn->prepare("SELECT * FROM typedocument;");
        try{
            $sentencia->execute();
        }catch(PDOException $e){
            print json_encode($e->getMessage());
        }
        
        header("http/1.1 200 ok");
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        $sentencia = $sentencia->fetchAll();
        echo json_encode($sentencia);
        exit();
    }
?>