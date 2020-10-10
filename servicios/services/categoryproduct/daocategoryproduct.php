<?php
    include "../../Conexion.php";
    include '../../config.php';
    include '../../data/classcategoryproduct.php';
    function getParamsCategoryP($input){   
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
    function bindAllValuesCategoryP($statement, $params){
        foreach($params as $param => $value){
            if ($param !== "IdResponse" and $param !== "Response"){
                $statement->bindValue(":$param", $value);
            }
        }                
        return $statement;        
    }
    class CategoryProdDao extends Conexiondb{
        private $conexion;
        public function __construct(){
            $this->conexion = Conexiondb::conectar();
        }
        public function getCategoryProduct(){
            $sentencia = $this->conexion->prepare("SELECT * FROM CategoryProduct;");
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

        public function postCategoryProduct($datos){
            $categoryp = new categoryproduct(0,$datos['ReferenceType'], $datos['NameCategory'], $datos['FKIdUser'], $datos['Status'], $datos['UpdateTimestamp']);

            $autoincrement = $this->conexion->prepare("SELECT MAX(IdTypeProduct) + 1 as ID FROM CategoryProduct");
            try{
                $autoincrement->execute();
            }catch(PDOException $e){
                $categoryproductFallo = new categoryproduct(0,'error','.','0','.','.','');
                $categoryproductFallo->IdResponse = 2;
                $categoryproductFallo->Response = $e->getMessage();
                return $categoryproductFallo;
            }
            $autoincrement = $autoincrement->fetch();

            $newId = $autoincrement['ID'];
            $categoryp->IdTypeProduct = $newId;
            $sql = $this->conexion->prepare("INSERT INTO CategoryProduct(IdTypeProduct,ReferenceType,NameCategory,FKIdUser,Status,UpdateTimestamp) 
                                VALUES($categoryp->IdTypeProduct,'$categoryp->ReferenceType','$categoryp->NameCategory',$categoryp->FKIdUser,
                                '$categoryp->Status','$categoryp->UpdateTimestamp')");

            try{
                $sql->execute();
                $categoryp->IdResponse = 0;
                $categoryp->Response = "categoria creada correctamente";

                return $categoryp;
            }catch(PDOException $e){
                $categoryproductFallo = new categoryproduct(0,'error','.','0','.','.','');
                $categoryproductFallo->IdResponse = 2;
                $categoryproductFallo->Response = $e->getMessage();
                return $categoryproductFallo;
            }
        }
        public function updateCategoryProduct($datos,$IdTypeProd,$data){
            $datos = getParams($datos);

            /*
                ACTUALIZAMOS TABLA CATEGORIA PRODUCTO
            */
            $sql = "UPDATE CategoryProduct SET $datos WHERE IdTypeProduct = :IdTypeProduct;";
            $prepare = $this->conexion->prepare($sql);
            // ASIGNAMOS LOS PARAMETROS DE WHERE CON LA LLAVE PRIMARIA DE LA TABLA Y LOS DATOS ENVIADOS POR EL JSON
            
            $prepare->bindParam(':IdTypeProduct',$IdTypeProd, PDO::PARAM_INT);
            $prepare = bindAllValues($prepare,$data);
            
            try{
                $prepare->execute();
            }catch(PDOException $e){
                $categoryp = new categoryproduct($datos['IdTypeProduct'], $datos['ReferenceType'], $datos['NameCategory'], 
                                                    $datos['FKIdUser'], $datos['Status'], $datos['UpdateTimestamp']);
                $categoryp->IdResponse = 2;
                $categoryp->Response = $e->getMessage();                      
                //echo json_encode($categoryp);
                return $categoryp;
            }
            $categoryp = new categoryproduct($data['IdTypeProduct'], $data['ReferenceType'], $data['NameCategory'], 
                                                    $data['FKIdUser'], $data['Status'], $data['UpdateTimestamp'],0,"");
            $categoryp->IdResponse = 0;
            $categoryp->Response = "Datos actualizados correctamente";
            //echo json_encode($categoryp);
            return $categoryp;
        }
        public function deleateCategoryProduct($datos){

        }
    }
?>