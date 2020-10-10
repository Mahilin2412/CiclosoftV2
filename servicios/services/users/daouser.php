<?php
    include "../../Conexion.php";
    include '../../config.php';
    include '../Data/classuser.php';
    class UserDao extends Conexiondb{
        private $conexion;
        public function __construct(){
            $this->conexion = Conexiondb::conectar();
        }

        public function getUserLogin($cduser,$pass){
            $sentencia = $this->conexion->prepare("SELECT * FROM users a
            WHERE a.CodeUser = :coduser ;");

            $sentencia->bindParam(':coduser',$cduser, PDO::PARAM_STR, 30);
            $sentencia->execute();
            header("http/1.1 200 ok");
            $sentencia->setFetchMode(PDO::FETCH_ASSOC);
            $sentencia = $sentencia->fetch();
        
            //Creamos instancia de la clase Users para devolver respuesta al servicio.
            if ($sentencia){
                $user = new User($sentencia['IdUser'],$sentencia['FirstName'],$sentencia['SecondName'],$sentencia['FirstLastName'],$sentencia['SecondLastName'],
                                 $sentencia['PerModProduct'],$sentencia['PerOrder'],$sentencia['PerInvoice'],$sentencia['PerEntry'],$sentencia['CodeUser'],
                                 $sentencia['Password'],$sentencia['RolUser'],$sentencia['StatusUser'],$sentencia['Status'],$sentencia['UpdateTimestamp']);
            
            }else{
                $userFallo = new User('0','error','.','.','.',0,0,0,0,'.','.','.',0,'.','.');
                $userFallo->IdResponse = 1;
                $userFallo->Response = "Usuario no existe";
                //echo json_encode($userFallo);
                return $userFallo;
            }
            $Password = $sentencia['Password'];
                if($Password === $pass){
                    $user->IdResponse = 0;
                    $user->Response = "Ok";
                    return $user;
                    //echo json_encode($user); 
                    exit();
                }else{
                    $user->IdResponse = 1;
                    $user->Response = "Contraseña Incorrecta";
                    return $user;
                    //echo json_encode($user);
                }
        }

        public function PostUser($datos){
            $obj = new User($datos['IdUser'], $datos['FirstName'], $datos['SecondName'], $datos['FirstLastName'], $datos['SecondLastName'], 
            $datos['PerModProduct'], $datos['PerOrder'], $datos['PerInvoice'], $datos['PerEntry'], $datos['CodeUser'], $datos['Password'], 
            $datos['RolUser'], $datos['StatusUser'], $datos['Status'], $datos['UpdateTimestamp'],0,"");
            $sentencia = $this->conexion->prepare("INSERT INTO users (IdUser, FirstName, SecondName,FirstLastName, SecondLastName, PerModProduct, PerOrder, 
            PerInvoice, PerEntry, CodeUser, Password, RolUser, StatusUser, Status, UpdateTimestamp) VALUES ('$obj->IdUser','$obj->FirstName', '$obj->SecondName',
            '$obj->FirstLastName', '$obj->SecondLastName', '$obj->PerModProduct', '$obj->PerOrder', '$obj->PerInvoice','$obj->PerEntry', '$obj->CodeUser', 
            $obj->Password, $obj->RolUser, '$obj->StatusUser', '$obj->Status', '$obj->UpdateTimeStamp')");
            $consulta2 = $this->conexion->prepare("SELECT * FROM  users WHERE CodeUser = :CodeUser AND Password = :Password;");
            $consulta2->bindParam(':CodeUser',$obj->NumIdentification,PDO::PARAM_STR,30);
            $consulta2->bindParam(':Password',$obj->FKIdTypeDoc,PDO::PARAM_INT);
            try{
                $consulta2->execute();
            }catch(PDOException $e){
                $userFallo = new User('0','error','.','.','.',0,0,0,0,'.','.','.',0,'.','.');
                $userFallo->IdResponse = 2;
                $userFallo->Response = $e->getMessage();
                //echo json_encode($userFallo);
                return $userFallo;
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
                $userFallo = new User('0','error','.','.','.',0,0,0,0,'.','.','.',0,'.','.');
                $userFallo->IdResponse = 2;
                $userFallo->Response = $e->getMessage();
                //echo json_encode($userFallo);
                return $userFallo;
            }
            $obj->IdResponse = 0;
            $obj->Response = "Usuario creado correctamente";
            //echo json_encode($obj);
            return $obj;
        }
    }
?>