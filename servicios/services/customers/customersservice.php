<?php
    include_once("daocustomer.php");
    function getParams($input,$Boolean){   
        $filterParams = [];
        foreach($input as $param => $value){
            //echo $param;
            if ($Boolean){
                if ($param !== "IdResponse" and $param !== "Response"  and $param !== "name"){
                    $filterParams[] = "$param = :$param";
                }
            }else{
                if ($param !== "FKIdGender" and $param !== "IdResponse" and $param !== "Response" and $param !== "name"){
                    $filterParams[] = "$param = :$param";    
                }
                
            }
        }
            
            
       return implode(", ", $filterParams);
    }
        
   
     //Asociar todos los parametros a un sql
    function bindAllValues($statement, $params,$Boolean){
        foreach($params as $param => $value){
            if($Boolean){
                if ($param !== "IdResponse" and $param !== "Response" and $param !== "name"){
                    $statement->bindValue(":$param", $value);
                }
            }else{
            if ($param !== "FKIdGender" and $param !== "IdResponse" and $param !== "Response" and $param !== "name"){
                $statement->bindValue(":$param", $value);
            }
           }
                
               
        }
        return $statement;
    }
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $numiden = $_GET['NumIdentification']; // Se obtiene el número de identificación para la consulta 
        $type = $_GET['FKIdTypeDoc']; // se obtiene el tipo de documento de identificación para la consulta
        $pass = $_GET['Password'];
        
        $model = new CustomerDao();
        $json = $model->getCustomerLogin($numiden,$type,$pass);

        echo json_encode($json);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $ExisteTercero = false;
        $type = $_SERVER['CONTENT_TYPE'];

        if($type != 'application/json'){
            header("http/1.1 500 no es Json");
        }
        $content = trim(file_get_contents("php://input"));
        $datos = json_decode($content,true);

        $model = new CustomerDao();
        $json = $model->PostCustomer($datos);

        echo json_encode($json);
        
    }
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

        $datosThird = array(
            'NumIdentification' => $datos['NumIdentification'],
            'FKIdTypeDoc' => $datos['FKIdTypeDoc'],
            'FirstNameThird' => $datos['FirstNameCustomer'],
            'SecondNameThird' => $datos['SecondNameCustomer'],
            'LastNameThird' => $datos['LastNameCustomer'],
            'SecondLastNameThird' => $datos['SecondLastNameCustomer'],
            'FKIdGender' => $datos['FKIdGender'],
            'FKIdUser' => $datos['FKIdUser'],
            'Status' => $datos['Status'],
            'UpdateTimestamp' => $datos['UpdateTimestamp'],
        );
        $numiden = $datos['NumIdentification'];
        $typeDoc = $datos['FKIdTypeDoc'];

        $camposThirds = getParams($datosThird,true);
        $campos = getParams($datos,false);

        /*
            ACTUALIZAMOS INICIALMENTE LA TABLA DE Thirds
        */
        $sql = "UPDATE Thirds SET $camposThirds WHERE NumIdentification = :NumIdentification and FKIdTypeDoc = :FKIdTypeDoc";
        $prepareSql = $conn->prepare($sql);
        // ASIGNAMOS LOS PARAMETROS DE WHERE CON LA LLAVE PRIMARIA DE LA TABLA Y LOS DATOS ENVIADOS POR EL JSON
        $prepareSql->bindParam(':NumIdentification',$numiden, PDO::PARAM_STR, 30);
        $prepareSql->bindParam(':FKIdTypeDoc',$typeDoc, PDO::PARAM_INT);
        $prepareSql = bindAllValues($prepareSql,$datosThird,true);  
        try{
            $prepareSql->execute();
        }catch(PDOException $e){
            $customer = new Customers($datos['NumIdentification'],$datos['FirstNameCustomer'],$datos['SecondNameCustomer'],$datos['LastNameCustomer'],$datos['SecondLastNameCustomer'],
                                  $datos['Password'],$datos['Mail'],$datos['Address'],$datos['AddressEntry'],$datos['NumberPhone'],$datos['FKIdTypeDoc'],$datos['FKIdUser'],
                                  $datos['Status'],$datos['UpdateTimestamp'],0,"");
            $customer->IdResponse = 2;
            $customer->Response = $e->getMessage();                      
            echo json_encode($customer);
            return;
        }
        $sentencia = "UPDATE customers SET $campos WHERE NumIdentification = :NumIdentification and FKIdTypeDoc = :FKIdTypeDoc";
        $prepare = $conn->prepare($sentencia);
        $prepare->bindParam(':NumIdentification',$numiden, PDO::PARAM_STR, 30);
        $prepare->bindParam(':FKIdTypeDoc',$typeDoc, PDO::PARAM_INT);
        $prepare = bindAllValues($prepare,$datos,false);
        
        try{
            $prepare->execute();
        }catch(PDOException $e){
            $customer = new Customers($datos['NumIdentification'],$datos['FirstNameCustomer'],$datos['SecondNameCustomer'],$datos['LastNameCustomer'],$datos['SecondLastNameCustomer'],
                                  $datos['Password'],$datos['Mail'],$datos['Address'],$datos['AddressEntry'],$datos['NumberPhone'],$datos['FKIdTypeDoc'],$datos['FKIdUser'],
                                  $datos['Status'],$datos['UpdateTimestamp'],0,"");
            $customer->IdResponse = 2;
            $customer->Response = $e->getMessage();                      
            echo json_encode($customer);
            return;
        }
        $customer = new Customers($datos['NumIdentification'],$datos['FirstNameCustomer'],$datos['SecondNameCustomer'],$datos['LastNameCustomer'],$datos['SecondLastNameCustomer'],
                                  $datos['Password'],$datos['Mail'],$datos['Address'],$datos['AddressEntry'],$datos['NumberPhone'],$datos['FKIdTypeDoc'],$datos['FKIdUser'],
                                  $datos['Status'],$datos['UpdateTimestamp'],0,"");
        $customer->IdResponse = 0;
        $customer->Response = "Datos actualizados correctamente";
        echo json_encode($customer);
        exit();
    }
    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    }
?>