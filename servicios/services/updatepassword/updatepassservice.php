<?php
    include "daoupdatepass.php";

    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        //Optenemos el tipo de contenido del llamado del servicio
        $type = $_SERVER['CONTENT_TYPE'];

        //Siempre debe ser de tipo aplicación Json, de lo contrario enviamos error 
        if($type != 'application/json'){
            header("http/1.1 500 no es Json");
        }
        //Optenemos el Json y luego lo dejamos en un Array asociativo con la funcion json_decode...
        //está recibe como parametros el Json y (trueo false) este ultimo es para que el array...
        //sea asociativo o no. 
        $content = trim(file_get_contents("php://input"));
        $datos = json_decode($content,true);

        $numiden = $datos['NumidenTification'];
        $typeDoc = $datos['FKIdTypeDoc'];
        $passold = $datos['Passwordold'];
        $passnew = $datos['Password'];

        /*
            CONSULTAMOS EL CLIENTE QUE SE LE CAMBIARA LA CONTRASEÑA
        */
        $temsql = $conn->prepare("SELECT password FROM customers WHERE NumIdentification = :NumIdentification and FKIdTypeDoc = :FKIdTypeDoc");
        $temsql->bindParam(':NumIdentification',$numiden,PDO::PARAM_STR,30);
        $temsql->bindParam(':FKIdTypeDoc',$typeDoc, PDO::PARAM_INT);
        try{
            $temsql->execute();
        }catch(PDOException $e){
            //Error
            $DatosRespues = array("Passwordold"=> "","Password"=> "","NumidenTification"=> "","FKIdTypeDoc"=> "","IdResponse"=> 1,"Response" => $e->getMessage());                     
            echo json_encode($DatosRespues);
            return;
        }
        $temsql->setFetchMode(PDO::FETCH_ASSOC);
        $temsql = $temsql->fetch();
        if(!$temsql){
            // Error
            $DatosRespues = array("Passwordold"=> "","Password"=> "","NumidenTification"=> "","FKIdTypeDoc"=> "","IdResponse"=> 1,"Response" => "Error, no se encontro el usuario");                     
            echo json_encode($DatosRespues);
            return;
        }
        if( $temsql['password'] !== $passold){
            // Error
            $DatosRespues = array("Passwordold"=> "","Password"=> "","NumidenTification"=> "","FKIdTypeDoc"=> "","IdResponse"=> 1,"Response" => "Error, la contraseña actual no coincide");                     
            echo json_encode($DatosRespues);
            return;
        }else{
            // todo bien todo bonito
            $sql = $conn->prepare("UPDATE customers SET password = :password WHERE NumIdentification = :NumIdentification and FKIdTypeDoc = :FKIdTypeDoc"); 
            $sql->bindParam(':NumIdentification',$numiden, PDO::PARAM_STR, 30);
            $sql->bindParam(':FKIdTypeDoc',$typeDoc, PDO::PARAM_INT);
            $sql->bindValue(':password',$passnew, PDO::PARAM_STR);
            try{
                $sql->execute();
            }catch(PDOException $e){                     
                // Error
                $DatosRespues = array("Passwordold"=> "","Password"=> "","NumidenTification"=> "","FKIdTypeDoc"=> "","IdResponse"=> 1,"Response" => $e->getMessage());                     
                echo json_encode($DatosRespues);
                return;
            }
            // OK
            $DatosRespues = array("Passwordold"=> "","Password"=> "","NumidenTification"=> "","FKIdTypeDoc"=> "","IdResponse"=> 0,"Response" => "Contraseña modificada correctamente, por favor iniciar sesión nuevamente");                     
            echo json_encode($DatosRespues);
            return;
        }
    }

?>