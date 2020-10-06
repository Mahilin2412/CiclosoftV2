<?php
    include "../../Conexion.php";
    include '../../config.php';
    include '../../Data/classcustomers.php';
    include '../../Data/classthirds.php';
    class CustomerDao extends Conexiondb{
        private $conexion;
        public function __construct(){
            $this->conexion = Conexiondb::conectar();
        }

        public function getCustomerLogin($Iden,$type,$pass){
            $sentencia = $this->conexion->prepare("SELECT a.*,c.IdGender,c.name FROM customers a
            inner join thirds b on a.NumIdentification = b.NumIdentification and a.FKIdTypeDoc = b.FKIdTypeDoc
            inner join gender c on c.IdGender = b.FKIdGender
            WHERE a.NumIdentification = :Numiden AND a.FKIdTypeDoc = :fkidtype;");

            $sentencia->bindParam(':Numiden',$Iden, PDO::PARAM_STR, 30);
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
                //echo json_encode($customerFallo);
                return $customerFallo;
            }
            if($pass <> "0"){
                $Password = $sentencia['Password'];
                if($Password === $pass){
                    $customer->IdResponse = 0;
                    $customer->Response = "Ok";
                    return $customer;
                    //echo json_encode($customer); 
                    exit();
                }else{
                    $customer->IdResponse = 1;
                    $customer->Response = "Contraseña Incorrecta";
                    return $customer;
                    //echo json_encode($customer);
                }
            }else{
                $customer->IdResponse = 0;
                $customer->Response = "Ok";
                return $customer;
                //echo json_encode($customer); 
            }
        }

        public function PostCustomer($datos){
            $ExisteTercero = false;
            $third = new Thirds($datos['NumIdentification'], $datos['FirstNameCustomer'], $datos['SecondNameCustomer'], 
            $datos['LastNameCustomer'], $datos['SecondLastNameCustomer'], $datos['FKIdGender'], $datos['FKIdTypeDoc'], $datos['FKIdUser'], $datos['Status'],
            $datos['UpdateTimestamp']);

            $sql = $this->conexion->prepare("INSERT INTO Thirds(NumIdentification,FKIdTypeDoc,FirstNameThird,SecondNameThird,LastNameThird,SecondLastNameThird,FKIdGender,FKIdUser,Status,UpdateTimestamp) 
                                VALUES('$third->NumIdentification',$third->FKIdTypeDoc,'$third->FirstNameThird','$third->SecondNameThird','$third->LastNameThird','$third->SecondLastNameThird',$third->FKIdGender,$third->FKIdUser,'$third->Status','$third->UpdateTimestamp')");

            $consulta = $this->conexion->prepare("SELECT *  FROM Thirds WHERE NumIdentification = :NumIdentification AND FKIdTypeDoc = :FKIdTypeDoc ;");
            $consulta->bindParam(':NumIdentification',$third->NumIdentification, PDO::PARAM_STR, 30);
            $consulta->bindParam(':FKIdTypeDoc',$third->FKIdTypeDoc, PDO::PARAM_INT);
            try{
                $consulta->execute();
            }catch(PDOException $e){
                $customerFallo = new Customers('0','error','.','.','.','.','.','.','.','.',0,0,'.','.',0,'');
                $customerFallo->IdResponse = 2;
                $customerFallo->Response = $e->getMessage();
                //echo json_encode($customerFallo);
             return $customerFallo;
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
                    //echo json_encode($customerFallo);
                    return $customerFallo;
                }
            }
        
            $obj = new Customers($datos['NumIdentification'], $datos['FirstNameCustomer'], $datos['SecondNameCustomer'], 
            $datos['LastNameCustomer'], $datos['SecondLastNameCustomer'], $datos['Password'], $datos['Mail'], $datos['Address'],
            $datos['AddressEntry'], $datos['NumberPhone'], $datos['FKIdTypeDoc'], $datos['FKIdUser'], $datos['Status'],
            $datos['UpdateTimestamp'],0,"");
            $sentencia = $this->conexion->prepare("INSERT INTO CUSTOMERS (NumIdentification, FirstNameCustomer, SecondNameCustomer,LastNameCustomer, SecondLastNameCustomer, Password, MAIL, Address, AddressEntry, NumberPhone, FKIdTypeDoc,FKIdUser, Status, UpdateTimestamp) VALUES ('$obj->NumIdentification','$obj->FirstNameCustomer', '$obj->SecondNameCustomer','$obj->LastNameCustomer', '$obj->SecondLastNameCustomer', '$obj->Password', '$obj->Mail', '$obj->Address','$obj->AddressEntry', '$obj->NumberPhone', $obj->FKIdTypeDoc, $obj->FKIdUser, '$obj->Status', '$obj->UpdateTimeStamp')");
            $consulta2 = $this->conexion->prepare("SELECT * FROM  customers WHERE NumIdentification = :NumIdentification AND FKIdTypeDoc = :FKIdTypeDoc;");
            $consulta2->bindParam(':NumIdentification',$obj->NumIdentification,PDO::PARAM_STR,30);
            $consulta2->bindParam(':FKIdTypeDoc',$obj->FKIdTypeDoc,PDO::PARAM_INT);
            try{
                $consulta2->execute();
            }catch(PDOException $e){
                $customerFallo = new Customers('0','error','.','.','.','.','.','.','.','.',0,0,'.','.',0,'');
                $customerFallo->IdResponse = 2;
                $customerFallo->Response = $e->getMessage();
                //echo json_encode($customerFallo);
                return $customerFallo;
            }
        
            $consulta2 = $consulta2->fetch();
            if($consulta2){
                $obj->IdResponse = 1;
                $obj->Response = "Usuario ya registrado";
                //echo json_encode($obj);
                return $obj;
            }
            try{
                //echo json_encode($sentencia);
                $sentencia->execute();
            }catch(PDOException $e){
                $customerFallo = new Customers('0','error','.','.','.','.','.','.','.','.',0,0,'.','.',0,'');
                $customerFallo->IdResponse = 2;
                $customerFallo->Response = $e->getMessage();
                //echo json_encode($customerFallo);
                return $customerFallo;
            }
            $obj->IdResponse = 0;
            $obj->Response = "Usuario creado correctamente";
            //echo json_encode($obj);
            return $obj;
        }
    }
?>