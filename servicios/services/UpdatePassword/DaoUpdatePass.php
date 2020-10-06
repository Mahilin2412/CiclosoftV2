<?php
    include "../../Conexion.php";
    include '../../config.php';
    
    class UpdatePassDao extends Conexiondb{
        private $conexion;
        public function __construct(){
            $this->conexion = Conexiondb::conectar();
        }
        
        }
        public function UpdateProduct($datos){
            $datos = getParams($datos);

            /*
                ACTUALIZAMOS CONTRASEÑA
            */
            $sql = "UPDATE PRODUCTS SET $datos WHERE IdProduct = :IdProduct;";
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
        
        public function DeleteProduct($datos){
            $datos = getParams($datos);
            $sql = "DELETE PRODUCTS SET $datos WHERE IdProduct = :IdProduct;";
            $prepare = $this->conexion->prepare($sql);
        }
    }

    
?>