<?php
    include '../Conexion.php';
    include '../config.php';
    include '../Data/classcustomers.php';
    include '../Data/classthirds.php';
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
    $conn = conectar($bd);

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $numiden = $_GET['NumIdentification']; // Se obtiene el número de identificación para la consulta 
        $type = $_GET['FKIdTypeDoc']; // se obtiene el tipo de documento de identificación para la consulta
        $pass = $_GET['Password'];  

        

        $sentencia = $conn->prepare("SELECT a.*,c.IdGender,c.name FROM customers a
        inner join thirds b on a.NumIdentification = b.NumIdentification and a.FKIdTypeDoc = b.FKIdTypeDoc
        inner join gender c on c.IdGender = b.FKIdGender
        WHERE a.NumIdentification = :Numiden AND a.FKIdTypeDoc = :fkidtype;");
        $sentencia->bindParam(':Numiden',$numiden, PDO::PARAM_STR, 30);
        $sentencia->bindParam(':fkidtype',$type, PDO::PARAM_INT);
        $sentencia->execute();
        header("http/1.1 200 ok");
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        $sentencia = $sentencia->fetch();
        
        //Creamos instancia de la clase Customers para devolver respuesta al servicio.
        if ($sentencia){
            $customer = new Customers($sentencia['NumIdentification'],$sentencia['FirstNameCustomer'],$sentencia['SecondNameCustomer'],$sentencia['LastNameCustomer'],$sentencia['SecondLastNameCustomer'],
                                  $sentencia['Password'],$sentencia['MAIL'],$sentencia['Address'],$sentencia['AddressEntry'],$sentencia['NumberPhone'],$sentencia['FKIdTypeDoc'],$sentencia['FKIdUser'],
                                  $sentencia['Status'],$sentencia['UpdateTimestamp'],$sentencia['IdGender'],$sentencia['name']);
            
        }else{
            $customerFallo = new Customers('0','error','.','.','.','.','.','.','.','.',0,0,'.','.',0,'');
            $customerFallo->IdResponse = 1;
            $customerFallo->Response = "Usuario con Documento: {$numiden} No existe";
            echo json_encode($customerFallo);
            return;
        }
        if($pass <> "0"){
            $Password = $sentencia['Password'];
        if($Password === $pass){
            $customer->IdResponse = 0;
            $customer->Response = "Ok";
            echo json_encode($customer); 
        exit();
        }else{
            $customer->IdResponse = 1;
            $customer->Response = "Contraseña Incorrecta";
            echo json_encode($customer);
        }

        }else{
            $customer->IdResponse = 0;
            $customer->Response = "Ok";
            echo json_encode($customer); 
        }
        
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $ExisteTercero = false;
        $type = $_SERVER['CONTENT_TYPE'];

        if($type != 'application/json'){
            header("http/1.1 500 no es Json");
        }
        $content = trim(file_get_contents("php://input"));
        $datos = json_decode($content,true);
        $third = new Thirds($datos['NumIdentification'], $datos['FirstNameCustomer'], $datos['SecondNameCustomer'], 
        $datos['LastNameCustomer'], $datos['SecondLastNameCustomer'], $datos['FKIdGender'], $datos['FKIdTypeDoc'], $datos['FKIdUser'], $datos['Status'],
        $datos['UpdateTimestamp']);

        $sql = $conn->prepare("INSERT INTO Thirds(NumIdentification,FKIdTypeDoc,FirstNameThird,SecondNameThird,LastNameThird,SecondLastNameThird,FKIdGender,FKIdUser,Status,UpdateTimestamp) 
                                VALUES('$third->NumIdentification',$third->FKIdTypeDoc,'$third->FirstNameThird','$third->SecondNameThird','$third->LastNameThird','$third->SecondLastNameThird',$third->FKIdGender,$third->FKIdUser,'$third->Status','$third->UpdateTimestamp')");

        $consulta = $conn->prepare("SELECT *  FROM Thirds WHERE NumIdentification = :NumIdentification AND FKIdTypeDoc = :FKIdTypeDoc ;");
        $consulta->bindParam(':NumIdentification',$third->NumIdentification, PDO::PARAM_STR, 30);
        $consulta->bindParam(':FKIdTypeDoc',$third->FKIdTypeDoc, PDO::PARAM_INT);
        try{
            $consulta->execute();
        }catch(PDOException $e){
            $customerFallo = new Customers('0','error','.','.','.','.','.','.','.','.',0,0,'.','.',0,'');
            $customerFallo->IdResponse = 2;
            $customerFallo->Response = $e->getMessage();
            echo json_encode($customerFallo);
            return;
        }
        $consulta = $consulta->fetch();
        if($consulta){ $ExisteTercero = true; }
        if (!$ExisteTercero){
            try{
                $sql->execute();
            }catch(PDOException $e){
                $customerFallo = new Customers('0','error','.','.','.','.','.','.','.','.',0,0,'.','.',0,'');
                $customerFallo->IdResponse = 2;
                $customerFallo->Response = $e->getMessage();
                echo json_encode($customerFallo);
                return;
            }
        }
        
        $obj = new Customers($datos['NumIdentification'], $datos['FirstNameCustomer'], $datos['SecondNameCustomer'], 
        $datos['LastNameCustomer'], $datos['SecondLastNameCustomer'], $datos['Password'], $datos['Mail'], $datos['Address'],
        $datos['AddressEntry'], $datos['NumberPhone'], $datos['FKIdTypeDoc'], $datos['FKIdUser'], $datos['Status'],
        $datos['UpdateTimestamp'],0,"");
        $sentencia = $conn->prepare("INSERT INTO CUSTOMERS (NumIdentification, FirstNameCustomer, SecondNameCustomer,LastNameCustomer, SecondLastNameCustomer, Password, MAIL, Address, AddressEntry, NumberPhone, FKIdTypeDoc,FKIdUser, Status, UpdateTimestamp) VALUES ('$obj->NumIdentification','$obj->FirstNameCustomer', '$obj->SecondNameCustomer','$obj->LastNameCustomer', '$obj->SecondLastNameCustomer', '$obj->Password', '$obj->Mail', '$obj->Address','$obj->AddressEntry', '$obj->NumberPhone', $obj->FKIdTypeDoc, $obj->FKIdUser, '$obj->Status', '$obj->UpdateTimeStamp')");
        $consulta2 = $conn->prepare("SELECT * FROM  customers WHERE NumIdentification = :NumIdentification AND FKIdTypeDoc = :FKIdTypeDoc;");
        $consulta2->bindParam(':NumIdentification',$obj->NumIdentification,PDO::PARAM_STR,30);
        $consulta2->bindParam(':FKIdTypeDoc',$obj->FKIdTypeDoc,PDO::PARAM_INT);
        try{
            $consulta2->execute();
        }catch(PDOException $e){
            $customerFallo = new Customers('0','error','.','.','.','.','.','.','.','.',0,0,'.','.',0,'');
            $customerFallo->IdResponse = 2;
            $customerFallo->Response = $e->getMessage();
            echo json_encode($customerFallo);
            return;
        }
        
        $consulta2 = $consulta2->fetch();
        if($consulta2){
            $obj->IdResponse = 1;
            $obj->Response = "Usuario ya registrado";
            echo json_encode($obj);
            return;
        }
        try{
            echo json_encode($sentencia);
            $sentencia->execute();
        }catch(PDOException $e){
            $customerFallo = new Customers('0','error','.','.','.','.','.','.','.','.',0,0,'.','.',0,'');
            $customerFallo->IdResponse = 2;
            $customerFallo->Response = $e->getMessage();
            echo json_encode($customerFallo);
            return;
        }
        $obj->IdResponse = 0;
        $obj->Response = "Usuario creado correctamente";
        echo json_encode($obj);
        return;
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