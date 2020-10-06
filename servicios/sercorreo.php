<?php
    include 'Conexion.php';
    include 'config.php';
    include 'classservcorreo.php';
    $conn = conectar($bd);

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $prueba = $_GET['id'];
        $sentencia = $conn->prepare("SELECT * FROM customers WHERE NumIdentification ='{$prueba}' ;");
        $sentencia->execute();
        header("http/1.1 200 ok");
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        $sentencia = $sentencia->fetchAll();
        //echo json_encode($sentencia->fetch(PDO::FETCH_ASSOC)); solo un registro
        echo json_encode($sentencia);
        exit();
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $datos = $_POST;
        //$jugador = json_decode($datos);
        //echo $jugador;
        //echo json_encode($datos);
        //$obj = new jugador($datos['NumIdentification'],$datos['Nombre'],$datos['Apellido'],$datos['Peso'],$datos['Estatura'],$datos['Posicion'],$datos['IDEquipo']);
        //$sentencia = $conn->prepare("INSERT INTO JUGADOR (IDJugador,nombre,apellido,peso,estatura,posicion,IDEquipo) VALUES('$obj->id','$obj->name','$obj->lastName','$obj->weight','$obj->height','$obj->position','$obj->idTeam')");
        $obj = new sercorreo($datos['IdSerCorreo'], $datos['IpServidorCorreo'], $datos['Port']);
        $sentencia = $conn->prepare("INSERT INTO SERCORREO (IdSerCorreo, IpServidorCorreo, Port) VALUES ($obj->IdSerCorreo,'$obj->IpServidorCorreo', $obj->Port)");
    
        try{
            $sentencia->execute();
        }catch(Exeption $e){
            echo json_encode("Error en el SQL $e->getMessage()");
            exit();
        }
        
        echo json_encode("ok");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $datos = $_POST;
        //$jugador = json_decode($datos);
        //echo $jugador;
        //echo json_encode($datos);
        $obj = new sercorreo($datos['IdSerCorreo'], $datos['IpServidorCorreo'], $datos['Port']);
        $sentencia = $conn->prepare("INSERT INTO SERCORREO (IdSerCorreo, IpServidorCorreo, Port) VALUES ($obj->IdSerCorreo,'$obj->IpServidorCorreo', $obj->Port)");
        try{
            $sentencia->execute();
        }catch(Exeption $e){
            echo json_encode("Error en el SQL $e->getMessage()");
            exit();
        }
        
        echo json_encode("ok");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $datos = $_POST;
        //$jugador = json_decode($datos);
        //echo $jugador;
        //echo json_encode($datos);
        $obj = new sercorreo($datos['IdSerCorreo'], $datos['IpServidorCorreo'], $datos['Port']);
        $sentencia = $conn->prepare("INSERT INTO SERCORREO (IdSerCorreo, IpServidorCorreo, Port) VALUES ($obj->IdSerCorreo,'$obj->IpServidorCorreo', $obj->Port)");
        try{
            $sentencia->execute();
        }catch(Exeption $e){
            echo json_encode("Error en el SQL $e->getMessage()");
            exit();
        }
        
        echo json_encode("ok");
        exit();
    }
?>