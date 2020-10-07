<?php 
    include '../Conexion.php';
    include '../config.php';

    $conn = conectar($bd);
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $numiden = $_GET['NumIdentification']; // Se obtiene el número de identificación para la consulta 
        $typeDoc = $_GET['FKIdTypeDoc']; // se obtiene el tipo de documento de identificación para la consulta

        $SQL = $conn->prepare("SELECT Mail FROM customers WHERE NumIdentification = :NumIdentification AND FKIdTypeDoc = :FKIdTypeDoc");
        $SQL->bindParam(':NumIdentification',$numiden,PDO::PARAM_STR,30);
        $SQL->bindParam(':FKIdTypeDoc',$typeDoc,PDO::PARAM_INT);
        try{
            $SQL->execute();
        }catch(PDOException $e){
            $customerFallo = new Customers('0','error','.','.','.','.','.','.','.','.',0,0,'.','.',0,'');
            $customerFallo->IdResponse = 2;
            $customerFallo->Response = $e->getMessage();
            echo json_encode($customerFallo);
            return;
        }
        $SQL->setFetchMode(PDO::FETCH_ASSOC);
        $SQL = $SQL->fetch(); // Se convierte en array asociativo con los nombres de las columnas de select ejecutado como indices del array
        $Email = $SQL['Mail']; // se asigna el correo del cliente.
        if(filter_var($Email, FILTER_VALIDATE_EMAIL)){
            $message = "Hola amiguitos :3";
            $success = mail($Email,$Email, $message);
            if (!$success) {
                $errorMessage = error_get_last()['message'];
                json_encode($errorMessage);
            }
            else{
                json_encode("Envio correo");
            }
        }else{
            echo json_encode("NO ES CORREO: {$Email}");
        }
    }
?>