<?php
    include "../../Conexion.php";
    include '../../config.php';
    include '../../Data/classwarehouse.php';
    function getParams($input){   
        $filterParams = [];
        foreach($input as $param => $value){
            //echo $param;
                if ($param !== "IdResponse" and $param !== "Response"){
                    $filterParams[] = "$param = :$param";
                }
        }
        return implode(", ", $filterParams);
    }

     //Asociar todos los parametros a un sql
    function bindAllValues($statement, $params){
        foreach($params as $param => $value){
            if ($param !== "IdResponse" and $param !== "Response"){
                $statement->bindValue(":$param", $value);
            }
        }                
        return $statement;        
    }
    class WarehouseDao extends Conexiondb{
        private $conexion;
        public function __construct(){
            $this->conexion = Conexiondb::conectar();
        }

        public function getWarehouse(){
            $sentencia = $this->conexion->prepare("SELECT * FROM WareHouse;");
            try{
                $sentencia->execute();
            }catch(PDOException $e){
                print json_encode($e->getMessage());
            }
        
            header("http/1.1 200 ok");
            $sentencia->setFetchMode(PDO::FETCH_ASSOC);
            $sentencia = $sentencia->fetchAll();

            return $sentencia;
        }

        public function postWarehouse($datos){
            $warehouse = new Warehouse(0,$datos['ReferenceWareHouse'], $datos['NameWareHouse'], $datos['FKIdUserMan'], $datos['StatusWareHouse'], $datos['FKIdUser'], $datos['Status'], $datos['UpdateTimestamp']);

            $autoincrement = $this->conexion->prepare("SELECT MAX(IdWareHouse) + 1 as ID FROM WareHouse");
            try{
                $autoincrement->execute();
            }catch(PDOException $e){
                $warehouseFallo = new Warehouse(0,'error','.','0','.','0','.','.','');
                $warehouseFallo->IdResponse = 2;
                $warehouseFallo->Response = $e->getMessage();
                return $warehouseFallo;
            }
            $autoincrement = $autoincrement->fetch();

            $newId = $autoincrement['ID'];
            $warehouse->IdWareHouse = $newId;
            $sql = $this->conexion->prepare("INSERT INTO WareHouse(IdWareHouse,ReferenceWareHouse,NameWareHouse,FKIdUserMan,StatusWareHouse,FKIdUser,Status,UpdateTimestamp) 
                                VALUES($warehouse->IdWareHouse,'$warehouse->ReferenceWareHouse','$warehouse->NameWareHouse',$warehouse->FKIdUserMan,$warehouse->StatusWareHouse,
                                $warehouse->FKIdUser,'$warehouse->Status','$warehouse->UpdateTimestamp')");

            try{
                $sql->execute();
                $warehouse->IdResponse = 0;
                $warehouse->Response = "Bodega creada correctamente";

                return $warehouse;
            }catch(PDOException $e){
                $warehouseFallo = new Warehouse(0,'error','.','0','.','0','.','.','');
                $warehouseFallo->IdResponse = 2;
                $warehouseFallo->Response = $e->getMessage();
                return $warehouseFallo;
            }
        }
        public function updateWarehouse($datos,$IdWareh,$data){
            $datos = getParams($datos);

            /*
                ACTUALIZAMOS TABLA BODEGA
            */
            $sql = "UPDATE WareHouse SET $datos WHERE IdWareHouse = :IdWareHouse;";
            $prepare = $this->conexion->prepare($sql);
            // ASIGNAMOS LOS PARAMETROS DE WHERE CON LA LLAVE PRIMARIA DE LA TABLA Y LOS DATOS ENVIADOS POR EL JSON
            
            $prepare->bindParam(':IdWareHouse',$IdWareh, PDO::PARAM_INT);
            $prepare = bindAllValues($prepare,$data);
            
            try{
                $prepare->execute();
            }catch(PDOException $e){
                $warehouse = new Warehouse($datos['IdWareHouse'],$datos['ReferenceWareHouse'], $datos['NameWareHouse'], $datos['FKIdUserMan'],
                                            $datos['StatusWareHouse'], $datos['FKIdUser'], $datos['Status'], $datos['UpdateTimestamp']);
                $warehouse->IdResponse = 2;
                $warehouse->Response = $e->getMessage();                      
                echo json_encode($warehouse);
                return $warehouse;
            }
            $warehouse = new Warehouse($data['IdWareHouse'],$data['ReferenceWareHouse'], $data['NameWareHouse'], $data['FKIdUserMan'],
                                            $data['StatusWareHouse'], $data['FKIdUser'], $data['Status'], $data['UpdateTimestamp']);
            $warehouse->IdResponse = 0;
            $warehouse->Response = "Datos actualizados correctamente";
            return $warehouse;
        }
        public function deleateWarehouse($datos){

        }
    }
?>