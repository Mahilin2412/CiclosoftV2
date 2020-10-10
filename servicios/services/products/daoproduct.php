<?php
    include "../../Conexion.php";
    include '../../config.php';
    include '../../data/classproduct.php';
    function getParamsProducts($input){   
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
    function bindAllValuesProducts($statement, $params){
        foreach($params as $param => $value){
            if ($param !== "IdResponse" and $param !== "Response"){
                $statement->bindValue(":$param", $value);
            }
        }                
        return $statement;        
    }
    class ProductDao extends Conexiondb{
        private $conexion;
        public function __construct(){
            $this->conexion = Conexiondb::conectar();
        }
        public function getProduct(){
            $sentencia = $this->conexion->prepare("SELECT * FROM Products;");
            try{
                $sentencia->execute();
            }catch(PDOException $e){
                print json_encode($e->getMessage());
            }
        
            header("http/1.1 200 ok");
            $sentencia->setFetchMode(PDO::FETCH_ASSOC);
            $sentencia = $sentencia->fetchAll();
            //echo json_encode($sentencia);
            return $sentencia;
        }
        public function PostProduct($datos){

            $product = new Products(0, $datos['NameProduct'], $datos['Reference'], $datos['ManIva'], 
                                        $datos['PorIva'], $datos['Price'], $datos['StatusProduct'], $datos['Description'], 
                                        $datos['imageProduct'], $datos['Clasification'], $datos['FKIdTypeProduct'], $datos['FKIdUser'],
                                        $datos['Status'], $datos['UpdateTimestamp']);

            $autoincrement = $this->conexion->prepare("SELECT MAX(IdProduct) + 1 as ID FROM Products");
            try{
                $autoincrement->execute();
            }catch(PDOException $e){
                $productFallo = new Products('0','error','.',0,0,0,'.','.','.','.',0,0,'.',0,'');
                $productFallo->IdResponse = 2;
                $productFallo->Response = $e->getMessage();
                return $productFallo;
            }
            $autoincrement = $autoincrement->fetch();

            $newId = $autoincrement['ID'];
            $product->IdProduct = $newId;

            $sql = $this->conexion->prepare("INSERT INTO Products(IdProduct,NameProduct,Reference,ManIva,PorIva,Price,StatusProduct,Description,
                                            imageProduct,Clasification,FKIdTypeProduct,FKIdUser,Status,UpdateTimestamp) 
                                            VALUES($product->IdProduct,'$product->NameProduct','$product->Reference',
                                            $product->ManIva,$product->PorIva,$product->Price,$product->StatusProduct,
                                            '$product->Description','$product->imageProduct','$product->Clasification',$product->FKIdTypeProduct,
                                            $product->FKIdUser, '$product->Status', '$product->UpdateTimestamp')");

                try{
                    $sql->execute();
                    $product->IdResponse = 0;
                    $product->Response = "Producto creado correctamente";
                    return $product;
                }catch(PDOException $e){
                    $productFallo = new Products('0','error','.',0,0,0,'.','.','.','.',0,0,'.',0,'');
                    $productFallo->IdResponse = 2;
                    $productFallo->Response = $e->getMessage();
                    //echo json_encode($customerFallo);
                    return $productFallo;
                }
        }

        public function UpdateProduct($datos,$IdProd,$data){
            $datos = getParams($datos);

            /*
                ACTUALIZAMOS TABLA PRODUCTO
            */
            $sql = "UPDATE Products SET $datos WHERE IdProduct = :IdProduct;";
            $prepare = $this->conexion->prepare($sql);
            // ASIGNAMOS LOS PARAMETROS DE WHERE CON LA LLAVE PRIMARIA DE LA TABLA Y LOS DATOS ENVIADOS POR EL JSON
            
            $prepare->bindParam(':IdProduct',$IdProd, PDO::PARAM_INT);
            $prepare = bindAllValues($prepare,$data);
            
            try{
                $prepare->execute();
            }catch(PDOException $e){
                $product = new Products($datos['IdProduct'], $datos['NameProduct'], $datos['Reference'], $datos['ManIva'], 
                                        $datos['PorIva'], $datos['Price'], $datos['StatusProduct'], $datos['Description'], 
                                        $datos['imageProduct'], $datos['Clasification'], $datos['FKIdTypeProduct'], $datos['FKIdUser'],
                                        $datos['Status'], $datos['UpdateTimestamp']);
                $product->IdResponse = 2;
                $product->Response = $e->getMessage();                      

                return $product;
            }
                $product = new Products($data['IdProduct'], $data['NameProduct'], $data['Reference'], $data['ManIva'], 
                                        $data['PorIva'], $data['Price'], $data['StatusProduct'], $data['Description'], 
                                        $data['imageProduct'], $data['Clasification'], $data['FKIdTypeProduct'], $data['FKIdUser'],
                                        $data['Status'], $data['UpdateTimestamp']);
            $product->IdResponse = 0;
            $product->Response = "Datos actualizados correctamente";

            return $product;
        }
    }

    
?>