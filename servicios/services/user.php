<?php
    include 'Conexion.php';
    include 'config.php';
    include 'classuser.php';
    $conn = conectar($bd); 

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $prueba = $_GET['IdUser'];
        $sentencia = $conn->prepare("SELECT * FROM Users WHERE IdUser ='{$prueba}' ;");
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
        $obj = new User($datos['NumIdentification'], $datos['FirstNameCustomer'], $datos['SecondNameCustomer'], 
        $datos['FirstLastNameCustomer'], $datos['SecondLastNameCustomer'], $datos['Password'], $datos['MAIL'], $datos['Address'],
        $datos['AddressEntry'], $datos['NumberPhone'], $datos['FKIdTypeDoc'], $datos['FKIdUser'], $datos['Status'],
        $datos['UpdateTimeStamp']);
        $sentencia = $conn->prepare("INSERT INTO CUSTOMERS (NumIdentification, FirstNameCustomer, SecondNameCustomer,
        FirstLastNameCustomer, SecondLastNameCustomer, Password, MAIL, Address, AddressEntry, NumberPhone, FKIdTypeDoc,
        FKIdUser, Status, UpdateTimeStamp) VALUES ($obj->NumIdentification,'$obj->FirstNameCustomer', '$obj->SecondNameCustomer',
        '$obj->FirstLastNameCustomer', '$obj->SecondLastNameCustomer', '$obj->Password', '$obj->MAIL', '$obj->Address',
        '$obj->AddressEntry', $obj->NumberPhone, $obj->FKIdTypeDoc, $obj->FKIdUser, '$obj->Status', $obj->UpdateTimeStamp)");
    
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
        $obj = new jugador($datos['IDJugador'],$datos['Nombre'],$datos['Apellido'],$datos['Peso'],$datos['Estatura'],$datos['Posicion'],$datos['IDEquipo']);
        $sentencia = $conn->prepare("INSERT INTO JUGADOR (IDJugador,nombre,apellido,peso,estatura,posicion,IDEquipo) VALUES('$obj->id','$obj->name','$obj->lastName','$obj->weight','$obj->height','$obj->position','$obj->idTeam')");
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
        $obj = new jugador($datos['IDJugador'],$datos['Nombre'],$datos['Apellido'],$datos['Peso'],$datos['Estatura'],$datos['Posicion'],$datos['IDEquipo']);
        $sentencia = $conn->prepare("INSERT INTO JUGADOR (IDJugador,nombre,apellido,peso,estatura,posicion,IDEquipo) VALUES('$obj->id','$obj->name','$obj->lastName','$obj->weight','$obj->height','$obj->position','$obj->idTeam')");
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